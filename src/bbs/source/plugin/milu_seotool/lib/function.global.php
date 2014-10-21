<?php
function show_seotool_window($title,$html,$args = ''){
	global $_G;
	$charset = GBK ? 'gb2312' : 'UTF-8';
	$big5 = $_G['config']['output']['language'] == 'zh_tw' && $_G['config']['output']['charset'] == 'big5' ? TRUE : FALSE;
	if($big5) $charset = 'big5';
	if(!$args['no_show']) header('Content-Type: text/xml ');
	global $_G;
	ob_clean();
	ob_end_flush();
	$show_footer = $args['f'] && !$args['js_func'] ? false : true;
	$args['js_func'] = $args['js_func'] ? $args['js_func'] : 'hideWindow(\''.$_GET['handlekey'].'\')';
	if(!$args['w']) $args['w'] = 'auto';
	if(!$args['h']) $args['h'] = 'auto';
	$args['y'] = $args['y'] ? 'hidden' : 'scroll';
	if(!$args['no_show']){
		$show_html = '<?xml version="1.0" encoding="'.$charset.'"?>';
		$show_html .= "<root>";
		$show_html .= '<![CDATA[';
	}
	$show_html .= '<h3 class="flb">
	<em>'.$title.'</em>
	<span><a href="javascript:;" onclick="hideWindow(\''.$_GET['handlekey'].'\');" class="flbc" title="'.stlang('close').'">'.stlang('close').'</a></span>
	</h3>
	<div class="article_detail c" id="return_'.$_GET['handlekey'].'">
	<div class="c bart">
	<div style="width:'.$args['w'].'px; height:'.$args['h'].'px;overflow-y:'.$args['y'].';">'.$html.'</div>
	</div>';
	if($show_footer){
	 	$show_html .=  '<p class="o pns">
		<button type="submit" name="dsf" style="width:50px;  height:25px;" class="pn pnc" onclick="'.$args['js_func'].';"><span>'.stlang('ok').'</span></button>
		<button type="reset" style="width:50px; height:25px;" name="dsf" class="pn" onclick="hideWindow(\''.$_GET['handlekey'].'\');"><em>'.stlang('cancel').'</em></button>
		</p>';
	}
	$show_html .= "</div>";
	if(!$args['no_show']){
		$show_html .= "]]></root>";
	}
	if($args['no_show'] == 1){
		return $show_html;
	}else{
		echo $show_html;
	}	
	//echo st_str_iconv($show_html);
	define(FOOTERDISABLED, false);
	exit();
}

function st_str_cut($content, $start, $end){//取出所有匹配，效率最快，因为只读一次，字符串越大越明显  
    $m = explode($start,$content);  
    $result = array();  
    for( $i = 1;$i < count($m);$i++ ){  
        $my = explode($end,$m[$i]);  
        $result[] = $my[0];  
        unset($my);  
    }  
    return $result;  
} 


//由此函数调ajax函数
function seotool_ajax_func(){
	global $_G;
	$seotool_ajax_func = $_GET['af'];
	if(strexists($seotool_ajax_func, ':')){
		$temp_arr = explode(':', $seotool_ajax_func);
		$file_name = $temp_arr[0];
		$seotool_ajax_func = $temp_arr[1];
		sload('F:'.$file_name);
		if(!function_exists($seotool_ajax_func)){
			sload('C:'.$file_name);
			if(!function_exists($seotool_ajax_func)){
				exit(stlang('no_found_ajaxfunc'));
			}
		}
	}
	$inajax = $_GET['inajax'];
	$xml = empty($_GET['xml']) ? 0 : $_GET['xml'];
	if(!function_exists($seotool_ajax_func)) exit(stlang('no_found_ajaxfunc'));
	$output = $seotool_ajax_func();
	ob_clean();
	ob_end_flush();
	if($xml == 1) include template('common/header_ajax');
	echo $output;
	if($xml == 1) include template('common/footer_ajax');
	define(FOOTERDISABLED, false);
	exit();
}

