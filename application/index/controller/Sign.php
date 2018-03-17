<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/2/5
 * Time: 下午2:11
 */

namespace app\index\controller;


use think\Controller;
use think\Request;

class Sign extends Common
{
    protected $model;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->model = new \app\index\model\Sign();
    }

    public function sign(Request $request)
    {
        return json($this->model->add($request->param()));
    }
}