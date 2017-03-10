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

use app\common\model\Users;
use think\Config;
use think\Controller;
use think\Request;
use think\Session;
use think\Url;


/**
 * Class Login 账户模块
 * @package app\admin\controller
 */
class Accout extends Controller
{

    public function __construct(Request $request = null)
    {
        parent::__construct($request);

        $debug = Config::get('app_debug');

        if ($debug == true){
            //调试环境
            Config::set('sys_config.lmx_static_url','//www.shuangkai.com/static');
            Config::set('sys_config.lmx_static_debug',true);

        }else{
            //正式环境

        }

    }

    /**
     * 登录
     */
    public function login(){
        if ($this->request->isPost()){

            $data = $this->request->post();

            $result = $this->validate($data,'Users.login');
            if (true !== $result){
                //数据验证失败
                $this->error($result);
            }

            $where = [];
            $where['user_name'] = $data['user_name'];
            $whereOr['user_email'] = $data['user_name'];
            $user = Users::where($where)
                ->whereOr($whereOr)
                ->find();

            if (empty($user) || Users::getPass($data['user_pass']) != $user->user_pass){
                $this->error('用户名和密码不匹配');
            }

            if ($user->user_status != '正常' || $user->user_type != 1){
                $this->error('当前用户已被禁用或没权限，请联系管理员');
            }

            $admin_user = [];
            $admin_user['id'] = $user->id;
            $admin_user['user_name'] = $user->user_name;
            $admin_user['avatar'] = $user['avatar'];

            Session::set('admin_user',$admin_user);

            //更新用户信息
            Users::where(['id' => $user->id])->update([
                'last_login_time'   =>  time(),
                'last_login_ip'     =>  $this->request->ip()
            ]);

            $url = Url::build('index/index');

            $this->success('登录成功', $url);

        }else{
            return $this->view->fetch('login',[
                'title'     =>      '登录'
            ]);
        }


    }

    /**
     * 退出登录
     */
    public function logout(){
        Session::delete('admin_user');
        $this->success('退出成功', 'admin/accout/login');
    }

    public function  captcha(){
        $config = [
            'codeSet'   => '123456789',
            'length'    =>  3,
            'useCurve'  => false
        ];
        return captcha('',$config);
    }
}
