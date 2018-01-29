<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/1/29
 * Time: 上午9:41
 */

namespace app\admin\validate;


use think\Validate;

class Stolevel extends Validate
{
    protected $rule = [
        'name'  =>  'require|unique:stolevel',
    ];

    protected $message = [
        'name.require'  =>  '等级不能为空',
        'name.unique'  =>  '此等级已创建',
    ];
}