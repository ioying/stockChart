<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('tsound_wenda:header'); ?> <!--height:537px;background:url(source/plugin/tsound_wenda/course/images/desk1comingsoon.gif) no-repeat;-->
<div style="width:500px;padding-top:20px; margin-top:10px;">
       <div style="padding-left:39px;"> 

此处罗列了可能用到的数据，<br/>
可根据需要使用，将来成绩可能显示为星星。<br/>
课程可单独设置图标	   <br/><br/><br/>

<h4>课程介绍</h4>
   <div>课程名称: <?php echo $course['cname'];?>
   </div>
   <div>课程说明:<?php echo $course['creadme'];?>
   </div>
   <div>课程图标:<a href="<?php echo $baseurl;?>&action=selectlesson&cid=<?php echo $course['cid'];?>"><img src="<?php echo $course['clogo'];?>" /></a>

   </div>
   <br/><br/>
   &nbsp&nbsp&nbsp课程内容&nbsp 平均得分 &nbsp 最高得分  &nbsp 评分次数
   </div><?php if(is_array($lesson)) foreach($lesson as $slesson) { ?>  <!-- 自动排列图标 未处理 -->
<div style="padding-left:39px;padding-top:22px;">
<a href="<?php echo $baseurl;?>&action=task&lessonid=<?php echo $slesson['lessonid'];?>&cid=<?php echo $cid;?>">
<?php if(!empty($slesson['logo']) ) { ?>
<img src="<?php echo $slesson['logo'];?>" />&nbsp  <?php echo $slesson['lessontitle'];?> 
<?php } else { ?>
<?php echo $slesson['lessontitle'];?>
<?php } if(!empty($UserScore[$slesson['lessonid']]['avgscore']) ) { ?>
&nbsp&nbsp&nbsp<?php echo $UserScore[$slesson['lessonid']]['avgscore'];?>&nbsp
<?php } if(!empty($UserScore[$slesson['lessonid']]['maxscore']) ) { ?>
&nbsp&nbsp&nbsp&nbsp<?php echo $UserScore[$slesson['lessonid']]['maxscore'];?>&nbsp
<?php } if(!empty($UserScore[$slesson['lessonid']]['scorecount']) ) { ?>
&nbsp&nbsp&nbsp&nbsp<?php echo $UserScore[$slesson['lessonid']]['scorecount'];?>&nbsp
<?php } ?>


<!-- 
当前用户 各课程所得分数         平均分        最高分      被评分次数
<?php echo $UserScore[$slesson['lessonid']]['avgscore']['maxscore']['scorecount'];?> 
将来成绩可显示为“星”，根据需要使用上述数据。
-->

</a>
</div>

<?php } ?>
</div>


<br/>
<a href="<?php echo $baseurl;?>&action=selectcourse">返回教程主选单</a>
<br/>
<br/>

<div class="aside" id="caside">
<!--x{xtemplate tsound_wenda:side}x-->
</div><?php include template('tsound_wenda:footer'); ?>