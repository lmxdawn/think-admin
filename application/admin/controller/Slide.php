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

use app\common\model\Slide as Slidemodel;
use app\common\model\SlideCat;
use think\Url;


/**
 * Class Auth 幻灯片管理控制器
 * @package app\index\controller
 */
class Slide extends Base {

    /**
     *列表
     */
    public function index(){

        $where = [];

        $cid = $this->request->get('cid/d');
        if (!empty($cid)){
            $where['cid'] = $cid;
        }
        $query_data = ['cid' => $cid];
        $lists = Slidemodel::where($where)
            ->field(
                ['id','name','pic','url','des','status','listorder']
            )
            ->order('listorder ASC')
            ->paginate(15,false,['query' => $query_data]);

        //分类列表
        $cat_lists = SlideCat::where(['status' => 1])->field(['id','name'])->select();

        return $this->view->fetch('index',[
            'title' => '幻灯片管理',
            'lists' => $lists,
            'cat_lists' => $cat_lists,
            'cid' => $cid,
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

            $result = $this->validate($data,'Slide');
            if (true !== $result){
                //数据验证失败
                $this->error($result);
            }

            // 菜单模型
            $Slidemodel = Slidemodel::getInstance();

            $result = $Slidemodel->allowField(true)->save($data);

            if (empty($result)){
                $this->error('幻灯片添加失败');
            }

            $this->success('幻灯片添加成功',Url::build('index'));

        }else{

            //分类列表
            $lists = SlideCat::where(['status' => 1])->field(['id','name'])->select();

            return $this->view->fetch('add',[
                'title' => '添加幻灯片',
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
        $Slide = Slidemodel::where($where)
            ->field(
                ['id','cid','name','pic','url','des','content','status','listorder']
            )
            ->find();

        //编辑页面
        if (empty($Slide)){
            $this->error('没有幻灯片信息');
        }

        if ($this->request->isPost()){
            $data = $this->request->post();
            if (empty($data)){
                $this->error('数据不能为空');
            }
            $result = $this->validate($data,'Slide');
            if (true !== $result){
                //数据验证失败
                $this->error($result);
            }

            $result = $Slide->allowField(true)->isUpdate(true)->save($data);

            if (false == $result){
                $this->error('幻灯片更新失败');
            }

            $this->success('幻灯片更新成功');


        }else{

            //分类列表
            $lists = SlideCat::where(['status' => 1])->field(['id','name'])->select();

            return $this->view->fetch('add',[
                'title' => '编辑幻灯片',
                'lists' => $lists,
                'Slide' => $Slide,
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
            if (SlideCatmodel::destroy($id)){
                $this->success('删除成功！');
            }

        }

        $this->error('删除失败！');
    }

}
