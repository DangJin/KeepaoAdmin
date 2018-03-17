<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/2/3
 * Time: 下午9:07
 */

namespace app\index\validate;


use think\Validate;

class Follow extends Validate
{
    protected $rule = [
        'uid' => 'require',
        'createUser' => 'require',
    ];

    protected $message = [
        'uid.require' => '被关注不能为空',
        'createUser.require' => '关注人不能为空',
    ];

    protected $scene = [
        'message_add' => ['body'],
    ];
}