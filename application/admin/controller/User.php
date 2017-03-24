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
use think\Url;


/**
 * 用户个人信息
 * Class User
 * @package app\index\controller
 */
class User extends Base {


    /**
     * 编辑
     */
    public function edit(){

        $userInfo = Users::getAdmin();
        $user = Users::get($userInfo['id']);

        if ($this->request->isPost()){

            if ($userInfo['id'] == 2){
                $this->error('超级管理员不能操作!');
            }

            $data = $this->request->post();

            if (empty($data)){
                $this->error('数据不能为空');
            }
            $result = $this->validate($data,'Users.edit');
            if (true !== $result){
                //数据验证失败
                $this->error($result);
            }

            // 菜单模型
            $where = [];
            $where['user_name'] = $data['user_name'];
            $where['id'] = ['neq',$userInfo['id']];
            $count = Users::where($where)
                ->count();
            if ($count > 0){
                $this->error('该管理员已存在');
            }

            unset($data['user_pass']);

            $result = $user->isUpdate(true)->save($data);

            if (empty($result)){
                $this->error('未做任何修改');
            }
            $this->success('修改信息成功',Url::build('edit'));

        }else{

            return $this->view->fetch('edit',[
                'title' => '修改个人信息',
                'user'  => $user,
            ]);


        }

    }


    /**
     * 修改密码
     * @return string
     */
    public function pwd(){

        if ($this->request->isPost()){

            $userInfo = Users::getAdmin();
            $user = Users::get($userInfo['id']);

            if ($userInfo['id'] == 2){
                $this->error('超级管理员不能操作!');
            }

            $data = $this->request->post();

            if (empty($data)){
                $this->error('数据不能为空');
            }

            $new_pass = !empty($data['new_pass']) ? $data['new_pass'] : '';
            $ok_new_pass = !empty($data['ok_new_pass']) ? $data['ok_new_pass'] : '';
            if ($new_pass != $ok_new_pass){
                $this->error('两次密码必须一致');
            }

            if (empty($user)){
                $this->error('该用户未登录');
            }

            $user_pass = !empty($data['user_pass']) ? $data['user_pass'] : '';
            if ($user['user_pass'] != Users::getPass($user_pass)){
                $this->error('初始密码输入错误');
            }

            $result = $user->isUpdate(true)->save(['user_pass' => Users::getPass($ok_new_pass)]);

            if (empty($result)){
                $this->error('未做任何修改');
            }
            $this->success('修改密码成功',Url::build('pwd'));

        }else{

            return $this->view->fetch('pwd',[
                'title' => '修改密码',
            ]);


        }
    }

}
