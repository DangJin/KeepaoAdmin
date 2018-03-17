<?php
/**
 * Created by PhpStorm.
 * User: PengZong
 * Date: 18/1/8
 * Time: 上午2:34
 */

namespace app\wechat\controller;

use think\Log;

class Wx extends Common
{

    public function __construct(\think\Request $request = null)
    {
        parent::__construct($request);
    }

    /**
     * @throws \EasyWeChat\Core\Exceptions\InvalidArgumentException
     * @throws \EasyWeChat\Server\BadRequestException
     */
    public function serve()
    {
        $this->server->setMessageHandler(
            function ($message) {
                switch ($message->MsgType) {
                    case 'event':
                        return $this->eventHandle($message);
                        break;
                    case 'text':
                        return '文字消息';
                        break;
                    default:
                        return '收到其它消息';
                        break;
                }
            }
        );
        $response = $this->server->serve();
        $response->send();
    }


    public function eventHandle($message)
    {
        // 处理事件
        if ($message->Event == "SCAN" || $message->Event == "subscribe") {
            if ($message->EventKey) {
                // 处理
                $event_key = explode("_", $message->EventKey);
                if (count($event_key) >= 3) {
                    $action  = $event_key[1];
                    $lock_sn = $event_key[2];
                } else {
                    $action  = $event_key[0];
                    $lock_sn = $event_key[1];
                }
                if ($action == 56) {
                    $res = openLock(
                        'wmj_nCDopzTEiwv', 'ZcSmLUDRIFFvefLnrIZpSmMtrHEDvto',
                        $lock_sn
                    );

                    return "欢迎光临KP,".$lock_sn."门禁已解锁，请尽快进入！".$res['state_msg'];
                }
            }
        }
    }
}