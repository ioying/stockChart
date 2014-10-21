/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : ultrax

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2014-10-21 15:06:17
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `pre_links_course`
-- ----------------------------
DROP TABLE IF EXISTS `pre_links_course`;
CREATE TABLE `pre_links_course` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `cname` varchar(20) NOT NULL,
  `creadme` text NOT NULL,
  `clogo` varchar(120) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_links_course
-- ----------------------------
INSERT INTO `pre_links_course` VALUES ('1', '英语900句', '曾经最受欢迎的、无数次尝试而未完成的', 'source/plugin/tsound_wenda/course/test/900c1.png', '0');
