<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/1/29
 * Time: 上午11:10
 */

namespace app\admin\model;


use think\Exception;
use think\Model;

class LevCar extends Model
{
    protected $pk = 'id';

    //设置自动插入生成时间
    protected $createTime = 'createTime';

    //设置自动插入修改时间
    protected $updateTime = 'modifyTime';

    public function add($data)
    {
        $data['createUser'] = session('sId');
        $data['modifyUser'] = session('sId');
        $data['createType'] = 2;
        $data['modifyType'] = 2;

        if (isset($data['levId'])) {
            $level = Stolevel::get($data['levId']);
            if (is_null($level)) {
                return [
                    'value' => false,
                    'data' => [
                        'message' => '没有此等级'
                    ]
                ];
            }
        }

        if (isset($data['levId'])) {
            $mem = Memcard::get([
                'memId' => $data['mcId'],
                'state' => 1
            ]);
            if (is_null($mem)) {
                return [
                    'value' => false,
                    'data' => [
                        'message' => '没有此类型'
                    ]
                ];
            }
        }

        $levCar = new LevCar;
        $result = $levCar->validate(true)->allowField(true)->save($data);

        if (false == $result) {
            return [
                'value' => false,
                'data' => [
                    'message' => $levCar->getError()
                ]
            ];
        }

        return [
            'value' => true,
            'data' => [
                'message' => '添加成功',
                'data' => $levCar
            ]
        ];
    }

    public function del($data)
    {
        if (empty($data)) {
            return [
                'value' => false,
                'data' => [
                    'message' => '删除参数不能为空'
                ]
            ];
        }

        Stolevel::destroy($data);
        return [
            'value' => true,
            'data' => [
                'message' => '删除成功'
            ]
        ];
    }

    public function renew($data, $host)
    {
        if (!isset($data['id']) || empty($data['id'])) {
            return [
                'value' => false,
                'data' => [
                    'message' => '类型Id不能为空'
                ]
            ];
        }

        if (!isset($data['levId']) || empty($data['levId'])) {
            return [
                'value' => false,
                'data' => [
                    'message' => '缺少等级ID'
                ]
            ];
        }
        $level = Stolevel::get([$data['levId']]);
        if (is_null($level)) {
            return [
                'value' => false,
                'data' => [
                    'message' => '门店等级不存在'
                ]
            ];
        }
        if (!isset($data['mcId']) || empty($data['mcId'])) {
            return [
                'value' => false,
                'data' => [
                    'message' => '缺少等级ID'
                ]
            ];
        }
        $memcard = Memcard::get($data['mcId']);
        if (is_null($memcard)) {
            return [
                'value' => false,
                'data' => [
                    'message' => '会员卡类型不存在'
                ]
            ];
        }

        $levCar = new LevCar;
        $data['modifyUser'] = session('sId');
        $data['modifyType'] = 2;

        $levCar->startTrans();
        try {
            $result = $levCar->allowField(['lowest'])->isUpdate(true)->save($data);
            if (false == $result) {
                return [
                    'value' => false,
                    'data' => [
                        'message' => '跟新失败'
                    ]
                ];
            }
            $price = substr_replace($data['lowest'], '.', -2, 0);
            $message = [
                'title' => '会员卡价格调整通知',
                'body' => '即日起所有'.$level->getAttr('name').'等级的门店,'.$memcard->getAttr('name').'最低价格调整为'.$price.'如果未及时替换系统将在3天后自动更新价格',
                'type' => 5,
                'state' => 1
            ];
            $levCar->table('message')->insert($message);
            system("echo 'curl http://".$host."/admin/behavior/changePrice/level/".$data['levId']."/type/".$data['mcId']."/price/".$data['lowest']."' | at now +3 days");
            $levCar->commit();
        } catch (Exception $e) {
            $levCar->rollback();
            return [
                'value' => false,
                'data' => [
                    'message' => $e->getMessage()
                ]
            ];
        }
        return [
            'value' => true,
            'data' => [
                'message' => '更新成功'
            ]
        ];
    }

    public function select($data, $page = 1, $limit = 10)
    {
        $levcar = new LevCar;
        $levcar = $levcar->alias('a');
        if (isset($data['mcId']))
            $levcar = $levcar->where('a.mcId',$data['mcId']);//->where('type', $type)->order('state')->paginate($limit, false, ['page' => $page]);
        if (isset($data['levId']))
            $levcar = $levcar->where('a.levId',$data['levId']);
        if (isset($data['id']))
            $levcar = $levcar->where('a.id',$data['id']);

        $levcar = $levcar
            ->join('stolevel s', 's.id=a.levId', 'LEFT')
            ->join('memcard m', 'm.memId=a.mcId', 'LEFT')
            ->field('a.*')->field('m.name mname')->field('s.name lname')
            ->paginate($limit, false, ['page' => $page]);
        $flag = false;
        $msg = '没有找到数据';
        if ($levcar->count() > 0) {
            $flag = true;
            $msg = '查询成功';
        }
        return [
            'value' => $flag,
            'data' => [
                'message' => $msg,
                'data' => $levcar
            ]
        ];
    }
}