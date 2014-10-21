<?php

/**    
 *	Powered by 完美枫枫.
 *	Version: 1.0 完美枫枫插件学习QQ群：196923393
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class plugin_wmff_jianfan {
function global_cpnav_top() {
     global $_G;
     $set= $_G['cache']['plugin']['wmff_jianfan'];
//$wmff_bl_fantizw = $lang['bl_fantizw'];
     $wmff_jianfan_weizhi = $set['wmff_jianfai_weizhi'];
      $wmff_jianfan_zdybt = $set['wmff_jianfan_zdybt'];  
       $wmff_jianfan_quanju = $set['wmff_jianfan_quanju'];  

    		 if ($wmff_jianfan_quanju==1){
    		 	if($wmff_jianfan_weizhi==1){
    	   	 return '<a href="javascript:;" id="wmffstranlink">'.$wmff_jianfan_zdybt.'</a>';
    		 }}
 
	  
	}
 
 function global_cpnav_extra1() {
     global $_G;
     $set= $_G['cache']['plugin']['wmff_jianfan'];
//$wmff_bl_fantizw = $lang['bl_fantizw'];
     $wmff_jianfan_weizhi = $set['wmff_jianfai_weizhi'];
      $wmff_jianfan_zdybt = $set['wmff_jianfan_zdybt'];  
       $wmff_jianfan_quanju = $set['wmff_jianfan_quanju'];  
	 if ($wmff_jianfan_quanju==1){
    		 	if($wmff_jianfan_weizhi==2){
    	   	 return '<a href="javascript:;" id="wmffstranlink">'.$wmff_jianfan_zdybt.'</a>';
    		 }}
    		
    		 }
	
 function global_cpnav_extra2() {
     global $_G;
     $set= $_G['cache']['plugin']['wmff_jianfan'];
//$wmff_bl_fantizw = $lang['bl_fantizw'];
     $wmff_jianfan_weizhi = $set['wmff_jianfai_weizhi'];
      $wmff_jianfan_zdybt = $set['wmff_jianfan_zdybt'];  
       $wmff_jianfan_quanju = $set['wmff_jianfan_quanju'];  
	 if ($wmff_jianfan_quanju==1){
    		 	if($wmff_jianfan_weizhi==3){
    	   	 return '<a href="javascript:;" id="wmffstranlink">'.$wmff_jianfan_zdybt.'</a>';
    		 }}
 }
 
  function global_nav_extra() {
     global $_G;
     $set= $_G['cache']['plugin']['wmff_jianfan'];
//$wmff_bl_fantizw = $lang['bl_fantizw'];
     $wmff_jianfan_weizhi = $set['wmff_jianfai_weizhi'];
      $wmff_jianfan_zdybt = $set['wmff_jianfan_zdybt'];  
       $wmff_jianfan_quanju = $set['wmff_jianfan_quanju'];  

	 if ($wmff_jianfan_quanju==1){
    		 	if($wmff_jianfan_weizhi==4){
    	   	 return '<a href="javascript:;" id="wmffstranlink">'.$wmff_jianfan_zdybt.'</a>';
    		 }}
    		  }
 
   function global_footerlink() {
     global $_G;
     $set= $_G['cache']['plugin']['wmff_jianfan'];
//$wmff_bl_fantizw = $lang['bl_fantizw'];
     $wmff_jianfan_weizhi = $set['wmff_jianfai_weizhi'];
      $wmff_jianfan_zdybt = $set['wmff_jianfan_zdybt'];  
       $wmff_jianfan_quanju = $set['wmff_jianfan_quanju'];  
 

    		 
    		 
    		    $wmff_jianfan_gbut_a = $set['wmff_jianfan_gbut'];//GBUT
     $wmff_bl_fantizw = $lang['bl_fantizw'];
    		      $wmaffmrjf = $set['wmaffmrjf'];
     $wmff_jianfan_color = $set['wmff_jianfan_color'];
     
      
     if ($wmff_jianfan_gbut_a==1){
    	$wmff_jianfan_gbut_a="_gbk";
    	}else
    	{
    		$wmff_jianfan_gbut_a="_utf8";
    		}
    		
    		  $return = '';
    	include 'template/top_1.htm';

    		 	 if ($wmff_jianfan_quanju==1){
    		 	if($wmff_jianfan_weizhi==5){
    		 		 
      $anniuaa= '<a href="javascript:;" id="wmffstranlink">'.$wmff_jianfan_zdybt.'</a>';
    		 }}
    		 
   
 
     return $anniuaa. $return;
  }
 
 
function global_footer() {
     global $_G;
     $set= $_G['cache']['plugin']['wmff_jianfan'];
     		$lang = lang('plugin/wmff_jianfan'); 
     $wmff_jianfan_gbut_a = $set['wmff_jianfan_gbut'];//GBUT
     $wmff_bl_fantizw = $lang['bl_fantizw'];
  //   $wmff_jianfan_weizhi = $lang['wmff_jianfai_weizhi'];
    // $wmff_jianfan_zdybt = $lang['wmff_jianfan_zdybt'];  
     
      $wmaffmrjf = $set['wmaffmrjf'];
     $wmff_jianfan_color = $set['wmff_jianfan_color'];
     
     
     if ($wmff_jianfan_gbut_a==1){
    	$wmff_jianfan_gbut_a="_gbk";
    	}else
    	{
    		$wmff_jianfan_gbut_a="_utf8";
    		}
 // $return = '';
  // include 'template/top_1.htm';
 //return $return;
	   

 
	  
	  
	  	  return $return;
	  
	  
	}

 
	}
?>