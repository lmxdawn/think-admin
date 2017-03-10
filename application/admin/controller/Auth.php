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
 * Class Auth Auth权限
 * @package app\index\controller
 */
class Auth{


    public function index(){

        $auth = \lmxdawn\auth\Auth::getInstance();
        $res = $auth->check(2,'index/auth/edit,show_button','and');
        dump($res);
    }


}
