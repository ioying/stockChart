<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function get_rank_data($keyword, $view_num = 100, $update = 0){
	global $_G;
	$daytime = date('Ymd');
	$cache_key = md5($keyword);
	$keyword_set = tool_common_get('keyword');
	$st_cache_data = $keyword_set['rank_data'];
	$cache_keyword_data = $st_cache_data['data'];
	if($st_cache_data['daytime'] != $daytime) {
		unset($st_cache_data);
		save_syscache('milu_seotool_keyword_data', array());
	}
	if(!$st_cache_data || $update == 1 || !$st_cache_data['data'][$cache_key]){
		$keyword = st_addslashes($keyword);
		$base_sql = "SELECT k.*,r.* FROM ".DB::table('milu_seotool_keyword')." as k Inner Join ".DB::table('milu_seotool_keyword_rank')." as r ON r.kid=k.kid WHERE name='$keyword' AND ";
		$info = DB::fetch_first($base_sql."r.daytime='$daytime'");
		if($info){
			$rank_arr = explode(',', $info['rank']);
		}else{
			$rank_arr = get_ranking($keyword, $view_num);
			$keyword_info = DB::fetch_first("SELECT kid FROM ".DB::table('milu_seotool_keyword')." WHERE name='$keyword'");
			if(!$keyword_info){
				$kid = DB::insert('milu_seotool_keyword', array('name' => $keyword), TRUE);
			}else{
				$kid = $keyword_info['kid'];
			}
			$set['kid'] = $kid;
			$set['daytime'] = $daytime;
			$set['rank'] = implode(',', $rank_arr);
			DB::insert('milu_seotool_keyword_rank', $set, TRUE);
		}
		//查询排名上升还是下降
		$last_info = DB::fetch_first($base_sql."r.daytime<'$daytime' ORDER BY daytime DESC LIMIT 1");
		$now_rank = min($rank_arr);
		$last_rank = min(explode(',', $last_info['rank']));
		$keyword_trend = $last_rank - $now_rank;
		if(!$last_rank && $now_rank) $keyword_trend = '+';
		if($last_rank && !$now_rank) $keyword_trend = '-';
		$keyword_data = array('keyword' => $keyword,  'rank' => $rank_arr, 'trend' => $keyword_trend);
		$cache_keyword_data[$cache_key] = $keyword_data;
		$st_cache_data['daytime'] = $daytime;
		$st_cache_data['data'] = $cache_keyword_data;
		tool_common_set('keyword', array('rank_data' => $st_cache_data));
	}else{//缓存
		$keyword_data = $cache_keyword_data[$cache_key];
	}
	return $keyword_data;
}

// $rn每页数量 pn目前的数量
function get_ranking($keyword,$view_num = 100, $pn = 0, $data_arr = array()){
	global $_G;
	$siteurl = $_G['siteurl'];
	$url_info = st_get_host_info($siteurl);
	$host = $url_info['host'];
	$rn = 100;
	$search_url = 'http://www.baidu.com/s?wd='.$keyword.'&pn='.$pn.'&rn='.$rn.'';
	$content = st_get_contents($search_url.$host, array('cache' => 3600));
	preg_match_all('/<div class="f13"><span class="g">(.*?)<\/span>/i',$content,$arr);
	foreach($arr[1] as $k => $v){
		$v = st_striptext($v);
		$v_arr = explode('>', $v);
		$match_url = $v_arr[0];
		if(strexists($match_url, $host)) $data_arr[] = $pn + $k+1;
	}
	$pn += $rn;
	if($pn < $view_num) return get_ranking($keyword, $view_num, $pn, $data_arr);
	return $data_arr;
}

?>