function st_get_contents($url, $args = array()){
	extract($args);
	$cache = isset($cache) ? $cache : 3600;
	if($cache > 0 && $content = st_load_cache($url)){
		
	}else{
		$snoopy = st_get_snoopy_obj($args);
		if(!$snoopy->fetch($url)) return FALSE;
		$header = $snoopy->headers;
		$key = array_search("Content-Encoding: gzip\r\n", $header);
		if($header[0] == 'HTTP/1.1 404 Not Found
' || $header[0] == 'HTTP/1.1 500 Internal Server Error') return FALSE;
		$content = $snoopy->results;
		$content = st_str_iconv($content);
		if($content) st_cache_data($url, $content, $cache);
	}
	return $content;
}


function st_get_snoopy_obj($args = array()){
	extract($args);
	require_once(PLUGIN_DIR.'/lib/Snoopy.class.php');
	$snoopy = new Snoopy;  
	$snoopy->maxredirs = $maxredirs ? $maxredirs : 3;
	$snoopy->expandlinks = TRUE;
	$snoopy->offsiteok = TRUE;//是否允许向别的域名重定向
	$snoopy->agent = $_SERVER['HTTP_USER_AGENT'];
	if($referer) $snoopy->referer = $referer;  
	$snoopy->rawheaders["COOKIE"]= $cookie;
	
	return $snoopy;
}

function st_ischinese($s){  
	$allen = preg_match("/^[^\x80-\xff]+$/", $s);   //判断是否是英文  
	$allcn = preg_match("/^[".chr(0xa1)."-".chr(0xff)."]+$/",$s);  //判断是否是中文  
	if($allen){    
		return 'allen';    
	}else{    
		if($allcn){    
			return 'allcn';    
		}else{    
			return 'encn';    
		}    
	}                    
}   


function st_format_wrap($str, $exp_type = WRAP){
	if(!defined('WRAP')) {
		define('WRAP', PHP_EOL);
		$exp_type = WRAP;
	}
	if(!$str) return false;
	$arr = explode($exp_type, trim($str));
	return $arr;
}

function st_num_size($data){
	if($data >100000000){
		$data = round(($data /100000000),2).stlang('_yi');
	}elseif($data >10000){
		$data = round(($data /10000),2).stlang('_wan');
	}elseif($data >1000){
		//$data = round(($data /1000),2).stlang('_qian');
		$data = $data;
	}
	if($data <0){
		if($data < -100000000){
			$data = round(($data /100000000),2).stlang('_yi');
		}elseif($data < -10000){
			$data = round(($data /10000),2).stlang('_wan');
		}elseif($data < -1000){
			$data = round(($data /1000),2).stlang('_qian');
		}
	}
	return $data;
}


//获取插件的全局设置
function st_get_pluin_set(){
	global $_G;
	loadcache('plugin');
	return $_G['cache']['plugin']['milu_seotool'];
}


function st_ajax_decode($str){
	return json_decode(base64_decode($str));
}


function st_get_domain($url){
	if(empty($url)) return;
	$d = RootDomain::instace();
	$d->setUrl($url);
	return $d->getDomain();
}
function st_check_rpc_data($data){
	if(!is_object($data)) {
		if($data == 'rpclimit') exit(stlang('rpclimit'));
		return $data;
	}
	if($data->Message || $data->Number == 0) {
		cpmsg_error(stlang('phprpc_error_text', array('msg' => $data->Message)));
	}
}

function st_get_rpc_error($data){
	if(!is_object($data)) return FALSE;
	if($data->Message || $data->Number == 0) {
		return stlang('phprpc_error', array('msg' => $data->Message));
	}	
	return FALSE;
}

function seo_tpl($args = array()){
	global $_S;
	extract((array)$args);
	sload('C:seoOutput');
	$head_url = '?'.PLUGIN_GO.$_GET['pmod'].'&myac=';
	$myac = $_GET['myac'];
	$tpl = $_GET['tpl'];
	if(empty($myac)) $myac = $default_ac ? $default_ac : $_GET['pmod'].'_run';
	if(function_exists($myac)) $info = $myac();
	$_GET['mytemp'] = $_GET['mytemp'] ? $_GET['mytemp'] : $info['tpl'];
	$mytemp = $_GET['mytemp'] ? $_GET['mytemp'] : $myac;
	if(!$_GET['inajax']){
		$_S['set'] = st_get_pluin_set();
		$submit_pmod = $info['submit_pmod'] ? $info['submit_pmod'] : $_GET['pmod'];
		$submit_action = $info['submit_action'] ? $info['submit_action'] : $myac;
		$info['header'] = seoOutput::pick_header_output();
		if(!$tpl && $tpl!= 'no') include template('milu_seotool:'.$mytemp);
	}
}

//转换不同编码的序列化数组
function st_serialize_iconv($thevalue){
	global $_G;
	if(!is_array($thevalue)) return $thevalue;
	foreach((array)$thevalue as $k => $v){//防止编码不同造成的错误
		$v_s = dunserialize($v);
		if(!$v_s){//不是序列化
			if(is_array($v)){//如果是数组
				$thevalue[$k] = st_serialize_iconv($v);
			}else{
				$thevalue[$k] = $_G['config']['output']['language'] == 'zh_tw' && $_G['config']['output']['charset'] == 'big5' ? st_gb2big5($v) : st_str_iconv($v);
			}
		}else{
			$v = st_serialize_iconv($v_s);
			$thevalue[$k] = serialize($v);
 		}
	}
	return $thevalue;
}





function st_rpcClient($rpc_url = ''){
	include_once (PLUGIN_DIR."/lib/phprpc/phprpc_client.php");  
	$client = new PHPRPC_Client();  
	$client->setProxy(NULL);  
	$rpc_url = $rpc_url ? $rpc_url : GET_URL.'plugin.php?id=seotool_server:flink&tpl=no&myac=rpcServer&inajax=1';
	$client->useService($rpc_url);   
	//$client->setKeyLength(10);  
	//$client->setEncryptMode(3);  
	$client->setCharset('GBK');  
	$client->setTimeout(10);  
	return $client;
}
function st_str_iconv($str, $charset = ''){
	global $_G;
	$is_big = $_G['cache']['evn_milu_pick']['pick_config']['is_big'];//是否utf-8环境下将繁体转换为简体
	if(!$str) return false;
	$charset = $charset ? $charset : strtoupper(st_get_charset($str));
	$big5 = $_G['config']['output']['language'] == 'zh_tw' && $_G['config']['output']['charset'] == 'big5' ? TRUE : FALSE;
	if(GBK){
		if($charset == 'UTF-8'){
			if($is_big){
				return st_big5_gbk($str);
			}
			$str = st_iconv($str, 'UTF-8', 'GBK');
			return $str;
		}else if($charset == 'BIG5'){//繁体
			return st_big52gb($str);
		}
	}else{
		if($charset != 'UTF-8'){
			if($charset == 'BIG5')  {
				if($_G['config']['output']['language'] != 'zh_tw'){//简体
					$str = st_big52gb($str);
					return st_iconv($str, 'GBK', 'UTF-8');
				}
				if($big5) return $str;
			}
			if($big5) return st_gb2big5($str);
			$str = st_iconv($str, $charset, 'UTF-8');
			return $str;		
		}else{
			if($big5){
				$str = st_iconv($str, 'UTF-8', 'GBK');
				$str = st_gb2big5($str);
				return $str;
			}
		}
	}
	return $str;	
}

//utf-8环境下 繁体装成简体 只用于gbk程序
function st_big5_gbk($str){
	global $_G;
	$is_big = $_G['cache']['milu_seotool']['config']['is_big'];//是否utf-8环境下将繁体转换为简体
	if(!$is_big) return $str;
	$str = st_iconv($str, 'UTF-8', 'BIG5');
	$str = st_big52gb($str);
	return $str;
}

function st_gb2big5($Text){   
   $fp = fopen(PLUGIN_DIR."/data/gb-big5.table", "r");   
   $max = strlen($Text)-1;   
	for($i=0; $i<$max; $i++){ 
		$h = ord($Text[$i]); 
		if($h >= 160){   
			$l=ord($Text[$i+1]);   
		if($h == 161 && $l==64){   
			$gb = " ";  
		}else{   
			fseek($fp, ($h-160)*510+($l-1)*2);   
			$gb = fread($fp,2);   
		}   
		$Text[$i] = $gb[0];   
		$Text[$i+1] = $gb[1]; $i++;   
		}   
	}  
	fclose($fp);   
	return $Text;  
} 


function st_big52gb($Text){
	$fp = fopen(PLUGIN_DIR."/data/big5-gb.table", "r"); 
    $max = strlen($Text)-1;
    for($i=0;$i<$max;$i++){
	   $h = ord($Text[$i]);
	   if($h>=160){
			$l = ord($Text[$i+1]);
			if($h == 161 && $l==64){
				$gb = " ";
			}else{
				fseek($fp, ($h-160)*510+($l-1)*2);
				$gb = fread($fp,2);
			}
			$Text[$i] = $gb[0];
			$Text[$i+1] = $gb[1];
			$i++;
		}
   }
   fclose($fp);
   return $Text;
 }



function st_iconv($str, $in, $out){
	global $_G;
	$is_win = strtoupper(substr(PHP_OS, 0, 3)) == 'WIN' ? TRUE : FALSE;
	if($is_win) return diconv($str, $in, $out);
	if(function_exists('mb_convert_encoding')) {
		$str = mb_convert_encoding($str, $out, $in); 
	}else{	
		$str = diconv($str, $in, $out);
	}
	return $str;
}


function st_get_charset($web_str){
	preg_match("/<meta[^>]+charset=\"?'?([^'\"\>]+)\"?[^>]+\>/is", $web_str, $arr);
	//if($arr[1]) return $arr[1];
	$arr[1] = strtoupper($arr[1]);
	if($arr[1] == 'GBK' || $arr[1] == 'BIG5') return $arr[1];
	$charset = st_is_utf8($web_str) ? 'UTF-8' : 'GB2312'; 
	if($arr[1] && $arr[1] == $charset) return $arr[1];
	return $charset;
}



function st_is_utf8($string) { 
	if (preg_match("/^([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}/",$string) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){1}$/",$string) == true || preg_match("/([".chr(228)."-".chr(233)."]{1}[".chr(128)."-".chr(191)."]{1}[".chr(128)."-".chr(191)."]{1}){2,}/",$string) == true) { 
		return true; 
	}else{ 
		return false; 
	} 
}

