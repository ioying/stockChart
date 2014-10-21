<?php
/*
	[Smjy] stock      thanks a lot !Mood Wall 
	Copyright (c) 2009-2012 xinlin & smjy(http://www.smjy.org)
	$Id: stock.inc.php 2012-8-30 ioying 
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
//	$query = DB::query("SELECT * FROM ".DB::table('stock')." ORDER BY id DESC LIMIT 0, 30");
	$query = DB::query("SELECT * FROM ".DB::table('stock')." WHERE uid='$_G[uid]' ORDER BY id DESC LIMIT 0, 30");
	while($mood = DB::fetch($query)){
		$mood['dateline'] = dgmdate($mood['dateline'], 'dt', $_G['setting']['timeoffset']);
		$moodlist[]=$mood;
	}

}elseif($_GET['mod'] == 'user_formula'){
if(submitcheck('test')){
showmessage('test');
}
	if(submitcheck('del_formula')){
		$moodsadd = '';
		if($moodids = dimplode($_GET['delete'])){
			$moodsadd = "id IN ($moodids)";
		}
		showmessage($moodids);
		if(!$moodsadd){
			showmessage('stock:stock_inc_php_2', 'plugin.php?id=stock&mod=user_formula');
		}else{
			DB::query("DELETE FROM ".DB::table('stock')." WHERE $moodsadd");
			showmessage('stock:stock_inc_php_6', dreferer());
		}
	}
//	showmessage('here2');
	$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('stock')." WHERE uid='$_G[uid]'");
	$page = $_G['page'] > 10 ? 1 : $_G['page'];
	$start_limit = ($page - 1) * 10;
	$multipage = multi($num, 10, $page, "plugin.php?id=stock&mod={$_GET[mod]}");
	$query = DB::query("SELECT * FROM ".DB::table('stock')." WHERE uid='$_G[uid]' ORDER BY id DESC LIMIT $start_limit, 10");
	$moodlist_user = array();
	while($mood_user = DB::fetch($query)){
		$mood_user['dateline'] = dgmdate($mood_user['dateline'], 'dt', $_G['setting']['timeoffset']);
		$moodlist_user[] = $mood_user;
	}
	
}elseif($_GET['mod'] == 'edit_formula' && $_GET['moodid']){
	$check = DB::fetch_first("SELECT id FROM ".DB::table('stock')." WHERE id='".intval($_GET['moodid'])."' AND uid='$_G[uid]'");
	if(!$check['id']){
		showmessage('stock:stock_inc_php_2'.'8888', 'plugin.php?id=stock&mod=user_formula');
	}
	if(submitcheck('Submit_edit')){
//		if (!trim($_GET['fathername']) and !trim($_GET['mothername']) ){
			if(!trim($_GET['formulaname']) or !trim($_GET['formula'] )){
			//公式名字和代码不能 为空
						showmessage('stock:stock_inc_php_nameplease');
		//if(!trim($_GET['message'])){
		//	showmessage('stock:stock_inc_php_4');
		}else{

		
			DB::query("UPDATE ".DB::table('stock')." SET 
			formulaname='".daddslashes(dhtmlspecialchars($_GET['formulaname']))."',
			description='".daddslashes(dhtmlspecialchars($_GET['description']))."',			
			comment='".daddslashes(dhtmlspecialchars($_GET['comment']))."',			
			formula='".daddslashes(dhtmlspecialchars($_GET['formula']))."',						
			mainmap='".intval($_GET['mainmap'])."',
			message='".daddslashes(dhtmlspecialchars($_GET['message']))."' 
			WHERE id='".intval($_GET['moodid'])."'");
			showmessage('stock:stock_inc_php_5', 'plugin.php?id=stock&mod=user_formula');
		}
	}
	$query = DB::query("SELECT * FROM ".DB::table('stock')." WHERE id='".intval($_GET['moodid'])."'");
	$moodlist_edit = array();
	while($mood_edit = DB::fetch($query)){
		$moodlist_edit[] = $mood_edit;
	}
	
}elseif($_GET['mod'] == 'members_formula'){
	$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('stock')."");
	$page = $_G['page'] > 10 ? 1 : $_G['page'];
	$start_limit = ($page - 1) * 10;
	$multipage = multi($num, 10, $page, "plugin.php?id=stock&mod={$_GET[mod]}");
	$query = DB::query("SELECT * FROM ".DB::table('stock')." ORDER BY id DESC LIMIT $start_limit, 10");
	$moodlist_members = array();
	while($mood_members = DB::fetch($query)){
		$mood_members['dateline'] = dgmdate($mood_members['dateline'], 'dt', $_G['setting']['timeoffset']);
		$moodlist_members[] = $mood_members;
	}
	 
}elseif($_GET['mod'] == 'admin_check'){
	if($_G['adminid'] != '1'){
		showmessage('group_nopermission', 'plugin.php?id=stock');
	}
	if(submitcheck('admin_del')){
		$moodsadd = '';
		if($moodids = dimplode($_GET['delete'])){
			$moodsadd = "id IN ($moodids)";
		}
	//	showmessage($moodids);
		if(!$moodsadd){
			showmessage('stock:stock_inc_php_2', 'plugin.php?id=stock&mod=admin_check');
		}else{
			DB::query("DELETE FROM ".DB::table('stock')." WHERE $moodsadd");
			showmessage('stock:stock_inc_php_6', dreferer());
		}
	}
	$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('stock')."");
	$page = $_G['page'] > 10 ? 1 : $_G['page'];
	$start_limit = ($page - 1) * 10;
	$multipage = multi($num, 10, $page, "plugin.php?id=stock&mod={$_GET[mod]}");
	$query = DB::query("SELECT * FROM ".DB::table('stock')." ORDER BY id DESC LIMIT $start_limit, 10");
	$moodlist_admin = array();
	while($mood_admin = DB::fetch($query)){
		$mood_admin['dateline'] = dgmdate($mood_admin['dateline'], 'dt', $_G['setting']['timeoffset']);
		$moodlist_admin[] = $mood_admin;
	}

}elseif($_GET['mod'] == 'add_Formula'){
	if(submitcheck('Submit_member')){
			if(!trim($_GET['formulaname']) or !trim($_GET['formula'] )){
			//公式名字和代码不能同时为空
						showmessage('stock:stock_inc_php_nameplease');

		}else{
//								showmessage($_GET['formulaname']);
//description  comment  
			
			DB::query("INSERT INTO ".DB::table('stock')." (uid,username,formulaname,description, mainmap,comment,formula,dateline) VALUES ('$_G[uid]','$_G[username]','".daddslashes(dhtmlspecialchars($_GET['formulaname']))."','".daddslashes(dhtmlspecialchars($_GET['description']))."','".intval($_GET['mainmap'])."','".daddslashes(dhtmlspecialchars($_GET['comment']))."','".daddslashes(dhtmlspecialchars($_GET['formula']))."','$_G[timestamp]')");
			showmessage('stock:stock_inc_php_10', 'plugin.php?id=stock');
		}
	}

}else{
	showmessage('undefined_action', NULL, 'HALTED');
}

include template('stock:stock');
?>