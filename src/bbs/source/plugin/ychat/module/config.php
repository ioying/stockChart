<?php
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	if($_GET["formhash"]!=FORMHASH)
	{
		exit('Access Denied');
	}
	$roomID = empty($_GET['roomID']) ? 0 : intval($_GET['roomID']);
	header("Content-Type: application/xml");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	echo "\t<config>\n";
	$value=C::t("#ychat#ychat_rooms")->fetch_all_by_roomID($roomID);
	if ($value) {
		echo "\t\t<roomName><![CDATA[".$value["roomName"]."]]></roomName>\n";
		echo "\t\t<roomDescript><![CDATA[".$value["roomDescript"]."]]></roomDescript>\n";
		echo "\t\t<adv><![CDATA[".$value["adv"]."]]></adv>\n";
		echo "\t\t<password><![CDATA[".$value["password"]."]]></password>\n";
		echo "\t\t<CompetenceData><![CDATA[".$value["CompetenceData"]."]]></CompetenceData>\n";
		echo "\t\t<YunxuJoinGroup><![CDATA[".$value["YunxuJoinGroup"]."]]></YunxuJoinGroup>\n";
		$value["XianzhiJoinRoom"]=$value["XianzhiJoinRoom"]==1?"true":"false";
		echo "\t\t<XianzhiJoinRoom><![CDATA[".$value["XianzhiJoinRoom"]."]]></XianzhiJoinRoom>\n";
		echo "\t\t<YunxuSendMessage><![CDATA[".$value["YunxuSendMessage"]."]]></YunxuSendMessage>\n";
		$value["XianzhiChat"]=$value["XianzhiChat"]==1?"true":"false";
		echo "\t\t<XianzhiChat><![CDATA[".$value["XianzhiChat"]."]]></XianzhiChat>\n";
		echo "\t\t<YunxuSendMagicGroup><![CDATA[".$value["YunxuSendMagicGroup"]."]]></YunxuSendMagicGroup>\n";
		$value["XianzhiSendMagic"]=$value["XianzhiSendMagic"]==1?"true":"false";
		echo "\t\t<XianzhiSendMagic><![CDATA[".$value["XianzhiSendMagic"]."]]></XianzhiSendMagic>\n";
		echo "\t\t<MagicScoreNumber><![CDATA[".$value["MagicScoreNumber"]."]]></MagicScoreNumber>\n";
		$value["MagicScoreFlag"]=$value["MagicScoreFlag"]==1?"true":"false";
		echo "\t\t<MagicScoreFlag><![CDATA[".$value["MagicScoreFlag"]."]]></MagicScoreFlag>\n";

		$value["isPaiMaiFlag"]=$value["isPaiMaiFlag"]==1?"true":"false";
		echo "\t\t<isPaiMaiFlag><![CDATA[".$value["isPaiMaiFlag"]."]]></isPaiMaiFlag>\n";
		echo "\t\t<yuxuPaimaiGroup><![CDATA[".$value["yuxuPaimaiGroup"]."]]></yuxuPaimaiGroup>\n";
		echo "\t\t<jifenPaodian><![CDATA[".$value["jifenPaodian"]."]]></jifenPaodian>\n";
		echo "\t\t<paodianTime><![CDATA[".$value["paodianTime"]."]]></paodianTime>\n";
		
		echo "\t\t<playerDisplay><![CDATA[".$value["playerDisplay"]."]]></playerDisplay>\n";
		echo "\t\t<mainChatBg><![CDATA[".$value["mainChatBg"]."]]></mainChatBg>\n";
		echo "\t\t<myChatBg><![CDATA[".$value["myChatBg"]."]]></myChatBg>\n";
		echo "\t\t<AdminCompetenceUID><![CDATA[".$value["AdminCompetenceUID"]."]]></AdminCompetenceUID>\n";
		echo "\t\t<isDisplayGift><![CDATA[".$value["isDisplayGift"]."]]></isDisplayGift>\n";
		echo "\t\t<micMode><![CDATA[".$value["micMode"]."]]></micMode>\n";
		echo "\t\t<yunxuJietuGroup><![CDATA[".$value["yunxuJietuGroup"]."]]></yunxuJietuGroup>\n";
		echo "\t\t<yunxuFatuGroup><![CDATA[".$value["yunxuFatuGroup"]."]]></yunxuFatuGroup>\n";

		echo "\t\t<isVideoSwitch><![CDATA[".$value["isVideoSwitch"]."]]></isVideoSwitch>\n";
		echo "\t\t<videonumber><![CDATA[".$value["videonumber"]."]]></videonumber>\n";
		echo "\t\t<yunxuDuiliaoGroup><![CDATA[".$value["yunxuDuiliaoGroup"]."]]></yunxuDuiliaoGroup>\n";
		echo "\t\t<ptAdminCompetenceUID><![CDATA[".$value["ptAdminCompetenceUID"]."]]></ptAdminCompetenceUID>\n";
		echo "\t\t<videoadv1><![CDATA[".$value["videoadv1"]."]]></videoadv1>\n";
		echo "\t\t<videoadv2><![CDATA[".$value["videoadv2"]."]]></videoadv2>\n";
		echo "\t\t<videoadv3><![CDATA[".$value["videoadv3"]."]]></videoadv3>\n";
		echo "\t\t<videoadvClick1><![CDATA[".$value["videoadvClick1"]."]]></videoadvClick1>\n";
		echo "\t\t<videoadvClick2><![CDATA[".$value["videoadvClick2"]."]]></videoadvClick2>\n";
		echo "\t\t<videoadvClick3><![CDATA[".$value["videoadvClick3"]."]]></videoadvClick3>\n";
		echo "\t\t<videoadvClick0><![CDATA[".$value["videoadvClick0"]."]]></videoadvClick0>\n";
		
		$configarr=C::t("#ychat#ychat_config")->fetch_all();
		foreach($configarr as $value){
			echo "\t\t<".$value["var"]."><![CDATA[".$value["value"]."]]></".$value["var"].">\n";
		}
	}
	echo "\t</config>\n";
?> 