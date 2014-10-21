<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

@updatecache(array('setting', 'styles'));
$finish = TRUE;

?>