/*
Navicat MySQL Data Transfer

Source Server         : str
Source Server Version : 80012
Source Host           : 127.0.0.1:3306
Source Database       : order

Target Server Type    : MYSQL
Target Server Version : 80012
File Encoding         : 65001

Date: 2020-02-20 21:09:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for order_sync
-- ----------------------------
DROP TABLE IF EXISTS `order_sync`;
CREATE TABLE `order_sync` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '同步数据',
  `order_sync_id` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of order_sync
-- ----------------------------
INSERT INTO `order_sync` VALUES ('75', '5', '1');
INSERT INTO `order_sync` VALUES ('74', '3', '1');

-- ----------------------------
-- Table structure for shop_business
-- ----------------------------
DROP TABLE IF EXISTS `shop_business`;
CREATE TABLE `shop_business` (
  `b_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `b_name` varchar(255) COLLATE utf8_croatian_ci DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL COMMENT '商家表',
  PRIMARY KEY (`b_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_business
-- ----------------------------
INSERT INTO `shop_business` VALUES ('1', '商家A', '1', null, null);
INSERT INTO `shop_business` VALUES ('2', '商家B', '1', null, null);
INSERT INTO `shop_business` VALUES ('3', '商家C', '1', null, null);

-- ----------------------------
-- Table structure for shop_cart
-- ----------------------------
DROP TABLE IF EXISTS `shop_cart`;
CREATE TABLE `shop_cart` (
  `cart_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '购物车表',
  `goods_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `b_id` int(11) DEFAULT NULL,
  `buy_number` int(11) DEFAULT NULL,
  `status` varchar(11) COLLATE utf8_croatian_ci DEFAULT NULL,
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`cart_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_cart
-- ----------------------------
INSERT INTO `shop_cart` VALUES ('1', '1', '1', '1', '1', '1', null, null);
INSERT INTO `shop_cart` VALUES ('2', '3', '1', '2', '1', '1', null, null);
INSERT INTO `shop_cart` VALUES ('3', '6', '1', '3', '1', '1', null, null);
INSERT INTO `shop_cart` VALUES ('4', '4', '1', '2', '1', '1', null, null);
INSERT INTO `shop_cart` VALUES ('5', '2', '1', '1', '1', '1', null, null);

-- ----------------------------
-- Table structure for shop_goods
-- ----------------------------
DROP TABLE IF EXISTS `shop_goods`;
CREATE TABLE `shop_goods` (
  `goods_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '商品表',
  `b_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) COLLATE utf8_croatian_ci DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `stack` varchar(255) COLLATE utf8_croatian_ci DEFAULT NULL,
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`goods_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_goods
-- ----------------------------
INSERT INTO `shop_goods` VALUES ('1', '1', '斗神1', '100.00', '1', '10', null, null);
INSERT INTO `shop_goods` VALUES ('2', '1', '斗神2', '110.00', '1', '10', null, null);
INSERT INTO `shop_goods` VALUES ('3', '2', '暗无1', '120.00', '1', '10', null, null);
INSERT INTO `shop_goods` VALUES ('4', '2', '暗无2', '130.00', '1', '10', null, null);
INSERT INTO `shop_goods` VALUES ('5', '3', '布鲁1', '140.00', '1', '10', null, null);
INSERT INTO `shop_goods` VALUES ('6', '3', '布鲁2', '150.00', '1', '10', null, null);

-- ----------------------------
-- Table structure for shop_order_00
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_00`;
CREATE TABLE `shop_order_00` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单表',
  `user_id` int(11) DEFAULT NULL,
  `order_no` char(30) COLLATE utf8_croatian_ci DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_00
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_01
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_01`;
CREATE TABLE `shop_order_01` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单表',
  `user_id` int(11) DEFAULT NULL,
  `order_no` char(30) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_01
-- ----------------------------
INSERT INTO `shop_order_01` VALUES ('1', '1', '15822026983272', '610.00', '1', null, null);

-- ----------------------------
-- Table structure for shop_order_02
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_02`;
CREATE TABLE `shop_order_02` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单表',
  `user_id` int(11) DEFAULT NULL,
  `order_no` char(30) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_02
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_03
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_03`;
CREATE TABLE `shop_order_03` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单表',
  `user_id` int(11) DEFAULT NULL,
  `order_no` char(30) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_03
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_04
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_04`;
CREATE TABLE `shop_order_04` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单表',
  `user_id` int(11) DEFAULT NULL,
  `order_no` char(30) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_04
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_05
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_05`;
CREATE TABLE `shop_order_05` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单表',
  `user_id` int(11) DEFAULT NULL,
  `order_no` char(30) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_05
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_06
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_06`;
CREATE TABLE `shop_order_06` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单表',
  `user_id` int(11) DEFAULT NULL,
  `order_no` char(30) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_06
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_07
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_07`;
CREATE TABLE `shop_order_07` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单表',
  `user_id` int(11) DEFAULT NULL,
  `order_no` char(30) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_07
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_08
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_08`;
CREATE TABLE `shop_order_08` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单表',
  `user_id` int(11) DEFAULT NULL,
  `order_no` char(30) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_08
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_09
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_09`;
CREATE TABLE `shop_order_09` (
  `order_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单表',
  `user_id` int(11) DEFAULT NULL,
  `order_no` char(30) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_09
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_detail_business_00
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail_business_00`;
CREATE TABLE `shop_order_detail_business_00` (
  `detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详情商家',
  `order_id` int(11) DEFAULT NULL,
  `order_son_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `buy_number` int(11) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_detail_business_00
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_detail_business_01
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail_business_01`;
CREATE TABLE `shop_order_detail_business_01` (
  `detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详情商家',
  `order_id` int(11) DEFAULT NULL,
  `order_son_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `buy_number` int(11) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_detail_business_01
-- ----------------------------
INSERT INTO `shop_order_detail_business_01` VALUES ('1', '1', '1', '1', '1', '斗神1', '1', '100.00', null, null, null);
INSERT INTO `shop_order_detail_business_01` VALUES ('2', '1', '1', '2', '1', '斗神2', '1', '110.00', null, null, null);

-- ----------------------------
-- Table structure for shop_order_detail_business_02
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail_business_02`;
CREATE TABLE `shop_order_detail_business_02` (
  `detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详情商家',
  `order_id` int(11) DEFAULT NULL,
  `order_son_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `buy_number` int(11) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_detail_business_02
-- ----------------------------
INSERT INTO `shop_order_detail_business_02` VALUES ('3', '1', '2', '3', '2', '暗无1', '1', '120.00', null, null, null);
INSERT INTO `shop_order_detail_business_02` VALUES ('4', '1', '2', '4', '2', '暗无2', '1', '130.00', null, null, null);

-- ----------------------------
-- Table structure for shop_order_detail_business_03
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail_business_03`;
CREATE TABLE `shop_order_detail_business_03` (
  `detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详情商家',
  `order_id` int(11) DEFAULT NULL,
  `order_son_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `buy_number` int(11) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_detail_business_03
-- ----------------------------
INSERT INTO `shop_order_detail_business_03` VALUES ('5', '1', '3', '6', '3', '布鲁2', '1', '150.00', null, null, null);

-- ----------------------------
-- Table structure for shop_order_detail_business_04
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail_business_04`;
CREATE TABLE `shop_order_detail_business_04` (
  `detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详情商家',
  `order_id` int(11) DEFAULT NULL,
  `order_son_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `buy_number` int(11) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_detail_business_04
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_detail_business_05
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail_business_05`;
CREATE TABLE `shop_order_detail_business_05` (
  `detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详情商家',
  `order_id` int(11) DEFAULT NULL,
  `order_son_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `buy_number` int(11) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_detail_business_05
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_detail_business_06
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail_business_06`;
CREATE TABLE `shop_order_detail_business_06` (
  `detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详情商家',
  `order_id` int(11) DEFAULT NULL,
  `order_son_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `buy_number` int(11) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_detail_business_06
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_detail_business_07
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail_business_07`;
CREATE TABLE `shop_order_detail_business_07` (
  `detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详情商家',
  `order_id` int(11) DEFAULT NULL,
  `order_son_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `buy_number` int(11) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_detail_business_07
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_detail_business_08
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail_business_08`;
CREATE TABLE `shop_order_detail_business_08` (
  `detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详情商家',
  `order_id` int(11) DEFAULT NULL,
  `order_son_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `buy_number` int(11) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_detail_business_08
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_detail_business_09
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail_business_09`;
CREATE TABLE `shop_order_detail_business_09` (
  `detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详情商家',
  `order_id` int(11) DEFAULT NULL,
  `order_son_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `buy_number` int(11) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_detail_business_09
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_detail_user_00
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail_user_00`;
CREATE TABLE `shop_order_detail_user_00` (
  `detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详情',
  `order_id` int(11) DEFAULT NULL,
  `order_son_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) COLLATE utf8_croatian_ci DEFAULT NULL,
  `buy_number` int(11) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_detail_user_00
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_detail_user_01
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail_user_01`;
CREATE TABLE `shop_order_detail_user_01` (
  `detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详情',
  `order_id` int(11) DEFAULT NULL,
  `order_son_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `buy_number` int(11) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_detail_user_01
-- ----------------------------
INSERT INTO `shop_order_detail_user_01` VALUES ('1', '1', '1', '1', '1', '斗神1', '1', '100.00', null, null, null);
INSERT INTO `shop_order_detail_user_01` VALUES ('2', '1', '1', '2', '1', '斗神2', '1', '110.00', null, null, null);
INSERT INTO `shop_order_detail_user_01` VALUES ('3', '1', '2', '3', '2', '暗无1', '1', '120.00', null, null, null);
INSERT INTO `shop_order_detail_user_01` VALUES ('4', '1', '2', '4', '2', '暗无2', '1', '130.00', null, null, null);
INSERT INTO `shop_order_detail_user_01` VALUES ('5', '1', '3', '6', '3', '布鲁2', '1', '150.00', null, null, null);

-- ----------------------------
-- Table structure for shop_order_detail_user_02
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail_user_02`;
CREATE TABLE `shop_order_detail_user_02` (
  `detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详情',
  `order_id` int(11) DEFAULT NULL,
  `order_son_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `buy_number` int(11) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_detail_user_02
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_detail_user_03
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail_user_03`;
CREATE TABLE `shop_order_detail_user_03` (
  `detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详情',
  `order_id` int(11) DEFAULT NULL,
  `order_son_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `buy_number` int(11) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_detail_user_03
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_detail_user_04
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail_user_04`;
CREATE TABLE `shop_order_detail_user_04` (
  `detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详情',
  `order_id` int(11) DEFAULT NULL,
  `order_son_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `buy_number` int(11) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_detail_user_04
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_detail_user_05
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail_user_05`;
CREATE TABLE `shop_order_detail_user_05` (
  `detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详情',
  `order_id` int(11) DEFAULT NULL,
  `order_son_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `buy_number` int(11) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_detail_user_05
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_detail_user_06
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail_user_06`;
CREATE TABLE `shop_order_detail_user_06` (
  `detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详情',
  `order_id` int(11) DEFAULT NULL,
  `order_son_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `buy_number` int(11) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_detail_user_06
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_detail_user_07
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail_user_07`;
CREATE TABLE `shop_order_detail_user_07` (
  `detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详情',
  `order_id` int(11) DEFAULT NULL,
  `order_son_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `buy_number` int(11) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_detail_user_07
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_detail_user_08
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail_user_08`;
CREATE TABLE `shop_order_detail_user_08` (
  `detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详情',
  `order_id` int(11) DEFAULT NULL,
  `order_son_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `buy_number` int(11) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_detail_user_08
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_detail_user_09
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_detail_user_09`;
CREATE TABLE `shop_order_detail_user_09` (
  `detail_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单详情',
  `order_id` int(11) DEFAULT NULL,
  `order_son_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `goods_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_croatian_ci DEFAULT NULL,
  `buy_number` int(11) DEFAULT NULL,
  `goods_price` decimal(10,2) DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `ctime` int(11) DEFAULT NULL,
  `utime` int(11) DEFAULT NULL,
  PRIMARY KEY (`detail_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_detail_user_09
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_son_business_00
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_son_business_00`;
CREATE TABLE `shop_order_son_business_00` (
  `order_son_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单子表',
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `post_type` tinyint(4) DEFAULT NULL COMMENT '快递方式',
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_son_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_son_business_00
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_son_business_01
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_son_business_01`;
CREATE TABLE `shop_order_son_business_01` (
  `order_son_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单子表',
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `post_type` tinyint(4) DEFAULT NULL COMMENT '快递方式',
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_son_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_son_business_01
-- ----------------------------
INSERT INTO `shop_order_son_business_01` VALUES ('1', '1', '1', '1', '210.00', '1', null, null, null);

-- ----------------------------
-- Table structure for shop_order_son_business_02
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_son_business_02`;
CREATE TABLE `shop_order_son_business_02` (
  `order_son_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单子表',
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `post_type` tinyint(4) DEFAULT NULL COMMENT '快递方式',
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_son_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_son_business_02
-- ----------------------------
INSERT INTO `shop_order_son_business_02` VALUES ('2', '1', '1', '2', '250.00', '1', null, null, null);

-- ----------------------------
-- Table structure for shop_order_son_business_03
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_son_business_03`;
CREATE TABLE `shop_order_son_business_03` (
  `order_son_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单子表',
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `post_type` tinyint(4) DEFAULT NULL COMMENT '快递方式',
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_son_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_son_business_03
-- ----------------------------
INSERT INTO `shop_order_son_business_03` VALUES ('3', '1', '1', '3', '150.00', '1', null, null, null);

-- ----------------------------
-- Table structure for shop_order_son_business_04
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_son_business_04`;
CREATE TABLE `shop_order_son_business_04` (
  `order_son_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单子表',
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `post_type` tinyint(4) DEFAULT NULL COMMENT '快递方式',
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_son_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_son_business_04
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_son_business_05
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_son_business_05`;
CREATE TABLE `shop_order_son_business_05` (
  `order_son_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单子表',
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `post_type` tinyint(4) DEFAULT NULL COMMENT '快递方式',
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_son_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_son_business_05
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_son_business_06
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_son_business_06`;
CREATE TABLE `shop_order_son_business_06` (
  `order_son_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单子表',
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `post_type` tinyint(4) DEFAULT NULL COMMENT '快递方式',
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_son_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_son_business_06
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_son_business_07
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_son_business_07`;
CREATE TABLE `shop_order_son_business_07` (
  `order_son_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单子表',
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `post_type` tinyint(4) DEFAULT NULL COMMENT '快递方式',
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_son_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_son_business_07
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_son_business_08
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_son_business_08`;
CREATE TABLE `shop_order_son_business_08` (
  `order_son_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单子表',
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `post_type` tinyint(4) DEFAULT NULL COMMENT '快递方式',
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_son_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_son_business_08
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_son_business_09
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_son_business_09`;
CREATE TABLE `shop_order_son_business_09` (
  `order_son_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单子表',
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `post_type` tinyint(4) DEFAULT NULL COMMENT '快递方式',
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_son_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_son_business_09
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_son_user_00
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_son_user_00`;
CREATE TABLE `shop_order_son_user_00` (
  `order_son_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单子表',
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `post_type` tinyint(4) DEFAULT NULL COMMENT '快递方式',
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_son_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_son_user_00
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_son_user_01
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_son_user_01`;
CREATE TABLE `shop_order_son_user_01` (
  `order_son_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单子表',
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `post_type` tinyint(4) DEFAULT NULL COMMENT '快递方式',
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_son_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_son_user_01
-- ----------------------------
INSERT INTO `shop_order_son_user_01` VALUES ('1', '1', '1', '1', '210.00', '1', null, null, null);
INSERT INTO `shop_order_son_user_01` VALUES ('2', '1', '1', '2', '250.00', '1', null, null, null);
INSERT INTO `shop_order_son_user_01` VALUES ('3', '1', '1', '3', '150.00', '1', null, null, null);

-- ----------------------------
-- Table structure for shop_order_son_user_02
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_son_user_02`;
CREATE TABLE `shop_order_son_user_02` (
  `order_son_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单子表',
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `post_type` tinyint(4) DEFAULT NULL COMMENT '快递方式',
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_son_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_son_user_02
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_son_user_03
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_son_user_03`;
CREATE TABLE `shop_order_son_user_03` (
  `order_son_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单子表',
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `post_type` tinyint(4) DEFAULT NULL COMMENT '快递方式',
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_son_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_son_user_03
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_son_user_04
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_son_user_04`;
CREATE TABLE `shop_order_son_user_04` (
  `order_son_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单子表',
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `post_type` tinyint(4) DEFAULT NULL COMMENT '快递方式',
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_son_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_son_user_04
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_son_user_05
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_son_user_05`;
CREATE TABLE `shop_order_son_user_05` (
  `order_son_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单子表',
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `post_type` tinyint(4) DEFAULT NULL COMMENT '快递方式',
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_son_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_son_user_05
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_son_user_06
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_son_user_06`;
CREATE TABLE `shop_order_son_user_06` (
  `order_son_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单子表',
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `post_type` tinyint(4) DEFAULT NULL COMMENT '快递方式',
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_son_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_son_user_06
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_son_user_07
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_son_user_07`;
CREATE TABLE `shop_order_son_user_07` (
  `order_son_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单子表',
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `post_type` tinyint(4) DEFAULT NULL COMMENT '快递方式',
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_son_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_son_user_07
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_son_user_08
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_son_user_08`;
CREATE TABLE `shop_order_son_user_08` (
  `order_son_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单子表',
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `post_type` tinyint(4) DEFAULT NULL COMMENT '快递方式',
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_son_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_son_user_08
-- ----------------------------

-- ----------------------------
-- Table structure for shop_order_son_user_09
-- ----------------------------
DROP TABLE IF EXISTS `shop_order_son_user_09`;
CREATE TABLE `shop_order_son_user_09` (
  `order_son_id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '订单子表',
  `order_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `business_id` int(11) DEFAULT NULL,
  `order_amount` decimal(10,2) DEFAULT NULL,
  `order_status` tinyint(4) DEFAULT NULL,
  `post_type` tinyint(4) DEFAULT NULL COMMENT '快递方式',
  `ctime` int(10) DEFAULT NULL,
  `utime` int(10) DEFAULT NULL,
  PRIMARY KEY (`order_son_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_croatian_ci;

-- ----------------------------
-- Records of shop_order_son_user_09
-- ----------------------------
