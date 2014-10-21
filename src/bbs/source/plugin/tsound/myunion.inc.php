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
$pmod='myunion';
$act=$_G['onez_act'];
$id=(int)$_G['onez_id'];

if(submitcheck('submit')){

	if ($_G['onez_delete']) {
    DB::query("delete from ".DB::table('tsound_myunion')." where union_id in (".implode(',',array_keys($_G['onez_delete'])).")");
	}
  $ids=array();
  $query = DB::query("SELECT * FROM ".DB::table('tsound_myunion'));
  while($rs = DB::fetch($query)) {
    $ids[]=$rs['union_id'];
  }
  $ids=implode(',',$ids);
  $data=@file_get_contents('http://2cscs.onez.cn/onez.php?action=deletemyunion&siteurl='.urlencode($_G['siteurl']).'&ids='.$ids);
  cpmsg(lang('plugin/tsound', 'done_successfully'), 'action=plugins&operation=config&do=' . $pluginid . '&identifier=tsound&pmod=myunion', 'succeed');
}else{
	showformheader('plugins&operation=config&do=' . $pluginid . '&identifier=tsound&pmod='.$pmod);
	showtableheader(lang('plugin/tsound', 'myunionlist'), 'nobottom');
	showtablerow('',
    array('', '', '', '','', '', '', '', '', '', '', ''),
    array(
      '',
      lang('plugin/tsound', 'ti_sitename'),
      lang('plugin/tsound', 'ti_forumname'),
      lang('plugin/tsound', 'bindfid'),
      lang('plugin/tsound', 'ti_time'),
      lang('plugin/tsound', 'ti_num'),
      '',
  ));
  
  $page = max(1, intval($_G['onez_page']));
  $perpage=20;
  $count=DB::num_rows(DB::query("SELECT * FROM ".DB::table('tsound_myunion')." $xxx"));
	$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&do=$pluginid&identifier=tsound&pmod=$pmod");
	$query = DB::query("SELECT * FROM ".DB::table('tsound_myunion')." ORDER BY union_id desc limit ".(($page - 1) * $perpage).','.$perpage);
	while($rs = DB::fetch($query)) {
		showtablerow('', '', array(
					"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$rs[union_id]]\" value=\"$rs[union_id]\">",
					$rs['sitename'],
					$rs['forumname'],
					$rs['name'],
					date('Y-m-d H:i:s',$rs['time']),
					$rs['num'],
					'<a href="'.$rs['siteurl'].'" target="_blank">'.lang('plugin/tsound', 'viewsite').'</a> &nbsp; <a href="'.$rs['siteurl'].'/forum.php?mod=forumdisplay&fid='.$rs['forumid'].'" target="_blank">'.lang('plugin/tsound', 'viewforum').'</a>'
				));
	}
	showsubmit('submit', 'submit', 'del', "", $multipage);
	showtablefooter();
	showformfooter();		
}
?>