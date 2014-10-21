<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once(DISCUZ_ROOT.'source/plugin/milu_seotool/config.inc.php');
sload('F:included,F:copyright');
$header_arr = array('included_set', 'included_forum_list', 'included_portal_list', 'base_data_count', 'trend_data_count');
if(!VIP) unset($header_arr[array_search('included_portal_list', $header_arr)]);
$args = array('default_ac' => 'included_set');

$search_type_arr = array('1' => stlang('baidu'), '2' => stlang('google'));

$spider_type_arr = $search_type_arr;
$ping_type_arr = $search_type_arr;
$view_data_type = array(1 => stlang('bbs'), 2 => stlang('portal'));
$view_search_type = $search_type_arr;
$included_type_arr = $search_type_arr;
$view_types_arr = array(1 => stlang('in_count'), 2 => stlang('in_percent'));

$right_status = '<span class="status_right"></span>';
$notice_status = '<span class="status_notice"></span>';

$included_set = tool_common_get('included');
$included_set['view_user_group'] = dunserialize($included_set['view_user_group']);
$included_set['ping_type'] = dunserialize($included_set['ping_type']);
$included_set['spider_type'] = dunserialize($included_set['spider_type']);
$included_set['included_type'] = dunserialize($included_set['included_type']);
seo_tpl($args);

function included_set(){
	global $_G,$pluin_info,$spider_type_arr,$ping_type_arr,$included_set,$included_type_arr;
	if($_GET['editsubmit']){
		$set = $_GET['set'];
		$set['view_user_group'] = serialize($_GET['view_user_group']);
		$set['ping_type'] = serialize($_GET['ping_type']);
		$set['spider_type'] = serialize($_GET['spider_type']);
		$set['included_type'] = serialize($_GET['included_type']);
		//计划任务要重新设定
		tool_common_set('milu_seotool_cron', array('included_check' => 0, 'ping_check' => 0));
		tool_common_set('included', $set);
		cpmsg(stlang('op_success'), PLUGIN_GO."included", 'succeed');	
	}else{
		$info = $included_set;
		$cat_arr = $cat_site_arr = get_site_category();
		array_unshift($cat_arr, stlang('empty'));
		$show .= seoOutput::show_title(stlang('base_set'));
		$show .=  seoOutput::show_tr(
				array(
					'name' => stlang('spider_log_set'),
					'desc' => '',
					'arr' => array(
						'name' => 'spider_type',
						'info' => $info,
						'option_arr' => $spider_type_arr,
					),
				)
				,'checkbox');	
		$show .= seoOutput::show_title(stlang('included_set'));			
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('included_set'),
					'desc' => stlang('included_set_notice'),
					'arr' => array(
						'name' => 'included_type',
						'info' => $info,
						'option_arr' => $included_type_arr,
					),
				)
				,'checkbox');		
		$show .= seoOutput::show_title(stlang('ping_set'));	
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('article_ping_set'),
					'arr' => array(
						'name' => 'ping_type',
						'info' => $info,
						'option_arr' => $ping_type_arr,
					),
				)
				,'checkbox');		
		$show .=  seoOutput::show_tr(
				array(
					'name' => stlang('is_auto_ping'),
					'desc' => '',
					'arr' => array(
						'name' => 'is_auto_ping',
						'info' => $info,
						'int_val' => 2,
						'lang_type' => 2,
					),
				)
				,'radio');
		
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('auto_ping_time'),
					'desc' => stlang('auto_ping_time_notice'),
					'arr' => array(
						'name' => 'auto_ping_time',
						'int_val' => 30,
						'info' => $info,
					),
				)
				,'input');
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('bat_max_num'),
					'desc' => stlang('default_num_article', array('c' => 50)),
					'arr' => array(
						'name' => 'ping_per_num',
						'int_val' => 50,
						'info' => $info,
					),
				)
				,'input');		
					
		$show .= seoOutput::show_title(stlang('is_auto_check_included'));			
		
		$show .=  seoOutput::show_tr(
				array(
					'name' => stlang('_is_auto_check_included'),
					'desc' => stlang('check_included_notice'),
					'arr' => array(
						'name' => 'is_auto_check',
						'info' => $info,
						'int_val' => 2,
						'lang_type' => 2,
					),
				)
				,'radio');
		
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('aoto_check_day'),
					'desc' => stlang('aoto_check_day_notice'),
					'arr' => array(
						'name' => 'aoto_check_day',
						'int_val' => 3,
						'info' => $info,
					),
				)
				,'input');
		
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('auto_check_time'),
					'desc' => stlang('auto_check_time_notice', array('c' => 12)),
					'arr' => array(
						'name' => 'auto_check_time',
						'int_val' => 12,
						'info' => $info,
					),
				)
				,'input');
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('bat_max_num'),
					'desc' => stlang('default_num_article', array('c' => 50)),
					'arr' => array(
						'name' => 'check_per_num',
						'int_val' => 50,
						'info' => $info,
					),
				)
				,'input');			
		if(VIP){
			$show .= seoOutput::show_title(stlang('included_is_show_title'));
			$show .=  seoOutput::show_tr(
					array(
						'name' => stlang('included_is_show'),
						'desc' => stlang('included_is_show_notice'),
						'arr' => array(
							'name' => 'is_show',
							'info' => $info,
							'int_val' => 2,
							'lang_type' => 2,
						),
					)
					,'radio');
			$show .=  seoOutput::show_tr(
					array(
						'name' => stlang('view_user_type'),
						'desc' => '',
						'arr' => array(
							'name' => 'view_user_type',
							'info' => $info,
							'int_val' => 1,
							'lang_arr' => array(stlang('user_group'), stlang('_user_set')),
							'js' => array(0 => "show_hide('tr_user_group', 'tr_user_set' ,1);", 1 => "show_hide('tr_user_group', 'tr_user_set' ,2);"),
							'lang_type' => 2,
						),
					)
					,'radio');
			$show .= seoOutput::add_tr(array('desc' => stlang('select_notice_'), 'tr_id' => 'tr_user_group', 'style' => $info['view_user_type'] !=2 ? '' : 'style="display:none"'), seoOutput::user_group_select('view_user_group', $info['view_user_group'], array('group_arr' => array('system', 'special'), 'no_epmty' => 1)));
			$show .= seoOutput::add_tr(array('desc' => stlang('included_view_uid'), 'tr_id' => 'tr_user_set', 'style' => $info['view_user_type'] == 2 ? '' : 'style="display:none"'), seoOutput::input(
				array(
				'name' => 'view_user',
				'info' => $info,
				'int_val' => '',
			),$info));	
		}
		$info['show'] = $show;
		$info['tpl'] = 'common_set';
		return $info;
	}
	
}

