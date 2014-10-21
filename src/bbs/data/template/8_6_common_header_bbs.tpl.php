<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); 
0
|| checktplrefresh('./template/linksbbs/common/header_bbs.htm', './template/linksbbs/common/header_common.htm', 1411356110, '6', './data/template/8_6_common_header_bbs.tpl.php', './template/linksbbs', 'common/header_bbs')
;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />
<?php if($_G['config']['output']['iecompatible']) { ?><meta http-equiv="X-UA-Compatible" content="IE=EmulateIE<?php echo $_G['config']['output']['iecompatible'];?>" /><?php } ?>
<title><?php if(!empty($navtitle)) { ?><?php echo $navtitle;?><?php } if(empty($nobbname)) { ?> - <?php echo $_G['setting']['bbname'];?><?php } ?></title>
<?php echo $_G['setting']['seohead'];?>

<meta name="keywords" content="<?php if(!empty($metakeywords)) { echo dhtmlspecialchars($metakeywords); } ?>" />
<meta name="description" content="<?php if(!empty($metadescription)) { echo dhtmlspecialchars($metadescription); ?> <?php } if(empty($nobbname)) { ?>,<?php echo $_G['setting']['bbname'];?><?php } ?>" />
<meta name="MSSmartTagsPreventParsing" content="True" />
<meta http-equiv="MSThemeCompatible" content="Yes" />
<base href="<?php echo $_G['siteurl'];?>" /><link rel="stylesheet" type="text/css" href="data/cache/style_<?php echo STYLEID;?>_common.css?<?php echo VERHASH;?>" /><link rel="stylesheet" type="text/css" href="data/cache/style_<?php echo STYLEID;?>_forum_forumdisplay.css?<?php echo VERHASH;?>" /><?php if($_G['uid'] && isset($_G['cookie']['extstyle']) && strpos($_G['cookie']['extstyle'], TPLDIR) !== false) { ?><link rel="stylesheet" id="css_extstyle" type="text/css" href="<?php echo $_G['cookie']['extstyle'];?>/style.css" /><?php } elseif($_G['style']['defaultextstyle']) { ?><link rel="stylesheet" id="css_extstyle" type="text/css" href="<?php echo $_G['style']['defaultextstyle'];?>/style.css" /><?php } ?><link rel="stylesheet" href="http://a.links123.net/g/src/normalize.css">
<link rel="stylesheet" href="http://a.links123.net/g/src/util.css">
<link rel="stylesheet" href="http://a.links123.net/village/src/carousel.css">
<link rel="stylesheet" href="http://a.links123.net/village/src/global.css">
<link rel="stylesheet" href="http://a.links123.net/village/src/index.css">
<link rel="stylesheet" href="http://a.links123.net/village/src/theme.css">


<script src="<?php echo $_G['setting']['jspath'];?>/jquery-1.11.0.min.js" type="text/javascript"></script>
<script type="text/javascript">var STYLEID = '<?php echo STYLEID;?>', STATICURL = '<?php echo STATICURL;?>', IMGDIR = '<?php echo IMGDIR;?>', VERHASH = '<?php echo VERHASH;?>', charset = '<?php echo CHARSET;?>', discuz_uid = '<?php echo $_G['uid'];?>', cookiepre = '<?php echo $_G['config']['cookie']['cookiepre'];?>', cookiedomain = '<?php echo $_G['config']['cookie']['cookiedomain'];?>', cookiepath = '<?php echo $_G['config']['cookie']['cookiepath'];?>', showusercard = '<?php echo $_G['setting']['showusercard'];?>', attackevasive = '<?php echo $_G['config']['security']['attackevasive'];?>', disallowfloat = '<?php echo $_G['setting']['disallowfloat'];?>', creditnotice = '<?php if($_G['setting']['creditnotice']) { ?><?php echo $_G['setting']['creditnames'];?><?php } ?>', defaultstyle = '<?php echo $_G['style']['defaultextstyle'];?>', REPORTURL = '<?php echo $_G['currenturl_encode'];?>', SITEURL = '<?php echo $_G['siteurl'];?>', JSPATH = '<?php echo $_G['setting']['jspath'];?>', DYNAMICURL = '<?php echo $_G['dynamicurl'];?>';</script>
<script src="<?php echo $_G['setting']['jspath'];?>common.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php if(empty($_GET['diy'])) { $_GET['diy'] = '';?><?php } if(!isset($topic)) { $topic = array();?><?php } ?><meta name="application-name" content="<?php echo $_G['setting']['bbname'];?>" />
<meta name="msapplication-tooltip" content="<?php echo $_G['setting']['bbname'];?>" />
<meta name="msapplication-task" content="name=<?php echo $_G['setting']['navs']['2']['navname'];?>;action-uri=<?php echo !empty($_G['setting']['domain']['app']['forum']) ? 'http://'.$_G['setting']['domain']['app']['forum'] : $_G['siteurl'].'forum.php'; ?>;icon-uri=<?php echo $_G['siteurl'];?><?php echo IMGDIR;?>/bbs.ico" />
<?php if(widthauto()) { ?>
<link rel="stylesheet" id="css_widthauto" type="text/css" href="data/cache/style_<?php echo STYLEID;?>_widthauto.css?<?php echo VERHASH;?>" />
<script type="text/javascript">HTMLNODE.className += ' widthauto'</script>
<?php } ?>
</head>

