<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/1/31
 * Time: 下午3:15
 */

namespace app\index\controller;


use think\Request;

class Config extends Common
{
    public function getProblem(Request $request)
    {
        $config = new \app\index\model\Config();
        $data = [];
        if ($request->has('id', 'param', true)) {
            $data['id'] = $request->param('id');
        }
        if ($request->has('name', 'param', true)) {
            $data['name'] = $request->param('name');
        }
        $page = $request->has('page', 'param', true) ? $request->param('page') : 1;
        $limit = $request->has('limit', 'param', true) ? $request->param('page') : 10;

        return json($config->getProblem($data, $page, $limit));
    }
}