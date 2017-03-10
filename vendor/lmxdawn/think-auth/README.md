

## 安装
> composer require lmxdawn/think-auth:dev-master

## 配置
### 公共配置
```
// auth配置
'auth'  => [
    'auth_on' => true, //  权限开关 是否
    'auth_cache' => false, //是否开启缓存
    'auth_key' => '_auth_', // 数据缓存的key
    'auth_rule' => 'auth_rule', // 权限规则表
    'auth_access' => 'auth_access', // 权限授权表
    'role' => 'role', // 角色表
    'role_user' => 'role_user', // 用户角色对应表
    'users' => 'users', // 用户信息表
    'users_auth_fields' => [],//用户需要验证的规则表达式字段 空代表所有用户字段
],
```

### 导入数据表
> `lmx_` 为自定义的数据表前缀

```
SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `lmx_auth_access`
-- ----------------------------
DROP TABLE IF EXISTS `lmx_auth_access`;
CREATE TABLE `lmx_auth_access` (
  `role_id` mediumint(8) unsigned NOT NULL COMMENT '角色',
  `rule_name` varchar(255) NOT NULL COMMENT '规则唯一英文标识,全小写',
  `type` varchar(30) DEFAULT NULL COMMENT '权限规则分类，请加应用前缀,如admin_',
  KEY `role_id` (`role_id`),
  KEY `rule_name` (`rule_name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='权限授权表';

