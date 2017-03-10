<?php
// +----------------------------------------------------------------------
// | ThinkPHP 5 [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 .
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Byron Sampson <lmxdawn@gmail.com>
// +----------------------------------------------------------------------
namespace lmxdawn\auth;


use think\Cache;
use think\Config;
use think\Db;
use think\Session;

/**
 * 权限认证类
 * 功能特性：
 * 1，是对规则进行认证，不是对节点进行认证。用户可以把节点当作规则名称实现对节点进行认证。
 *      $auth = \lmxdawn\auth\Auth::getInstance();  $auth->check('规则名称','用户id')
 * 2，可以同时对多条规则进行认证，并设置多条规则的关系（or或者and）
 *      $auth = \lmxdawn\auth\Auth::getInstance();  $auth->check('规则1,规则2','用户id','and')
 *      第三个参数为and时表示，用户需要同时具有规则1和规则2的权限。 当第三个参数为or时，表示用户值需要具备其中一个条件即可。默认为or
 * 3，一个用户可以属于多个用户组(lmx_auth_group_access表 定义了用户所属用户组)。我们需要设置每个用户组拥有哪些规则(lmx_auth_group 定义了用户组权限)
 *
 * 4，支持规则表达式。
 *      在lmx_auth_rule 表中定义一条规则时，[如果type为1]， condition字段就可以定义规则表达式。 如定义{score}>5  and {score}<100  表示用户的分数在5-100之间时这条规则才会通过。
 */
//数据库


class Auth {
    //默认配置
    protected $config = array(
        'auth_on' => true, // 权限开关
        'auth_cache' => false, //是否开启缓存
        'auth_key' => '_auth_', // 数据缓存的key
        'auth_rule' => 'auth_rule', // 权限规则表
        'auth_access' => 'auth_access', // 权限授权表
        'role' => 'role', // 角色表
        'role_user' => 'role_user', // 用户角色对应表
        'users' => 'users', // 用户信息表
        'users_auth_fields' => [],//用户需要验证的规则表达式字段 空代表所有用户字段
    );

    //权限规则数据
    protected $ruleData = [];

    // 用户拥有的角色数据
    protected $roleUser = [];

    //用户信息
    protected $userInfo = [];

    //对象实例
    protected static $instance;

    /**
     * 单列
     * @param array $options 参数
     * @return object|static 对象
     */
    public static function getInstance($options = []) {
        if (is_null(self::$instance)) {
            self::$instance = new static($options);
        }
        return self::$instance;
    }


    /**
     * 类架构函数 （私有构造函数，防止外界实例化对象）
     * @param array $options 参数
     * Auth constructor.
     */
    private function __construct($options = [])
    {
        //可设置配置项 auth, 此配置项为数组。
        if ($auth = Config::get('auth')) {
            $this->config = array_merge($this->config, $auth);
        }

        // 将传递过来的参数替换
        if (!empty($options) && is_array($options)){
            $this->config = array_merge($this->config, $options);
        }
    }

    /**
     * 私有克隆函数，防止外办克隆对象
     */
    private function __clone() {}

    /**
     * 检查权限
     * @param  int $uid 用户基本信息
     * @param array  $name 需要验证的规则列表,支持逗号分隔的权限规则或索引数组
     * @param string $relation 如果为 'or' 表示满足任一条规则即通过验证;如果为 'and'则表示需满足所有规则才能通过验证
     * @return bool 通过验证返回true;失败返回false
     */
    public function check($uid = 0, $name = [], $relation = 'or'){

        // 是否开启权限开关 (或者 用户id为 1  超级管理员)
        if (empty($this->config['auth_on']) || $uid == 1){
            return true;
        }

        if (empty($uid) || empty($name)){
            return false;
        }

        //获取用户对应角色
        $groups = $this->getRoleUser($uid);
        if (empty($groups)){
            return false;
        }

        //如果用户角色有超级管理员直接验证成功
        if (in_array(1,$groups)){
            return true;
        }

        if (is_string($name)) {
            $name = strtolower($name);
            if (strpos($name, ',') !== false) {
                $name = explode(',', $name);
            } else {
                $name = array($name);
            }
        }

        // 获取该用户 对应 该规则名的权限列表
        $rules = $this->getRuleData($uid);

        if (empty($rules)){
            return false;
        }

        //用户信息
        $user = $this->getUserInfo($uid);

        foreach ($rules as $rule){
            if (!empty($rule['condition'])) { //根据condition进行验证

                $command = preg_replace('/\{(\w*?)\}/', '$user[\'\\1\']', $rule['condition']);
                //dump($command);//debug
                @(eval('$condition=(' . $command . ');'));
                if ($condition) {
                    $list[] = strtolower($rule['name']);
                }
            }else{
                $list[] = strtolower($rule['name']);
            }
        }

        if ($relation == 'or' and !empty($list)) {
            return true;
        }
        $diff = array_diff($name, $list);
        if ($relation == 'and' and empty($diff)) {
            return true;
        }

        return false;
    }


