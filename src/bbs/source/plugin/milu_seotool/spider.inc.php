<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once(DISCUZ_ROOT.'source/plugin/milu_seotool/config.inc.php');
sload('F:spider,F:copyright');
$header_arr = array('spider_set', 'spider_list', 'area_data_count', 'trend_data_count');
if(!VIP) unset($header_arr[array_search('area_data_count', $header_arr)]);
$args = array('default_ac' => 'spider_set');
$spider_id_arr = $milu_seotool_config['spider_id_arr'];
$spider_type_arr = $milu_seotool_config['spider_type_arr']; 
$spider_set = tool_common_get('spider');
$spider_set['spider_type'] = dunserialize($spider_set['spider_type']);
seo_tpl($args);

function spider_set(){
	global $_G,$pluin_info,$spider_type_arr,$spider_set;
	if($_GET['editsubmit']){
		$set = $_GET['set'];
		$set['spider_type'] = serialize($_GET['spider_type']);
		tool_common_set('spider', $set);
		cpmsg(stlang('op_success'), PLUGIN_GO."spider", 'succeed');	
	}else{
		$info = $spider_set;
		$show .= seoOutput::show_title(stlang('base_set'));
		
		$show .=  seoOutput::show_tr(
				array(
					'name' => stlang('spider_is_open'),
					'desc' => '',
					'arr' => array(
						'name' => 'is_open_spider',
						'info' => $info,
						'int_val' => 2,
						'lang_type' => 2,
					),
				)
				,'radio');
		$show .=  seoOutput::show_tr(
				array(
					'name' => stlang('spider_set_title'),
					'desc' => stlang('spider_set_title_notice'),
					'arr' => array(
						'name' => 'spider_type',
						'info' => $info,
						'multiple' => TRUE,
						'flag' => 2,
						'option_arr' => $spider_type_arr,
					),
				)
				,'select');	

		$info['show'] = $show;
		$info['tpl'] = 'common_set';
		return $info;
	}
	
}

