<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if($_G['uid']<=0) exit("you haven't login!");
require_once DISCUZ_ROOT . './source/plugin/ssound/include/function.inc.php';
$action=$_G['onez_action'];
//echo $action; exit;
$ft=$_G['onez_ft'];
if($action=='insert'){
  $flash=ssound_insertflash('source/plugin/ssound/template/recorder.swf?ft='.$ft."&formhash=".formhash(),$flashvars,550,300,'ssound_insert');
  include template('ssound:insert');
}elseif($action=='upload'){
  set_time_limit(0);
  $url=ssound_upload();
  exit($url);
}
echo "ssound";
?>