<?php

global $_G,$tsound;
foreach($_GET as $k => $v) {
	$_G['onez_'.$k] = function_exists('daddslashes') ? daddslashes($v) : $v;
}
foreach($_POST as $k => $v) {
	$_G['onez_'.$k] = function_exists('daddslashes') ? daddslashes($v) : $v;
}
define('TSOUND_SETTING',DISCUZ_ROOT.'./data/tsound.php');
if(in_array('plugin',$_G['setting']['rewritestatus'])){
  $url=$_G['setting']['rewriterule']['plugin'];
  $url=str_replace(array('{pluginid}','{module}'),'tsound',$url);
  define('BASEURL',$url.'?');
}else{
  define('BASEURL','plugin.php?id=tsound&');
}
if(file_exists(TSOUND_SETTING)){
  @include(TSOUND_SETTING);
}else{
  $tsound=array('verify'=>0);
}
$tsound = @array_merge($tsound,$_G['cache']['plugin']['tsound']);


function tsound_button($isthread=1){
  global $tsound,$_G;
  
  if ($tsound['enabled_rqd']){
   	  $data='';
	  if($tsound['enabled_audio']){
	    $data.='<a id="e_tsound" title="'.lang('plugin/tsound','addsound1').'" onmousedown="showWindow(\'tsound\', \''.BASEURL.'action=record&type=audio&isthread='.$isthread.'\')" href="javascript:;">'.lang('plugin/tsound','addsound2').'</a>';
	  }
	  if($tsound['enabled_video']){
	    $data.='<a id="e_tsound2" title="'.lang('plugin/tsound','addvideo1').'" onmousedown="showWindow(\'tsound\', \''.BASEURL.'action=record&type=video&isthread='.$isthread.'\')" href="javascript:;">'.lang('plugin/tsound','addvideo2').'</a>';
	  }
  }else{
	  $groups=(array)@unserialize($tsound['groups']);
	  if(!in_array($_G['groupid'],$groups))return;
	  $forums=(array)@unserialize($tsound['forums']);
	  if(!in_array($_G['fid'],$forums))return;
	  $data='';
	  if($tsound['enabled_audio']){
	    $data.='<a id="e_tsound" title="'.lang('plugin/tsound','addsound1').'" onmousedown="showWindow(\'tsound\', \''.BASEURL.'action=record&type=audio&isthread='.$isthread.'\')" href="javascript:;">'.lang('plugin/tsound','addsound2').'</a>';
	  }
	  if($tsound['enabled_video']){
	    $data.='<a id="e_tsound2" title="'.lang('plugin/tsound','addvideo1').'" onmousedown="showWindow(\'tsound\', \''.BASEURL.'action=record&type=video&isthread='.$isthread.'\')" href="javascript:;">'.lang('plugin/tsound','addvideo2').'</a>';
	  }
  }
  return $data;
}

