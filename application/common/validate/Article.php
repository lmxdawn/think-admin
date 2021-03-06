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
class Article extends Validate
{
    //当前验证的规则
    protected $rule = [
        'title'      =>      'require|max:50'
        ,'content'      =>      'require|min:10'
    ];

    //验证提示信息
    protected $message = [
        'title.require'      => '文章标题不能为空'
        ,'title.max'         => '文章标题不能超过50个字符'
        ,'content.require'      => '文章内容不能为空'
        ,'content.min'         => '文章内容不能少于10个字符'
    ];

    //验证场景 scene = ['edit'=>'name1,name2,...']
    protected $scene = [

    ];
}