function included_forum_list(){
	return included_list();
}



function included_list($data_type = 0){
	global $_G,$included_set;
	if($_GET['submit']){//执行批量操作
		$set = $_GET['set'];
		
		$set['batch_op_range'] = $set['batch_op_range'] ? $set['batch_op_range'] : $_GET['batch_op_range'];
		$set['batch_op_type'] = $set['batch_op_type'] ? $set['batch_op_type'] : $_GET['batch_op_type'];
		$set['op_select_type'] = $set['op_select_type'] ? $set['op_select_type'] : $_GET['op_select_type'];
		
		$search_args = urldecode($_GET['search_args']);
		$set['title'] = $set['title'] ? $set['title'] : $_GET['title'];
		$set['baidu'] = $set['baidu'] ? $set['baidu'] : $_GET['baidu'];
		$set['baidu_modify_dateline'] = $set['baidu_modify_dateline'] ? $set['baidu_modify_dateline'] : $_GET['baidu_modify_dateline'];
		$set['google_modify_dateline'] = $set['google_modify_dateline'] ? $set['google_modify_dateline'] : $_GET['google_modify_dateline'];
		$set['fast_search'] = $set['fast_search'] ? $set['fast_search'] : $_GET['fast_search'];
		$set['article_batch_num'] = $article_batch_num = $_GET['article_batch_num'];
		$set['page'] = $_GET['page'];
		$set['perpage'] = $_GET['perpage'];
		
		$ids_arr = $_GET['ids'];
		$batch_args_url = get_args_str($set).$search_args;
		if(!$_GET['step']) {
			if($set['batch_op_range'] == 1){//所选数据
				$count = count($ids_arr);
				if(!$ids_arr) cpmsg_error(stlang('please_select_data'));
				$ids_str = implode('_', $ids_arr);
			}else{//全部数据
				$count = 0;
			}
			cpmsg(stlang('running'), PLUGIN_GO.'included&myac='.$_GET['myac'].'&step=1&submit=1&count='.$count.'&ids_str='.$ids_str.$batch_args_url, 'loading', '', false);
		}else if($_GET['step'] == 1){
			$ids_str = '';
			if($_GET['batch_op_range'] == 1){//所选数据
				$ids_arr = $_GET['ids_str'] ? explode('_', $_GET['ids_str']) : array();
				$per = $article_batch_num;
				$count = $_GET['count'];
				$new_ids_arr = array_splice ($ids_arr, $per);
				$percent = ( $count - count($new_ids_arr) ) / $count;
				$percent = sprintf("%01.0f", $percent*100).'%';
				$ids_str = implode('_', $new_ids_arr);
			}else{
				$search_args['page'] = $page = $_GET['bat_page'] ? $_GET['bat_page'] : 1;
				$search_args['title'] = $_GET['title'];
				$search_args['baidu'] = $_GET['baidu'];
				$search_args['baidu_modify_dateline'] = $_GET['baidu_modify_dateline'];
				$search_args['google_modify_dateline'] = $_GET['google_modify_dateline'];
				$search_args['fast_search'] = $_GET['fast_search'];
				if($set['fast_search']) unset($set['baidu'], $set['baidu_modify_dateline'], $set['google_modify_dateline'], $set['title']);
				$search_args['perpage'] = $article_batch_num;
				$search_args['data_type'] = $data_type;
				$info = included_data_list($search_args);
				$count = $info['count'];
				foreach($info['list'] as $k => $v){
					$ids_arr[] = $v['aid'];
				}
				$new_count = count($ids_arr);
				$new_ids_arr = $ids_arr;
				$page +=1;
				$batch_args_url .= '&page='.$page;
				if($set['op_select_type'] == 2){//有记录就跳过
					$ids_arr = filter_article_data($ids_arr, $set['batch_op_type'], $data_type);
				}
				$percent = ($article_batch_num * ($search_args['page'] - 1) + $new_count) / $count;
				$percent = sprintf("%01.0f", $percent*100).'%';
				$batch_args_url .= '&bat_page='.$page;
			}
			batch_run($ids_arr, $set['batch_op_type'], $data_type);
			if(!$new_ids_arr) {
				if($set['batch_op_range'] == 2) $batch_args_url = str_replace(array('&page=', '&bat_page='), array('&', '&'), $batch_args_url);
				cpmsg(stlang('running_finsh'), PLUGIN_GO."included&myac=".$_GET['myac'].$batch_args_url, 'succeed');
			}
			cpmsg(stlang('running_status', array('p' => $percent)), PLUGIN_GO.'included&myac='.$_GET['myac'].'&step=1&submit=1&count='.$count.'&ids_str='.$ids_str.$batch_args_url, 'loading', '', false);
		}
	}
	
	$set = $_GET['set'];
	$set['title'] = $set['title'] ? $set['title'] : $_GET['title'];
	$set['fast_search'] = $_GET['fast_search'];
	$set['data_type'] = $data_type;
	$set['baidu'] = $_GET['baidu'];
	$set['baidu_modify_dateline'] = $_GET['baidu_modify_dateline'];
	$set['google_modify_dateline'] = $_GET['google_modify_dateline'];
	if($set['fast_search']) unset($set['baidu'], $set['baidu_modify_dateline'], $set['google_modify_dateline'], $set['title']);
	$set['page'] = $page = $_GET['page'] ? intval($_GET['page']) : 1;
	$set['perpage'] = $_GET['perpage'] ? intval($_GET['perpage']) : 25;
	$search_info = $set;
	
	$check_info['show_include']['baidu'] = in_array(1, $included_set['included_type']);
	$check_info['show_include']['google'] = in_array(2, $included_set['included_type']);
	
	$check_info['show_spider']['baidu'] = in_array(1, $included_set['spider_type']);
	$check_info['show_spider']['google'] = in_array(2, $included_set['spider_type']);
	
	$check_info['show_ping']['baidu'] = in_array(1, $included_set['ping_type']);
	$check_info['show_ping']['google'] = in_array(2, $included_set['ping_type']);
	
	
	$search_show .=  stlang('title').' '.seoOutput::input(
		array(
		'name' => 'title',
		'info' => $search_info,
		'int_val' => '',
	),$info);
	
	$search_show .=  ' '.stlang('baidu').' '.seoOutput::select(
		array('option_arr' => array(stlang('all'), stlang('spidered_no_included'), stlang('all_included'), stlang('24hour_included')),
		'name' => 'baidu',
		'info' => $search_info,
		'int_val' => 10,
		'flag' => 2,
	),$info);
	

	if($check_info['show_include']['baidu']){
		$search_show .=  ' '.stlang('baidu_included_check_time').' '.seoOutput::select(
			array('option_arr' => array(stlang('all'), stlang('never_check'), stlang('one_day_before'), stlang('one_week_before')),
			'name' => 'baidu_modify_dateline',
			'info' => $search_info,
			'int_val' => 10,
			'flag' => 2,
		),$info);
	}
	
	if($check_info['show_include']['google']){
		$search_show .=  ' '.stlang('google_included_check_time').' '.seoOutput::select(
			array('option_arr' => array(stlang('all'), stlang('never_check'), stlang('one_day_before'), stlang('one_week_before')),
			'name' => 'google_modify_dateline',
			'info' => $search_info,
			'int_val' => 10,
			'flag' => 2,
		),$info);
	}
	
	$info = included_data_list($search_info);
	$info['op_select_range'] =  seoOutput::radio(
		array('lang_arr' => array(1 => stlang('selected_data'), 2 => stlang('all_data')),
		'name' => 'batch_op_range',
		'info' => $_GET['batch_op_range'],
		'lang_type' => 3,
		'int_val' => 1,
		'flag' => 2,
	),$info);
	
	$info['op_select'] =  seoOutput::radio(
		array('lang_arr' => array(1 => stlang('baidu_included_check'), 2 => stlang('google_included_check'), 3 => stlang('baidu_ping'), '4' => stlang('google_ping')),
		'name' => 'batch_op_type',
		'info' => $_GET['batch_op_type'],
		'int_val' => 1,
		'flag' => 2,
	),$info);
	
	$info['op_select_type'] =  seoOutput::radio(
		array('lang_arr' => array(1 => stlang('no_record_run'), 2 => stlang('have_record_jump') ),
		'name' => 'op_select_type',
		'info' => $_GET['op_select_type'],
		'lang_type' => 3,
		'int_val' => 2,
		'flag' => 2,
	),$info);
	
	$info['show_title'] = stlang('article_inluded');
	$fast_search_arr = array(1 => stlang('baidu24hour_included'), 2 => stlang('baidu_spider_no_included'), 3 => stlang('baidu_never_check')); 
	$fast_search = '';
	foreach($fast_search_arr as $k => $v){
		$current = isset($search_info['fast_search']) && $k == $search_info['fast_search'] ? 'class="current"' : '';
		$link = '?'.PLUGIN_GO.'included&myac='.$_GET['myac'].'&page='.$page.'&data_type'.$search_info['data_type'].'&fast_search='.$k;
		$fast_search .= '<li '.$current.'><a href="'.$link.'">'.$v.'</a></li>';
	}

	
	$info = array_merge($info, $check_info);
	
	$info['search_args'] = urlencode(get_args_str($search_info));
	$info['fast_search'] = $fast_search;
	$info['search_show'] = $search_show;
	$info['tpl'] = 'included_list';
	return $info;
}


