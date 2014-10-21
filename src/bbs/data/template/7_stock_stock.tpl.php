<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); hookscriptoutput('stock');
0
|| checktplrefresh('./source/plugin/stock/template/stock.htm', './template/links/common/header.htm', 1405157492, 'stock', './data/template/7_stock_stock.tpl.php', './source/plugin/stock/template', 'stock')
|| checktplrefresh('./source/plugin/stock/template/stock.htm', './template/links/common/footer.htm', 1405157492, 'stock', './data/template/7_stock_stock.tpl.php', './source/plugin/stock/template', 'stock')
|| checktplrefresh('./source/plugin/stock/template/stock.htm', './template/default/common/header_common.htm', 1405157492, 'stock', './data/template/7_stock_stock.tpl.php', './source/plugin/stock/template', 'stock')
;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET;?>" />
<?php if($_G['config']['output']['iecompatible']) { ?><meta http-equiv="X-UA-Compatible" content="IE=EmulateIE<?php echo $_G['config']['output']['iecompatible'];?>" /><?php } ?>
<title><?php if(!empty($navtitle)) { ?><?php echo $navtitle;?> - <?php } if(empty($nobbname)) { ?> <?php echo $_G['setting']['bbname'];?> - <?php } ?> Powered by Discuz!</title>
<?php echo $_G['setting']['seohead'];?>

<meta name="keywords" content="<?php if(!empty($metakeywords)) { echo dhtmlspecialchars($metakeywords); } ?>" />
<meta name="description" content="<?php if(!empty($metadescription)) { echo dhtmlspecialchars($metadescription); ?> <?php } if(empty($nobbname)) { ?>,<?php echo $_G['setting']['bbname'];?><?php } ?>" />
<meta name="generator" content="Discuz! <?php echo $_G['setting']['version'];?>" />
<meta name="author" content="Discuz! Team and Comsenz UI Team" />
<meta name="copyright" content="2001-2013 Comsenz Inc." />
<meta name="MSSmartTagsPreventParsing" content="True" />
<meta http-equiv="MSThemeCompatible" content="Yes" />
<base href="<?php echo $_G['siteurl'];?>" /><link rel="stylesheet" type="text/css" href="data/cache/style_<?php echo STYLEID;?>_common.css?<?php echo VERHASH;?>" /><?php if($_G['uid'] && isset($_G['cookie']['extstyle']) && strpos($_G['cookie']['extstyle'], TPLDIR) !== false) { ?><link rel="stylesheet" id="css_extstyle" type="text/css" href="<?php echo $_G['cookie']['extstyle'];?>/style.css" /><?php } elseif($_G['style']['defaultextstyle']) { ?><link rel="stylesheet" id="css_extstyle" type="text/css" href="<?php echo $_G['style']['defaultextstyle'];?>/style.css" /><?php } ?><script type="text/javascript">var STYLEID = '<?php echo STYLEID;?>', STATICURL = '<?php echo STATICURL;?>', IMGDIR = '<?php echo IMGDIR;?>', VERHASH = '<?php echo VERHASH;?>', charset = '<?php echo CHARSET;?>', discuz_uid = '<?php echo $_G['uid'];?>', cookiepre = '<?php echo $_G['config']['cookie']['cookiepre'];?>', cookiedomain = '<?php echo $_G['config']['cookie']['cookiedomain'];?>', cookiepath = '<?php echo $_G['config']['cookie']['cookiepath'];?>', showusercard = '<?php echo $_G['setting']['showusercard'];?>', attackevasive = '<?php echo $_G['config']['security']['attackevasive'];?>', disallowfloat = '<?php echo $_G['setting']['disallowfloat'];?>', creditnotice = '<?php if($_G['setting']['creditnotice']) { ?><?php echo $_G['setting']['creditnames'];?><?php } ?>', defaultstyle = '<?php echo $_G['style']['defaultextstyle'];?>', REPORTURL = '<?php echo $_G['currenturl_encode'];?>', SITEURL = '<?php echo $_G['siteurl'];?>', JSPATH = '<?php echo $_G['setting']['jspath'];?>', DYNAMICURL = '<?php echo $_G['dynamicurl'];?>';</script>
<script src="<?php echo $_G['setting']['jspath'];?>common.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php if(empty($_GET['diy'])) { $_GET['diy'] = '';?><?php } if(!isset($topic)) { $topic = array();?><?php } ?>
<meta name="application-name" content="<?php echo $_G['setting']['bbname'];?>" />
<meta name="msapplication-tooltip" content="<?php echo $_G['setting']['bbname'];?>" />
<?php if($_G['setting']['portalstatus']) { ?><meta name="msapplication-task" content="name=<?php echo $_G['setting']['navs']['1']['navname'];?>;action-uri=<?php echo !empty($_G['setting']['domain']['app']['portal']) ? 'http://'.$_G['setting']['domain']['app']['portal'] : $_G['siteurl'].'portal.php'; ?>;icon-uri=<?php echo $_G['siteurl'];?><?php echo IMGDIR;?>/portal.ico" /><?php } ?>
<meta name="msapplication-task" content="name=<?php echo $_G['setting']['navs']['2']['navname'];?>;action-uri=<?php echo !empty($_G['setting']['domain']['app']['forum']) ? 'http://'.$_G['setting']['domain']['app']['forum'] : $_G['siteurl'].'forum.php'; ?>;icon-uri=<?php echo $_G['siteurl'];?><?php echo IMGDIR;?>/bbs.ico" />
<?php if($_G['setting']['groupstatus']) { ?><meta name="msapplication-task" content="name=<?php echo $_G['setting']['navs']['3']['navname'];?>;action-uri=<?php echo !empty($_G['setting']['domain']['app']['group']) ? 'http://'.$_G['setting']['domain']['app']['group'] : $_G['siteurl'].'group.php'; ?>;icon-uri=<?php echo $_G['siteurl'];?><?php echo IMGDIR;?>/group.ico" /><?php } if(helper_access::check_module('feed')) { ?><meta name="msapplication-task" content="name=<?php echo $_G['setting']['navs']['4']['navname'];?>;action-uri=<?php echo !empty($_G['setting']['domain']['app']['home']) ? 'http://'.$_G['setting']['domain']['app']['home'] : $_G['siteurl'].'home.php'; ?>;icon-uri=<?php echo $_G['siteurl'];?><?php echo IMGDIR;?>/home.ico" /><?php } if($_G['basescript'] == 'forum' && $_G['setting']['archiver']) { ?>
<link rel="archives" title="<?php echo $_G['setting']['bbname'];?>" href="<?php echo $_G['siteurl'];?>archiver/" />
<?php } if(!empty($rsshead)) { ?><?php echo $rsshead;?><?php } if(widthauto()) { ?>
<link rel="stylesheet" id="css_widthauto" type="text/css" href="data/cache/style_<?php echo STYLEID;?>_widthauto.css?<?php echo VERHASH;?>" />
<script type="text/javascript">HTMLNODE.className += ' widthauto'</script>
<?php } if($_G['basescript'] == 'forum' || $_G['basescript'] == 'group') { ?>
<script src="<?php echo $_G['setting']['jspath'];?>forum.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php } elseif($_G['basescript'] == 'home' || $_G['basescript'] == 'userapp') { ?>
<script src="<?php echo $_G['setting']['jspath'];?>home.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php } elseif($_G['basescript'] == 'portal') { ?>
<script src="<?php echo $_G['setting']['jspath'];?>portal.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php } if($_G['basescript'] != 'portal' && $_GET['diy'] == 'yes' && check_diy_perm($topic)) { ?>
<script src="<?php echo $_G['setting']['jspath'];?>portal.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php } if($_GET['diy'] == 'yes' && check_diy_perm($topic)) { ?>
<link rel="stylesheet" type="text/css" id="diy_common" href="data/cache/style_<?php echo STYLEID;?>_css_diy.css?<?php echo VERHASH;?>" />
<?php } ?>
</head>

