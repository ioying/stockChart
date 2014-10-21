<?php
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	header("Content-Type: application/xml");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	echo "\t<config>\n";
	$roomID=$_GET["roomID"];
	$value=C::t("#ychat#ychat_rooms")->fetch_all_by_roomID($roomID);
	if ($value) {
		echo "\t\t<password>".$value["password"]."</password>\n";
		echo "\t\t<CompetenceData>".$value["CompetenceData"]."</CompetenceData>\n";
		echo "\t\t<rolenum>".$value["rolenum"]."</rolenum>\n";
		echo "\t\t<micoTime>".$value["micoTime"]."</micoTime>\n";
		echo "\t\t<videonum>".$value["videonumber"]."</videonum>\n";
		echo "\t\t<formhash>".FORMHASH."</formhash>\n";
	}
	echo "\t</config>\n";
	exit;
?> 