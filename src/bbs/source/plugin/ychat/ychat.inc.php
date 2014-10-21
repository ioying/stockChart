<?php

if(!defined('IN_DISCUZ')) {
   exit('Access Deined');
}

$ychat_plugin = $_G['cache']['plugin']['ychat'];
$_GET=daddslashes($_GET);
$_POST=daddslashes($_POST);
$modarr = array('index','rooms','userinfo', 'credit', 'moreuserinfo','chat','config','gift','crole','paodian','login','modifyuserinfo','rank','fmsdata');
$mod = getgpc('mod');
$mod = !$mod ? 'index' : $mod;
$navtitle=$ychat_plugin['title'];
$metakeywords=$ychat_plugin['keywords'];
$metadescription=$ychat_plugin['description'];
if($mod && in_array($mod, $modarr))
{
	require ('module/'.$mod.'.php');
}
else
{
	exit('Access Deined');
}
?>