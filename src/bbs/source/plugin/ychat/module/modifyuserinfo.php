<?php
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	if($_POST["formhash"]!=FORMHASH)
	{
		exit('Access Denied');
	}
	$uid=$_POST["uid"];
	$name=$_POST["name"];
	$spacenote=$_POST["spacenote"];
	$birthyear=$_POST["birthyear"];
	$birthmonth=$_POST["birthmonth"];
	$birthday=$_POST["birthday"];
	$blood=$_POST["blood"];
	$marry=$_POST["marry"];
	$birthprovince=$_POST["birthprovince"];
	$birthcity=$_POST["birthcity"];
	$resideprovince=$_POST["resideprovince"];
	$residecity=$_POST["residecity"];
	$sex=$_POST["sex"];
	require_once libfile('function/spacecp');
	header("Content-Type: application/xml");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	if($_G['uid']==$uid&&$_G['uid']!=0)
	{
		$data=array(
			'realname'=>$name,
			'birthyear'=>$birthyear,
			'birthmonth'=>$birthmonth,
			'birthday'=>$birthday,
			'bloodtype'=>$blood,
			'birthprovince'=>$birthprovince,
			'birthcity'=>$birthcity,
			'resideprovince'=>$resideprovince,
			'residecity'=>$residecity,
			'gender'=>$sex,
			'affectivestatus'=>$marry,
		);
		$tiaojian=array('uid'=>$uid,);
		C::t("common_member_profile")->update($uid,$data);
		C::t("common_member_field_home")->update($uid,array('spacenote'=>$spacenote));
		echo "\t<userInformation result=\"2\">\n";//数据更新成功
	}
	else
	{
		echo "\t<userInformation result=\"0\">\n";//尚未登录
	}
	echo "\t</userInformation>\n";
?>