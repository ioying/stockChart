<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once(DISCUZ_ROOT.'source/plugin/milu_seotool/config.inc.php');
sload('F:copyright');
$header_arr = array('flink_set', 'flink_to', 'flink_get' , 'flink_onlie');
$args = array('default_ac' => 'flink_set');
$baidusnap_arr = array(0 => stlang('no_limit'), 1 => stlang('one_day'), 2 => '1-3'.stlang('day'), 3 => stlang('one_weekly'));
$pr_arr = array(0 => stlang('no_limit'), 1 => 1, 2 => 2, 3 => 3 , 4 => 4, 5 => 5, 6 => '6'.stlang('value_up'));
$link_type_arr = array(0 => stlang('no_limit'), 1 => stlang('type_img'), 2 => stlang('text'));
$default_link_displayorder = 15;
$flink_status_arr = array('10' => stlang('all_status'), 1 => stlang('trun_sucess'), 0 => stlang('wait_accept'), '-1' => stlang('refused'));
seo_tpl($args);

function flink_set(){
	global $_G,$pr_arr,$link_type_arr,$baidusnap_arr,$pluin_info;
	if($_GET['editsubmit']){
		$set = $_GET['set'];
		$set['link_type'] = $_GET['link_type'];
		$set['site_catid'] = $_GET['site_catid'];
		$set['limit_site_catid'] = serialize($_GET['limit_site_catid']);
		$set['limit_baidusnap'] = $_GET['limit_baidusnap'];
		$set['limit_pr'] = $_GET['limit_pr'];
		tool_common_set('flink', $set);
		add_online_flink($set);
		cpmsg(stlang('op_success'), PLUGIN_GO."flink", 'succeed');	
	}else{
		$info = tool_common_get('flink');
		$info['limit_site_catid'] = dunserialize($info['limit_site_catid']);
		$cat_arr = $cat_site_arr = get_site_category();
		array_unshift($cat_arr, stlang('empty'));
		$show .= seoOutput::show_title(stlang('base_set'));
		$show .=  seoOutput::show_tr(
				array(
					'name' => stlang('ask_add_flink'),
					'desc' => stlang('ask_add_flink_notice'),
					'arr' => array(
						'name' => 'is_open',
						'info' => $info,
						'int_val' => 2,
						'lang_type' => 2,
					),
				)
				,'radio');
		$show .= seoOutput::show_title(stlang('perfect_info'));
		$show .=  seoOutput::show_tr(
				array(
					'name' => stlang('link_type'),
					'desc' => stlang('link_type_notice'),
					'arr' => array(
						'name' => 'link_type',
						'info' => $info,
						'int_val' => 0,
						'flag' => 1,
						'option_arr' => $link_type_arr,
					),
				)
				,'select');
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('site_catid'),
					'desc' => '',
					'arr' => array(
						'name' => 'site_catid',
						'info' => $info,
						'int_val' => 0,
						'flag' => 1,
						'option_arr' => $cat_site_arr,
					),
				)
				,'select');
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('qq_info'),
					'desc' => stlang('qq_info_notice'),
					'arr' => array(
						'name' => 'qq',
						'info' => $info,
					),
				)
				,'input');	
		$info['link_keyword'] = $info['link_keyword'] ? $info['link_keyword'] : $_G['setting']['bbname'];						
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('link_text'),
					'desc' => stlang('link_text_notce'),
					'arr' => array(
						'name' => 'link_keyword',
						'info' => $info,
					),
				)
				,'input');
		list($navtitle, $info['site_desc'], $metakeywords) = get_seosetting('forum', array(), array('seodescription' => $info['site_desc']));				
		$info['site_desc'] = $info['site_desc'] ? $info['site_desc'] : $_G['setting']['seodescription']['forum'];						
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('link_desc'),
					'desc' => stlang('link_desc_notice'),
					'arr' => array(
						'name' => 'site_desc',
						'info' => $info,
					),
				)
				,'textarea');
		$logo_url = $info['logo_url'] ? $info['logo_url'] : $_G['siteurl'].$_G['style']['boardimg'];
		$logo_img = $logo_url ? '<a target="_blank" href="'.$logo_url.'">'.stlang('hits_view').'</a> ' : ''; 	
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('logo_url'),
					'desc' => $logo_img.stlang('logo_url_notice'),
					'arr' => array(
						'name' => 'logo_url',
						'info' => $info,
						'int_val' => $logo_url,
					),
				)
				,'input');			
		$show .= seoOutput::show_title(stlang('ask_limit_title'));
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('site_cate'),
					'desc' => stlang('selected_notice'),
					'arr' => array(
						'name' => 'limit_site_catid',
						'info' => $info,
						'int_val' => 0,
						'flag' => 1,
						'multiple' => TRUE,
						'option_arr' => $cat_arr,
					),
				)
				,'select');	
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('limit_baidu'),
					'desc' => '',
					'arr' => array(
						'name' => 'limit_baidu',
						'info' => $info,
					),
				)
				,'input');
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('limit_google'),
					'desc' => '',
					'arr' => array(
						'name' => 'limit_google',
						'info' => $info,
					),
				)
				,'input');	
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('baidusnap'),
					'desc' => '',
					'arr' => array(
						'name' => 'limit_baidusnap',
						'info' => $info,
						'int_val' => 0,
						'flag' => 1,
						'option_arr' => $baidusnap_arr,
					),
				)
				,'select');										
		$show .= seoOutput::show_tr(
				array(
					'name' => stlang('limit_pr'),
					'desc' => '',
					'arr' => array(
						'name' => 'limit_pr',
						'info' => $info,
						'int_val' => 0,
						'flag' => 1,
						'option_arr' => $pr_arr,
					),
				)
				,'select');			
		$info['show'] = $show;
		$info['tpl'] = 'common_set';
		return $info;
	}
	
}