function spider_list(){
	global $_G,$spider_id_arr,$spider_type_arr;
	$spider_type_arr = get_user_spider_type();
	$set = $_GET['set'];
	$set['title'] = $set['title'] ? $set['title'] : $_GET['title'];
	$set['spider_type'] = $_GET['spider_type'];
	$set['search_dateline_start'] = $set['search_dateline_start'] ? strtotime($set['search_dateline_start']) : '';
	$set['search_dateline_end'] = $set['search_dateline_end'] ? strtotime($set['search_dateline_end']) : '';
	if($set['search_dateline_start'] || $set['search_dateline_end']){
		$set['search_dateline_start'] =  $set['search_dateline_start'] ? $set['search_dateline_start'] : $_G['timestamp'];
		$set['search_dateline_end'] = $set['search_dateline_end'] ? $set['search_dateline_end'] : $_G['timestamp'];
	}
	if($_GET['fast_search']) $set = array();
	$set['fast_search'] = $_GET['fast_search'];
	$search_info = $set;
	$spider_type_new_arr['all'] = stlang('all');
	$spider_type_new_arr = array_merge($spider_type_new_arr, $spider_type_arr);
	
	$search_show .=  stlang('title_url_keyword').' '.seoOutput::input(
		array(
		'name' => 'title',
		'int_val' => '',
	),$search_info);
	
	$search_show .=  ' '.stlang('spider_type').' '.seoOutput::select(
		array('option_arr' => $spider_type_new_arr,
		'name' => 'spider_type',
		'int_val' => 'all',
		'flag' => 2,
	),$search_info);
	
	$search_show .=  ' '.stlang('spider_date').' '.seoOutput::dateline(
		array('option_arr' => $spider_type_new_arr,
		'name' => 'search_dateline',
		'int_val' => 10,
		'date_type' => 2,
	),$search_info);
		
	$fast_search_arr = array(1 => stlang('baidu_today_spider_log'), 2 =>stlang('dead_link')); 
	if(!VIP) unset($fast_search_arr[2]);
	$fast_search = '';
	foreach($fast_search_arr as $k => $v){
		$current = isset($search_info['fast_search']) && $k == $search_info['fast_search'] ? 'class="current"' : '';
		$link = '?'.PLUGIN_GO.'spider&myac='.$_GET['myac'].'&page='.$page.'&data_type'.$search_info['data_type'].'&fast_search='.$k;
		$fast_search .= '<li '.$current.'><a href="'.$link.'">'.$v.'</a></li>';
	}
	$perpage = 25;
	$page = $_GET['page'] ? intval($_GET['page']) : 1;
	$start = ($page-1)*$perpage;
	$mpurl = get_args_str($search_info);
	$mpurl = '?'.PLUGIN_GO.'spider&myac='.$_GET['myac'].$mpurl;
	$where_sql = ' WHERE 1=1 ';
	
	$spider_id = $spider_id_arr[$set['spider_type']];
	
	if($spider_id){
		$where_sql .= " AND spider_type='".$spider_id."' ";
	}
	
	if($set['search_dateline_start'] && $set['search_dateline_start']){
		$where_sql .= " AND dateline>'$set[search_dateline_start]' AND dateline<'$set[search_dateline_end]' ";
	}
	
	if($set['title']){
		$where_sql .= " AND ( page_title like '%".$set['title']."%' OR page_url like '%".$set['title']."%')";
	}
	if($set['fast_search']){
		if($set['fast_search'] == 1){
			$dateline = strtotime(date('Y-m-d'));
			$where_sql = " WHERE spider_type='".$spider_id_arr['baiduspider']."' AND dateline>'$dateline' ";
		}
		if($set['fast_search'] == 2){
			$where_sql = " WHERE status='1' ";
		}
	}
	
	$count =  DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('milu_seotool_spider')." $where_sql"), 0);
	$query = DB::query("SELECT * FROM ".DB::table('milu_seotool_spider')." $where_sql ORDER BY dateline DESC LIMIT $start,$perpage");
	$spider_id_arr = array_flip($spider_id_arr); 
	$group_arr = $_G['cache']['milu_seotool']['config']['spider_group_rules'];
	if($count){
		while($rs = DB::fetch($query)) {
			$rs['parent_name'] = $group_arr[$rs['group_parent_id']]['name'];
			$rs['parent_name'] = $rs['parent_name'] ? $rs['parent_name'] : stlang('other');
			$rs['child_name'] = $group_arr[$rs['group_parent_id']]['child'][$rs['group_child_id']]['name'];
			$rs['parent_name'] = $rs['group_parent_id'] ? $rs['parent_name'] : stlang('other');
			$rs['child_name'] = $rs['group_child_id'] ? $rs['child_name'] : stlang('other');
			$rs['show_group'] = $rs['parent_name'].'-'.$rs['child_name'];
			if($rs['group_parent_id'] == 0 &&$rs['group_child_id'] == 0) $rs['show_group'] = stlang('other');
			
			$rs['show_status'] = $rs['status'] == 0 ? seoOutput::show_status('right').stlang('status_normal') : seoOutput::show_status('error').stlang('dead_link');
			$rs['dateline'] = $rs['dateline'] ? dgmdate($rs['dateline'], 'u') : '';
			$rs['spider_type'] = $spider_type_arr[$spider_id_arr[$rs['spider_type']]];
			$rs['show_title'] = cutstr(trim($rs['page_title']), 45);
			$rs['show_url'] = cutstr(trim($rs['page_url']), 65);
			$list[] = $rs;
		}
	}
	$info['count'] = $count;
	$info['list'] = $list;
	$info['multipage'] = multi($count, $perpage, $page, $mpurl);
	
	
	$info['show_title'] = stlang('spider_log_list');
	$info['fast_search'] = $fast_search;
	$info['search_show'] = dstripslashes($search_show);
	$info['tpl'] = 'spider_list';
	return $info;
}

//爬行区域统计
function area_data_count(){
	global $_G,$view_types_arr,$view_search_type,$spider_id_arr,$spider_type_arr;
	$spider_type_arr = get_user_spider_type();
	$data_types_default = array_slice ($spider_type_arr, 0, 2);
	$view_info['data_types'] = $_GET['data_types'] ? $_GET['data_types'] : reset(array_keys($spider_type_arr));
	$view_info['start_dateline'] = $_GET['start_dateline'] ? strtotime($_GET['start_dateline']) : '';
	$view_info['end_dateline'] = $_GET['end_dateline'] ? strtotime($_GET['end_dateline']) : '';
	$view_info['start_dateline'] =  $view_info['start_dateline'] ? $view_info['start_dateline'] : $_G['timestamp'] - 3600*24*7;
	$view_info['end_dateline'] = $view_info['end_dateline'] ? $view_info['end_dateline'] : $_G['timestamp'];
	$dateline_arr = st_dayRange($view_info['start_dateline'], $view_info['end_dateline']);
	$from = $dateline_arr[1]['from'];
	$end = $dateline_arr[count($dateline_arr)]['end'];
	$group_data = array();
	$group_arr = $_G['cache']['milu_seotool']['config']['spider_group_rules'];
	foreach($group_arr as $k => $v){
		foreach($v['child'] as $k2 => $v2){
			$group_data[$k.'_'.$k2]['name'] = $v['name'].'-'.$v2['name'];
		}
	}
	$title = date('Y-m-d', $from).' '.stlang('to_').' '.date('Y-m-d', $end). ' '.$spider_type_arr[$view_info['data_types']].stlang('spider_area_flash');
	
	$FC = get_flash_obj(array('flash_type' => 'Pie3D', 'caption_title' => $caption_title, 'title' => $title, 'width' => '850', 'height' => 500));
	
	$sql = " WHERE dateline<'$end' AND dateline>'$from'";
	
	$spider_id = $spider_id_arr[$view_info['data_types']];
	if($spider_id){
		$sql .= "AND spider_type='$spider_id'";
	}
	$query = DB::query("SELECT spider_type,dateline,id,group_child_id,group_parent_id FROM ".DB::table('milu_seotool_spider').$sql);
	while($rs = DB::fetch($query)) {
		$group_data[$rs['group_parent_id'].'_'.$rs['group_child_id']]['count']++;
	}
	$flag = '';
	foreach($group_data as $k1 => $v1){
		if(!$v1['count']) continue;
		if(!$v1['name']){
			$temp_arr = explode('_', $k1);
			$name = $group_arr[$temp_arr[0]]['name'];
			$v1['name'] = $name ? $name.'-'.stlang('other') : stlang('other');
		}
		$FC->addChartData($v1['count'], "name=".$v1['name']);
	}
	$info['chart_flash'] = $FC->renderChart("", false);
	$info['show'] = implode('', $show_arr);
	$info['view_show']['data_type'] = seoOutput::select( array('name' => 'data_types', 'option_arr' => $spider_type_arr, 'flag' => 2), $view_info);
	$info['start_dateline'] = date('Y-m-d', $view_info['start_dateline']);
	$info['end_dateline'] = date('Y-m-d', $view_info['end_dateline']);
	$info['tpl'] = 'spider_area_count';
	$info['show_title'] = stlang('area_data_count');
	return $info;
}



