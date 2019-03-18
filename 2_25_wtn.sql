# Host: localhost  (Version: 5.5.53)
# Date: 2019-03-04 16:41:36
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "ddsc_admin"
#

DROP TABLE IF EXISTS `ddsc_admin`;
CREATE TABLE `ddsc_admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `pwd` varchar(255) DEFAULT NULL,
  `pretime` datetime DEFAULT NULL,
  `curtime` datetime DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL COMMENT '登录IP',
  `level` int(11) NOT NULL DEFAULT '0' COMMENT '管理员类型 0超级管理员 1普通管理员',
  `control` text COMMENT '控制器权限',
  `way` text COMMENT '方法',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "ddsc_admin"
#

/*!40000 ALTER TABLE `ddsc_admin` DISABLE KEYS */;
INSERT INTO `ddsc_admin` VALUES (1,'admin','8a30ec6807f71bc69d096d8e4d501ade','2019-03-01 10:57:26','2019-03-04 09:26:56','0.0.0.0',0,NULL,NULL);
/*!40000 ALTER TABLE `ddsc_admin` ENABLE KEYS */;

#
# Structure for table "ddsc_carte"
#

DROP TABLE IF EXISTS `ddsc_carte`;
CREATE TABLE `ddsc_carte` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(255) DEFAULT NULL COMMENT '模块名称',
  `c_modul` varchar(255) DEFAULT NULL COMMENT '控制器',
  `c_icon` varchar(255) DEFAULT NULL COMMENT '图标',
  `pid` int(11) DEFAULT NULL COMMENT '上级id',
  `c_sort` int(11) NOT NULL DEFAULT '50' COMMENT '排序',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "ddsc_carte"
#

/*!40000 ALTER TABLE `ddsc_carte` DISABLE KEYS */;
INSERT INTO `ddsc_carte` VALUES (1,'网站设置','Sys','fa-desktop',0,1),(2,'基本信息','seting','',1,50),(3,'网站优化','seo','',1,50),(4,'广告管理','Lb','fa-picture-o',0,2),(5,'广告列表','lister','',4,50),(6,'广告位','place','',4,50),(13,'菜单管理','Carte','fa-reorder',0,3),(14,'后台模板','lister','',13,50),(16,'管理员管理','User','fa-user',0,4),(17,'管理员列表','lister','',16,50),(19,'会员管理','Member','fa-address-book-o',0,5),(20,'会员列表','lister','',19,50),(34,'日志管理','Logs','fa-book',0,12),(36,'后台登录日志','index','',34,50),(39,'订单管理','Dd','fa-paper-plane',0,7),(40,'待付款订单','dai_dd','',39,50),(41,'待发货订单','fa_dd','',39,50),(42,'待收货订单','shou_dd','',39,50),(43,'待评价订单','ping_dd','',39,50),(44,'已完成订单','wan_dd','',39,50),(45,'商品管理','Goods','fa-map-signs',0,6),(46,'商品列表','lister','',45,50),(47,'商品分类','type','',45,50),(48,'评论管理','Assess','fa-area-chart',0,50),(49,'会员折扣','Agio','fa-heart',0,8),(50,'会员折扣','lister','',49,50),(51,'合伙人分红','index','',49,50),(52,'公益金','fund','',49,50),(53,'合伙人等级','level','',49,50),(58,'未审核评论','lister','',48,50),(59,'已审核评论','index','',48,50),(60,'推荐奖励金','bonus','',49,50),(61,'提现管理','balance','',19,50),(62,'意见反馈','Message','fa-desktop',0,50),(63,'反馈列表','lister','',62,50),(64,'合伙人申请列表','Cobber','fa-bullhorn',0,50),(65,'未付款列表','index','',64,50),(66,'已付款列表','lister','',64,50),(67,'申请退货列表','tui_dd','',39,50),(68,'已退货列表','ytui_dd','',39,50),(69,'店铺管理','Shop','fa-flag',0,50),(70,'店铺列表','lister','',69,50),(71,'待审核商品','index','',45,50);
/*!40000 ALTER TABLE `ddsc_carte` ENABLE KEYS */;

#
# Structure for table "ddsc_goods"
#

DROP TABLE IF EXISTS `ddsc_goods`;
CREATE TABLE `ddsc_goods` (
  `gid` int(11) NOT NULL AUTO_INCREMENT COMMENT '商品id',
  `g_name` varchar(255) DEFAULT NULL COMMENT '商品名称',
  `g_xprice` float(16,2) NOT NULL DEFAULT '0.00' COMMENT '商品现价',
  `g_sales` int(11) NOT NULL DEFAULT '0' COMMENT '销量',
  `g_kc` int(11) DEFAULT NULL COMMENT '库存',
  `g_content` text COMMENT '商品详情',
  `g_up` tinyint(1) NOT NULL DEFAULT '0' COMMENT '商品状态 0下架 1上架',
  `g_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '首页显示 0否 1是',
  `g_sort` int(11) NOT NULL DEFAULT '0' COMMENT '排序',
  `g_image` varchar(255) DEFAULT NULL COMMENT '商品图片',
  `fid` int(11) DEFAULT NULL COMMENT '所属分类id',
  `spec` text COMMENT '商品规格',
  `desc` varchar(255) DEFAULT NULL COMMENT '商品描述',
  `tag` varchar(255) DEFAULT NULL COMMENT '商品标签',
  `g_images` varchar(255) DEFAULT NULL COMMENT '首页推荐图',
  `shopid` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `g_freight` float(16,2) NOT NULL DEFAULT '0.00' COMMENT '运费',
  `g_audi` tinyint(3) NOT NULL DEFAULT '1' COMMENT '是否审核 0否 1是',
  `g_thumb` varchar(255) DEFAULT NULL COMMENT '推荐图125',
  PRIMARY KEY (`gid`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

#
# Data for table "ddsc_goods"
#

/*!40000 ALTER TABLE `ddsc_goods` DISABLE KEYS */;
INSERT INTO `ddsc_goods` VALUES (2,'测试11',22.00,1,222,'<p><img src=\"/ueditor/php/upload/image/20190226/1551164001.png\" title=\"1551164001.png\" alt=\"17051971672_1200x799.png\"/></p>',1,1,50,'/uploads/20190228/e3e64b25d62d037b3fedae1244437b94.png',1,'','商品描述','标签1@标签2','/thumb/5c774f6a195e40.52800350.jpg',0,0.00,1,'/thumb/cd8ab9d7637859a571d2f4fc3fda9c69.jpg'),(3,'测试11',12.00,2,222,'<p><img src=\"/ueditor/php/upload/image/20190226/1551164001.png\" title=\"1551164001.png\" alt=\"17051971672_1200x799.png\"/></p>',1,1,50,'/uploads/20190228/4008214c7a9306c52ab6b801ef25ae57.png',1,'','商品描述','标签1@标签2','/thumb/5c774f6090dd47.62358795.jpg',0,0.00,1,'/thumb/22df999604d98394b0ae33dde22b07c1.jpg'),(4,'测试11',25.00,3,222,'<p><img src=\"/ueditor/php/upload/image/20190226/1551164001.png\" title=\"1551164001.png\" alt=\"17051971672_1200x799.png\"/></p>',1,1,50,'/uploads/20190228/26e5dd8fd554cf3197fa1d7d7579d438.png',1,'','商品描述','标签1@标签2','/thumb/5c774f57d49d16.11538929.jpg',0,0.00,1,'/thumb/26e22d53778cd27ced003ff58f8bad1a.jpg'),(5,'测试11',23.00,4,222,'<p><img src=\"/ueditor/php/upload/image/20190226/1551164001.png\" title=\"1551164001.png\" alt=\"17051971672_1200x799.png\"/></p>',1,1,50,'/uploads/20190228/91bc12bb2a6ff0ae9e05fbadb03822e8.png',1,'','商品描述','标签1@标签2','/thumb/5c774f4bdbc551.04242419.jpg',0,0.00,1,'/thumb/f3833c7e664c7ce6fc382506ad4fca40.jpg'),(6,'测试11',52.00,5,222,'<p><img src=\"/ueditor/php/upload/image/20190226/1551164001.png\" title=\"1551164001.png\" alt=\"17051971672_1200x799.png\"/></p>',1,0,50,'/uploads/20190226/8ae1351c885e70415d1c7ed3ee6232f4.png',2,'','商品描述','标签1@标签2','/thumb/5c74e64919bfd8.34573971.jpg',2,0.00,1,'/thumb/c53cf642af87222f7dec9f5d5b6d2bf9.jpg'),(7,'测试11',45.00,6,222,'<p><img src=\"/ueditor/php/upload/image/20190226/1551164001.png\" title=\"1551164001.png\" alt=\"17051971672_1200x799.png\"/></p>',1,0,50,'/uploads/20190226/8ae1351c885e70415d1c7ed3ee6232f4.png',2,'','商品描述','标签1@标签2','/thumb/5c74e64919bfd8.34573971.jpg',2,0.00,1,'/thumb/c53cf642af87222f7dec9f5d5b6d2bf9.jpg'),(8,'测试11',57.00,7,222,'<p><img src=\"/ueditor/php/upload/image/20190226/1551164001.png\" title=\"1551164001.png\" alt=\"17051971672_1200x799.png\"/></p>',1,0,50,'/uploads/20190226/8ae1351c885e70415d1c7ed3ee6232f4.png',2,'','商品描述','标签1@标签2','/thumb/5c74e64919bfd8.34573971.jpg',2,0.00,1,'/thumb/c53cf642af87222f7dec9f5d5b6d2bf9.jpg'),(9,'测试11',456.00,8,222,'<p><img src=\"/ueditor/php/upload/image/20190226/1551164001.png\" title=\"1551164001.png\" alt=\"17051971672_1200x799.png\"/></p>',1,0,50,'/uploads/20190226/8ae1351c885e70415d1c7ed3ee6232f4.png',2,'','商品描述','标签1@标签2','/thumb/5c74e64919bfd8.34573971.jpg',2,0.00,1,'/thumb/c53cf642af87222f7dec9f5d5b6d2bf9.jpg'),(10,'测试11',5454.00,9,222,'<p><img src=\"/ueditor/php/upload/image/20190226/1551164001.png\" title=\"1551164001.png\" alt=\"17051971672_1200x799.png\"/></p>',1,0,50,'/uploads/20190226/8ae1351c885e70415d1c7ed3ee6232f4.png',3,'','商品描述','标签1@标签2','/thumb/5c74e64919bfd8.34573971.jpg',2,0.00,1,'/thumb/c53cf642af87222f7dec9f5d5b6d2bf9.jpg'),(17,'测试11',231.00,10,222,'<p><img src=\"/ueditor/php/upload/image/20190226/1551164001.png\" title=\"1551164001.png\" alt=\"17051971672_1200x799.png\"/></p>',1,1,50,'/uploads/20190228/24571df92ed07f927c62843e720e3e50.png',3,'','商品描述','标签1@标签2','/thumb/5c774f4256d331.23641077.jpg',0,0.00,1,'/thumb/c53cf642af87222f7dec9f5d5b6d2bf9.jpg'),(18,'就的撒恐龙当家',111.00,1111,111,'<p><img src=\"/ueditor/php/upload/image/20190227/1551238744.png\" title=\"1551238744.png\" alt=\"8842d10cb9a04371f43452b69fd19e0a.png\"/></p>',1,1,50,'/uploads/20190228/ac22e809d97b9b0c7c90c0c8f8b5180b.png',3,NULL,'商品描述','标签1@标签2','/thumb/5c774f29465c97.34530779.jpg',0,0.00,1,'/thumb/0987b3b1fd48498e517ae3f4fb0a21f9.jpg'),(19,'个梵蒂冈',11111.00,111,111,'<p>是非得失</p>',1,1,50,'/uploads/20190228/9242cc228bde23d8c2aa4bb37ef72592.png',3,NULL,'商品描述','标签1@标签2','/thumb/5c774f7793df06.47104837.jpg',2,0.00,1,'/thumb/41d354d9b6ac98e54aa58c7de88b0082.jpg');
/*!40000 ALTER TABLE `ddsc_goods` ENABLE KEYS */;

#
# Structure for table "ddsc_goods_img"
#

DROP TABLE IF EXISTS `ddsc_goods_img`;
CREATE TABLE `ddsc_goods_img` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `image` varchar(255) DEFAULT NULL COMMENT '图片',
  `g_id` int(11) DEFAULT NULL COMMENT '商品id',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `i_status` tinyint(3) NOT NULL DEFAULT '0',
  `thumb` varchar(255) DEFAULT NULL COMMENT '缩略图',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品多图';

#
# Data for table "ddsc_goods_img"
#

/*!40000 ALTER TABLE `ddsc_goods_img` DISABLE KEYS */;
INSERT INTO `ddsc_goods_img` VALUES (1,'/uploads/20190226/4c30067a1abb79abf9c59d783388d83d.png',1,NULL,1,NULL);
/*!40000 ALTER TABLE `ddsc_goods_img` ENABLE KEYS */;

#
# Structure for table "ddsc_goods_spec"
#

DROP TABLE IF EXISTS `ddsc_goods_spec`;
CREATE TABLE `ddsc_goods_spec` (
  `sid` int(11) NOT NULL AUTO_INCREMENT,
  `g_id` int(11) DEFAULT NULL COMMENT '商品id',
  `s_name` varchar(255) DEFAULT NULL COMMENT '规格名称',
  `s_xprice` float(16,2) DEFAULT NULL COMMENT '价格',
  `s_sort` int(11) DEFAULT NULL COMMENT '排序',
  `s_image` varchar(255) DEFAULT NULL COMMENT '图片',
  `s_status` tinyint(1) NOT NULL DEFAULT '0' COMMENT '规格状态 0禁用 1启用',
  PRIMARY KEY (`sid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品规格';

#
# Data for table "ddsc_goods_spec"
#

/*!40000 ALTER TABLE `ddsc_goods_spec` DISABLE KEYS */;
INSERT INTO `ddsc_goods_spec` VALUES (1,1,'规格1',100.00,NULL,'/uploads/20190226/89737924e1f3d9ee0c4528b716e36b2f.png',1);
/*!40000 ALTER TABLE `ddsc_goods_spec` ENABLE KEYS */;

#
# Structure for table "ddsc_hot"
#

DROP TABLE IF EXISTS `ddsc_hot`;
CREATE TABLE `ddsc_hot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shopid` int(11) NOT NULL DEFAULT '0' COMMENT '店铺id',
  `name` varchar(255) DEFAULT NULL COMMENT '热门推荐',
  `status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '0关闭 1开启',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='店铺热门推荐';

#
# Data for table "ddsc_hot"
#

/*!40000 ALTER TABLE `ddsc_hot` DISABLE KEYS */;
/*!40000 ALTER TABLE `ddsc_hot` ENABLE KEYS */;

#
# Structure for table "ddsc_lb"
#

DROP TABLE IF EXISTS `ddsc_lb`;
CREATE TABLE `ddsc_lb` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fid` int(11) DEFAULT NULL COMMENT '父类id',
  `name` varchar(255) DEFAULT NULL COMMENT '名称',
  `sort` int(11) DEFAULT NULL COMMENT '排序',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态0关闭 1开启',
  `url` varchar(255) DEFAULT NULL,
  `desc` text COMMENT '简介',
  `image` varchar(255) DEFAULT NULL COMMENT '图片',
  `thumb` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='广告列表';

#
# Data for table "ddsc_lb"
#

/*!40000 ALTER TABLE `ddsc_lb` DISABLE KEYS */;
INSERT INTO `ddsc_lb` VALUES (1,1,'如何查询为取快递',50,1,'','<p>如何查询为取快递如何查询为取快递如何查询为取快递如何查询为取快递如何查询为取快递如何查询为取快递</p>',NULL,NULL),(2,2,'寄快递如何下单',50,1,'','<p>寄快递如何下单寄快递如何下单寄快递如何下单寄快递如何下单寄快递如何下单</p>',NULL,NULL),(3,2,'如何支付运费',50,1,'','<p>如何支付运费如何支付运费如何支付运费如何支付运费如何支付运费如何支付运费如何支付运费如何支付运费如何支付运费</p>',NULL,NULL),(4,3,'banner',50,1,'','','/uploads/20190228/3f943c45fc09d29b01eed0ffe94605ad.png',NULL),(5,3,'banner',50,1,'','','/uploads/20190228/a3e900c27e097d73976785ec9f299055.png',NULL),(6,4,'海报',50,1,'','','/uploads/20190228/4d1d95c5c510e2d6860c22d7a90b61fe.png',NULL),(7,5,'banner',50,1,'','','/uploads/20190228/97d00315ef69824ee1b94a615d417a60.png',NULL);
/*!40000 ALTER TABLE `ddsc_lb` ENABLE KEYS */;

#
# Structure for table "ddsc_lb_place"
#

DROP TABLE IF EXISTS `ddsc_lb_place`;
CREATE TABLE `ddsc_lb_place` (
  `pl_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '轮播id',
  `pl_name` varchar(255) DEFAULT NULL COMMENT '位置名称',
  PRIMARY KEY (`pl_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='广告位';

#
# Data for table "ddsc_lb_place"
#

/*!40000 ALTER TABLE `ddsc_lb_place` DISABLE KEYS */;
INSERT INTO `ddsc_lb_place` VALUES (1,'帮助中心取快递'),(2,'帮助中心寄快递'),(3,'首页banner'),(4,'首页海报'),(5,'更多优惠banner');
/*!40000 ALTER TABLE `ddsc_lb_place` ENABLE KEYS */;

#
# Structure for table "ddsc_seo"
#

DROP TABLE IF EXISTS `ddsc_seo`;
CREATE TABLE `ddsc_seo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL COMMENT '首页标题',
  `keywords` varchar(255) DEFAULT NULL COMMENT 'seo关键词',
  `description` text COMMENT 'seo描述',
  `copy` text COMMENT '版权信息',
  `code` text COMMENT '统计代码',
  `support` varchar(255) DEFAULT NULL COMMENT '技术支持',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='网站优化';

#
# Data for table "ddsc_seo"
#

/*!40000 ALTER TABLE `ddsc_seo` DISABLE KEYS */;
INSERT INTO `ddsc_seo` VALUES (1,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `ddsc_seo` ENABLE KEYS */;

#
# Structure for table "ddsc_shop"
#

DROP TABLE IF EXISTS `ddsc_shop`;
CREATE TABLE `ddsc_shop` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '店铺名称',
  `logo` varchar(255) DEFAULT NULL COMMENT '店铺logo',
  `content` text COMMENT '店铺简介',
  `addtime` datetime DEFAULT NULL COMMENT '添加时间',
  `phone` varchar(255) DEFAULT NULL COMMENT '手机号码',
  `username` char(20) DEFAULT NULL COMMENT '账号',
  `pwd` char(20) DEFAULT NULL COMMENT '登录密码',
  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态 0关闭 1开启',
  `goods_status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '商品免审核 0否 1是',
  `image` varchar(255) DEFAULT NULL COMMENT '店铺banner',
  `follow` int(11) NOT NULL DEFAULT '0' COMMENT '关注数量',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COMMENT='店铺列表';

#
# Data for table "ddsc_shop"
#

/*!40000 ALTER TABLE `ddsc_shop` DISABLE KEYS */;
INSERT INTO `ddsc_shop` VALUES (2,'测试案例11','/uploads/20190226/9dfb1dc67a60a3d52914a3c1aae47aae.png','<p><img src=\"/ueditor/php/upload/image/20190227/1551239645.png\" title=\"1551239645.png\" alt=\"238497764497162650.png\"/></p>','2019-02-26 11:41:09','15939590206','zhangsan','666666',1,0,'/uploads/20190228/c8402f9f5b5a4b99a8e5df9eaa2eb641.png',0);
/*!40000 ALTER TABLE `ddsc_shop` ENABLE KEYS */;

#
# Structure for table "ddsc_sys"
#

DROP TABLE IF EXISTS `ddsc_sys`;
CREATE TABLE `ddsc_sys` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT '公司名称',
  `username` varchar(255) DEFAULT NULL COMMENT '负责人',
  `url` varchar(255) DEFAULT NULL COMMENT '网站域名',
  `qq` char(20) DEFAULT NULL COMMENT '客服QQ',
  `icp` varchar(255) DEFAULT NULL COMMENT 'icp备案号',
  `email` varchar(255) DEFAULT NULL COMMENT '邮箱',
  `tel` varchar(255) DEFAULT NULL COMMENT '固定电话',
  `phone` char(11) DEFAULT NULL COMMENT '手机号码',
  `longs` varchar(255) DEFAULT NULL COMMENT '经度',
  `lats` varchar(255) DEFAULT NULL COMMENT '纬度',
  `addr` varchar(255) DEFAULT NULL COMMENT '公司地址',
  `content` text COMMENT '公司简介',
  `pclogo` varchar(255) DEFAULT NULL COMMENT '电脑端logo',
  `waplogo` varchar(255) DEFAULT NULL COMMENT '手机端logo',
  `qrcode` varchar(255) DEFAULT NULL COMMENT '微信二维码',
  `wx` varchar(255) DEFAULT NULL COMMENT '微信公众号',
  `fax` varchar(255) DEFAULT NULL COMMENT '公司传真',
  `telphone` varchar(255) DEFAULT NULL COMMENT '400电话',
  `follow` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='网站基本信息';

#
# Data for table "ddsc_sys"
#

/*!40000 ALTER TABLE `ddsc_sys` DISABLE KEYS */;
INSERT INTO `ddsc_sys` VALUES (1,'威特浓网络科技','','','','','','','','','','','<p>关于我们啊关于我们啊关于我们啊关于我们啊关于我们啊关于我们啊关于我们啊关于我们啊关于我们啊关于我们啊关于我们啊关于我们啊</p>','/uploads/20190301/790436fdff3b5ebab4f3979d993ff901.jpg','/uploads/20190228/9796e98f454a863a18ec19058b9c957d.png',NULL,NULL,'','',0);
/*!40000 ALTER TABLE `ddsc_sys` ENABLE KEYS */;

#
# Structure for table "ddsc_sys_log"
#

DROP TABLE IF EXISTS `ddsc_sys_log`;
CREATE TABLE `ddsc_sys_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(255) DEFAULT NULL COMMENT '类型',
  `time` datetime DEFAULT NULL COMMENT '操作时间',
  `admin` varchar(255) DEFAULT NULL COMMENT '操作账号',
  `ip` varchar(255) DEFAULT NULL COMMENT 'IP地址',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=50 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='系统日志';

#
# Data for table "ddsc_sys_log"
#

/*!40000 ALTER TABLE `ddsc_sys_log` DISABLE KEYS */;
INSERT INTO `ddsc_sys_log` VALUES (1,'后台登录','2018-12-22 09:13:43','admin','0.0.0.0'),(2,'后台登录','2018-12-24 08:56:23','admin','0.0.0.0'),(3,'后台登录','2018-12-25 10:14:19','admin','0.0.0.0'),(4,'后台登录','2018-12-26 09:34:44','admin','0.0.0.0'),(5,'后台登录','2018-12-27 08:52:04','admin','0.0.0.0'),(6,'后台登录','2018-12-28 08:45:16','admin','0.0.0.0'),(7,'后台登录','2018-12-28 14:22:55','admin','0.0.0.0'),(8,'后台登录','2018-12-28 16:32:44','admin','192.168.101.21'),(9,'后台登录','2018-12-28 19:10:19','admin','1.192.38.201'),(10,'后台登录','2018-12-28 19:49:42','admin','1.192.38.201'),(11,'后台登录','2018-12-29 09:22:51','admin','1.192.38.201'),(12,'后台登录','2018-12-29 16:40:56','admin','1.192.38.201'),(13,'后台登录','2019-01-02 18:08:25','admin','123.161.219.133'),(14,'后台登录','2019-01-03 10:12:59','admin','123.161.219.133'),(15,'后台登录','2019-01-03 13:44:12','admin','123.161.219.133'),(16,'后台登录','2019-01-03 13:45:38','admin','123.161.219.133'),(17,'后台登录','2019-01-03 15:03:05','admin','123.161.219.133'),(18,'后台登录','2019-01-03 16:31:47','admin','123.161.219.133'),(19,'后台登录','2019-01-03 16:34:34','admin','123.161.219.133'),(20,'后台登录','2019-01-03 16:43:33','admin','123.161.219.133'),(21,'后台登录','2019-01-03 17:54:15','admin','123.161.219.133'),(22,'后台登录','2019-01-03 19:21:46','admin','123.161.219.133'),(23,'后台登录','2019-01-03 19:31:49','admin','123.161.219.133'),(24,'后台登录','2019-01-04 09:05:50','admin','123.161.219.211'),(25,'后台登录','2019-01-04 10:39:14','admin','123.161.219.211'),(26,'后台登录','2019-01-04 11:36:49','admin','123.161.219.211'),(27,'后台登录','2019-01-04 16:26:33','admin','123.161.219.211'),(28,'后台登录','2019-01-04 16:40:28','admin','123.161.219.211'),(29,'后台登录','2019-01-04 18:14:45','admin','123.161.219.211'),(30,'后台登录','2019-01-05 15:42:25','admin','123.161.219.211'),(31,'后台登录','2019-01-05 17:38:27','admin','123.161.219.211'),(32,'后台登录','2019-01-06 16:10:51','admin','125.46.76.18'),(33,'后台登录','2019-01-07 14:21:16','admin','123.161.219.217'),(34,'后台登录','2019-01-07 16:33:02','admin','123.161.219.217'),(35,'后台登录','2019-01-07 16:33:52','admin','123.161.219.217'),(36,'后台登录','2019-01-08 10:40:12','admin','123.161.219.217'),(37,'后台登录','2019-01-08 14:10:22','admin','115.60.50.253'),(38,'后台登录','2019-01-09 09:13:04','admin','0.0.0.0'),(39,'后台登录','2019-02-26 09:28:33','admin','127.0.0.1'),(40,'后台登录','2019-02-26 09:36:16','admin','127.0.0.1'),(41,'后台登录','2019-02-26 09:36:35','admin','127.0.0.1'),(42,'后台登录','2019-02-27 08:56:24','admin','127.0.0.1'),(43,'后台登录','2019-02-27 10:01:42','zhangsan','127.0.0.1'),(44,'后台登录','2019-02-27 10:09:10','zhangsan','127.0.0.1'),(45,'后台登录','2019-02-28 09:04:00','admin','192.168.101.181'),(46,'后台登录','2019-02-28 10:13:41','admin','0.0.0.0'),(47,'后台登录','2019-03-01 10:57:26','admin','0.0.0.0'),(48,'后台登录','2019-03-04 09:26:57','admin','0.0.0.0'),(49,'后台登录','2019-03-04 09:42:51','zhangsan','0.0.0.0');
/*!40000 ALTER TABLE `ddsc_sys_log` ENABLE KEYS */;

#
# Structure for table "ddsc_type"
#

DROP TABLE IF EXISTS `ddsc_type`;
CREATE TABLE `ddsc_type` (
  `type_id` int(11) NOT NULL AUTO_INCREMENT,
  `type_name` varchar(255) DEFAULT NULL COMMENT '分类名称',
  `type_image` varchar(255) DEFAULT NULL COMMENT '分类图标',
  `type_sort` int(11) NOT NULL DEFAULT '50',
  PRIMARY KEY (`type_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='商品分类';

#
# Data for table "ddsc_type"
#

/*!40000 ALTER TABLE `ddsc_type` DISABLE KEYS */;
INSERT INTO `ddsc_type` VALUES (1,'干果',NULL,1),(2,'饮品',NULL,2),(3,'生鲜',NULL,3);
/*!40000 ALTER TABLE `ddsc_type` ENABLE KEYS */;

#
# Structure for table "ddsc_user"
#

DROP TABLE IF EXISTS `ddsc_user`;
CREATE TABLE `ddsc_user` (
  `uid` int(11) NOT NULL AUTO_INCREMENT,
  `nickname` varchar(255) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '昵称',
  `time` varchar(255) DEFAULT NULL COMMENT '注册时间',
  `image` text COMMENT '头像',
  `openid` varchar(255) DEFAULT NULL COMMENT '用户的openID',
  `card` varchar(255) NOT NULL DEFAULT '' COMMENT '二维码',
  `fid` int(11) NOT NULL DEFAULT '0' COMMENT '上级id',
  `phone` varchar(20) NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='用户列表';

#
# Data for table "ddsc_user"
#

/*!40000 ALTER TABLE `ddsc_user` DISABLE KEYS */;
INSERT INTO `ddsc_user` VALUES (6,'undefined','1546515068','https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKfEYmJxXZEosKcVvzGHVYnnUnOHTPJLLxV4lO6FHCtUIK3pCM9xyibTFMibQrFUZamJ7O38KZroMibw/132','oavnG5WISrylGvxgrPvYGxxCkYXY','',0,''),(7,'小丑','1546515072','https://wx.qlogo.cn/mmopen/vi_32/XibbFRzOVauS5ibPGxv4ialrvJbZYyMPweZtY7Gmh1nXQtibVxjjmxtozhtFvm3rHjbRgIAmRa0ULzLGq4NDIHlZ3A/132','oavnG5TQsodsid-DFLD9YPjkDQw0','uploads/5c77418222402.jpg',0,''),(8,'蓝色忧恋','1546762542','https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTITmSMvjMPVibib22afCkr7PvBZuL8AjmGZ3D0ibl5xSujyo8zTu4XRNNjyiaVlGPNZ45RteABicCXzqicg/132','oavnG5Yv9gWuN0_vxz2U3dpUb19w','uploads/5c2ecdad2f22d.jpg',0,''),(9,'张华华','1546565288','https://wx.qlogo.cn/mmopen/vi_32/ryibeEJsmM1XIYwtd9uHzjiat1oEzQVPIckTEODMyxZNUiaTS1DEusuRNzibw1zyAlozZaSmticsW55yVWR1LbXOVtw/132','oavnG5X2e03Uc0ej2GyO26fW942c','',0,''),(10,'Dy','1546564075','https://wx.qlogo.cn/mmopen/vi_32/TZbZyhmoicTgzK9fvRSmKiaeUlXF0ChHKTASHicNFiaDS71VwfZiczibbt6vibnKUDc7Nw1IkxT2ZEjicWU739VovoBKOg/132','oavnG5SfpILozlXBPVvEKy_mAXGA','',0,''),(11,'二  月  半  ','1546564076','https://wx.qlogo.cn/mmopen/vi_32/PiajxSqBRaEIjr3P73Vz7hPiaoTh8cFEjic2GPsjNIicYHy5X965ofiaMtjPxm56qoJ85qfavjlzEp1QlydiayhEBfaw/132','oavnG5d3urNSy6RXmLZlKRnwj8As','',0,''),(12,'小程序开发-李宜润','1546564219','https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTI7hsTibhnpQP1zy3f5ibHiaSeLQImewaFWGNTXVd1ohdFggLKUdxmBamk3F7wiaMibOdcL5rNNjXz7ZzQ/132','oavnG5dcq7x2BHZfYF2aXs8vR2yg','',0,''),(14,'꧁༺神仙姐姐༻꧂','1546564635','https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83erDib7UWDQ2rf5QAGaNtKrIFj7s30b0fPm8dtVIKlrx3vA9OXcJ6cTMd8tDJbs3OFaJUgkR8FJBY5w/132','oavnG5SWW3GiP9pJchCe7wQq8vGs','',0,''),(15,'二 月 半','1546564688','https://wx.qlogo.cn/mmopen/vi_32/w1ZLcpJat76Ce4WTEREibRpic4tANgASQmPPXDUeQ3gW4qLd8G4aArZOPzaWOIQib1oe3polgSAmcPMUbh1y4AmsA/132','oavnG5X8ZkK3Y_UmnHb9bITRrdZU','',0,''),(16,'暗语寒飞','1546566497','https://wx.qlogo.cn/mmopen/vi_32/uRNqembZfqScc8ChWjJSrrT0ry4iaKHiazAdNZ7wWAicdctViaAldDFEvxUR8icC1ia7RSt313SnAiaBvruVrqyvxBUag/132','oavnG5WPAWFwsmfSXWy4OimgJ7Rc','',0,''),(17,'Sion_ren','1546592500','https://wx.qlogo.cn/mmopen/vi_32/xSGbqic7K70FX3B7ytAulRdOdaAyv6pVX1IAK8z6B3zBU6KY2FMcv6ePvGIibX3IXicWnTnq9OzF0Hzuz0kR9fic1g/132','oavnG5RyPfhforZ_NWS7QTGZ8FXA','',0,''),(18,'ECHO?','1546570825','https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83erMia4m1Th04W2fzKZlpNviaQr5OIZ2Gcl5KFG1680TBs2ufCartBJefyN7L3NicFDwSPvMPjGtTPwFA/132','oavnG5dNy-r9qL98b7rEE9RUqNLU','',0,''),(22,'小幸运?','1546593249','https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83eo5ibyDUBLLUof40Av2jzmjPfunbjodv4ngnv7opYgiayYpAFIDIjtQ7cjQicvTQpZstc3cTsCR8iaZAw/132','oavnG5ahpimi-dPmXp0xOtKRe6w4','uploads/5c2f3f0536d0b.jpg',19,''),(23,'朵朵科技客服','1546602293','https://wx.qlogo.cn/mmopen/vi_32/ExNCPyFI9bEdzycydFPt42UvFVVu5jAMicgyUCXibxQtqH58hyzUnSFicGN9xXtQkxhqeMyHpr7CuFhFWv9icOlalw/132','oavnG5RJEZAm_ZJA-NkCcfa5iDOY','',0,''),(24,'黄淑华','1546672212','https://wx.qlogo.cn/mmhead/0PficMg2FogXRvHibk2kflUuwwNKfWa3dPW4XyvEhx4I4/132','oavnG5SpemrpmIdJi2c2lfngIHEs','',0,''),(25,'江佳原','1546845479','https://wx.qlogo.cn/mmhead/jXwQMoovVc2Wqx5VXHTxZb8rl8P1eia0YFqVvR30Ycw4/132','oavnG5bd_jcN4kHKiIpJDs4HV2Fc','',0,''),(27,'展翅飞翔','1546673228','https://wx.qlogo.cn/mmopen/vi_32/Mtax4H84p1tmwicRuCB3TMkL9ic0V8jcsTtKxISwuvm1F8icaEATuhYa7G7RUBDpPzZCGXx5EOJVa2OdJ0OXLP18A/132','oavnG5XXoVpJhBPzcwtkIsygDQ4Q','',0,''),(29,'润物无声','1546699220','https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKXOhEO7Z5bqTxWVKU9pvXSLoc0uDseu8em6bAX03EMyR0BAWAdJjy32h1B8E7tGajtVibcym406Ig/132','oavnG5V1Xz7PInWmEWo63Gk0Yrdg','uploads/5c30c1de8e248.jpg',0,''),(30,'王嘉德','1546762591','https://wx.qlogo.cn/mmhead/5sEgeNoIv33ocSiaXVR453UF0QrAmr2AsR8zjLkT1GXg/132','oavnG5TmTIcgxY_ccTdQx4DAqA4Y','',0,''),(31,'吴侑秋','1546837164','https://wx.qlogo.cn/mmhead/2Y1MpTicN5NHicJIjfyXrfy7xJCOvSVCMQNNCQ3kJovxo/132','oavnG5ejEcS2dva5tFYOd_t7ScDM','',0,''),(32,'工程孙欣磊15939033083','1546836101','https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTJqpARH71Tth8ZJqACBBjNt3vJ6omDJ9MDZFFmhqbl8p8DdIlWqy0NEe7Mtje8uQgibqFEgKZcXVLg/132','oavnG5TGQ4WrdW2l3HKIbHWoJclo','',0,''),(33,'? ʚ AN. ɞ','1546928843','https://wx.qlogo.cn/mmopen/vi_32/cqjto0CNcUVxgUM4yaT3tlEMeSGticiaZeDA2BxZBriaxibckibKcZ2gzpyL6odOpVOGeeDmcS7w6zy3zia5k0zsfEfA/132','oavnG5WXXsMACMLW2chYsT6yEcoA','uploads/5c34441923d62.jpg',0,''),(34,'黄儒纯','1546924252','https://wx.qlogo.cn/mmhead/y8JI2LH9X0EfpicxbMGWiczD1HB19LNS4OG1WFejTrxibY/132','oavnG5XD-G6DuupnRRvqn6pl7owA','',0,''),(35,'林杰廷','1546926710','https://wx.qlogo.cn/mmhead/5tCU4Bs3tY11Hn7G6YlfGnj0yOuxtNjpqungWFJSabA/132','oavnG5bqxJEttxbMzwTTfMFAGGY8','',0,''),(36,'LY','1546927263','https://wx.qlogo.cn/mmopen/vi_32/DYAIOgq83erspeMzxBQUicdZcqicInP8lmFPiauG5kOsY4fbry5CzTibyc7Sl5TVdQMBeD1uMAKjSw8QsNp635n7aA/132','oavnG5S2AFYRCvD-3VUMGXbJLxs8','uploads/5c344426cafd5.jpg',0,''),(39,'霸鹰','1546929627','https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTKico7yBRca2oEtUDcNqMtPmWiaZJnb5ic3SGjdCyXnmL4wIJBSFhZvCqQpErGzzj4y2bJXohjbLFKjw/132','oavnG5Ri82mDdE1iX1frT4qWPhpE','uploads/5c3445817d443.jpg',0,''),(40,'undefined','1551507986','https://wx.qlogo.cn/mmopen/vi_32/Q0j4TwGTfTIEr2pMqS8rlvoQJ5lTLvqQHkMkfyic3e7sG389z3Y2jLLRc826OwbeyGS996PwpAEsqYN7dSziabKA/132','oplp45O53yD8wllMav30LpsuEDps','',0,'');
/*!40000 ALTER TABLE `ddsc_user` ENABLE KEYS */;