    /**
     * 获取用户拥有权限的规则数据
     * @param $uid 用户id
     * @param $name 需要验证的规则名称
     * @return array
     */
    public function getRuleData($uid) {

        if (empty($this->ruleData) && !empty($uid)){

            $rule_data = $this->config['auth_cache'] ? Cache::get($this->getRuleKey($uid)) : [];


            if (empty($rule_data) || !is_array($rule_data)){

                $join = '__AUTH_RULE__ b';

                $where = [];
                $groups = $this->getRoleUser($uid);
                $where['a.role_id'] = ['in',$groups];

                $where['b.status'] = 1;

                $rule_data = Db::name('auth_access')->alias("a")
                    ->field('b.name,b.condition')
                    ->join($join,'a.rule_name = b.name')
                    ->where($where)
                    ->select();

                if (empty($rule_data)) return false;

                if ($this->config['auth_cache'])
                    Cache::set($this->getRuleKey($uid),$rule_data);

            }

            $this->ruleData = $rule_data;

        }

        return $this->ruleData;
    }

    /**
     * 获取
     * @return string
     */
    private function getRuleKey($uid){
        return $this->getKey('rule_data_list'.$uid);
    }


    /**
     * 获取用户拥有角色数据
     * @param $uid 用户id
     * @return array 拥有的角色数组
     */
    public function getRoleUser($uid) {

        if (empty($this->roleUser)){

            $role_user_data = $this->config['auth_cache'] ? Session::get($this->getRoleUserKey()) : [];

            if (empty($role_user_data) || !is_array($role_user_data)){

                $where = [];
                $where['user_id'] = $uid;
                $role_user_list = Db::name($this->config['role_user'])
                    ->field('role_id')
                    ->where($where)
                    ->select();

                $role_user_data = array_column($role_user_list,'role_id');

                //dump($role_user_data);

                if (empty($role_user_data)) return false;

                if ($this->config['auth_cache'])
                    Session::set($this->getRoleUserKey(),$role_user_data);
            }

            $this->roleUser = $role_user_data;

        }

        return $this->roleUser;
    }

    /**
     * 获取用户角色 session key
     * @return string
     */
    private function getRoleUserKey(){
        return $this->getKey('role_user_list');
    }



    /**
     * 获取用户信息
     * @return array
     */
    public function getUserInfo($uid) {

        $userinfo = [];

        if (empty($this->userInfo)){

            $userinfo = $this->config['auth_cache'] ? Session::get($this->getUserKey($uid)) : [];

            if (empty($userinfo) || !is_array($userinfo)){
                $user = Db::name($this->config['users']);
                // 获取用户表主键
                $_pk = is_string($user->getPk()) ? $user->getPk() : 'id';

                $userinfo = $user->field($this->config['users_auth_fields'])->where($_pk, $uid)->find();

                if ($this->config['auth_cache'])
                    Session::set($this->getUserKey($uid),$userinfo);
            }


            $this->userInfo = $userinfo;
        }

        return $this->userInfo;
    }

    /**
     * 获取用户信息的session key
     * @param $uid 用户id
     * @return string
     */
    private function getUserKey($uid){
        return $this->getKey('user_info'.$uid);
    }


    /**
     * 获取auth 的session key
     * @param $key 需要获取的key
     * @return string
     */
    private function getKey($key){
        return md5($this->config['auth_key'].$key);
    }



}