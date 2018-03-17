<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/2/4
 * Time: 下午5:14
 */

namespace app\index\controller;



use think\Request;

class PointDet extends Common
{

    public function getdetails(Request $request)
    {
        if (!$request->has('id', 'param', true)) {
            return json([
                'code' => 400,
                'error' => '缺少ID'
            ]);
        }

        $page = $request->has('page', 'param', true) ? $request->param('page') : 1;
        $limit = $request->has('limit', 'param', true) ? $request->param('limit') : 10;
        $model = new \app\index\model\PointDet();
        return json($model->getdetails($request->param('id'), $page, $limit));
    }
}