-- ----------------------------
--  Table structure for `lmx_auth_rule`
-- ----------------------------
DROP TABLE IF EXISTS `lmx_auth_rule`;
CREATE TABLE `lmx_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则编号',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `title` char(20) DEFAULT '' COMMENT '规则中文名称',
  `type` tinyint(1) DEFAULT '1' COMMENT '规则类型',
  `status` tinyint(1) DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
  `condition` char(100) DEFAULT '' COMMENT '规则表达式，为空表示存在就验证，不为空表示按照条件验证',
  `listorder` int(10) DEFAULT '0' COMMENT '排序，优先级，越小优先级越高',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='规则表';

-- ----------------------------
--  Table structure for `lmx_menu`
-- ----------------------------
DROP TABLE IF EXISTS `lmx_menu`;
CREATE TABLE `lmx_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `parent_id` smallint(6) unsigned DEFAULT '0' COMMENT '父级ID',
  `app` char(20) DEFAULT NULL COMMENT '应用名称',
  `model` char(20) DEFAULT NULL COMMENT '控制器',
  `action` char(20) DEFAULT NULL COMMENT '操作名称',
  `param` char(50) DEFAULT NULL COMMENT 'url参数',
  `type` tinyint(1) DEFAULT '0' COMMENT '菜单类型  1：权限认证+菜单；0：只作为菜单',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT '状态，1显示，0不显示',
  `name` varchar(50) DEFAULT NULL COMMENT '菜单名称',
  `icon` varchar(50) DEFAULT NULL COMMENT '菜单图标',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `listorder` smallint(6) unsigned DEFAULT '0' COMMENT '排序，优先级，越小优先级越高',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  `nav_id` int(11) DEFAULT '0' COMMENT 'nav ID ',
  `request` varchar(255) DEFAULT NULL COMMENT '请求方式（日志生成）',
  `log_rule` varchar(255) DEFAULT NULL COMMENT '日志规则',
  PRIMARY KEY (`id`),
  KEY `status` (`status`) USING BTREE,
  KEY `model` (`model`) USING BTREE,
  KEY `parent_id` (`parent_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=utf8 COMMENT='后台菜单表';

-- ----------------------------
--  Table structure for `lmx_role`
-- ----------------------------
DROP TABLE IF EXISTS `lmx_role`;
CREATE TABLE `lmx_role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL COMMENT '角色名称',
  `pid` smallint(6) DEFAULT NULL COMMENT '父角色ID',
  `status` tinyint(1) unsigned DEFAULT NULL COMMENT '状态',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `create_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `listorder` int(3) NOT NULL DEFAULT '0' COMMENT '排序，优先级，越小优先级越高',
  PRIMARY KEY (`id`),
  KEY `parentId` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
--  Table structure for `lmx_role_user`
-- ----------------------------
DROP TABLE IF EXISTS `lmx_role_user`;
CREATE TABLE `lmx_role_user` (
  `role_id` int(11) unsigned DEFAULT '0' COMMENT '角色 id',
  `user_id` int(11) DEFAULT '0' COMMENT '用户id',
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户角色对应表';

-- ----------------------------
--  Table structure for `lmx_users`
-- ----------------------------
DROP TABLE IF EXISTS `lmx_users`;
CREATE TABLE `lmx_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '' COMMENT '用户名',
  `user_pass` varchar(64) NOT NULL DEFAULT '' COMMENT '登录密码；sp_password加密',
  `user_nicename` varchar(50) NOT NULL DEFAULT '' COMMENT '用户美名',
  `user_email` varchar(100) NOT NULL DEFAULT '' COMMENT '登录邮箱',
  `user_url` varchar(100) NOT NULL DEFAULT '' COMMENT '用户个人网站',
  `avatar` varchar(255) DEFAULT NULL COMMENT '用户头像，相对于upload/avatar目录',
  `sex` smallint(1) DEFAULT '0' COMMENT '性别；0：保密，1：男；2：女',
  `birthday` date DEFAULT '2000-01-01' COMMENT '生日',
  `signature` varchar(255) DEFAULT NULL COMMENT '个性签名',
  `last_login_ip` varchar(16) DEFAULT NULL COMMENT '最后登录ip',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `user_activation_key` varchar(60) NOT NULL DEFAULT '' COMMENT '激活码',
  `user_status` int(11) NOT NULL DEFAULT '1' COMMENT '用户状态 0：禁用； 1：正常 ；2：未验证',
  `score` int(11) NOT NULL DEFAULT '0' COMMENT '用户积分',
  `user_type` smallint(1) DEFAULT '1' COMMENT '用户类型，1:admin ;2:会员',
  `coin` int(11) NOT NULL DEFAULT '0' COMMENT '金币',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '手机号',
  PRIMARY KEY (`id`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户表';

SET FOREIGN_KEY_CHECKS = 1;
```

## 原理
Auth权限认证是按规则进行认证。
在数据库中我们有 

- 规则表（lmx_auth_rule） 
- 权限授权表（lmx_auth_access）
- 角色表(lmx_role) 
- 用户角色对应表（lmx_role_user）
- 菜单表（lmx_menu）
- 用户表（lmx_users）

在规则表中定义规则,角色表里面定角色,权限授权表里面对应角色拥有的权限(一个角色对应多个权限),在用户角色对应表里面定义用户有多少角色(多个)


## 使用
判断权限方法
```

// 获取auth实例
$auth = \lmxdawn\auth\Auth::getInstance();

// 检测权限
if($auth->check('规则1,规则2','用户id','and')){// 第一个参数是规则名称,第二个参数是用户UID,第三个参数为判断条件
	//有显示操作按钮的权限
}else{
	//没有显示操作按钮的权限
}
```

Auth类也可以对节点进行认证，我们只要将规则名称，定义为节点名称就行了。 
可以在公共控制器Base中定义_initialize方法
```
<?php
use think\Controller;
use think\auth\Auth;
class Base extends Controller
{
    public function _initialize()
	{
		$controller = request()->controller();
		$action = request()->action();
		$auth = \lmxdawn\auth\Auth::getInstance();
		if(!$auth->check($controller . '-' . $action, session('uid'))){
			$this->error('你没有权限访问');
		}
    }
 }
```
这时候我们可以在数据库中添加的节点规则， 格式为： “控制器名称-方法名称”

Auth 类 还可以多个规则一起认证 如： 
```
$auth->check('rule1,rule2',uid); 
```
表示 认证用户只要有rule1的权限或rule2的权限，只要有一个规则的权限，认证返回结果就为true 即认证通过。 默认多个权限的关系是 “or” 关系，也就是说多个权限中，只要有个权限通过则通过。 我们也可以定义为 “and” 关系
```
$auth->check('rule1,rule2',uid,'and'); 
```
第三个参数指定为"and" 表示多个规则以and关系进行认证， 这时候多个规则同时通过认证才有权限。只要一个规则没有权限则就会返回false。

Auth认证，一个用户可以属于多个用户组。 比如我们对 show_button这个规则进行认证， 用户A 同时属于 用户组1 和用户组2 两个用户组 ， 用户组1 没有show_button 规则权限， 但如果用户组2 有show_button 规则权限，则一样会权限认证通过。 
```
$auth->getRoleUser($uid)
```
通过上面代码，可以获得用户所属的所有用户组，方便我们在网站上面显示。

Auth类还可以按用户属性进行判断权限， 比如
按照用户积分进行判断， 假设我们的用户表 (lmx_members) 有字段 score 记录了用户积分。 
我在规则表添加规则时，定义规则表的condition 字段，condition字段是规则条件，默认为空 表示没有附加条件，用户组中只有规则 就通过认证。
如果定义了 condition字段，用户组中有规则不一定能通过认证，程序还会判断是否满足附加条件。
比如我们添加几条规则： 

> `name`字段：grade1 `condition`字段：{score}<100 <br/>
> `name`字段：grade2 `condition`字段：{score}>100 and {score}<200<br/>
> `name`字段：grade3 `condition`字段：{score}>200 and {score}<300

这里 `{score}` 表示 `lmx_members` 表 中字段 `score` 的值。 

那么这时候 

> $auth->check('grade1', uid) 是判断用户积分是不是0-100<br/>
> $auth->check('grade2', uid) 判断用户积分是不是在100-200<br/>
> $auth->check('grade3', uid) 判断用户积分是不是在200-300