function included_data_list($args){
	global $_G;
	$perpage = $args['perpage'];
	$page = $args['page'];
	$data_arr['start'] = $start = ($page-1)*$perpage;
	$mpurl = get_args_str($args);
	$data_arr['mpurl'] = '?'.PLUGIN_GO.'included&myac='.$_GET['myac'].$mpurl;
	$data_type = $args['data_type'];
	if(!$args['baidu'] && !$args['baidu_modify_dateline'] && !$args['google_modify_dateline'] && !$args['fast_search']){
		$func = $args['data_type'] == 1 ? 'included_data_portal' : 'included_data_forum';
		$data_list = $func($data_arr, $args);
	}else{
		$data_id_name = $data_type == 1 ? 'aid' : 'tid';
		$where_sql = '';
		
		if($data_type == 1){//门户
			$table = 'portal_article_title';
			$where_sql = "WHERE a.data_type='1' AND  b.status='0'";
			$title_name = 'title';
			$get_field = 'b.aid,b.title as subject,b.dateline,b.catid';
		}else{
			$table = 'forum_thread';
			$where_sql = "WHERE a.data_type='0' AND b.displayorder='0'";
			$title_name = 'subject';
			$get_field = 'b.tid as aid,b.subject,b.dateline,b.fid';
		}
		if($args['title']){
			$where_sql .= " AND b.$title_name like '%".$args['title']."%'";
		}
		//百度收录
		if($args['baidu'] == 1 || $args['fast_search'] == 2){//百度爬过但未收录
			$where_sql .= " AND a.baidu_spider_count>0 AND a.baidu_included=0 ";
		}else if($args['baidu'] == 2){//所有已收录
			$where_sql .= " AND a.baidu_included>0 ";
		}else if($args['baidu'] == 3 || $args['fast_search'] == 1){//最近24小时收录
			$dateline = $_G['timestamp'] - 3600*24;
			$where_sql .= " AND a.baidu_included>$dateline ";
		}
		//百度查询时间
		if($args['baidu_modify_dateline'] == 1 || $args['fast_search'] == 3){//从未查询
			$where_sql .= " AND a.baidu_modify_dateline=0 ";
		}else if($args['baidu_modify_dateline'] == 2){//一天以前
			$dateline = $_G['timestamp'] - 3600*24;
			$where_sql .= " AND a.baidu_modify_dateline<$dateline ";
		}else if($args['baidu_modify_dateline'] == 3){//一周前
			$dateline = $_G['timestamp'] - 3600*24*7;
			$where_sql .= " AND a.baidu_modify_dateline<$dateline ";
		}
		//谷歌查询时间
		if($args['google_modify_dateline'] == 1 ){//从未查询
			$where_sql .= " AND a.google_modify_dateline=0 ";
		}else if($args['google_modify_dateline'] == 2){//一天以前
			$dateline = $_G['timestamp'] - 3600*24;
			$where_sql .= " AND a.google_modify_dateline<$dateline ";
		}else if($args['google_modify_dateline'] == 3){//一周前
			$dateline = $_G['timestamp'] - 3600*24*7;
			$where_sql .= " AND a.google_modify_dateline<$dateline ";
		}
		
		$count =  DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('milu_seotool_included')." as a Inner Join ".DB::table($table)." as b ON b.$data_id_name = a.data_id $where_sql"), 0);
		$query = DB::query("SELECT $get_field,a.* FROM ".DB::table('milu_seotool_included')." as a Inner Join ".DB::table($table)." as b ON b.$data_id_name = a.data_id $where_sql ORDER BY b.dateline DESC LIMIT $start,$perpage");
		if($count){
			if($data_type == 1){//门户
				loadcache('portalcategory');
				$cat_arr = $_G['cache']['portalcategory'];
			}else{
				loadcache('forums');
				$cat_arr = $_G['cache']['forums'];
			}
			while($rs = DB::fetch($query)) {
				$rs = $data_type == 1 ? portal_rs_data($rs, $cat_arr) : forum_rs_data($rs, $cat_arr);
				$rs = format_included_rs($rs);
				$list[] = $rs;
				$data_list['included_data'][$rs['data_id']] = $rs;
			}
		}
		$data_list['count'] = $count;
		$data_list['list'] = $list;
		$data_list['multipage'] = multi($count, $perpage, $page, $data_arr['mpurl']);
	}
	return $data_list;
}


