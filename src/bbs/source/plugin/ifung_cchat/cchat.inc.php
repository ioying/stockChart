<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$plugin = $_G['cache']['plugin']['ifung_cchat'];


if (!$_G['uid'] && !$plugin['ifung_guest'] != 0) 
showmessage('to_login', 'member.php?mod=logging&action=login', array(), array('showmsg' => true, 'login' => 1)); 


$_G['plugin'][ifung_switch]= $plugin['ifung_switch'];

if(!$plugin['ifung_switch'] && $_G['adminid'] !=0){
	showmessage($plugin['ifung_closetext']);
	}


$cchat_path = './source/plugin/ifung_cchat/';
$cchat_username = $_G['username'];

include template('ifung_cchat:cchat')
?>