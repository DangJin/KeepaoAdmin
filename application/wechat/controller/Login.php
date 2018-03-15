<?php
/**
 * Created by PhpStorm.
 * User: PengZong
 * Date: 17/12/14
 * Time: 上午2:00
 * 后台系统、第三方登录
 */

namespace app\wechat\controller;

use app\common\controller\Token;
use app\index\model\User;
use EasyWeChat\Foundation\Application;
use think\Config;
use think\Request;
use think\Session;

class Login extends Common
{


    public function wxLogin(Request $request)
    {
        Config::load(APP_PATH.'/wechat/config.php');
        $conf = Config::get("wxconfig");
        $app  = new Application($conf);

        $oauth = $app->oauth;
        if (empty(Session::get('wechat_user'))) {
            Session::set(
                'target_url', $request->param('target_url')
            );    //session请求地址
            $oauth->redirect()->send();
        } else {
            header(
                'location:'.$request->param('target_url').'?state=1'
            );
        }
    }

    public function index()
    {
        Config::load(APP_PATH.'/wechat/config.php');
        $conf = Config::get("wxconfig");
        //        $app  = new Application($conf);
        dump($conf);
    }

}