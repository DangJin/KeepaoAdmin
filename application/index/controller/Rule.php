<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/2/4
 * Time: 下午4:46
 */

namespace app\index\controller;


use app\index\model\PointRuleDet;
use think\Controller;
use think\Request;

class Rule extends Common
{
    private $model;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->model = new PointRuleDet();
    }

    public function getsport(Request $request)
    {
        if ($request->has('id', 'param', true)){
            return json($this->model->getsport($request->param('id')));
        } else {
            return json([
                'code' => 400,
                'error' => '缺少id参数'
            ]);
        }
    }

    public function getchram(Request $request)
    {
        if ($request->has('id', 'param', true)){
            return json($this->model->getcharm($request->param('id')));
        } else {
            return json([
                'code' => 400,
                'error' => '缺少id参数'
            ]);
        }

    }

    public function getdetails(Request $request)
    {
        if ($request->has('id', 'param', true)) {
            return json($this->model->getdetails($request->param('id')));
        } else {
            return json([
                'code' => 400,
                'error' => '没有id'
            ]);
        }
    }

    public function level(Request $request)
    {
        return json($this->model->level($request->param()));
    }
}