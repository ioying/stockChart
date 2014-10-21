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
ALTER TABLE `pre_tsound_wenda_question` ADD `fid` MEDIUMINT( 8 ) NULL ,
ADD `tid` MEDIUMINT( 8 ) NULL ;
EOF;

runquery($sql);
$finish = true;
?>