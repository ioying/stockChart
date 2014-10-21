<?php

/**
 *      [Sanree] (C)2001-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_question_list.php $
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require_once DISCUZ_ROOT . './source/plugin/tsound/include/function.inc.php';
$pmod='audio';
$act=$_G['onez_act'];
$id=(int)$_G['onez_id'];

if(in_array($act,array('edit'))){
  if($act=='edit'){
    $onez=DB::fetch_first('SELECT * FROM '. DB::table('tsound_record').' where rid='.$id); 
    $url=$onez['file'];
    if(substr($url,0,7)!='http://'){
      $url=trim($_G['siteurl'],'/').'/'.$url;
    }
    include_once(dirname(__FILE__).'/audio.edit.php');
  }
  exit();
}
if(submitcheck('submit')){

	if ($_G['onez_delete']) {
    $query = DB::query("SELECT * FROM ".DB::table('tsound_record')." where rid in (".implode(',',array_keys($_G['onez_delete'])).")");
    while($rs = DB::fetch($query)) {
      @unlink(DISCUZ_ROOT.'/'.$rs['file']);
    }
    DB::query("delete from ".DB::table('tsound_record')." where rid in (".implode(',',array_keys($_G['onez_delete'])).")");
	} 	
	cpmsg(lang('plugin/tsound', 'done_successfully'), 'action=plugins&operation=config&do=' . $pluginid . '&identifier=tsound&pmod='.$pmod, 'succeed');
}else{
	showformheader('plugins&operation=config&do=' . $pluginid . '&identifier=tsound&pmod='.$pmod);
	showtableheader(lang('plugin/tsound', 'audiolist'), 'nobottom');
	showtablerow('',
    array('', '', '', '','', '', '', '', '', '', '', ''),
    array(
      '',
      lang('plugin/tsound', 'ti_title'),
      lang('plugin/tsound', 'ti_status'),
      lang('plugin/tsound', 'ti_username'),
      lang('plugin/tsound', 'ti_sec'),
      lang('plugin/tsound', 'ti_thread'),
  ));
  
  $page = max(1, intval($_G['onez_page']));
  $perpage=20;
  $count=DB::num_rows(DB::query("SELECT * FROM ".DB::table('tsound_record')." $xxx"));
	$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&do=$pluginid&identifier=tsound&pmod=$pmod");
	$query = DB::query("SELECT r.*,m.username,t.subject as thread FROM ".DB::table('tsound_record')." r left join ".DB::table('common_member')." m on m.uid=r.uid left join  ".DB::table('forum_thread')." t on t.tid=r.tid where r.type='audio' and r.status>=0 ORDER BY r.rid desc limit ".(($page - 1) * $perpage).','.$perpage);
	while($rs = DB::fetch($query)) {
		showtablerow('', '', array(
					"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$rs[rid]]\" value=\"$rs[rid]\">",
					$rs['name'],
					lang('plugin/tsound', 'status'.$rs['status']),
					$rs['username'],
					floatval($rs['sec']/100),
					$rs['thread'],
					"<a href=\"?action=plugins&operation=config&do=$pluginid&identifier=tsound&pmod=$pmod&act=edit&id=$rs[rid]\" class=\"act\">".lang('plugin/tsound', 'edit')."</a>"
				));
	}
	showsubmit('submit', 'submit', 'del', "", $multipage);
	showtablefooter();
	showformfooter();		
}
?>