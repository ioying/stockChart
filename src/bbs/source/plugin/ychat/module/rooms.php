<?php
   if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	$_G['disabledwidthauto'] = 1;
	$num = !empty($_G['cookie']['onlineusernum']) ? intval($_G['cookie']['onlineusernum']) : C::app()->session->count();
	$bcatearray=C::t("#ychat#ychat_bcategory")->fetch_all();
	$bcategoryarr=array();
	require_once libfile('function/home');
	foreach($bcatearray as $bvalue)
	{
		$catearray=C::t("#ychat#ychat_category")->fetch_all_by_bcategoryid($bvalue['bCategoryID']);
		$categoryarr=array();
		$countrolenum=0;
		foreach($catearray as $value)
		{
			
			$rolenum=C::t("#ychat#ychat_rooms")->fetch_by_crole_count( $value['categoryID']);
			$rolenum=0+$rolenum;
			$arr=array('categoryID'=>$value['categoryID'],'categoryName'=>$value['categoryName'],'cnum'=>$rolenum);
			array_push($categoryarr,$arr);
			$countrolenum=$countrolenum+$rolenum;
		}
		$barr=array('bCategoryID'=>$bvalue['bCategoryID'],'bCategoryName'=>$bvalue['bCategoryName'],'categoryArr'=>$categoryarr,'countrolenum'=>$countrolenum);
		array_push($bcategoryarr,$barr);
	}
	
	$userinfo = getspace($_G['uid'], 'uid');
	require_once libfile('function/spacecp');
	space_merge($userinfo, 'profile');
	space_merge($userinfo, 'count');

	$nickname=$_G["username"];
	$avatarimg=UC_API."/avatar.php?uid=".$_G["uid"]."&size=small";
	$croomsarray=C::t("#ychat#ychat_rooms")->fetch_all_by_category($_GET["cid"]);
	$room2arr=array();
	foreach($croomsarray as $room2Value)
	{
		$barr=array('roomID'=>$room2Value['roomID'],'roomName'=>$room2Value['roomName'],'cnum'=>$room2Value['cnum'],'rolenum'=>$room2Value['rolenum'],'image'=>$room2Value['image']);
		array_push($room2arr,$barr);
	}

	
	

	//manyou app
	$titlelength	=  40;
	$startrow       = '0';
	$items          =  15;
	$appData=C::t("#ychat#common_myapp")->fetch_all($startrow,$items);
	$appflag=false;
	foreach($appData as $data) {
		$appflag=true;
		$applist[] = array(
			'id' => $data['appid'],
			'idtype' => 'appid',
			'title' => cutstr(str_replace('\\\'', '&#39;', $data['appname']), $titlelength, ''),
			'url' => 'userapp.php?id='.$data['appid'],
			'icon' => 'http://appicon.manyou.com/logos/'.$data['appid'],
			'icon_small' => 'http://appicon.manyou.com/icons/'.$data['appid'],
			'icon_abouts' => 'http://appicon.manyou.com/abouts/'.$data['appid'],
		);
	}
	include template('ychat:rooms');
?>