if(!function_exists('dunserialize')){//这个函数是DZ2.5新加入的
	function dunserialize($data) {
		if(($ret = unserialize($data)) === false) {
			$ret = unserialize(stripslashes($data));
		}
		return $ret;
	}
}

function get_site_category(){
	global $pluin_info,$_G;
	$cache_key = 'seo_site_category';
	loadcache($cache_key);
	$big5 = $_G['config']['output']['language'] == 'zh_tw' && $_G['config']['output']['charset'] == 'big5' ? TRUE : FALSE;
	if( !($data = $_G['cache'][$cache_key] )){
		$cate_str = stlang('site_category');
		if(!$big5){
			$cate_arr = explode('|', $cate_str);
			foreach((array)$cate_arr as $k => $v){		
				$temp_arr = explode('=', $v);
				$data[$temp_arr[0]] = $temp_arr[1];
			}
		}else{//不这样繁体分割会乱码
			preg_match_all("/([\x81-\xfe][\x40-\xfe])+/", $cate_str, $matches);
			$value_arr = $matches[0];
			$key_arr = range(1, count($value_arr));
			$data = array_combine($key_arr, $value_arr);
		}
		save_syscache($cache_key, $data);
	}
	return $data;
}


function tool_common_set($name, $value){
	$conf_arr = tool_common_get();
	$setting = $conf_arr[$name];
	$value = (array)$value;
	$setting = (array)$setting;
	$value += $setting;
	$conf_arr[$name] = $value;
	save_syscache('milu_seotool_setting', $conf_arr);
}

