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
 * Class AuthGroup 用户模型验证器
 * @package app\index\validate
 */
class Users extends Validate
{
    //当前验证的规则
    protected $rule = [
        'user_name'      =>      'require|max:60'
        ,'user_pass'      =>      'require'
        ,'code'      =>      'require|captcha'
    ];

    //验证提示信息
    protected $message = [
        'user_name.require'      => '请输入用户名'
        ,'user_name.max'      => '用户名最多60个字符'
        ,'user_pass.require'      => '密码不能为空'
        ,'code.require'      => '验证码不能为空'
        ,'code.captcha'      => '验证码输入错误'

    ];

    //验证场景 scene = ['edit'=>'name1,name2,...']
    protected $scene = [
        'login' =>  'user_name,user_pass,code'
        ,'add' =>  'user_name,user_pass'
        ,'edit' =>  'user_name'
    ];
}