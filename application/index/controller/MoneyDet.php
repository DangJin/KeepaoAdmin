<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/2/5
 * Time: 上午10:55
 */

namespace app\index\controller;


use think\Request;

class MoneyDet extends Common
{
    public function getMoenydet(Request $request)
    {
        if (!$request->has('id', 'param', true)) {
            return json([
                'code' => 200,
                'error' => '缺少ID'
            ]);
        }
        $model = new \app\index\model\MoneyDet();
        $page = $request->has('page', 'param', true) ? $request->param('page') : 1;
        $limit = $request->has('limit', 'param', true) ? $request->param('limit') : 10;

        return json($model->select($request->param('id'), $page, $limit));
    }
}