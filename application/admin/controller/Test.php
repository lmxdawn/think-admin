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
 * Class Auth 测试控制器
 * @package app\index\controller
 */
class Test extends Base {

    /**
     *列表
     */
    public function index(){

        return $this->view->fetch('index',[
            'title' => '测试列表',
        ]);

    }


    /**
     * 添加
     * @return string
     */
    public function add(){

        if ($this->request->isPost()){

            if (empty($data)){
                $this->result([],40000,'数据不能为空','json');
            }

        }else{

            //添加页面

            return $this->view->fetch('add',[
                'title' => '添加菜单',
            ]);


        }

    }


}