function forum_rs_data($rs, $cat_arr){
	global $_G;
	$rs['dateline'] = $rs['dateline'] ? dgmdate($rs['dateline']) : '';
	$rs['tid'] = $rs['tid'] ? $rs['tid'] : $rs['aid'];
	$rs['view_url'] = get_article_url($rs['tid']);
	$rs['cat_name'] = $cat_arr[$rs['fid']]['name'];
	$rs['cat_url'] = $_G['siteurl'].'forum.php?mod=forumdisplay&fid='.$rs['fid'];
	return $rs;
}




function included_data_forum($data_arr, $args){
	global $_G;
	$perpage = $args['perpage'];
	$page = $args['page'];
	$list = $aid_arr = array();
	$start = $data_arr['start'];
	$where_sql = '';
	if($args['title']){
		$where_sql .= " AND subject like '%".$args['title']."%'";
	}
	$count =  DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('forum_thread')." WHERE displayorder='0' $where_sql"), 0);
	$query = DB::query("SELECT tid,subject,dateline,fid FROM ".DB::table('forum_thread')." WHERE displayorder='0' $where_sql  ORDER BY dateline DESC LIMIT $start,$perpage");
	if($count){
		loadcache('forums');
		$cat_arr = $_G['cache']['forums'];
		while($rs = DB::fetch($query)) {
			$rs['aid'] = $rs['tid'];
			$rs = forum_rs_data($rs, $cat_arr);
			$aid_arr[] = $rs['aid'];
			$list[] = $rs;
		}
	}
	$data['count'] = $count;
	$data['list'] = $list;
	$data['included_data'] = data_included_list($aid_arr, 0);
	$data['multipage'] = multi($count, $perpage, $page, $data_arr['mpurl']);
	return $data;
}



