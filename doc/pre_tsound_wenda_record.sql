/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : ultrax

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2014-10-21 15:07:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `pre_tsound_wenda_record`
-- ----------------------------
DROP TABLE IF EXISTS `pre_tsound_wenda_record`;
CREATE TABLE `pre_tsound_wenda_record` (
  `rid` int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('audio','video') NOT NULL DEFAULT 'audio',
  `name` varchar(80) DEFAULT NULL,
  `readme` text,
  `uid` int(11) NOT NULL DEFAULT '0',
  `sec` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `size` int(11) NOT NULL DEFAULT '0',
  `tid` int(11) NOT NULL DEFAULT '0',
  `pid` int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `file` varchar(120) DEFAULT NULL,
  `token` varchar(20) NOT NULL,
  `isthread` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`rid`),
  KEY `uid` (`uid`),
  KEY `tid` (`tid`),
  KEY `status` (`status`),
  KEY `type` (`type`),
  KEY `token` (`token`),
  KEY `isthread` (`isthread`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_tsound_wenda_record
-- ----------------------------
INSERT INTO `pre_tsound_wenda_record` VALUES ('1', 'audio', null, null, '1', '1242', '1395023501', '196416', '0', '0', '1', 'source/plugin/tsound_wenda/data/53265e8d8583b.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('2', 'audio', null, null, '1', '1242', '1395023505', '196416', '0', '0', '1', 'source/plugin/tsound_wenda/data/53265e91a037a.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('3', 'audio', null, null, '1', '117', '1395042862', '16368', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326aa2ea7d8c.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('4', 'audio', null, null, '1', '101', '1395043930', '16368', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326ae5a39387.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('5', 'audio', null, null, '1', '101', '1395043931', '16368', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326ae5b6ea05.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('6', 'audio', null, null, '1', '101', '1395043931', '16368', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326ae5c03d09.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('7', 'audio', null, null, '1', '323', '1395043943', '49104', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326ae67dd40a.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('8', 'audio', null, null, '1', '323', '1395043946', '49104', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326ae6a632ea.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('9', 'audio', null, null, '1', '323', '1395043947', '49104', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326ae6b1e848.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('10', 'audio', null, null, '1', '323', '1395043956', '49104', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326ae74bebc2.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('11', 'audio', null, null, '1', '323', '1395043957', '49104', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326ae75bebc2.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('12', 'audio', null, null, '1', '323', '1395043958', '49104', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326ae76a037a.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('13', 'audio', null, null, '1', '323', '1395043959', '49104', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326ae773567e.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('14', 'audio', null, null, '1', '223', '1395044010', '32736', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326aeaac28cb.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('15', 'audio', null, null, '1', '174', '1395044073', '24552', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326aee9ec82e.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('16', 'audio', null, null, '1', '151', '1395044113', '24552', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326af11b71b0.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('17', 'audio', null, null, '1', '362', '1395044196', '57288', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326af64d9701.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('18', 'audio', null, null, '1', '188', '1395044333', '28644', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326afeda7d8c.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('19', 'audio', null, null, '1', '228', '1395047405', '36828', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326bbed81b32.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('20', 'audio', null, null, '1', '354', '1395047690', '53196', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326bd0a90f56.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('21', 'audio', null, null, '1', '170', '1395049278', '24552', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326c33e40d99.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('22', 'audio', null, null, '1', '181', '1395054387', '28644', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326d7332dc6c.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('23', 'audio', null, null, '1', '110', '1395054459', '16368', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326d77b5b8d8.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('24', 'audio', null, null, '1', '218', '1395054518', '32736', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326d7b6dd40a.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('25', 'audio', null, null, '1', '235', '1395056021', '36828', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326dd9553ec6.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('26', 'audio', null, null, '1', '198', '1395056306', '28644', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326deb2bebc2.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('27', 'audio', null, null, '1', '178', '1395056422', '28644', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326df268d24d.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('28', 'audio', null, null, '1', '182', '1395056672', '28644', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326e020a037a.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('29', 'audio', null, null, '1', '204', '1395056699', '32736', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326e03b1ab3f.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('30', 'audio', null, null, '1', '382', '1395057716', '61380', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326e43416e36.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('31', 'audio', null, null, '1', '398', '1395059398', '61380', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326eac6bebc2.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('32', 'audio', null, null, '1', '1517', '1395059675', '241428', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326ebdc0b71b.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('33', 'audio', null, null, '1', '154', '1395062471', '24552', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326f6c7c65d4.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('34', 'audio', null, null, '1', '104', '1395062481', '16368', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326f6d1d59f8.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('35', 'audio', null, null, '1', '104', '1395062625', '16368', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326f761af79e.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('36', 'audio', null, null, '1', '235', '1395063230', '36828', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326f9be2dc6c.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('37', 'audio', null, null, '1', '464', '1395063792', '73656', '0', '0', '1', 'source/plugin/tsound_wenda/data/5326fbf0501bd.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('38', 'audio', null, null, '1', '339', '1395064835', '53196', '0', '0', '1', 'source/plugin/tsound_wenda/data/532700032625a.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('39', 'audio', null, null, '1', '609', '1395127402', '94116', '0', '0', '1', 'source/plugin/tsound_wenda/data/5327f46b00000.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('40', 'audio', null, null, '1', '343', '1395141149', '53196', '0', '0', '1', 'source/plugin/tsound_wenda/data/53282a1d7de29.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('41', 'audio', null, null, '1', '351', '1395321875', '53196', '0', '0', '1', 'source/plugin/tsound_wenda/data/532aec1407a12.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('42', 'audio', null, null, '1', '521', '1395321939', '81840', '0', '0', '1', 'source/plugin/tsound_wenda/data/532aec53a037a.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('43', 'audio', null, null, '1', '199', '1395400473', '32736', '0', '0', '1', 'source/plugin/tsound_wenda/data/532c1f19b34a7.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('44', 'audio', null, null, '1', '223', '1395400525', '32736', '0', '0', '1', 'source/plugin/tsound_wenda/data/532c1f4d7a120.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('45', 'audio', null, null, '1', '168', '1395492074', '24552', '0', '0', '1', 'source/plugin/tsound_wenda/data/532d84ea40d99.mp3', '', '1');
INSERT INTO `pre_tsound_wenda_record` VALUES ('46', 'audio', null, null, '1', '348', '1395734987', '53196', '0', '0', '1', 'source/plugin/tsound_wenda/data/533139cbb34a7.mp3', '', '1');
