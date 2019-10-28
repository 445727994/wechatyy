# MySQL-Front 5.1  (Build 4.13)

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;


# Host: 192.168.31.205    Database: yy
# ------------------------------------------------------
# Server version 5.6.45-log

DROP DATABASE IF EXISTS `yy`;
CREATE DATABASE `yy` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `yy`;

#
# Source for table yhc_admin
#

DROP TABLE IF EXISTS `yhc_admin`;
CREATE TABLE `yhc_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '#yhc_name#id#',
  `username` varchar(255) DEFAULT '' COMMENT '#yhc_name#用户名#yhc_type#input#yhc_validate#require#',
  `password` varchar(255) DEFAULT NULL COMMENT '#yhc_name#密码#yhc_type#password#yhc_validate#require#yhc_recheck#1',
  `salt` varchar(255) DEFAULT NULL,
  `role` varchar(255) DEFAULT NULL,
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#更新时间#yhc_type#laydate#yhc_show#0',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#创建时间#yhc_type#laydate#yhc_show#1',
  `userheader` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

#
# Dumping data for table yhc_admin
#

LOCK TABLES `yhc_admin` WRITE;
/*!40000 ALTER TABLE `yhc_admin` DISABLE KEYS */;
INSERT INTO `yhc_admin` VALUES (2,'admin','e1d627e2532e317ceee8a021529b70ba','667662d443961083a0be5a16ef5136aa',NULL,1554629022,1554629022,'');
/*!40000 ALTER TABLE `yhc_admin` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table yhc_camera
#

DROP TABLE IF EXISTS `yhc_camera`;
CREATE TABLE `yhc_camera` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '#yhc_name#id#',
  `name` varchar(200) NOT NULL DEFAULT '',
  `desc` varchar(2000) DEFAULT NULL COMMENT '#yhc_name#简介#yhc_type#textarea#yhc_validate#require#',
  `sort` int(11) DEFAULT NULL COMMENT '#yhc_name#排序#yhc_type#input#yhc_validate#number#',
  `is_show` int(1) NOT NULL DEFAULT '0' COMMENT '#yhc_name#状态#yhc_type#select#yhc_value#{"0":"显示","1":"不显示"}#',
  `content` longtext COMMENT '#yhc_name#摄影师介绍#yhc_type#textarea#yhc_validate#require#yhc_editor#ue#',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#创建时间#yhc_type#laydate#yhc_show#1',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#更新时间#yhc_type#laydate#yhc_show#0',
  `img` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table yhc_camera
#

LOCK TABLES `yhc_camera` WRITE;
/*!40000 ALTER TABLE `yhc_camera` DISABLE KEYS */;
INSERT INTO `yhc_camera` VALUES (1,'小白摄影1','专业专注婚纱摄影',10,0,NULL,1572006523,1572006779,4);
INSERT INTO `yhc_camera` VALUES (2,'小白摄影','小白摄影',100,1,NULL,1572006619,1572006803,5);
/*!40000 ALTER TABLE `yhc_camera` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table yhc_cate
#

DROP TABLE IF EXISTS `yhc_cate`;
CREATE TABLE `yhc_cate` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '#yhc_name#id#',
  `name` varchar(100) DEFAULT '',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#上级分类#yhc_type#input#yhc_type#select#yhc_value#{"where":"pid=0&is_delete=0","table":"cate","order":"id desc","field1":"id","field2":"name"}#',
  `is_delete` int(1) NOT NULL DEFAULT '0' COMMENT '#yhc_name#状态#yhc_type#select#yhc_value#{"0":"启用","1":"未启用"}#',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#创建时间#yhc_type#laydate#yhc_show#1',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#更新时间#yhc_type#laydate#yhc_show#0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table yhc_cate
#

LOCK TABLES `yhc_cate` WRITE;
/*!40000 ALTER TABLE `yhc_cate` DISABLE KEYS */;
INSERT INTO `yhc_cate` VALUES (4,'个人写真',0,0,1571756520,1571756520);
INSERT INTO `yhc_cate` VALUES (5,'婚纱摄影',0,0,1571845727,1571845727);
/*!40000 ALTER TABLE `yhc_cate` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table yhc_form
#

DROP TABLE IF EXISTS `yhc_form`;
CREATE TABLE `yhc_form` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '#yhc_name#id#',
  `name` varchar(200) NOT NULL DEFAULT '',
  `content` varchar(5000) DEFAULT NULL COMMENT '#yhc_name#内容#yhc_type#input#yhc_validate#require#',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#创建时间#yhc_type#laydate#yhc_show#1',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#更新时间#yhc_type#laydate#yhc_show#0',
  `is_delete` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table yhc_form
#

LOCK TABLES `yhc_form` WRITE;
/*!40000 ALTER TABLE `yhc_form` DISABLE KEYS */;
INSERT INTO `yhc_form` VALUES (12,'测试','{\"field\":[\"12\",\"13\",\"15\"],\"length\":[\"12\",\"13\",\"15\"],\"require\":{\"1\":\"1\",\"2\":\"1\",\"0\":0}}',1572145160,1572145367,0);
/*!40000 ALTER TABLE `yhc_form` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table yhc_goods
#

DROP TABLE IF EXISTS `yhc_goods`;
CREATE TABLE `yhc_goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '#yhc_name#id#',
  `goodsname` varchar(20) DEFAULT NULL COMMENT '#yhc_name#商品名称#yhc_type#input#yhc_validate#require#',
  `price` varchar(20) DEFAULT NULL COMMENT '#yhc_name#商品价格#yhc_type#input#yhc_validate#require#',
  `img` int(11) DEFAULT NULL COMMENT '#yhc_name#缩略图#yhc_type#uploadimg#yhc_validate#require#',
  `form_id` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#自定义字段模板#yhc_type#select#yhc_value#{"where":"is_delete=0","table":"form","order":"id desc","field1":"id","field2":"name"}#',
  `desc` varchar(5000) DEFAULT NULL COMMENT '#yhc_name#包含内容#yhc_type#textarea#yhc_validate#require#',
  `content` longtext COMMENT '#yhc_name#详情介绍#yhc_type#textarea#yhc_validate#require#yhc_editor#ue#',
  `sort` int(11) DEFAULT NULL COMMENT '#yhc_name#排序#yhc_type#input#yhc_validate#number#',
  `is_show` int(1) NOT NULL DEFAULT '0' COMMENT '#yhc_name#状态#yhc_type#select#yhc_value#{"0":"显示","1":"不显示"}#',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#创建时间#yhc_type#laydate#yhc_show#1',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#更新时间#yhc_type#laydate#yhc_show#0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table yhc_goods
