<?php
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	if($_POST["formhash"]!=FORMHASH)
	{
		exit('Access Denied');
	}
	require_once './config/config_ucenter.php';
	require_once './source/function/function_member.php';
	header("Content-Type: application/xml");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	$result= userlogin($_POST['username'], $_POST['userpwd'], "", "");
	if($result['status']>0)//µÇÂ¼³É¹¦
	{
		setloginstatus($result['member'],$_G['gp_cookietime'] ? 2592000 : 0);
		echo "\t<userInformation login='success' />\n";
	}
	else
	{
		echo "\t<userInformation login='fail' />\n";
		//µÇÂ¼Ê§°Ü
	}
	
?>