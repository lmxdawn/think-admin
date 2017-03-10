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

namespace app\common\model;

use lmxdawn\tree\Tree;
use think\Model;
use lmxdawn\auth\Auth;

/**
 * Class AuthRule 菜单表模型
 * @package app\index\model
 */
class Menu extends Model
{

    // 数据完成时
    protected $auto = ['update_time'];
    protected $insert = ['create_time'];
    protected $update = [];


    /**
     * 设置更新时间字段
     */
    protected function setUpdateTimeAttr(){
        return time();
    }

    /**
     * 设置创建时间字段
     */
    protected function setCreateTimeAttr(){
        return time();
    }

    /**
     * @var object 对象实例
     */
    protected static $instance;

    /**
     * 初始化
     * @param array $data 数据
     * @return object|static
     */
    public static function getInstance($data = []) {
        if (is_null(self::$instance)) {
            self::$instance = new self($data);
        }
        return self::$instance;
    }

    /**
     * 查询所有节点列表
     * @param array $where 查询条件
     * @return array 节点列表
     */
    public static function getMenuList($where = []){
        $lists = self::where($where)
            ->field(
                ['id','parent_id','parent_name','app','model','action','param','type','status','title','icon','listorder','create_time','update_time','is_update']
            )
            ->order(['listorder' => 'ASC','id' => 'ASC'])
            ->select();

        return $lists;
    }

    /**
     * 获取树形节点列表
     * @param array $where
     * @return array 格式化好的节点列表
     */
    public static function getTreeNode($where = []){
        //获取菜单列表
        $lists = self::getMenuList($where);

        //创建树节点模型
        $tree = Tree::build($lists,['parent' => 'parent_id'])->getRootFormat();

        return $tree;
    }


    /**
     * 获取树形节点列表 （多维数组）
     * @param array $where
     * @return array 格式化好的节点列表
     */
    public static function getMergeNode($where = []){



        //获取菜单列表
        $lists = self::getMenuList($where);

        $userInfo = Users::getAdmin();
        $temp = [];

        foreach ($lists as $key=>$value){
            $rule_name = $value->app.'/'.$value->model.'/'.$value->action;

            if ($value['type'] == 0 || $userInfo['id'] == 2 || Auth::getInstance()->check($userInfo['id'],$rule_name,'and')){
                $temp[$key] = $value;
                //$temp[$key]['name'] = $value['title'];
            }


        }

        //dump($temp);exit;


        //创建树节点模型
        $tree = Tree::getInstance(['parent' => 'parent_id'])->getMerge($temp);

        return $tree;
    }

}
