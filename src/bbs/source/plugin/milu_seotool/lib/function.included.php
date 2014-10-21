<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


//google_query_included('d');

//百度收录查询
function baidu_query_included($article_url){
	global $_G;
	$url = 'http://www.baidu.com/s?wd='.urlencode($article_url);
	$content = st_get_contents($url);
	preg_match("/<span class=\"g\">(.*)<\/span>/", $content, $temp);
	preg_match('/<\/b>&nbsp;(.*)&nbsp;/', $temp[1], $screenshot);
	$included_str = $screenshot[1];
	if(!$included_str) return FALSE; 
	$dateline = included_time_format($included_str);
	return $dateline;
}



//谷歌收录查询
function google_query_included($article_url){
	global $_G;
	$url = 'http://www.google.com.hk/search?q='.urlencode($article_url);
	$article_url = urlencode($article_url);
	$url = "http://www.google.com.hk/search?source=hp&q=$article_url&fp=f22d456bb24e9df3";
	$content = st_get_contents($url, array('referer' => $url, 'cache' => -1));
	$content = dstripslashes($content);
	if(strexists($content, '<form action="Captcha" method="get">')) {
		cpmsg_error(stlang('google_limit'));
	}
	$cut_temp_arr = st_str_cut($content, 'classx3dx22f slpx22x3e', 'x3c/divx3ex3cspan classx3d');//论坛
	$temp_arr[1] = $cut_temp_arr[0];
	if($temp_arr[1]){
		$dateline_str = $temp_arr[1];
		$dateline_arr = explode('-', $dateline_str);
		$dateline_str = trim($dateline_arr[0]);
	}else{
		$temp_arr = array();
		$cut_temp_arr = st_str_cut($content, 'x3cspan classx3dx22fx22x3e', '- x3c/spanx3e');//非论坛
		$temp_arr[1] = $cut_temp_arr[0];
		if($temp_arr[1]){
			$dateline_str = $temp_arr[1];
		}
	}
	$dateline = included_time_format($dateline_str);
	return $dateline;
}

function article_ping($article_url, $type = 'baidu'){
	global $_G;
	$ping_func = $type.'_ping';
	$result = $ping_func($article_url, $_G['sitename'], $_G['siteurl'], $rss_url);
	return $result;
}

function baidu_ping($article_url, $sitename, $siteurl, $rssurl = ''){
	$ping_rpcurl = 'http://ping.baidu.com/ping/RPC2';;
	$xml = "
    <?xml version=\"1.0\" encoding=\"UTF-8\"?>
    <methodCall>
    <methodName>weblogUpdates.extendedPing</methodName>
    <params>
    <param><value><string>$sitename</string></value></param>
    <param><value><string>$siteurl</string></value></param>
    <param><value><string>$article_url</string></value></param>
    <param><value><string>$rssurl</string></value></param>
    </params>
    </methodCall>";
	$result = dfsockopen($ping_rpcurl, 0, $xml, '', FALSE, '', 15, TRUE, 1, false);
	if (strexists($result, "<int>0</int>")){//成功
       return 1;
	}else{
       return -1;
	}
}


function google_ping($article_url, $sitename, $siteurl, $rssurl = ''){
	$ping_rpcurl = 'http://blogsearch.google.com/ping/RPC2';
	$xml = "
    <?xml version=\"1.0\" encoding=\"UTF-8\"?>
    <methodCall>
	  <methodName>weblogUpdates.extendedPing</methodName>
	  <params>
		<param><value>$sitename</value></param>
		<param><value>$siteurl</value></param>
		<param><value>$article_url</value></param>
		<param><value>$rssurl</value></param>
	  </params>
	</methodCall>";
	$result = dfsockopen($ping_rpcurl, 0, $xml);
	if (strexists($result, "<boolean>0</boolean>")){//成功
       return 1;
	}else{
       return -1;
	}
}


function included_time_format($time_str){
	global $_G;
	if(!$time_str) return FALSE;
	if(strexists($time_str, stlang('hour_before'))){
		$hour = str_replace(stlang('hour_before'), '', $time_str);
		$dateline = $_G['timestamp'] - trim($hour)*3600;
	}else if(strexists($time_str, stlang('minute_before'))){
		$minute = str_replace(stlang('minute_before'), '', $time_str);
		$dateline = $_G['timestamp'] - trim($minute)*60;
	}else if(strexists($time_str, stlang('day_before'))){
		$day = str_replace(stlang('day_before'), '', $time_str);
		$dateline = $_G['timestamp'] - trim($day)*3600*24;
	}else{
		$time_str_arr = explode('|', stlang('time_str'));
		$time_str = str_replace($time_str_arr, array('-', '-', '', ':', ':', ''), $time_str);
		$dateline = strtotime($time_str);
	}
	return $dateline;
}



