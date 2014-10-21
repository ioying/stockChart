<?php
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	
	header("Content-Type: application/xml");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	if($_G['uid']==0)
	{
		echo "\t<userInformation login='fail' formhash='".FORMHASH."'>\n";
	}
	else
	{
		require_once 'ychat_config.php';
		require_once './config/config_ucenter.php';
		require_once libfile('function/home');
		$space = getspace($_G['uid'], 'uid');
		require_once libfile('function/spacecp');
		space_merge($space, 'profile');
		space_merge($space, 'count');
		$groups = C::t('common_usergroup')->fetch_all($space["groupid"]);
		foreach($groups as $group);
		$group['icon']=$group['icon']==''?'':$_G['setting']['attachurl']."common/".$group['icon'];
		echo "\t<userInformation login='success' formhash='".FORMHASH."'>\n";
		echo "\t\t<userID>".$space["uid"]."</userID>\n";
		if($space["realname"]==""){
			echo "\t\t<username>".$space["username"]."</username>\n";
		}
		else
		{
			echo "\t\t<username>".$space["realname"]."</username>\n";
		}
		echo "\t\t<competence>".$space["groupid"]."</competence>\n";
		
		echo "\t<groupicon><![CDATA[".$group['icon']."]]></groupicon>\n";//组id
		echo "\t<credit>".$space[$creditType]."</credit>\n";//积分
		if($space['avatarstatus'])//判断用户是否设置了头像
		{
			$space['avatar']=UC_API.'/avatar.php?uid='.$_G['uid'].'&size=small';//用户设置了头像
			echo "\t<avatar><![CDATA[".$space['avatar']."]]></avatar>\n";//头像
		}
		echo "\t\t<sex>".$space["gender"]."</sex>\n";
		
	}
	echo "\t</userInformation>\n";
?>