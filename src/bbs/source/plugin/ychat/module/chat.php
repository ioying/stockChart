<?php
   if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}

	$roomid=$_GET["roomID"];
	$loginstatus=$_G['uid']==0?0:1;
	$value=C::t("#ychat#ychat_rooms")->fetch_all_by_roomID($roomid);
	if($value)
	{
		$navtitle=$value["roomName"].'-'.$ychat_plugin['title'];
	}
	include template('ychat:chat');
?>
