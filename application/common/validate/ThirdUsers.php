<?php
// +----------------------------------------------------------------------
// | ThinkPHP 5 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 .
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 黎明晓 <lmxdawn@gmail.com>
// +----------------------------------------------------------------------

namespace app\common\validate;


use think\Validate;


/**
 * Class AuthGroup 第三方用户模型验证器
 * @package app\index\validate
 */
class ThirdUsers extends Validate
{
    //当前验证的规则
    protected $rule = [
        'openid'      =>      'require|max:50'
    ];

    //验证提示信息
    protected $message = [
        'openid.require'      => 'openid不能为空'
        ,'openid.max'      => 'openid非法'

    ];

    //验证场景 scene = ['edit'=>'name1,name2,...']
    protected $scene = [
        'add' =>  'openid'
    ];
}