<body id="nv_<?php echo $_G['basescript'];?>" class="pg_<?php echo CURMODULE;?><?php if($_G['basescript'] === 'portal' && CURMODULE === 'list' && !empty($cat)) { ?> <?php echo $cat['bodycss'];?><?php } ?>" onkeydown="if(event.keyCode==27) return false;">
<div id="append_parent"></div><div id="ajaxwaitid"></div>
<?php if($_GET['diy'] == 'yes' && check_diy_perm($topic)) { include template('common/header_diy'); } if(check_diy_perm($topic)) { ?><?php
$__STATICURL = STATICURL;$diynav = <<<EOF

<a id="diy-tg" href="javascript:openDiy();" title="打开 DIY 面板" class="xi1 xw1" onmouseover="showMenu(this.id)"><img src="{$__STATICURL}image/diy/panel-toggle.png" alt="DIY" /></a>
<div id="diy-tg_menu" style="display: none;">
<ul>
<li><a href="javascript:saveUserdata('diy_advance_mode', '');openDiy();" class="xi2">简洁模式</a></li>
<li><a href="javascript:saveUserdata('diy_advance_mode', '1');openDiy();" class="xi2">高级模式</a></li>
</ul>
</div>

EOF;
?>
<?php } if(CURMODULE == 'topic' && $topic && empty($topic['useheader']) && check_diy_perm($topic)) { ?>
<?php echo $diynav;?>
<?php } if(empty($topic) || $topic['useheader']) { if($_G['setting']['mobile']['allowmobile'] && (!$_G['setting']['cacheindexlife'] && !$_G['setting']['cachethreadon'] || $_G['uid']) && ($_GET['diy'] != 'yes' || !$_GET['inajax']) && ($_G['mobile'] != '' && $_G['cookie']['mobile'] == '' && $_GET['mobile'] != 'no')) { ?>
<div class="xi1 bm bm_c">
    请选择 <a href="<?php echo $_G['siteurl'];?>forum.php?mobile=yes">进入手机版</a> <span class="xg1">|</span> <a href="<?php echo $_G['setting']['mobile']['nomobileurl'];?>">继续访问电脑版</a>
</div>
<?php } if(!IS_ROBOT) { if($_G['uid'] && !empty($_G['style']['extstyle'])) { ?>
<div id="sslct_menu" class="cl p_pop" style="display: none;">
<?php if(!$_G['style']['defaultextstyle']) { ?><span class="sslct_btn" onclick="extstyle('')" title="默认"><i></i></span><?php } if(is_array($_G['style']['extstyle'])) foreach($_G['style']['extstyle'] as $extstyle) { ?><span class="sslct_btn" onclick="extstyle('<?php echo $extstyle['0'];?>')" title="<?php echo $extstyle['1'];?>"><i style='background:<?php echo $extstyle['2'];?>'></i></span>
<?php } ?>
</div>
<?php } ?>

<!--定义快捷菜单， 后台设置可增加内容-->
<div id="qmenu_menu" class="p_pop <?php if(!$_G['uid']) { ?>blk<?php } ?>" style="display: none;">
<?php if($_G['uid']) { ?>
<ul><?php if(is_array($_G['setting']['mynavs'])) foreach($_G['setting']['mynavs'] as $nav) { if($nav['available'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1))) { ?>
<li><?php echo $nav['code'];?></li>
<?php } } ?>
<!------设置 后台管理 门户管理 退出 放到快捷中---------->
<?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra3'])) echo $_G['setting']['pluginhooks']['global_usernav_extra3'];?>
<li><a href="home.php?mod=spacecp">设置</a></li>
<?php if(($_G['group']['allowmanagearticle'] || $_G['group']['allowpostarticle'] || $_G['group']['allowdiy'] || getstatus($_G['member']['allowadmincp'], 4) || getstatus($_G['member']['allowadmincp'], 6) || getstatus($_G['member']['allowadmincp'], 2) || getstatus($_G['member']['allowadmincp'], 3))) { ?>
<li><a href="portal.php?mod=portalcp"><?php if($_G['setting']['portalstatus'] ) { ?>门户管理<?php } else { ?>模块管理<?php } ?></a></li>
<?php } if($_G['uid'] && $_G['group']['radminid'] > 1) { ?>
<li><a href="forum.php?mod=modcp&amp;fid=<?php echo $_G['fid'];?>" target="_blank"><?php echo $_G['setting']['navs']['2']['navname'];?>管理</a></li>
<?php } if($_G['uid'] && $_G['adminid'] == 1 && $_G['setting']['cloud_status']) { ?>
<li><a href="admin.php?frames=yes&amp;action=cloud&amp;operation=applist" target="_blank">云平台</a></li>
<?php } if($_G['uid'] && getstatus($_G['member']['allowadmincp'], 1)) { ?>
<li><a href="admin.php" target="_blank" style="background-image:url(http://localhost/bbs/static/image/feed/ranklist_b.png)" >管理中心</a></li>
<?php } ?>
<?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra4'])) echo $_G['setting']['pluginhooks']['global_usernav_extra4'];?>
<li><a href="member.php?mod=logging&amp;action=logout&amp;formhash=<?php echo FORMHASH;?>">退出</a></li>
<!------------------------------------------------------->	

</ul>
<?php } elseif($_G['connectguest']) { ?>
<div class="ptm pbw hm"> 
请先<br /><a class="xi2" href="member.php?mod=connect"><strong>完善帐号信息</strong></a> 或 <a href="member.php?mod=connect&amp;ac=bind" class="xi2 xw1"><strong>绑定已有帐号</strong></a><br />后使用快捷导航
</div>
<?php } else { ?>
<div class="ptm pbw hm"> 
请 <a href="javascript:;" class="xi2" onclick="lsSubmit()"><strong>登录</strong></a> 后使用快捷导航<br />没有帐号？<a href="member.php?mod=<?php echo $_G['setting']['regname'];?>" class="xi2 xw1"><?php echo $_G['setting']['reglinkname'];?></a>
</div>
<?php } ?>
</div>
<?php } ?><?php echo adshow("headerbanner/wp a_h");?><div id="hd">
<div class="wp"> 
<div class="hdc cl"><?php $mnid = getcurrentnav();?><?php if($_G['uid']) { } elseif(!empty($_G['cookie']['loginuser'])) { } elseif(!$_G['connectguest']) { ?>
<!-- 用户登录模板 -->
<!--xxx{xxx template member/login_simple xxx}xxx-->
<?php } else { } ?>
</div>

