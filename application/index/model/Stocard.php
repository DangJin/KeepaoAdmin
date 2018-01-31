<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/1/31
 * Time: 下午4:43
 */

namespace app\index\model;


class Stocard extends Common
{
    public function getCard($data, $page = 1, $limit = 10) {
        $stocard = new Stocard;
        if (isset($data['stoId'])) {
            $stocard = $stocard->where('stoId', $data['stoId']);
        }

        if (isset($data['id'])) {
            $stocard = $stocard->where('id', $data['id']);
        }

        $stocard = $stocard
            ->alias('a')
            ->join('memcard m', 'a.type=m.memId', 'LEFT')
            ->where('a.state', 1)
            ->field('a.price,m.name,m.day,m.point,m.description,a.fprice')
            ->paginate($limit, false, ['page' => $page]);

        return [
            'code' => 200,
            'data' => $stocard
        ];
    }
}