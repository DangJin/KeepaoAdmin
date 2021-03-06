<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/1/11
 * Time: 上午12:41
 */

namespace app\admin\validate;


use think\Validate;

class Admin extends Validate
{
    protected $rule = [
        'account'  =>  'require',
        'password' =>  'require',
        'type' => 'require',
        'name' => 'require',
    ];

    protected $message = [
        'account.require'  =>  '帐户不能为空',
        'password.require' =>  '密码不能为空',
        'type.require' =>  '管理员类型不能为空',
        'name.require' =>  '名称不能为空',
    ];

}