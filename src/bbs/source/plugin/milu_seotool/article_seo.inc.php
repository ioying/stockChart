<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once(DISCUZ_ROOT.'source/plugin/milu_seotool/config.inc.php');
sload('F:copyright,F:seo');
$header_arr = array('article_seo_set', 'seo_word_set', 'seo_word_import');
if(!VIP) unset($header_arr);
$args = array('default_ac' => 'article_seo_set');
$article_seo_type = array(1 => stlang('portal'), 2 => stlang('bbs'), 3 => stlang('blog'));
$article_seo_set = tool_common_get('article_seo');
$article_seo_set['open_type'] = dunserialize($article_seo_set['open_type']);
$article_seo_set['open_forum'] = dunserialize($article_seo_set['open_forum']);

seo_tpl($args);


function article_seo_set(){
	global $_G,$pluin_info,$article_seo_set,$article_seo_type;
	if($_GET['editsubmit']){
		$set = $_GET['set'];
		$set['open_type'] = serialize($_GET['open_type']);
		$set['open_forum'] = serialize($set['open_forum']);
		tool_common_set('article_seo', $set);
		cpmsg(stlang('op_success'), PLUGIN_GO."article_seo", 'succeed');	
	}else{
		$info = $article_seo_set;
		$show .= seoOutput::show_title(stlang('base_set'));
		
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('open_seo'),
					'desc' => stlang('show_open_seo_mod'),
					'arr' => array(
						'name' => 'is_open',
						'info' => $info,
						'int_val' => 2,
						'lang_type' => 2,
					),
				)
				,'radio');
				
		
		
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('can_see_seo_uid'),
					'desc' => stlang('can_see_seo_uid_notice'),
					'arr' => array(
						'name' => 'view_seo_uid',
						'info' => $info,
					),
				)
				,'input');					
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('seo_run_range'),
					'desc' => stlang('seo_run_range_notice'),
					'arr' => array(
						'name' => 'open_type',
						'info' => $info,
						'option_arr' => $article_seo_type,
					),
				)
				,'checkbox');
		require_once libfile('function/forumlist');		
		$show .= seoOutput::add_tr(array(''), stlang('seo_run_forum'));
		$show .= seoOutput::add_tr(array(''), '<select name="set[open_forum][]" size="10" multiple="multiple">'.forumselect(FALSE, 0, $info['open_forum'], TRUE).'</select><div>'.stlang('seo_run_forum_notice').'</div>');		
		
		if(VIP){
			$show .= seoOutput::show_title(stlang('seo_word_set'));
			
			
			$show .=  seoOutput::show_tr(
					array(
						'name' => stlang('is_open_seo_word'),
						'desc' => '',
						'arr' => array(
							'name' => 'is_open_word',
							'info' => $info,
							'int_val' => 2,
							'lang_type' => 2,
						),
					)
					,'radio');		
			$show .=  seoOutput::show_tr(
					array(
						'name' => stlang('seo_word_open_mode'),
						'desc' => '',
						'arr' => array(
							'name' => 'word_open_mode',
							'info' => $info,
							'int_val' => 1,
							'lang_arr' => array(stlang('seo_for_spider').stlang('tuijian'), stlang('seo_for_all')),
							'lang_type' => 2,
						),
					)
					,'radio');
		
		}
		$show .= seoOutput::show_title(stlang('text_and_title_set'));
		$show .=  seoOutput::show_tr(
					array(
						'name' => stlang('is_open_seo_push'),
						'desc' => '',
						'arr' => array(
							'name' => 'is_open_seo_push',
							'info' => $info,
							'int_val' => 2,
							'lang_type' => 2,
						),
					)
					,'radio');	
		$show .=  seoOutput::show_tr(
				array(
					'name' => stlang('text_push_mode'),
					'desc' => '',
					'arr' => array(
						'name' => 'push_open_mode',
						'info' => $info,
						'int_val' => 2,
						'lang_arr' => array(stlang('seo_for_spider'), stlang('seo_for_all')),
						'lang_type' => 2,
					),
				)
				,'radio');		
		
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('push_title_header'),
					'desc' => stlang('push_title_footer_notice'),
					'arr' => array(
						'name' => 'push_title_header',
						'info' => $info,
					),
				)
				,'textarea');
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('push_title_footer'),
					'desc' => stlang('push_title_footer_notice'),
					'arr' => array(
						'name' => 'push_title_footer',
						'info' => $info,
					),
				)
				,'textarea');
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('push_content_header'),
					'desc' => stlang('row_class'),
					'arr' => array(
						'name' => 'push_content_header',
						'info' => $info,
					),
				)
				,'textarea');
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('push_content_body'),
					'desc' => stlang('row_class'),
					'arr' => array(
						'name' => 'push_content_body',
						'info' => $info,
					),
				)
				,'textarea');
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('push_content_footer'),
					'desc' => stlang('row_class'),
					'arr' => array(
						'name' => 'push_content_footer',
						'info' => $info,
					),
				)
				,'textarea');
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('push_reply_header'),
					'desc' => stlang('row_class'),
					'arr' => array(
						'name' => 'push_reply_header',
						'info' => $info,
					),
				)
				,'textarea');	
		
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('push_reply_body'),
					'desc' => stlang('row_class'),
					'arr' => array(
						'name' => 'push_reply_body',
						'info' => $info,
					),
				)
				,'textarea');
		
		
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('push_reply_footer'),
					'desc' => stlang('row_class'),
					'arr' => array(
						'name' => 'push_reply_footer',
						'info' => $info,
					),
				)
				,'textarea');
		
												
											
		$info['show'] = $show;
		$info['tpl'] = 'common_set';
		return $info;
	}
	
}



//同义词
function get_replace_words($page = 0, $perpage = 0, $s = ''){
	$words = array();
	$word_arr = get_seo_word_arr();
	$total_count = count($word_arr);
	if($page > 0 && $perpage > 0){
		if($s){
			$search_arr = array();
			foreach($word_arr as $k => $v){
				if(strexists($v, $s)) $search_arr[] = $v;
			}
			$word_arr = $search_arr;
			$total_count = count($word_arr);
		}
		$start = ($page-1)*$perpage;
		$word_arr = array_slice($word_arr, $start, $perpage);
	}
	$ext_str = get_seo_word_split();
	foreach((array)$word_arr as $k=>$v){
		if(!$v) continue;
		$str_arr = explode($ext_str, $v);//关键词分割符
		$words += array("$str_arr[0]" => "$str_arr[1]");
	}
	return array('list' => $words, 'total_count' => $total_count);
}

function replace_del_wrap($str){
	if($str == get_seo_word_split()) return;
	$str .= WRAP;
	return $str;
}


?>