function tool_common_get($key = ''){
	global $_G;
	loadcache('milu_seotool_setting');
	$setting = $_G['cache']['milu_seotool_setting'];
	$setting = dstripslashes($setting);
	$setting = $key ? $setting[$key] : $setting;
	return $setting;
}

function get_flash_obj($args = array()){
	global $_G;
	$set = st_get_pluin_set();
	$palette = $set['palette'] ? $set['palette'] : 1;
	include_once(PLUGIN_DIR."/lib/MyFCPHPClassCharts/class/FusionCharts_Gen.php");
	$args['flash_type'] = $args['flash_type'] ? $args['flash_type'] : 'MSLine';
	$args['width'] = $args['width'] ? $args['width'] : 500;
	$args['height'] = $args['height'] ? $args['height'] : 350;
	$FC = new FusionCharts($args['flash_type'], $args['width'], $args['height']); 
	$FC->setSWFPath(PLUGIN_URL."lib/MyFCPHPClassCharts/FusionCharts/");
	$caption_title = $args['caption_title'];
	$decimals = isset($args['decimals']) ? $args['decimals'] : 0;
	$strParam = "caption=$args[title] ;subCaption=$caption_title;decimals=$decimals;lang=CN;yAxisName=$args[yAxisName];palette=$palette;showAboutMenuItem=0;pieSliceDepth=20;numberPrefix=;showToolTipShadow=1;baseFontSize=12;decimalPrecision=0;formatNumberScale=0;showNames=1";
	$FC->setChartParams($strParam);
	return $FC;
}