<script src="<?php echo $_G['setting']['jspath'];?>forum.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="http://a.links123.net/g/src/base.css">
<!-- <link rel="stylesheet" type="text/css" href="http://a.links123.cn/g/src/gh/gh.css"> -->
<link rel="stylesheet" href="http://a.links123.net/g/src/normalize.css">
<link rel="stylesheet" href="http://a.links123.net/g/src/util.css">
<link rel="stylesheet" href="http://a.links123.net/village/src/carousel.css">
<link rel="stylesheet" href="http://a.links123.net/village/src/global.css">
<link rel="stylesheet" href="http://a.links123.net/village/src/list.css">
<link rel="stylesheet" href="http://a.links123.net/village/src/theme.css">

<!-- 上线请使用此段目录
    <link rel="stylesheet" type="text/css" href="/static/iread/css/style.css?<?php echo VERHASH;?>">
<link rel="stylesheet" type="text/css" href="/static/iread/css/top-bar.css?<?php echo VERHASH;?>">
-->
<!--由于目录不同，仅限 TT 本地测试使用 by TT -->
    <link rel="stylesheet" type="text/css" href="<?php echo $_G['siteurl'];?>template/linksbbs/css/style.css?<?php echo VERHASH;?>">
<link rel="stylesheet" type="text/css" href="<?php echo $_G['siteurl'];?>template/linksbbs/css/top-bar.css?<?php echo VERHASH;?>">

</head>

<body class="page_list">
<div id="append_parent"></div><div id="ajaxwaitid"></div>
    <div class="top-bar">
        <ul class="lf">
            <li><a href="http://www.links123.com/" target="_blank">首页</a></li>
            <li><a href="http://english.links123.com/" target="_blank">英语角</a></li>
            <li><a href="http://english.links123.com/IndexV2/index?t=chinese" target="_blank">汉语角</a></li>
            <li><a href="http://www.links123.com/Home/Index/nav.html" target="_blank">导航</a></li>
            <li><a href="http://www.links123.com/Suggestion.html" target="_blank">留言板</a></li>
        </ul>
        <div class="uc rf">
<?php if($_G['uid']) { ?>
            <!--<a href="/">消息 <em class="msg-tip">2</em></a> -->
            <a href="/" class="J_username"> <?php echo $_G['username'];?><i class="b-tip"></i></a>
            <ul class="pop-navlist" style="display:none;">
                <li class="t-tip"></li>
                <li class="person"><a href="http://www.links123.com/Members/Index"><i class="gh-ico gh-ico-person"></i>个人中心</a></li>
                <li><a href="http://www.links123.com/Members/Collection"><i class="gh-ico gh-ico-heart"></i>我的收藏</a></li>
                <li><a href="http://www.links123.com/Members/Recommend"><i class="gh-ico gh-ico-good"></i>我赞过的</a></li>
                <li><a href="#"><i class="gh-ico gh-ico-phone"></i>手机绑定</a></li>
                <li class="logout"><a href="//passport.links123.com/logout?f=http://www.links123.com/"> <i class="gh-ico gh-ico-close"></i>退出登录</a></li>
            </ul>
            <?php } else { ?>
            <a href="http://passport.links123.com/?f=http://village.links123.com/" class="login login-bg">登录</a><a href="http://passport.links123.com/register?f=http://village.links123.com/" class="join">快速注册</a>
            <?php } ?>
        </div>
    </div>
<div class="nav_bar clearfix"> <!--top-->
<h1 class="brand pull-left"><a href="###" title="另客村论坛首页">另客村</a>论坛</h1>
        <div class="lf"><a href="/" class="iread-logo"></a></div>
<ul class="pull-right nav">
        <ul class="pull-right nav"> <!--rf s-nav-->
            <li><a href="/">另客阅读</a></li>
            <li><a href="http://www.links123.com/Event.html" target="_blank">另客奖学金</a></li>
            <!-- 
            <li><a href=";" title="">外教免费课程</a></li>
            -->
            <li><a href="/forum.php?mod=forumdisplay&amp;fid=52" target="_blank">有问必答</a></li>
            <li><a href="/forum.php?mod=forumdisplay&amp;fid=38" target="_blank">另客云团队</a></li>
            <li class="desk-rank"><a href="/portal.php?mod=top" target="_blank">大赛排行榜</a></li>
        </ul>
    </div>
