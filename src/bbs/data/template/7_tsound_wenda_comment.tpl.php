<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('tsound_wenda:header'); ?><link href="./source/plugin/tsound_wenda/template/images/detail.combo.css" rel="stylesheet" type="text/css">

<!--类淘宝星级评分开始  by TT  不好用，求助！！！ -->

<style>
.wd_other {
  margin-top:10px;
}
.wd_other li {
  margin-left: 25px;
  border-bottom: 1px dashed #BBB;
  padding: 5px 0;
}
.wd_other li .wd_l{
  display: inline;
  float: left;
  line-height: 24px;
}
.wd_other li .c_f{
  color: #5EBB0B;
}
.wd_other li .c_a{
  color: #999;
}
.wd_other li .c_b{
  color: blue;
}
.wd_other li .wd_r{
  margin-left: 20px;
  display: inline;
  float: left;
  line-height: 24px;
}
.wd_other li .wd_cl{
  clear:both;
}
.addsound{
  position: relative;
  top: -5px;
  color:#666666;
  text-decoration:none;
}
.addsound:hover{
  color:#666666;
  text-decoration:underline;
}
</style>
<div id="bd" class="grid-3 clearfix"  >
<div id="qarticle" class="article" id="js-detail">
<div class="mod-question js-form">
<div class="hd"><span class="ico <?php echo $resloved;?>"></span><!--评分状态图标resloved 已点评-->
<h3 class="title"><?php echo $Q['title'];?></h3>
<span class="cate">[ <a href="<?php echo $baseurl;?>&action=selectlesson&cid=<?php echo $Q['cid'];?>"><?php echo $Q['cname'];?></a>]</span>
<input type="hidden" value="<?php echo $Q['title'];?>" id="js-ask-title">
<?php if($Q['coin']>=$tsound_wenda['high'] ) { ?>
<span class="ico-emergency"></span>
<?php } ?>
<span class="">[
<a href="<?php echo $baseurl;?>&action=task&lessonid=<?php echo $Q['lessonid'];?>&cid=<?php echo $Q['cid'];?>">查看原课文</a>]</span>
<!--
<span class="wealth"><?php echo $Q['coin'];?></span>
-->
<div class="label"><a target="_blank" href="home.php?mod=space&amp;uid=<?php echo $Q['uid'];?>" class="author" id="ask-author"><?php echo $Q['username'];?></a>&nbsp;|&nbsp;<span class="pubtime"><?php echo $time;?></span>&nbsp;|&nbsp;
<!--
<span>分类:<a href="<?php echo $baseurl;?>&action=category">全部语音</a> <?php echo $where;?>  </span>
-->
</div>
<br/>
  </div>
  <div class="bd">
<div class="mod-added-q js-added-area">
<?php echo $Q['content']['0'];?>　<!--语音-->
</div>
<?php if(!empty($UserScore['avgscore'])) { ?>
<div>
评分次数:      	<?php echo $UserScore['scorecount'];?> 	<br/>
平均分数:		<?php echo $UserScore['avgscore'];?> 	<br/>
最高分数:    	<?php echo $UserScore['maxscore'];?>	<br/><br/>		
</div>
<?php } ?>	
  </div>
  <div class="ft"><!--补充按钮-->
<?php echo $Q['content']['1'];?> 
  </div>
  <div style ="font-size:14px;color:red;">
  &nbsp&nbsp&nbsp&nbsp 举报 删除功能编写中...
   <a href="<?php echo $baseurl;?>&action=delete&qid=<?php echo $Q['qid'];?>&reason=9">普通用户使用: 举报该作业</a> 
   
  </div>
