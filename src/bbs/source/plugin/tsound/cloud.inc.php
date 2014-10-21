<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$data=@file_get_contents('http://2cscs.onez.cn/onez.php?action=info&charset='.$_G['charset'].'&siteurl='.urlencode($_G['siteurl']));
echo $data;
?>