<div id="nv">


<!--网站logo -->

<h2><?php if(!isset($_G['setting']['navlogos'][$mnid])) { ?><a href="<?php if($_G['setting']['domain']['app']['default']) { ?>http://<?php echo $_G['setting']['domain']['app']['default'];?>/<?php } else { ?>./<?php } ?>" title="<?php echo $_G['setting']['bbname'];?>"><?php echo $_G['style']['boardlogo'];?></a><?php } else { ?><?php echo $_G['setting']['navlogos'][$mnid];?><?php } ?></h2>


<a href="javascript:;" id="qmenu" onmouseover="showMenu({'ctrlid':'qmenu','pos':'34!','ctrlclass':'a','duration':2});">快捷导航</a>
<ul><?php if(is_array($_G['setting']['navs'])) foreach($_G['setting']['navs'] as $nav) { if($nav['available'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1))) { ?><li <?php if($mnid == $nav['navid']) { ?>class="a" <?php } ?><?php echo $nav['nav'];?>></li><?php } } ?>
</ul>

 

<?php if(!empty($_G['setting']['pluginhooks']['global_nav_extra'])) echo $_G['setting']['pluginhooks']['global_nav_extra'];?>

<!--	用户名 ------------------------------------------------------- -->

<?php if($_G['uid']) { ?>		
<div id="um">


<!--显示头像   关闭-->
<!--
<div class="avt y"><a href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>"><!--xxx{xxx avatar(<?php echo $_G['uid'];?>,small) xxx}xxx --> <!--
</a>
</div>
-->
<p>

<?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra1'])) echo $_G['setting']['pluginhooks']['global_usernav_extra1'];?>

<a href="home.php?mod=space&amp;do=pm" id="pm_ntc"<?php if($_G['member']['newpm']) { ?> class="new"<?php } ?>>消息</a>
<span class="pipe">|</span><a href="home.php?mod=space&amp;do=notice" id="myprompt"<?php if($_G['member']['newprompt']) { ?> class="new"<?php } ?>>提醒<?php if($_G['member']['newprompt']) { ?>(<?php echo $_G['member']['newprompt'];?>)<?php } ?></a><span id="myprompt_check"></span>
<?php if($_G['setting']['taskon'] && !empty($_G['cookie']['taskdoing_'.$_G['uid']])) { ?><span class="pipe">|</span><a href="home.php?mod=task&amp;item=doing" id="task_ntc" class="new">进行中的任务</a><?php } if($_G['uid'] && $_G['group']['radminid'] > 1) { ?>
<span class="pipe">|</span><a href="forum.php?mod=modcp&amp;fid=<?php echo $_G['fid'];?>" target="_blank"><?php echo $_G['setting']['navs']['2']['navname'];?>管理</a>
<?php } if($_G['uid'] && $_G['adminid'] == 1 && $_G['setting']['cloud_status']) { ?>
<span class="pipe">|</span><a href="admin.php?frames=yes&amp;action=cloud&amp;operation=applist" target="_blank">云平台</a>
<?php } ?>
<span class="pipe">|</span>
<strong class="vwmy<?php if($_G['setting']['connect']['allow'] && $_G['member']['conisbind']) { ?> qq<?php } ?>"><a href="home.php?mod=space&amp;uid=<?php echo $_G['uid'];?>" target="_blank" title="访问我的空间"><?php echo $_G['member']['username'];?></a></strong>
<?php if($_G['group']['allowinvisible']) { ?>
<span id="loginstatus">
<a id="loginstatusid" href="member.php?mod=switchstatus" title="切换在线状态" onclick="ajaxget(this.href, 'loginstatus');return false;" class="xi2"> </a>
</span>
<?php } ?>
<?php if(!empty($_G['setting']['pluginhooks']['global_usernav_extra2'])) echo $_G['setting']['pluginhooks']['global_usernav_extra2'];?>

</p>
</div>	
<?php } ?>

<!------------------------------------------------------------------------->

</div>
<?php if(!empty($_G['setting']['plugins']['jsmenu'])) { ?>
<ul class="p_pop h_pop" id="plugin_menu" style="display: none"><?php if(is_array($_G['setting']['plugins']['jsmenu'])) foreach($_G['setting']['plugins']['jsmenu'] as $module) { ?> <?php if(!$module['adminid'] || ($module['adminid'] && $_G['adminid'] > 0 && $module['adminid'] >= $_G['adminid'])) { ?>
 <li><?php echo $module['url'];?></li>
 <?php } } ?>
</ul>
<?php } ?>
<?php echo $_G['setting']['menunavs'];?>
<div id="mu" class="cl">
<?php if($_G['setting']['subnavs']) { if(is_array($_G['setting']['subnavs'])) foreach($_G['setting']['subnavs'] as $navid => $subnav) { if($_G['setting']['navsubhover'] || $mnid == $navid) { ?>
<ul class="cl <?php if($mnid == $navid) { ?>current<?php } ?>" id="snav_<?php echo $navid;?>" style="display:<?php if($mnid != $navid) { ?>none<?php } ?>">
<?php echo $subnav;?>
</ul>
<?php } } } ?>
</div><?php echo adshow("subnavbanner/a_mu");?><!--暂不显示搜索-->
<!--xxx{xxx subtemplate common/pubsearchform xxx}xxx-->

</div>
</div>

<?php if(!empty($_G['setting']['pluginhooks']['global_header'])) echo $_G['setting']['pluginhooks']['global_header'];?>
<?php } ?>

