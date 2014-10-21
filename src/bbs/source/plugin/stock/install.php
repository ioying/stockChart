<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_stock` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `uid` mediumint(8) unsigned NOT NULL,
  `username` varchar(15) NOT NULL,
  `passtest` smallint(6) NOT NULL COMMENT '测试通过',
  `showset` smallint(6) NOT NULL COMMENT '显示设置',
  `message` text NOT NULL,
  `dateline` int(10) NOT NULL,
  `formulaname` varchar(15) NOT NULL COMMENT '公式名称',
  `description` text NOT NULL COMMENT '公式描述',
  `comment` text NOT NULL COMMENT '注释用法',
  `formula` text NOT NULL COMMENT '公式代码',
  `parser` text NOT NULL COMMENT '解析后',
  `mainmap` smallint(6) NOT NULL COMMENT '主图叠加',
  `hots` int(11) NOT NULL COMMENT '热度/权限等以后加',
  `lastupdate` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

EOF;

runquery($sql);
@updatecache(array('setting', 'styles'));

$finish = TRUE;



?>