function data_included_list($aid_arr, $type = 0){
	if(!$aid_arr) return array();
	$query = DB::query("SELECT * FROM ".DB::table('milu_seotool_included')." WHERE data_type='$type' AND data_id IN(".dimplode($aid_arr).")");
	while($rs = DB::fetch($query)) {
		$rs = format_included_rs($rs);
		$data[$rs['data_id']] = $rs;
	}
	return $data;
}

function format_included_rs($rs){
	global $right_status,$notice_status;
	$rs['baidu_modify_dateline'] = $rs['baidu_modify_dateline'] ? dgmdate($rs['baidu_modify_dateline'], 'u') : '';
	$rs['google_modify_dateline'] = $rs['google_modify_dateline'] ? dgmdate($rs['google_modify_dateline'], 'u') : '';
	$rs['google_spider_last'] = $rs['google_spider_last'] ? dgmdate($rs['google_spider_last'], 'u') : '';
	$rs['google_included'] = $rs['google_included'] ? $right_status.dgmdate($rs['google_included'], 'Y-m-d') : '';
	if($rs['google_ping'] == -1){
		$rs['google_ping'] = $notice_status.stlang('fail');
	}else{
		$rs['google_ping'] = $rs['google_ping'] ? $right_status.dgmdate($rs['google_ping'], 'u') : '';
	}
	$rs['baidu_spider_last'] = $rs['baidu_spider_last'] ? dgmdate($rs['baidu_spider_last'], 'u') : '';
	if($rs['baidu_ping'] == -1){
		$rs['baidu_ping'] = $notice_status.stlang('fail');
	}else{
		$rs['baidu_ping'] = $rs['baidu_ping'] ? $right_status.dgmdate($rs['baidu_ping'], 'u') : '';
	}
	$rs['baidu_included'] = $rs['baidu_included'] ? $right_status.dgmdate($rs['baidu_included'], 'Y-m-d') : '';
	return $rs;
}

