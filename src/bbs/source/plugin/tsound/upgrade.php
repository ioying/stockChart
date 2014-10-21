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

CREATE TABLE IF NOT EXISTS pre_tsound_myunion (
  union_id int(11) NOT NULL,
  fid int(11) NOT NULL DEFAULT '0',
  num int(11) NOT NULL DEFAULT '0',
  `time` int(11) NOT NULL DEFAULT '0',
  `name` varchar(120) DEFAULT NULL,
  forumname varchar(50) DEFAULT NULL,
  siteurl varchar(120) DEFAULT NULL,
  sitename varchar(120) DEFAULT NULL,
  forumid int(11) NOT NULL DEFAULT '0',
  UNIQUE KEY union_id (union_id)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS pre_tsound_record (
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



EOF;
runquery($sql);

$finish = true;
?>