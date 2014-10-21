<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = <<<EOF

CREATE TABLE IF NOT EXISTS pre_tsound_wenda_answer (
  aid int(11) NOT NULL AUTO_INCREMENT,
  qid int(11) NOT NULL DEFAULT '0',
  cid int(11) NOT NULL DEFAULT '0',
  rid int(11) NOT NULL DEFAULT '0',
  uid int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  title varchar(255) DEFAULT NULL,
  content longtext,
  `Score` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (aid),
  KEY qid (qid),
  KEY cid (cid),
  KEY rid (rid),
  KEY uid (uid),
  KEY `time` (`time`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS pre_tsound_wenda_category (
  cid int(11) NOT NULL AUTO_INCREMENT,
  pcid int(11) NOT NULL DEFAULT '0',
  `name` varchar(120) DEFAULT NULL,
  readme text,
  step int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (cid),
  KEY pcid (pcid)
) ENGINE=MyISAM;


CREATE TABLE IF NOT EXISTS pre_tsound_wenda_question (
  qid int(11) NOT NULL AUTO_INCREMENT,
  rid int(11) NOT NULL DEFAULT '0',
  uid int(11) NOT NULL DEFAULT '0',
  cid int(11) NOT NULL DEFAULT '0',
 `lessonid` smallint(6) NOT NULL,
  coin int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  title varchar(200) DEFAULT NULL,
  content longtext,
  aid int(11) NOT NULL DEFAULT '0',
  iscommand int(1) NOT NULL DEFAULT '0',
  answer int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (qid),
  KEY rid (rid),
  KEY uid (uid),
  KEY cid (cid),
  KEY coin (coin),
  KEY `status` (`status`),
  KEY `time` (`time`),
  KEY aid (aid),
  KEY iscommand (iscommand)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS pre_tsound_wenda_record (
  rid int(11) NOT NULL AUTO_INCREMENT,
  `type` enum('audio','video') NOT NULL DEFAULT 'audio',
  `name` varchar(80) DEFAULT NULL,
  readme text,
  uid int(11) NOT NULL DEFAULT '0',
  sec int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  size int(11) NOT NULL DEFAULT '0',
  tid int(11) NOT NULL DEFAULT '0',
  pid int(11) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT '0',
  `file` varchar(120) DEFAULT NULL,
  token varchar(20) NOT NULL,
  isthread int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (rid),
  KEY uid (uid),
  KEY tid (tid),
  KEY `status` (`status`),
  KEY `type` (`type`),
  KEY token (token),
  KEY isthread (isthread)
) ENGINE=MyISAM;
ALTER TABLE `pre_tsound_wenda_question` ADD `fid` MEDIUMINT( 8 ) NULL ,
ADD `tid` MEDIUMINT( 8 ) NULL ;
ALTER TABLE `pre_tsound_wenda_category`ADD `authority` TEXT   NOT NULL ;

CREATE TABLE `pre_tsound_wenda_authority` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`authority` TEXT NOT NULL 
) ENGINE = MYISAM ;
ALTER TABLE `pre_tsound_wenda_question` ADD `is_auth` VARCHAR( 1 ) NULL ;
ALTER TABLE `pre_tsound_wenda_question` ADD `readpay` INT NULL ;

CREATE TABLE `pre_tsound_wenda_paylog` (
  `id` mediumint(12) NOT NULL auto_increment,
  `qid` int(11) NOT NULL,
  `uid` mediumint(8) NOT NULL,
  `create_time` datetime NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;




--
-- 表的结构 `pre_links_course`
--

CREATE TABLE IF NOT EXISTS `pre_links_course` (
  `cid` int(11) NOT NULL AUTO_INCREMENT,
  `cname` varchar(20) NOT NULL,
  `creadme` text NOT NULL,
  `clogo` varchar(120) NOT NULL,
  `time` int(11) NOT NULL,
  PRIMARY KEY (`cid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- 转存表中的数据 `pre_links_course`
--

INSERT INTO `pre_links_course` (`cid`, `cname`, `creadme`, `clogo`, `time`) VALUES
(1, '英语900句', '曾经最受欢迎的、无数次尝试而未完成的', 'source/plugin/tsound_wenda/course/test/900c1.png', 0);


--
-- 表的结构 `pre_links_lesson`
--

CREATE TABLE IF NOT EXISTS `pre_links_lesson` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='课表' AUTO_INCREMENT=4 ;

--
-- 转存表中的数据 `pre_links_lesson`
--

INSERT INTO `pre_links_lesson` (`lessonid`, `lessontitle`, `cid`, `type`, `english`, `Chinese`, `file`, `level`, `logo`, `time`) VALUES
(1, 'Lesson1', 1, 'audio', 'Chance 英 [tʃɑ:ns] 美 [tʃæns]', 'n.机会，机遇； 概率，可能性； 偶然，运气<br/>v.偶然发生； 冒险； 碰巧； 偶然被发现<br/>adj.意外的； 偶然的； 碰巧的<br/>', 'source/plugin/tsound_wenda/course/test/chance.mp3', 1, 'source/plugin/tsound_wenda/course/test/lessonlogo.png', 0),
(2, 'Lesson2', 1, 'audio', 'available 英 [əˈveɪləbl] 美 [əˈveləbəl]', 'adj.可用的； 有空的； 可会见的； （戏票、车票等）有效的<br/>', 'source/plugin/tsound_wenda/course/test/available.mp3', 1, 'source/plugin/tsound_wenda/course/test/lessonlogo.png', 0),
(3, '第三课', 1, 'audio', 'feedback 英 [ˈfi:dbæk] 美 [ˈfidˌbæk]', '.反馈； （音频系统的输出信号在输入端收到时发生的）反馈杂音； 回复； 自动调节（把机器的输出数据提供给自控装置以纠正偏差）<br/>网 络 反馈；意见反馈；回授；回馈<br/>', 'source/plugin/tsound_wenda/course/test/feedback.mp3', 1, 'source/plugin/tsound_wenda/course/test/lessonlogo2.png', 0);



EOF;
require_once DISCUZ_ROOT . './source/plugin/tsound_wenda/include/function.inc.php';
$data=@file_get_contents(dirname(__FILE__).'/data/default.php');
if($data){
  $data=tsound_wenda_flashToDz($data);
  $A=explode("\n",$data);
  $A[0]=$sql;
  $sql=implode("\n",$A);
}

runquery($sql);
$finish = true;
?>