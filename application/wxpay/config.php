<?php
//配置文件
return [
    'wxconfig' => [
        // 必要配置
        'app_id'        => 'wx57d618b8d33729e0',
        'secret'        => '12ae9280e824131b08666a3b305e0ef9',
        'token'         => 'keepao',
        'response_type' => 'array',
        'log'           => [
            'level'      => 'debug',
            'permission' => 0777,
            'file'       => '/home/wwwroot/kp.codwiki.cn/runtime/log/easywechat/easywechat.log',
        ],
        'oauth'         => [
            'scopes'   => ['snsapi_userinfo'],
            'callback' => 'weixin/callback',
        ],

        'payment' => [
            'merchant_id' => '1499666862',
            'key' => '6kLeic5W2AiOrU7d1NtiEfQJ3xxjtvEW',   // API 密钥
            'cert_path' => '/home/wwwroot/kp.codwiki.cn/apiclient_cert.pem',
            // XXX: 绝对路径！！！！
            'key_path' => '/home/wwwroot/kp.codwiki.cn/apiclient_key.pem',
            // XXX: 绝对路径！！！！
            //        'notify_url' => '默认的订单回调地址',     // 你也可以在下单时单独设置来想覆盖它
        ]


    ],
];