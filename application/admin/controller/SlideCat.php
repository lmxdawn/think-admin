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

use app\common\model\Slide;
use app\common\model\SlideCat as SlideCatmodel;
use think\Url;


/**
 * Class Auth 幻灯片分类管理控制器
 * @package app\index\controller
 */
class SlideCat extends Base {

    /**
     *列表
     */
    public function index(){

        $where = [];

        $lists = SlideCatmodel::where($where)
            ->field(
                ['id','name','idname','status']
            )
            ->paginate(15);

        return $this->view->fetch('index',[
            'title' => '幻灯片分类管理',
            'lists' => $lists,
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

            $result = $this->validate($data,'SlideCat');
            if (true !== $result){
                //数据验证失败
                $this->error($result);
            }

            // 菜单模型
            $SlideCatmodel = SlideCatmodel::getInstance();

            $result = $SlideCatmodel->allowField(true)->save($data);

            if (empty($result)){
                $this->error('分类添加失败');
            }

            $this->success('分类添加成功',Url::build('index'));

        }else{

            return $this->view->fetch('add',[
                'title' => '添加分类',
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
        $SlideCat = SlideCatmodel::where($where)
            ->field(
                ['id','name','idname','remark','status']
            )
            ->find();

        //编辑页面
        if (empty($SlideCat)){
            $this->error('没有分类信息');
        }

        if ($this->request->isPost()){
            $data = $this->request->post();
            if (empty($data)){
                $this->error('数据不能为空');
            }
            $result = $this->validate($data,'SlideCat');
            if (true !== $result){
                //数据验证失败
                $this->error($result);
            }

            $result = $SlideCat->allowField(true)->isUpdate(true)->save($data);

            if (false == $result){
                $this->error('分类更新失败');
            }

            $this->success('分类更新成功');


        }else{


            return $this->view->fetch('add',[
                'title' => '编辑文章',
                'SlideCat' => $SlideCat,
            ]);


        }
    }

    /**
     * 删除
     */
    public function delete(){
        if ($this->request->isPost()){
            $id = $this->request->post('id/d');
            if (empty($id)){
                $this->error('参数错误！');
            }

            $slide = Slide::where(['cid' => $id])->field(['id'])->find();
            if ($slide){
                $this->error('该分类下有幻灯片,请先删除幻灯片');
            }

            if (SlideCatmodel::destroy($id)){
                $this->success('删除成功！');
            }

        }

        $this->error('删除失败！');
    }

}
