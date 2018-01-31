<?php
/**
 * Created by PhpStorm.
 * User: PengZong
 * Date: 18/1/15
 * Time: 上午11:57
 */

namespace app\index\model;


class Config extends Common{
    protected $ame = 'config';

    public function getProblem($data, $page = 1, $limit = 10) {
        $config = new Config;
        if (isset($data['id'])) {
            $config = $config->where('conId', $data['id'])->field('value');
        }
        if (isset($data['name'])) {
            $config = $config->where('name', 'like', '%'.$data['name'].'%')->field('value');
        }
        $config = $config->where('type', 2)
            ->where('state', 1)
            ->field('name,conId')
            ->paginate($limit, false, ['page' => $page]);
        return [
            'code' => '200',
            'data' => $config,
        ];
    }
}