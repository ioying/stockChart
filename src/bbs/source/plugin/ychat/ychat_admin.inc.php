<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: admincp_ychat.php 27939 2012-02-17 03:03:07Z chxs $
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$_GET=daddslashes($_GET);
$_POST=daddslashes($_POST);
cpheader();
$ymod=$_GET["ymod"];
$ymod = !$ymod ? 'basic' : $ymod;
if($ymod=="basic") {
	showtableheader();
	$configarray =C::t("#ychat#ychat_config")->fetch_all();
			
	echo '<tr class="header"><td colspan="8"><div>'.lang('plugin/ychat', 'ychat_basic_configname').'</div></td><td colspan="8"><div>'.lang('plugin/ychat', 'ychat_basic_configvalue').'</div></td><td colspan="8"><div>'.lang('plugin/ychat', 'ychat_basic_configedit').'</div></td></tr>';
	foreach($configarray as $config_value)
	{
		echo '<tr class="hover"><td colspan="8"><div>'.lang('plugin/ychat', 'ychatduo_basic_'.$config_value["var"]).'</div></td><td colspan="8"><div>'.$config_value["value"].'</div></td><td colspan="8"><div><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&identifier=ychat&pmod=ychat_admin&ymod=editbasic&var='.$config_value["var"].'" >'.lang('plugin/ychat', 'ychat_basic_configedit').'</a></div></td></tr>';
	}
	showtablefooter();
}
else if($ymod=="editbasic") {
	$yvar=dhtmlspecialchars(getgpc('var'));
	if(!submitcheck('ychatsubmit'))
	{
		showformheader('plugins&operation=config&identifier=ychat&pmod=ychat_admin&ymod=editbasic&var='.$yvar);
		showtableheader();
		$config_query = DB::query("select * from ".DB::table("ychat_config")." where var='".$yvar."'");
		if($config_value=DB::fetch($config_query))
		{
			showsetting(lang('plugin/ychat', 'ychatduo_basic_'.$config_value["var"]), 'txt', $config_value["value"], 'text');		
			showsubmit('ychatsubmit', 'submit');
		}
		showtablefooter();
		showformfooter();
	}
	else
	{
		$txt=$_POST['txt'];
		$config_query = C::t("#ychat#ychat_config")->update($yvar,array('value'=>$txt));
		if($config_query)
		{
			cpmsg(lang('plugin/ychat','ychat_basic_eidt_success'),'action=plugins&operation=config&identifier=ychat&pmod=ychat_admin','succeed');
		}
		else
		{
			cpmsg(lang('plugin/ychat','ychat_basic_eidt_error'),'','error');
		}
	}
}

?>