function base_data_count(){
	global $_G,$view_data_type,$view_types_arr,$view_search_type,$included_set,$notice_status;
	$info['tpl'] = 'included_count_base';
	$search_type = $_GET['search_type'] ? intval($_GET['search_type']) : 1;
	$search_name = $search_type == 1 ? 'baidu' : 'google';
	$class_arr = array($search_name.'_included_data');
	
	$temp_arr['all_count'][0] = get_article_count();//论坛文章数量
	$temp_arr['all_count'][1] = get_article_count(1);//门户文章收录
	
	$temp_arr['included_count'][0] = get_included_count(0, $search_type);//论坛文章收录数量
	$temp_arr['included_count'][1] = get_included_count(1, $search_type);//门户文章收录数量
	
	$temp_arr['no_included'][0] = $temp_arr['all_count'][0] - $temp_arr['included_count'][0];//论坛文章未收录数量
	$temp_arr['no_included'][1] = $temp_arr['all_count'][1] - $temp_arr['included_count'][1];//门户文章未收录数量
	
	$temp_arr['count_percent'][0] = $temp_arr['included_count'][0] / $temp_arr['all_count'][0];//论坛文章收录文章占总数
	$temp_arr['count_percent'][0] = sprintf("%01.0f", $temp_arr['count_percent'][0]*100).'%';
	$temp_arr['count_percent'][1] = $temp_arr['included_count'][1] / $temp_arr['all_count'][1];//门户文章收录文章占总数
	$temp_arr['count_percent'][1] = sprintf("%01.0f", $temp_arr['count_percent'][1]*100).'%';
	
	$temp_arr['hour_included_count'][0] = get_included_count(0, $search_type, 1);//论坛文章24小时收录数量
	$temp_arr['hour_included_count'][1] = get_included_count(1, $search_type, 1);//门户文章24小时收录数量
	
	$cache_ttl = 3600*2;
	if(!($data_arr = st_load_cache($search_name.'_included_data')) || $_GET['clear_cache'] == 1){
		$data_arr[$search_name.'_included_data'] = array(
			0 => array(
				'name' => '',
				'value' => array(stlang('forum_article'), stlang('portal_article')),
			),
			1 => array(
				'name' => stlang('article_all_count'),
				'value' => array($temp_arr['all_count'][0], $temp_arr['all_count'][1]),
			),
			2 => array(
				'name' => stlang('all_included_count'),
				'value' => array($temp_arr['included_count'][0], $temp_arr['included_count'][1]),
			),
			3 => array(
				'name' => stlang('no_included_count'),
				'value' => array($temp_arr['no_included'][0], $temp_arr['no_included'][1]),
			),
			4 => array(
				'name' => stlang('included_all_count_percent'),
				'value' => array($temp_arr['count_percent'][0], $temp_arr['count_percent'][1]),
			),
			5 => array(
				'name' => stlang('24hour_included_count'),
				'value' => array($temp_arr['hour_included_count'][0], $temp_arr['hour_included_count'][1]),
			),
		);
		$data_arr['dateline'] = $_G['timestamp'];
		st_cache_data($search_name.'_included_data', $data_arr, $cache_ttl);
	}
	
	$info['cache_dateline'] = dgmdate($data_arr['dateline']);
	$info['next_dateline'] = dgmdate($data_arr['dateline'] + $cache_ttl);
	unset($data_arr['dateline']);
	
	$show_arr[] = array();
	
	foreach($class_arr as $k => $v){
		$show_arr[$k] = seoOutput::show_table($data_arr, $v);
	}
	//状态数据
	$cron_info = tool_common_get('milu_seotool_cron');
	$included_set['auto_check_time'] = $included_set['auto_check_time'] ? $included_set['auto_check_time'] : 12;
	if($included_set['is_auto_check'] == 2){
		$info['status']['auto_check'] = $notice_status.stlang('closed_');
	}else{
		$info['status']['auto_check'] = run_status_output($included_set['auto_check_time'], 3600, $cron_info['included_check']);
	}
	
	if($included_set['is_auto_ping'] == 2){
		$info['status']['auto_ping'] = $notice_status.stlang('closed_');
	}else{
		$info['status']['auto_ping'] = run_status_output($included_set['auto_ping_time'], 60, $cron_info['ping_check']);
	}
	
	$info['show'] = implode('', $show_arr);
	$info['search_type'] = $search_type;
	return $info;
}


