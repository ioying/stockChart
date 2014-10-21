<?php
/*
	[Smjy] lighting      thanks a lot !Mood Wall 
	Copyright (c) 2009-2012 xinlin & smjy(http://www.smjy.org)
	$Id: lighting.inc.php 2012-8-30 Marco & ioying $
*/
if(!defined('IN_DISCUZ')){
	exit('Access Denied');
}

if(!empty($_GET['mod']) && !$_G['uid']){
	showmessage('not_loggedin', NULL, array(), array('login' => 1));
}elseif(preg_match("/X1.5/i", $_G['setting']['version'])){
	if($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST)){
		$_GET = array_merge($_GET, $_POST);
	}
}

if(empty($_GET['mod'])){
	$query = DB::query("SELECT * FROM ".DB::table('lighting')." ORDER BY id DESC LIMIT 0, 30");
	while($mood = DB::fetch($query)){
		$mood['dateline'] = dgmdate($mood['dateline'], 'dt', $_G['setting']['timeoffset']);
		$moodlist[]=$mood;
	}

}elseif($_GET['mod'] == 'user_mood'){
	if(submitcheck('del_mood')){
		$moodsadd = '';
		if($moodids = dimplode($_GET['delete'])){
			$moodsadd = "id IN ($moodids)";
		}
		if(!$moodsadd){
			showmessage('lighting:lighting_inc_php_2', 'plugin.php?id=lighting&mod=user_mood');
		}else{
			DB::query("DELETE FROM ".DB::table('lighting')." WHERE $moodsadd");
			showmessage('lighting:lighting_inc_php_6', dreferer());
		}
	}
	$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('lighting')." WHERE uid='$_G[uid]'");
	$page = $_G['page'] > 10 ? 1 : $_G['page'];
	$start_limit = ($page - 1) * 10;
	$multipage = multi($num, 10, $page, "plugin.php?id=lighting&mod={$_GET[mod]}");
	$query = DB::query("SELECT * FROM ".DB::table('lighting')." WHERE uid='$_G[uid]' ORDER BY id DESC LIMIT $start_limit, 10");
	$moodlist_user = array();
	while($mood_user = DB::fetch($query)){
		$mood_user['dateline'] = dgmdate($mood_user['dateline'], 'dt', $_G['setting']['timeoffset']);
		$moodlist_user[] = $mood_user;
	}
	
}elseif($_GET['mod'] == 'edit_mood' && $_GET['moodid']){
	$check = DB::fetch_first("SELECT id FROM ".DB::table('lighting')." WHERE id='".intval($_GET['moodid'])."' AND uid='$_G[uid]'");
	if(!$check['id']){
		showmessage('lighting:lighting_inc_php_2', 'plugin.php?id=lighting&mod=user_mood');
	}
	if(submitcheck('Submit_edit')){
		if(!trim($_GET['message'])){
			showmessage('lighting:lighting_inc_php_4');
		}else{
//			DB::query("UPDATE ".DB::table('lighting')." SET bgpic='".intval($_GET['bgpic'])."',mood='".intval($_GET['mood'])."',message='".daddslashes(dhtmlspecialchars($_GET['message']))."' WHERE id='".intval($_GET['moodid'])."'");
			DB::query("UPDATE ".DB::table('lighting')." SET message='".daddslashes(dhtmlspecialchars($_GET['message']))."' WHERE id='".intval($_GET['moodid'])."'");
			showmessage('lighting:lighting_inc_php_5', 'plugin.php?id=lighting&mod=user_mood');
		}
	}
	$query = DB::query("SELECT * FROM ".DB::table('lighting')." WHERE id='".intval($_GET['moodid'])."'");
	$moodlist_edit = array();
	while($mood_edit = DB::fetch($query)){
		$moodlist_edit[] = $mood_edit;
	}
	
}elseif($_GET['mod'] == 'members_mood'){
	$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('lighting')."");
	$page = $_G['page'] > 10 ? 1 : $_G['page'];
	$start_limit = ($page - 1) * 10;
	$multipage = multi($num, 10, $page, "plugin.php?id=lighting&mod={$_GET[mod]}");
	$query = DB::query("SELECT * FROM ".DB::table('lighting')." ORDER BY id DESC LIMIT $start_limit, 10");
	$moodlist_members = array();
	while($mood_members = DB::fetch($query)){
		$mood_members['dateline'] = dgmdate($mood_members['dateline'], 'dt', $_G['setting']['timeoffset']);
		$moodlist_members[] = $mood_members;
	}
	 
}elseif($_GET['mod'] == 'admin_check'){
	if($_G['adminid'] != '1'){
		showmessage('group_nopermission', 'plugin.php?id=lighting');
	}
	if(submitcheck('admin_del')){
		$moodsadd = '';
		if($moodids = dimplode($_GET['delete'])){
			$moodsadd = "id IN ($moodids)";
		}
		if(!$moodsadd){
			showmessage('lighting:lighting_inc_php_2', 'plugin.php?id=lighting&mod=admin_check');
		}else{
			DB::query("DELETE FROM ".DB::table('lighting')." WHERE $moodsadd");
			showmessage('lighting:lighting_inc_php_6', dreferer());
		}
	}
	$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('lighting')."");
	$page = $_G['page'] > 10 ? 1 : $_G['page'];
	$start_limit = ($page - 1) * 10;
	$multipage = multi($num, 10, $page, "plugin.php?id=lighting&mod={$_GET[mod]}");
	$query = DB::query("SELECT * FROM ".DB::table('lighting')." ORDER BY id DESC LIMIT $start_limit, 10");
	$moodlist_admin = array();
	while($mood_admin = DB::fetch($query)){
		$mood_admin['dateline'] = dgmdate($mood_admin['dateline'], 'dt', $_G['setting']['timeoffset']);
		$moodlist_admin[] = $mood_admin;
	}

}elseif($_GET['mod'] == 'add_mood'){
	if(submitcheck('Submit_member')){
//		if(!$_GET['bgpic']){
//			showmessage('lighting:lighting_inc_php_8');
//		}elseif(!$_GET['mood']){
//			showmessage('lighting:lighting_inc_php_9');
//		}else
        if(!$_GET['message']){
			showmessage('lighting:lighting_inc_php_4');
		}else{
//			DB::query("INSERT INTO ".DB::table('lighting')." (uid,username,bgpic,mood,message,dateline) VALUES ('$_G[uid]','$_G[username]','".intval($_GET['bgpic'])."','".intval($_GET['mood'])."','".daddslashes(dhtmlspecialchars($_GET['message']))."','$_G[timestamp]')");

			DB::query("INSERT INTO ".DB::table('lighting')." (uid,username,message,dateline) VALUES ('$_G[uid]','$_G[username]','".daddslashes(dhtmlspecialchars($_GET['message']))."','$_G[timestamp]')");
			showmessage('lighting:lighting_inc_php_10', 'plugin.php?id=lighting');
		}
	}

}else{
	showmessage('undefined_action', NULL, 'HALTED');
}

include template('lighting:lighting');
?>