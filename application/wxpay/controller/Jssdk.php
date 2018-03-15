<?php

namespace app\wxpay\controller;

use think\Controller;
use think\Request;

class Jssdk extends Common
{

    public function __construct(\think\Request $request = null)
    {
        parent::__construct($request);
    }

    /**
     * @return \think\response\Json
     */
    public function getJssdk(Request $request)
    {
        $prepayId = $request->param('prepayId');
        $jssdk    = $this->payment->configForJSSDKPayment($prepayId);

        return returnJson(200, 200, $jssdk);
    }
}
