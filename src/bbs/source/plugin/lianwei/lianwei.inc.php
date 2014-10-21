<?php
/*
	[Smjy] lianwei      thanks a lot !Mood Wall 
	Copyright (c) 2009-2012 xinlin & smjy(http://www.smjy.org)
	$Id: lianwei.inc.php 2012-8-30 ioying 
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
//	$query = DB::query("SELECT * FROM ".DB::table('lianwei')." ORDER BY id DESC LIMIT 0, 30");
	$query = DB::query("SELECT * FROM ".DB::table('lianwei')." WHERE uid='$_G[uid]' ORDER BY id DESC LIMIT 0, 30");
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
			showmessage('lianwei:lianwei_inc_php_2', 'plugin.php?id=lianwei&mod=user_mood');
		}else{
			DB::query("DELETE FROM ".DB::table('lianwei')." WHERE $moodsadd");
			showmessage('lianwei:lianwei_inc_php_6', dreferer());
		}
	}
	$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('lianwei')." WHERE uid='$_G[uid]'");
	$page = $_G['page'] > 10 ? 1 : $_G['page'];
	$start_limit = ($page - 1) * 10;
	$multipage = multi($num, 10, $page, "plugin.php?id=lianwei&mod={$_GET[mod]}");
	$query = DB::query("SELECT * FROM ".DB::table('lianwei')." WHERE uid='$_G[uid]' ORDER BY id DESC LIMIT $start_limit, 10");
	$moodlist_user = array();
	while($mood_user = DB::fetch($query)){
		$mood_user['dateline'] = dgmdate($mood_user['dateline'], 'dt', $_G['setting']['timeoffset']);
		$moodlist_user[] = $mood_user;
	}
	
}elseif($_GET['mod'] == 'edit_mood' && $_GET['moodid']){
	$check = DB::fetch_first("SELECT id FROM ".DB::table('lianwei')." WHERE id='".intval($_GET['moodid'])."' AND uid='$_G[uid]'");
	if(!$check['id']){
		showmessage('lianwei:lianwei_inc_php_2', 'plugin.php?id=lianwei&mod=user_mood');
	}
	if(submitcheck('Submit_edit')){
		if (!trim($_GET['fathername']) and !trim($_GET['mothername']) ){
			//父母名字不能同时为空
						showmessage('lianwei:lianwei_inc_php_nameplease');
		//if(!trim($_GET['message'])){
		//	showmessage('lianwei:lianwei_inc_php_4');
		}else{
		//	DB::query("UPDATE ".DB::table('lianwei')." SET bgpic='".intval($_GET['bgpic'])."',mood='".intval($_GET['mood'])."',message='".daddslashes(dhtmlspecialchars($_GET['message']))."' WHERE id='".intval($_GET['moodid'])."'");
		
			DB::query("UPDATE ".DB::table('lianwei')." SET gonedate='".daddslashes(dhtmlspecialchars($_GET['gonedate']))."',holyname='".daddslashes(dhtmlspecialchars($_GET['holyname']))."',fathername='".daddslashes(dhtmlspecialchars($_GET['fathername']))."',mothername='".daddslashes(dhtmlspecialchars($_GET['mothername']))."',message='".daddslashes(dhtmlspecialchars($_GET['message']))."' WHERE id='".intval($_GET['moodid'])."'");
			showmessage('lianwei:lianwei_inc_php_5', 'plugin.php?id=lianwei&mod=user_mood');
		}
	}
	$query = DB::query("SELECT * FROM ".DB::table('lianwei')." WHERE id='".intval($_GET['moodid'])."'");
	$moodlist_edit = array();
	while($mood_edit = DB::fetch($query)){
		$moodlist_edit[] = $mood_edit;
	}
	
}elseif($_GET['mod'] == 'members_mood'){
	$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('lianwei')."");
	$page = $_G['page'] > 10 ? 1 : $_G['page'];
	$start_limit = ($page - 1) * 10;
	$multipage = multi($num, 10, $page, "plugin.php?id=lianwei&mod={$_GET[mod]}");
	$query = DB::query("SELECT * FROM ".DB::table('lianwei')." ORDER BY id DESC LIMIT $start_limit, 10");
	$moodlist_members = array();
	while($mood_members = DB::fetch($query)){
		$mood_members['dateline'] = dgmdate($mood_members['dateline'], 'dt', $_G['setting']['timeoffset']);
		$moodlist_members[] = $mood_members;
	}
	 
}elseif($_GET['mod'] == 'admin_check'){
	if($_G['adminid'] != '1'){
		showmessage('group_nopermission', 'plugin.php?id=lianwei');
	}
	if(submitcheck('admin_del')){
		$moodsadd = '';
		if($moodids = dimplode($_GET['delete'])){
			$moodsadd = "id IN ($moodids)";
		}
		if(!$moodsadd){
			showmessage('lianwei:lianwei_inc_php_2', 'plugin.php?id=lianwei&mod=admin_check');
		}else{
			DB::query("DELETE FROM ".DB::table('lianwei')." WHERE $moodsadd");
			showmessage('lianwei:lianwei_inc_php_6', dreferer());
		}
	}
	$num = DB::result_first("SELECT COUNT(*) FROM ".DB::table('lianwei')."");
	$page = $_G['page'] > 10 ? 1 : $_G['page'];
	$start_limit = ($page - 1) * 10;
	$multipage = multi($num, 10, $page, "plugin.php?id=lianwei&mod={$_GET[mod]}");
	$query = DB::query("SELECT * FROM ".DB::table('lianwei')." ORDER BY id DESC LIMIT $start_limit, 10");
	$moodlist_admin = array();
	while($mood_admin = DB::fetch($query)){
		$mood_admin['dateline'] = dgmdate($mood_admin['dateline'], 'dt', $_G['setting']['timeoffset']);
		$moodlist_admin[] = $mood_admin;
	}

}elseif($_GET['mod'] == 'add_mood'){
	if(submitcheck('Submit_member')){
			if(!trim($_GET['fathername']) and !trim($_GET['mothername'] )){
			//父母名字不能同时为空
						showmessage('lianwei:lianwei_inc_php_nameplease');
//			showmessage('lianwei:lianwei_inc_php_8');
//		if(!$_GET['bgpic']){
//			showmessage('lianwei:lianwei_inc_php_8');
//		}elseif(!$_GET['mood']){
//			showmessage('lianwei:lianwei_inc_php_9');
//		}elseif(!$_GET['message']){
//			showmessage('lianwei:lianwei_inc_php_4');
		}else{
//			DB::query("INSERT INTO ".DB::table('lianwei')." (uid,username,bgpic,mood,message,dateline) VALUES ('$_G[uid]','$_G[username]','".intval($_GET['bgpic'])."','".intval($_GET['mood'])."','".daddslashes(dhtmlspecialchars($_GET['message']))."','$_G[timestamp]')");
            //莲位编号自动增加
			$maxlianweiid = DB::result_first("SELECT max(lianweiid) FROM ".DB::table('lianwei')."   ");
			$maxlianweiid=$maxlianweiid+1;

//法名为空，则生成法名			
			if(!$_GET['holyname'] ){
			//法名字典  妙法莲花经  mflhj.txt  70193字 // ×××××莲位大于字典数时处理××××××
			//打开文件流,fopen不会把文件整个加载到内存
			
            $f = fopen("./source/plugin/lianwei/mflhj.txt","r");
			if (!$f){ 
			showmessage(getcwd());
			}
            //移动文件指针到$maxlianweiid utf8每个中文占3字节
			
             fseek($f,$maxlianweiid*3);
			             //fseek($f,$maxlianweiid);
			//读取法名第一个字	
			$firstholyname = DB::result_first("SELECT content FROM ".DB::table('lianweisetup')." where project='firstholyname'   ");
            //读取1个汉字，即为法名第二个字
			$newholyname = $firstholyname.fread($f,3);
			//showmessage($newholyname.'i'.$firstholyname);
			//关闭数据流
			fclose($f);
			}else{
			//法名合法性校验
			//showmessage($_GET['holyname']);
			$newholyname = $_GET['holyname'];
			}
			
			
			DB::query("INSERT INTO ".DB::table('lianwei')." (uid,username,fathername,mothername,message,dateline,gonedate,lianweiid,holyname) VALUES ('$_G[uid]','$_G[username]','".daddslashes(dhtmlspecialchars($_GET['fathername']))."','".daddslashes(dhtmlspecialchars($_GET['mothername']))."','".daddslashes(dhtmlspecialchars($_GET['message']))."','$_G[timestamp]','".daddslashes(dhtmlspecialchars($_GET['gonedate']))."','$maxlianweiid','".daddslashes(dhtmlspecialchars($newholyname))."')");
			showmessage('lianwei:lianwei_inc_php_10', 'plugin.php?id=lianwei');
		}
	}

}else{
	showmessage('undefined_action', NULL, 'HALTED');
}

include template('lianwei:lianwei');
?>