#

LOCK TABLES `yhc_goods` WRITE;
/*!40000 ALTER TABLE `yhc_goods` DISABLE KEYS */;
/*!40000 ALTER TABLE `yhc_goods` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table yhc_goods_case
#

DROP TABLE IF EXISTS `yhc_goods_case`;
CREATE TABLE `yhc_goods_case` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '#yhc_name#id#',
  `case_id` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#案例#yhc_type#select#yhc_value#{"where":"is_show=0","table":"case","order":"id desc","field1":"id","field2":"name"}#',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#商品#yhc_type#select#yhc_value#{"where":"is_show=0","table":"goods","order":"id desc","field1":"id","field2":"name"}#',
  `sort` int(11) DEFAULT NULL COMMENT '#yhc_name#排序#yhc_type#input#yhc_validate#number#',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#创建时间#yhc_type#laydate#yhc_show#1',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#更新时间#yhc_type#laydate#yhc_show#0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table yhc_goods_case
#

LOCK TABLES `yhc_goods_case` WRITE;
/*!40000 ALTER TABLE `yhc_goods_case` DISABLE KEYS */;
/*!40000 ALTER TABLE `yhc_goods_case` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table yhc_img
#

DROP TABLE IF EXISTS `yhc_img`;
CREATE TABLE `yhc_img` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '#yhc_name#id#',
  `img_name` varchar(200) DEFAULT NULL COMMENT '#yhc_name#图片上传名称#yhc_type#input#yhc_validate#require#',
  `url` varchar(500) DEFAULT NULL COMMENT '#yhc_name#图片地址#yhc_type#input#yhc_validate#require#',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#创建时间#yhc_type#laydate#yhc_show#1',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#更新时间#yhc_type#laydate#yhc_show#0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table yhc_img
#

LOCK TABLES `yhc_img` WRITE;
/*!40000 ALTER TABLE `yhc_img` DISABLE KEYS */;
INSERT INTO `yhc_img` VALUES (1,'mx-btn.jpg','20191024/115363083f491e376863fbca79659747.jpg',1571924138,0);
INSERT INTO `yhc_img` VALUES (2,'1dbdfd34e8074ef8c4c1952fb12eca1e_t.gif','20191025/46c5a62d7d361bf861b528688fa66ab6.gif',1572006064,0);
INSERT INTO `yhc_img` VALUES (3,'1dbdfd34e8074ef8c4c1952fb12eca1e_t.gif','20191025/4f58aadb54483b0bb6c97cb27a548e0b.gif',1572006608,0);
INSERT INTO `yhc_img` VALUES (4,'1dbdfd34e8074ef8c4c1952fb12eca1e_t.gif','20191025/9a5fdbe35f01e036261123823b78bd1d.gif',1572006775,0);
INSERT INTO `yhc_img` VALUES (5,'8ea94258efd4d8319f9fdcd904f76b22_t.gif','20191025/d7ba56b8708435dd21e15d77034b3e93.gif',1572006795,0);
/*!40000 ALTER TABLE `yhc_img` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table yhc_menu
#

DROP TABLE IF EXISTS `yhc_menu`;
CREATE TABLE `yhc_menu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '#yhc_name#id#',
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '#yhc_name#网页标题#yhc_type#input#yhc_validate#require#',
  `module` varchar(200) NOT NULL DEFAULT '' COMMENT '#yhc_name#模块#yhc_type#input#yhc_validate#require#',
  `controller` varchar(200) NOT NULL DEFAULT '' COMMENT '#yhc_name#控制器#yhc_type#input#yhc_validate#require#',
  `action` varchar(200) DEFAULT NULL COMMENT '#yhc_name#方法#yhc_type#input#yhc_validate#require#',
  `param` varchar(200) NOT NULL DEFAULT '' COMMENT '#yhc_name#参数#yhc_type#input#',
  `pid` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#上级分类#yhc_type#select#',
  `is_menu` int(1) NOT NULL DEFAULT '0' COMMENT '#yhc_name#是否显示菜单#yhc_type#switch#yhc_value#{"1":"是","0":"否"}#',
  `icon` varchar(255) DEFAULT NULL COMMENT '#yhc_name#图标class#yhc_type#input#yhc_validate#require#''',
  `type` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table yhc_menu
#

LOCK TABLES `yhc_menu` WRITE;
/*!40000 ALTER TABLE `yhc_menu` DISABLE KEYS */;
INSERT INTO `yhc_menu` VALUES (1,'信息管理','admin','',NULL,'',0,1,'&#xe6b4;','1');
INSERT INTO `yhc_menu` VALUES (2,'用户管理','admin','','','',0,1,'&#xe6b4;','1');
INSERT INTO `yhc_menu` VALUES (9,'网站设置','admin','','','',0,1,'&#xe6b4;','1');
INSERT INTO `yhc_menu` VALUES (10,'网站设置','admin','webconfig','edit','id=1',9,1,'&#xe6b4;','2');
INSERT INTO `yhc_menu` VALUES (12,'管理列表','admin','admin','index','',2,1,'&#xe6a7;','2');
INSERT INTO `yhc_menu` VALUES (16,'案例列表','admin','user_case','index','',1,1,'&#xe6a7;','2');
INSERT INTO `yhc_menu` VALUES (17,'案例列表-添加','admin','user_case','add','',1,0,'&#xe6a7;','2');
INSERT INTO `yhc_menu` VALUES (18,'案例列表-编辑','admin','user_case','edit','',1,0,'&#xe6a7;','2');
INSERT INTO `yhc_menu` VALUES (19,'预约管理','admin','goods','index','',1,1,'&#xe6a7;','2');
INSERT INTO `yhc_menu` VALUES (20,'预约管理-添加','admin','goods','add','',1,0,'&#xe6a7;','2');
INSERT INTO `yhc_menu` VALUES (21,'预约管理-编辑','admin','goods','edit','',1,0,'&#xe6a7;','2');
INSERT INTO `yhc_menu` VALUES (22,'自定义表单','admin','form','index','',1,1,'&#xe6a7;','2');
INSERT INTO `yhc_menu` VALUES (23,'自定义表单-添加','admin','form','add','',1,0,'&#xe6a7;','2');
INSERT INTO `yhc_menu` VALUES (24,'自定义表单-编辑','admin','form','edit','',1,0,'&#xe6a7;','2');
/*!40000 ALTER TABLE `yhc_menu` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table yhc_order
#

DROP TABLE IF EXISTS `yhc_order`;
CREATE TABLE `yhc_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '#yhc_name#id#',
  `order_no` varchar(30) DEFAULT NULL COMMENT '#yhc_name#订单号#yhc_type#input#yhc_validate#require#',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#购买人#yhc_type#select#yhc_value#{"where":"","table":"user","order":"id desc","field1":"id","field2":"username"}#',
  `money` int(11) DEFAULT NULL COMMENT '#yhc_name#金额#yhc_type#input#',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#预约商品#yhc_type#select#yhc_value#{"where":"is_delete=0","table":"goods","order":"id desc","field1":"id","field2":"name"}#',
  `goods_content` varchar(5000) NOT NULL DEFAULT '' COMMENT '#yhc_name#预约时商品信息#yhc_type#select#yhc_value#{"where":"is_delete=0","table":"goods","order":"id desc","field1":"id","field2":"name"}#',
  `form_content` varchar(10000) NOT NULL DEFAULT '' COMMENT '#yhc_name#自定义字段#yhc_type#input#',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#状态#yhc_type#select#yhc_value#{"1":"待付款","2":"已付款","3":"商家确认","4":"用户确认,交易完成","5":"退款"}#',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#创建时间#yhc_type#laydate#yhc_show#1',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#更新时间#yhc_type#laydate#yhc_show#0',
  `msg` varchar(1000) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table yhc_order
#

LOCK TABLES `yhc_order` WRITE;
/*!40000 ALTER TABLE `yhc_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `yhc_order` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table yhc_user
#

DROP TABLE IF EXISTS `yhc_user`;
CREATE TABLE `yhc_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '#yhc_name#id#',
  `username` varchar(20) DEFAULT NULL COMMENT '#yhc_name#用户名#yhc_type#input#yhc_validate#require#',
  `mobile` varchar(20) DEFAULT NULL COMMENT '#yhc_name#手机号码#yhc_type#input#yhc_validate#require#',
  `openid` varchar(50) DEFAULT NULL COMMENT '#yhc_name#手机号码#yhc_type#input#yhc_validate#require#',
  `nickname` varchar(20) DEFAULT NULL COMMENT '#yhc_name#昵称#yhc_type#input#yhc_show#0',
  `head_img` varchar(300) DEFAULT NULL COMMENT '#yhc_name#昵称#yhc_type#input#yhc_show#0',
  `password` varchar(30) DEFAULT NULL COMMENT '#yhc_name#密码#yhc_type#password#yhc_validate#require#yhc_check#1#',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#创建时间#yhc_type#laydate#yhc_show#1',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#更新时间#yhc_type#laydate#yhc_show#0',
  `salt` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table yhc_user
#

LOCK TABLES `yhc_user` WRITE;
/*!40000 ALTER TABLE `yhc_user` DISABLE KEYS */;
/*!40000 ALTER TABLE `yhc_user` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table yhc_user_case
#

DROP TABLE IF EXISTS `yhc_user_case`;
CREATE TABLE `yhc_user_case` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '#yhc_name#id#',
  `title` varchar(200) DEFAULT NULL COMMENT '#yhc_name#标题#yhc_type#input#yhc_validate#require#',
  `desc` varchar(5000) DEFAULT NULL COMMENT '#yhc_name#内容#yhc_type#textarea#yhc_validate#require#',
  `cate_id` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#分类#yhc_type#select#yhc_value#{"where":"is_delete=0","table":"cate","order":"id desc","field1":"id","field2":"name"}#',
  `camera_id` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#关联摄影师#yhc_type#select#yhc_value#{"where":"is_show=0","table":"camera","order":"id desc","field1":"id","field2":"name"}#',
  `img` int(11) DEFAULT NULL COMMENT '#yhc_name#缩略图#yhc_type#uploadimg#yhc_validate#require#',
  `content` longtext COMMENT '#yhc_name#案例详情#yhc_type#textarea#yhc_validate#require#yhc_editor#ue#',
  `sort` int(11) DEFAULT NULL COMMENT '#yhc_name#排序#yhc_type#input#yhc_validate#number#',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#创建时间#yhc_type#laydate#yhc_show#1',
  `update_time` int(11) NOT NULL DEFAULT '0' COMMENT '#yhc_name#更新时间#yhc_type#laydate#yhc_show#0',
  `is_show` int(1) NOT NULL DEFAULT '0' COMMENT '#yhc_name#状态#yhc_type#select#yhc_value#{"0":"显示","1":"不显示"}#',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table yhc_user_case
#

LOCK TABLES `yhc_user_case` WRITE;
/*!40000 ALTER TABLE `yhc_user_case` DISABLE KEYS */;
INSERT INTO `yhc_user_case` VALUES (15,'个人摄影案例','个人摄影案例',5,0,2,NULL,10,1571846558,1572006066,0);
INSERT INTO `yhc_user_case` VALUES (16,'sdf','dfsda',5,0,1,NULL,10,1571924148,1571924155,0);
/*!40000 ALTER TABLE `yhc_user_case` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table yhc_webconfig
#

DROP TABLE IF EXISTS `yhc_webconfig`;
CREATE TABLE `yhc_webconfig` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '#yhc_name#id#',
  `title` varchar(200) NOT NULL DEFAULT '' COMMENT '#yhc_name#网站名称#yhc_type#input#yhc_validate#require#',
  `address` varchar(200) NOT NULL DEFAULT '' COMMENT '#yhc_name#地址#yhc_type#input#',
  `copyright` varchar(500) NOT NULL DEFAULT '' COMMENT '#yhc_name#版权#yhc_type#input#',
  `phone` varchar(200) DEFAULT NULL COMMENT '#yhc_name#联系电话#yhc_type#input#',
  `qq` char(255) NOT NULL DEFAULT '' COMMENT '#yhc_name#联系QQ#yhc_type#input#',
  `is_limit` tinyint(1) NOT NULL DEFAULT '1' COMMENT '#yhc_name#关闭网站#yhc_type#switch#yhc_value#{"1":"是","0":"否"}#yhc_show#1',
  `min_size` int(11) NOT NULL DEFAULT '1' COMMENT '#yhc_name#最小上传（M）#yhc_type#input#',
  `max_size` int(11) NOT NULL DEFAULT '1' COMMENT '#yhc_name#最大上传（M）#yhc_type#input#',
  `money` int(11) NOT NULL DEFAULT '0',
  `money1` int(11) NOT NULL DEFAULT '0',
  `money2` int(11) NOT NULL DEFAULT '0',
  `ps_no` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Dumping data for table yhc_webconfig
#

LOCK TABLES `yhc_webconfig` WRITE;
/*!40000 ALTER TABLE `yhc_webconfig` DISABLE KEYS */;
INSERT INTO `yhc_webconfig` VALUES (1,'摄影预约','河南省郑州市','豫ICP备17005265号-1','15639068085','445727994@qq.com',0,1,3,18,0,0,'图片正在制作中，请耐心等待');
/*!40000 ALTER TABLE `yhc_webconfig` ENABLE KEYS */;
UNLOCK TABLES;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