function run_status_output($check_time, $check_time_flag, $now_run = ''){
	$check_time_flag_str = $check_time_flag == '3600' ? stlang('_hour') : stlang('_minute');
	$old_now_run  = $now_run;
	$now_run = $now_run ? $now_run - $check_time * $check_time_flag : '';
	$next_run = $old_now_run ? $old_now_run : '';
	$next_run = $next_run ? dgmdate($next_run) : stlang('be_run');
	$now_run = $now_run ? dgmdate($now_run) : stlang('no_have');
	$show_str = stlang('last_run').':<font>'.$now_run.'</font> '.stlang('next_run').':<font>'.$next_run.'</font>'.stlang('per_time').'<font>'.$check_time.'</font>'.$check_time_flag_str.stlang('run_one_times');
	return $show_str;
}

//数据趋势
function trend_data_count(){
	global $_G,$view_data_type,$view_types_arr,$view_search_type;
	$view_info['data_types'] = $_GET['data_types'] ? $_GET['data_types'] : array(1, 2);
	$view_info['search_types'] = $_GET['search_types'] ? $_GET['search_types'] : array(1);
	$view_info['view_types'] = $_GET['view_types'] ? $_GET['view_types'] : array(1);
	$view_info['start_dateline'] = $_GET['start_dateline'] ? strtotime($_GET['start_dateline']) : '';
	$view_info['end_dateline'] = $_GET['end_dateline'] ? strtotime($_GET['end_dateline']) : '';
	$view_info['start_dateline'] =  $view_info['start_dateline'] ? $view_info['start_dateline'] : $_G['timestamp'] - 3600*24*7;
	$view_info['end_dateline'] = $view_info['end_dateline'] ? $view_info['end_dateline'] : $_G['timestamp'];
	$dateline_arr = st_dayRange($view_info['start_dateline'], $view_info['end_dateline']);
	$from = $dateline_arr[1]['from'];
	$end = $dateline_arr[count($dateline_arr)]['end'];
	//$sql .= 'WHERE '
	
	$search_type_flag = in_array(2, $view_info['search_types']);
	$data_types_flag = in_array(2, $view_info['data_types']);
	$view_types_flag = in_array(2, $view_info['view_types']);
	
	$temp_end = $end + 1; 
	$temp_from = $from - 1; 
	
	if(count($view_info['search_types']) < 2){//搜索引擎
		$search_name = $search_type_flag ? 'google_included' : 'baidu_included';
		$sql = " WHERE $search_name<$temp_end AND $search_name>$temp_from ";
	}else{
		$sql = " WHERE (baidu_included<$temp_end AND baidu_included<$temp_from) OR (google_included<$temp_end OR google_included>$temp_from) ";
	}
	
	if(count($view_info['data_types']) < 2){//数据类型
		$sql .= in_array(2, $view_info['data_types']) ? " AND data_type='1'" : "AND data_type='0'"; 
	}
	
	
	if($view_types_flag){
		$where_sql = " AND dateline<'$temp_end' AND dateline>'$temp_from'";
		//查询文章总数
		if(in_array(2, $view_info['data_types'])){//门户
			$query = DB::query("SELECT dateline FROM ".DB::table('portal_article_title'). " WHERE status='0' $where_sql");
			while($rs = DB::fetch($query)) {
				foreach($dateline_arr as $k => $v){
					if($rs['dateline'] < $v['end'] && $rs['dateline'] > $v['from']){
						$dateline_arr[$k]['article_count']['portal']++;
					}
					
				}
			}
		}
		if(in_array(1, $view_info['data_types'])){//论坛
			$query = DB::query("SELECT dateline FROM ".DB::table('forum_thread'). " WHERE displayorder='0' $where_sql");
			while($rs = DB::fetch($query)) {
				foreach($dateline_arr as $k => $v){
					if($rs['dateline'] < $v['end'] && $rs['dateline'] > $v['from'] ){
						$dateline_arr[$k]['article_count']['bbs']++;
					}
					
				}
			}
		}
		
	}
	$query = DB::query("SELECT baidu_included,baidu_spider_count,data_type,google_included,google_spider_count,data_type FROM ".DB::table('milu_seotool_included').$sql);
	while($rs = DB::fetch($query)) {
		foreach($dateline_arr as $k => $v){
			$data_type_name = $rs['data_type'] == 1 ? 'portal' : 'bbs';
			$v['end'] +=1;
			$v['from'] -=1;
			if($rs['baidu_included'] < $v['end'] && $rs['baidu_included'] > $v['from']){//百度收录
				$dateline_arr[$k]['included']['baidu'][$data_type_name]++;
			}
			if($rs['google_included'] < $v['end'] && $rs['google_included'] > $v['from']){//谷歌收录
				$dateline_arr[$k]['included']['google'][$data_type_name]++;
			}
		}
	}
	
	$title = date('Y-m-d', $from).' '.stlang('_to').' '.date('Y-m-d', $end). ' '.stlang('trend_flash_title');
	
	$FC = get_flash_obj(array('caption_title' => $caption_title, 'title' => $title, 'width' => '100%', 'height' => 400, 'yAxisName' => '', 'decimals' => 1));
	
	$view_data_arr  = array('bbs' => stlang('bbs'), 'portal' => stlang('portal'));
	if(!VIP) unset($view_data_arr['portal']);
	$search_type_arr = array('baidu' => stlang('baidu'), 'google' => stlang('google')); 
	$temp_view_types_arr = array('included' => stlang('in_count'), 'included_percent' => stlang('in_percent'));
	
	if(!in_array(1, $view_info['data_types'])) unset($view_data_arr['bbs']);
	if(!in_array(2, $view_info['data_types'])) unset($view_data_arr['portal']);
	
	
	if(!in_array(1, $view_info['search_types'])) unset($search_type_arr['baidu']);
	if(!in_array(2, $view_info['search_types'])) unset($search_type_arr['google']);
	
	if(!in_array(1, $view_info['view_types'])) unset($temp_view_types_arr['included']);
	if(!in_array(2, $view_info['view_types'])) unset($temp_view_types_arr['included_percent']);
	
	$flag = '';
	foreach($view_data_arr as $k1 => $v1){
		foreach($search_type_arr as $k2 => $v2){
			foreach($temp_view_types_arr as $k3 => $v3){
				$FC->addDataset($v1.$v2.$v3);
				foreach($dateline_arr as $k => $v){
					$key_str = $k1.$k2.$k3;
					$flag = $flag ? $flag : $key_str;
					if($flag && $key_str == $flag) $FC->addCategory($v['name']);
					if($k3 == 'included'){//收录
						$FC->addChartData($v[$k3][$k2][$k1]);
					}
					if($k3 == 'included_percent'){//收录率
						$article_count = $v['article_count'][$k1];
						$percent = $article_count > 0 ? $v['included'][$k2][$k1]/$v['article_count'][$k1] : 0;
						$percent = round($percent, 1);
						$percent = $percent > 1 ? 1 : $percent;
						//$percent = sprintf("%01.0f", $percent*100).'%';
						$FC->addChartData($percent);
					}
				}
			}
		}
	}
	
	$info['chart_flash'] = $FC->renderChart("", false);
	
	$info['show'] = implode('', $show_arr);
	if(!VIP) unset($view_data_type[2]);
	$info['view_show']['data_type'] = seoOutput::checkbox( array('name' => 'data_types', 'option_arr' => $view_data_type), $view_info);
	$info['view_show']['search_type'] = seoOutput::checkbox( array('name' => 'search_types', 'option_arr' => $view_search_type), $view_info);
	$info['view_show']['view_type'] = seoOutput::checkbox( array('name' => 'view_types', 'option_arr' => $view_types_arr), $view_info);
	$info['start_dateline'] = date('Y-m-d', $view_info['start_dateline']);
	$info['end_dateline'] = date('Y-m-d', $view_info['end_dateline']);
	$info['tpl'] = 'included_count_trend';
	return $info;
}



//data_type 0论坛 1门户  search_type 1 百度 2谷歌
function get_included_count($data_type = 0, $search_type = 1, $flag = 0){
	global $_G;
	$search_name =  $search_type == 2 ? 'google_included' : 'baidu_included'; 
	$dateline = $_G['timestamp'] - 3600*24;
	$sql = $flag == 1 ? " AND $search_name >$dateline" : '';
	return DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('milu_seotool_included')." WHERE data_type='$data_type' AND $search_name>0 $sql"), 0);
}


?>