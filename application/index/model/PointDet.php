<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/2/4
 * Time: 下午5:09
 */

namespace app\index\model;


use think\Model;

class PointDet extends Model
{
    public function getdetails($id, $page = 1, $limit = 10)
    {
        $result = $this->alias('a')
            ->where('a.createUser', $id)
            ->join('point_rule pr', 'a.type=pr.prId')
            ->field('a.*')->field('pr.name')
            ->paginate($limit, false, ['page' => $page]);
        $count = $this->table('sign')->whereTime('createTime', 'd')->where('uId', $id)->count();
        $change = $this->table('user')->where('uId', $id)->field('point')->select();
        return [
            'code' => 200,
            'data' => $result,
            'isSign' => $count,
            'point' => $change
        ];
    }
}