//数据趋势
function trend_data_count(){
	global $_G,$view_types_arr,$view_search_type,$spider_id_arr;
	$spider_type_arr = get_user_spider_type();
	$data_types_default = array_slice ($spider_type_arr, 0, 2);
	$view_info['data_types'] = $_GET['data_types'] ? $_GET['data_types'] : array_keys($data_types_default);
	$view_info['start_dateline'] = $_GET['start_dateline'] ? strtotime($_GET['start_dateline']) : '';
	$view_info['end_dateline'] = $_GET['end_dateline'] ? strtotime($_GET['end_dateline']) : '';
	$view_info['start_dateline'] =  $view_info['start_dateline'] ? $view_info['start_dateline'] : $_G['timestamp'] - 3600*24*7;
	$view_info['end_dateline'] = $view_info['end_dateline'] ? $view_info['end_dateline'] : $_G['timestamp'];
	$dateline_arr = st_dayRange($view_info['start_dateline'], $view_info['end_dateline']);
	$from = $dateline_arr[1]['from'];
	$end = $dateline_arr[count($dateline_arr)]['end'];
	
	
	$title = date('Y-m-d', $from).' '.stlang('to_').' '.date('Y-m-d', $end). ' '.stlang('spider_trend_flash');
	
	$FC = get_flash_obj(array('caption_title' => $caption_title, 'title' => $title, 'width' => '100%', 'height' => 400, 'yAxisName' => '次'));
	
	$sql = " WHERE dateline<'$end' AND dateline>'$from'";
	
	$spider_id_data_arr = get_spider_id($view_info['data_types']);
	if($spider_id_data_arr){
		$sql .= "AND spider_type IN(".dimplode($spider_id_data_arr).")" ;
	}
	$query = DB::query("SELECT spider_type,dateline,id FROM ".DB::table('milu_seotool_spider').$sql);
	while($rs = DB::fetch($query)) {
		foreach($dateline_arr as $k => $v){
			if($rs['dateline'] < $v['end'] && $rs['dateline'] > $v['from']){
				$dateline_arr[$k]['count'][$rs['spider_type']]++;
			}
		}
	}
	$flag = '';
	foreach($view_info['data_types'] as $k1 => $v1){
		$FC->addDataset($spider_type_arr[$v1]);
		$spider_id = $spider_id_arr[$v1];
		foreach($dateline_arr as $k => $v){
			$key_str = $v1.$k1;
			$flag = $flag ? $flag : $key_str;
			if($flag && $key_str == $flag) {
				$FC->addCategory($v['name']);
			}
			$FC->addChartData($v['count'][$spider_id]);
		}
	}
	$info['chart_flash'] = $FC->renderChart("", false);
	
	$info['show'] = implode('', $show_arr);
	$info['view_show']['data_type'] = seoOutput::checkbox( array('name' => 'data_types', 'option_arr' => $spider_type_arr), $view_info);
	$info['start_dateline'] = date('Y-m-d', $view_info['start_dateline']);
	$info['end_dateline'] = date('Y-m-d', $view_info['end_dateline']);
	$info['tpl'] = 'spider_count_trend';
	return $info;
}

function get_spider_id($data){
	global $spider_id_arr;
	foreach((array)$data as $k => $v){
		$data[$k] = $spider_id_arr[$v];
	}
	return $data;
}
?>