function flink_to(){
	$info = get_flink_info();
	return $info;
}



function flink_get(){
	$info = get_flink_info(1);
	return $info;
}

function get_flink_info($type = 0){
	global $flink_status_arr;
	$set = $_GET['set'];
	$sitename = $set['sitename'];
	$status = $_GET['status'];
	$search_info = array('sitename' => $sitename, 'status' => $status);
	$search_show .=  stlang('sitename').seoOutput::input(
		array(
		'name' => 'sitename',
		'info' => $search_info,
		'int_val' => '',
	),$info);
	
	$search_show .=  seoOutput::select(
		array('option_arr' => $flink_status_arr,
		'name' => 'status',
		'info' => $search_info,
		'int_val' => 10,
		'flag' => 2,
	),$info);
	
	$info = flink_list(array('type' => $type, 'sitename' => $sitename, 'status' => $status));
	$info['search_show'] = $search_show;
	$info['tpl'] = 'flink_ask_list';
	$info['type'] = $type;
	$info['show_title'] = $type == 1 ? stlang('to_ask_info') : stlang('send_ask_info');
	$info['flink_status_arr'] = $flink_status_arr;
	return $info;
}

function flink_onlie(){
	global $_G,$cat_site_arr,$pr_arr,$baidusnap_arr,$link_type_arr;
	$set = $_GET['set'];
	$set['sitename'] = $_GET['sitename'] ? $_GET['sitename'] : $set['sitename'];
	$set['baidu'] = $_GET['baidu'] ? $_GET['baidu'] : $set['baidu'];
	$set['google'] = $_GET['google'] ? $_GET['google'] : $set['google'];
	$set['order_by'] = $_GET['order_by'];
	$set['order'] = $_GET['order'];
	$set['link_type'] = $_GET['link_type'];
	$set['site_catid'] = $_GET['site_catid'];
	$set['PR'] = $_GET['PR'];
	$set['baidusnap'] = $_GET['baidusnap'];
	$set['only_list_my'] = $_GET['search_submit'] ? $_GET['only_list_my'] : 0;
	$search_info = dstripslashes($set);
	$cat_site_arr = get_site_category();
	array_unshift($cat_site_arr, stlang('no_limit_cate'));
	$search_show .=  stlang('sitename').' '.seoOutput::input(
		array(
		'name' => 'sitename',
		'info' => $search_info,
		'int_val' => '',
	),$info);
	
	$search_show .= stlang('web_from_type').seoOutput::select(
		array(
		  'name' => 'site_catid',
		  'info' => $search_info,
		  'int_val' => 0,
		  'flag' => 1,
		  'option_arr' => $cat_site_arr,
	  ),$info);
	 
	 $search_show .= stlang('search_limit_set').seoOutput::select(
		array(
		  'name' => 'PR',
		  'info' => $search_info,
		  'int_val' => 0,
		  'flag' => 1,
		  'option_arr' => $pr_arr,
	  ),$info); 
	  
	$search_show .=  ' '.stlang('limit_baidu').' '.seoOutput::input(
		array(
		'name' => 'baidu',
		'length' => 3,
		'info' => $search_info,
		'int_val' => '',
	),$info);
	$search_show .=  ' '.stlang('limit_google').' '.seoOutput::input(
		array(
		'name' => 'google',
		'length' => 3,
		'info' => $search_info,
		'int_val' => '',
	),$info);  
	
	$search_show .=  ' '.stlang('baidusnap').' '.seoOutput::select(
		array('option_arr' => $baidusnap_arr,
		'name' => 'baidusnap',
		'info' => $search_info,
		'int_val' => 10,
		'flag' => 2,
	),$info);
	
	$search_show .=  ' '.stlang('link_type').' '.seoOutput::select(
		array('option_arr' => $link_type_arr,
		'name' => 'link_type',
		'info' => $search_info,
		'int_val' => 10,
		'flag' => 2,
	),$info);
	
	$search_show .=  ' '.stlang('order').' '.seoOutput::select(
		array('option_arr' => array('0' => stlang('default'), 'baidu' => stlang('baidu_count'), 'google' => stlang('google_count'), 'pr' => 'PR', 'baidusnap' => stlang('baidusnap'), 'modify_dateline' => stlang('modify_dateline')),
		'name' => 'order_by',
		'info' => $search_info,
		'int_val' => 10,
		'flag' => 2,
	),$info);
	$search_show .=  seoOutput::select(
		array('option_arr' => array('DESC' => stlang('desc'), 'ASC' => stlang('asc')),
		'name' => 'order',
		'info' => $search_info,
		'int_val' => 10,
		'flag' => 2,
	),$info);
	$checked = $search_info['only_list_my'] ? 'checked="checked"' : '';
	$search_show .= ' <input '.$checked.' class="checkbox" type="checkbox" value="1" id="only_list_my" name="only_list_my"><label for="only_list_my">'.stlang('list_match').'</label> ';
	$set['page'] = $_GET['page'] ? intval($_GET['page']) : 1;
	$info = flink_online_list($set);
	$info['client'] = get_client_info();
	$host_info = GetHostInfo($_G['siteurl']);
	$info['client']['host'] = $host_info['host'];
	$info['search_show'] = $search_show;
	$info['tpl'] = 'flink_onlie';
	$info['show_title'] = stlang('flink_onlie_');
	$info['cat_site_arr'] = $cat_site_arr;
	$info['link_type_arr'] = $link_type_arr;
	$flink_set =  tool_common_get('flink');
	$seo_info = get_site_seoinfo();
	if($seo_info['status'] < 1) $info['evn_msg'] = $seo_info['msg'];
	$seo_info['show_baidusnap'] = $seo_info['baidusnap'] ? date('Y-m-d', strtotime($seo_info['baidusnap'])) : stlang('no_have');
	$seo_info['show_modify_dateline'] = $seo_info['modify_dateline'] ? dgmdate($seo_info['modify_dateline'], 'u') : '';
	$seo_info['catname'] = $cat_site_arr[$seo_info['site_catid']];
	$info['user_info'] = $seo_info;
	$flink_set['limit_site_catid'] = dunserialize($flink_set['limit_site_catid']);
	$flink_set['limit_site_catid'] = array_filter($flink_set['limit_site_catid']);
	$info['flink_set'] = $flink_set;
	return $info;
}

