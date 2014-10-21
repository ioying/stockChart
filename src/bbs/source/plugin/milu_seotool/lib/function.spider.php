<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


//记录日志
function spider_add_log($navtitle) {
	global $_G;
	$spider_id_arr = $_G['cache']['milu_seotool']['config']['spider_id_arr'];
	$spider_type = get_spider_type();
	if(!$spider_type) return false;
	$group_arr = get_page_group();
	$set['page_url'] = "http://".$_SERVER['SERVER_NAME'].$_SERVER["REQUEST_URI"];
	$set['spider_type'] = $spider_id_arr[$spider_type];
	$set['group_parent_id'] = $group_arr['parent_id'];
	$set['group_child_id'] = $group_arr['child_id'];
	$set['status'] = $_G['inshowmessage'] ? 1 : 0;
	$set['page_title'] = $navtitle;
	$set['dateline'] = $_G['timestamp'];
	DB::insert('milu_seotool_spider', $set, TRUE);
}

function get_page_group(){
	global $_G;
	$result_data = array('parent_id' => 0, 'child_id' => 0);
	$group_rules_arr = $_G['cache']['milu_seotool']['config']['spider_group_rules'];
	if(!$group_rules_arr) return $result_data;
	foreach($group_rules_arr as $k => $v){
		if($v['rules']['basescript'] != $_G['basescript']) continue;
		$result_data['parent_id'] = $k;
		if(!$_G['mod']){
			$result_data['child_id'] = 1;//1是首页
			continue;
		}
		foreach((array)$v['child'] as $k2 => $v2){
			$flag = TRUE;
			foreach((array)$v2['rules'] as $k3 => $v3){
				if($_G[$k3] != $v3) $flag = FALSE;
			}
			if(!$v2['rules']) $flag = FALSE;
			if($flag) $result_data['child_id'] = $k2;
		}
	}
	return $result_data;
}



//获取爬虫类型
function get_spider_type(){
	global $_G;
	$spider_type_arr = $_G['cache']['milu_seotool']['config']['spider_type_arr'];
	$spider_set = tool_common_get('spider');
	$spider_set['spider_type'] = unserialize($spider_set['spider_type']);
	$spider_type = strtolower($_SERVER['HTTP_USER_AGENT']);
	if(!is_array($spider_type_arr)) return false;
	foreach($spider_type_arr as $k => $v){
	   if (strpos($spider_type, $k) !== false && in_array($k, $spider_set['spider_type'])){ 
		   return $k;
	   } 
	}
}

//获取用户设定监控的爬虫类型
function get_user_spider_type(){
	global $_G;
	$spider_type_arr = $_G['cache']['milu_seotool']['config']['spider_type_arr'];
	$spider_set = tool_common_get('spider');
	$spider_set['spider_type'] = unserialize($spider_set['spider_type']);
	$new_spider_arr = array();
	foreach($spider_type_arr as $k => $v){
		if(in_array($k, $spider_set['spider_type'])) $new_spider_arr[$k] = $v;
	}
	return $new_spider_arr;
}

?>