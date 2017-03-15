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
 * Class AuthGroup 文章模型验证器
 * @package app\index\validate
 */
class Ad extends Validate
{
    //当前验证的规则
    protected $rule = [
        'name'      =>      'require|max:255'
    ];

    //验证提示信息
    protected $message = [
        'name.require'      => '广告名称不能为空'
        ,'name.max'         => '广告名称不能超过255个字符'
    ];

    //验证场景 scene = ['edit'=>'name1,name2,...']
    protected $scene = [

    ];
}