function update_info(){
	$flink_set =  tool_common_get('flink');
	if($flink_set['is_open'] != 1) cpmsg_error(stlang('update_flink__info_err'));
	get_site_seoinfo(24*3600, 1);
	cpmsg(stlang('op_success'), PLUGIN_GO."flink&myac=flink_onlie", 'succeed');	
}

function get_site_seoinfo($cache_time = 86400, $flag = 0){
	global $_G;
	$key_data = get_site_key();
	$cache_key = md5($key_data['domain']);
	if($flag == 0 && $cache_time > 0 && $data = st_load_cache($cache_key)){
		return $data;
	}else{
		$st_rpcClient = st_rpcClient();
		$key_data['siteurl'] =  $_G['siteurl'];
		$data = $st_rpcClient->RPC_user_info($key_data, $flag);//flag==1时，服务器强制刷新信息
		
		if(is_object($data)){
			if($data->Message || $data->Number == 0) {
				return array('status' => -1, 'msg' => stlang('phprpc_error', array('msg' => $data->Message)) );
			}	
		}
		$data = list_data_format($data, array('sitename', 'link_keyword', 'site_desc'));
		if($data && is_array($data)) st_cache_data($cache_key, $data, $cache_time);
		if($data < 0) {
			del_key_cache();
			cpmsg_error(stlang('key_error'));
		}
		return $data;
	}
}

