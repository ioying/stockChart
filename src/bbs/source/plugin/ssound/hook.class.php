<?php
/**
 *	[ÓïÒô·¢Ìû(sound.{modulename})] (C)2012-2099 Powered by .
 *	Version: 1.0
 *	Date: 2012-12-20 16:48
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class plugin_ssound {
	public function global_header() {
    return'<link href="source/plugin/ssound/template/images/style.css" rel="stylesheet" type="text/css" />';
  }
	public function discuzcode($param) {
    global $ssound,$_G;
	//print_r($_G);
		if($param['caller'] == 'discuzcode') {
		require_once DISCUZ_ROOT . './source/plugin/ssound/include/function.inc.php';
		$_G['discuzcodemessage']=preg_replace("/\[ssound\]([^\[]+)\[\/ssound\]/ies", "ssound_parse('\\1')", $_G['discuzcodemessage']);
	    }
	    else {
			$_G['discuzcodemessage'] = preg_replace("/\[ssound\]([^\[]+)\[\/ssound\]/ies", '', $_G['discuzcodemessage']);
	    }
	}
}

class plugin_ssound_forum extends plugin_ssound {
	function post_editorctrl_left() {
    global $ssound,$_G;
    require_once DISCUZ_ROOT . './source/plugin/ssound/include/function.inc.php';
    $groups=(array)@unserialize($ssound['user_group']);
    if(!in_array($_G['groupid'],$groups))return;
    $forums=(array)@unserialize($ssound['bankuai']);
    if(!in_array($_G['fid'],$forums))return;
    return '<a id="e_tsound" title="" onmousedown="showWindow(\'ssound\', \'plugin.php?id=ssound&action=insert&ft=0\')" href="javascript:;">Ëµ»°</a>';

  }
  function viewthread_fastpost_ctrl_extra() {
  global $ssound,$_G;
    require_once DISCUZ_ROOT . './source/plugin/ssound/include/function.inc.php';
    $groups=(array)@unserialize($ssound['user_group']);
    if(!in_array($_G['groupid'],$groups))return;
    $forums=(array)@unserialize($ssound['bankuai']);
    if(!in_array($_G['fid'],$forums))return;
  return '<a id="ssound_fast1" title="" onmousedown="showWindow(\'ssound\', \'plugin.php?id=ssound&action=insert&ft=1\')" href="javascript:;"></a>';
  //return ;post_infloat_middle
  }
  function post_infloat_middle() {
  global $ssound,$_G;
    require_once DISCUZ_ROOT . './source/plugin/ssound/include/function.inc.php';
    $groups=(array)@unserialize($ssound['user_group']);
    if(!in_array($_G['groupid'],$groups))return;
    $forums=(array)@unserialize($ssound['bankuai']);
    if(!in_array($_G['fid'],$forums))return;
  return '<a id="ssound_fast2" title="" onmousedown="showWindow(\'ssound\', \'plugin.php?id=ssound&action=insert&ft=2\')" href="javascript:;"></a>';
  //return ;post_infloat_middle
  }
}
?>