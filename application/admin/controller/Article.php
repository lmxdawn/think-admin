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

use app\common\model\Article as Articlemodel;
use app\common\model\Category;
use think\Url;


/**
 * Class Auth 文章管理控制器
 * @package app\index\controller
 */
class Article extends Base {

    /**
     *列表
     */
    public function index(){

        $where = [];

        $lists = Articlemodel::where($where)
            ->field(
                ['id','uid','pid','title','status','comment_count','hits','likes','create_time']
            )
            ->select();

        return $this->view->fetch('index',[
            'title' => '文章管理',
            'lists' => $lists,
        ]);

    }


    /**
     * 添加文章
     */
    public function add(){

        if ($this->request->isPost()){
            $data = $this->request->post();

            if (empty($data)){
                $this->error('数据不能为空');
            }

            $result = $this->validate($data,'Article');
            if (true !== $result){
                //数据验证失败
                $this->error($result);
            }


            // 菜单模型
            $Articlemodel = Articlemodel::getInstance();

            $data['smeta'] = json_encode($data['smeta']);

            $result = $Articlemodel->allowField(true)->save($data);

            if (empty($result)){
                $this->error('新闻添加失败');
            }

            $this->success('新闻添加成功',Url::build('index'));

        }else{

            //获取分类树形列表
            $lists = Category::getTreeCategory();

            $category_id = $this->request->param('category_id/d');

            return $this->view->fetch('add',[
                'title' => '添加新闻',
                'category_id' => $category_id,
                'lists' => $lists,
            ]);


        }

    }


    /**
     * 编辑
     */
    public function edit(){

        $id = $this->request->param('id/d');
        $where['id'] = $id;
        // 分类信息
        $Article = Articlemodel::where($where)
            ->field(
                ['id','category_id','title','keywords','source','u_date','content','excerpt','status','smeta','hits','istop','recommended']
            )
            ->find();

        if ($this->request->isPost()){
            $data = $this->request->post();
            if (empty($data)){
                $this->error('数据不能为空');
            }

            $result = $this->validate($data,'Article');
            if (true !== $result){
                //数据验证失败
                $this->error($result);
            }


            $result = $Article->isUpdate(true)->allowField(true)->save($data);

            if (false == $result){
                $this->error('新闻更新失败');
            }

            $this->success('新闻更新成功');


        }else{

            //编辑页面
            if (empty($Article)){
                $this->error('没有新闻信息');
            }

            $category_id = $Article->category_id;
            $Article->smeta = json_decode($Article->smeta,true);

            //获取分类树形列表
            $lists = Category::getTreeCategory();

            return $this->view->fetch('add',[
                'title' => '编辑分类',
                'lists' => $lists,
                'category_id' => $category_id,
                'Article' => $Article,
            ]);


        }
    }

    public function delete(){
        if ($this->request->isPost()){
            $id = $this->request->post('id/d');
            if (empty($id)){
                $this->error('参数错误！');
            }

            if (Articlemodel::destroy($id)){
                $this->success('删除成功！');
            }

        }

        $this->error('删除失败！');
    }

}