function flink_ask_to(){
	$data['uid'] = intval($_GET['uid']);
	$data['remark'] = st_format_url($_GET['remark']);
	if(!$data['uid']) return 'error:1';
	$key_data = get_site_key();
	if(!$key_data['key_code']) return 'error:2';
	$data = st_rpcClient()->RPC_flink_ask_to($data, $key_data, CHARSET);
	if(is_object($data)){
		if($data->Message || $data->Number == 0) {
			return stlang('phprpc_error', array('msg' => $data->Message));
		}	
	}
	$error_msg = stlang('send_flink_err');
	$msg_arr = array( '-3' => stlang('send_flink_err1'), '-5' => stlang('send_flink_err2'));
	if($data < 0){
		$error = $msg_arr[$data] ? $msg_arr[$data] : $error_msg;
		return $error;
	}
	return 1;
}

function flink_online_list($args){
	$st_rpcClient = st_rpcClient();
	$client_info = get_client_info();
	$flink_set = $args['only_list_my'] ? tool_common_get('flink') : array();
	unset($flink_set['site_desc']);
	$url_args = get_args_str($args);
	$args['mpurl'] = '?'.PLUGIN_GO.'flink&myac=flink_onlie'.$url_args;
	$data = $st_rpcClient->RPC_flink_online_list($args, $flink_set, $client_info);
	if(is_object($data)){
		if($data->Message || $data->Number == 0) {
			$info['evn_msg'] = stlang('phprpc_error', array('msg' => $data->Message));
			return $info;
		}	
	}
	if($data == 'rpclimit') cpmsg_error(stlang('rpclimit'));
	$data['list'] = list_data_format($data['list'], array('sitename'));
	$info['list'] = $data['list'];
	$info['count'] = $data['count'];
	$info['multipage'] = $data['multipage'];
	if($args['sitename']){
		$info['show_result'] = stlang('search_num', array('n' => $info['count'] ? $info['count'] : 0));
	}
	return $info;
}


function flink_list($args){
	$st_rpcClient = st_rpcClient();
	$key_data = get_site_key();
	$data = $st_rpcClient->RPC_flink_list($args, $key_data);
	if(is_object($data)){
		if($data->Message || $data->Number == 0) {
			$info['evn_msg'] = stlang('phprpc_error', array('msg' => $data->Message));
			return $info;
		}	
	}
	if($data == 'rpclimit') cpmsg_error(stlang('rpclimit'));
	$data['list'] = list_data_format($data['list'], array('sitename', 'remark'));
	$info['list'] = $data['list'];
	$info['count'] = $data['count'];
	if($args['sitename']){
		$info['show_result'] = stlang('search_num', array('n' => $info['count'] ? $info['count'] : 0));
	}
	return $info;
}

