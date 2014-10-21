<?php
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	$rnum=$_GET["rnum"];
	$roomID=$_GET["roomID"];
	C::t("#ychat#ychat_rooms")->update_by_id($roomID,array('cnum'=>$rnum));
	echo 'roomid='.$roomID;
	exit;
?> 