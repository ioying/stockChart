<?php
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	if($_GET["formhash"]!=FORMHASH)
	{
		exit('Access Denied');
	}
	require_once libfile('function/home');
	require_once './config/config_ucenter.php';
	require_once 'fcommon.php';
	//获得用户uid
	$uid = empty($_GET['uid']) ? 0 : intval($_GET['uid']);
	//获得用户信息
	$space = getspace($uid, 'uid');
	require_once libfile('function/spacecp');
	space_merge($space, 'count');
	space_merge($space, 'field_home');
	space_merge($space, 'field_forum');
	space_merge($space, 'profile');
	space_merge($space, 'status');
	$groups = C::t('common_usergroup')->fetch_all($space["groupid"]);
	foreach($groups as $group);
	$group['icon']=$group['icon']==''?'':$_G['setting']['attachurl']."common/".$group['icon'];
	//性别
	$space['sex'] = $space['gender'] == '1'?lang("plugin/ychat","nan"):($space['gender'] == '2'?lang("plugin/ychat","nv"):'');
	//生日
	//$space['birth'] = ($space['birthyear']?"$space[birthyear]".'年':'').($space['birthmonth']?"$space[birthmonth]".'月':'').($space['birthday']?"$space[birthday]".'日':'');
	//婚恋
	$space['marry'] = $space['marry']=='1'?lang("plugin/ychat","danshen"):($space['marry']=='2'?lang("plugin/ychat","feidanshen"):'');
	//出生地
	$space['birthcity'] = trim(($space['birthprovince']?$space['birthprovince']:'')."|".($space['birthcity']?$space['birthcity']:''));
	$space['birthcity']=str_replace(lang("plugin/ychat","sheng"),"",$space['birthcity']);
	$space['birthcity']=str_replace(lang("plugin/ychat","shi"),"",$space['birthcity']);
	//居住地
	$space['residecity'] = trim(($space['resideprovince']?$space['resideprovince']:'')."|".($space['residecity']?$space['residecity']:''));
	$space['residecity'] =str_replace(lang("plugin/ychat","sheng"),"",$space['residecity']);
	$space['residecity'] =str_replace(lang("plugin/ychat","shi"),"",$space['residecity']);
	//域名
	$space['domainurl'] = space_domain($space);
	
	//日志
	
	$blogxml = "";
	$blogarr=C::t("home_blog")->range(0, 1, 'DESC', 'dateline',  null, null, $space['uid']);
	foreach ($blogarr as $value) {
			if(ckfriend($value['uid'], $value['friend'], $value['target_ids'])) {
				if($value['friend'] == 4) {
					$value['message'] = $value['pic'] = '';
				} else {
					$value['message'] = getstr($value['message'], $summarylen, 0, 0, 0, 0, -1);
				}
				$value['message'] = preg_replace("/&[a-z]+\;/i", '', $value['message']);
				if($value['pic']) $value['pic'] = pic_cover_get($value['pic'], $value['picflag']);
				$value['dateline'] = dgmdate($value['dateline']);
				$list[] = $value;
				$blogxml = $blogxml."\t\t<blog blogid='".$value['blogid']."' subject='".$value['subject']."'><![CDATA[".$value['message']."]]></blog>\n";
			} else {
				$pricount++;
			}
		}

	
	

	$albumxml = "";
	$maxalbum = $nowalbum = $key = 0;
	$albumlist=C::t("home_album")->fetch_all_by_uid($space[uid],'updatetime',0,5);
	foreach ($albumlist as $value) {
		if($value['friend'] != 4 && ckfriend($value['uid'], $value['friend'], $value['target_ids'])) {
			$value['pic'] = pic_cover_get($value['pic'], $value['picflag']);
		} elseif ($value['picnum']) {
			$value['pic'] = STATICURL.'image/common/nopublish.gif';
		} else {
			$value['pic'] = '';
		}
		$albumxml = $albumxml."\t\t<album albumid='".$value['albumid']."' albumname='".$value['albumname']."'><![CDATA[".$value['pic']."]]></album>\n";//获取相册id、相册名、相册缩略图
	}

	header("Content-Type: application/xml");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
	echo "<userInformation>\n";
		echo "\t<username>".$space['username']."</username>\n";//用户名
		echo "\t<name>".$space['realname']."</name>\n";//真实姓名
		$space['avatar']=UC_API.'/avatar.php?uid='.$_G['uid'].'&size=middle';//用户设置了头像
		echo "\t<avatar><![CDATA[".$space['avatar']."]]></avatar>\n";//头像
		echo "\t<experience>".$space['extcredits1']."</experience>\n";//经验
		echo "\t<experienceIcon>".showstars($group['stars'])."</experienceIcon>\n";//经验
		echo "\t<credit>".$space['credits']."</credit>\n";//积分
		echo "\t<domainurl>".$space['domainurl']."</domainurl>\n";//域名
		echo "\t<email>".$space['email']."</email>\n";//email
		echo "\t<sex>".$space['sex']."</sex>\n";//性别
		echo "\t<birthyear>".$space['birthyear']."</birthyear>\n";//生日 年
		echo "\t<birthmonth>".$space['birthmonth']."</birthmonth>\n";//月
		echo "\t<birthday>".$space['birthday']."</birthday>\n";//日
		echo "\t<marry>".$space['affectivestatus']."</marry>\n";//婚恋
		echo "\t<mobile>".$space['mobile']."</mobile>\n";//手机
		echo "\t<qq>".$space['qq']."</qq>\n";//qq
		echo "\t<birthcity>".$space['birthcity']."</birthcity>\n";//出生地
		echo "\t<residecity>".$space['residecity']."</residecity>\n";//居住地
		echo "\t<mobile>".$space['mobile']."</mobile>\n";//手机
		echo "\t<msn>".$space['msn']."</msn>\n";//msn
		echo "\t<groupid>".$space['groupid']."</groupid>\n";//组id
		echo "\t<groupicon><![CDATA[".$group['icon']."]]></groupicon>\n";//组id
		echo "\t<viewnum>".$space['viewnum']."</viewnum>\n";//访问人次
		echo "\t<dateline>".date('Y-m-d',$space['regdate'])."</dateline>\n";//创建时间
		echo "\t<lastlogin>".date('Y-m-d',$space['lastlogin'])."</lastlogin>\n";//上次登录
		echo "\t<blood>".$space['bloodtype']."</blood>\n";//血型
		echo "\t<occupation>".$space['occupation']."</occupation>\n";
		echo "\t<age>".(Date("Y")-$space['birthyear'])."</age>\n";
		echo "\t<spacenote><![CDATA[".strip_tags($space['spacenote'])."]]></spacenote>\n";//状态
		echo "\t\t<bloglist>".$blogxml."</bloglist>\n";
		echo "\t\t<albumlist>".$albumxml."</albumlist>\n";
	echo "\t</userInformation>\n";
?>