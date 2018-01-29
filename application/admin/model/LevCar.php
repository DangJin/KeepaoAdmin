<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/1/29
 * Time: 上午11:10
 */

namespace app\admin\model;


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
//        try {
//            if (isset($data['lowest']) && !empty($data['lowest'])) {
//                $data['lowest'] = $data['lowest'] * 100;
//            }
//        } catch (ErrorException $e) {
//            return [
//                'value' => false,
//                'data' => [
//                    'message' => '每日最低价格类型错误',
//                ]
//            ];
//        }
        $levCar = new LevCar;
        $data['modifyUser'] = session('sId');
        $data['modifyType'] = 2;

        $result = $levCar->allowField(true)->isUpdate(true)->save($data);
        $flag = true;
        //dump($role);
        $msg = '更新成功';
        if (false == $result) {
            $flag = false;
            $msg = $levCar->getError();
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
        $stolevel = new Stolevel;
        if (isset($data['mcId']))
            $stolevel = $stolevel->where('mcId',$data['mcId']);//->where('type', $type)->order('state')->paginate($limit, false, ['page' => $page]);
        if (isset($data['levId']))
            $stolevel = $stolevel->where('levId',$data['levId']);
        $stolevel = $stolevel->paginate($limit, false, ['page' => $page]);
        $flag = false;
        $msg = '没有找到数据';
        if ($stolevel->count() > 0) {
            $flag = true;
            $msg = '查询成功';
        }
        return [
            'value' => $flag,
            'data' => [
                'message' => $msg,
                'data' => $stolevel
            ]
        ];
    }
}