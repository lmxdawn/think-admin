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

use think\Model;
use think\Session;
use traits\model\SoftDelete;

/**
 * Class Member 用户信息表模型
 * @package app\index\model
 */
class Users extends Model
{

    use SoftDelete;
    protected $deleteTime = 'delete_time';//软删除


    // 数据完成时
    protected $auto = [];
    protected $insert = ['create_time'];
    protected $update = [];


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
     * 返回加密后的密码
     * @param $pwd
     * @return string
     */
    public static function getPass($pwd){
        return md5(md5($pwd));
    }

    /**
     * 获取登录用户的信息
     * @return mixed
     */
    public static function getAdmin(){
        return Session::get('admin_user');
    }

    /**
     * 获取器
     * @param $value
     * @return mixed
     */
    public function getUserStatusAttr($value)
    {
        $status = [0=>'禁用',1=>'正常',2=>'未验证'];
        return $status[$value];
    }

}
