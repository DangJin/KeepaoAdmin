<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/2/5
 * Time: 上午11:15
 */

namespace app\index\validate;


use think\Validate;

class Sign extends Validate
{
    protected $rule = [
        'uId' => 'require',
    ];

    protected $message = [
        'uId.require' => '用户ID不能为空',
    ];
}