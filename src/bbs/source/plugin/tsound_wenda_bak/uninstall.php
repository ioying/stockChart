<?php

/**
 * [Discuz!] (C)2001-2099 Comsenz Inc.
 * This is NOT a freeware, use is subject to license terms
 *
 */

if (! defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE IF EXISTS pre_tsound_wenda_answer;
DROP TABLE IF EXISTS pre_tsound_wenda_category;
DROP TABLE IF EXISTS pre_tsound_wenda_question;
DROP TABLE IF EXISTS pre_tsound_wenda_record;
DROP TABLE IF EXISTS pre_tsound_wenda_paylog;
DROP TABLE IF EXISTS pre_tsound_wenda_authority;

EOF;
runquery($sql);
$finish = TRUE;