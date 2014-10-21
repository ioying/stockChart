/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50612
Source Host           : localhost:3306
Source Database       : ultrax

Target Server Type    : MYSQL
Target Server Version : 50612
File Encoding         : 65001

Date: 2014-10-21 15:06:25
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `pre_links_lesson`
-- ----------------------------
DROP TABLE IF EXISTS `pre_links_lesson`;
CREATE TABLE `pre_links_lesson` (
  `lessonid` int(11) NOT NULL AUTO_INCREMENT COMMENT '第课',
  `lessontitle` varchar(30) NOT NULL,
  `cid` int(11) NOT NULL COMMENT '教程编号',
  `type` enum('audio','video') NOT NULL DEFAULT 'audio' COMMENT '文件类型',
  `english` text NOT NULL COMMENT '英文',
  `Chinese` text NOT NULL COMMENT '中文',
  `file` varchar(120) NOT NULL COMMENT '演示文件',
  `level` tinyint(4) NOT NULL COMMENT '难度级别',
  `logo` varchar(120) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`lessonid`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='课表';

-- ----------------------------
-- Records of pre_links_lesson
-- ----------------------------
INSERT INTO `pre_links_lesson` VALUES ('1', 'Lesson1', '1', 'audio', 'Chance 英 [tʃɑ:ns] 美 [tʃæns]', 'n.机会，机遇； 概率，可能性； 偶然，运气<br/>v.偶然发生； 冒险； 碰巧； 偶然被发现<br/>adj.意外的； 偶然的； 碰巧的<br/>', 'source/plugin/tsound_wenda/course/test/chance.mp3', '1', 'source/plugin/tsound_wenda/course/test/lessonlogo.png', '0');
INSERT INTO `pre_links_lesson` VALUES ('2', 'Lesson2', '1', 'audio', 'available 英 [əˈveɪləbl] 美 [əˈveləbəl]', 'adj.可用的； 有空的； 可会见的； （戏票、车票等）有效的<br/>', 'source/plugin/tsound_wenda/course/test/available.mp3', '1', 'source/plugin/tsound_wenda/course/test/lessonlogo.png', '0');
INSERT INTO `pre_links_lesson` VALUES ('3', '第三课', '1', 'audio', 'feedback 英 [ˈfi:dbæk] 美 [ˈfidˌbæk]', '.反馈； （音频系统的输出信号在输入端收到时发生的）反馈杂音； 回复； 自动调节（把机器的输出数据提供给自控装置以纠正偏差）<br/>网 络 反馈；意见反馈；回授；回馈<br/>', 'source/plugin/tsound_wenda/course/test/feedback.mp3', '1', 'source/plugin/tsound_wenda/course/test/lessonlogo2.png', '0');
