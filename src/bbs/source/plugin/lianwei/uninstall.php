<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

DB::query("DROP TABLE IF EXISTS ".DB::table('lianwei')."");
@updatecache(array('setting', 'styles'));
$finish = TRUE;

?>