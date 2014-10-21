<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_lighting` (
	`id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
	`uid` mediumint(8) unsigned NOT NULL,
	`username` varchar(15) NOT NULL,
	`bgpic` smallint(6) NOT NULL,
	`mood` smallint(6) NOT NULL,
	`message` text NOT NULL,
	`dateline` int(10) NOT NULL,
	PRIMARY KEY (`id`)
) ENGINE=MyISAM;
EOF;

runquery($sql);
@updatecache(array('setting', 'styles'));

$finish = TRUE;

?>