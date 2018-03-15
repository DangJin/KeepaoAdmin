<?php

namespace app\wxpay\controller;

use think\Controller;
use think\Request;

class Order extends Common
{

    public function __construct(\think\Request $request = null)
    {
        parent::__construct($request);
    }

    public function orderUnify(Request $request)
    {
        $notice_url = $request->host().'/wxpay/notice';
        // 生成订单号
        $out_trade_no = date('Ymd').str_pad(
                mt_rand(1, 99999), 5, '0', STR_PAD_LEFT
            );
        $openid       = $request->param("openid");
        $total_fee    = $request->param("total_fee");
        $body         = $request->param("body");
        $data         = new Order(
            [
                'body'         => $body,
                'out_trade_no' => $out_trade_no,
                'total_fee'    => $total_fee,
                'notify_url'   => $notice_url,
                // 支付结果通知网址，如果不设置则会使用配置里的默认地址
                'trade_type'   => 'JSAPI',
                'openid'       => $openid,
            ]
        );

        return returnJson(200, 200, $data);
    }

    /**
     * @throws \EasyWeChat\Core\Exceptions\FaultException
     */
    public function notice()
    {
        $response = $this->payment->handleNotify(
            function ($notify, $successful) {
                $order_res = $this->payment->queryByTransactionId(
                    $notify['transaction_id']
                );
                if ($successful){

                }
            }
        );

        $response->send();
    }
}
