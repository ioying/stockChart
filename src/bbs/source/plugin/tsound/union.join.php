<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
if (!submitcheck('settingsubmit', 1)) {

	showformheader('plugins&operation=config&do=' . $pluginid . '&identifier=tsound&pmod=union&act='.$act.'&id='.$id, 'enctype');
	
	showtableheader(lang('plugin/tsound', 'bindfid'));
  
  showsetting(lang('plugin/tsound', 'ti_sitename'), '', '', $sitename .' <a href="'.$siteurl.'" target="_blank">'.lang('plugin/tsound', 'viewsite').'</a>');
  showsetting(lang('plugin/tsound', 'ti_forumname'), '', '', $forumname .' <a href="'.$siteurl.'/forum.php?mod=forumdisplay&fid='.$forumid.'" target="_blank">'.lang('plugin/tsound', 'viewforum').'</a>');
  showsetting(lang('plugin/tsound', 'ti_fid'), 'fid', '0', 'number');

	showsubmit('settingsubmit','submit','',"
	<input type=\"hidden\" name=\"siteurl\" value=\"$siteurl\">
	<input type=\"hidden\" name=\"sitename\" value=\"$sitename\">
	<input type=\"hidden\" name=\"forumid\" value=\"$forumid\">
	<input type=\"hidden\" name=\"forumname\" value=\"$forumname\">
	<input type=\"hidden\" name=\"union_id\" value=\"$union_id\">
	<input type=\"hidden\" name=\"page\" value=\"$page\">
	");
	showtablefooter();
	showformfooter();
} else {
  $union_id=$_G['onez_union_id'];
  $fid=$_G['onez_fid'];
  $siteurl=$_G['onez_siteurl'];
  $sitename=$_G['onez_sitename'];
  $forumid=$_G['onez_forumid'];
  $forumname=$_G['onez_forumname'];
  $page=$_G['onez_page'];
  
  $T = DB::fetch_first("SELECT * FROM ".DB::table('forum_forum')." where fid='$fid'");
  if($T){
    $name=$T['name'];
  }else{
    $fid=0;
  }
  $data=tsound_post('http://2cscs.onez.cn/onez.php?action=myunion&siteurl='.urlencode($_G['siteurl']),0,'fid='.$fid.'&union_id='.$union_id);
	if($data=='onez'){
    $T = DB::fetch_first("SELECT * FROM ".DB::table('tsound_myunion')." where union_id='$union_id'");
    if(!$T){
      DB::query("INSERT INTO ".DB::table('tsound_myunion')." (union_id,fid,time,forumname,siteurl,sitename,forumid,name) VALUES ('" . $T['siteid'] . "','" . $fid . "','" . TIMESTAMP . "','" . $forumname . "','" . $siteurl . "','" . $sitename . "','" . $forumid . "','" . $name . "') ON DUPLICATE KEY UPDATE fid = '" . $fid . "',forumname = '" . $forumname . "',siteurl = '" . $siteurl . "',sitename = '" . $sitename . "',forumid = '" . $forumid . "',name = '" . $name . "'");
    }
    cpmsg(lang('plugin/tsound', 'done_successfully'), 'action=plugins&operation=config&do=' . $pluginid . '&identifier=tsound&pmod=myunion', 'succeed');
	}else{
    $data=tsound_FlashToDz($data);
    cpmsg($data, 'action=plugins&operation=config&do=' . $pluginid . '&identifier=tsound&pmod=union&page='.$page, 'succeed');
	}
	
}
?>