<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('common/header_ajax'); ?><h3 class="flb mn sr"><em><?php echo $ti;?></em><a href="javascript:;" id="lastsound" onclick="insertLast()" style="display:none"><em style="color:red;padding-left:20px;text-decoration:underline">插入上一次录音</em></a> <span> 

<a href="javascript:;" class="flbc" onclick="hideWindow('tsound_wenda_other', 0, 1);" title="关闭">关闭</a> 

</span> </h3>
    <div class="mod-answer-form js-form" style="border:0">
      <div class="bd">
        <form id="editform" method="post" type="0" action="<?php echo $baseurl;?>&action=<?php echo $action;?>&qid=<?php echo $qid;?>&aid=<?php echo $aid;?>" onsubmit="return checkform2()">
          <textarea name="content" id="content2"  class="textarea js-editor " style="width: 438px;border:1px solid #3db40c"></textarea>
          <div id="js-answer-error" class="erro js-form-error"></div>
          <input name="qid" type="hidden" value="<?php echo $qid;?>">
          <input name="aid" type="hidden" value="<?php echo $aid;?>">
          <input name="type" type="hidden" value="<?php echo $type;?>">
          <input name="rid" id="rid2" type="hidden" value="">
          <div class="soundbtn" style="float:left;padding-top:0px">
<style>
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
          <span class="addimg">
            <?php echo $flash;?>
            <a href="<?php echo $baseurl;?>&action=insert&idname=rid2" onclick="showWindow('tsound_wenda', this.href)" class="addsound"><img src="./source/plugin/tsound_wenda/template/images/tsound_small.png" align="absmiddle" />添加语音</a>
          </span>
          <span id="playerbox"></span>
          </div>
          <span class="btn btn-2">
          <button type="submit" id="submit" class="js-added-submit" text="answer-submit">提交</button>
          </span>
        </form>
      </div>
    </div>
<script type="text/javascript" reload="1">
function OnezUploadCall2(s){
  if(s.substr(0,2)=='ok'){
    $('content2').value+=s.substr(2);
    return;
  }
}
function checkform2(){
  var content=$('content2').value;
  var rid=$('rid2').value;
  if(content.length<1){
//  if(rid.length<1){
   alert('请填写您的回复');
//   alert('请先上传语音！');
    $('content2').focus();
    return false;
  }
  return true;
}
</script> <?php include template('common/footer_ajax'); ?>