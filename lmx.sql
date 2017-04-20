/*
Navicat MySQL Data Transfer

Source Server         : php
Source Server Version : 50553
Source Host           : localhost:3306
Source Database       : lmx

Target Server Type    : MYSQL
Target Server Version : 50553
File Encoding         : 65001

Date: 2017-04-20 11:38:18
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for lmx_ad
-- ----------------------------
DROP TABLE IF EXISTS `lmx_ad`;
CREATE TABLE `lmx_ad` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '广告id',
  `name` varchar(255) NOT NULL COMMENT '广告名称',
  `content` text COMMENT '广告内容',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1显示，0不显示',
  PRIMARY KEY (`id`),
  KEY `name` (`name`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='广告表';

-- ----------------------------
-- Records of lmx_ad
-- ----------------------------

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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='文章表';

-- ----------------------------
-- Records of lmx_article
-- ----------------------------
INSERT INTO `lmx_article` VALUES ('1', '0', '1', '谷歌、亚马逊在零售领域必有一战！', '2', '谷歌、亚马逊在零售领域必有一战！', '谷歌、亚马逊在零售领域必有一战！', '2017-03-16 09:53:24', '<h1 style=\"font-size: 32px; font-weight: bold; border-bottom: 2px solid rgb(204, 204, 204); padding: 0px 4px 0px 0px; text-align: center; margin: 0px 0px 20px;\"><span style=\"font-family:楷体;word-wrap: break-word;\">谷歌、亚马逊在零售领域必有一战！<br/></span></h1><p><span style=\"font-family:楷体;word-wrap: break-word;\">“亚马逊是谷歌最大的竞争对手。”谷歌董事长埃里克·施密特最近的这个判断或许让人感到困惑。表面上看<span style=\"word-wrap: break-word; line-height: 1.8em;\">谷歌和亚马逊似乎处于不同领域，但在决定未来零售的走向方面，双方避免不了一战。关于这一问题，</span>研究商业、科技和社会变革的吉迪恩·罗森巴拉特（Gideon Rosenblatt）发表深度文章，解析到亚马逊在商品丰富度不断提升后，用户站内搜索习惯间接影响到谷歌的购物搜索频率，这种局面在移动端上会愈加明显。本文转自网易科技，原文标题<a href=\"http://tech.163.com/14/1020/12/A90GHPH6000915BF.html\" target=\"_blank\" style=\"word-wrap: break-word; color: rgb(0, 136, 204); text-decoration: none;\">《谷歌VS亚马逊：决定零售业未来》</a>，译者皓慧。虎嗅进行编辑（删节）。</span></p><p><span style=\"word-wrap: break-word; line-height: 1.8em;\"><br/></span></p><p><span style=\"word-wrap: break-word; line-height: 1.8em;\">谷歌是一家搜索引擎公司，而亚马逊则是一家在线零售商。那究竟是什么促使它们兵戎相见的呢？</span></p><p>简单来说，谷歌主要依靠广告创收，其利润丰厚的广告业务很大一部分就是为了方便人们购买商品服务。那正是亚马逊所擅长的地方。<strong style=\"word-wrap: break-word;\">随着购物相关的搜索请求开始从谷歌搜索转到其它地方，谷歌的盈利性面临直接的威胁：</strong></p><p>分析与软件公司SDL最近进行了一项调查，询问人们今年假日购物季他们首选的礼品购买物色平台是哪三个。调查结果显示，“在线搜索”占45%，低于一年前的49%；而普及程度增幅最大的渠道是亚马逊，占比从31%攀升至37%。</p><p>产品展示广告的点击率也比谷歌的关键词广告高出21%。谷歌的利润率面临下行风险，亚马逊在产品搜索领域的涉足显然对它构成了很大的威胁。</p><p><strong style=\"word-wrap: break-word;\"><span style=\"color:#800000;word-wrap: break-word;\">亚马逊商品丰富提升 用户倾向本站搜索</span></strong></p><p>亚马逊在15年前推出了它的卖家服务，而后开始逐渐从在线零售商演变成电商平台。在这一过程中，它向第三方卖家开放了它庞大的物流基础设施。截至2013年底，亚马逊的平台有大约200万卖家使用亚马逊服务（Amazon\n Services），并出现在该网站的产品搜索结果上。如今，亚马逊有40%的单位销售量来自第三方卖家，对它们的收费占该公司营收的20%。</p><p>毫无疑问，众多的第三方卖家让亚马逊平台上的商品选择变得更加丰富，这是人们倾向于在亚马逊搜索产品服务而非谷歌的原因之一。</p><p><strong style=\"word-wrap: break-word;\"><span style=\"color:#800000;word-wrap: break-word;\">谷歌在强化关联</span></strong><strong style=\"word-wrap: break-word; line-height: 1.8em;\"><span style=\"color:#800000;word-wrap: break-word;\">购物搜索</span></strong></p><p>亚马逊这一巨擘存在一个公关问题：人们喜欢它带来的便利性，但不少人担心其模式可能会致使本地零售商衰亡。而谷歌有能力充分利用亚马逊的这一潜在弱点。</p><p>与亚马逊不同，谷歌的角色并不是零售商，而是广大零售商的顾客来源。它是通过广告来赚钱——而非交易本身——这是它跟亚马逊的本质区别。（注：除了在数字媒体领域，谷歌Google Play商店向终端用户直接出售商品，与亚马逊和其它公司直接竞争。）</p><p>过去几年，为了应对亚马逊的冲击，谷歌改变了它处理购物相关的搜索方式。老实说，它早期的购物功能令人困惑，搜索广告掺杂着其购物网站上的免费展示商品，后者与它的主搜索结果页面并不相连。</p><p>谷歌近年来做出了重大改变。如今，搜索诸如“microwave\n oven”（微波炉）的时候，你会在搜索结果右侧看到商品网格。从网格点击“Shop for microwave oven on \nGoogle”（在谷歌上购买微波炉），你就可以筛选出附近有售的商品。点击其中一个链接，你会看到该产品的介绍，上面突出显示本地零售商、定价、其它零售商的链接等信息。</p><p>谷歌在购物领域的动作并不止于此。它旗下的购物快递服务（Google Express）旨在通过提供便利的配送选项让谷歌的购物体验更上一层楼。</p><p>Google Express目前仅覆盖几个地区，包括波士顿、芝加哥、曼哈顿、华盛顿DC、洛杉矶西部和湾区（为北加州的其余地区提供通宵服务）。</p><p>虽然湾区有小商家参与谷歌的项目，但该公司显然是将重心放在那些规模较大的零售商上。因为它们拥有更多的产品库存，它们的IT系统也能够轻松地将其产品和目录与谷歌的搜索结果相整合。</p><p>而将该项目扩张至更为普遍的小型零售店得耗费大量的功夫和资金。依靠第三方卖家固然让谷歌无需像亚马逊那样巨额投资建设仓储中心，但这种模式也会带来很多其它的问题。</p><p><strong style=\"word-wrap: break-word;\"><span style=\"color:#800000;word-wrap: break-word;\">本地零售市场</span></strong></p><p>在网络零售诞生20年后，实体零售与虚拟零售如今必须要比以往更好地进行融合。那是因为我们不再仅仅通过我们的桌面使用网络。</p><p>智能手机的爆炸式增长大大提振了移动搜索。到2015年，移动端在搜索量上应该会超过桌面。谷歌不仅仅着眼于在这两端齐头并进。在美国，它的桌面端搜索份额为67%，在移动端的份额则达到83%。该公司如今想要通过理解如何给本地商家带来生意，将其移动搜索优势转化成其购物战略的推动力。</p><p>本质上，<strong style=\"word-wrap: break-word;\">谷歌的战略是由它对“组织全世界的信息使得它变得有用，为人们所获取”宗旨的专注而决定的。因此，不难理解谷歌的购物赌注更多的关乎产品服务背后的信息处理，而非产品服务本身的处理。</strong>因此，即便你是经由谷歌才完成交易的，你也可以知道背后是哪家零售商给你提供商品。</p><p>再来对比一下亚马逊和它的移动战略。它的Fire手机被普遍认为是“商品展示”工具，旨在帮助顾客发现本地商店的产品，然后更加轻松地在亚马逊上购买。它的移动扫描器Amazon Dash是这一战略更加明显的例子。Fire手机和Dash只是亚马逊平台的一种延伸。</p><p>这些工具凸显了亚马逊的战略，本质上其战略是由它的电商平台优势所决定的。亚马逊卖家服务可让其它零售商依托亚马逊庞大的交易处理基础设施。而你在亚马逊上从这些第三方卖家买东西时，你很少会注意到它们的品牌名称。从购买者的角度来看，你好像就是从亚马逊购买的。</p><p><strong style=\"word-wrap: break-word;\"><span style=\"color:#800000;word-wrap: break-word;\">零售业未来之战</span></strong></p><p>我们即将见证亚马逊和谷歌之间的一场大战，亚马逊给谷歌带来的挑战将明显超过苹果、Facebook或者微软。两种战略最终谁将胜出还不好说。事实上，该市场规模宏大，也足以让两种战略同时并存。</p><p>这种争夺只会让人们的购物体验变得更加便利，我个人认为有利也有弊。我很高兴看到谷歌采取一种成败实际取决于本地零售商存活的战略。属于本地实体店的美好时光早已不复存在。如今，要在高科技零售环境中存活甚至兴旺发展，即便是小零售铺也得进行科技武装——这意味着它们会有相当一部分的收入流入科技巨头们的口袋。</p><p>这不是理想的情况，但总好过所有的东西都经由一家庞大的商店出售。</p><p><br/></p><p><br/></p>', '谷歌是一家搜索引擎公司，而亚马逊则是一家在线零售商。那究竟是什么促使它们兵戎相见的呢？\n简单来说，谷歌主要依靠广告创收，其利润丰厚的广告业务很大一部分就是为了方便人们购买商品服务。那正是亚马逊所擅长的地方。随着购物相关的搜索请求开始从谷歌搜索转到其它地方，谷歌的盈利性面临直接的威胁', '1', '1', '0', '{\"thumb\":\"20170316\\\\e57ac1ca685b6049432d2b93da376ebb.jpg\"}', '0', '0', '1', '1', null, '1489630473', '1489634360');

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
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COMMENT='规则表';

-- ----------------------------
-- Records of lmx_auth_rule
-- ----------------------------
INSERT INTO `lmx_auth_rule` VALUES ('45', 'admin/Node/default', '菜单管理', '1', '1', '', '0', '1488007070', '1488007070');
INSERT INTO `lmx_auth_rule` VALUES ('46', 'admin/System/siteConfig', '网站配置', '1', '1', '', '0', '1488043079', '1489038654');
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
INSERT INTO `lmx_auth_rule` VALUES ('60', 'admin/System/setAppAndroidConfig', 'android配置', '1', '1', '', '0', '1489031361', '1489031361');
INSERT INTO `lmx_auth_rule` VALUES ('61', 'admin/System/upAppAndroidConfig', '更新android配置', '1', '1', '', '0', '1489031431', '1489031431');
INSERT INTO `lmx_auth_rule` VALUES ('62', 'admin/Tool/default', '扩展工具', '1', '1', '', '0', '1489476084', '1489547712');
INSERT INTO `lmx_auth_rule` VALUES ('65', 'admin/Slide/default', '幻灯片', '1', '1', '', '0', '1489489395', '1489489395');
INSERT INTO `lmx_auth_rule` VALUES ('66', 'admin/Slide/index', '幻灯片管理', '1', '1', '', '0', '1489489421', '1489489421');
INSERT INTO `lmx_auth_rule` VALUES ('67', 'admin/SlideCat/index', '幻灯片分类', '1', '1', '', '0', '1489489448', '1489489448');
INSERT INTO `lmx_auth_rule` VALUES ('68', 'admin/Slide/add', '添加幻灯片', '1', '1', '', '0', '1489546558', '1489546558');
INSERT INTO `lmx_auth_rule` VALUES ('69', 'admin/Slide/edit', '编辑幻灯片', '1', '1', '', '0', '1489546580', '1489546580');
INSERT INTO `lmx_auth_rule` VALUES ('70', 'admin/Slide/delete', '删除幻灯片', '1', '1', '', '0', '1489546608', '1489546608');
INSERT INTO `lmx_auth_rule` VALUES ('71', 'admin/SlideCat/add', '添加幻灯片分类', '1', '1', '', '0', '1489546644', '1489546644');
INSERT INTO `lmx_auth_rule` VALUES ('72', 'admin/SlideCat/edit', '编辑幻灯片分类', '1', '1', '', '0', '1489546670', '1489546670');
INSERT INTO `lmx_auth_rule` VALUES ('73', 'admin/SlideCat/delete', '删除幻灯片分类', '1', '1', '', '0', '1489546702', '1489546702');
INSERT INTO `lmx_auth_rule` VALUES ('74', 'admin/AppRecommend/index', '推荐应用管理', '1', '1', '', '0', '1489554977', '1489554977');
INSERT INTO `lmx_auth_rule` VALUES ('75', 'admin/AppRecommend/add', '添加推荐应用', '1', '1', '', '0', '1489555011', '1489555011');
INSERT INTO `lmx_auth_rule` VALUES ('76', 'admin/AppRecommend/edit', '编辑推荐应用', '1', '1', '', '0', '1489555035', '1489555035');
INSERT INTO `lmx_auth_rule` VALUES ('77', 'admin/AppRecommend/delete', '删除推荐应用', '1', '1', '', '0', '1489555118', '1489555118');
INSERT INTO `lmx_auth_rule` VALUES ('78', 'admin/AppRecommend/setShowCount', '客户端的显示数量', '1', '1', '', '0', '1489555243', '1489555256');
INSERT INTO `lmx_auth_rule` VALUES ('79', 'admin/AppRecommend/setAppRecommendConf', '推荐应用配置', '1', '1', '', '0', '1489557777', '1489557777');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='文章分类表';

-- ----------------------------
-- Records of lmx_category
-- ----------------------------
INSERT INTO `lmx_category` VALUES ('2', '0', '分类', '', '1', '1', null, null, null, '1489656726', '1489656726');

-- ----------------------------
-- Table structure for lmx_menu
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
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=utf8 COMMENT='后台菜单表';

-- ----------------------------
-- Records of lmx_menu
-- ----------------------------
INSERT INTO `lmx_menu` VALUES ('66', '0', 'admin', 'Node', 'default', '', '1', '1', '菜单管理', 'fa-list', '', '1', '1487778496', '1488007070', '0', '0');
INSERT INTO `lmx_menu` VALUES ('67', '66', 'admin', 'Node', 'index', '', '1', '1', '后台菜单', 'fa-circle-o', '', '2', '1487779790', '1487950594', '0', '0');
INSERT INTO `lmx_menu` VALUES ('68', '67', 'admin', 'Node', 'add', '', '1', '0', '添加菜单', 'fa-circle-o', '', '3', '1487779957', '1487789234', '0', '0');
INSERT INTO `lmx_menu` VALUES ('69', '67', 'admin', 'Node', 'edit', '', '1', '0', '编辑菜单', 'fa-circle-o', '', '4', '1487780038', '1487789255', '0', '0');
INSERT INTO `lmx_menu` VALUES ('70', '67', 'admin', 'Node', 'delete', '', '1', '0', '删除菜单', 'fa-circle-o', '', '5', '1487780088', '1487789246', '0', '0');
INSERT INTO `lmx_menu` VALUES ('71', '0', 'admin', 'Setting', 'default', '', '1', '1', '设置', 'fa-cogs', '', '0', '1487951321', '1487951321', '0', '0');
INSERT INTO `lmx_menu` VALUES ('72', '0', 'admin', 'Users', 'default', '', '1', '1', '用户管理', 'fa-group', '', '0', '1487951847', '1487952237', '0', '0');
INSERT INTO `lmx_menu` VALUES ('73', '72', 'admin', 'Users', 'default', '', '1', '1', '用户组', 'fa-circle-o', '', '1', '1487954607', '1487999511', '0', '0');
INSERT INTO `lmx_menu` VALUES ('74', '73', 'admin', 'Users', 'index', '', '1', '1', '本站用户', 'fa-user-o', '', '1', '1487954667', '1487999501', '0', '0');
INSERT INTO `lmx_menu` VALUES ('75', '72', 'admin', 'Admin', 'default', '', '1', '1', '管理组', 'fa-circle-o', '', '2', '1487954732', '1487954732', '0', '0');
INSERT INTO `lmx_menu` VALUES ('76', '75', 'admin', 'Admin', 'index', '', '1', '1', '管理员', 'fa-user-circle-o', '', '2', '1487957700', '1487999532', '0', '0');
INSERT INTO `lmx_menu` VALUES ('77', '76', 'admin', 'Admin', 'add', '', '1', '0', '添加管理员', 'fa-circle-o', '', '1', '1487966778', '1487966778', '0', '0');
INSERT INTO `lmx_menu` VALUES ('78', '76', 'admin', 'Admin', 'edit', '', '1', '0', '编辑管理员', 'fa-circle-o', '', '2', '1487966821', '1487966821', '0', '0');
INSERT INTO `lmx_menu` VALUES ('79', '76', 'admin', 'Admin', 'delete', '', '1', '0', '删除管理员', 'fa-circle-o', '', '3', '1487966874', '1487966874', '0', '0');
INSERT INTO `lmx_menu` VALUES ('80', '75', 'admin', 'Rbac', 'index', '', '1', '1', '角色管理', 'fa-venus-mars', '', '1', '1487997838', '1487999640', '0', '0');
INSERT INTO `lmx_menu` VALUES ('81', '71', 'admin', 'User', 'default', '', '0', '1', '个人信息', 'fa-circle-o', '', '1', '1488042992', '1488043017', '0', '0');
INSERT INTO `lmx_menu` VALUES ('82', '71', 'admin', 'System', 'siteConfig', '', '1', '1', '网站配置', 'fa-circle-o', '', '2', '1488043079', '1489038654', '0', '0');
INSERT INTO `lmx_menu` VALUES ('83', '82', 'admin', 'System', 'updateSiteConfig', '', '1', '0', '更新配置', 'fa-circle-o', '', '1', '1488043231', '1488043231', '0', '0');
INSERT INTO `lmx_menu` VALUES ('84', '71', 'admin', 'Backup', 'default', '', '1', '1', '备份管理', 'fa-circle-o', '', '3', '1488044935', '1488044935', '0', '0');
INSERT INTO `lmx_menu` VALUES ('85', '84', 'admin', 'Backup', 'index', '', '1', '1', '数据备份', 'fa-circle-o', '', '1', '1488044981', '1488044981', '0', '0');
INSERT INTO `lmx_menu` VALUES ('86', '84', 'admin', 'Backup', 'restore', '', '1', '1', '数据列表', 'fa-circle-o', '', '2', '1488045030', '1488052426', '0', '0');
INSERT INTO `lmx_menu` VALUES ('87', '84', 'admin', 'Backup', 'import', '', '1', '0', '数据恢复', 'fa-circle-o', '', '3', '1488052552', '1488052552', '0', '0');
INSERT INTO `lmx_menu` VALUES ('88', '84', 'admin', 'Backup', 'del_backup', '', '1', '0', '数据删除', 'fa-circle-o', '', '4', '1488052594', '1488052594', '0', '0');
INSERT INTO `lmx_menu` VALUES ('89', '84', 'admin', 'Backup', 'download', '', '1', '0', '数据下载', 'fa-circle-o', '', '5', '1488052624', '1488052624', '0', '0');
INSERT INTO `lmx_menu` VALUES ('90', '81', 'admin', 'User', 'edit', '', '0', '1', '修改信息', 'fa-circle-o', '', '1', '1488058039', '1488058039', '0', '0');
INSERT INTO `lmx_menu` VALUES ('91', '81', 'admin', 'User', 'pwd', '', '0', '1', '修改密码', 'fa-circle-o', '', '2', '1488058064', '1488058064', '0', '0');
INSERT INTO `lmx_menu` VALUES ('92', '0', 'admin', 'Content', 'default', '', '1', '1', '内容管理', 'fa-file-text', '', '4', '1488597861', '1488597861', '0', '0');
INSERT INTO `lmx_menu` VALUES ('93', '92', 'admin', 'Category', 'index', '', '1', '1', '分类管理', 'fa-circle-o', '', '1', '1488597987', '1488597987', '0', '0');
INSERT INTO `lmx_menu` VALUES ('94', '93', 'admin', 'Category', 'add', '', '1', '0', '添加分类', 'fa-circle-o', '', '1', '1488690546', '1488690546', '0', '0');
INSERT INTO `lmx_menu` VALUES ('95', '93', 'admin', 'Category', 'edit', '', '1', '0', '编辑分类', 'fa-circle-o', '', '2', '1488690572', '1488690572', '0', '0');
INSERT INTO `lmx_menu` VALUES ('96', '93', 'admin', 'Category', 'delete', '', '1', '0', '删除分类', 'fa-circle-o', '', '3', '1488690603', '1488690603', '0', '0');
INSERT INTO `lmx_menu` VALUES ('97', '92', 'admin', 'Article', 'index', '', '1', '1', '文章管理', 'fa-circle-o', '', '2', '1488691790', '1488691790', '0', '0');
INSERT INTO `lmx_menu` VALUES ('98', '71', 'admin', 'System', 'setAppAndroidConfig', '', '1', '1', 'android配置', 'fa-circle-o', '', '2', '1489031361', '1489031361', '0', '0');
INSERT INTO `lmx_menu` VALUES ('99', '98', 'admin', 'System', 'upAppAndroidConfig', '', '1', '0', '更新android配置', 'fa-circle-o', '', '1', '1489031431', '1489031431', '0', '0');
INSERT INTO `lmx_menu` VALUES ('100', '0', 'admin', 'Tool', 'default', '', '1', '1', '扩展工具', 'fa-cloud', '', '4', '1489476084', '1489547868', '0', '0');
INSERT INTO `lmx_menu` VALUES ('103', '100', 'admin', 'Slide', 'default', '', '1', '1', '幻灯片', 'fa-circle-o', '', '1', '1489489395', '1489489395', '0', '0');
INSERT INTO `lmx_menu` VALUES ('104', '103', 'admin', 'Slide', 'index', '', '1', '1', '幻灯片管理', 'fa-circle-o', '', '1', '1489489421', '1489489421', '0', '0');
INSERT INTO `lmx_menu` VALUES ('105', '103', 'admin', 'SlideCat', 'index', '', '1', '1', '幻灯片分类', 'fa-circle-o', '', '2', '1489489448', '1489489448', '0', '0');
INSERT INTO `lmx_menu` VALUES ('106', '104', 'admin', 'Slide', 'add', '', '1', '0', '添加幻灯片', 'fa-circle-o', '', '1', '1489546558', '1489546558', '0', '0');
INSERT INTO `lmx_menu` VALUES ('107', '104', 'admin', 'Slide', 'edit', '', '1', '0', '编辑幻灯片', 'fa-circle-o', '', '2', '1489546580', '1489546580', '0', '0');
INSERT INTO `lmx_menu` VALUES ('108', '104', 'admin', 'Slide', 'delete', '', '1', '0', '删除幻灯片', 'fa-circle-o', '', '3', '1489546608', '1489546608', '0', '0');
INSERT INTO `lmx_menu` VALUES ('109', '105', 'admin', 'SlideCat', 'add', '', '1', '0', '添加幻灯片分类', 'fa-circle-o', '', '1', '1489546644', '1489546644', '0', '0');
INSERT INTO `lmx_menu` VALUES ('110', '105', 'admin', 'SlideCat', 'edit', '', '1', '0', '编辑幻灯片分类', 'fa-circle-o', '', '2', '1489546670', '1489546670', '0', '0');
INSERT INTO `lmx_menu` VALUES ('111', '105', 'admin', 'SlideCat', 'delete', '', '1', '0', '删除幻灯片分类', 'fa-circle-o', '', '3', '1489546702', '1489546702', '0', '0');

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
-- Table structure for lmx_slide
-- ----------------------------
DROP TABLE IF EXISTS `lmx_slide`;
CREATE TABLE `lmx_slide` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL COMMENT '幻灯片分类 id',
  `name` varchar(255) NOT NULL COMMENT '幻灯片名称',
  `pic` varchar(255) DEFAULT NULL COMMENT '幻灯片图片',
  `url` varchar(255) DEFAULT NULL COMMENT '幻灯片链接',
  `des` varchar(255) DEFAULT NULL COMMENT '幻灯片描述',
  `content` text COMMENT '幻灯片内容',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1显示，0不显示',
  `listorder` int(10) DEFAULT '0' COMMENT '排序',
  PRIMARY KEY (`id`),
  KEY `cid` (`cid`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='幻灯片表';

-- ----------------------------
-- Records of lmx_slide
-- ----------------------------
INSERT INTO `lmx_slide` VALUES ('1', '1', '测试1', '20170316\\2c1851a4fa09be27e29c36594c2fd953.png', 'http://www.baidu.com', '面搜', '的老师放假了', '1', '1');
INSERT INTO `lmx_slide` VALUES ('2', '1', '阿斯蒂芬', '20170316\\79787d32c08b0915c6ebf116bccd393c.png', '阿斯蒂芬', '阿斯蒂芬', '', '1', '2');

-- ----------------------------
-- Table structure for lmx_slide_cat
-- ----------------------------
DROP TABLE IF EXISTS `lmx_slide_cat`;
CREATE TABLE `lmx_slide_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT '幻灯片分类名称',
  `idname` varchar(255) NOT NULL COMMENT '幻灯片分类标识',
  `remark` text COMMENT '分类备注',
  `status` int(2) NOT NULL DEFAULT '1' COMMENT '状态，1显示，0不显示',
  PRIMARY KEY (`id`),
  KEY `idname` (`idname`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='幻灯片分类表';

-- ----------------------------
-- Records of lmx_slide_cat
-- ----------------------------
INSERT INTO `lmx_slide_cat` VALUES ('1', '默认分类1', '123', '哈哈哈\n', '1');

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
INSERT INTO `lmx_users` VALUES ('2', 'admin', 'c3284d0f94606de1fd2af172aba15bf3', 'admin', 'lmxdawn@gmail.com', 'kk', null, '0', '2000-01-01', null, '127.0.0.1', '1492659460', '1487868050', '', '1', '0', '1', '0', '', null);
INSERT INTO `lmx_users` VALUES ('5', 'demo', '6c5ac7b4d3bd3311f033f971196cfa75', 'demo', '862253272@qq.com', '123', null, '1', '2000-01-01', '', '127.0.0.1', '1488169490', '1487966028', '', '1', '0', '1', '0', '', null);
INSERT INTO `lmx_users` VALUES ('6', 'demo1', '655e9d2a52f932bdde5ba3e0c544a6b9', 'demo1', '', '', null, '0', '2000-01-01', null, null, '0', '1487966314', '', '1', '0', '1', '0', '', null);
