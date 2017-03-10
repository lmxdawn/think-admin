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


use app\common\model\Menu;

/**
 * Class Index 后台模块首页
 * @package app\admin\controller
 */
class Index extends Base
{

    /**
     * 首页
     */
    public function index(){

        //菜单列表
        $where = [];
        $where['status'] = 1;
        $menu_lists =  Menu::getMergeNode($where);

        //快捷菜单
        $quick_menu = [
            ['id' => '1','title' => '网站首页','url' => '','icon' => 'fa-user','type' => 'layui-btn-danger']
        ];


        return $this->view->fetch('index',[
            'title'     =>      '首页',
            'menu_lists' => $menu_lists,
            'quick_menu' => $quick_menu,
        ]);
    }
}