//$op_type = 1 百度收录查询 2谷歌收录查询 3百度ping 4谷歌ping
function batch_run($ids_arr, $op_type, $data_type){
	global $_G;
	foreach((array)$ids_arr as $k => $aid){
		$article_url = get_article_url($aid, $data_type);
		$setarr = array();
		if($op_type == 1){//百度收录
			$setarr['baidu_included'] = baidu_query_included($article_url);
			$setarr['baidu_modify_dateline'] = $_G['timestamp'];
		}else if($op_type == 2){//谷歌收录
			$setarr['google_included'] = google_query_included($article_url);
			$setarr['google_modify_dateline'] = $_G['timestamp'];
		}else if($op_type == 3){//百度ping
			$setarr['baidu_ping'] = article_ping($article_url, 'baidu') > 0 ? $_G['timestamp'] : -1;
		}else if($op_type == 4){//谷歌ping
			$setarr['google_ping'] = article_ping($article_url, 'google') > 0 ? $_G['timestamp'] : -1;
		}
		update_included_data($aid, $setarr, $data_type);//更新状态
	}
}

//$data_type 0论坛 1门户
function get_article_url($aid, $data_type = 0){
	global $_G;
	if($data_type == 1){
		if($_G['setting']['rewritestatus'] && in_array('portal_article', $_G['setting']['rewritestatus'])) {
			$url = rewriteoutput('portal_article', 1, '', $aid, 1, '', '');
		} else {
			$url = 'portal.php?mod=view&aid='.$aid;
		}
	}else{
		if($_G['setting']['rewritestatus'] && in_array('forum_viewthread', $_G['setting']['rewritestatus'])) {
			$url = rewriteoutput('forum_viewthread', 1, '', $aid, 1, '', '');
		} else {
			$url = 'forum.php?mod=viewthread&tid='.$aid;
		}
	}
	$url = !strexists($url, 'http://') ? $_G['siteurl'].$url : $url;
	return $url;
}



function update_included_data($aid, $setarr, $data_type = 0){
	if(!$setarr) return;
	$info = DB::fetch_first("SELECT id FROM ".DB::table('milu_seotool_included')." WHERE data_type='$data_type' AND data_id='$aid'");
	if($info['id']){
		DB::update("milu_seotool_included", $setarr, array("id" => $info['id']));
	}else{
		$setarr['data_id'] = $aid;
		$setarr['data_type'] = $data_type;
		DB::insert('milu_seotool_included', $setarr, TRUE);
	}
}


//文章总数 0论坛 1门户
function get_article_count($data_type = 0, $where = ''){
	if($data_type != 1){
		return DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('forum_thread')." WHERE displayorder='0' $where"), 0);
	}else{
		return DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('portal_article_title')." WHERE status='0' $where"), 0);
	}
}


function filter_article_data($ids_arr, $op_type, $data_type = 0){
	if(!$ids_arr) return array();
	$where_sql = " AND data_type='$data_type' AND data_id IN(".dimplode($ids_arr).")";
	if($op_type == 1){//百度收录查询
		$query = DB::query("SELECT data_id FROM ".DB::table('milu_seotool_included')." WHERE baidu_included>0 $where_sql");
	}else if($op_type == 2){//谷歌收录
		$query = DB::query("SELECT data_id FROM ".DB::table('milu_seotool_included')." WHERE google_included>0 $where_sql");
	}else if($op_type == 3){//百度ping
		$query = DB::query("SELECT data_id FROM ".DB::table('milu_seotool_included')." WHERE baidu_ping>0 $where_sql");
	}else if($op_type == 4){//谷歌ping
		$query = DB::query("SELECT data_id FROM ".DB::table('milu_seotool_included')." WHERE google_ping>0 $where_sql");
	}
	while($rs = DB::fetch($query)) {
		$no_id_arr[] = $rs['data_id'];
	}
	$ids_arr = $no_id_arr ? array_diff($ids_arr, $no_id_arr) : $ids_arr;
	return $ids_arr;
}


?>