function check_flink_match($data, $flink_set, $my_info){
	global $_G;
	
	if($_G['siteurl'] == $data['siteurl']) return -9;
	
	if($flink_set['limit_baidu'] && $data['baidu'] < $flink_set['limit_baidu']) return -1;
	if($data['limit_baidu'] && $my_info['baidu'] < $data['limit_baidu']) return -2;
	
	if($flink_set['limit_google'] && $data['google'] < $flink_set['limit_google']) return -3;
	if($data['limit_google'] && $my_info['google'] < $data['limit_google']) return -4;
	
	if($flink_set['limit_pr'] && $data['pr'] < $flink_set['limit_pr']) return -5;
	if($data['limit_pr'] && $my_info['pr'] < $data['limit_pr']) return -6;
	
	$data['limit_site_catid'] = explode(',', $data['limit_site_catid']);
	$data['limit_site_catid'] = array_filter($data['limit_site_catid']);
	if($flink_set['limit_site_catid'] && !in_array($data['site_catid'],$flink_set['limit_site_catid'])) return -7;
	if($data['limit_site_catid'] && !in_array($my_info['site_catid'],$data['limit_site_catid'])) return -8;
	
	return 1;
}

function add_online_flink($set){
	$key_data = get_site_key();
	if(!$key_data) exit('error:201'); 
	$st_rpcClient = st_rpcClient();
	$client_info = get_client_info();
	$set['sitename'] = $client_info['sitename'];
	$set['siteurl'] = $client_info['siteurl'];
	$data = $st_rpcClient->RPC_flink_add_online($set, $key_data, CHARSET);
	st_check_rpc_data($data);
	if((int)$data < 0 || !$data) {
		del_key_cache();
		cpmsg_error(stlang('add_online_flink_err', array('c' => $data)));
	}
	st_cache_del(md5($key_data['domain']));
	return 1;
}

function del_key_cache(){
	$cachefile = DISCUZ_ROOT.'./data/cache/milu_seotool_key.php';
	@unlink($cachefile);
}

