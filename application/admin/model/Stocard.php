<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/1/30
 * Time: 上午10:17
 */

namespace app\admin\model;


use think\Db;
use think\Model;

class Stocard extends Model
{
    protected $pk = 'id';

    //设置自动插入生成时间
    protected $createTime = 'createTime';

    //设置自动插入修改时间
    protected $updateTime = 'modifyTime';

    protected $insert = ['state' => 1];

    public function add($data)
    {
        $data['createUser'] = session('sId');
        $data['modifyUser'] = session('sId');
        $data['createType'] = 2;
        $data['modifyType'] = 2;
        if (isset($data['type']) && isset($data['stoId']) && isset($data['price'])) {
            $count = $this->where('type', $data['type'])->where('stoId', $data['stoId'])->count();
            if ($count > 0) {
                return [
                    'value' => false,
                    'data' => [
                        'message' => '此类型已存在'
                    ]
                ];
            }
            $level = Db::table('store')->where('stoId',  $data['stoId'])->find();
            if (is_null($level)) {
                return [
                    'value' => false,
                    'data' => [
                        'message' => '店铺不存在'
                    ]
                ];
            }
            $count = Db::table('lev_car')
                ->where('levId', $level->getAttr('level'))
                ->where('mcId', isset($data['type']))
                ->where('lowest', '>', $data['price'])
                ->count();
            if ($count > 0) {
                return [
                    'value' => false,
                    'data' => [
                        'message' => '价格低于平台最低价格'
                    ]
                ];
            }
        }

        $stocard = new Stocard;
        $result = $stocard->allowField(true)->validate(true)->save($data);

        if (false == $result) {
            return [
                'value' => false,
                'data' => [
                    'message' => $stocard->getError()
                ]
            ];
        }

        return [
            'value' => true,
            'data' => [
                'message' => '添加成功',
                'data' => $stocard
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
        $this->where('id', 'in', $data)->update(['state' => 2]);
        return [
            'value' => true,
            'data' => [
                'message' => '删除成功'
            ]
        ];
    }

    public function renew($data)
    {
        if (!isset($data['id']) || empty($data['id'])) {
            return [
                'value' => false,
                'data' => [
                    'message' => '类型Id不能为空'
                ]
            ];
        }

        $stocard = new Stocard;
        $data['modifyUser'] = session('sId');
        $data['modifyType'] = 2;

        $result = $stocard->allowField(true)->isUpdate(true)->save($data);
        $flag = true;
        //dump($role);
        $msg = '更新成功';
        if (false == $result) {
            $flag = false;
            $msg = $stocard->getError();
        }
        //dump($msg);
        return [
            'value' => $flag,
            'data' => [
                'message' => $msg,
            ]
        ];
    }

    public function select($data, $page = 1, $limit = 10)
    {
        $stocard = new Stocard;
        if (isset($data['name']))
            $stocard = $stocard->where('name', 'like', '%'.$data['name'].'%');//->where('type', $type)->order('state')->paginate($limit, false, ['page' => $page]);
        if (isset($data['id']))
            $stocard = $stocard->where('id', $data['id']);
        if (isset($data['stoId']))
            $stocard = $stocard->where('stoId', $data['stoId']);
        $stocard = $stocard->paginate($limit, false, ['page' => $page]);
        $flag = false;
        $msg = '没有找到数据';
        if ($stocard->count() > 0) {
            $flag = true;
            $msg = '查询成功';
        }
        return [
            'value' => $flag,
            'data' => [
                'message' => $msg,
                'data' => $stocard
            ]
        ];
    }
}