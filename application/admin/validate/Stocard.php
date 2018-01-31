<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/1/30
 * Time: 下午2:54
 */

namespace app\admin\validate;


use think\Validate;

class Stocard extends  Validate
{
    protected $rule = [
        'stoId'  =>  'require',
        'type' => 'require',
        'price' => 'require',
    ];

    protected $message = [
        'stoId.require'  =>  '店铺ID不能为空',
        'type.require'  =>  '类型不能为空',
        'price.require'  =>  '价格不能为空',
        'type.unique'  =>  '此类型的卡已存在',
    ];
}