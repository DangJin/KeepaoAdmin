<?php
/**
 * Created by PhpStorm.
 * User: PengZong
 * Date: 18/1/5
 * Time: 上午11:55
 */

namespace app\wechat\controller;


use think\Controller;
use Hooklife\ThinkphpWechat\Wechat;

class Common extends Controller
{

    public function _initialize()
    {
        parent::_initialize();
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header(
            "Access-Control-Allow-Headers: Origin, X-Requested-With, access-token, refresh-token, Content-Type, Accept, csrf, authKey, sessionId"
        );
        header('Content-Type:text/html; charset=utf-8');
    }
}