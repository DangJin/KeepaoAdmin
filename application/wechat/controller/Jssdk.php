<?php

namespace app\wechat\controller;

use EasyWeChat\Foundation\Application;
use think\Config;
use think\Controller;
use think\Request;

class Jssdk extends Common
{

    public function getWxConfig(Request $request)
    {
        Config::load(APP_PATH.'/wechat/config.php');
        $conf      = Config::get("wxconfig");
        $app       = new Application($conf);
        $jsApiList = $request->param('jsApiList');
        $url       = $request->param('url');
        $debug     = $request->param('debug');
        if (empty($debug)) {
            $debug = 0;
        }
        if (empty($jsApiList) || empty($url)) {
            return returnJson(400, 400, 'jsApiList 不得为空 / NULL');
        }
        $app->js->setUrl($url);
        $config = $app->js->config(explode(",", $jsApiList),
            $debug);

        return returnJson(200, 200, json_decode($config));
    }
}
