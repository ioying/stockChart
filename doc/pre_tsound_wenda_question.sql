/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : ultrax

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2014-10-21 15:07:39
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `pre_tsound_wenda_question`
-- ----------------------------
DROP TABLE IF EXISTS `pre_tsound_wenda_question`;
CREATE TABLE `pre_tsound_wenda_question` (
  `qid` int(11) NOT NULL AUTO_INCREMENT,
  `rid` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  `cid` int(11) NOT NULL DEFAULT '0',
  `lessonid` smallint(6) NOT NULL,
  `coin` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `title` varchar(200) DEFAULT NULL,
  `content` longtext,
  `aid` int(11) NOT NULL DEFAULT '0',
  `iscommand` int(1) NOT NULL DEFAULT '0',
  `answer` int(11) NOT NULL DEFAULT '0',
  `fid` mediumint(8) DEFAULT NULL,
  `tid` mediumint(8) DEFAULT NULL,
  `is_auth` varchar(1) DEFAULT NULL,
  `readpay` int(11) DEFAULT NULL,
  PRIMARY KEY (`qid`),
  KEY `rid` (`rid`),
  KEY `uid` (`uid`),
  KEY `cid` (`cid`),
  KEY `coin` (`coin`),
  KEY `status` (`status`),
  KEY `time` (`time`),
  KEY `aid` (`aid`),
  KEY `iscommand` (`iscommand`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_tsound_wenda_question
-- ----------------------------
INSERT INTO `pre_tsound_wenda_question` VALUES ('1', '2', '1', '0', '0', '5', '0', '1395023511', '123', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('2', '3', '1', '0', '0', '0', '0', '1395042874', '', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('3', '0', '1', '0', '0', '0', '0', '1395043360', '', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('4', '0', '1', '0', '0', '0', '0', '1395043576', '', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('5', '0', '1', '0', '0', '0', '0', '1395043618', '', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('6', '0', '1', '0', '0', '0', '0', '1395043632', '', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('7', '0', '1', '0', '0', '0', '0', '1395043655', '', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('8', '0', '1', '0', '0', '0', '0', '1395043695', '', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('9', '0', '1', '0', '0', '0', '0', '1395043704', '', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('10', '0', '1', '0', '0', '0', '0', '1395043741', '', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('11', '18', '1', '0', '0', '0', '0', '1395044336', '', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('12', '19', '1', '0', '0', '0', '0', '1395047412', '', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('13', '25', '1', '0', '0', '0', '0', '1395056023', '', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('14', '26', '1', '0', '0', '0', '0', '1395056309', '', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('15', '27', '1', '0', '0', '0', '0', '1395056425', '', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('16', '28', '1', '0', '0', '0', '0', '1395056675', '头天躺', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('17', '29', '1', '0', '0', '0', '0', '1395056701', '3333', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('18', '29', '1', '0', '0', '0', '0', '1395057624', '3333', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('19', '30', '1', '0', '0', '0', '0', '1395057724', ' Test001', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('20', '31', '1', '0', '0', '0', '0', '1395059401', ' Test001', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('21', '32', '1', '0', '0', '0', '0', '1395059698', ' Test001', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('22', '36', '1', '0', '0', '0', '0', '1395063237', ' Test001', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('23', '38', '1', '0', '0', '0', '0', '1395064842', ' Test001', '', '2', '0', '2', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('24', '39', '1', '0', '1', '0', '0', '1395127409', ' Test001', '', '0', '0', '8', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('25', '41', '1', '0', '3', '0', '0', '1395321882', ' lesson3', '', '0', '0', '1', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('26', '43', '1', '1', '1', '0', '0', '1395400478', ' Lesson1', '', '0', '0', '2', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('27', '44', '1', '1', '3', '0', '0', '1395400527', ' 第三课', '', '0', '0', '1', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('28', '0', '1', '1', '1', '0', '0', '1395586507', ' Lesson1', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('29', '0', '1', '1', '2', '0', '0', '1395586517', ' Lesson2', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('30', '0', '1', '1', '2', '0', '0', '1395586722', ' Lesson2', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('31', '0', '1', '1', '2', '0', '0', '1395586788', ' Lesson2', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('32', '0', '1', '1', '2', '0', '0', '1395586814', ' Lesson2', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('33', '0', '1', '1', '2', '0', '0', '1395586819', ' Lesson2', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('34', '0', '1', '1', '2', '0', '0', '1395586884', ' Lesson2', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('35', '0', '1', '1', '2', '0', '0', '1395586892', ' Lesson2', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('36', '0', '1', '1', '2', '0', '0', '1395586914', ' Lesson2', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('37', '0', '1', '1', '2', '0', '0', '1395586933', ' Lesson2', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('38', '0', '1', '1', '2', '0', '0', '1395586971', ' Lesson2', '', '0', '0', '0', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('39', '0', '1', '1', '2', '0', '0', '1395587218', ' Lesson2', '$	$	$111#	#	#b#	#	#1#	#	#0$	$	$333#	#	#b#	#	#1#	#	#0', '0', '0', '1', null, null, null, null);
INSERT INTO `pre_tsound_wenda_question` VALUES ('40', '444', '1', '1', '2', '0', '0', '1395587385', ' Lesson2', '', '0', '0', '4', null, null, null, null);
