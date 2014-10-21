<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: install.php 8889 2010-04-23 07:48:22Z monkey $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

include_once 'cert.php';
include_once 'lang.'.currentlang().'.php';
if($cert[3] != $_G['siteurl'] || md5(implode('', $cert)) != $sign) {
	cpmsg($l['error']);
}

$finish = TRUE;

?>