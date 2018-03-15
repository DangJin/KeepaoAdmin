<?php
/**
 * Created by PhpStorm.
 * User: PengZong
 * Date: 18/1/8
 * Time: 上午11:50
 */

namespace app\wechat\controller;


use app\admin\model\Config;
use EasyWeChat\Foundation\Application;
use think\config\driver\Json;
use think\Request;

class Menu extends Common
{

    private $app;

    public function __construct(\think\Request $request = null)
    {
        parent::__construct($request);
        \think\Config::load("APP_PATH.'/wechat/config.php'");
        $conf      = \think\Config::get("wxconfig");
        $this->app = new Application($conf);
    }

    public function add_menu()
    {

        $menu    = $this->app->menu;
        $buttons = [
            [
                "type" => "scancode_waitmsg",
                "name" => "扫一扫",
                "key"  => "keepao_1",
            ],
            [
                "name"       => "KP",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "码上开跑",
                        "url"  => "http://kp.codwiki.cn/public/fore/storeList.html",
                    ],
                    [
                        "type" => "view",
                        "name" => "排行榜",
                        "url"  => "http://kp.codwiki.cn/public/fore/ranking.html",
                    ],
                    [
                        "type" => "view",
                        "name" => "KP官网",
                        "url"  => "http://www.keepao.com/",
                    ],
                ],
            ],
            [
                "name"       => "我",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "个人主页",
                        "url"  => "http://kp.codwiki.cn/public/fore/myMessage.html",
                    ],
                    [
                        "type" => "view",
                        "name" => "我的钱包",
                        "url"  => "http://kp.codwiki.cn/public/fore/myWallet.html",
                    ],
                    [
                        "type" => "view",
                        "name" => "我的消息",
                        "url"  => "http://kp.codwiki.cn/public/fore/systemNews.html",
                    ],
                ],
            ],
        ];

        $res = $menu->add($buttons);

        return returnJson(200, 200, $res);
    }

    //获取菜单列表
    public function menu_list()
    {
        //        $app  = new Application($conf);
        //
        $menu  = $this->app->menu;
        $menus = $menu->all();

        return $menus->toJson();
        //        return $menus;
    }

    //删除全部菜单
    public function del_menus()
    {
        $conf = config("wechat");
        $app  = new Application($conf);

        $menu = $app->menu;

        $menu->destroy();
    }

    //按照id删除菜单
    public function del_menu($id)
    {
        $conf = config("wechat");
        $app  = new Application($conf);

        $menu = $app->menu;

        $menu->destroy($id);
    }
}