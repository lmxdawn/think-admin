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

use app\common\model\AuthAccess;
use app\common\model\Menu;
use app\common\model\Role;
use app\common\model\RoleUser;
use think\Url;


/**
 * 管理组管理
 * Class User
 * @package app\index\controller
 */
class Rbac extends Base {

    /**
     *列表
     */
    public function index(){

        $where = [];

        $fields = ['id','name','status','remark'];
        $order = ['id'  =>  'ASC'];
        $lists = Role::where($where)
            ->field($fields)
            ->order($order)
            ->paginate(15);

        return $this->view->fetch('index',[
            'title' =>  '角色管理',
            'lists' =>  $lists,
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
            $result = $this->validate($data,'Role');
            if (true !== $result){
                //数据验证失败
                $this->error($result);
            }

            // 菜单模型
            $count = Role::where(['name' => $data['name']])
                    ->count();
            if ($count > 0){
                $this->error('该角色已存在');
            }

            $result = Role::getInstance()->save($data);

            if (empty($result)){
                $this->error('添加失败');
            }

            $this->success('角色添加成功',Url::build('index'));

        }else{

            return $this->view->fetch('add',[
                'title' => '添加角色',
            ]);


        }

    }

    /**
     * 编辑
     */
    public function edit(){

        $id = $this->request->param('id/d');
        $role = Role::get($id);

        if ($this->request->isPost()){
            $data = $this->request->post();

            if (empty($data)){
                $this->error('数据不能为空');
            }
            $result = $this->validate($data,'Role');
            if (true !== $result){
                //数据验证失败
                $this->error($result);
            }

            // 菜单模型
            $where = [];
            $where['name'] = $data['name'];
            $where['id'] = ['neq',$id];
            $count = Role::where($where)
                ->count();
            if ($count > 0){
                $this->error('该角色已存在');
            }

            $result = $role->isUpdate(true)->save($data);

            if (empty($result)){
                $this->error('未做任何修改');
            }

            $this->success('角色修改成功',Url::build('index'));

        }else{

            return $this->view->fetch('add',[
                'title' => '编辑角色',
                'role'  => $role,
            ]);


        }

    }

    /**
     * 角色授权
     * @return string
     */
    public function auth(){
        $id = $this->request->param('id/d');

        if ($this->request->isPost()){

            $rule_access = [];
            $res = $this->request->post();
            $data = $res['data'];
            foreach ($data as $key=>$v){
                $menu = Menu::get($v);
                $rule_name = $menu['app'].'/'.$menu['model'].'/'.$menu['action'];
                $rule_access[$key]['role_id'] = $id;
                $rule_access[$key]['rule_name'] = $rule_name;
                $rule_access[$key]['type'] = 'admin';
            }
            //先删除
            AuthAccess::where(['role_id' => $id])->delete();
            if (AuthAccess::getInstance()->saveAll($rule_access)){
                $this->success('授权成功');
            }

            $this->error('授权失败');

        }else{

            $rule_list = Menu::where(['type' => 1])
                ->field(['id','parent_id','app','model','action','title'])
                ->order(['listorder' => 'ASC','id' => 'ASC'])
                ->select();
            //获取登录用户的信息
            $auth_access = AuthAccess::where(['role_id' => $id])
                ->field(['rule_name'])
                ->select();

            $temp = [];
            foreach ($rule_list as $key=>$value){

                $temp[$key]['id'] = $value['id'];
                $temp[$key]['pId'] = $value['parent_id'];
                $temp[$key]['name'] = $value['title'];

                foreach ($auth_access as $k=>$v){
                    if (strtolower($value['app'].'/'.$value['model'].'/'.$value['action']) == strtolower($v['rule_name'])){
                        $temp[$key]['checked'] = 1;
                    }
                }
            }

            return $this->view->fetch('auth',[
                'title'     =>      '角色授权',
                'id'        =>      $id,
                'rule_list' => json_encode($temp),
            ]);
        }

    }


    /**
     * 删除角色
     */
    public function delete(){
        if ($this->request->isPost()){
            $id = $this->request->post('id/d');
            if (empty($id)){
                $this->error('参数错误!');
            }

            if (Role::destroy($id)){
                $this->success('删除成功！');
            }

        }

        $this->error('删除失败！');
    }

}
