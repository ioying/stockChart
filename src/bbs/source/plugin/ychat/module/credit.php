<?php
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	if($_GET["formhash"]!=FORMHASH)
	{
		exit('Access Denied');
	}
	$giftid=$_GET["giftid"];
	$giftnum=$_GET["giftnum"];
	$uid=$_GET["uid"];
	$credit=$_GET["credit"];
	$toUserID=$_GET["toUserID"];
	if($credit<=0)
	{
	  echo '参数错误';
	  exit;
	}
	header("Content-Type: application/xml");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	require_once 'ychat_config.php';
	if($_G['uid']==$uid&&$_G['uid']!=0)
	{
		$creditValue=C::t('common_member_count')->fetch($uid);
		if($creditValue[$creditType]<$credit*$giftnum)//积分不够
		{
			echo "\t<userInformation  result=\"1\">\n";
		}
		else//扣除积分
		{
			updatemembercount($uid,array($creditType => 0-$credit*$giftnum));//扣除金钱
			if($toUserID!=-1)
			{
				updatemembercount($toUserID,array($creditType => $credit*$giftnum*$creditPerc));//增加金钱
			}
			if($giftid!=0)
			{
				$data = array(
					'gid' => $giftid,
					'sid' => $uid,
					'rid' => $toUserID,
					'dateline' => time(),
					'sellprice' => $credit,
					'num' => $giftnum,
				);
				C::t('#ychat#ychat_gift_list')->insert($data,0,1);
			}
			$creditValue=C::t('common_member_count')->fetch($uid);
			echo "\t<userInformation result=\"2\" jifen=\"".$creditValue[$creditType]."\">\n";//扣除积分成功
		}
	}
	else
	{
		echo "\t<userInformation result=\"0\">\n";//尚未登录
	}
	echo "\t</userInformation>\n";
?>
