<?php
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	if($_GET["formhash"]!=FORMHASH)
	{
		exit('Access Denied');
	}
	$uid=$_GET["uid"];
	$credit=$_GET["credit"];
	header("Content-Type: application/xml");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	if($_G['uid']==$uid&&$_G['uid']!=0)
	{
			if($credit<0)//参数错误
			{
				echo "\t<userInformation result=\"1\">\n";
			}
			else//增加积分
			{
				updatecreditbyaction("chatroom",$_G['uid']);
				echo "\t<userInformation result=\"2\" >\n";//扣除积分成功
				
			}
	}
	else
	{
		echo "\t<userInformation result=\"0\">\n";//尚未登录
	}
	echo "\t</userInformation>\n";
?>