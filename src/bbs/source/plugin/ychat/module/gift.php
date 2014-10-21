<?php
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	header("Content-Type: application/xml");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>\n";
	echo "<information>\n";
	echo "\t<liwu name=\"gift\">\n";
	$carray =C::t("#ychat#ychat_gift_categories")->fetch_all();
	foreach($carray as $value) {
		$giftarray=C::t("#ychat#ychat_gift_goods")->fetch_all_by_cid($value['id']);
		echo "\t\t<data cid=\"".$value["id"]."\" name=\"".$value["name"]."\" top=\"".$value["top"]."\" >\n";
		foreach($giftarray as $gift) {
			echo "\t\t\t<item id=\"".$gift["id"]."\" name=\"".$gift["name"]."\" price=\"".$gift["price"]."\" pic=\"source/plugin/ychat/images/".$gift["pic"]."\" picAct=\"source/plugin/ychat/images/".$gift["picAct"]."\" />\n";
		}
		echo "\t\t</data>\n";
	}
	echo "\t</liwu>\n";
	
	echo "\t<daoju name=\"\">\n";
	echo "\t</daoju>\n";
	
	echo "\t<youxi name=\"\">\n";
	
	echo "\t</youxi>\n";
echo "</information>\n";
?> 