</div>
    





    <?php if($_G['uid'] && !$A) { ?>
<div class="mod-answer-form js-form" style="background-color: #FFF;">




<div class="hd">

<h4>管理专用:</h4>	    
<?php if($showscore  || 1<2 ) { ?> <!--允许指定用户组删除 调试期间增加 || 1<2 -->
<div style="clear:both;font-size:14px;">
&nbsp&nbsp&nbsp&nbsp
<a href="<?php echo $baseurl;?>&action=delete&qid=<?php echo $Q['qid'];?>&reason=1">语音质量太差,删除</a>&nbsp&nbsp&nbsp&nbsp
<a href="<?php echo $baseurl;?>&action=delete&qid=<?php echo $Q['qid'];?>&reason=2">语音内容违规,删除</a>
</div>	
<?php } ?>	
<h4>我来点评:</h4>					
</div>
<div class="bd"  >
<form id="editform" method="post" type="0" onsubmit="return checkform()">
<textarea name="content" id="content"  class="textarea js-editor " style="width: 568px;border:1px solid #3db40c"></textarea>
<div id="js-answer-error" class="erro js-form-error"></div>
<input name="qid" type="hidden" value="<?php echo $Q['qid'];?>">
<input name="cid" type="hidden" value="<?php echo $Q['cid'];?>">
<input name="rid" id="rid" type="hidden" value="">
<div class="soundbtn" style="float:left;padding-top:0px">
<span class="addimg">
<!-- { <?php echo $flash;?> } 添加图片 -->
<a href="<?php echo $baseurl;?>&action=insert" onclick="showWindow('tsound_wenda', this.href)" class="addsound"><img src="./source/plugin/tsound_wenda/template/images/tsound_small.png" align="absmiddle" />添加语音</a>
</span>
<span id="playerbox"></span> <!--语音点评回放-->
</div>
<?php if($showscore  || 1<2 ) { ?> <!--允许指定用户组评分 调试期间增加 || 1<2 -->
<div style="clear:both;font-size:14px;">
<h4>我来打分</h4>

<input type="radio" name="score" id="score" value="1" /> 还需努力(1分)
<input type="radio" name="score" id="score" value="60" checked="checked" /> 闯关成功(60分)
<input type="radio" name="score" id="score" value="80" /> Well Done(80分)
<input type="radio" name="score" id="score" value="100" /> 非常完美(100分)

<h4>此处需换个更方便美观的评分组件</h4>
</div>	
<?php } ?>					
<div >
<span class="btn btn-2" style ='float:left;padding-left:435px' >
<button type="submit" id="submit" class="js-added-submit" text="answer-submit">提交点评</button>
</span>
</div>					
</form>
</div>
</div>
    <?php } ?>
    <?php if($A) { ?>
<div class="mod-answer-form" style="border-bottom:none;height:0px;"></div>
<div class="mod-answer-one mod-answer-best">
<div class="hd" style="background-color: #FFF;">
<h4>满意点评</h4>
<p class="pubtime"><?php echo $A['time'];?></p>
<div class="ico-best"></div>
</div>
<div class="bd" id="js-static-bestanswer" style="background-color: #FFF;">
<div class="content"><?php echo $A['content']['0'];?></div>
<div class="mod-add-answer-box">
<div class="mod-add-qa-list js-added-area" style="display:none;"></div>
</div>
</div>
<div class="ft" style="position: relative;">
<div class="vcard-user"><a target="_blank" href="home.php?mod=space&amp;uid=<?php echo $Q['uid'];?>" class="pic"><?php echo avatar($A['uid'],small);; ?></a>
<div class="text">
<p class="name"><a target="_blank" href="home.php?mod=space&amp;uid=<?php echo $Q['uid'];?>"><?php echo $A['username'];?></a></p>
<span class="wealth"><?php echo $A['money'];?></span>
</div>
</div>
<a style="display:none;" data-agree="0" class="btn btn-1 btn-zan "><span>0 </span></a><span class="tips js-ilike-tips">+1</span>
</div>
</div>

    <?php } ?>
<div class="mod-answer-list" id="answerList">
<div class="hd"  >
<h4><b>(<?php echo $answer_count;?>)</b>&nbsp;</h4>
<span class="ico "></span>
</div>
<div class="bd"   >
<p class="ask-q-time"><span></span></p>
<div class="mod-all-answer-list">
<ul class="list"><?php if(is_array($answers)) foreach($answers as $answer) { ?><li class="item js-form <?php echo $answer['odd'];?>">
<div class="date"><span><?php echo $answer['day'];?></span></div>
<div class="dot" title="<?php echo $answer['time'];?>"></div>
<div class="answer-detail  clearfix js-answer-region">
<div class="vcard"><a target="_blank" href="home.php?mod=space&amp;uid=<?php echo $answer['uid'];?>"><?php echo avatar($answer['uid'],small);; ?><?php echo $answer['username'];?><br/><font color=<?php echo $answer['titlecolor'];?>><?php echo $answer['grouptitle'];?></font></a>
</div>
<div class="content-box">
  <div class="mod-qa-content">
<div class="g-point g-point-left"><ins class="border"></ins><ins class="bg"></ins></div>
<div class="content"><?php echo $answer['content']['0'];?></div>
  </div>
  <?php echo $answer['content']['1'];?>
</div>
</div>
<div class="js-added-area" style="display:"></div>
</li>
<?php } ?>
</ul>
</div>
</div>
</div>
</div>
<div class="aside"  id="qaside"  > <?php include template('tsound_wenda:side'); ?></div>
</div>

<script type="text/javascript" reload="1">
function OnezUploadCall(s){
  if(s.substr(0,2)=='ok'){
    try{
      $('content2').value+=s.substr(2);
    }catch(e){
      $('content').value+=s.substr(2);
    }
    return;
  }
}
function checkform(){
  var content=$('content').value;
  var rid=$('rid').value;
  if(content.length<1){
    alert('请填写您的回复');
    $('content').focus();
    return false;
  }
<?php if($tsound_wenda['force2']) { ?>
  if(rid.length<1){
    alert('请录制语音');
    return false;
  }
<?php } ?>
  return true;
}
</script> <?php include template('tsound_wenda:footer'); ?>