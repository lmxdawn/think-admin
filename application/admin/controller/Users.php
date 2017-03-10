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
 * 用户组管理
 * Class User
 * @package app\index\controller
 */
class Users extends Base {

    /**
     *列表
     */
    public function index(){

        $where = [];

        $id = $this->request->param('id/d');
        if (!empty($id)){
            $where['id'] = $id;
        }

        $whereOr = [];
        $kwd = $this->request->param('kwd');
        if (!empty($kwd)){
            $whereOr['user_name'] = "%{$kwd}%";
            $whereOr['user_nicename'] = "%{$kwd}%";
            $whereOr['user_email'] = "%{$kwd}%";
        }

        $fields = ['id','user_name','user_nicename','user_email','avatar','create_time','last_login_time','last_login_ip','user_status'];
        $order = ['id'  =>  'DESC'];
        $lists = \app\common\model\Users::where($where)
            ->whereOr($whereOr)
            ->field($fields)
            ->order($order)
            ->paginate(15);

        return $this->view->fetch('index',[
            'title' =>  '用户列表',
            'lists' =>  $lists,
            'id'    =>  $id,
            'kwd'   =>  $kwd,
        ]);

    }



}
