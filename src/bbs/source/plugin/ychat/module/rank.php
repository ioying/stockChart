<?php
   if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	require_once './config/config_ucenter.php';
	require_once libfile('function/home');
	$_G['disabledwidthauto'] = 1;
	$navtitle=lang('plugin/ychat', 'ychat_paihanglang').'-'.$ychat_plugin['title'];
	$shijian=5000;
	//shang zhou
	if(!$_G['cache']['ychat_rank_sqstar']) {
		loadcache('ychat_rank_sqstar');
	}
	if(!$_G['cache']['ychat_rank_sqstar']||(TIMESTAMP-$_G['cache']['ychat_rank_sqstar']['dateline'])>$shijian)
	{
		//shang zhou
		$goodsArray=C::t("#ychat#ychat_gift_goods")->fetch_all();
		$stime14=(time()-14*24*60*60);
		$stime7=(time()-7*24*60*60);
		foreach ($goodsArray as $value) {
			$giftrow=C::t("#ychat#ychat_gift_list")->fetch_by_gift_star($value["id"],$stime14,$stime7);
			if($giftrow)
			{
				$space = getspace($giftrow['rid'], 'uid');
				$szstar[]=array(
					'giftname'=>$value['name'],
					'pic'=>$value["pic"],
					'avatar'=>UC_API.'/avatar.php?uid='.$value['rid'].'&size=small',
					'username'=>$space['username'],
					'cc'=>$giftrow['cc'],
					);
			}
		}
		$data = array('content' => $szstar,'dateline'=>TIMESTAMP);
		save_syscache('ychat_rank_sqstar', $data);
	}
	else
	{
		$szstar=$_G['cache']['ychat_rank_sqstar']['content'];
	}

	$shijian=5500;
	if(!$_G['cache']['ychat_rank_bqstar']) {
		loadcache('ychat_rank_bqstar');
	}
	if(!$_G['cache']['ychat_rank_bqstar']||(TIMESTAMP-$_G['cache']['ychat_rank_bqstar']['dateline'])>$shijian)
	{
		//ben zhou
		$goodsArray=C::t("#ychat#ychat_gift_goods")->fetch_all();
		$stime=time();
		$stime7=(time()-7*24*60*60);
		foreach ($goodsArray as $value) {
			$giftrow=C::t("#ychat#ychat_gift_list")->fetch_by_gift_star($value["id"],$stime7,$stime);
			if($giftrow)
			{
				$space = getspace($giftrow['rid'], 'uid');
				$bzstar[]=array(
					'giftname'=>$value['name'],
					'pic'=>$value["pic"],
					'avatar'=>UC_API.'/avatar.php?uid='.$giftrow['rid'].'&size=small',
					'username'=>$space['username'],
					'cc'=>$giftrow['cc'],
					);
			}
		}
		$data = array('content' => $bzstar,'dateline'=>TIMESTAMP);
		save_syscache('ychat_rank_bqstar', $data);
	}
	else
	{
		$bzstar=$_G['cache']['ychat_rank_bqstar']['content'];
	}

	$shijian=5500;
	if(!$_G['cache']['ychat_rank_rqfenyun']) {
		loadcache('ychat_rank_rqfenyun');
	}
	if(!$_G['cache']['ychat_rank_rqfenyun']||(TIMESTAMP-$_G['cache']['ychat_rank_rqfenyun']['dateline'])>$shijian)
	{
		$memberarray=C::t("common_member_count")->range_by_field(0,10,'views','desc');
		$i=0;
		foreach ($memberarray as $value)
		{
			$i++;
			$space = getspace($value['uid'], 'uid');
			$rqarr[]=array(
				'num'=>$i,
				'uid'=>$value['uid'],
				'username'=>$space['username'],
				'views'=>$value['views'],
			);
		}
		$data = array('content' => $rqarr,'dateline'=>TIMESTAMP);
		save_syscache('ychat_rank_rqfenyun', $data);
	}
	else
	{
		$rqarr=$_G['cache']['ychat_rank_rqfenyun']['content'];
	}
	
	//huo zhen feng yun ban
	$shijian=5600;
	if(!$_G['cache']['ychat_rank_hzfenyun']) {
		loadcache('ychat_rank_hzfenyun');
	}
	if(!$_G['cache']['ychat_rank_hzfenyun']||(TIMESTAMP-$_G['cache']['ychat_rank_hzfenyun']['dateline'])>$shijian)
	{
		$gstararray=C::t("#ychat#ychat_gift_list")->fetch_by_rank(0,10);
		$i=0;
		foreach ($gstararray as $value )
		{
			$i++;
			$space = getspace($value['rid'], 'uid');
			$hzarr[]=array(
				'num'=>$i,
				'uid'=>$value['uid'],
				'username'=>$space['username'],
				'znum'=>$value['gnum'],
				);
		}
		$data = array('content' => $hzarr,'dateline'=>TIMESTAMP);
		save_syscache('ychat_rank_hzfenyun', $data);
	}
	else
	{
		$hzarr=$_G['cache']['ychat_rank_hzfenyun']['content'];
	}


	//xiao fei feng yun ban 
	$shijian=5700;
	if(!$_G['cache']['ychat_rank_xffenyun']) {
		loadcache('ychat_rank_xffenyun');
	}
	if(!$_G['cache']['ychat_rank_xffenyun']||(TIMESTAMP-$_G['cache']['ychat_rank_xffenyun']['dateline'])>$shijian)
	{
		$gstararray=C::t("#ychat#ychat_gift_list")->fetch_by_rank(0,10,'sid','sellprice*num');
		$i=0;
		foreach ($gstararray as $value )
		{
			$i++;
			$space = getspace($value['sid'], 'uid');
			$xfarr[]=array(
				'num'=>$i,
				'uid'=>$value['uid'],
				'username'=>$space['username'],
				'price'=>$value['gnum'],
				);
		}
		$data = array('content' => $xfarr,'dateline'=>TIMESTAMP);
		save_syscache('ychat_rank_xffenyun', $data);
	}
	else
	{
		$xfarr=$_G['cache']['ychat_rank_xffenyun']['content'];
	}
	include template('ychat:rank');
?>
