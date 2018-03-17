<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/2/5
 * Time: 上午11:12
 */

namespace app\index\model;


use think\Db;
use think\Exception;
use think\Model;

class Sign extends Model
{
    protected $pk = 'id';

    protected $createTime = 'createTime';

    protected $updateTime = 'modifyTime';

    public function add($data)
    {
        if (empty($data['uId'])) {
            return [
                'code' => 400,
                'error' => '缺少uId'
            ];
        }
        if (!$this->findDay($data['uId'])) {
            $this->startTrans();
            try {
                $result = $this->validate(true)->allowField(true)->save($data);
                if (false === $result) {
                    return [
                        'code' => 400,
                        'error' => $this->getError()
                    ];
                }
                $result = $this->table('user')->where('uId', $data['uId'])->setInc('day');
                $this->commit();
            } catch (Exception $e) {
                $this->rollback();
                return [
                    'code' => 400,
                    'error' => $e->getMessage()
                ];
            }
            return [
                'code' => 200,
                'data' => '签到成功'
            ];
        }
        return [
            'code' => 400,
            'error' => '今天已经签到过啦～'
        ];
    }

    public function findDay($id, $day = 'd')
    {

        $result = $this->whereTime('createTime', $day)->where('uid', $id)->find();

        if (empty($result)) {
            return false;
        }
        return true;
    }
}