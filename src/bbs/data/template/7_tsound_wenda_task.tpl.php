<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('tsound_wenda:header'); ?><!-- 原有作废 重写css
<link href="./source/plugin/tsound_wenda/template/images/base.combo.css" rel="stylesheet" type="text/css">
<link href="./source/plugin/tsound_wenda/template/images/ask.combo.css" rel="stylesheet" type="text/css">
-->
<div id="bd1" class="grid-4 clearfix">
<div style="position: relative;" class="article">
<div class="mod-ask-form" style="margin: 0 65px;">
<div class="bd">
<div style="padding-top:10px">课程名称：<?php echo $row['lessontitle'];?>
</div>
<div style="padding-top:10px">示范朗读：<?php echo $flashDemo;?>	
</div>

<div style="padding-top:10px">英文原文： <?php echo $row['english'];?>
</div>
<div style="padding-top:10px">中文参考：<?php echo $row['Chinese'];?>
</div>
<div class="form clearfix"> <!--text-->
<form id="editform" method="post" onsubmit="return checkform()">
<input type="hidden" name="rid" id="rid" value="<?php echo $rid;?>" />
<input type="hidden" name="content" id="content" value="" />
<input type="hidden" name="lessonid" id="lessonid" value="<?php echo $row['lessonid'];?>" />
  
<div class="q-main">
  <textarea name="ask_title" id="ask_title" cols="30" rows="1"  style="background-color: rgb(255, 255, 255); background-position: initial initial; background-repeat: initial initial;display:none; "> <?php echo $row['lessontitle'];?></textarea>
</div>

<div class="q-toolbar">


<!--   <?php echo $flash;?> 声音上传     <?php echo $flash3;?>  图片上传   textarea task_title  文字上传 float:left;-->
<div class="soundbtn" style="padding-top:10px">
<span id="playerbox"></span>
</div>
<div style="margin-top:5px"><?php echo $flash;?><span id="picbox"></span></div>
<div class="q-btn" style="padding-top:10px">
<!--
<button type="submit" id="submit" class="bt-dft">提交语音</button>
-->
<button type="submit" id="submit" class="bt-dft" style = "width:100px;height:100px ;">交作业</button>				
</div>
            
<div class="clear"></div>
</form>
</div>
<br/>
<br/>

<a href="<?php echo $baseurl;?>&action=selectlesson&cid=<?php echo $cid;?>">返回课程主选单</a>
<br/>
<br/>

<div><br/><br/>
本页待办事项：<br/>
1. 语音录制上传 flash 客户端 不理想，需要点“上传”和“交作业”两次才能完成提交。<br/>
2. 整体美化， 视觉控看不下去！<br/>
3. 辅助功能补充。<br/><br/>
</div>
</div>
</div>
</div>
</div>

<script type="text/javascript" reload="1">
function checkrid(){
  //var title=$('task_title').value;
  var rid=$('rid').value;

  if(rid.length<1){
    alert('请录制语音');
    return false;
  }

  return true;
}



function OnezUploadCall(s){
  if(s.substr(0,2)=='ok'){
    $('content').value+=s.substr(2);
    $('picbox').innerHTML='<img src="./source/plugin/tsound_wenda/data/'+s.substr(5,s.length-6)+'.jpg" width="20" height="20" />';
    return;
  }
}

var flashcode=<?php echo $flash2;?>;
function OnezCall(type,s){
  if(type=='upload'){
    if(s.substr(0,2)!='ok'){
      alert(s);
      return;
    }
    s=s.substr(2);
    insertSound(s);
  }else if(type=='status'){
  }
}
function insertLast(){
  insertSound(lsound);
}
function insertSound(s){
  var o=s.split('|');
//  alert(o[1]);
  $('rid').value=o[0];
  $('playerbox').innerHTML=flashcode.replace('*',o[1]);
}

function checkform(){
//alert(<?php echo $tsound_wenda['force1'];?>);

//此函数  简化版 只判断rid checkrid by TT 20140317
//  var title=$('task_title').value;
  var rid=$('rid').value;
//  alert(rid.length);
//  if(title.length<1){
//    alert('请填写您的问题');
//    $('task_title').focus();
//    return false;
//  }
<?php if($tsound_wenda['force1']) { ?>
  if(rid.length<1){
    alert('请录制语音');
    return false;
  }
<?php } ?>
  return true;
}
</script> <?php include template('tsound_wenda:footer'); ?>