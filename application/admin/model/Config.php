<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/1/13
 * Time: 下午3:42
 */

namespace app\admin\model;


use think\Db;
use think\Model;

class Config extends Model
{
    protected $pk = 'conId';

    //设置自动插入生成时间
    protected $createTime = 'createTime';

    //设置自动插入修改时间
    protected $updateTime = 'modifyTime';

    //添加默认值
    protected $insert = ['state' => 1];


    /**
     * Function: getStateAttr
     * Description: tp5获取器根据数据库取出相应的字段的值 自动匹配对应字符串
     * Author  : wry
     * DateTime: 18/1/3 上午10:33
     *
     * @param $value 由tp5自动注入
     *
     * @return mixed 返回$status数组中对应value
     */
//    public function getStateAttr($value)
//    {
//        $status = [1 => '启用', 0 => '注销', null => '未知状态'];
//        return $status[$value];
//    }

    public function add($data)
    {
        $data['createUser'] = session('sId');
        $data['modifyUser'] = session('sId');
        $data['createType'] = 2;
        $data['modifyType'] = 2;
        $config = new Config;
        $result = $config->validate(true)->allowField(true)->save($data);

        if (false == $result) {
            return [
                'value' => false,
                'data' => [
                    'message' => $config->getError()
                ]
            ];
        }

        return [
            'value' => true,
            'data' => [
                'message' => '添加成功',
                'data' => $config
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
        //dump($data);
        $arr = explode(",", $data);
        $arr = array_unique($arr);
        $arr = array_filter($arr);
        Db::startTrans();
        try {
            foreach ($arr as $item) {
                $config = Config::get($item);
                if (!is_null($config)) {
                    if (!empty($config->getAttr('imgid'))) {
                        $img = Imgs::get($config->getAttr('imgid'));
                        if (!is_null($img)) {
                            unlink($img->getAttr('path'));
                            $img->delete();
                        }
                    }
                    $config->delete();
                }
            }
            Db::table('sto_con')->where('conId', 'in', $arr)->delete();
            Db::commit();
        }  catch (\Exception $e) {
            Db::rollback();
            return [
                'value' => false,
                'data' => [
                    'message' => '删除失败'
                ]
            ];
        }
        return [
            'value' => true,
            'data' => [
                'message' => '删除成功'
            ]
        ];
    }

    public function renew($data)
    {
        if (!isset($data['conId']) || empty($data['conId'])) {
            return [
                'value' => false,
                'data' => [
                    'message' => '配置Id不能为空'
                ]
            ];
        }

        $config = new Config;
        $data['modifyUser'] = session('sId');
        $data['modifyType'] = 2;

        $result = $config->allowField(true)->isUpdate(true)->save($data);
        $flag = true;
        //dump($role);
        $msg = '更新成功';
        if (false == $result) {
            $flag = false;
            $msg = $config->getError();
        }
        //dump($msg);
        return [
            'value' => $flag,
            'data' => [
                'message' => $msg,
            ]
        ];

     }

    public function select($type, $data, $page = 1, $limit = 10)
    {
        $config = new Config;
        if (isset($data['name']))
            $config = $config->where('name', 'like', '%'.$data['name'].'%');//->where('type', $type)->order('state')->paginate($limit, false, ['page' => $page]);
        $config = $config->where('type', $type)->paginate($limit, false, ['page' => $page]);
        $flag = false;
        $msg = '没有找到数据';
        if ($config->count() > 0) {
            $flag = true;
            $msg = '查询成功';
        }
        return [
            'value' => $flag,
            'data' => [
                'message' => $msg,
                'data' => $config
            ]
        ];
    }

}