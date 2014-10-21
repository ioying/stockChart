/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : ultrax

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2014-10-21 15:07:19
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `pre_tsound_wenda_answer`
-- ----------------------------
DROP TABLE IF EXISTS `pre_tsound_wenda_answer`;
CREATE TABLE `pre_tsound_wenda_answer` (
  `aid` int(11) NOT NULL AUTO_INCREMENT,
  `qid` int(11) NOT NULL DEFAULT '0',
  `cid` int(11) NOT NULL DEFAULT '0',
  `rid` int(11) NOT NULL DEFAULT '0',
  `uid` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) DEFAULT NULL,
  `content` longtext,
  `Score` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`aid`),
  KEY `qid` (`qid`),
  KEY `cid` (`cid`),
  KEY `rid` (`rid`),
  KEY `uid` (`uid`),
  KEY `time` (`time`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_tsound_wenda_answer
-- ----------------------------
INSERT INTO `pre_tsound_wenda_answer` VALUES ('1', '23', '0', '0', '1', '1395112007', null, 'zzc！$	$	$zzzc#	#	#f#	#	#1#	#	#0', '0');
INSERT INTO `pre_tsound_wenda_answer` VALUES ('2', '23', '0', '0', '2', '1395126795', null, 'hahaha', '0');
INSERT INTO `pre_tsound_wenda_answer` VALUES ('3', '24', '0', '0', '2', '1395140850', null, 'Very Good!', '0');
INSERT INTO `pre_tsound_wenda_answer` VALUES ('4', '24', '0', '0', '1', '1395146139', null, '\\\'<\\\'', '0');
INSERT INTO `pre_tsound_wenda_answer` VALUES ('5', '25', '0', '0', '1', '1395321900', null, '不错！', '0');
INSERT INTO `pre_tsound_wenda_answer` VALUES ('6', '24', '0', '0', '1', '1395389791', null, '受损失', '0');
INSERT INTO `pre_tsound_wenda_answer` VALUES ('7', '24', '0', '0', '1', '1395390119', null, '高规格$	$	$具体些#	#	#f#	#	#1#	#	#0', '0');
INSERT INTO `pre_tsound_wenda_answer` VALUES ('8', '24', '0', '0', '1', '1395390224', null, 'vvv', '0');
INSERT INTO `pre_tsound_wenda_answer` VALUES ('9', '24', '0', '0', '1', '1395390271', null, '温度', '80');
INSERT INTO `pre_tsound_wenda_answer` VALUES ('10', '24', '0', '0', '2', '1395390299', null, 'wm', '100');
INSERT INTO `pre_tsound_wenda_answer` VALUES ('11', '27', '1', '0', '1', '1395400758', null, 'ok', '60');
INSERT INTO `pre_tsound_wenda_answer` VALUES ('12', '26', '1', '0', '1', '1395401540', null, 'aaa', '100');
INSERT INTO `pre_tsound_wenda_answer` VALUES ('13', '26', '1', '0', '1', '1395404455', null, '差了一点', '1');
INSERT INTO `pre_tsound_wenda_answer` VALUES ('14', '24', '0', '46', '1', '1395734996', null, '不错', '60');
INSERT INTO `pre_tsound_wenda_answer` VALUES ('15', '40', '1', '0', '1', '1395735608', null, '在这种', '60');
INSERT INTO `pre_tsound_wenda_answer` VALUES ('16', '40', '1', '0', '1', '1395739632', null, '啊啊', '60');
INSERT INTO `pre_tsound_wenda_answer` VALUES ('17', '40', '1', '0', '1', '1395739657', null, '22', '60');
INSERT INTO `pre_tsound_wenda_answer` VALUES ('18', '40', '1', '0', '1', '1395741176', null, '333', '60');
INSERT INTO `pre_tsound_wenda_answer` VALUES ('19', '39', '1', '0', '1', '1395751475', null, '在这种$	$	$点点滴滴#	#	#f#	#	#1#	#	#0', '60');
