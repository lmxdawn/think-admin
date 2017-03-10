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

use app\common\model\Category as Categorymodel;
use think\Url;


/**
 * Class Auth 文章分类控制器
 * @package app\index\controller
 */
class Category extends Base {

    /**
     *菜单列表
     */
    public function index(){

        $where = [];

        $lists = Categorymodel::getTreeCategory($where);

        return $this->view->fetch('index',[
            'title' => '分类管理',
            'lists' => $lists,
        ]);

    }


    /**
     * 添加分类
     */
    public function add(){

        if ($this->request->isPost()){
            $data = $this->request->post();

            if (empty($data)){
                $this->error('数据不能为空');
            }

            $result = $this->validate($data,'Category');
            if (true !== $result){
                //数据验证失败
                $this->error($result);
            }

            $count = Categorymodel::where(['title' => $data['title']])
                ->count();
            if ($count > 0){
                $this->error('该分类已经存在');
            }

            // 菜单模型
            $Categorymodel = Categorymodel::getInstance();

            $result = $Categorymodel->save($data);

            if (empty($result)){
                $this->error('菜单添加失败');
            }

            $this->success('菜单添加成功',Url::build('index'));

        }else{

            //获取树形列表
            $lists = Categorymodel::getTreeCategory();

            $pid = $this->request->param('pid/d');

            return $this->view->fetch('add',[
                'title' => '添加分类',
                'pid' => $pid,
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
        // 分类信息
        $Cate = Categorymodel::where($where)
            ->field(
                ['id','pid','title','status','description','listorder']
            )
            ->find();

        if ($this->request->isPost()){
            $data = $this->request->post();
            if (empty($data)){
                $this->error('数据不能为空');
            }

            $result = $this->validate($data,'Category');
            if (true !== $result){
                //数据验证失败
                $this->error($result);
            }

            $wh['id'] = ['neq',$id];
            $wh['title'] = $data['title'];
            $count = Categorymodel::where($wh)
                ->count();
            if ($count > 0){
                $this->error('该分类已经存在');
            }

            if ($Cate->id == $data['pid']){
                $this->result([],-1,'不能把自身作为父级菜单','json');
            }
            $sub_menu = Categorymodel::where(['pid' => $id])->field(['id'])->select();
            foreach ($sub_menu as $value){
                if ($value['id'] == $data['pid']){
                    $this->error('不能把子级作为父级分类');
                }
            }


            $result = $Cate->isUpdate(true)->save($data);

            if (false == $result){
                $this->error('分类添加失败');
            }

            $this->success('分类更新成功');


        }else{

            //编辑页面
            if (empty($Cate)){
                $this->error('没有分类信息');
            }

            //获取树形列表
            $lists = Categorymodel::getTreeCategory();

            $pid = $Cate->pid;

            return $this->view->fetch('add',[
                'title' => '编辑分类',
                'lists' => $lists,
                'pid' => $pid,
                'Cate' => $Cate,
            ]);


        }
    }

    public function delete(){
        if ($this->request->isPost()){
            $id = $this->request->post('id/d');
            if (empty($id)){
                $this->error('参数错误！');
            }

            $sub_cate = Categorymodel::get(['pid' => $id]);
            if ($sub_cate){
                $this->error('此菜单下存在子菜单，不可删除！');
            }
            if (Categorymodel::destroy($id)){
                $this->success('删除成功！');
            }

        }

        $this->error('删除失败！');
    }

}
