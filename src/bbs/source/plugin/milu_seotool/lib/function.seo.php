<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


function miluseo_replace($info, $bbs = 1) {
	if(!$info) return;
	include_once libfile('function/home');
	$set = tool_common_get('article_seo');
	$key_arr = array('push_title_header','push_title_footer','push_content_header','push_content_body','push_content_footer','push_reply_header', 'push_reply_body', 'push_reply_footer');
	foreach($key_arr as $v){
		$$v = st_format_wrap($set[$v]);
	}
	$info_key = array('title', 'content', 'reply');
	$hide = $bbs == 1 ? 0 : 1; 
	foreach($info_key as $v){
		if(!$info[$v]) continue;
		if($v != 'title'){//Ìí¼ÓËæ»úÒş²ØÄÚÈİ
			$rand_arr_key = 'push_'.$v.'_body';
			if($$rand_arr_key){
				$rand_arr = implode('*_*', $$rand_arr_key);
				$info[$v] = preg_replace("/\r\n|\n|\r/e", "miluseo_jammer('', '$rand_arr', $bbs)", $info[$v]);
				$info[$v] = preg_replace("/<\/p>|<\/P>/e", "miluseo_jammer('</p>', '$rand_arr', $bbs)", $info[$v]);
			}
			
		}
		$header_arr = 'push_'.$v.'_header';
		$header_arr = $$header_arr;
		$header = $header_arr[array_rand($header_arr)];
		$footer_arr = 'push_'.$v.'_footer';
		$footer_arr = $$footer_arr;
		$footer = $footer_arr[array_rand($footer_arr)];
		$info[$v] = $header.$info[$v];
		$info[$v] .= $footer;
		if($v == 'title') $info[$v] = getstr(trim($info[$v]), 80, 1, 1);
	}
	return $info;
}
function miluseo_jammer($flag,$rand_arr, $bbs = 1) {
	$rand_arr = explode('*_*', $rand_arr);
	$randomstr = $rand_arr[array_rand($rand_arr)];
	return mt_rand(0, 1) && $bbs==1 ? $flag.'<font class="jammer">'.$randomstr.'</font>'."\r\n" :
		 $flag."\r\n".'<span style="display:none">'.$randomstr.'</span>';
}

function miluseo_word_replace($data, $word = ''){
	if(!VIP) return $data;
	if(!$data) return $data;
	$words = $words ? $words : get_seo_word_arr(2);
	if(!$words) return $data;
	if(is_array($data)){
		foreach($data as $k => $v){
			$v = strtr($v,$words);
			$data[$k] = $v;
		}
	}else{
		$data = strtr($data,$words);
	}
	return $data;
}

function get_seo_word_arr($text = 0){
	global $_G;
	$words = array();
	$data_file = SEO_WORD_FILE;
	$handle = fopen($data_file, "r");
	$data = fread($handle, filesize($data_file));
	$data = $old_data = trim($data);
	if(GBK) $data = st_str_iconv($data);
	if($text == 1) return $data;
	$word_arr = explode("\r\n", $data);
	if(!$word_arr){
		$word_arr = explode("\r\n", $old_data);
	}
	if(!$word_arr) return;
	if($text == 0) return $word_arr;
	$ext_str = get_seo_word_split();
	foreach((array)$word_arr as $k=>$v){
		if(!$k) continue;
		$str_arr = explode($ext_str, $v);//¹Ø¼ü´Ê·Ö¸î·û
		$words += array("$str_arr[0]" => "$str_arr[1]");
	}
	return $words;
}

function get_seo_word_split(){
	$format_str = stlang('format_str');
	$format_arr = explode('@', $format_str);
	$ext_str = '¡ú';
	foreach((array)$format_arr as $k => $v){
		$v_arr = explode('|', $v);
		if($v_arr[0] == '&rarr;') $ext_str =  $v_arr[1];
	}
	return $ext_str;
}

?>