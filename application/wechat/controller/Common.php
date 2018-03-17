<?php
/**
 * Created by PhpStorm.
 * User: PengZong
 * Date: 18/1/5
 * Time: 上午11:55
 */

namespace app\wechat\controller;


use EasyWeChat\Foundation\Application;
use think\Config;
use think\Controller;

class Common extends Controller
{

    protected $app;
    protected $server;

    public function __construct(\think\Request $request = null)
    {
        parent::__construct($request);
        Config::load(APP_PATH.'wechat/config.php');
        $options      = Config::get("wxconfig");
        $this->app    = new Application($options);
        $this->server = $this->app->server;
    }
}