function st_stripslashes($data){
	if(DISCUZ_VERSION == 'X2') return $data;
	return dstripslashes($data);
}

function st_addslashes($data){
	if(DISCUZ_VERSION != 'X2') return $data;
	return daddslashes($data);
}

function stlang($name, $val_arr = array()){
	return lang('plugin/milu_seotool', $name, $val_arr);
}


function list_data_format($data, $field_arr = array(), $in = 'GBK', $out = ''){
	if(!$data || !is_array($data)) return $data;
	$out = $out ? $out : CHARSET;
	$in = strtoupper($in);
	$out = strtoupper($out);
	if($in == $out) return $data;
	foreach($data as $k => $v){
		if(is_array($v)){
			foreach($v as $k2 => $v2){
				$data[$k][$k2] = (!$field_arr || ($field_arr && in_array($k2, $field_arr))) && !is_array($v2) ? st_str_iconv($v2, $in) : $v2;
			}
		}else{
			$data[$k] = st_str_iconv($v, $in);
		}
	}
	return $data;
}


function s_s($name = 'default') { 
	global $ss_timing_start_times; 
	$ss_timing_start_times[$name] = explode(' ', microtime());
} 

function s_e($show=1,$name = 'default') { 
	global $ss_timing_stop_times; 
	$ss_timing_stop_times[$name] = explode(' ', microtime()); 
	if($show == 1){
		echo '<p>'.st_timing_current($name).'</p>';
	}else{
		return st_timing_current($name);
	}
} 

function st_timing_current ($name = 'default') { 
	global $ss_timing_start_times, $ss_timing_stop_times; 
	if (!isset($ss_timing_start_times[$name])) {
	   return 0; 
	} 
	if (!isset($ss_timing_stop_times[$name])) { 
	   $stop_time = explode(' ', microtime()); 
	} else { 
	   $stop_time = $ss_timing_stop_times[$name]; 
	} 
	$current = $stop_time[1] - $ss_timing_start_times[$name][1]; 
	$current += $stop_time[0] - $ss_timing_start_times[$name][0]; 
	return $current; 
}


function sload($name){
	$arr = explode(',', $name);
	$temp_arr = array();
	$pick_dir = DISCUZ_ROOT.'source/plugin/milu_seotool';
	foreach($arr as $k => $v){
		$temp_arr = explode(':', $v);
		$type = strtolower($temp_arr[0]);
		$name = $temp_arr[1];
		$func_file = $pick_dir.'/lib/function.'.$name.'.php';
		$class_file = $pick_dir.'/lib/'.$name.'.class.php';
		if( (!$type || $type == 'f')){//函数库
			require_once($func_file);
		}else if($type == 'c'){//类库
			require_once($class_file);
		}
	}
}

function st_format_url($url, $flag = 1){
	$url = trim(st_str_iconv($url));
	$url = stripslashes($url);
	$url = stripslashes($url);
	if(!$url || ($flag == 1 && $url == 'undefined')) return false;
	$url =  str_replace('[[JK%', '<', $url);
	$url = str_replace('JK%]]', '>', $url);
	$url = str_replace('[yinhao', '"', $url);
	//if(strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
		$url = str_replace("\r\n", "\r\m", $url);	
		$url = str_replace("\n", "\r\n", $url);
		$url = str_replace("\r\m", "\r\n", $url);
	//}	
	return $url;
}

function st_load_cache($key,$clearStaticKey = FALSE){
	require_once(PLUGIN_DIR.'/lib/cache.class.php');
	$cache = new serialize_cache();
	return $cache->get($key,$clearStaticKey);
}

function st_cache_data($key,$value,$ttl = 3600){
	if($ttl < 0 || $ttl == 0) return FALSE;
	require_once(PLUGIN_DIR.'/lib/cache.class.php');
	$cache = new serialize_cache();
	$value = is_array($value) ? $value : rawurlencode($value);
	$cache->set($key,$value,$ttl);
}
function st_cache_del($key){
	require_once(PLUGIN_DIR.'/lib/cache.class.php');
	$cache = new serialize_cache();
	$cache->delete($key);
}

