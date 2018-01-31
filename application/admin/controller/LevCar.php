<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/1/29
 * Time: 上午11:10
 */

namespace app\admin\controller;


use think\Request;

class LevCar extends Common
{
    private $levCar;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->levCar = new \app\admin\model\LevCar();
    }

    public function add(Request $request)
    {
        if ($request->isPost()) {
//            if (!$request->has('csrf', 'header', true) || $request->header('csrf') != session('csrf')) {
//                return json([
//                    'value' => false,
//                    'data' => [
//                        'message' => '请不要重复提交数据',
//                    ]
//                ]);
//            }
//            session('csrf', md5($_SERVER['REQUEST_TIME_FLOAT']));
            return json($this->levCar->add($request->param()));
        }
    }

    public function delete(Request $request)
    {
        if ($request->has('del', 'param', true)) {
            return json($this->levCar->del($request->param('del')));
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
        return json($this->levCar->renew($request->param(),$request->host()));
    }

    public function select(Request $request)
    {
        $data = [];
        if ($request->has('mcId', 'param', true)) {

            $data['mcId'] = $request->param('mcId');
        }

        if ($request->has('levId', 'param', true)) {

            $data['levId'] = $request->param('levId');
        }

        if ($request->has('id', 'param', true)) {

            $data['id'] = $request->param('id');
        }

        if ($request->has('page', 'param', true))
        {
            $page = $request->param('page');
            if ($request->has('limit', 'param', true))
            {
                return json($this->levCar->select($data, $page, $request->param('limit')));
            }
            return json($this->levCar->select( $data, $page));
        }
        return json($this->levCar->select($data));
    }
}