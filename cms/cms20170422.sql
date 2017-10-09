-- MySQL dump 10.16  Distrib 10.1.13-MariaDB, for Win32 (AMD64)
--
-- Host: localhost    Database: cms
-- ------------------------------------------------------
-- Server version	10.1.13-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `cms_admin`
--

DROP TABLE IF EXISTS `cms_admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_admin` (
  `admin_id` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(20) NOT NULL DEFAULT '',
  `password` varchar(32) NOT NULL DEFAULT '',
  `lastloginip` varchar(15) DEFAULT '0',
  `lastlogintime` int(10) unsigned DEFAULT '0',
  `email` varchar(40) DEFAULT '',
  `realname` varchar(50) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`admin_id`),
  KEY `username` (`username`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_admin`
--

LOCK TABLES `cms_admin` WRITE;
/*!40000 ALTER TABLE `cms_admin` DISABLE KEYS */;
INSERT INTO `cms_admin` VALUES (3,'aa','asdf','0',0,'','',-1),(4,'dsdf','9031afa2e3a2fe0c6446325a7620ce18','0',0,'','sdf',-1),(5,'andy','454a48d41ef8e417ed08e25fcc78a4a6','0',1492870409,'','andy',1),(6,'admin','ca8d74c966c6dd4d761ada19a2b4d724','0',1492870889,'','admin',1);
/*!40000 ALTER TABLE `cms_admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_menu`
--

DROP TABLE IF EXISTS `cms_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_menu` (
  `menu_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(40) NOT NULL DEFAULT '',
  `parentid` smallint(6) NOT NULL DEFAULT '0',
  `m` varchar(20) NOT NULL DEFAULT '',
  `c` varchar(20) NOT NULL DEFAULT '',
  `f` varchar(20) NOT NULL DEFAULT '',
  `data` varchar(100) NOT NULL DEFAULT '',
  `listorder` smallint(6) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`menu_id`),
  KEY `listorder` (`listorder`),
  KEY `parentid` (`parentid`),
  KEY `module` (`m`,`c`,`f`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_menu`
--

LOCK TABLES `cms_menu` WRITE;
/*!40000 ALTER TABLE `cms_menu` DISABLE KEYS */;
INSERT INTO `cms_menu` VALUES (1,'菜单管理',0,'admin','menu','index','',6,1,1),(14,'科技',0,'home','cat','index','',0,1,0),(13,'新闻',0,'home','cat','index','',0,1,0),(12,'体育',0,'home','cat','index','',0,1,0),(7,'文章管理',0,'admin','content','index','',5,1,1),(8,'推荐位管理',0,'admin','position','index','',4,1,1),(9,'推荐位内容管理',0,'admin','positioncontent','index','',3,1,1),(10,'用户管理',0,'admin','admin','index','',2,1,1),(11,'基本配置',0,'admin','basic','index','',1,1,1);
/*!40000 ALTER TABLE `cms_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_news`
--

DROP TABLE IF EXISTS `cms_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_news` (
  `news_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `title` varchar(80) NOT NULL DEFAULT '',
  `small_title` varchar(30) NOT NULL DEFAULT '',
  `title_font_color` varchar(250) DEFAULT NULL COMMENT '标题颜色',
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `keywords` char(40) NOT NULL DEFAULT '',
  `description` varchar(250) NOT NULL COMMENT '文章描述',
  `posids` varchar(250) NOT NULL DEFAULT '',
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `copyfrom` varchar(250) DEFAULT NULL COMMENT '来源',
  `username` char(20) NOT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  `count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`news_id`),
  KEY `status` (`status`,`listorder`,`news_id`),
  KEY `listorder` (`catid`,`status`,`listorder`,`news_id`),
  KEY `catid` (`catid`,`status`,`news_id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_news`
--

LOCK TABLES `cms_news` WRITE;
/*!40000 ALTER TABLE `cms_news` DISABLE KEYS */;
INSERT INTO `cms_news` VALUES (1,14,'重庆美女球迷争芳斗艳','重庆美女球迷争芳斗艳','#5674ed','/upload/2017/04/12/58ede78c1bebe.jpg','广告','2016年3月13日，2016年中超联赛第2轮：重庆力帆vs河南建业，主场美女球迷争芳斗艳。','',0,1,'3','seven',0,1492007796,1),(2,14,'习近平今日下午出席解放军代表团全体会议','习近平今日下午出席解放军代表团全体会议','#5674ed','/upload/2017/04/12/58ede7663b600.jpg','啊哈','淡定点','',22,1,'1','john',0,1492015916,4),(9,14,'任意门','may','#5674ed','/upload/2017/04/12/58edb89d27210.jpg','你的身边','day','',23,1,'0','admin',1491974369,1492015907,8),(8,14,'abc','a','','','d','c','',0,1,'0','admin',1491959681,1491983092,0),(10,13,'生存以上','生活以下','#5674ed','/upload/2017/04/12/58ede71eb992f.jpg','宅','五月','',10,1,'0','admin',1491986252,1491986346,6),(11,13,'我喜欢上你时的内心活动','喜欢你','#5674ed','/upload/2017/04/12/58ee3b160f208.jpg','珍','绮','',17,1,'1','admin',1492007769,0,2),(12,14,'盛世','是打发','#5674ed','/upload/2017/04/18/58f630a4be49f.jpg','地方','地方','',0,1,'0','admin',1492322438,1492529364,1),(13,14,'LIPO','meiJIU','#5674ed','/upload/2017/04/19/58f6428aa12f8.jpg','李白','暂无','',0,1,'2','admin',1492533943,0,2),(14,14,'星空','旅行的意义','#5674ed','/upload/2017/04/19/58f6430874114.jpg','陈','','',0,1,'1','admin',1492534064,0,2),(15,12,'明明你也很爱我','没理由爱不到结果','#5674ed','/upload/2017/04/20/58f7948c259dc.jpg','关键字','描述','',0,1,'3','admin',1492620477,0,2);
/*!40000 ALTER TABLE `cms_news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_news_content`
--

DROP TABLE IF EXISTS `cms_news_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_news_content` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `news_id` mediumint(8) unsigned NOT NULL,
  `content` mediumtext NOT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `news_id` (`news_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_news_content`
--

LOCK TABLES `cms_news_content` WRITE;
/*!40000 ALTER TABLE `cms_news_content` DISABLE KEYS */;
INSERT INTO `cms_news_content` VALUES (1,8,'b',1491959681,0),(2,9,'&lt;p&gt;\r\n	你问我：\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	全世界哪里最美？ -- MayDay\r\n&lt;/p&gt;',1491974369,1491983023),(3,10,'&lt;img src=&quot;/upload/2017/04/12/58ede73793974.jpg&quot; alt=&quot;&quot; /&gt;---MayDay',1491986252,1491986346),(4,11,'陈',1492007769,0),(5,12,'东方闪电',1492322438,1492529364),(6,13,'李白没酒',1492533943,0),(7,14,'绮珍',1492534064,0),(8,15,'&lt;p&gt;\r\n	&lt;img src=&quot;/upload/2017/04/20/58f794a0319d7.jpg&quot; alt=&quot;&quot; /&gt;\r\n&lt;/p&gt;\r\n&lt;p&gt;\r\n	明天见！\r\n&lt;/p&gt;',1492620477,0);
/*!40000 ALTER TABLE `cms_news_content` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_position`
--

DROP TABLE IF EXISTS `cms_position`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_position` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` char(30) NOT NULL DEFAULT '',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `description` char(100) DEFAULT NULL,
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_position`
--

LOCK TABLES `cms_position` WRITE;
/*!40000 ALTER TABLE `cms_position` DISABLE KEYS */;
INSERT INTO `cms_position` VALUES (1,'首页大图',-1,'等等我呀ok?',0,1492013114),(2,'小图',-1,NULL,0,0),(3,'首页大图',1,'',0,1492527159),(4,'首页三小图',1,'三小图',1492010765,1492528673),(5,'广告位',1,'广告信息',1492010829,1492533837);
/*!40000 ALTER TABLE `cms_position` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cms_position_content`
--

DROP TABLE IF EXISTS `cms_position_content`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cms_position_content` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `position_id` int(5) unsigned NOT NULL,
  `title` varchar(30) NOT NULL DEFAULT '',
  `thumb` varchar(100) NOT NULL DEFAULT '',
  `url` varchar(100) DEFAULT NULL,
  `news_id` mediumint(8) unsigned NOT NULL,
  `listorder` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `position_id` (`position_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cms_position_content`
--

LOCK TABLES `cms_position_content` WRITE;
/*!40000 ALTER TABLE `cms_position_content` DISABLE KEYS */;
INSERT INTO `cms_position_content` VALUES (1,3,'生存以上','/upload/2017/04/14/58efa93fb3b7a.jpg','',10,30,-1,1491986252,1492527180),(2,3,'习近平今日下午出席解放军代表团全体会议','/upload/2017/04/12/58ede7663b600.jpg',NULL,2,0,-1,1492007441,1492325446),(3,2,'生存以上','/upload/2017/04/12/58ede71eb992f.jpg',NULL,10,40,1,1491986252,1492353684),(4,3,'ddddd','/upload/2017/04/13/58ef9cd67456f.jpg','www.bestaday.c',0,0,-1,1492098383,1492277863),(5,4,'ddd','/upload/2017/04/13/58ef9d61901fe.jpg','www',0,0,-1,1492098403,1492102681),(6,3,'生存以上','/upload/2017/04/12/58ede71eb992f.jpg',NULL,10,0,1,1491986252,0),(7,4,'任意门','/upload/2017/04/12/58edb89d27210.jpg',NULL,9,0,-1,1491974369,1492528817),(8,4,'我喜欢上你时的内心活动','/upload/2017/04/12/58ee3b160f208.jpg',NULL,11,0,1,1492007769,0),(9,4,'任意门','/upload/2017/04/12/58edb89d27210.jpg',NULL,9,0,1,1491974369,0),(10,4,'盛世嫡妃','/upload/2017/04/18/58f62e446e815.jpg',NULL,12,0,-1,1492322438,1492529394),(11,4,'盛世','/upload/2017/04/18/58f630a4be49f.jpg',NULL,12,0,1,1492322438,0),(12,5,'LIPO','/upload/2017/04/19/58f645e65d5b5.jpg','',13,0,1,1492533943,0),(13,5,'星空','/upload/2017/04/19/58f645ab8f12b.jpg','',14,0,1,1492534064,0);
/*!40000 ALTER TABLE `cms_position_content` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-22 23:03:15
