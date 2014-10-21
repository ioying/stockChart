<?php
/*
        [DISCUZ X2] 完美枫枫

        Author: wanmeiff.com (565948567@qq.com)
        Copyright: For crystar
        Last Modified: 2012.12.5
*/

if(!defined('IN_DISCUZ')) {
   exit('Access Deined');
}

//include("class.phpmailer.php");
//include("class.smtp.php"); 

global $_G;
$wmff_jianfan_plugin = $_G['cache']['plugin']['wmff_jianfan'];
		$set= $_G['cache']['plugin']['wmff_jianfan'];
		$lang = lang('plugin/wmff_jianfan');
		$wmff_jianfan_close = $set['wmff_jianfan_close'];//开关
		$wmff_jianfan_biaoti = $set['wmff_jianfan_biaoti'];//BT
    $wmff_jianfan_jianjie = $set['wmff_jianfan_jianjie'];//NR
    $wmff_jianfan_gbut = $set['wmff_jianfan_gbut'];//GBUT
     $wmff_bl_fantizw = $lang['bl_fantizw'];
     $wmff_jianfan_weizhi = $lang['wmff_jianfai_weizhi'];
    
     
     
    $navtitle = lang('plugin/wmff_jianfan', $wmff_jianfan_biaoti.$lang['bl_btgjc']." Plug-in belongs to genus wanmeiff.com and vcpic.com");

    if ($wmff_jianfan_gbut==1){
    	$wmff_jianfan_gbut="_gbk";
    	}else
    	{
    		$wmff_jianfan_gbut="_utf8";
    		}

if($wmff_jianfan_close==1){
include template('wmff_jianfan:wmff_jianfan');
}
?>
 