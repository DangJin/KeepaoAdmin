<?php
/**
 * Created by PhpStorm.
 * User: PengZong
 * Date: 18/1/5
 * Time: 上午11:53
 */

namespace app\wechat\controller;

use app\admin\model\User;
use EasyWeChat\Foundation\Application;
use think\Config;
use think\Db;
use think\Session;


class OAuth extends Common
{


    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    function oauth()
    {
        if (Session::get('wx_user')) {
            return returnJson(200, 200, Session::get('wx_user'));
        }
        Config::load(APP_PATH.'/wechat/config.php');
        $conf            = Config::get("wxconfig");
        $app             = new Application($conf);
        $oauth           = $app->oauth;
        $user            = $oauth->user();  //获取已授权的用户
        $uid             = $this->getUserId($user);
        $user_arr        = $user->toArray();
        $user_arr['uid'] = $uid;

        return returnJson(200, 200, $user_arr);
    }


    /**
     * @param \Overtrue\Socialite\User $user
     *
     * @return mixed|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getUserId(\Overtrue\Socialite\User $user)
    {
        $user_arr = $user->toArray();
        $openid   = $user->getId();
        if ( ! empty($openid)) {
            $_user = Db::table('user')->where('openid', $openid)->find();
            if ( ! empty($_user)) {
                //                session('user_id', $_user['uId']);
                return $_user['uId'];
            } else {
                $data = [
                    'openId'  => $openid,
                    'name'    => $user_arr['original']['nickname'],
                    'heading' => $user_arr['original']['headimgurl'],
                    'gender'  => $user_arr['original']['sex'],
                ];

                $res = Db::table('user')->insert($data);
                if ($res === 1) {
                    return Db::name('user')->getLastInsID();
                }
            }

        }
    }
}