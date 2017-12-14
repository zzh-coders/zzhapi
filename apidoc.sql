CREATE DATABASE IF NOT EXISTS apidoc DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE apidoc;
/*Table structure for table `item` */

DROP TABLE IF EXISTS `item`;

CREATE TABLE `item` (
  `item_id` int(10) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(50) NOT NULL DEFAULT '' COMMENT '项目名称',
  `item_description` varchar(225) NOT NULL DEFAULT '' COMMENT '项目描述',
  `uid` int(10) NOT NULL DEFAULT '0' COMMENT '项目创建用户',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '项目创建时间',
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='项目表';

/*Table structure for table `item_member` */

DROP TABLE IF EXISTS `item_member`;

CREATE TABLE `item_member` (
  `item_member_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '项目关联表',
  `item_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '项目id',
  `username` VARCHAR(10) NOT NULL DEFAULT '' COMMENT '用户名',
  `create_time` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',
  PRIMARY KEY (`item_member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='项目成员表';

/*Table structure for table `member` */

DROP TABLE IF EXISTS `member`;

CREATE TABLE `member` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户表id',
  `username` varchar(32) NOT NULL,
  `groupid` tinyint(1) NOT NULL DEFAULT '1',
  `password` varchar(32) NOT NULL,
  `create_time` int(10) unsigned NOT NULL,
  `state` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*Table structure for table `menu` */

DROP TABLE IF EXISTS `menu`;

CREATE TABLE `menu` (
  `id` int(10) NOT NULL AUTO_INCREMENT COMMENT '目录id',
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '目录名',
  `item_id` int(10) NOT NULL DEFAULT '0' COMMENT '所在的项目id',
  `order` int(10) NOT NULL DEFAULT '99' COMMENT '顺序号。数字越小越靠前。若此值全部相等时则按id排序',
  `create_time` int(10) NOT NULL DEFAULT '0',
  `parent_id` int(10) NOT NULL DEFAULT '0' COMMENT '上级目录',
  `level` tinyint(1) NOT NULL DEFAULT '1' COMMENT '级别',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='目录表';

/*Table structure for table `page` */

DROP TABLE IF EXISTS `page`;

CREATE TABLE `page` (
  `page_id` int(10) NOT NULL AUTO_INCREMENT,
  `author_uid` int(10) NOT NULL DEFAULT '0' COMMENT '页面作者uid',
  `author_username` varchar(50) NOT NULL DEFAULT '' COMMENT '页面作者名字',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `cat_id` int(10) NOT NULL DEFAULT '0',
  `page_title` varchar(50) NOT NULL DEFAULT '',
  `page_desc` varchar(255) NOT NULL DEFAULT '' COMMENT '描述字符',
  `page_content` text NOT NULL,
  `order` int(10) NOT NULL DEFAULT '99' COMMENT '顺序号。数字越小越靠前。若此值全部相等时则按id排序',
  `create_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='文章页面表';

/*Table structure for table `page_history` */

DROP TABLE IF EXISTS `page_history`;

CREATE TABLE `page_history` (
  `page_history_id` int(10) NOT NULL AUTO_INCREMENT,
  `page_id` int(10) NOT NULL DEFAULT '0',
  `author_uid` int(10) NOT NULL DEFAULT '0' COMMENT '页面作者uid',
  `author_username` varchar(50) NOT NULL DEFAULT '' COMMENT '页面作者名字',
  `item_id` int(10) NOT NULL DEFAULT '0',
  `cat_id` int(10) NOT NULL DEFAULT '0',
  `page_title` varchar(50) NOT NULL DEFAULT '',
  `page_content` text NOT NULL,
  `order` int(10) NOT NULL DEFAULT '99' COMMENT '顺序号。数字越小越靠前。若此值全部为0则按时间排序',
  `create_time` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_history_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='页面历史表';
