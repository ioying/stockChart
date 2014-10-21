/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : ultrax

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2014-10-21 15:07:27
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `pre_tsound_wenda_authority`
-- ----------------------------
DROP TABLE IF EXISTS `pre_tsound_wenda_authority`;
CREATE TABLE `pre_tsound_wenda_authority` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `authority` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_tsound_wenda_authority
-- ----------------------------