//status 0等待 1成功 -1拒绝
function show_flink_op($id, $type, $status){
	$detail_str = '<a href="javascript:void(0)" onclick="flink_ask_detail('.$id.','.$type.');">'.stlang('detail').'</a>';
	$msg_arr_to = array(0 => '<a href="javascript:void(0)" onclick="flink_ask_op('.$id.', 3);">'.stlang('_cancel').'</a>',  1 => $detail_str);
	$msg_arr_get = array(0 => '<a href="javascript:void(0)" onclick="flink_ask_op('.$id.', 1);">'.stlang('accept').'</a>', 1 => '<a href="javascript:void(0)" onclick="flink_ask_op('.$id.', \'-1\');">'.stlang('refuse').'</a>', 2 => $detail_str);
	if($status == 0){
		$str = $type == 1 ? implode(' ',$msg_arr_get) : implode(' ',$msg_arr_to);
	}else if($status > 0){
		$str = $type == 1 ? $msg_arr_get[2] : $msg_arr_to[1];
	}else{
		$str = $type == 1 ? $msg_arr_get[0].' '.$msg_arr_to[1] : $msg_arr_to[1];
	}
	return $str;
}
//type 0 发出的 1 收到的
function flink_ask_detail(){
	global $flink_status_arr,$link_type_arr;
	$cat_arr  = get_site_category();
	$id = intval($_GET['id']);
	$type = intval($_GET['type']);
	$key_data = get_site_key();
	$data = st_rpcClient()->RPC_flink_ask_detail($id, $type, $key_data);
	$data['user_info'] = list_data_format($data['user_info'], array('site_desc', 'sitename'));
	$data['flink_info'] = list_data_format($data['flink_info'], array('remark'));
	if(($rpc_error = st_get_rpc_error($data))) return $rpc_error;
	$site_info = $data['user_info'];
	$site_info['baidu_count'] = $site_info['baidu'];
	unset($site_info['baidu']);
	$site_info['siteurl'] = '<a target="_blank" href="'.$site_info['siteurl'].'">'.cutstr($site_info['siteurl'], 57).'</a> ';
	$site_info['logo_url'] = '<a target="_blank" href="'.$site_info['logo_url'].'">'.cutstr($site_info['logo_url'], 57).'</a> ';
	$site_info['link_type'] = $link_type_arr[$site_info['link_type']];
	$site_info['site_catid'] = $cat_arr[$site_info['site_catid']];
	$site_info['qq'] = seoOutput::show_qq($site_info['qq']);
	$site_info['baidusnap'] = $site_info['baidusnap'] ? date('Y-m-d', strtotime($site_info['baidusnap'])) : '';
	unset($site_info['uid']);
	$flink_info = $data['flink_info'];
	$html = '<ul class="show_tips"><li><h1>'.stlang('site_info').':</h1></li>';
	foreach($site_info as $k => $v){
		$html .= '<li>'.stlang($k).' : '.$v.'</li>';
	}
	$html .= '<li><h1>'.stlang('op_info').':</h1></li>';
	$flink_info['ask_dateline'] = $flink_info['dateline'] ? dgmdate($flink_info['dateline'], 'u') : '';
	$flink_info['accept_dateline'] = $flink_info['accept_dateline'] ? dgmdate($flink_info['accept_dateline'], 'u') : '';
	
	unset($flink_info['dateline']);
	unset($flink_info['id'], $flink_info['to_uid'], $flink_info['uid']);
	$flink_info['status'] = $flink_status_arr[$flink_info['status']];
	
	foreach($flink_info as $k => $v){
		$html .= '<li>'.stlang($k).' : '.$v.'</li>';
	}
	$html .= '</ul>';
	show_seotool_window(stlang('detail'), $html, array('w' => 550, 'h' => 450, 'f' => 1));
}

//1接受 -1拒绝 3撤销
function flink_ask_op(){
	$id = intval($_GET['id']);
	$status = intval($_GET['status']);
	$key_data = get_site_key();
	if(!$key_data) return stlang('key_error'); 
	$data = st_rpcClient()->RPC_flink_ask_op($id, $status, $key_data);
	if(($rpc_error = st_get_rpc_error($data))) return $rpc_error;
	if($data == -1) return stlang('key_error'); 
	if($data == -4) return stlang('flink_op_err1');
	if($data < 0) return 'error:'.$data;
	add_flink(array(
		'name' => $data['link_keyword'],
		'url' => $data['siteurl'],
		'logo' => $data['logo_url'],
		'description' => $data['site_desc'],
	));
	return 1; 
}
function add_flink($set){
	global $default_link_displayorder;
	$set = list_data_format($set, array('name', 'description'));
	$set = dstripslashes($set);
	$set = st_addslashes($set);
	if(!$set['name'] || !$set['url']) return;
	$flink_set = tool_common_get('flink');
	$link_type = $flink_set['link_type'];
	if($link_type == 2) unset($set['logo']);//文字链接
	$check = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('common_friendlink')." WHERE name='$set[name]' AND url='$set[url]'"), 0);
	if($check) return;
	$max_displayorder =DB::result(DB::query("SELECT MAX(displayorder) FROM ".DB::table('common_friendlink')), 0);
	$set['displayorder'] = $max_displayorder;
	$set['type'] = $default_link_displayorder;//默认的分组
	$insert_id = DB::insert('common_friendlink', $set);
	return $insert_id;
}


function flink_ask_api(){
	global $_G;
	$key = $_GET['key'];
	$status = intval($_GET['status']);
	$set['name'] = urldecode($_GET['sitename']);
	$set['url'] = urldecode($_GET['siteurl']);
	$set['description'] = urldecode($_GET['site_desc']);
	$set['logo'] = urldecode($_GET['logo_url']);
	$key_data = get_site_key();
	if($key != $key_data['key_code']) exit('-1');
	add_flink($set);
	exit('1');
}
?>