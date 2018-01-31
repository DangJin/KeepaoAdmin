<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/1/31
 * Time: 下午6:31
 */

namespace app\index\model;


use think\Db;
use think\Model;

class UseSto extends Model
{
    public function getvip($uid, $page = 1, $limit = 10) {

        $vips = $this->where('uid', $uid)
            ->alias('a')
            ->order('validity desc')
            ->join('store s', 'a.stoId=s.stoId', 'LEFT')
            ->field('a.validity,s.stoname,s.thum')
            ->paginate($limit, false, ['page' => $page]);
        $result = [];
        foreach ($vips as $item) {
            $tmp = $item->getData();
            if (strtotime('now') - strtotime($tmp['validity']) > 0) {
                $tmp['state'] = 0;
            } else {
                $tmp['state'] = 1;
            }
            array_push($result, $tmp);
        }
        return [
            'code' => 200,
            'data' => $result
        ];
    }
}