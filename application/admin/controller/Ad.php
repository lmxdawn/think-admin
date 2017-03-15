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

namespace app\admin\controller;



/**
 * Class Auth 广告控制器
 * @package app\index\controller
 */
class Ad extends Base {

    /**
     * 广告位列表
     */
    public function index(){

        return $this->view->fetch('index',[
            'title' => '测试列表',
        ]);

    }




}
