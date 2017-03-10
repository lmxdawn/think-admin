<?php
/**
 * Created by PhpStorm.
 * User: lk
 * Date: 17/2/23
 * Time: 23:49
 */

namespace app\admin\behavior;



use think\Session;
use think\exception\HttpResponseException;
use think\Url;


/**
 * 检测是否有权限
 * Class CheckLogin
 * @package app\index\behavior
 */
class CheckAuth
{
    public function run(&$params) {
        //检查是否登录
        if (!Session::has('admin_user')) {

            $url = Url::build('admin/accout/login');
            $response = redirect($url);
            throw new HttpResponseException($response);
        }

    }
}