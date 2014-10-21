<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once(DISCUZ_ROOT.'source/plugin/milu_seotool/config.inc.php');
sload('F:copyright');
$ac = $_GET['ac'];
if(!empty($ac) && function_exists($ac)) {
	$info = $ac();
	return;
}	
$user_arr = get_user_level();
$evo_check_msg = evo_check();
$evo_config_arr = evo_server_config();
$plugin_count_msg = system_count();

function system_count(){
	clear_plugin_cache();//缓存定期清理
	$spider_count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('milu_seotool_spider')), 0);
	$arr['spider']['name'] = stlang('spider_count');
	$arr['spider']['show'] = $spider_count;
	$arr['spider']['msg'] = stlang('spider_notice');
	
	sload('C:cache');
	$cache_info = IO::info(PLUGIN_CACHE, 1, 1);
	$arr['cache']['name'] = stlang('cache_file_size');
	$arr['cache']['show'] = stlang('cache_size_value', array('s' => sizecount($cache_info['size']), 'p' => PLUGIN_CACHE_SIZE));
	$arr['cache']['msg'] = stlang('cache_notice');
	return $arr;
		
}

function clear_plugin_cache(){
	sload('C:cache');
	$clear_cache = (array)tool_common_get('clear_cache');
	$clear_cache = $clear_cache[0];
	if( (TIMESTAMP - $clear_cache) < 3600*2 && $del == 0) return;
	$cache_info = IO::info(PLUGIN_CACHE);
	if($cache_info['size'] > PLUGIN_CACHE_SIZE*1024*1024){
		IO::rm(PLUGIN_CACHE);
	}
	tool_common_set('clear_cache', TIMESTAMP);
}

function evo_check(){

	$arr[4]['name'] =  stlang('plugin_dir_write');
	$arr[4]['check'] = 1;
	if(!dir_writeable(PLUGIN_PATH.'/data/cache')){
		$arr[4]['check'] = 0;
		$arr[4]['msg'] = '<li>'.stlang('dir_no_write', array('dir' => './source/plugin/milu_seotool/data/cache')).'</li>';
	}
	
	if($arr[4]['msg']) $arr[4]['msg'] = '<ul id="tipslis">'.$arr[4]['msg'].'</ul>'; 
	
	$arr[8]['name'] =  stlang('open_zend');
	if(($zend_re = is_zend()) > 0){
		$arr[8]['check'] = 1;
		$arr[8]['msg'] = stlang('zend_notice');
	}else{
		$arr[8]['check'] = 0;
		$arr[8]['msg'] = $zend_re == -1 ? stlang('http_visit', array('file' => 'source/plugin/milu_seotool/zend/zendcheck.php')) : stlang('zend_enable');
	}
	return $arr;
}

//获取服务器参数
function evo_server_config(){
	$get = function_exists('ini_get') ? TRUE : FALSE;
	$memory_str = $get ? ini_get('memory_limit') : '-1';
	if($memory_str >0){
		$m = intval($memory_str);
		$memory_msg = stlang('memory_notice');
	}
	$config_arr['php_version'] = array(
		'name' => stlang('phpversion'),
		'value' => phpversion(),
		'msg' => '',
		'best_value' => '',
	);
	$config_arr['memory_limit'] = array(
		'name' => stlang('php_memory_set'),
		'value' => $memory_str == '-1' ?  stlang('un_know') : $memory_str,
		'msg' => $memory_msg,
		'best_value' => '128MB'.stlang('set_up'),
 	);
	$dis_fun = $get ? ini_get("disable_functions") : '-1';
	$config_arr['display_function'] = array(
		'name' => stlang('no_use_func'),
		'value' => $dis_fun ? ($dis_fun != '-1' ? $dis_fun : stlang('un_know')) : stlang('no_have'),
	);
	
	$max_time = $get ? ini_get("max_execution_time") : '-1';
	$config_arr['max_execution_time'] = array(
		'name' => stlang('time_out_time'),
		'value' => $max_time ? ($max_time != '-1' ? $max_time.stlang('sec') : stlang('un_know')) : stlang('no_limit'),
		'best_value' => stlang('no_limit'),
	);
	
	return $config_arr;
}


$_GET['tpl'] = $_GET['tpl'] ? $_GET['tpl'] : 'plugin_info';
if($_GET['tpl'] != 'no' && $_GET['tpl']) include template('milu_seotool:'.$_GET['tpl']);

?>