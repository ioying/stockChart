<?php

/**
 *	@name		UIDилЁг
 *	@author		Jiekii
 *	@qq			357754800
 *	@email		jiekii@vip.qq.com
 *	@website	http://www.dpzone.net/
 *	@date		2012-10-27
**/

if(!defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF
DROP TABLE IF EXISTS pre_ychat_bcategory;
DROP TABLE IF EXISTS pre_ychat_category;
DROP TABLE IF EXISTS pre_ychat_config;
DROP TABLE IF EXISTS pre_ychat_gift_categories;
DROP TABLE IF EXISTS pre_ychat_gift_goods;
DROP TABLE IF EXISTS pre_ychat_gift_list;
DROP TABLE IF EXISTS pre_ychat_rooms;
EOF;
runquery($sql);
runquery("delete  from ".DB::table("common_credit_rule")." where action='chatroom'");
$finish = TRUE;
?>