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
function showsearchform2($operation = '') {
	$formurl = "plugins&operation=config&identifier=ychat&pmod=ychat_admin_rooms";
	showformheader($formurl);
	showtableheader();
	showsetting(lang('plugin/ychat','ychat_search_uid'), 'roomID', '', 'text');
	showsubmit('ychatsubmit','submit');
	showtablefooter();
	showformfooter();
}
function roomCategory($optname,$cid)
{
	$returnvalue='<select name="'.$optname.'">';
	$bcategoryarr=C::t("#ychat#ychat_bcategory")->fetch_all();
	foreach($bcategoryarr as $value)
	{
		$subcategoriesArr=C::t("#ychat#ychat_category")->fetch_all_by_bcategoryid($value["bCategoryID"]);
		$returnvalue.='<optgroup label="'.$value["bCategoryName"].'">';
		foreach($subcategoriesArr as $subcate)
		{
			if($subcate["categoryID"]==$cid)
			{
				$returnvalue.='<option selected="selected" value="'.$subcate["categoryID"].'">'.$subcate["categoryName"].'</option>';
			}
			else
			{
				$returnvalue.='<option value="'.$subcate["categoryID"].'">'.$subcate["categoryName"].'</option>';
			}
			
		}
		$returnvalue.='</optgroup>';
	}
	$returnvalue.='</select>';
	return $returnvalue;
}
function getpage($pcount,$pcpage,$url)
{
	$startpage=$pcpage-5;
	if($startpage<1)
	{
		$startpage=1;
	}
	$html='<div class="cuspages right"><div class="pg">';
	for($i=$startpage;$i<=$pcount&&$i<$startpage+10;$i++)
	{
		if($i==$pcpage)
		{
			$html.='<strong>'.$i.'</strong>';
		}
		else
		{
			$html.='<a href="'.$url.'&page='.$i.'">'.$i.'</a>';
		}
	}
	$html.='<a href="'.$url.'&page='.($pcpage+1).'">&rsaquo;&rsaquo;</a>';
	$html.='<kbd><input type="text" name="custompage" size="3" onkeydown="if(event.keyCode==13) {window.location=\''.$url.'&page=\'+this.value; doane(event);}" /></kbd></div></div>';
	return $html;
}
cpheader();
$ymod=$_GET["ymod"];
$ymod = !$ymod ? 'list' : $ymod;
if($ymod=="list")
{
	$c1="current";
}
else if($ymod=="add")
{
	$c2="current";
}
else if($ymod=="search")
{
	$c3="current";
}
echo '<ul class="tab1"><li  class="'.$c1.'"><a href="admin.php?action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_rooms&ymod=list"><span>'.lang("plugin/ychat","ychat_liulan").'</span></a></li><li class="'.$c2.'"><a href="admin.php?action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_rooms&ymod=add"><span>'.lang("plugin/ychat","ychat_add").'</span></a></li>
<li  class="'.$c3.'"><a href="admin.php?action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_rooms&ymod=search"><span>'.lang("plugin/ychat","ychat_search").'</span></a></li></ul>';
if($ymod=="list")
{
	showtableheader();
	if(isset($_GET['page'])){
		$page = intval($_GET['page']);//dang qian ye
    }
    else 
	{
		$page=1;//dang qian ye
    }
	$pagesize=20;//mei ye shu ju liang
	if($_POST["roomID"]=="")
	{
		
		$roomsarr=C::t("#ychat#ychat_rooms")->fetch_all(1,($page-1)*$pagesize,$pagesize);
	}
	else
	{
		$roomsarr=array(C::t("#ychat#ychat_rooms")->fetch_all_by_roomID($_POST["roomID"]));
	}
	echo '<tr class="header"><td colspan="8"><div>'.lang('plugin/ychat', 'ychatduo_room_id').'</div></td><td colspan="8"><div>'.lang('plugin/ychat', 'ychatduo_room_name').'</div></td>
	<td colspan="8"><div>'.lang('plugin/ychat',"ychatduo_room_categoryName").'</div></td>
	<td colspan="8"><div>'.lang('plugin/ychat',"ychatduo_room_image").'</div></td><td colspan="8"><div>'.lang('plugin/ychat',"ychatduo_room_cnum").'</div></td><td colspan="8"><div>'.lang('plugin/ychat',"ychatduo_room_rolenum").'</div></td><td colspan="8"><div>'.lang('plugin/ychat',"ychatduo_room_descript").'</div></td><td colspan="8"><div>'.lang('plugin/ychat',"ychat_caozuo").'</div></td></tr>';
	foreach($roomsarr as $config_value)
	{
		$categoryvalue=C::t("#ychat#ychat_category")->fetch_by_categoryid($config_value['categoryID']);
		echo '<tr class="hover"><td colspan="8"><div>'.$config_value["roomID"].'</div></td><td colspan="8"><div>'.$config_value["roomName"].'</div></td><td colspan="8"><div>'.$categoryvalue["categoryName"].'</div></td><td colspan="8"><div><img src="'.$config_value["image"].'"  width="50" height="50" onerror="this.src=\'source/plugin/ychat/images/nophoto.jpg\'" /></div></td><td colspan="8"><div>'.$config_value["cnum"].'</div></td><td colspan="8"><div>'.$config_value["rolenum"].'</div></td><td colspan="8"><div>'.$config_value["roomDescript"].'</div></td><td colspan="8"><div><a href="admin.php?action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_rooms&ymod=edit&roomid='.$config_value["roomID"].'" >'.lang('plugin/ychat',"ychat_basic_configedit").'</a>&nbsp;&nbsp;<a href="admin.php?action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_rooms&ymod=delete&roomid='.$config_value["roomID"].'" >'.lang('plugin/ychat',"ychat_delete").'</a>&nbsp;&nbsp;';
		if($config_value['top']==0)
		{
			echo'<a href="admin.php?action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_rooms&ymod=tuijian&roomid='.$config_value["roomID"].'" >'.lang('plugin/ychat',"ychat_tuijian").'</a>';
		}
		else
		{
			echo'<a href="admin.php?action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_rooms&ymod=quxiaotuijian&roomid='.$config_value["roomID"].'" >'.lang('plugin/ychat',"ychat_quxiaotuijian").'</a>';
		}
		echo '</div></td></tr>';
	}
			
	showtablefooter();
	if($_POST["roomID"]=="")
	{
		$giftcount=C::t("#ychat#ychat_rooms")->fetch_count();
	}
	else
	{
		$giftcount=1;
	}
	$pagecount=ceil($giftcount/$pagesize);
	echo getpage($pagecount,$page,'admin.php?action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_rooms');
}
else if($ymod=="delete")
{
	$roomid=$_GET["roomid"];
	C::t("#ychat#ychat_rooms")->delete($roomid);
	cpmsg(lang('plugin/ychat','ychatduo_rooms_del_success'),'action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_rooms','succeed');
}
else if($ymod=="tuijian")
{
	$roomid=$_GET["roomid"];
	C::t("#ychat#ychat_rooms")->update($roomid,array('top'=>1));
	cpmsg(lang('plugin/ychat','ychat_caozuo_success'),'action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_rooms','succeed');
}
else if($ymod=="quxiaotuijian")
{
	$roomid=$_GET["roomid"];
	C::t("#ychat#ychat_rooms")->update($roomid,array('top'=>0));
	cpmsg(lang('plugin/ychat','ychat_caozuo_success'),'action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_rooms','succeed');
}
else if($ymod=="edit")
{
		if(!submitcheck('ychatsubmit'))
		{
			showformheader('plugins&operation=config&identifier=ychat&pmod=ychat_admin_rooms&ymod=edit&roomid='.$_GET["roomid"],'enctype');
			showtableheader();
			if(empty($_GET["roomid"]))
			{
				cpmsg(lang('plugin/ychat','ychat_rooms_error'),'','error');
			}
			else
			{
				$value=C::t("#ychat#ychat_rooms")->fetch_all_by_roomID($_GET["roomid"]);
				if($value)
				{
					showsetting(lang('plugin/ychat','ychatduo_room_id'), 'roID', $value["roomID"], 'text');
					showsetting(lang('plugin/ychat','ychatduo_room_name'), 'roomName', $value["roomName"], 'text');
					//showsetting(lang('plugin/ychat','ychatduo_room_uid'), 'uid',  $value["uid"], 'text');	
					//showsetting(lang('plugin/ychat','ychatduo_room_category'), array('categoryID', $categoryarr), $value["categoryID"], 'select');
					echo '<tr onmouseover="setfaq(this, \'faqba4e\')"><td colspan="2" class="td27" s="1">'.lang('plugin/ychat',"ychatduo_room_category").':</td></tr>
						<tr><td colspan="2"  s="1">'.roomCategory('categoryID',$value["categoryID"]).'</td></tr>';
					showsetting(lang('plugin/ychat','ychat_rooms_countnum'), 'rolenum',  $value["rolenum"], 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_descript'), 'roomDescript',  $value["roomDescript"], 'textarea');
					
					showsetting(lang('plugin/ychat','ychatduo_room_micoTime'), 'micoTime',  $value["micoTime"], 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_jifenPaodian'), 'jifenPaodian',  $value["jifenPaodian"], 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_paodianTime'), 'paodianTime',  $value["paodianTime"], 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_playerDisplay'), 'isDisplayGift',  $value["isDisplayGift"], 'radio');	
					if($value["micMode"]==2)
					{
						$selected1='checked';
						$selected2='';
					}
					else
					{
						$selected2='checked';
						$selected1='';
					}
					echo '<tr onmouseover="setfaq(this, \'faqba4e\')"><td colspan="2" class="td27" s="1">'.lang('plugin/ychat',"ychatduo_room_micMode").':</td></tr>
						<tr><td colspan="2"  s="1"><input type="radio" name="micMode" id="micMode" value="2" '.$selected1.' />
						  <label for="micMode">'.lang('plugin/ychat',"ychatduo_room_zhuximode").'</label>&nbsp;
						  <input type="radio" name="micMode" id="micMode2" value="1" '.$selected2.'/>
						  <label for="micMode2">'.lang('plugin/ychat',"ychatduo_room_ziyoumode").'</label></td></tr>';	
					if($value["isVideoSwitch"]==1)
					{
						$selected1='checked';
						$selected2='';
					}
					else
					{
						$selected2='checked';
						$selected1='';
					}
					echo '<tr onmouseover="setfaq(this, \'faqba4e\')"><td colspan="2" class="td27" s="1">'.lang('plugin/ychat',"ychatduo_room_isVideoSwitch").':</td></tr>
						<tr><td colspan="2"  s="1"><input type="radio" name="isVideoSwitch" id="isVideoSwitch" value="1" '.$selected1.'/>
						  <label for="isVideoSwitch">'.lang('plugin/ychat',"ychatduo_room_videoroom").'</label>&nbsp;
						  <input type="radio" name="isVideoSwitch" id="isVideoSwitch2" value="0" '.$selected2.'/>
						  <label for="isVideoSwitch2">'.lang('plugin/ychat',"ychatduo_room_textroom").'</label></td></tr>';	
				   if($value["videonumber"]==1)
					{
						$selected1='checked';
						$selected2='';
					}
					else
					{
						$selected2='checked';
						$selected1='';
					}
					echo '<tr onmouseover="setfaq(this, \'faqba4e\')"><td colspan="2" class="td27" s="1">'.lang('plugin/ychat',"ychatduo_room_videonumber").':</td></tr>
						<tr><td colspan="2"  s="1"><input type="radio" name="videonumber" id="videonumber" value="1" '.$selected1.'/>
						  <label for="videonumber">'.lang('plugin/ychat',"ychatduo_room_danshipin").'</label>&nbsp;
						  <input type="radio" name="videonumber" id="videonumber2" value="3" '.$selected2.'/>
						  <label for="videonumber2">'.lang('plugin/ychat',"ychatduo_room_3shipin").'</label></td></tr>';	

					showsetting(lang('plugin/ychat','ychatduo_room_image'), 'image',  $value["image"], 'filetext');	
					showsetting(lang('plugin/ychat','ychatduo_room_mainChatBg'), 'mainChatBg',  $value["mainChatBg"], 'filetext');	
					showsetting(lang('plugin/ychat','ychatduo_room_myChatBg'), 'myChatBg',  $value["myChatBg"], 'filetext');	
			
					if($value["XianzhiJoinRoom"]==1)
					{
						$checked="checked";
					}
					else
					{
						$checked="";
					}
					echo '<tr><td colspan="2" class="td27" s="1"><input type="checkbox" name="XianzhiJoinRoom" id="XianzhiJoinRoom"  value="1" '.$checked.' /><label for="XianzhiJoinRoom">'.lang('plugin/ychat',"ychatduo_room_XianzhiJoinRoom").'</label></td></tr>';
					showsetting(lang('plugin/ychat','ychatduo_room_YunxuJoinGroup'), 'YunxuJoinGroup',  $value["YunxuJoinGroup"], 'text');
					if($value["XianzhiChat"]==1)
					{
						$checked="checked";
					}
					else
					{
						$checked="";
					}
					echo '<tr><td colspan="2" class="td27" s="1"><input type="checkbox" name="XianzhiChat" id="XianzhiChat"  value="1" '.$checked.' /><label for="XianzhiChat">'.lang('plugin/ychat',"ychatduo_room_XianzhiChat").'</label></td></tr>';
					showsetting(lang('plugin/ychat','ychatduo_room_YunxuSendMessage'), 'YunxuSendMessage',  $value["YunxuSendMessage"], 'text');	
					if($value["XianzhiSendMagic"]==1)
					{
						$checked="checked";
					}
					else
					{
						$checked="";
					}
					echo '<tr><td colspan="2" class="td27" s="1"><input type="checkbox" name="XianzhiSendMagic" id="XianzhiSendMagic"  value="1" '.$checked.' /><label for="XianzhiSendMagic">'.lang('plugin/ychat',"ychatduo_room_XianzhiSendMagic").'</label></td></tr>';
					showsetting(lang('plugin/ychat','ychatduo_room_YunxuSendMagicGroup'), 'YunxuSendMagicGroup',  $value["YunxuSendMagicGroup"], 'text');	
					if($value["MagicScoreFlag"]==1)
					{
						$checked="checked";
					}
					else
					{
						$checked="";
					}
					echo '<tr><td colspan="2" class="td27" s="1"><input type="checkbox" name="MagicScoreFlag" id="MagicScoreFlag"  value="1" '.$checked.' /><label for="MagicScoreFlag">'.lang('plugin/ychat',"ychatduo_room_MagicScoreFlag").'</label></td></tr>';
					
					showsetting(lang('plugin/ychat','ychatduo_room_MagicScoreNumber'), 'MagicScoreNumber',  $value["MagicScoreNumber"], 'text');	
					if($value["isPaiMaiFlag"]==1)
					{
						$checked="checked";
					}
					else
					{
						$checked="";
					}
					echo '<tr><td colspan="2" class="td27" s="1"><input type="checkbox" name="isPaiMaiFlag" id="isPaiMaiFlag"  value="1" '.$checked.'  /><label for="isPaiMaiFlag">'.lang('plugin/ychat',"ychatduo_room_isPaiMaiFlag").'</label></td></tr>';
					showsetting(lang('plugin/ychat','ychatduo_room_yuxuPaimaiGroup'), 'yuxuPaimaiGroup',  $value["yuxuPaimaiGroup"], 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_yunxuFatuGroup'), 'yunxuFatuGroup',  $value["yunxuFatuGroup"], 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_yunxuDuiliaoGroup'), 'yunxuDuiliaoGroup',  $value["yunxuDuiliaoGroup"], 'text');	

					showsetting(lang('plugin/ychat','ychatduo_room_CompetenceData'), 'CompetenceData',  $value["CompetenceData"], 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_AdminCompetenceUID'), 'AdminCompetenceUID',  $value["AdminCompetenceUID"], 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_ptAdminCompetenceUID'), 'ptAdminCompetenceUID',  $value["ptAdminCompetenceUID"], 'text');	

					showsetting(lang('plugin/ychat','ychatduo_room_adv'), 'adv',  $value["adv"], 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_videoadvClick0'), 'videoadvClick0',  $value["videoadvClick0"], 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_videoadv1'), 'videoadv1',  $value["videoadv1"], 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_videoadvClick1'), 'videoadvClick1',  $value["videoadvClick1"], 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_videoadv2'), 'videoadv2',  $value["videoadv2"], 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_videoadvClick2'), 'videoadvClick2',  $value["videoadvClick2"], 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_videoadv3'), 'videoadv3',  $value["videoadv3"], 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_videoadvClick3'), 'videoadvClick3',  $value["videoadvClick3"], 'text');	
					
					showsubmit('ychatsubmit', 'submit');
				}
				showtablefooter();
				showformfooter();
			}
		}
		else
		{
			$roomID=$_GET["roomid"];
			$roID=$_POST["roID"];
			$roomName = $_POST["roomName"];
		//	$uid=$_POST["uid"];
			$roomDescript = $_POST["roomDescript"];
			$rolenum = $_POST["rolenum"];
			$password = $_POST["password"];
			$adv = $_POST["adv"];
			$CompetenceData = $_POST["CompetenceData"];
			$YunxuJoinGroup = $_POST["YunxuJoinGroup"];
			$XianzhiJoinRoom =$_POST["XianzhiJoinRoom"];
			$YunxuSendMessage = $_POST["YunxuSendMessage"];
			$XianzhiChat = $_POST["XianzhiChat"];
			$YunxuSendMagicGroup = $_POST["YunxuSendMagicGroup"];
			$XianzhiSendMagic = $_POST["XianzhiSendMagic"];
			$MagicScoreNumber = $_POST["MagicScoreNumber"];
			$MagicScoreFlag = $_POST["MagicScoreFlag"];
			$micoTime=$_POST["micoTime"];

			$isPaiMaiFlag=$_POST["isPaiMaiFlag"];
			$yuxuPaimaiGroup=$_POST["yuxuPaimaiGroup"];
			$AdminCompetenceUID=$_POST["AdminCompetenceUID"];
			$jifenPaodian=$_POST["jifenPaodian"];
			$paodianTime=$_POST["paodianTime"];

			$playerDisplay=$_POST["playerDisplay"];
			$isDisplayGift=$_POST["isDisplayGift"];
			$micMode=$_POST["micMode"];
			$yunxuJietuGroup=$_POST["yunxuJietuGroup"];
			$yunxuFatuGroup=$_POST["yunxuFatuGroup"];
			$isVideoSwitch=$_POST["isVideoSwitch"];
			$videonumber=$_POST["videonumber"];
			$yunxuDuiliaoGroup=$_POST["yunxuDuiliaoGroup"];
			$ptAdminCompetenceUID=$_POST["ptAdminCompetenceUID"];
			$videoadv1=$_POST["videoadv1"];
			$videoadv2=$_POST["videoadv2"];
			$videoadv3=$_POST["videoadv3"];
			$videoadvClick1=$_POST["videoadvClick1"];
			$videoadvClick2=$_POST["videoadvClick2"];
			$videoadvClick3=$_POST["videoadvClick3"];
			$videoadvClick0=$_POST["videoadvClick0"];			
			$categoryID=$_POST["categoryID"];
			$timeline=time();
			if($_FILES['image']["type"])
			{
				$ext=strrchr($_FILES['image']["name"],".");
				$imagepath="source/plugin/ychat/images/slt".$timeline.$ext;
				uploadfile($_FILES['image'],$imagepath);
			}
			else
			{
				$imagepath=$_POST["image"];
			}
			
			if($_FILES['mainChatBg']["type"])
			{
				$ext=strrchr($_FILES['mainChatBg']["name"],".");
				$mainChatBgpath="source/plugin/ychat/images/cbg".$timeline.$ext;
				uploadfile($_FILES['mainChatBg'],$mainChatBgpath);
			}
			else
			{
				$mainChatBgpath=$_POST["mainChatBg"];
			}
			if($_FILES['myChatBg']["type"])
			{
				$ext=strrchr($_FILES['myChatBg']["name"],".");
				$myChatBgpath="source/plugin/ychat/images/mbg".$timeline.$ext;
				uploadfile($_FILES['myChatBg'],$myChatBgpath);
			}
			else
			{
				$myChatBgpath=$_POST["myChatBg"];
			}
			if($roID!=$roomID)
			{
				$value=C::t("#ychat#ychat_rooms")->fetch_all_by_roomID($roID);
				if($value)
				{
						cpmsg(lang('plugin/ychat','ychatduo_room_iderror'),'',"error");
				}
			}
			$data=array(
				'roomID'=>$roID,
				'roomName'=>$roomName,
				'roomDescript'=>$roomDescript,
				'image'=>$imagepath,
				'rolenum'=>$rolenum,
				'password'=>$password,
				'adv'=>$adv,
				'CompetenceData'=>$CompetenceData,
				'YunxuJoinGroup'=>$YunxuJoinGroup,
				'XianzhiJoinRoom'=>$XianzhiJoinRoom,
				'YunxuSendMessage'=>$YunxuSendMessage,
				'XianzhiChat'=>$XianzhiChat,
				'YunxuSendMagicGroup'=>$YunxuSendMagicGroup,
				'XianzhiSendMagic'=>$XianzhiSendMagic,
				'MagicScoreNumber'=>$MagicScoreNumber,
				'MagicScoreFlag'=>$MagicScoreFlag,
				'micoTime'=>$micoTime,
				'isPaiMaiFlag'=>$isPaiMaiFlag,
				'yuxuPaimaiGroup'=>$yuxuPaimaiGroup,
				'AdminCompetenceUID'=>$AdminCompetenceUID,
				'jifenPaodian'=>$jifenPaodian,
				'paodianTime'=>$paodianTime,
				'mainChatBg'=>$mainChatBgpath,
				'myChatBg'=>$myChatBgpath,
				'playerDisplay'=>$playerDisplay,
				'isDisplayGift'=>$isDisplayGift,
				'micMode'=>$micMode,
				'yunxuJietuGroup'=>$yunxuJietuGroup,
				'yunxuFatuGroup'=>$yunxuFatuGroup,
				'isVideoSwitch'=>$isVideoSwitch,
				'videonumber'=>$videonumber,
				'yunxuDuiliaoGroup'=>$yunxuDuiliaoGroup,
				'ptAdminCompetenceUID'=>$ptAdminCompetenceUID,
				'videoadv1'=>$videoadv1,
				'videoadv2'=>$videoadv2,
				'videoadv3'=>$videoadv3,
				'videoadvClick1'=>$videoadvClick1,
				'videoadvClick2'=>$videoadvClick2,
				'videoadvClick3'=>$videoadvClick3,
				'videoadvClick0'=>$videoadvClick0,
				'categoryID'=>$categoryID,
				);
			C::t("#ychat#ychat_rooms")->update($roomID,$data);
			
			cpmsg(lang('plugin/ychat','ychatduo_room_edit_success'),'action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_rooms','succeed');
		}
}
else if($ymod=="add")
{
	if(!submitcheck('ychatsubmit'))
		{
			showformheader('plugins&operation=config&identifier=ychat&pmod=ychat_admin_rooms&ymod=add','enctype');
			showtableheader();
			
			showsetting(lang('plugin/ychat','ychatduo_room_name'), 'roomName', '', 'text');
		//	showsetting(lang('plugin/ychat','ychatduo_room_uid'), 'uid',  '', 'text');	
			//showsetting(lang('plugin/ychat','ychatduo_room_category'), array('categoryID', $categoryarr), 1, 'select');
			echo '<tr onmouseover="setfaq(this, \'faqba4e\')"><td colspan="2" class="td27" s="1">'.lang('plugin/ychat',"ychatduo_room_category").':</td></tr>
						<tr><td colspan="2"  s="1">'.roomCategory('categoryID',0).'</td></tr>';
			showsetting(lang('plugin/ychat','ychat_rooms_countnum'), 'rolenum',  '200', 'text');	
			showsetting(lang('plugin/ychat','ychatduo_room_descript'), 'roomDescript', '', 'textarea');
			showsetting(lang('plugin/ychat','ychatduo_room_micoTime'), 'micoTime',  '5', 'text');	
			showsetting(lang('plugin/ychat','ychatduo_room_jifenPaodian'), 'jifenPaodian',  '10', 'text');	
			showsetting(lang('plugin/ychat','ychatduo_room_paodianTime'), 'paodianTime',  '600000', 'text');	
			showsetting(lang('plugin/ychat','ychatduo_room_isDisplayGift'), 'isDisplayGift',  '1', 'radio');	
			echo '<tr onmouseover="setfaq(this, \'faqba4e\')"><td colspan="2" class="td27" s="1">'.lang('plugin/ychat',"ychatduo_room_micMode").':</td></tr>
				<tr><td colspan="2"  s="1"><input type="radio" name="micMode" id="micMode" value="2" />
				 <label for="micMode">'.lang('plugin/ychat',"ychatduo_room_zhuximode").'</label>&nbsp;
				 <input type="radio" name="micMode" id="micMode2" value="1" checked />
				 <label for="micMode2">'.lang('plugin/ychat',"ychatduo_room_ziyoumode").'</label></td></tr>';	
			echo '<tr onmouseover="setfaq(this, \'faqba4e\')"><td colspan="2" class="td27" s="1">'.lang('plugin/ychat',"ychatduo_room_isVideoSwitch").':</td></tr>
				<tr><td colspan="2"  s="1"><input type="radio" name="isVideoSwitch" id="isVideoSwitch" value="1" checked/>
				 <label for="isVideoSwitch">'.lang('plugin/ychat',"ychatduo_room_videoroom").'</label>&nbsp;
				<input type="radio" name="isVideoSwitch" id="isVideoSwitch2" value="0" />
				<label for="isVideoSwitch2">'.lang('plugin/ychat',"ychatduo_room_textroom").'</label></td></tr>';	
			echo '<tr onmouseover="setfaq(this, \'faqba4e\')"><td colspan="2" class="td27" s="1">'.lang('plugin/ychat',"ychatduo_room_videonumber").':</td></tr>
						<tr><td colspan="2"  s="1"><input type="radio" name="videonumber" id="videonumber" value="1" />
						  <label for="videonumber">'.lang('plugin/ychat',"ychatduo_room_danshipin").'</label>&nbsp;
						  <input type="radio" name="videonumber" id="videonumber2" value="3" checked />
						  <label for="videonumber2">'.lang('plugin/ychat',"ychatduo_room_3shipin").'</label></td></tr>';	
			showsetting(lang('plugin/ychat','ychatduo_room_playerDisplay'), 'playerDisplay', '', 'radio');	
			showsetting(lang('plugin/ychat','ychatduo_room_image'), 'image',  '', 'filetext');	
			showsetting(lang('plugin/ychat','ychatduo_room_mainChatBg'), 'mainChatBg','', 'filetext');	
			showsetting(lang('plugin/ychat','ychatduo_room_myChatBg'), 'myChatBg', '', 'filetext');	
			echo '<tr><td colspan="2" class="td27" s="1"><input type="checkbox" name="XianzhiJoinRoom" id="XianzhiJoinRoom" value="1" /><label for="XianzhiJoinRoom">'.lang('plugin/ychat',"ychatduo_room_XianzhiJoinRoom").'</label></td></tr>';
			showsetting(lang('plugin/ychat','ychatduo_room_YunxuJoinGroup'), 'YunxuJoinGroup', '1|2|3|4', 'text');	
			echo '<tr><td colspan="2" class="td27" s="1"><input type="checkbox" name="XianzhiChat" id="XianzhiChat"  value="1" /><label for="XianzhiChat">'.lang('plugin/ychat',"ychatduo_room_XianzhiChat").'</label></td></tr>';
			showsetting(lang('plugin/ychat','ychatduo_room_YunxuSendMessage'), 'YunxuSendMessage',  '1|2|3|4', 'text');	
			echo '<tr><td colspan="2" class="td27" s="1"><input type="checkbox" name="XianzhiSendMagic" id="XianzhiSendMagic"  value="1" /><label for="XianzhiSendMagic">'.lang('plugin/ychat',"ychatduo_room_XianzhiSendMagic").'</label></td></tr>';
			showsetting(lang('plugin/ychat','ychatduo_room_YunxuSendMagicGroup'), 'YunxuSendMagicGroup',  '1|2|3|4', 'text');	
			echo '<tr><td colspan="2" class="td27" s="1"><input type="checkbox" name="MagicScoreFlag" id="MagicScoreFlag"  value="1" /><label for="MagicScoreFlag">'.lang('plugin/ychat',"ychatduo_room_MagicScoreFlag").'</label></td></tr>';
			showsetting(lang('plugin/ychat','ychatduo_room_MagicScoreNumber'), 'MagicScoreNumber',  '0', 'text');	
			echo '<tr><td colspan="2" class="td27" s="1"><input type="checkbox" name="isPaiMaiFlag" id="isPaiMaiFlag"  value="1" /><label for="isPaiMaiFlag">'.lang('plugin/ychat',"ychatduo_room_isPaiMaiFlag").'</label></td></tr>';
			showsetting(lang('plugin/ychat','ychatduo_room_yuxuPaimaiGroup'), 'yuxuPaimaiGroup',  '1|2|3|4', 'text');	
			showsetting(lang('plugin/ychat','ychatduo_room_yunxuFatuGroup'), 'yunxuFatuGroup', '-1', 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_yunxuDuiliaoGroup'), 'yunxuDuiliaoGroup', '-1', 'text');	

					showsetting(lang('plugin/ychat','ychatduo_room_CompetenceData'), 'CompetenceData',  '1|2', 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_AdminCompetenceUID'), 'AdminCompetenceUID',  '', 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_ptAdminCompetenceUID'), 'ptAdminCompetenceUID',  '', 'text');	

					showsetting(lang('plugin/ychat','ychatduo_room_adv'), 'adv',  '', 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_videoadvClick0'), 'videoadvClick0',  '', 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_videoadv1'), 'videoadv1',  '', 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_videoadvClick1'), 'videoadvClick1', '', 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_videoadv2'), 'videoadv2',  '', 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_videoadvClick2'), 'videoadvClick2', '', 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_videoadv3'), 'videoadv3',  '', 'text');	
					showsetting(lang('plugin/ychat','ychatduo_room_videoadvClick3'), 'videoadvClick3',  '', 'text');	
					
					showsubmit('ychatsubmit', 'submit');
			
				showtablefooter();
				showformfooter();
		}
		else
		{
			$roomID=$_GET["roomID"];
			$roID=$_POST["roID"];
			$roomName = $_POST["roomName"];
			
			$roomDescript = $_POST["roomDescript"];
			$rolenum = $_POST["rolenum"];
			$password = $_POST["password"];
			$adv = $_POST["adv"];
			$CompetenceData = $_POST["CompetenceData"];
			$YunxuJoinGroup = $_POST["YunxuJoinGroup"];
			$XianzhiJoinRoom =$_POST["XianzhiJoinRoom"];

			$YunxuSendMessage = $_POST["YunxuSendMessage"];
			$XianzhiChat = $_POST["XianzhiChat"];
			$YunxuSendMagicGroup = $_POST["YunxuSendMagicGroup"];
			$XianzhiSendMagic = $_POST["XianzhiSendMagic"];
			$MagicScoreNumber = $_POST["MagicScoreNumber"];
			$MagicScoreFlag = $_POST["MagicScoreFlag"];
			$micoTime=$_POST["micoTime"];

			$isPaiMaiFlag=$_POST["isPaiMaiFlag"];
			$yuxuPaimaiGroup=$_POST["yuxuPaimaiGroup"];
			$AdminCompetenceUID=$_POST["AdminCompetenceUID"];
			$jifenPaodian=$_POST["jifenPaodian"];
			$paodianTime=$_POST["paodianTime"];

			$playerDisplay=$_POST["playerDisplay"];
			$isDisplayGift=$_POST["isDisplayGift"];
			$micMode=$_POST["micMode"];
			$yunxuJietuGroup=$_POST["yunxuJietuGroup"];
			$yunxuFatuGroup=$_POST["yunxuFatuGroup"];
			$isVideoSwitch=$_POST["isVideoSwitch"];
			$videonumber=$_POST["videonumber"];
			$yunxuDuiliaoGroup=$_POST["yunxuDuiliaoGroup"];
			$ptAdminCompetenceUID=$_POST["ptAdminCompetenceUID"];
			$videoadv1=$_POST["videoadv1"];
			$videoadv2=$_POST["videoadv2"];
			$videoadv3=$_POST["videoadv3"];
			$videoadvClick1=$_POST["videoadvClick1"];
			$videoadvClick2=$_POST["videoadvClick2"];
			$videoadvClick3=$_POST["videoadvClick3"];
			$videoadvClick0=$_POST["videoadvClick0"];			
			$categoryID=$_POST["categoryID"];
			$timeline=time();
			if($_FILES['image']["type"])
			{
				$ext=strrchr($_FILES['image']["name"],".");
				$imagepath="source/plugin/ychat/images/slt".$timeline.$ext;
				uploadfile($_FILES['image'],$imagepath);
			}
			else
			{
				$imagepath=$_POST["image"];
			}
			
			if($_FILES['mainChatBg']["type"])
			{
				$ext=strrchr($_FILES['mainChatBg']["name"],".");
				$mainChatBgpath="source/plugin/ychat/images/cbg".$timeline.$ext;
				uploadfile($_FILES['mainChatBg'],$mainChatBgpath);
			}
			else
			{
				$mainChatBgpath=$_POST["mainChatBg"];
			}
			if($_FILES['myChatBg']["type"])
			{
				$ext=strrchr($_FILES['myChatBg']["name"],".");
				$myChatBgpath="source/plugin/ychat/images/mbg".$timeline.$ext;
				uploadfile($_FILES['myChatBg'],$myChatBgpath);
			}
			else
			{
				$myChatBgpath=$_POST["myChatBg"];
			}
			$data=array(
				'roomName'=>$roomName,
				'roomDescript'=>$roomDescript,
				'image'=>$imagepath,
				'rolenum'=>$rolenum,
				'password'=>$password,
				'adv'=>$adv,
				'CompetenceData'=>$CompetenceData,
				'YunxuJoinGroup'=>$YunxuJoinGroup,
				'XianzhiJoinRoom'=>$XianzhiJoinRoom,
				'YunxuSendMessage'=>$YunxuSendMessage,
				'XianzhiChat'=>$XianzhiChat,
				'YunxuSendMagicGroup'=>$YunxuSendMagicGroup,
				'XianzhiSendMagic'=>$XianzhiSendMagic,
				'MagicScoreNumber'=>$MagicScoreNumber,
				'MagicScoreFlag'=>$MagicScoreFlag,
				'micoTime'=>$micoTime,
				'isPaiMaiFlag'=>$isPaiMaiFlag,
				'yuxuPaimaiGroup'=>$yuxuPaimaiGroup,
				'AdminCompetenceUID'=>$AdminCompetenceUID,
				'jifenPaodian'=>$jifenPaodian,
				'paodianTime'=>$paodianTime,
				'mainChatBg'=>$mainChatBgpath,
				'myChatBg'=>$myChatBgpath,
				'playerDisplay'=>$playerDisplay,
				'isDisplayGift'=>$isDisplayGift,
				'micMode'=>$micMode,
				'yunxuJietuGroup'=>$yunxuJietuGroup,
				'yunxuFatuGroup'=>$yunxuFatuGroup,
				'isVideoSwitch'=>$isVideoSwitch,
				'videonumber'=>$videonumber,
				'yunxuDuiliaoGroup'=>$yunxuDuiliaoGroup,
				'ptAdminCompetenceUID'=>$ptAdminCompetenceUID,
				'videoadv1'=>$videoadv1,
				'videoadv2'=>$videoadv2,
				'videoadv3'=>$videoadv3,
				'videoadvClick1'=>$videoadvClick1,
				'videoadvClick2'=>$videoadvClick2,
				'videoadvClick3'=>$videoadvClick3,
				'videoadvClick0'=>$videoadvClick0,
				'categoryID'=>$categoryID,
				);
			C::t("#ychat#ychat_rooms")->insert($data,0,1);
			cpmsg(lang('plugin/ychat','ychatduo_room_add_success'),'action=plugins&operation=config&identifier=ychat&pmod=ychat_admin_rooms','succeed');
		}
}
else if($ymod=="search")
{
		if(!submitcheck('ychatsubmit')&&empty($_GET["flag"]))
		{
			showsearchform2();
		}
		else
		{
			
		}
}
function uploadfile($file,$path)
{
	if ((($file["type"] == "image/gif")|| ($file["type"] == "image/png")|| ($file["type"] == "image/jpeg")|| ($file["type"] == "image/pjpeg")||($file["type"]=="application/x-shockwave-flash"))
		&& ($file["size"] < 800000))
		{
		if ($file["error"] > 0)
		{
			cpmsg($file["error"],'',"error");
		}
		else
		{
			move_uploaded_file($file["tmp_name"],$path);
		}
  }
else
  {
	 cpmsg(lang('plugin/ychat',"ychat_hostresslevel_icon_upload_error"),'',"error");
  }
}
function showsearchform($operation = '') {
	global $_G, $lang;
	$formurl = "ychatduo&operation=rooms&do=list";
	showformheader($formurl);
	showtableheader();
	showsetting('ychat_search_uid', 'roomID', '', 'text');
	showsubmit('ychatsubmit','submit');
	showtablefooter();
	showformfooter();
}
?>