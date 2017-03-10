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

/**
 * Class AuthGroup 配置表模型
 * @package app\index\model
 */
class Options extends Model
{

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
     * 获取配置
     * @param $name 配置名称
     * @return mixed
     */
    public static function get_value($name){
        $where['name'] = $name;
        $config = self::where($where)
            ->field(['value'])
            ->find();

        return unserialize($config['value']);
    }

    /**
     * 更新配置
     * @param $name 配置名称
     * @param $value 配置value
     * @return bool 是否更新成功
     */
    public static function up_value($name,$value){
        $where['name'] = $name;
        $data['value'] = serialize($value);

        if (self::where($where)->update($data) !== false){
            return true;
        }

        return false;


    }



}