<div id="wp" class="wp"><script src="source/plugin/stock/stock.func.js" type="text/javascript"></script>
<!--代码高亮-->
<script src="/CodeMirror/lib/codemirror.js" type="text/javascript"></script>
<link rel="stylesheet" href="/CodeMirror/lib/codemirror.css">
<script src="/CodeMirror/mode/javascript/javascript.js" type="text/javascript"></script>
<!--加载代码高亮主题  -->
<link rel="stylesheet" href="/CodeMirror/lib/codemirror.css">
<link rel="stylesheet" href="/CodeMirror/doc/docs.css">
<link rel="stylesheet" href="/CodeMirror/theme/ambiance.css">
<!--自定义页面函数-->
<script src="source/plugin/stock/main.js" type="text/javascript"></script>
<!--代码高亮结束-->
<!--载入等候特效
<script src="/spin/jquery-1.10.1.min.js" type="text/javascript"></script>
<script src="/spin/spin.min.js" type="text/javascript" ></script>   
<script src="/spin/myspin.js" type="text/javascript" ></script>    -->    
<!--编辑部分 CSS 调试后移动到 extend_common.css 中 background-color:#99bbbb; -->
<style type="text/css">
div#container{width:100%}
div#header {height:300px;width:750px;float:left;}
div#prompt {background-color:#EEEEEE;height:300px;width:300px;float:left;}
div#menu1 {height:500px;width:750px;float:left;}
div#content {background-color:#EEEEEE;height:500px;width:300px;float:left;}
div#right {background-color:#EE0EEE;height:500px;width:350px;float:left;}
div#footer {background-color:#99bbbb;clear:both;text-align:center;}
h1 {margin-bottom:0;}
h2 {margin-bottom:0;font-size:18px;}
ul {margin:0;}
li {list-style:none;}
.remarks {font-size:6px;}
</style>


<div id="ct" class="wp cl">
  <div class="mn">
    <div class="bm">

