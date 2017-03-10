/*
Navicat MySQL Data Transfer

Source Server         : php
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : lmx

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-03-10 18:52:23
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for lmx_article
-- ----------------------------
DROP TABLE IF EXISTS `lmx_article`;
CREATE TABLE `lmx_article` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '文章编号',
  `pid` int(11) DEFAULT '0' COMMENT '文章上级编号',
  `category_id` int(11) DEFAULT NULL COMMENT '文章分类id',
  `title` varchar(255) DEFAULT NULL COMMENT '文章标题',
  `uid` int(11) DEFAULT '0' COMMENT '发表者id',
  `keywords` varchar(150) DEFAULT NULL COMMENT 'SEO keywords',
  `source` varchar(150) DEFAULT NULL COMMENT '文章来源',
  `u_date` datetime DEFAULT '2000-01-01 00:00:00' COMMENT '文章更新时间 可更改',
  `content` longtext COMMENT '文章内容',
  `excerpt` text COMMENT '摘要',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态 1已审核，0未审核',
  `comment_status` tinyint(4) DEFAULT '1' COMMENT '评论状态 1允许，0不允许',
  `comment_count` bigint(20) DEFAULT '0' COMMENT '评论数量',
  `smeta` text COMMENT '文章扩展字段，保存相关扩展属性，如缩略图；格式为json',
  `hits` int(11) DEFAULT '0' COMMENT '点击数',
  `likes` int(11) DEFAULT '0' COMMENT '点赞数',
  `istop` tinyint(4) DEFAULT '0' COMMENT '置顶 1置顶； 0不置顶',
  `recommended` tinyint(4) DEFAULT '0' COMMENT '推荐 1推荐 0不推荐',
  `template` varchar(255) DEFAULT NULL COMMENT '文章模板',
  `create_time` int(11) DEFAULT NULL COMMENT '添加时间',
  `update_time` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of lmx_article
-- ----------------------------

-- ----------------------------
-- Table structure for lmx_auth_access
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
-- Records of lmx_auth_access
-- ----------------------------
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/System/updateSiteConfig', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('2', 'admin/Backup/del_backup', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('2', 'admin/Backup/import', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/System/siteConfig', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/Setting/default', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('2', 'admin/Backup/restore', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('2', 'admin/Backup/index', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('2', 'admin/Backup/default', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('2', 'admin/System/siteConfig', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('2', 'admin/System/updateSiteConfig', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('2', 'admin/Setting/default', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('2', 'admin/Backup/download', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('2', 'admin/Node/default', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('2', 'admin/Node/index', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('2', 'admin/Node/add', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/Backup/default', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/Backup/index', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/Backup/restore', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/Backup/import', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/Backup/del_backup', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/Backup/download', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/Users/default', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/Users/default', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/Users/index', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/Admin/default', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/Rbac/index', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/Admin/index', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/Admin/add', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/Admin/edit', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/Admin/delete', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/Node/default', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/Node/index', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/Node/add', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/Node/edit', 'admin');
INSERT INTO `lmx_auth_access` VALUES ('1', 'admin/Node/delete', 'admin');

-- ----------------------------
-- Table structure for lmx_auth_rule
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
) ENGINE=MyISAM AUTO_INCREMENT=60 DEFAULT CHARSET=utf8 COMMENT='规则表';

-- ----------------------------
-- Records of lmx_auth_rule
-- ----------------------------
INSERT INTO `lmx_auth_rule` VALUES ('45', 'admin/Node/default', '菜单管理', '1', '1', '', '0', '1488007070', '1488007070');
INSERT INTO `lmx_auth_rule` VALUES ('46', 'admin/System/siteConfig', '网站信息', '1', '1', '', '0', '1488043079', '1488043079');
INSERT INTO `lmx_auth_rule` VALUES ('47', 'admin/System/updateSiteConfig', '更新配置', '1', '1', '', '0', '1488043231', '1488043231');
INSERT INTO `lmx_auth_rule` VALUES ('48', 'admin/Backup/default', '备份管理', '1', '1', '', '0', '1488044935', '1488044935');
INSERT INTO `lmx_auth_rule` VALUES ('31', 'admin/Node/index', '后台菜单', '1', '1', '', '0', '1487789220', '1487950594');
INSERT INTO `lmx_auth_rule` VALUES ('32', 'admin/Node/add', '添加菜单', '1', '1', '', '0', '1487789234', '1487789234');
INSERT INTO `lmx_auth_rule` VALUES ('33', 'admin/Node/delete', '删除菜单', '1', '1', '', '0', '1487789246', '1487789246');
INSERT INTO `lmx_auth_rule` VALUES ('34', 'admin/Node/edit', '编辑菜单', '1', '1', '', '0', '1487789255', '1487789255');
INSERT INTO `lmx_auth_rule` VALUES ('35', 'admin/Setting/default', '设置', '1', '1', '', '0', '1487951321', '1487951321');
INSERT INTO `lmx_auth_rule` VALUES ('36', 'admin/Users/default', '用户组', '1', '1', '', '0', '1487951847', '1487999511');
INSERT INTO `lmx_auth_rule` VALUES ('37', 'admin/Users/index', '本站用户', '1', '1', '', '0', '1487954667', '1487999501');
INSERT INTO `lmx_auth_rule` VALUES ('38', 'admin/Admin/default', '管理组', '1', '1', '', '0', '1487954732', '1487954732');
INSERT INTO `lmx_auth_rule` VALUES ('39', 'admin/Admin/index', '管理员', '1', '1', '', '0', '1487957700', '1487999532');
INSERT INTO `lmx_auth_rule` VALUES ('40', 'admin/Admin/add', '添加管理员', '1', '1', '', '0', '1487966778', '1487966778');
INSERT INTO `lmx_auth_rule` VALUES ('41', 'admin/Admin/edit', '编辑管理员', '1', '1', '', '0', '1487966821', '1487966821');
INSERT INTO `lmx_auth_rule` VALUES ('42', 'admin/Admin/delete', '删除管理员', '1', '1', '', '0', '1487966874', '1487966874');
INSERT INTO `lmx_auth_rule` VALUES ('43', 'admin/Role/index', '角色管理', '1', '1', '', '0', '1487997838', '1487997838');
INSERT INTO `lmx_auth_rule` VALUES ('44', 'admin/Rbac/index', '角色管理', '1', '1', '', '0', '1487998167', '1487999640');
INSERT INTO `lmx_auth_rule` VALUES ('49', 'admin/Backup/index', '数据备份', '1', '1', '', '0', '1488044981', '1488044981');
INSERT INTO `lmx_auth_rule` VALUES ('50', 'admin/Backup/restore', '数据列表', '1', '1', '', '0', '1488045030', '1488052426');
INSERT INTO `lmx_auth_rule` VALUES ('51', 'admin/Backup/import', '数据恢复', '1', '1', '', '0', '1488052552', '1488052552');
INSERT INTO `lmx_auth_rule` VALUES ('52', 'admin/Backup/del_backup', '数据删除', '1', '1', '', '0', '1488052594', '1488052594');
INSERT INTO `lmx_auth_rule` VALUES ('53', 'admin/Backup/download', '数据下载', '1', '1', '', '0', '1488052624', '1488052624');
INSERT INTO `lmx_auth_rule` VALUES ('54', 'admin/Content/default', '内容管理', '1', '1', '', '0', '1488597861', '1488597861');
INSERT INTO `lmx_auth_rule` VALUES ('55', 'admin/Category/index', '分类管理', '1', '1', '', '0', '1488597987', '1488597987');
INSERT INTO `lmx_auth_rule` VALUES ('56', 'admin/Category/add', '添加分类', '1', '1', '', '0', '1488690546', '1488690546');
INSERT INTO `lmx_auth_rule` VALUES ('57', 'admin/Category/edit', '编辑分类', '1', '1', '', '0', '1488690572', '1488690572');
INSERT INTO `lmx_auth_rule` VALUES ('58', 'admin/Category/delete', '删除分类', '1', '1', '', '0', '1488690603', '1488690603');
INSERT INTO `lmx_auth_rule` VALUES ('59', 'admin/Article/index', '文章管理', '1', '1', '', '0', '1488691790', '1488691790');

-- ----------------------------
-- Table structure for lmx_category
-- ----------------------------
DROP TABLE IF EXISTS `lmx_category`;
CREATE TABLE `lmx_category` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '分类编号',
  `pid` int(11) DEFAULT '0' COMMENT '分类父级id',
  `title` varchar(50) DEFAULT '' COMMENT '分类标题',
  `description` varchar(255) DEFAULT '' COMMENT '分类描述',
  `listorder` varchar(255) DEFAULT '0' COMMENT '排序',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态（0，1）',
  `seo_title` varchar(255) DEFAULT NULL,
  `seo_keywords` varchar(255) DEFAULT NULL,
  `seo_description` varchar(255) DEFAULT NULL,
  `create_time` int(11) DEFAULT NULL,
  `update_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文章分类表';

-- ----------------------------
-- Records of lmx_category
-- ----------------------------
INSERT INTO `lmx_category` VALUES ('1', '0', '测试一级分类1', '', '1', '1', null, null, null, '1488685709', '1488686404');

-- ----------------------------
-- Table structure for lmx_menu
-- ----------------------------
DROP TABLE IF EXISTS `lmx_menu`;
CREATE TABLE `lmx_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `parent_id` smallint(6) unsigned DEFAULT '0' COMMENT '父级ID',
  `parent_name` varchar(50) DEFAULT NULL COMMENT '父级菜单名称',
  `app` char(20) DEFAULT NULL COMMENT '应用名称',
  `model` char(20) DEFAULT NULL COMMENT '控制器',
  `action` char(20) DEFAULT NULL COMMENT '操作名称',
  `param` char(50) DEFAULT NULL COMMENT 'url参数',
  `type` tinyint(1) DEFAULT '0' COMMENT '菜单类型  1：权限认证+菜单；0：只作为菜单',
  `status` tinyint(1) unsigned DEFAULT '0' COMMENT '状态，1显示，0不显示',
  `title` varchar(50) DEFAULT NULL COMMENT '菜单名称',
  `icon` varchar(50) DEFAULT NULL COMMENT '菜单图标',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `listorder` smallint(6) unsigned DEFAULT '0' COMMENT '排序，优先级，越小优先级越高',
  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',
  `update_time` int(11) DEFAULT '0' COMMENT '更新时间',
  `nav_id` int(11) DEFAULT '0' COMMENT 'nav ID ',
  `is_update` tinyint(1) DEFAULT '0' COMMENT '是否自动刷新',
  PRIMARY KEY (`id`),
  KEY `status` (`status`) USING BTREE,
  KEY `model` (`model`) USING BTREE,
  KEY `parent_id` (`parent_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=98 DEFAULT CHARSET=utf8 COMMENT='后台菜单表';

-- ----------------------------
-- Records of lmx_menu
-- ----------------------------
INSERT INTO `lmx_menu` VALUES ('66', '0', '顶级', 'admin', 'Node', 'default', '', '1', '1', '菜单管理', 'fa-list', '', '1', '1487778496', '1488007070', '0', '0');
INSERT INTO `lmx_menu` VALUES ('67', '66', '菜单管理', 'admin', 'Node', 'index', '', '1', '1', '后台菜单', 'fa-circle-o', '', '2', '1487779790', '1487950594', '0', '0');
INSERT INTO `lmx_menu` VALUES ('68', '67', '后台菜单', 'admin', 'Node', 'add', '', '1', '0', '添加菜单', 'fa-circle-o', '', '3', '1487779957', '1487789234', '0', '0');
INSERT INTO `lmx_menu` VALUES ('69', '67', '后台菜单', 'admin', 'Node', 'edit', '', '1', '0', '编辑菜单', 'fa-circle-o', '', '4', '1487780038', '1487789255', '0', '0');
INSERT INTO `lmx_menu` VALUES ('70', '67', '后台菜单', 'admin', 'Node', 'delete', '', '1', '0', '删除菜单', 'fa-circle-o', '', '5', '1487780088', '1487789246', '0', '0');
INSERT INTO `lmx_menu` VALUES ('71', '0', '顶级', 'admin', 'Setting', 'default', '', '1', '1', '设置', 'fa-cogs', '', '0', '1487951321', '1487951321', '0', '0');
INSERT INTO `lmx_menu` VALUES ('72', '0', '顶级', 'admin', 'Users', 'default', '', '1', '1', '用户管理', 'fa-group', '', '0', '1487951847', '1487952237', '0', '0');
INSERT INTO `lmx_menu` VALUES ('73', '72', '用户管理', 'admin', 'Users', 'default', '', '1', '1', '用户组', 'fa-circle-o', '', '1', '1487954607', '1487999511', '0', '0');
INSERT INTO `lmx_menu` VALUES ('74', '73', '用户组', 'admin', 'Users', 'index', '', '1', '1', '本站用户', 'fa-user-o', '', '1', '1487954667', '1487999501', '0', '0');
INSERT INTO `lmx_menu` VALUES ('75', '72', '用户管理', 'admin', 'Admin', 'default', '', '1', '1', '管理组', 'fa-circle-o', '', '2', '1487954732', '1487954732', '0', '0');
INSERT INTO `lmx_menu` VALUES ('76', '75', '管理组', 'admin', 'Admin', 'index', '', '1', '1', '管理员', 'fa-user-circle-o', '', '2', '1487957700', '1487999532', '0', '0');
INSERT INTO `lmx_menu` VALUES ('77', '76', '管理员', 'admin', 'Admin', 'add', '', '1', '0', '添加管理员', 'fa-circle-o', '', '1', '1487966778', '1487966778', '0', '0');
INSERT INTO `lmx_menu` VALUES ('78', '76', '管理员', 'admin', 'Admin', 'edit', '', '1', '0', '编辑管理员', 'fa-circle-o', '', '2', '1487966821', '1487966821', '0', '0');
INSERT INTO `lmx_menu` VALUES ('79', '76', '管理员', 'admin', 'Admin', 'delete', '', '1', '0', '删除管理员', 'fa-circle-o', '', '3', '1487966874', '1487966874', '0', '0');
INSERT INTO `lmx_menu` VALUES ('80', '75', '管理组', 'admin', 'Rbac', 'index', '', '1', '1', '角色管理', 'fa-venus-mars', '', '1', '1487997838', '1487999640', '0', '0');
INSERT INTO `lmx_menu` VALUES ('81', '71', '设置', 'admin', 'User', 'default', '', '0', '1', '个人信息', 'fa-circle-o', '', '1', '1488042992', '1488043017', '0', '0');
INSERT INTO `lmx_menu` VALUES ('82', '71', '设置', 'admin', 'System', 'siteConfig', '', '1', '1', '网站信息', 'fa-circle-o', '', '2', '1488043079', '1488043079', '0', '0');
INSERT INTO `lmx_menu` VALUES ('83', '82', '网站信息', 'admin', 'System', 'updateSiteConfig', '', '1', '0', '更新配置', 'fa-circle-o', '', '1', '1488043231', '1488043231', '0', '0');
INSERT INTO `lmx_menu` VALUES ('84', '71', '设置', 'admin', 'Backup', 'default', '', '1', '1', '备份管理', 'fa-circle-o', '', '3', '1488044935', '1488044935', '0', '0');
INSERT INTO `lmx_menu` VALUES ('85', '84', '备份管理', 'admin', 'Backup', 'index', '', '1', '1', '数据备份', 'fa-circle-o', '', '1', '1488044981', '1488044981', '0', '0');
INSERT INTO `lmx_menu` VALUES ('86', '84', '备份管理', 'admin', 'Backup', 'restore', '', '1', '1', '数据列表', 'fa-circle-o', '', '2', '1488045030', '1488052426', '0', '0');
INSERT INTO `lmx_menu` VALUES ('87', '84', '备份管理', 'admin', 'Backup', 'import', '', '1', '0', '数据恢复', 'fa-circle-o', '', '3', '1488052552', '1488052552', '0', '0');
INSERT INTO `lmx_menu` VALUES ('88', '84', '备份管理', 'admin', 'Backup', 'del_backup', '', '1', '0', '数据删除', 'fa-circle-o', '', '4', '1488052594', '1488052594', '0', '0');
INSERT INTO `lmx_menu` VALUES ('89', '84', '备份管理', 'admin', 'Backup', 'download', '', '1', '0', '数据下载', 'fa-circle-o', '', '5', '1488052624', '1488052624', '0', '0');
INSERT INTO `lmx_menu` VALUES ('90', '81', '个人信息', 'admin', 'User', 'edit', '', '0', '1', '修改信息', 'fa-circle-o', '', '1', '1488058039', '1488058039', '0', '0');
INSERT INTO `lmx_menu` VALUES ('91', '81', '个人信息', 'admin', 'User', 'pwd', '', '0', '1', '修改密码', 'fa-circle-o', '', '2', '1488058064', '1488058064', '0', '0');
INSERT INTO `lmx_menu` VALUES ('92', '0', '顶级', 'admin', 'Content', 'default', '', '1', '1', '内容管理', 'fa-file-text', '', '4', '1488597861', '1488597861', '0', '0');
INSERT INTO `lmx_menu` VALUES ('93', '92', '内容管理', 'admin', 'Category', 'index', '', '1', '1', '分类管理', 'fa-circle-o', '', '1', '1488597987', '1488597987', '0', '0');
INSERT INTO `lmx_menu` VALUES ('94', '93', '分类管理', 'admin', 'Category', 'add', '', '1', '0', '添加分类', 'fa-circle-o', '', '1', '1488690546', '1488690546', '0', '0');
INSERT INTO `lmx_menu` VALUES ('95', '93', '分类管理', 'admin', 'Category', 'edit', '', '1', '0', '编辑分类', 'fa-circle-o', '', '2', '1488690572', '1488690572', '0', '0');
INSERT INTO `lmx_menu` VALUES ('96', '93', '分类管理', 'admin', 'Category', 'delete', '', '1', '0', '删除分类', 'fa-circle-o', '', '3', '1488690603', '1488690603', '0', '0');
INSERT INTO `lmx_menu` VALUES ('97', '92', '内容管理', 'admin', 'Article', 'index', '', '1', '1', '文章管理', 'fa-circle-o', '', '2', '1488691790', '1488691790', '0', '0');

-- ----------------------------
-- Table structure for lmx_options
-- ----------------------------
DROP TABLE IF EXISTS `lmx_options`;
CREATE TABLE `lmx_options` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL COMMENT '配置名',
  `value` longtext NOT NULL COMMENT '配置值',
  `autoload` int(2) NOT NULL DEFAULT '1' COMMENT '是否自动加载',
  PRIMARY KEY (`id`),
  UNIQUE KEY `option_name` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='全站配置表';

-- ----------------------------
-- Records of lmx_options
-- ----------------------------
INSERT INTO `lmx_options` VALUES ('7', 'site_config', 'a:7:{s:10:\"site_title\";s:5:\"lkjlj\";s:9:\"seo_title\";s:0:\"\";s:11:\"seo_keyword\";s:0:\"\";s:15:\"seo_description\";s:0:\"\";s:14:\"site_copyright\";s:0:\"\";s:8:\"site_icp\";s:0:\"\";s:11:\"site_tongji\";s:0:\"\";}', '1');

-- ----------------------------
-- Table structure for lmx_role
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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='角色表';

-- ----------------------------
-- Records of lmx_role
-- ----------------------------
INSERT INTO `lmx_role` VALUES ('1', '超级管理员', '0', '1', '拥有网站最高管理员权限！', '1329633709', '1329633709', '0');
INSERT INTO `lmx_role` VALUES ('2', '普通管理', '0', '1', '测试', '0', '0', '0');

-- ----------------------------
-- Table structure for lmx_role_user
-- ----------------------------
DROP TABLE IF EXISTS `lmx_role_user`;
CREATE TABLE `lmx_role_user` (
  `role_id` int(11) unsigned DEFAULT '0' COMMENT '角色 id',
  `user_id` int(11) DEFAULT '0' COMMENT '用户id',
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='用户角色对应表';

-- ----------------------------
-- Records of lmx_role_user
-- ----------------------------
INSERT INTO `lmx_role_user` VALUES ('1', '3');
INSERT INTO `lmx_role_user` VALUES ('3', '3');
INSERT INTO `lmx_role_user` VALUES ('1', '5');
INSERT INTO `lmx_role_user` VALUES ('2', '2');
INSERT INTO `lmx_role_user` VALUES ('2', '5');

-- ----------------------------
-- Table structure for lmx_third_users
-- ----------------------------
DROP TABLE IF EXISTS `lmx_third_users`;
CREATE TABLE `lmx_third_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '第三方用户编号',
  `from` varchar(20) DEFAULT NULL COMMENT '用户来源key',
  `name` varchar(50) DEFAULT NULL COMMENT '第三方用户昵称',
  `head_img` varchar(255) DEFAULT NULL COMMENT '第三方头像',
  `uid` int(11) DEFAULT NULL COMMENT '关联的本站用户id',
  `create_time` int(11) DEFAULT NULL COMMENT '绑定时间',
  `last_login_time` int(11) DEFAULT NULL COMMENT '最后登录时间',
  `last_login_ip` varchar(16) DEFAULT NULL COMMENT '最后登录ip',
  `login_times` int(6) DEFAULT NULL COMMENT '登录次数',
  `status` tinyint(4) DEFAULT '1' COMMENT '状态',
  `openid` varchar(50) DEFAULT NULL COMMENT '第三方用户id',
  `chid` int(11) DEFAULT NULL COMMENT '渠道',
  `subchid` int(11) DEFAULT NULL COMMENT '子渠道',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='第三方用户表';

-- ----------------------------
-- Records of lmx_third_users
-- ----------------------------

-- ----------------------------
-- Table structure for lmx_users
-- ----------------------------
DROP TABLE IF EXISTS `lmx_users`;
CREATE TABLE `lmx_users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_name` varchar(60) NOT NULL DEFAULT '' COMMENT '用户名',
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
  `delete_time` int(11) DEFAULT NULL COMMENT '删除日期',
  PRIMARY KEY (`id`),
  KEY `user_login_key` (`user_name`),
  KEY `user_nicename` (`user_nicename`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='用户表';

-- ----------------------------
-- Records of lmx_users
-- ----------------------------
INSERT INTO `lmx_users` VALUES ('2', 'admin', 'c3284d0f94606de1fd2af172aba15bf3', 'admin', 'lmxdawn@gmail.com', 'kk', null, '0', '2000-01-01', null, '127.0.0.1', '1489123503', '1487868050', '', '1', '0', '1', '0', '', null);
INSERT INTO `lmx_users` VALUES ('5', 'demo', '6c5ac7b4d3bd3311f033f971196cfa75', 'demo', '862253272@qq.com', '123', null, '1', '2000-01-01', '', '127.0.0.1', '1488169490', '1487966028', '', '1', '0', '1', '0', '', null);
INSERT INTO `lmx_users` VALUES ('6', 'demo1', '655e9d2a52f932bdde5ba3e0c544a6b9', 'demo1', '', '', null, '0', '2000-01-01', null, null, '0', '1487966314', '', '1', '0', '1', '0', '', null);
