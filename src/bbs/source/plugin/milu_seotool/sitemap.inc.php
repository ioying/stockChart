<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once(DISCUZ_ROOT.'source/plugin/milu_seotool/config.inc.php');
sload('F:sitemap,F:copyright');
$args = array('default_ac' => 'sitemap_set');
$sitemap_set = tool_common_get('sitemap');
$sitemap_set['sitemap_type'] = dunserialize($sitemap_set['sitemap_type']);
if(!function_exists('gzopen')) unset($sitemap_set['sitemap_type'][array_search('gz', $sitemap_set['sitemap_type'])]);
$sitemap_set['max_article_num'] = $sitemap_set['max_article_num'] ? $sitemap_set['max_article_num'] : 500;
$sitemap_set['max_threads_num'] = $sitemap_set['max_threads_num'] ? $sitemap_set['max_threads_num'] : 500;
seo_tpl($args);

function sitemap_set(){
	global $_G,$pluin_info,$sitemap_set;
	if($_GET['editsubmit']){
		$set = $_GET['set'];
		$set['sitemap_type'] = serialize($_GET['sitemap_type']);
		$update_info = update_sitemap($set);
		save_syscache('milu_seotool_sitemap', $update_info);
		//计划任务要重新设定
		tool_common_set('milu_seotool_cron', array('sitemap_maker' => 0));
		tool_common_set('sitemap', $set);
		cpmsg(stlang('op_success'), PLUGIN_GO."sitemap", 'succeed');	
	}else{
		$info = $sitemap_set;
		$show .= seoOutput::show_title(stlang('base_set'));
		if(VIP){
			$show .=  seoOutput::show_tr(
					array(
						'name' => stlang('auto_update_sitemap'),
						'desc' => '',
						'arr' => array(
							'name' => 'is_auto',
							'info' => $info,
							'int_val' => 2,
							'lang_type' => 2,
						),
					)
					,'radio');
			$show .= seoOutput::show_tr(
					array(
						'name' => stlang('sitemap_update_tiimes'),
						'desc' => stlang('sitemap_update_tiimes_notice'),
						'arr' => array(
							'name' => 'auto_time',
							'int_val' => 1,
							'info' => $info,
						),
					)
					,'input');		
		}
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('sitemap_article_max_count'),
					'desc' => stlang('sitemap_article_max_notice'),
					'arr' => array(
						'name' => 'max_article_num',
						'int_val' => 500,
						'info' => $info,
					),
				)
				,'input');	
		
		
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('sitemap_bbs_max_count'),
					'desc' => stlang('sitemap_article_max_notice'),
					'arr' => array(
						'name' => 'max_threads_num',
						'int_val' => 500,
						'info' => $info,
					),
				)
				,'input');	
		$create_file_type = seoOutput::show_tr(
				array(
					'name' => stlang('sitemap_file_type'),
					'desc' => stlang('sitemap_file_type_notice'),
					'arr' => array(
						'name' => 'sitemap_type',
						'info' => $info,
						'option_arr' => array('xml' => 'xml', 'txt' => 'txt', 'gz' => 'gz', 'html' => 'html'),
					),
				)
				,'checkbox');
		$create_file_type  = !function_exists('gzopen') ? str_replace(array('id="sitemap_type2"', '<label for="sitemap_type2">gz</label>'), array(' id="sitemap_type2" disabled="disabled"', '<label for="sitemap_type2">gz('.stlang('server_no_zhichi').')</label>'), $create_file_type) : $create_file_type;			
		$show .= $create_file_type;		
		$show .= seoOutput::show_title(stlang('sitemap_status'));
		loadcache('milu_seotool_sitemap');
		$sitemap_update_data = $_G['cache']['milu_seotool_sitemap'];
		$info['updateline'] = $sitemap_update_data['updateline'];
		$info['sitemap_url_count'] = $sitemap_update_data['sitemap_url_count'];
		$info['updateline'] = $info['updateline'] ? dgmdate($info['updateline']) : stlang('no_have');
		foreach($info['sitemap_type'] as $k => $v){
			$path = $v == 'gz' ? 'sitemap.xml.gz' : 'sitemap.'.$v;
			$sitemap['show'] .= ' &nbsp;<a href="'.$_G['siteurl'].$path.'" target="_blank">'.stlang('view_type_sitemap', array('c' => $v)).'</a>';
		}
		$sitemap['show'] = seoOutput::add_tr(array(''), $sitemap['show']);
		$sitemap['status'] = seoOutput::add_tr(array(''), stlang('in_url_count').":$info[sitemap_url_count] ".stlang('modify_dateline').":$info[updateline]");
		if($info['sitemap_type']){
			$show .= $sitemap['status'].$sitemap['show'];
		}else{
			$show .= seoOutput::add_tr(array(''), stlang('no_create'));
		}
		$show .= seoOutput::add_tr(array(''), stlang('sitemap_create_notice').' <a href="'.$_G['siteurl'].'robots.txt" target="_blank">'.stlang('view').'</a>');
		$info['show'] = $show;
		$info['submit_name'] = stlang('submit_update_sitemap');
		$info['tpl'] = 'common_set';
		return $info;
	}
	
}


//执行计划任务
function milu_seotool_cron(){
	global $_G;
	sload('C:cron');
	$cron_info = tool_common_get('milu_seotool_cron');
	print_r($cron_info);
	//收录查询
	if((int)$cron_info['included_check'] <= TIMESTAMP) {
		milu_seotool_cron::included_check();
	}
	//ping查询
	if((int)$cron_info['ping_check'] <= TIMESTAMP) {
		milu_seotool_cron::ping_check();
	}
	//排名查询
	if((int)$cron_info['keyword_rank_check'] <= TIMESTAMP) {
		if(VIP) milu_seotool_cron::keyword_rank_check();
	}

	//网站地图更新
	if((int)$cron_info['sitemap_maker'] <= TIMESTAMP) {
		if(VIP) milu_seotool_cron::sitemap_maker();
	}
}

?>