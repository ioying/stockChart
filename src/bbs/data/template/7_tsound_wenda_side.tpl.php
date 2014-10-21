<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); $grzxmodule1 = 'source/plugin/tsound_wenda/include/include_grzx_module1.inc.php';?><?php if(file_exists ( $grzxmodule1 )) { ?>
<div class="mod-userinfo" id="mod-userinfo"  style="width:176px; background-color: #FFF; text-align: center;margin-bottom:10px;">
<div class="info"><a class="js-user-header pic" href="/u/53875339"><img
text="userinfo-pic"
src="uc_server/avatar.php?uid=<?php echo $_G['uid'];?>&amp;size=small"></a>
<div class="text">
 
<p>积分:&nbsp;<a class="js-user-coin wealth" href="/user/wealth/53875339"><?php echo $singuser['extcredits'.$credit]?></a></p>
 
</div>
</div>
<div class="status">
<table>
<tbody>
<tr>
<th class="first">点评数</th>
<th>采纳率</th>
<th>语音数</th>
</tr>
<tr>
<td class="first"><a class="js-user-answer-num"
href="javascrpt:;"><?php echo $singhds;?></a></td>
<td><a class="js-user-acc-num" target="_blank"
href="javascript:;"><?php echo sprintf("%.2f", $singcnl);?>%</a></td>
<td><a class="js-user-ask-num" href="javascript:;"><?php echo $singtws;?></a></td>
</tr>
</tbody>
</table>
</div>
<div class="qa-btn">
<ul class="clearfix">
<li class="asked"><a text="userinfo-myAsk"
class="js-user-ask-link" href="<?php echo $baseurl;?>&action=wdtw">我的语音</a></li>
<li class="answered"><a text="userinfo-myAnswer"
class="js-user-answer-link" href="<?php echo $baseurl;?>&action=wdhd">我点评的</a></li>
</ul>
</div>
</div>


<?php } ?>


<!--上传语音按钮-->
<div class="bm" style="width: 200px; background-color: #FFF; text-align: center">
<div class="bm_c"><font color="#A0A0A0">你不是一个人在学英语 </font><br>
<span class="new-q-holder"><a href="<?php echo $baseurl;?>&action=selectcourse">我要上传语音 </a></span></div>
</div>
<!--用户列表-->
<div class="mod-user-wealth-top"	style="width: 200px; background-color: #FFF;" id="mod-user-wealth-top">
<div class="hd">
<h3></h3>
<p class="date"></p>
</div>
<div class="bd">
<ul class="list"><?php if(is_array($side['users'])) foreach($side['users'] as $rs) { ?><li><span class="num no<?php echo $rs['index'];?>"><?php echo $rs['index'];?>&nbsp</span><a
href="home.php?mod=space&amp;uid=<?php echo $rs['uid'];?>" target="_blank" class="name"><?php echo $rs['username'];?>&nbsp</a><span
class="wealth"><?php echo $rs['credit'];?></span></li>
<?php } ?>
</ul>
</div>
</div>
