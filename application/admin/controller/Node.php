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
use app\common\model\AuthRule;


/**
 * Class Auth 节点控制器
 * @package app\index\controller
 */
class Node extends Base {

    /**
     *菜单列表
     */
    public function index(){

        $where = [];

        $lists = Menu::getTreeNode($where);

        return $this->view->fetch('index',[
            'title' => '后台菜单',
            'lists' => $lists,
        ]);

    }


    /**
     * 添加菜单
     */
    public function add(){

        if ($this->request->isPost()){
//        if (1){
            $data = $this->request->post();

            if (empty($data)){
                $this->result([],40000,'数据不能为空','json');
            }

            $result = $this->validate($data,'Menu');
            if (true !== $result){
                //数据验证失败
                $this->result([],40001,$result,'json');
            }

            // 菜单模型
            $Menu = Menu::getInstance();

            $data['is_update'] = (!empty($data['is_update']) && $data['is_update'] == 'on') ? 1 : 0;
            $data['parent_id'] = !empty($data['parent_id']) ? $data['parent_id'] : 0;

            $result = $Menu->save($data);

            if (empty($result)){
                $this->result([],0,'菜单添加失败','json');
            }

            if (!empty($data['type']) && $data['type'] == 1){
                // 菜单需要验证
                $rule_name = $data['app'].'/'.$data["model"].'/'.$data['action'];
                $rule_where = [];
                $rule_where['name'] = $rule_name;
                $authRule = AuthRule::get($rule_where);
                if (empty($authRule)){
                    //如果没有规则就添加
                    $ruleDate = [
                        'name'     =>      $rule_name,
                        'title'    =>      !empty($data['title']) ? $data['title'] : '',
                    ];
                    $rule_res = AuthRule::getInstance()->save($ruleDate);

                    if (true != $rule_res){
                        $this->result([],0,'规则添加失败','json');
                    }

                }
            }
            $this->result($data,1,'菜单添加成功','json');

        }else{
            //添加页面

            //获取树形列表
            $lists = Menu::getTreeNode();

            $parent_id = $this->request->param('parent_id/d');

            return $this->view->fetch('add',[
                'title' => '添加菜单',
                'parent_id' => $parent_id,
                'lists' => $lists,
            ]);


        }

    }


    /**
     * 编辑菜单
     */
    public function edit(){

        $id = $this->request->param('id/d');
        $where['id'] = $id;
        // 菜单模型
        $Menu = Menu::where($where)
            ->field(
                ['id','parent_id','app','model','action','param','type','status','title','icon','listorder','remark','is_update']
            )
            ->find();

        if ($this->request->isPost()){
//        if (1){
            $data = $this->request->post();
            if (empty($data)){
                $this->result([],40000,'数据不能为空','json');
            }
            if (empty($Menu)){
                $this->result([],50002,'没有菜单信息','json');
            }

            $result = $this->validate($data,'Menu');
            if (true !== $result){
                //数据验证失败
                $this->result([],40001,$result);
            }

            $data['is_update'] = (!empty($data['is_update']) && $data['is_update'] == 'on') ? 1 : 0;
            $data['parent_id'] = !empty($data['parent_id']) ? $data['parent_id'] : 0;

            if ($Menu->id == $data['parent_id']){
                $this->result([],-1,'不能把自身作为父级菜单','json');
            }
            $sub_menu = Menu::where(['parent_id' => $id])->field(['id'])->select();
            foreach ($sub_menu as $value){
                if ($value['id'] == $data['parent_id']){
                    $this->result([],-1,'不能把子级作为父级菜单','json');
                }
            }


            $result = $Menu->isUpdate(true)->save($data);

            if (false == $result){
                $this->result([],-1,'菜单添加失败','json');
            }

            if (!empty($data['type']) && $data['type'] == 1){
                $rule_name = $data['app'].'/'.$data["model"].'/'.$data['action'];

                $rule_where = [];
                $rule_where['name'] = $Menu['app'].'/'.$Menu['model'].'/'.$Menu['action'];
                $authRule = AuthRule::get($rule_where);
                $ruleDate = [
                    'name'     =>      $rule_name,
                    'title'    =>      !empty($data['title']) ? $data['title'] : '',
                ];
                $result = $this->validate($ruleDate,'AuthRule');
                if (true !== $result){
                    //数据验证失败
                    $this->result([],40001,$result);
                }

                if ($authRule){
                    // 有则修改
                    $rule_res = $authRule->isUpdate(true)->save($ruleDate);
                }else{
                    //没有则增加
                    $rule_res = AuthRule::getInstance()->save($ruleDate);
                }


                if (false == $rule_res){
                    $this->result([],-1,'菜单添加成功，权限添加失败','json');
                }
            }

            $this->result($data,1,'菜单更新成功','json');


        }else{

            //编辑页面
            if (empty($Menu)){
                $this->error('没有菜单信息');
            }

            //获取树形列表
            $lists = Menu::getTreeNode();

            $parent_id = $Menu->parent_id;

            return $this->view->fetch('add',[
                'title' => '编辑菜单',
                'lists' => $lists,
                'parent_id' => $parent_id,
                'Menu' => $Menu,
            ]);


        }
    }

    public function delete(){
        if ($this->request->isPost()){
            $id = $this->request->post('id/d');
            if (empty($id)){
                $this->result([],-1,'参数错误！','json');
            }

            $sub_menu = Menu::get(['parent_id' => $id]);
            if ($sub_menu){
                $this->result([],-1,'此菜单下存在子菜单，不可删除！','json');
            }
            if (Menu::destroy($id)){
                $this->result([],1,'删除成功！','json');
            }

        }

        $this->result([],-1,'删除失败！','json');
    }

}