function get_args_str($args){
	$str = '';
	foreach((array)$args as $k => $v){
		$str .= isset($v) ? '&'.$k.'='.$v : '';	
	}
	return $str;
}


//获得每一日的时间范围 比如2010-12-29日的范围应该是2010-12-29 00:00:00到2010-12-29 23:59:59
function st_dayRange($from_time,$end_time){
	$time_lang_arr = explode('|', stlang('time_str'));
	$y_f = date("Y", $from_time);
	$y_e = date("Y", $end_time);
	$m_f = date("m", $from_time);
	$m_e = date("m", $end_time);
	$d_f = date("d", $from_time);
	$d_e = date("d", $end_time);
	$day_bet = 3600*24;
	$from = $from_time;
	$end = $end_time;
	$from_time = strtotime($y_f."-".$m_f."-".$d_f." 00:00:00");//起始那天
	$end_time = strtotime($y_f."-".$m_f."-".$d_f." 23:59:59");//结束那天
	$bet_day = ($end-$from) / $day_bet;//相隔几天？
	$bet_day = round($bet_day, 0);
	for($i=1;$i<$bet_day+2;$i++){
		$hour[$i]["from"] = $from_time + $day_bet*($i-1);
		$hour[$i]["end"] = $end_time + $day_bet*($i-1);
		$m = date("m", $hour[$i]["end"]);
		$d = date("d", $hour[$i]["end"]);
		if($i==1 || (date("m", $hour[$i-1]["end"]) != date("m", $hour[$i]["end"]))){
			$show_name = $m.$time_lang_arr[1].$d.$time_lang_arr[2];
		}else{
			$show_name = $d.$time_lang_arr[2];
		}
		$hour[$i]["name"] = $show_name;
	}
	return $hour;
}

function st_striptext($document) {
	if (!$document) return $document;
	$search = array("'<script[^>]*?>.*?</script>'si",	// strip out javascript
					"'<style[^>]*?>.*?</style>'si",		//去掉css
					"'<!--.*?-->'si",		//去掉注释
					"'<[\/\!]*?[^<>]*?>'si",			// strip out html tags
					"'([\r\n])[\s]+'",					// strip out white space
					"'&(quot|#34|#034|#x22);'i",		// replace html entities
					"'&(amp|#38|#038|#x26);'i",			// added hexadecimal values
					"'&(lt|#60|#060|#x3c);'i",
					"'&(nbsp|#160|#xa0);'i",
					"'&(gt|#62|#062|#x3e);'i",
					"'&(iexcl|#161);'i",
					"'&(cent|#162);'i",
					"'&(pound|#163);'i",
					"'&(copy|#169);'i",
					"'&(reg|#174);'i",
					"'&(deg|#176);'i",
					"'&(#39|#039|#x27);'",
					"'&(euro|#8364);'i",				// europe
					"'&a(uml|UML);'",					// german
					"'&o(uml|UML);'",
					"'&u(uml|UML);'",
					"'&A(uml|UML);'",
					"'&O(uml|UML);'",
					"'&U(uml|UML);'",
					"' '",
					"'&szlig;'i",
					);
	$replace = array(	"",
						"",
						"",
						"",
						"\\1",
						"\"",
						"&",
						"<",
						">",
						" ",
						chr(161),
						chr(162),
						chr(163),
						chr(169),
						chr(174),
						chr(176),
						chr(39),
						chr(128),
						"?",
						"?",
						"?",
						"?",
						"?",
						"?",
						"",
						"?",
					);
				
	$text = preg_replace($search,$replace,$document);
							
	return strip_tags($text);
}

function st_convertrule($rule) {
	$rule = dstripslashes($rule);
	$rule = preg_quote($rule, "/");		//转义正则表达式
	$rule = str_replace('\*', '.*?', $rule);
	$rule = str_replace("\(.*?\)", '(.*?)', $rule);
	
	//$rule = str_replace('\|', '|', $rule);
	
	return $rule;
}



function st_get_host_info($gurl){
    $gurl = preg_replace("/^http:\/\//i", "", trim($gurl));
    $garr['host'] = preg_replace("/\/(.*)$/i", "", $gurl);
    $garr['query'] = "/".preg_replace("/^([^\/]*)\//i", "", $gurl);
    return $garr;
}

?>