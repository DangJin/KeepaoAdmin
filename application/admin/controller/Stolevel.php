<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/1/29
 * Time: 上午9:40
 */

namespace app\admin\controller;


use think\Request;

class Stolevel extends Common
{
    private $stolevel;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->stolevel = new \app\admin\model\Stolevel();
    }

    public function add(Request $request)
    {
        if ($request->isPost()) {
            if (!$request->has('csrf', 'header', true) || $request->header('csrf') != session('csrf')) {
                return json([
                    'value' => false,
                    'data' => [
                        'message' => '请不要重复提交数据',
                    ]
                ]);
            }
            session('csrf', md5($_SERVER['REQUEST_TIME_FLOAT']));
            return json($this->stolevel->add($request->param()));
        }
    }

    public function delete(Request $request)
    {
        if ($request->has('del', 'param', true)) {
            return json($this->stolevel->del($request->param('del')));
        } else {
            return json([
                'value' => false,
                'data' => [
                    'message' => '缺少删除参数'
                ]
            ]);
        }

    }

    public function update(Request $request)
    {
        return json($this->stolevel->renew($request->param()));
    }

    public function select(Request $request)
    {
        $data = [];
        if ($request->has('name', 'param', true)) {

            $data['name'] = $request->param('name');
        }

        if ($request->has('page', 'param', true))
        {
            $page = $request->param('page');
            if ($request->has('limit', 'param', true))
            {
                return json($this->stolevel->select($data, $page, $request->param('limit')));
            }
            return json($this->stolevel->select( $data, $page));
        }
        return json($this->stolevel->select($data));
    }

}