<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('tsound_wenda:header'); ?><div style="width:500px;height:537px;background:url(source/plugin/tsound_wenda/course/images/desk1comingsoon.gif) no-repeat;padding-top:20px; margin-top:10px;"><?php if(is_array($course)) foreach($course as $scourse) { ?>  <!-- 自动排列图标 未处理-->
<div style="padding-left:89px;padding-top:122px">
<a href="<?php echo $baseurl;?>&action=selectlesson&cid=<?php echo $scourse['cid'];?>"><img src="<?php echo $scourse['clogo'];?>" /></a>
</div>	
<?php } ?>
</div>



<div class="aside" id="caside">
<!--x{xtemplate tsound_wenda:side}x-->
</div><?php include template('tsound_wenda:footer'); ?>