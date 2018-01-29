<?php
/**
 * Created by PhpStorm.
 * User: wry
 * Date: 18/1/29
 * Time: 上午11:11
 */

namespace app\admin\validate;


use think\Validate;

class LevCar extends Validate
{
    protected $rule = [
        'mcId' => 'require',
        'levId' => 'require',
        'lowest' => 'require'
    ];

    protected $message = [
        'mcId.require'  =>  '会员卡类型不能为空',
        'levId.require' => '门店等级不能为空',
        'lowest.require' => '最低价格不能为空',
    ];
}