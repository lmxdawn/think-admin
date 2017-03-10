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
 * Class AuthGroup 菜单模型验证器
 * @package app\index\validate
 */
class Menu extends Validate
{
    //当前验证的规则
    protected $rule = [
        'app'      =>      'require|max:20'
        ,'model'     =>      'require|max:20'
        ,'action'     =>      'require|max:20'
        ,'title'    =>      'require|max:50'
    ];

    //验证提示信息
    protected $message = [
        'app.require'      => '应用名称不能为空'
        ,'app.max'         => '应用名称长度不能超过20个字符'
        ,'model.require'      => '控制器名称不能为空'
        ,'model.max'         => '控制器名称长度不能超过20个字符'
        ,'action.require'      => '操作名称不能为空'
        ,'action.max'         => '操作名称长度不能超过20个字符'
        ,'title.require'      => '菜单名称不能为空'
        ,'title.max'         => '菜单名称长度不能超过50个字符'
    ];

    //验证场景 scene = ['edit'=>'name1,name2,...']
    protected $scene = [

    ];
}