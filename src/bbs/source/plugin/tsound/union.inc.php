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
if($act=='join'){
  $union_id=$_G['onez_union_id'];
  $siteurl=$_G['onez_siteurl'];
  $forumid=$_G['onez_forumid'];
  $forumname=$_G['onez_forumname'];
  $sitename=$_G['onez_sitename'];
  include_once(dirname(__FILE__).'/union.join.php');
  exit();
}

$str=$_G['onez_str'];
$id=(int)$_G['onez_id'];
$page=(int)$_G['onez_page'];
$data=@file_get_contents('http://2cscs.onez.cn/onez.php?action=union&page='.$page.'&str='.$str);
$data=tsound_flashToDz($data);
echo $data;
?>