<?php if(empty($_GET['mod'])) { ?>



<table width=100%  cellspacing="0" cellpadding="0" border="0"  style=" " >
<tr>
<td width=80%>
<iframe width=100% height=460 frameborder=0 src="source/plugin/stock/candle.inc.php?fdataid=./data/try/try_1.json&amp;mainmap=1"></iframe>
</td>
<td>
<div>aaa</div>
<div>bb</div>
<div>ddd</div>
<div>dddd</div>

</td>
</tr>

</table>


<div class="content" > 
<div id="content_stock"><?php if(is_array($stocklist)) foreach($stocklist as $stock) { ?><div id="cc<?php echo $stock['id'];?>" >

 
<iframe width=100% height=460 frameborder=1 src="source/plugin/stock/candle.inc.php?fdataid=<?php echo $userfile_name;?>&amp;mainmap=1"></iframe>

</div>

<table width=100% height="5" cellspacing="1" cellpadding="1" border="1"  style=" " >
<?php echo $test;?><?php echo $test1;?><?php echo $userfile_name;?>
    <tr >  <!--style="height:170px;"    -->
<td></td>
    </tr>
   
 
</table>
  </div>
  <?php } ?>   
</div>


</div>
</div></div></div>

<?php } elseif($_GET['mod'] == 'drawjs_b') { ?>

<form action="plugin.php?id=stock&amp;mod=drawjs" method="post">
      <ul class="tb cl"> 

 <!--       <li><input name="stock_code" type="text" id="stock_code" style="width:50px;" value="600320" /></li>
 <option value="000001.ss" <?php if($_GET['stock_code'] == '000001.ss') { ?>  -- >selected="selected"<!--<?php } ?>-- >>上证指数(000001.ss)</option>
 -->
 
<li>
<select name="stock_code" id="stock_code" title = '暂时只能提供部分演示数据，请谅解！' onchange="document.getElementById('stock_name').value=this.options[this.selectedIndex].text" >

<option value="510050.ss" <!--<?php if($_GET['stock_code'] == '510050.ss') { ?>selected="selected"<?php } ?>>50ETF(510050)</option>
<option value="601288.ss" <?php if($_GET['stock_code'] == '601288.ss') { ?>selected="selected"<?php } ?>>农业银行(601288)</option>
<option value="600320.ss" <?php if($_GET['stock_code'] == '600320.ss') { ?>selected="selected"<?php } ?>>振华重工(600320)</option>
<option value="^hsi" <?php if($_GET['stock_code'] == '^hsi') { ?>selected="selected"<?php } ?>>恒生指数(HSI)</option>
<option value="smn" <?php if($_GET['stock_code'] == 'smn') { ?>selected="selected"<?php } ?>>基础材料ETF-Pr(SMN)</option>
<option value="aapl" <?php if($_GET['stock_code'] == 'aapl') { ?>selected="selected"<?php } ?>>苹果(AAPL)</option>
<option value="tsla" <?php if($_GET['stock_code'] == 'tsla') { ?>selected="selected"<?php } ?>>特斯拉(TSLA)</option>
<option value="^GSPC" <?php if($_GET['stock_code'] == '^GSPC') { ?>selected="selected"<?php } ?>>标普500(S&P 500) </option>

</select>
</li>
<input type="hidden" name="stock_name" id="stock_name" value="<?php if(!empty($_GET['stock_name'])) { ?><?php echo $_GET['stock_name'];?><?php } else { ?> <?php echo $_GET['stock_code'];?> <?php } ?>" />
 <script>
 document.getElementById('stock_name').value=document.getElementById('stock_code').options[this.selectedIndex].text;
  document.getElementById("stock_code").fireEvent("onchange");		
</script>   

<!-- 暂时无数据
<option value="min1"<?php if($_GET['cycle'] == 'min1') { ?>-- >selected="selected"<!--<?php } ?>-- >>1分钟</option>
<option value="min5"<!--<?php if($_GET['cycle'] == 'min5') { ?>-- >selected="selected"<!--<?php } ?>-- >>5分钟</option>
<option value="min30"<!--<?php if($_GET['cycle'] == 'min30') { ?>-- >selected="selected"<!--<?php } ?>-- >>30分钟</option>
<option value="min60"<!--<?php if($_GET['cycle'] == 'min60') { ?>-- >selected="selected"<!--<?php } ?>-- >>60分钟</option>
-->
<li>
<div>
<select name="cycle" id="cycle"  title = '暂时只能提供日线、周线、月线数据，请谅解！' >
<option value="d" <!--<?php if($_GET['cycle'] == 'd') { ?>selected="selected"<?php } ?>>日</option>
<option value="w"<?php if($_GET['cycle'] == 'w') { ?>selected="selected"<?php } ?>>周</option>
<option value="m"<?php if($_GET['cycle'] == 'm') { ?>selected="selected"<?php } ?>>月</option>
</select>
        </div>
</li>
<li>

<div>
<select name="chart_numbers" id="cycle" disabled='disabled' title = '此功能调试中，请谅解！'>
<option value="1">1图组合</option>
<option value="2" selected="selected">2图组合</option>
<option value="3" >3图组合</option>
<option value="4">4图组合</option>
<option value="5">5图组合</option>
<option value="6">6图组合</option>
<option value="7">7图组合</option>
</select>
</div>			
</li>
<li>
<button type="submit" id="Submit_demo"  value="true" name="Submit_demo" tabindex="1"><span>确定</span></button>
<!--		<button id="bak2">备用按钮2</button>
<button id="bak3">备用按钮3</button>
<button id="bak4">备用按钮4</button>
-->		
</li>
<li>  <?php echo $ShowIeBugMessage;?> 
</li>
        <li style="float:right;"<?php if($_GET['mod'] == 'add_Formula') { ?> class="current"<?php } ?>><a href="plugin.php?id=stock&amp;mod=add_Formula">新增公式代码</a></li>
</ul>
</form>

<table width=100%  cellspacing="0" cellpadding="0" border="0"  style=" " >
<tr>	
<td width=80%'>
<?php echo $make_chart['0'];?>
<!--x{x <?php echo $make_chart['1'];?>}
{<?php echo $make_chart['2'];?> }-->
<!-- 
<iframe width=100% height=460 frameborder=0 src="source/plugin/stock/drawjs.inc.php?fdataid=<?php echo $short_name;?>&amp;mainmap=1"></iframe>
-->	
</td>
<td>
<div>公式名称</div>
<div><?php echo $check['formulaname'];?></div>
<div>使用说明</div>
<div><?php echo $check['comment'];?></div>
<div></div>
<div></div>
<div></div>
<div></div>
<div></div>
<div></div>
</td>
</tr>

</table>
<?php echo $test;?>  <?php echo $test1;?>
<?php } elseif($_GET['mod'] == 'add_Formula') { ?>




<h1 class="mt"><strong>&nbsp;新增公式代码</strong></h1>
<div class="content">
<div class="datalist">
<form action="plugin.php?id=stock&amp;mod=add_Formula" method="post">
<input type="hidden" name="formhash" id="formhash" value="<?php echo FORMHASH;?>" />
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td align="left"><input name="formulaname" type="text" class="px" id="formulaname" onchange="checkLength(this,16);" onkeyup="checkLength(this,16);" size="20" style="width:200px; height:40px;font-size:22px;"/>  
</td>
<td><font size="4">公式名称</font>
</td>
<td><font size="2">请输入公式名称，尽量使用英文，命名规则详见：xxx。</font>
</td>
</tr>

<tr>
<td align="left"><input name="description" type="text" class="px" id="description" onchange="checkLength(this,100);" onkeyup="checkLength(this,100);" size="20" style="width:200px; height:40px;font-size:22px;"/>  
</td>
<td><font size="4">公式描述</font>
</td>
<td><font size="2">请输入公式简要描述，限100个字. 命名规则详见：xxx。</font>
</td>
</tr>
<!--  checkbox 值为数组   先用 radio --> 	
<tr>
   <td><font size="4">是否在主图显示&nbsp&nbsp&nbsp</font><input type="radio" name="mainmap" id="mainmap" value="1" /><font size="4">是&nbsp&nbsp&nbsp</font>
   
   <input type="radio" name="mainmap" id="mainmap" value="2" checked="checked"/>
   <font size="4">否</font></td>
<!--	
<td align="center"><input name="mainmap" type="checkbox" class="px" id="mainmap" size="20" style="width:200px; height:40px;font-size:22px;"/>  
</td>-->
<td><font size="4">主图叠加</font>
</td>
<td><font size="2">该指标是否在主图上显示。详见：xxx。</font>
</td>
</tr>


<tr class="colplural"> 
 <td colspan="3" align="left"><font size="4">注释及用法&nbsp</font><font size="2"> 请尽可能详细的介绍公式各参数的详细说明及使用方法</size>
 </td>
 
</tr>
<tr class="colplural"> 
  <td colspan="2" align="left">
  <textarea name="comment" rows="10" cols="30" id="comment"   style="width:570px; height:240px;font-size:22px;"  ></textarea>
  <td></td>
</tr>

 <tr class="colplural"> 
 <td colspan="3" align="left"><font size="4">公式代码</font>
 </td>
 
 </tr>
 <tr class="colplural"> 
  <td colspan="3" align="left">

 <textarea name="formula" rows="10" cols="30" id="formula"  style="width:370px; height:240px;font-size:22px;"  ></textarea>  
  
  <script>
  var editor = CodeMirror.fromTextArea(document.getElementById("formula"), {
    lineNumbers: true,
    styleActiveLine: true,
    matchBrackets: true
 
  });
  //使用主题
     editor.setOption("theme", "ambiance");	
 editor.setOption("font-size", "20px");	
/*
  var input = document.getElementById("select");
  function selectTheme() {
    var theme = input.options[input.selectedIndex].innerHTML;
    editor.setOption("theme", theme);
  }
  var choice = document.location.search &&
               decodeURIComponent(document.location.search.slice(1));
  if (choice) {
    input.value = choice;
    editor.setOption("theme", choice);
  }
  */
</script>
  
  
  
  
 </td>
 
  </tr>
<tr>
 		<td>

您还可以输入<span id="chLeft"></span>字
<td>
</td>
<td>
</td>
</tr>
</table>
<table> 

    <td align="center"><button type="submit" id="Submit_member" class="pn pnc" value="true" name="Submit_member" tabindex="1"><span>发表指标公式</span></button></td>
  </tr>
</table>
</form>

</div></div></div></div></div>

<?php } elseif($_GET['mod'] == 'user_formula') { ?>
<div class="content datalist">
<form action="plugin.php?id=stock&amp;mod=user_formula" method="post">
<input type="hidden" name="formhash" id="formhash" value="<?php echo FORMHASH;?>" />
<table width="100%" cellpadding="0" cellspacing="0">
  <tr class="colplural" align="center">
    <td width="3%">&nbsp;</td>
    <td width="5%">公式ID</td>
    <td width="12%">公式名称</td>
<td width="55%">公式描述</td>
<td width="7%">热度</td>
    <td width="10%">发表时间</td>
    <td width="5%">&nbsp;</td>
  </tr>
<?php if($stocklist_user) { ?>
  <?php if(is_array($stocklist_user)) foreach($stocklist_user as $stock_user) { ?>  <tr align="left">
    <td width="3%"><input type="checkbox" name="delete[]" value="<?php echo $stock_user['id'];?>" /></td>
    <td width="5%"><?php echo $stock_user['id'];?></td>
    <td width="12%"><?php echo $stock_user['formulaname'];?></td>
<td width="55%"><?php echo $stock_user['description'];?></td>
<td width="7%" align="right"><?php echo $stock_user['hots'];?></td>
    <td width="10%"><?php echo $stock_user['dateline'];?></td> 
    <td width="5%"><a href="plugin.php?id=stock&amp;mod=edit_formula&amp;stockid=<?php echo $stock_user['id'];?>">编辑</a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="6">
<!--this.form-->
    <?php if(!empty($multipage)) { ?><div class="pages_btns"><?php echo $multipage;?></div><?php } ?>
    <input class="checkbox" type="checkbox" id="chkall" name="chkall" onclick="checkall(delete[])" />&nbsp;全选&nbsp;
    <button type="submit" id="del_formula" class="pn" value="true" name="del_formula" tabindex="1"><span>删除已选的公式</span></button>
<button type="submit" id="test " class="pn" value="true" name="testsubmit" tabindex="1"><span>test</span></button>

<button type="button" id="add_Formula " class="pn" value="true" name="add_Formula"><a href="plugin.php?id=stock&amp;mod=add_Formula">新增公式代码</a></button>

</td>
<td></td>
  </tr>
<?php } else { ?>
  <tr>
    <td colspan="6" align="center">您还没有已登记的公式！</td>
  </tr>
<?php } ?>
</table>
</form>
</div></div></div>





<?php } elseif($_GET['mod'] == 'edit_formula') { ?>
<div class="content datalist">
<form id="form1" method="post" action="plugin.php?id=stock&amp;mod=edit_formula">
<?php if($stocklist_edit) { if(is_array($stocklist_edit)) foreach($stocklist_edit as $stock_edit) { ?><input type="hidden" name="formhash" id="formhash" value="<?php echo FORMHASH;?>" />
<div id="container">


<div id="header">
<div class="STYLE2" id="chart">测试绘图区</div> 		
<div class="STYLE2" id="txtHint"></div> 	
</div>
<div id="prompt"><h2>当前编辑公式编号:&nbsp<?php echo $_GET['stockid'];?> &nbsp</h2> &nbsp

<input name="formulaname" type="text" class="px" id="formulaname" value="<?php echo $stock_edit['formulaname'];?>" onchange="checkLength(this,16);" onkeyup="checkLength(this,16);" size="8" style="width:120px; height:20px;font-size:12px;"/>公式名称
<div class='remarks'>&nbsp 不超过15个字符，公式命名规则详见：xxx。</div>&nbsp
<input name="description" type="text" class="px" id="description" value="<?php echo $stock_edit['description'];?>" onchange="checkLength(this,20);" onkeyup="checkLength(this,20);" size="8" style="width:120px; height:20px;font-size:12px;"/>公式描述
<div class='remarks'>&nbsp 公式中文名称或简要描述，限20个字. 命名规则详见：xxx。</div>&nbsp
<br>&nbsp
<input type="radio" name="mainmap" id="mainmap" value="1" <?php if($stock_edit['mainmap'] == 1) { ?>checked="checked"<?php } ?>/>在主图上叠加&nbsp&nbsp&nbsp
<input type="radio" name="mainmap" id="mainmap" value="2" <?php if($stock_edit['mainmap'] == 2) { ?>checked="checked"<?php } ?>/>副图显示&nbsp&nbsp&nbsp<br>&nbsp
<input type="radio" name="Permission" id="Permission" value="1" <?php if($stock_edit['Permission'] == 1) { ?>checked="checked"<?php } ?>/>允许源码公开&nbsp&nbsp&nbsp
   	<input type="radio" name="Permission" id="Permission" value="2" <?php if($stock_edit['Permission'] == 2) { ?>checked="checked"<?php } ?>/>源码保密&nbsp&nbsp&nbsp<br>
&nbsp注释及用法&nbsp
 <textarea name="comment" rows="7" cols="30" id="comment"   style="width:98%; height:78px;font-size:12px;"  ><?php echo $stock_edit['comment'];?></textarea>
   </div>
<div id="menu1">

<textarea name="formula"  id="formula"   ><?php echo $stock_edit['formula'];?></textarea>
</div>

<div id="content">
<input type="button" onclick="submitparser();" id="parser_it" name="parser_it" value=" 测试 " style="width:100  height:118px; font-size:22px;"/>
<input type="button" onclick="submitdraw();" name="draw_it" value=" 绘图 " style="width:100  height:118px; font-size:22px;" /><br>
<button type="submit" id="Submit_edit" value="true" name="Submit_edit" tabindex="1" style=" font-size:22px;" disabled= 'disable'; title='保存前请先点测试按钮！'><span>&nbsp保存指标公式 </span></button>
<div >&nbsp&nbsp常用函数  &nbsp&nbsp&nbsp 更多函数 此处另作treeview</div>
<select name="func" size="10" onclick="addfunc(this.value)">
<option value="ma(c,5)" selected="selected">ma(,n)   </option>
<option value="REF(c,1)">ref(x,n) </option>
<option value="abs(c)">abs(x)     </option>
<option value="">abcdefghigklmnopqrstuvwxyz     </option>
<option value=""></option>
<option value=""></option>
<option value=""></option>
<option value=""></option>
</select>
</div>


<div id="footer">
<div>
<textarea name="after_parser" type="hidden" rows="10" cols="30" id="after_parser"   style="width:570px; height:40px;font-size:12px;"  ></textarea>
<!--此处向js传递用户id, 为了生成JSON文件名  type="hidden" -->
<input type="hidden"  name="uid"  id="uid" style="width:50px;" value=<?php echo $_G['uid'];?> />
<input name="stockid" type="hidden"  class="px" id="stockid" value="<?php echo $_GET['stockid'];?>" size="8" style="width:20px; height:20px;font-size:12px;"/>
</div>
</div>

</div>



<!--**********************************************************************************-->
 
  
  <script>
  var editor = CodeMirror.fromTextArea(document.getElementById("formula"), {
    lineNumbers: true,
    styleActiveLine: true,
    matchBrackets: true,
    //         mode: "text/html",
            tabMode: "indent",
            width: '100%',
            height: '1500px',
            autoMatchParens: true,
            textWrapping: true,
            lineNumbers: true,
lineWrapping:true
  });
  //使用主题
     editor.setOption("theme", "ambiance");	
 editor.setOption("font-size", "20px");	
 
</script>
  
  
  
  

<!--
<input type="button" onclick="submitcontent();" name="test_it" value="    测试     " />
<input type="button" onclick="submitcontent_old();" value="    old测试     " />
<input type="button" onclick="submitparser();" name="parser_it" value="    测试解析     " />
<input type="button" onclick="submitdraw();" name="draw_it" value="    DRAW    " />

  <tr>
    <td colspan="3" align="center"><button type="submit" id="Submit_edit1" class="pn" value="true" name="Submit_edit1" tabindex="1"><span>编辑指标公式</span></button></td>
  </tr>
-->
 <!--************************************** 
  <!--************************************************************************-->
  <?php } } ?>

</form>
<script type="text/javascript">checkLength(document.getElementById('message'));</script>
</div></div></div>

<?php } elseif($_GET['mod'] == 'members_formula') { ?>
<div class="content datalist">
<table width="100%" cellpadding="0" cellspacing="0">

  <tr class="colplural" align="center">
    <td width="5%">公式ID</td>
    <td width="12%">公式名称</td>
<td width="53%">公式描述</td>
<td width="5%">热度</td>
    <td width="9%">发表时间</td>
<td width="13%">公式发布者</td>
   </tr>


<?php if($stocklist_members) { ?>
  <?php if(is_array($stocklist_members)) foreach($stocklist_members as $stock_members) { ?> 
   <tr align="left">
    <td width="5%"><?php echo $stock_members['id'];?></td>
    <td width="12%" title ="<?php echo $stock_members['comment'];?>"><?php echo $stock_members['formulaname'];?></td>
<td width="53%" title ="<?php echo $stock_members['comment'];?>"><?php echo $stock_members['description'];?></td>
<td width="5%" align="right"><?php echo $stock_members['hots'];?></td>
    <td width="9%"><?php echo $stock_members['dateline'];?></td> 
<td width="13%" align="left">&nbsp;<img src="<?php echo $_G['setting']['ucenterurl'];?>/avatar.php?uid=<?php echo $stock_members['uid'];?>&size=small" border="0" height="24" width="24"> <a href="<?php echo $_G['siteurl'];?>?<?php echo $stock_members['uid'];?>" target="_blank"><?php echo $stock_members['username'];?></a></td></a></td>
  </tr>
 
 

  </tr>
  <?php } ?>
  <?php if(!empty($multipage)) { ?>
  <tr><td colspan="5"><div class="pages_btns"><?php echo $multipage;?></div></td></tr><?php } } else { ?>
  <tr>
    <td colspan="5" align="center">没有坛友公式登记记录！</td>
  </tr>
<?php } ?>

</table>
<?php if($_G['adminid'] == '1') { ?>
        <li<?php if($_GET['mod'] == 'admin_check') { ?> class="current"<?php } ?>><a href="plugin.php?id=stock&amp;mod=admin_check">公式管理</a></li>
        <?php } ?>
</div></div></div>

<?php } elseif($_GET['mod'] == 'admin_check') { ?>
<h1 class="mt"><strong>&nbsp;指标公式管理</strong></h1>
<div class="content datalist">
<form action="plugin.php?id=stock&amp;mod=admin_check" method="post">
<input type="hidden" name="formhash" id="formhash" value="<?php echo FORMHASH;?>" />
<table width="100%" cellpadding="0" cellspacing="0">

  <tr class="colplural" align="center">
    <td width="3%">&nbsp;</td>
    <td width="5%">公式ID</td>
    <td width="15%">公式名称</td>
<td width="55%">公式描述</td>
<td width="7%">热度</td>
    <td width="10%">发表时间</td>
    <td width="5%">&nbsp;</td>
  </tr>

<?php if($stocklist_admin) { ?>
  <?php if(is_array($stocklist_admin)) foreach($stocklist_admin as $stock_admin) { ?> <tr align="left">
    <td width="3%"><input type="checkbox" name="delete[]" value="<?php echo $stock_user['id'];?>" /></td>
    <td width="5%"><?php echo $stock_admin['id'];?></td>
    <td width="15%"><?php echo $stock_admin['formulaname'];?></td>
<td width="55%"><?php echo $stock_admin['description'];?></td>
<td width="7%" align="right"><?php echo $stock_admin['hots'];?></td>
    <td width="10%"><?php echo $stock_admin['dateline'];?></td> 
    <td width="5%"><a href="plugin.php?id=stock&amp;mod=edit_formula&amp;stockid=<?php echo $stock_admin['id'];?>">编辑</a></td>
  </tr>



  <?php } ?>
  <tr>
    <td colspan="6">
    <?php if(!empty($multipage)) { ?><div class="pages_btns"><?php echo $multipage;?></div><?php } ?>
    <input class="checkbox" type="checkbox" id="chkall" name="chkall" onclick="checkall(this.form)" />&nbsp;全选&nbsp;
    <button type="submit" id="admin_edit" class="pn" value="true" name="admin_del" tabindex="1"><span>删除已选的公式</span></button></td>
  </tr>
<?php } else { ?>
  <tr>
    <td colspan="6" align="center">指标公式上并没有留言！</td>
  </tr>
<?php } ?>
</table>
</form>
</div></div></div>
<?php } ?>
<!--  	</div>
<?php if(empty($topic) || ($topic['usefooter'])) { $focusid = getfocus_rand($_G[basescript]);?><?php if($focusid !== null) { $focus = $_G['cache']['focus']['data'][$focusid];?><?php $focusnum = count($_G['setting']['focus'][$_G[basescript]]);?><div class="focus" id="sitefocus">
<div class="bm">
<div class="bm_h cl">
<a href="javascript:;" onclick="setcookie('nofocus_<?php echo $_G['basescript'];?>', 1, <?php echo $_G['cache']['focus']['cookie'];?>*3600);$('sitefocus').style.display='none'" class="y" title="关闭">关闭</a>
<h2>
<?php if($_G['cache']['focus']['title']) { ?><?php echo $_G['cache']['focus']['title'];?><?php } else { ?>站长推荐<?php } ?>
<span id="focus_ctrl" class="fctrl"><img src="<?php echo IMGDIR;?>/pic_nv_prev.gif" alt="上一条" title="上一条" id="focusprev" class="cur1" onclick="showfocus('prev');" /> <em><span id="focuscur"></span>/<?php echo $focusnum;?></em> <img src="<?php echo IMGDIR;?>/pic_nv_next.gif" alt="下一条" title="下一条" id="focusnext" class="cur1" onclick="showfocus('next')" /></span>
</h2>
</div>
<div class="bm_c" id="focus_con">
</div>
</div>
</div><?php $focusi = 0;?><?php if(is_array($_G['setting']['focus'][$_G['basescript']])) foreach($_G['setting']['focus'][$_G['basescript']] as $id) { ?><div class="bm_c" style="display: none" id="focus_<?php echo $focusi;?>">
<dl class="xld cl bbda">
<dt><a href="<?php echo $_G['cache']['focus']['data'][$id]['url'];?>" class="xi2" target="_blank"><?php echo $_G['cache']['focus']['data'][$id]['subject'];?></a></dt>
<?php if($_G['cache']['focus']['data'][$id]['image']) { ?>
<dd class="m"><a href="<?php echo $_G['cache']['focus']['data'][$id]['url'];?>" target="_blank"><img src="<?php echo $_G['cache']['focus']['data'][$id]['image'];?>" alt="<?php echo $_G['cache']['focus']['data'][$id]['subject'];?>" /></a></dd>
<?php } ?>
<dd><?php echo $_G['cache']['focus']['data'][$id]['summary'];?></dd>
</dl>
<p class="ptn cl"><a href="<?php echo $_G['cache']['focus']['data'][$id]['url'];?>" class="xi2 y" target="_blank">查看 &raquo;</a></p>
</div><?php $focusi ++;?><?php } ?>
<script type="text/javascript">
var focusnum = <?php echo $focusnum;?>;
if(focusnum < 2) {
$('focus_ctrl').style.display = 'none';
}
if(!$('focuscur').innerHTML) {
var randomnum = parseInt(Math.round(Math.random() * focusnum));
$('focuscur').innerHTML = Math.max(1, randomnum);
}
showfocus();
var focusautoshow = window.setInterval('showfocus(\'next\', 1);', 5000);
</script>
<?php } if($_G['uid'] && $_G['member']['allowadmincp'] == 1 && $_G['setting']['showpatchnotice'] == 1) { ?>
<div class="focus patch" id="patch_notice"></div>
<?php } ?><?php echo adshow("footerbanner/wp a_f/1");?><?php echo adshow("footerbanner/wp a_f/2");?><?php echo adshow("footerbanner/wp a_f/3");?><?php echo adshow("float/a_fl/1");?><?php echo adshow("float/a_fr/2");?><?php echo adshow("couplebanner/a_fl a_cb/1");?><?php echo adshow("couplebanner/a_fr a_cb/2");?><?php echo adshow("cornerbanner/a_cn");?><?php if(!empty($_G['setting']['pluginhooks']['global_footer'])) echo $_G['setting']['pluginhooks']['global_footer'];?>
<div id="ft" class="wp cl">
<div id="flk" class="y">
<p>
<?php if($_G['setting']['site_qq']) { ?><a href="http://wpa.qq.com/msgrd?V=3&amp;Uin=<?php echo $_G['setting']['site_qq'];?>&amp;Site=<?php echo $_G['setting']['bbname'];?>&amp;Menu=yes&amp;from=discuz" target="_blank" title="QQ"><img src="<?php echo IMGDIR;?>/site_qq.jpg" alt="QQ" /></a><span class="pipe">|</span><?php } if(is_array($_G['setting']['footernavs'])) foreach($_G['setting']['footernavs'] as $nav) { if($nav['available'] && ($nav['type'] && (!$nav['level'] || ($nav['level'] == 1 && $_G['uid']) || ($nav['level'] == 2 && $_G['adminid'] > 0) || ($nav['level'] == 3 && $_G['adminid'] == 1)) ||
!$nav['type'] && ($nav['id'] == 'stat' && $_G['group']['allowstatdata'] || $nav['id'] == 'report' && $_G['uid'] || $nav['id'] == 'archiver' || $nav['id'] == 'mobile'))) { ?><?php echo $nav['code'];?><span class="pipe">|</span><?php } } ?>
<strong><a href="<?php echo $_G['setting']['siteurl'];?>" target="_blank"><?php echo $_G['setting']['sitename'];?></a></strong>
<?php if($_G['setting']['icp']) { ?>( <a href="http://www.miitbeian.gov.cn/" target="_blank"><?php echo $_G['setting']['icp'];?></a> )<?php } ?>
<?php if(!empty($_G['setting']['pluginhooks']['global_footerlink'])) echo $_G['setting']['pluginhooks']['global_footerlink'];?>
<?php if($_G['setting']['statcode']) { ?><?php echo $_G['setting']['statcode'];?><?php } ?>
</p>
<p class="xs0">
GMT<?php echo $_G['timenow']['offset'];?>, <?php echo $_G['timenow']['time'];?>
<span id="debuginfo">
<?php if(debuginfo()) { ?>, Processed in <?php echo $_G['debuginfo']['time'];?> second(s), <?php echo $_G['debuginfo']['queries'];?> queries
<?php if($_G['gzipcompress']) { ?>, Gzip On<?php } if(C::memory()->type) { ?>, <?php echo ucwords(C::memory()->type); ?> On<?php } ?>.
<?php } ?>
</span>
</p>
</div>
<div id="frt">
<p>Powered by <strong><a href="http://www.discuz.net" target="_blank">Discuz!</a></strong> <em><?php echo $_G['setting']['version'];?></em><?php if(!empty($_G['setting']['boardlicensed'])) { ?> <a href="http://license.comsenz.com/?pid=1&amp;host=<?php echo $_SERVER['HTTP_HOST'];?>" target="_blank">Licensed</a><?php } ?></p>
<p class="xs0">&copy; 2001-2012 <a href="http://www.comsenz.com" target="_blank">Comsenz Inc.</a></p>
</div><?php updatesession();?><?php if($_G['uid'] && $_G['group']['allowinvisible']) { ?>
<script type="text/javascript">
var invisiblestatus = '<?php if($_G['session']['invisible']) { ?>隐身<?php } else { ?>在线<?php } ?>';
var loginstatusobj = $('loginstatusid');
if(loginstatusobj != undefined && loginstatusobj != null) loginstatusobj.innerHTML = invisiblestatus;
</script>
<?php } ?>
</div>

<?php if($upgradecredit !== false) { ?>
<div id="g_upmine_menu" class="tip tip_3" style="display:none;">
<div class="tip_c">
积分 <?php echo $_G['member']['credits'];?>, 距离下一级还需 <?php echo $upgradecredit;?> 积分
</div>
<div class="tip_horn"></div>
</div>
<?php } } if(!$_G['setting']['bbclosed']) { if($_G['uid'] && !isset($_G['cookie']['checkpm'])) { ?>
<script src="home.php?mod=spacecp&ac=pm&op=checknewpm&rand=<?php echo $_G['timestamp'];?>" type="text/javascript"></script>
<?php } if($_G['uid'] && helper_access::check_module('follow') && !isset($_G['cookie']['checkfollow'])) { ?>
<script src="home.php?mod=spacecp&ac=follow&op=checkfeed&rand=<?php echo $_G['timestamp'];?>" type="text/javascript"></script>
<?php } if(!isset($_G['cookie']['sendmail'])) { ?>
<script src="home.php?mod=misc&ac=sendmail&rand=<?php echo $_G['timestamp'];?>" type="text/javascript"></script>
<?php } if($_G['uid'] && $_G['member']['allowadmincp'] == 1 && !isset($_G['cookie']['checkpatch'])) { ?>
<script src="misc.php?mod=patch&action=checkpatch&rand=<?php echo $_G['timestamp'];?>" type="text/javascript"></script>
<?php } } if($_GET['diy'] == 'yes') { if(check_diy_perm($topic) && (empty($do) || $do != 'index')) { ?>
<script src="<?php echo $_G['setting']['jspath'];?>common_diy.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<script src="<?php echo $_G['setting']['jspath'];?>portal_diy<?php if(!check_diy_perm($topic, 'layout')) { ?>_data<?php } ?>.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php } if($space['self'] && CURMODULE == 'space' && $do == 'index') { ?>
<script src="<?php echo $_G['setting']['jspath'];?>common_diy.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<script src="<?php echo $_G['setting']['jspath'];?>space_diy.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php } } if($_G['uid'] && $_G['member']['allowadmincp'] == 1 && $_G['setting']['showpatchnotice'] == 1) { ?>
<script type="text/javascript">patchNotice();</script>
<?php } if($_G['uid'] && $_G['member']['allowadmincp'] == 1 && empty($_G['cookie']['pluginnotice'])) { ?>
<div class="focus plugin" id="plugin_notice"></div>
<script type="text/javascript">pluginNotice();</script>
<?php } if($_G['member']['newprompt'] && (empty($_G['cookie']['promptstate_'.$_G['uid']]) || $_G['cookie']['promptstate_'.$_G['uid']] != $_G['member']['newprompt']) && $_GET['do'] != 'notice') { ?>
<script type="text/javascript">noticeTitle();</script>
<?php } userappprompt();?><?php if($_G['basescript'] != 'userapp') { ?>
<span id="scrolltop" onclick="window.scrollTo('0','0')">返回顶部</span>
<script type="text/javascript">_attachEvent(window, 'scroll', function(){showTopLink();});checkBlind();</script>
<?php } output();?></body>
</html>
 -->