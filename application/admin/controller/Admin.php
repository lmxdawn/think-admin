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

use app\common\model\Role;
use app\common\model\RoleUser;
use app\common\model\Users;
use think\Controller;
use think\Url;


/**
 * 管理组管理
 * Class User
 * @package app\index\controller
 */
class Admin extends Controller {

    /**
     *列表
     */
    public function index(){

        $where = [];
        $where['user_type'] = 1;
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
        $query_data = ['id' => $id,'kwd' => $kwd];
        $lists = Users::where($where)
            ->whereOr($whereOr)
            ->field($fields)
            ->order($order)
            ->paginate(15,false,['query' => $query_data]);

        return $this->view->fetch('index',[
            'title' =>  '用户列表',
            'lists' =>  $lists,
            'id'    =>  $id,
            'kwd'   =>  $kwd,
        ]);

    }

    /**
     * 添加
     */
    public function add(){

        if ($this->request->isPost()){
            $data = $this->request->post();

            if (empty($data)){
                $this->error('数据不能为空');
            }
            $result = $this->validate($data,'Users.add');
            if (true !== $result){
                //数据验证失败
                $this->error($result);
            }

            // 菜单模型
            $count = Users::where(['user_name' => $data['user_name']])
                    ->count();
            if ($count > 0){
                $this->error('该管理员已存在');
            }

            $data['user_pass'] = Users::getPass($data['user_pass']);
            $data['user_nicename'] = $data['user_name'];

            $role = (!empty($data['role_id']) && is_array($data['role_id'])) ? $data['role_id'] : [];
            unset($data['role_id']);

            $result = Users::getInstance()->save($data);

            if (empty($result)){
                $this->error('添加失败');
            }

            if ($role){
                $temp = [];
                $user = Users::getAdmin();
                foreach ($role as $key => $value){
                    $temp[$key]['role_id'] = $value;
                    $temp[$key]['user_id'] = $user['id'];
                }

                //添加用户的角色
                RoleUser::getInstance()->saveAll($temp);
            }


            $this->success('管理员添加成功',Url::build('index'));

        }else{

            $role_lists = Role::where(['status' => 1])
                ->field(['id','name'])
                ->select();

            return $this->view->fetch('add',[
                'title' => '添加管理员',
                'role_lists' => $role_lists,
            ]);


        }

    }

    /**
     * 编辑
     */
    public function edit(){

        $id = $this->request->param('id/d');

        if ($id == 2){
            $this->error('超级管理员不能操作!');
        }

        $user = Users::get($id);

        if ($this->request->isPost()){
            //        if (1){
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
            $where['id'] = ['neq',$id];
            $count = Users::where($where)
                ->count();
            if ($count > 0){
                $this->error('该管理员已存在');
            }

            if (empty($data['user_pass'])){
                unset($data['user_pass']);
            }else{
                $data['user_pass'] = Users::getPass($data['user_pass']);
            }

            $role = (!empty($data['role_id']) && is_array($data['role_id'])) ? $data['role_id'] : [];
            unset($data['role_id']);

            $data['last_login_time'] = time();
            $result = $user->isUpdate(true)->save($data);

            if (empty($result)){
                $this->error('未做任何修改');
            }

            //先删除
            RoleUser::where(['user_id' => $id])->delete();
            if ($role){
                $temp = [];
                foreach ($role as $key => $value){
                    $temp[$key]['role_id'] = $value;
                    $temp[$key]['user_id'] = $id;
                }

                //添加用户的角色
                RoleUser::getInstance()->saveAll($temp);
            }

            $this->success('管理员修改成功',Url::build('index'));

        }else{

            $role_lists = Role::where(['status' => 1])
                ->field(['id','name'])
                ->select();
            $role_user = RoleUser::where(['user_id' => $id])
                ->field('role_id')
                ->select();

            foreach ($role_lists as $key=>$value){
                foreach ($role_user as $k=>$v){
                    if ($v['role_id'] == $value['id']){
                        $role_lists[$key]['checked'] = 1;
                    }
                }
            }

            return $this->view->fetch('add',[
                'title' => '编辑管理员',
                'user'  => $user,
                'role_lists' => $role_lists,
            ]);


        }

    }


    public function delete(){
        if ($this->request->isPost()){
            $id = $this->request->post('id/d');
            if (empty($id)){
                $this->error('参数错误!');
            }
            if ($id == 2){
                $this->error('超级管理员不能操作!');
            }

            if (Users::destroy($id)){
                $this->success('删除成功！');
            }

        }

        $this->error('删除失败！');
    }

}