function tsound_post($url, $limit = 0, $post = '', $cookie = '', $bysocket = FALSE, $ip = '', $timeout = 15, $block = TRUE) {
	$return = '';
	$matches = parse_url($url);
	!isset($matches['host']) && $matches['host'] = '';
	!isset($matches['path']) && $matches['path'] = '';
	!isset($matches['query']) && $matches['query'] = '';
	!isset($matches['port']) && $matches['port'] = '';
	$host = $matches['host'];
	$path = $matches['path'] ? $matches['path'].($matches['query'] ? '?'.$matches['query'] : '') : '/';
	$port = !empty($matches['port']) ? $matches['port'] : 80;
	if($post) {
		$out = "POST $path HTTP/1.0\r\n";
		$out .= "Accept: */*\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= 'Content-Length: '.strlen($post)."\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cache-Control: no-cache\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
		$out .= $post;
	} else {
		$out = "GET $path HTTP/1.0\r\n";
		$out .= "Accept: */*\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "User-Agent: $_SERVER[HTTP_USER_AGENT]\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Connection: Close\r\n";
		$out .= "Cookie: $cookie\r\n\r\n";
	}
	$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
	if(!$fp) {
		return '';
	} else {
		stream_set_blocking($fp, $block);
		stream_set_timeout($fp, $timeout);
		@fwrite($fp, $out);
		$status = stream_get_meta_data($fp);
		if(!$status['timed_out']) {
			while (!feof($fp)) {
				if(($header = @fgets($fp)) && ($header == "\r\n" ||  $header == "\n")) {
					break;
				}
			}

			$stop = false;
			while(!feof($fp) && !$stop) {
				$data = fread($fp, ($limit == 0 || $limit > 8192 ? 8192 : $limit));
				$return .= $data;
				if($limit) {
					$limit -= strlen($data);
					$stop = $limit <= 0;
				}
			}
		}
		@fclose($fp);
		return $return;
	}
}
function tsound_flashToDz($str){
  global $_G;
  if(strtolower($_G['charset'])!='utf-8'){
    if(is_array($str)){
      foreach($str as $k=>$v){
        $str[$k]=tsound_flashToDz($v);
      }
    }else{
      $str=tsound_oiconv('utf-8',$_G['charset'],$str);
    }
  }
  return $str;
}
function tsound_dzToFlash($str){
  global $_G;
  if(strtolower($_G['charset'])!='utf-8'){
    if(is_array($str)){
      foreach($str as $k=>$v){
        $str[$k]=tsound_dzToFlash($v);
      }
    }else{
      $str=tsound_oiconv($_G['charset'],'utf-8',$str);
    }
  }
  return $str;
}
function tsound_oiconv($from,$to,$string){
  if(function_exists('mb_convert_encoding')){
    return mb_convert_encoding($string,$to,$from);
  }else{
    return iconv($from,$to,$string);
  }
}
function tsound_upload(){
  global $tsound,$_G;
  $cloudurl=$_G['onez_cloudurl'];
  if($cloudurl){
    $succeed = true;
    $file=$cloudurl;
  }else{
    $token='data';
    $name=$_FILES[$token]['name'];
    $_FILES[$token]['error'] && exit('Error');
    if(!$_FILES[$token]['tmp_name']) {
      return 'none';
    }	
    $filetype=strtolower(end(explode('.',$name)));
    if($filetype!='mp3')exit('Error Format');
    $path=DISCUZ_ROOT.'./'.$tsound['path_audio'];
    if(!file_exists($path))@mkdir($path,0777);
    @touch("$path/index.html");
    $key=uniqid();
    $file=$key.'.'.$filetype;
    if(@copy($_FILES[$token]['tmp_name'], $path.'/'.$file)) {
      $succeed = true;
    }elseif(function_exists('move_uploaded_file') && @move_uploaded_file($_FILES[$token]['tmp_name'], $path.'/'.$file)) {
      $succeed = true;
    }
    $file=$tsound['path_audio'].'/'.$key.'.mp3';
  }
  
	if($succeed) {
    $rid=(int)$_G['onez_rid'];
    $size=(int)$_G['onez_size'];
    $sec=(int)$_G['onez_sec'];
    DB::update('tsound_record',array(
      'size'=>$size,
      'sec'=>$sec,
      'status'=>$tsound['auto_audio']?'1':'0',
      'file'=>$file,
    ),"rid='$rid'");
    return 'ok'.$rid;
	} else {
		exit('Can not write to cache files, please check directory ./'.$tsound['path_audio'].'/ .');
	}
}
function tsound_upload2(){
  global $tsound,$_G;
  $id=$_G['onez_flvid'];
  
  $name=$_FILES['thumb']['name'];
  $_FILES['thumb']['error'] && exit('Error');
  $filetype=strtolower(end(explode('.',$name)));
  if($filetype!='jpg')exit('Error Format');
  $path=DISCUZ_ROOT.'./'.$tsound['path_video'];
  $path=DISCUZ_ROOT.'./data/cache/tsound';
  
  $rid=(int)$_G['onez_rid'];
  $size=(int)$_G['onez_size'];
  $sec=(int)$_G['onez_sec'];
  
  if(!file_exists($path))@mkdir($path,0777);
  @touch("$path/index.html");
  $file=$rid.'.'.$filetype;
  if(@copy($_FILES['thumb']['tmp_name'], $path.'/'.$file)) {
    $succeed2 = true;
  }elseif(function_exists('move_uploaded_file') && @move_uploaded_file($_FILES['thumb']['tmp_name'], $path.'/'.$file)) {
    $succeed2 = true;
  }
  DB::update('tsound_record',array(
    'size'=>$size,
    'sec'=>$sec,
    'token'=>$id,
    'status'=>$tsound['auto_video']?'1':'0',
    'file'=>'http://2cscs.onez.cn/onez.php?action=video&siteurl='.urlencode($_G['siteurl']).'&id='.$id,
  ),"rid='$rid'");
}
function tsound_parse($rid,$fid=0,$tid=0,$pid=0){
  global $tsound,$_G,$pmod,$tsound_css;
  if(substr($rid,0,7)=='http://'){
    return tsound_insertflash($_G['siteurl'].'/source/plugin/tsound/template/player.swf','color='.$tsound['playercolor'].'&son='.$rid,250,40,'tsound');
  }
  list($_rid,$siteurl)=explode('|',$rid);
  if(is_numeric($_rid) && substr($siteurl,0,7)=='http://'){
    $data=@file_get_contents($siteurl.'/'.BASEURL.'action=parse&rid='.$_rid);
    if(substr($data,0,4)!='onez'){
      return'';
    }
    $data=tsound_flashToDz($data);
    return $data;
  }
  $T = DB::fetch_first("SELECT * FROM ".DB::table('tsound_record')." where rid='$rid'");
  if($T){
    $url=$T['file'];
    if(substr($url,0,7)!='http://'){
      $url=trim($_G['siteurl'],'/').'/'.$url;
    }
    if(!$T['tid'] && $tid){
      $T2 = DB::fetch_first("SELECT * FROM ".DB::table('forum_post')." where tid='$tid' and first=1");
      if($T2){
        $subject=$T2['subject'];
        $message=$T2['message'];
        $message=str_replace('[tsound]'.$rid.'[/tsound]','[tsound]'.$rid.'|'.$_G['siteurl'].'[/tsound]',$message);
        if($T['isthread'] && $tsound['isunion']){
          for($i=1;$i<99;$i++){
            if($tsound['fid'.$i]==$fid){
              $data=@tsound_post('http://2cscs.onez.cn/onez.php?action=thread&siteurl='.urlencode($_G['siteurl']),0,'fid='.$fid.'&tid='.$tid.'&uid='.$_G['uid'].'&username='.$_G['username'].'&url='.urlencode($url).'&subject='.urlencode(tsound_dzToFlash($subject)).'&content='.urlencode(tsound_dzToFlash($message)));
            }
          
          }
        }
      }
    }
    DB::update('tsound_record',array(
      'tid'=>$tid,
      'pid'=>$pid,
    ),"rid='$rid'");
    !$tsound['playercolor'] && $tsound['playercolor']='green';
    $str='<link href="source/plugin/tsound/template/images/thread.css" rel="stylesheet" type="text/css" />';
    
    $groups=(array)$tsound['down_group'];
    $down=0;
    if(in_array($_G['groupid'],$groups)){
      $down=1;
    }
    if($down || $T['readme']){
      $str2='<div class="tsound_box">';
      $str2.='<div class="tsound_top"></div>';
      $str2.='<div class="tsound_main"><div class="tsound_bar"></div>';
      $str2.='<ul>';
      $T['readme'] && $str2.='<li class="tsound_info">'.$T['readme'].'</li>';
      $down && $str2.='<li class="tsound_down"><a href="'.$url.'" target="_blank">'.lang('plugin/tsound', 'downnow').'</a></li>';
      $str2.='</ul>';
      $str2.='</div>';
      $str2.='<div class="tsound_bottom"></div>';
      $str2.='</div>';
    }
    if($T['type']=='audio'){
    	
      if($T['status']=='0' && !$pmod){
      	
        return $str.$tsound['tip_nocheck_audio'];
      }
      return $str.tsound_insertflash($_G['siteurl'].'/source/plugin/tsound/template/player.swf','color='.$tsound['playercolor'].'&son='.$url,250,40,'tsound').$str2;
    }else{
      if($T['status']=='0' && !$pmod){
        return $str.$tsound['tip_nocheck_video'];
      }
      $width=(int)$tsound['video_width'];!$width && $width=200;
      $height=(int)$tsound['video_height'];!$height && $height=150;
      return $str.tsound_insertflash($_G['siteurl'].'/source/plugin/tsound/template/player2.swf','color='.$tsound['playercolor'].'&flv='.$rid,$width+25,$height+21,'tvideo').$str2;
    }
  }else{
    return $str.$tsound['tip_none'];
  }
}
function tsound_insertflash($Flash,$Vars,$width,$Height,$ID){
  strpos($Flash,'?')===false && $Flash.='?t='.@filemtime($Flash);
  $fullcode=0;
  if($fullcode){
    $FlashHtml='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" ';
    $FlashHtml.='codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" ';
    $FlashHtml.='width="' . $width . '" height="' . $Height . '" id="' . $ID . '">';
    $FlashHtml.='<param name="movie" value="' . $Flash . '">';
    $FlashHtml.='<param name="quality" value="high">';
    $FlashHtml.='<param name="allowFullScreen" value="true">';
    $FlashHtml.='<param name="wmode" value="opaque">';
    $FlashHtml.='<param name="allowscriptaccess" value="always">';
    $FlashHtml.='<param name="FlashVars" value="'.$Vars.'">';
  }
  $FlashHtml.='<embed src="' . $Flash . '" name="' . $ID . '" quality="high" allowscriptaccess="always" pluginspage="http://www.macromedia.com/go/getflashplayer" ';
  $FlashHtml.='type="application/x-shockwave-flash" width="' . $width . '" FlashVars="'.$Vars.'" wmode="opaque" allowFullScreen="true" height="' . $Height . '"></embed>';
  if($fullcode){
    $FlashHtml.='</object>';
  }
  return $FlashHtml;
}
function tsound_json($a=false){
  if (is_null($a)) return 'null'; 
  if ($a === false) return 'false'; 
  if ($a === true) return 'true'; 
  if (is_scalar($a)){ 
    if (is_float($a)){ 
      return floatval(str_replace(",", ".", strval($a))); 
    } 
    if (is_string($a)) { 
      $jsonReplaces = array(array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'), array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"')); 
      return '"' . str_replace($jsonReplaces[0], $jsonReplaces[1], $a) . '"'; 
    }else{
       return $a; 
    }
  } 
  $isList = true; 
  for($i = 0, reset($a); $i < count($a); $i++, next($a)){ 
    if(key($a) !== $i){ 
      $isList = false; 
      break; 
    } 
  } 
  $result = array(); 
  if ($isList){ 
    foreach ($a as $v) $result[] = tsound_json($v); 
    return '[' . join(',', $result) . ']'; 
  }else{
    foreach ($a as $k => $v) $result[] = tsound_json($k).':'.tsound_json($v); 
    return '{' . join(',', $result) . '}'; 
  } 
}
?>