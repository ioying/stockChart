<?php

/**
 *	@name		UID商城
 *	@author		Jiekii
 *	@qq			357754800
 *	@email		jiekii@vip.qq.com
 *	@website	http://www.dpzone.net/
**/

if(!defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE IF EXISTS pre_ychat_bcategory;
CREATE TABLE IF NOT EXISTS pre_ychat_bcategory (
  bCategoryID int(4) NOT NULL auto_increment,
  bCategoryName varchar(50) NOT NULL,
  PRIMARY KEY  (bCategoryID)
) ENGINE=MyISAM AUTO_INCREMENT=4;

INSERT INTO pre_ychat_bcategory VALUES (1, '综艺');
INSERT INTO pre_ychat_bcategory VALUES (2, '情感');
INSERT INTO pre_ychat_bcategory VALUES (3, '财经');

DROP TABLE IF EXISTS pre_ychat_category;
CREATE TABLE IF NOT EXISTS pre_ychat_category (
  categoryID int(4) NOT NULL auto_increment,
  categoryName varchar(50) NOT NULL,
  bCategoryID int(4) NOT NULL,
  PRIMARY KEY  (categoryID)
) ENGINE=MyISAM AUTO_INCREMENT=13 ;

INSERT INTO pre_ychat_category VALUES (1, '网舞健身', 1);
INSERT INTO pre_ychat_category VALUES (2, '美女聊吧', 1);
INSERT INTO pre_ychat_category VALUES (3, '青春靓女', 1);
INSERT INTO pre_ychat_category VALUES (4, '靓丽互动', 1);
INSERT INTO pre_ychat_category VALUES (5, '点歌台', 1);
INSERT INTO pre_ychat_category VALUES (6, '综艺广场', 1);
INSERT INTO pre_ychat_category VALUES (7, '炫舞秀场', 1);
INSERT INTO pre_ychat_category VALUES (8, '中年专区', 2);
INSERT INTO pre_ychat_category VALUES (9, '同城有约', 2);
INSERT INTO pre_ychat_category VALUES (10, '情感婚恋', 2);
INSERT INTO pre_ychat_category VALUES (11, '你我同龄', 2);
INSERT INTO pre_ychat_category VALUES (12, '股票财经', 3);

DROP TABLE IF EXISTS pre_ychat_config;
CREATE TABLE IF NOT EXISTS pre_ychat_config (
  var varchar(30)  NOT NULL,
  `value` text  NOT NULL
) ENGINE=MyISAM;

INSERT INTO pre_ychat_config VALUES ('RegistUrl', '../member.php?mod=register');
INSERT INTO pre_ychat_config VALUES ('ShouyeUrl', './');
INSERT INTO pre_ychat_config VALUES ('RoomsListUrl', 'rooms.html');
INSERT INTO pre_ychat_config VALUES ('isP2PFlag', '2');
INSERT INTO pre_ychat_config VALUES ('UpdateUserInfo', './plugin.php?id=ychat&mod=modifyuserinfo');
INSERT INTO pre_ychat_config VALUES ('emotexml_URL', 'source/plugin/ychat/xml/emote.xml');
INSERT INTO pre_ychat_config VALUES ('LoadUserInfoAddress', './plugin.php?id=ychat&mod=moreuserinfo&uid=');
INSERT INTO pre_ychat_config VALUES ('FilterAddress', 'source/plugin/ychat/xml/filtrate.xml');
INSERT INTO pre_ychat_config VALUES ('JoinRoomSound', 'true');
INSERT INTO pre_ychat_config VALUES ('chatType', 'discuzX');
INSERT INTO pre_ychat_config VALUES ('paimaiJiangeTime', '11');
INSERT INTO pre_ychat_config VALUES ('jifenTitle', '金币');
INSERT INTO pre_ychat_config VALUES ('cyy', 'Hi~，大家好|不好意思我要走了，再见！|大家多叫点朋友进来聊天吧。|我知道了|认识你们真高兴！|有人愿意跟我聊聊吗？|请大家文明聊天！|很高兴见到你。');
INSERT INTO pre_ychat_config VALUES ('lianxiUrl', 'http://wpasig.qq.com/msgrd?v=3%0auin=445720316%0asite=qq%0amenu=yes');
INSERT INTO pre_ychat_config VALUES ('chongzhiUrl', 'http://www.ychat.cc');
INSERT INTO pre_ychat_config VALUES ('emoteUrl', 'source/plugin/ychat/help/emote.html');
INSERT INTO pre_ychat_config VALUES ('systemHelp', 'http://www.ychat.cc');
INSERT INTO pre_ychat_config VALUES ('MaxMsgLength', '20000');
INSERT INTO pre_ychat_config VALUES ('ScrollFlag', 'false');
INSERT INTO pre_ychat_config VALUES ('DefaultSendKey', '2');
INSERT INTO pre_ychat_config VALUES ('DisMessageCount', '100');
INSERT INTO pre_ychat_config VALUES ('MessageLength', '300');
INSERT INTO pre_ychat_config VALUES ('FmsAddress', 'rtmp://www.ychat.cc:1935/ychat-trial/');
INSERT INTO pre_ychat_config VALUES ('MagicTime', '10000');
INSERT INTO pre_ychat_config VALUES ('MainBg_Scale9Grid', '20|100|50|20');
INSERT INTO pre_ychat_config VALUES ('magic_URL', 'source/plugin/ychat/magic/magic.xml');
INSERT INTO pre_ychat_config VALUES ('UploadFileSize', '50');
INSERT INTO pre_ychat_config VALUES ('FontSize_End', '22');
INSERT INTO pre_ychat_config VALUES ('FontSize_Start', '8');
INSERT INTO pre_ychat_config VALUES ('FontSize', '12');
INSERT INTO pre_ychat_config VALUES ('FontFamily', '宋体');
INSERT INTO pre_ychat_config VALUES ('MagicToolsPos', '310|210');
INSERT INTO pre_ychat_config VALUES ('BqToolsPos', '200|220');
INSERT INTO pre_ychat_config VALUES ('endBqnum', '189');
INSERT INTO pre_ychat_config VALUES ('startBqnum', '100');
INSERT INTO pre_ychat_config VALUES ('Jifenbugou', '对不起，您的积分不够，不能发送魔法表情！');
INSERT INTO pre_ychat_config VALUES ('JifenjiekouFail', '调用扣除积分接口失败，请联系管理员！');
INSERT INTO pre_ychat_config VALUES ('XianzhiSendMagicTishi', '对不起，您所在的用户组不能发送魔法表情！');
INSERT INTO pre_ychat_config VALUES ('XianzhiChatTishi', '对不起，您所在的用户组不能发送消息！');
INSERT INTO pre_ychat_config VALUES ('UserinfoAddress', './plugin.php?id=ychat&mod=userinfo');
INSERT INTO pre_ychat_config VALUES ('KoujifenAddress', './plugin.php?id=ychat&mod=credit');
INSERT INTO pre_ychat_config VALUES ('XianzhiJoinTishi', '对不起，您所在的用户组不能进入聊天室！');
INSERT INTO pre_ychat_config VALUES ('DeveloperKey', 'ychatmulticast/');
INSERT INTO pre_ychat_config VALUES ('StratusAddress', 'rtmfp://www.ychat.cc:1935');
INSERT INTO pre_ychat_config VALUES ('BqUI', 'source/plugin/ychat/swf/bq.swf');
INSERT INTO pre_ychat_config VALUES ('MainUI', 'source/plugin/ychat/swf/ui.jpg');
INSERT INTO pre_ychat_config VALUES ('loadingUI', 'source/plugin/ychat/swf/loading.swf');
INSERT INTO pre_ychat_config VALUES ('nanColor', '3355443');
INSERT INTO pre_ychat_config VALUES ('nvColor', '16711832');
INSERT INTO pre_ychat_config VALUES ('zhongColor', '6658303');
INSERT INTO pre_ychat_config VALUES ('paodianUrl', './plugin.php?id=ychat&mod=paodian');
INSERT INTO pre_ychat_config VALUES ('playerAddress', 'source/plugin/ychat/swf/player.swf');
INSERT INTO pre_ychat_config VALUES ('playerPos', '580|90');
INSERT INTO pre_ychat_config VALUES ('defaultVolume', '1');
INSERT INTO pre_ychat_config VALUES ('loginUrl', 'source/plugin/ychat/swf/login.swf');
INSERT INTO pre_ychat_config VALUES ('loginPage', './plugin.php?id=ychat&mod=login');
INSERT INTO pre_ychat_config VALUES ('paihangURL', './plugin.php?id=ychat&mod=rank');
INSERT INTO pre_ychat_config VALUES ('buffertime', '1.2');
INSERT INTO pre_ychat_config VALUES ('videowidth', '320');
INSERT INTO pre_ychat_config VALUES ('videoheight', '240');
INSERT INTO pre_ychat_config VALUES ('fps', '15');
INSERT INTO pre_ychat_config VALUES ('keyFrameInterval', '20');
INSERT INTO pre_ychat_config VALUES ('qulity', '60');
INSERT INTO pre_ychat_config VALUES ('highQuality', '90');
INSERT INTO pre_ychat_config VALUES ('soundQuality', '8');

DROP TABLE IF EXISTS pre_ychat_gift_categories;
CREATE TABLE IF NOT EXISTS pre_ychat_gift_categories (
  id tinyint(8) unsigned NOT NULL auto_increment,
  `name` varchar(50) NOT NULL,
  top int(11) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM AUTO_INCREMENT=5;

INSERT INTO pre_ychat_gift_categories VALUES (1, '热门', 0);
INSERT INTO pre_ychat_gift_categories VALUES (2, '友谊', 0);
INSERT INTO pre_ychat_gift_categories VALUES (3, '爱情', 0);
INSERT INTO pre_ychat_gift_categories VALUES (4, '奢华', 1);

DROP TABLE IF EXISTS pre_ychat_gift_goods;
CREATE TABLE IF NOT EXISTS pre_ychat_gift_goods (
  id smallint(6) unsigned NOT NULL auto_increment,
  cid int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  pic varchar(50) NOT NULL,
  picAct varchar(50) NOT NULL,
  price mediumint(8) unsigned NOT NULL default '0',
  dateline int(11) NOT NULL,
  sell int(11) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM  AUTO_INCREMENT=51 ;

INSERT INTO `pre_ychat_gift_goods` VALUES (1, 1, '红唇热吻', 'thumbnails/100000110_a_t.png', 'preview/100000110_a_p.gif', 50, 1000000, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (2, 1, '玫瑰花', 'thumbnails/100000050_a_t.png', 'preview/100000050_a_p.gif', 60, 10000, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (3, 1, '蓝玫瑰', 'thumbnails/100000106_a_t.png', 'preview/100000106_a_p.gif', 100, 10000, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (4, 1, '歌舞娃娃', 'thumbnails/100000107_a_t.png', 'preview/100000107_a_p.gif', 1000, 10000, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (5, 1, '歌舞皇后', 'thumbnails/100000108_a_t.png', 'preview/100000108_a_p.gif', 5000, 10000, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (6, 1, '鼓掌', 'thumbnails/100000123_a_t.png', 'preview/100000123_a_p.gif', 60, 1000, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (7, 1, '谢谢', 'thumbnails/100000133_a_t.png', 'preview/100000133_a_p.gif', 20, 10000, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (8, 1, '欢迎你', 'thumbnails/100000143_a_t.png', 'preview/100000143_a_p.gif', 20, 10000, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (9, 2, '棒棒糖', 'thumbnails/100000045_a_t.png', 'preview/100000045_a_p.gif', 60, 10000, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (10, 2, '你好棒', 'thumbnails/100000052_a_t.png', 'preview/100000052_a_p.gif', 60, 1373096193, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (11, 2, '干杯', 'thumbnails/100000059_a_t.png', 'preview/100000059_a_p.gif', 50, 100000, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (12, 2, '维尼', 'thumbnails/100000080_a_t.png', 'preview/100000080_a_p.gif', 1000, 100000, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (13, 2, '砖头', 'thumbnails/100000130_a_t.png', 'preview/100000130_a_p.gif', 60, 1000, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (14, 2, '乌龟', 'thumbnails/100000134_a_t.png', 'preview/100000134_a_p.gif', 60, 10000, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (15, 2, '猪头', 'thumbnails/100000137_a_t.png', 'preview/100000137_a_p.gif', 60, 10000, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (16, 2, '砸西红柿', 'thumbnails/100000140_a_t.png', 'preview/100000140_a_p.gif', 100, 10000, 6);
INSERT INTO `pre_ychat_gift_goods` VALUES (17, 3, '丘比特', 'thumbnails/100000043_a_t.png', 'preview/100000043_a_p.gif', 200, 10000, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (18, 3, '气球', 'thumbnails/100000054_a_t.png', 'preview/100000054_a_p.gif', 100, 10000, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (19, 3, '香浓巧克力', 'thumbnails/100000061_a_t.png', 'preview/100000061_a_p.gif', 100, 1000, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (20, 3, '亲你', 'thumbnails/100000065_a_t.png', 'preview/100000065_a_p.gif', 500, 0, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (21, 3, '表白', 'thumbnails/100000075_a_t.png', 'preview/100000075_a_p.gif', 200, 0, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (22, 3, '香水', 'thumbnails/100000129_a_t.png', 'preview/100000129_a_p.gif', 100, 0, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (23, 3, '抱抱', 'thumbnails/100000138_a_t.png', 'preview/100000138_a_p.gif', 100, 0, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (24, 3, '红包', 'thumbnails/100000142_a_t.png', 'preview/100000142_a_p.gif', 100, 0, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (25, 4, '钻戒', 'thumbnails/100000132_a_t.png', 'preview/100000132_a_p.gif', 10000, 0, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (26, 4, '汽车', 'thumbnails/100000004_a_t.png', 'preview/100000004_a_p.gif', 10000, 0, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (27, 4, '豪华别墅', 'thumbnails/100000006_a_t.png', 'preview/100000006_a_p.gif', 10000, 0, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (28, 4, '钻石', 'thumbnails/100000009_a_t.png', 'preview/100000009_a_p.gif', 5000, 0, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (29, 4, '我们结婚吧', 'thumbnails/100000112_a_t.png', 'preview/100000112_a_p.gif', 120000, 0, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (30, 4, '超级跑车', 'thumbnails/100000113_a_t.png', 'preview/100000113_a_p.gif', 200000, 0, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (31, 4, '五星级别墅', 'thumbnails/100000114_a_t.png', 'preview/100000114_a_p.gif', 300000, 0, 0);
INSERT INTO `pre_ychat_gift_goods` VALUES (32, 4, '岛屿', 'thumbnails/100000119_a_t.png', 'preview/100000119_a_p.gif', 150000, 0, 0);


DROP TABLE IF EXISTS pre_ychat_gift_list;
CREATE TABLE IF NOT EXISTS pre_ychat_gift_list (
  id int(11) NOT NULL auto_increment,
  gid int(11) NOT NULL ,
  sid int(11) NOT NULL ,
  rid text NOT NULL,
  message text NOT NULL,
  dateline int(11) NOT NULL,
  sellprice mediumint(9) NOT NULL,
  throw tinyint(1) NOT NULL,
  showgift tinyint(1) NOT NULL,
  num mediumint(9) NOT NULL,
  PRIMARY KEY  (id)
) ENGINE=MyISAM  AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS pre_ychat_rooms;
CREATE TABLE IF NOT EXISTS pre_ychat_rooms (
  roomID int(10) unsigned NOT NULL auto_increment,
  videoadvClick0 varchar(200) NOT NULL,
  roomName varchar(50)  NOT NULL,
  roomDescript mediumtext  NOT NULL,
  image varchar(100)  NOT NULL,
  rolenum int(4) NOT NULL,
  `password` varchar(16) default NULL,
  adv varchar(100)  NOT NULL default 'gg.swf',
  CompetenceData varchar(50)  NOT NULL default '1|2',
  YunxuJoinGroup varchar(50)  NOT NULL default '1|2|3|4',
  XianzhiJoinRoom int(4) NOT NULL default '0',
  YunxuSendMessage varchar(50)  NOT NULL default '1|2|3|4',
  XianzhiChat int(4) NOT NULL default '0',
  YunxuSendMagicGroup varchar(50) NOT NULL default '1|2|3|4',
  XianzhiSendMagic int(4) NOT NULL default '0',
  MagicScoreNumber int(4) NOT NULL default '0',
  MagicScoreFlag int(4) NOT NULL default '0',
  micoTime int(4) NOT NULL default '5',
  isPaiMaiFlag int(4) NOT NULL default '0',
  yuxuPaimaiGroup varchar(50)  NOT NULL default '1|2|3|4',
  jifenPaodian int(4) NOT NULL default '10',
  paodianTime int(4) NOT NULL default '600000',
  playerDisplay int(4) NOT NULL default '0',
  mainChatBg varchar(100)  NOT NULL default 'mbg.swf',
  myChatBg varchar(100)  NOT NULL default 'cbg.swf',
  AdminCompetenceUID varchar(50)  NOT NULL default '',
  isDisplayGift int(4) NOT NULL default '1',
  micMode int(4) NOT NULL default '1',
  yunxuJietuGroup varchar(50)  NOT NULL default '-1',
  yunxuFatuGroup varchar(50)  NOT NULL default '-1',
  isVideoSwitch int(4) NOT NULL default '1',
  videonumber int(4) NOT NULL default '3',
  yunxuDuiliaoGroup varchar(100) NOT NULL default '-1',
  ptAdminCompetenceUID varchar(100) NOT NULL,
  videoadv1 varchar(200) NOT NULL,
  videoadv2 varchar(200) NOT NULL,
  videoadv3 varchar(200) NOT NULL,
  videoadvClick1 varchar(200) NOT NULL,
  videoadvClick2 varchar(200) NOT NULL,
  videoadvClick3 varchar(200) NOT NULL,
  cnum int(4) NOT NULL default '0',
  categoryID int(4) NOT NULL,
  top int(2) NOT NULL default '0',
  PRIMARY KEY  (roomID)
) ENGINE=MyISAM  AUTO_INCREMENT=1002 ;
INSERT INTO pre_ychat_rooms VALUES (1001, 'http://www.ychat.cc', '易聊网', '易聊网，为您打造专业的语音视频聊天室。', '', 100, '', 'source/plugin/ychat/swf/gg.jpg', '1|2', '1|2|3|4', 0, '1|2|3|4', 0, '1|2|3|4', 0, 0, 0, 12, 0, '1|2|3|4', 10, 600000, 0, '', '', '', 1, 1, '', '-1', 1, 3, '-1', '', '', '', '', '', '', '', 0, 1, 0);

EOF;
runquery($sql);
runquery("delete  from ".DB::table("common_credit_rule")." where action='chatroom'");
runquery("INSERT INTO ".DB::table("common_credit_rule")."(rulename,action,cycletype,cycletime,rewardnum,norepeat,extcredits1,extcredits2,extcredits3,extcredits4,extcredits5,extcredits6,extcredits7,extcredits8,fids) VALUES ('聊天室泡点', 'chatroom', 3, 10, 0, 0, 0, 10, 0, 0, 0, 0, 0, 0, '')");
runquery("INSERT INTO ".DB::table("ychat_config")." VALUES ('Key', '".md5($_SERVER['SERVER_NAME'])."')");
$finish = TRUE;

?>