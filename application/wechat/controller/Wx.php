<?php
/**
 * Created by PhpStorm.
 * User: PengZong
 * Date: 18/1/8
 * Time: 上午2:34
 */

namespace app\wechat\controller;

use Hooklife\ThinkphpWechat\Wechat;
use EasyWeChat\Foundation\Application;
use think\Config;
use think\Session;

class Wx extends Common
{


    /**
     * @throws \EasyWeChat\Core\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Server\BadRequestException
     */
    public function serve()
    {
        $conf   = Config::get("wxconfig");
        $app    = new Application($conf);
        $server = $app->server;

        $server->setMessageHandler(
            function ($message) {
                return "您好！欢迎关注我!".$message;
            }
        );
        $server->serve()->send();
    }

    public function index()
    {
        dump(Session::get('wechat_user'));
        dump(Session::get('user_id'));
        Session::set('wechat_user',null);
    }
}