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
	
	$roomResult=C::t("#ychat#ychat_rooms")->fetch_all_by_order_type("cnum",0,10);
	$roomarr=array();
	$i=0;
	foreach($roomResult as $roomValue)
	{
		$i++;
		$barr=array('roomID'=>$roomValue['roomID'],'roomName'=>$roomValue['roomName'],'cnum'=>$roomValue['cnum'],'rolenum'=>$roomValue['rolenum'],'image'=>$roomValue['image'],'order'=>$i);
		array_push($roomarr,$barr);
	}
	$room2Result=C::t("#ychat#ychat_rooms")->fetch_all_by_order_type("top",0,28);
	$room2arr=array();
	foreach($room2Result as $room2Value)
	{
		$barr=array('roomID'=>$room2Value['roomID'],'roomName'=>$room2Value['roomName'],'cnum'=>$room2Value['cnum'],'rolenum'=>$room2Value['rolenum'],'image'=>$room2Value['image']);
		array_push($room2arr,$barr);
	}
		$type           = array('0');
		$titlelength	= 18;
		$summarylength	= 80;
		$startrow       = 0;
		$items          = 10;

		$bannedids = array();

		$time = TIMESTAMP;

		$list = array();
		foreach(C::t('forum_announcement')->fetch_all_by_time($time, $type, $bannedids, $startrow, $items) as $data) {
			$list[] = array(
				'id' => $data['id'],
				'idtype' => 'announcementid',
				'title' => cutstr(str_replace('\\\'', '&#39;', strip_tags($data['subject'])), $titlelength, ''),
				'url' => $data['type']=='1' ? $data['message'] : 'forum.php?mod=announcement&id='.$data['id'],
				'pic' => '',
				'picflag' => '',
				'summary' => cutstr(str_replace('\\\'', '&#39;', $data['message']), $summarylength, ''),
				'starttime' =>date('Y-m-d', $data['starttime']),
				'endtime' => $data['endtime'],
			);
		}
	
	//gift star
	$shijian=5000;
	//找出本期礼物之星
	if(!$_G['cache']['ychat_rank_star']) {
		loadcache('ychat_rank_star');
	}
	if(!$_G['cache']['ychat_rank_star']||(TIMESTAMP-$_G['cache']['ychat_rank_star']['dateline'])>$shijian)
	{
		$goodsArray=C::t("#ychat#ychat_gift_goods")->fetch_all();
		$day7=(time()-14*24*60*60);
		$ctime=time();
		$shtml='<ul  id="benqi">'; 
		foreach ($goodsArray as $value) {
			$giftrow=C::t("#ychat#ychat_gift_list")->fetch_by_gift_star($value["id"],$day7,$ctime);
			if($giftrow)
			{
				$space = getspace($giftrow['rid'], 'uid');
				$shtml.='<li><img src="./source/plugin/ychat/images/'.$value['pic'].'" /><span><a href="./?'.$giftrow['rid'].'" target="_blank">'.$space['username'].'</a></span><em>'.$giftrow['cc'].' </em></li>';
			}
		}
		$shtml.='</ul>';
		$data = array('content' => $shtml,'dateline'=>TIMESTAMP);
		save_syscache('ychat_rank_star', $data);
	}
	else
	{
		$shtml=$_G['cache']['ychat_rank_star']['content'];
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

	include template('ychat:index');
?>
