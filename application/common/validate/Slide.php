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
 * Class AuthGroup 幻灯片模型验证器
 * @package app\index\validate
 */
class Slide extends Validate
{
    //当前验证的规则
    protected $rule = [
        'name'      =>      'require|max:255'
        ,'cid'      =>      'require'
    ];

    //验证提示信息
    protected $message = [
        'name.require'      => '幻灯片名称不能为空'
        ,'name.max'         => '幻灯片名称不能超过255个字符'
        ,'cid.require'      => '幻灯片分类不能为空'
    ];

    //验证场景 scene = ['edit'=>'name1,name2,...']
    protected $scene = [

    ];
}