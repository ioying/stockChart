<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF
DROP TABLE IF EXISTS `cdb_milu_seotool_included`, `cdb_milu_seotool_keyword`, `cdb_milu_seotool_keyword_rank`, `cdb_milu_seotool_spider`;
EOF;
runquery($sql);

$finish = TRUE;
?>