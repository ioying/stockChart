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
			if($credit<0)//��������
			{
				echo "\t<userInformation result=\"1\">\n";
			}
			else//���ӻ���
			{
				updatecreditbyaction("chatroom",$_G['uid']);
				echo "\t<userInformation result=\"2\" >\n";//�۳����ֳɹ�
				
			}
	}
	else
	{
		echo "\t<userInformation result=\"0\">\n";//��δ��¼
	}
	echo "\t</userInformation>\n";
?>