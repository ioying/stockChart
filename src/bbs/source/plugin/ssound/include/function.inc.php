<?php
global $_G;
foreach($_GET as $k => $v) {
	$_G['onez_'.$k] = function_exists('daddslashes') ? daddslashes($v) : $v;
}
foreach($_POST as $k => $v) {
	$_G['onez_'.$k] = function_exists('daddslashes') ? daddslashes($v) : $v;
}
global $ssound;
$ssound = $_G['cache']['plugin']['ssound'];

function ssound_dzToFlash($str){
  global $_G;
  if(strtolower($_G['charset'])!='utf-8'){
    $str=ssound_oiconv($_G['charset'],'utf-8',$str);
  }
  return $str;
}
function ssound_FlashToDz($str){
  global $_G;
  if(strtolower($_G['charset'])!='utf-8'){
    $str=ssound_oiconv('utf-8',$_G['charset'],$str);
  }
  return $str;
}
function ssound_oiconv($from,$to,$string){
  if(function_exists('mb_convert_encoding')){
    return mb_convert_encoding($string,$to,$from);
  }else{
    return iconv($from,$to,$string);
  }
}
function ssound_upload(){
  global $_G;
 if($_GET['hash']){
    $filename=addslashes($_GET['hash']).".wav";//要生成的文件的名字 由flash自动生成且做了formhash认证 没有覆盖文件BUG
    $xmlstr =  $GLOBALS["values"]["HTTP_RAW_POST_DATA"];  
    if(empty($xmlstr)) {  
        $xmlstr = file_get_contents('php://input');  
    }
    $wav = $xmlstr;//得到post过来的二进制原始数据*/
	//print_r(file_get_contents); exit();
	$path=DISCUZ_ROOT.'./data/cache/ssound/';
	//$wav=$_POST['wav'];
    if(!file_exists($path)){ @mkdir($path,0777); @mkdir($path."wav/",0777);} 
    $file = fopen('./data/cache/ssound/wav/'.$filename,"w");//打开文件准备写入  
    fwrite($file,$wav);//写入  
    fclose($file);//关闭  
    $succeed=1;  
	}
	else{
	echo "no hash!";
	$succeed=0;
	}
	if($succeed) {
    return trim($_G['siteurl'],'/').'/data/cache/ssound/wav/'.$filename;
	} else {
		exit('upload failed! no hash exit!');
	}
}
function ssound_parse($url){
  return ssound_insertflash('source/plugin/ssound/template/player.swf?path='.$url,'son='.$url,340,100,'ssound');
}
function ssound_insertflash($Flash,$Vars,$width,$Height,$ID){
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
function ssound_json($a=false){
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
    foreach ($a as $v) $result[] = ssound_json($v); 
    return '[' . join(',', $result) . ']'; 
  }else{
    foreach ($a as $k => $v) $result[] = ssound_json($k).':'.ssound_json($v); 
    return '{' . join(',', $result) . '}'; 
  } 
}
?>