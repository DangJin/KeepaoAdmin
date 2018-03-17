<?php
/**
 * Created by PhpStorm.
 * User: DangJin
 * Date: 2018-03-17
 * Time: 18:49
 */

namespace app\wechat\controller;


use think\Request;

class QrCode extends Common
{

    public function __construct(\think\Request $request = null)
    {
        parent::__construct($request);
    }

    public function createQrCode(Request $request)
    {
        $scene_id  = $request->param("scene_id");
        $file_path = __STATIC__.'code_scene_id_'.$scene_id.'.jpg';
        if (file_exists($file_path)) {
            return returnJson(200, 200, $file_path);
        } else {
            $qrcode  = $this->app->qrcode->forever($scene_id);
            $ticket  = $qrcode['ticket'];
            $url     = $this->app->qrcode->url($ticket);
            $content = file_get_contents($url);
            file_put_contents($file_path, $content);

            return returnJson(200, 200, $file_path);
        }
    }
}