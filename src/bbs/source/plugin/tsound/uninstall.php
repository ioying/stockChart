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
DROP TABLE IF EXISTS pre_tsound_myunion;
DROP TABLE IF EXISTS pre_tsound_record;
EOF;
runquery($sql);
$finish = TRUE;