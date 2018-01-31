<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/1/30
 * Time: 上午10:18
 */

namespace app\admin\controller;


use think\Request;

class Stocard extends Common
{
    private $stocard;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->stocard = new \app\admin\model\Stocard();
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
            return json($this->stocard->add($request->param()));
        }
    }

    public function delete(Request $request)
    {
        if ($request->has('del', 'param', true)) {
            return json($this->stocard->del($request->param('del')));
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
        return json($this->stocard->renew($request->param()));
    }

    public function select(Request $request)
    {
        $data = [];
        if ($request->has('name', 'param', true)) {

            $data['name'] = $request->param('name');
        }

        if ($request->has('id', 'param', true)) {
            $data['id'] = $request->param('id');
        }

        if ($request->has('stoId', 'param', true)) {
            $data['stoId'] = $request->param('stoId');
        }

        if ($request->has('page', 'param', true))
        {
            $page = $request->param('page');
            if ($request->has('limit', 'param', true))
            {
                return json($this->stocard->select($data, $page, $request->param('limit')));
            }
            return json($this->stocard->select( $data, $page));
        }
        return json($this->stocard->select($data));
    }
}