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
use app\common\model\Users;
use lmxdawn\auth\Auth;
use think\Config;
use think\Controller;
use think\Hook;
use think\Request;

/**
 * Class Base 基础控制器
 * @package app\admin\controller
 */
class Base extends Controller
{

    /**
     * 构架函数
     * Base constructor.
     */
    public function __construct(Request $request = null) {

        parent::__construct($request);

        $debug = Config::get('app_debug');

        if ($debug == true){
            //调试环境
            Config::set('sys_config.lmx_static_url','//www.shuangkai.com/static');
            Config::set('sys_config.lmx_static_debug',true);


        }else{
            //正式环境

        }

        //注册行为
        Hook::add('app_init','app\\admin\\behavior\\CheckAuth');
        //监听行为
        Hook::listen('app_init');

        //检查权限
        $module     = $this->request->module();
        $controller = $this->request->controller();
        $action     = $this->request->action();

        // 排除权限
        $not_check = ['admin/index/index', 'admin/main/index', 'admin/system/clear'];
        $not_menu = Menu::where(['type' => 0])
            ->field(['app','model','action'])
            ->select();
        foreach ($not_menu as $key=>$value){
            $not_check[] = strtolower($value->app.'/'.$value->model.'/'.$value->action);
        }

        $rule_name = $module . '/' . $controller . '/' . $action;
        if (!in_array(strtolower($rule_name), $not_check)) {
            $adminInfo = Users::getAdmin();
            if (!Auth::getInstance()->check($adminInfo['id'], $rule_name,'and') && $adminInfo['id'] != 2) {
                $this->error('没有权限');
            }
        }

    }


}