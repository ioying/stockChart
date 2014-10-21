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