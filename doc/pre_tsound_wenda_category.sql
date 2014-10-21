/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : ultrax

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2014-10-21 15:07:32
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `pre_tsound_wenda_category`
-- ----------------------------
DROP TABLE IF EXISTS `pre_tsound_wenda_category`;
CREATE TABLE `pre_tsound_wenda_category` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `pcid` int(11) NOT NULL DEFAULT '0',
  `name` varchar(120) DEFAULT NULL,
  `readme` text,
  `step` int(11) NOT NULL DEFAULT '0',
  `authority` text NOT NULL,
  PRIMARY KEY (`cid`),
  KEY `pcid` (`pcid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_tsound_wenda_category
-- ----------------------------
