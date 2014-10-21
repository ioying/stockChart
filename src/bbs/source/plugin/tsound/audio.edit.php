<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
if (!submitcheck('settingsubmit', 1)) {

	showformheader('plugins&operation=config&do=' . $pluginid . '&identifier=tsound&pmod=audio&act='.$act.'&id='.$id, 'enctype');
	
	showtableheader(lang('plugin/tsound', 'edit_audio'));

  showsetting(lang('plugin/tsound', 'ti_title'), 'onez[name]', $onez['name'], 'text');
  showsetting(lang('plugin/tsound', 'ti_readme'), 'onez[readme]', $onez['readme'], 'textarea');
  
	showsetting(lang('plugin/tsound', 'ti_status'), 'onez[status]', $onez['status'], 'radio');
	showsetting(lang('plugin/tsound', 'ti_show'), '', '', tsound_parse($id));
	showsetting(lang('plugin/tsound', 'ti_down'), '', '', '<a href="'.$url.'" target="_blank" style="color:#00c">'.$url.'</a>');

	showsubmit('settingsubmit');
	showtablefooter();
	showformfooter();
} else {
  $onez=(array)$_G['onez_onez'];
  $onez['status']=intval($onez['status']);
	DB::update('tsound_record', $onez, "rid='$id'");
	
	cpmsg(lang('plugin/tsound', 'done_successfully'), 'action=plugins&operation=config&do=' . $pluginid . '&identifier=tsound&pmod=audio', 'succeed');
}
?>
