<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/2/3
 * Time: 下午9:39
 */

namespace app\index\controller;


use think\Controller;
use think\Request;

class Follow extends Common
{
    public function follow(Request $request)
    {
        $data = [];
        if ($request->has('myid', 'param', true)) {
            $data['createUser'] = $request->param('myid');
        } else {
            return json([
                'code' => 400,
                'error' => '缺少myid',
            ]);
        }

        if ($request->has('gid', 'param', true)) {
            $data['uid'] = $request->param('gid');
        } else {
            return json([
                'code' => 400,
                'error' => '缺少gid',
            ]);
        }
//        $page = $request->has('page', 'param', true) ? $request->param('page') : 1;
//        $limit = $request->has('limit', 'param', true) ? $request->param('limit') : 10;

        $follow = new \app\index\model\Follow();
        return json($follow->follow($data));
    }

    public function select(Request $request)
    {
        $data = [];
        if (!$request->has('type', 'param', true)) {
            return json([
                'code' => 400,
                'error' => '缺少类型参数'
            ]);
        }

        if (!$request->has('id', 'param', true)) {
            return json([
                'code' => 400,
                'error' => '缺少id'
            ]);
        }

        $page = $request->has('page', 'param', true) ? $request->param('page') : 1;
        $limit = $request->has('limit', 'param', true) ? $request->param('limit') : 10;

        $follow = new \app\index\model\Follow();
        return json($follow->select($request->param('id'), $request->param('type'), $page, $limit));
    }

    public function unfollow(Request $request)
    {
        $flag = false;
        if (!$request->has('myid', 'param', true)) {
            $flag = true;
        }

        if (!$request->has('gid', 'param', true)) {
            $flag = true;
        }

        if ($flag) {
            return json([
                'code' => 400,
                'error' => '缺少类型参数'
            ]);
        }

        $follow = new \app\index\model\Follow();
        return json($follow->unfollow($request->param('myid'), $request->param('gid')));
    }


}
