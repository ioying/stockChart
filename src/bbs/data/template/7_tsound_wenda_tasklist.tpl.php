<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('tsound_wenda:header'); ?><br/>
<h4 style ="font-size:32px;color:red;">教师组评分/管理专用页面制作中...  ^_^  ...</h4>
How are you ?    &nbsp&nbsp&nbsp&nbsp   怎么是你？<br/>  
How old are you ?   怎么老是你？
<div id="bd" class="grid-3 clearfix">
<div class="crumb" id="hd-crumb" style="line-height:20px"><a href="<?php echo $baseurl;?>&action=tasklist">全部语音</a> <?php echo $where;?>  </div>
<div id="carticle" class="article">
<div class="mod-answer-list" id="mod-answer-list">
<div class="hd">
<ul class="tab-card">
  <li<?php echo $question0;?>><a text="list-resolved" href="<?php echo $baseurl;?>&action=tasklist&cid=<?php echo $cid;?>&type=wait">待点评/待评分</a></li>
  <li<?php echo $question1;?>><a text="list-resolved" href="<?php echo $baseurl;?>&action=tasklist&cid=<?php echo $cid;?>&type=success">已点评/已评分</a></li>
</ul>
</div>
<div class="bd">
<div class="cls-qa-table">
<table>
<tbody>
  <tr class="">
<th class="s0">标题</th>
<th class="s1">用户名</th>
<?php if(($type !== "wait" )) { ?>
<th class="s1">平均分</th>
<th class="s1">最高分</th>
<th class="s1">点评数</th>
 <?php } ?>
<th class="s2" style="width:100px">时间</th>
  </tr><?php if(is_array($list2)) foreach($list2 as $rs) { ?><tr>
<td class="title">
<div class="tit-mini">
<div class="wrap"><a text="list-item" target="_blank" title="<?php echo $rs['title'];?>" href="<?php echo $baseurl;?>&action=comment&qid=<?php echo $rs['qid'];?>" class="lnk"><?php echo $rs['title'];?></a>&nbsp;<span class="cate">[ <a href="<?php echo $baseurl;?>&action=selectlesson&cid=<?php echo $rs['cid'];?>"><?php echo $rs['cname'];?></a>]</span></div>
<!--
<div class="js-answer-tips" data-answered-text="<?php echo $rs['status'];?>" style="display:none;"><?php echo $rs['status'];?></div>
-->
</div>
<div class="answer-success"></div></td>
<td><?php echo $rs['username'];?></td>

<?php if(!empty($rs['avgscore'])) { ?>
<td><?php echo floor($rs['avgscore']); ?></td>
<?php } if(!empty($rs['maxscore'])) { ?>
<td>
<?php echo $rs['maxscore'];?>
</td>
<?php } if(!empty($rs['answer'])) { ?>
<td>
<?php echo $rs['answer'];?>
</td>
<?php } ?>

<td><?php echo $rs['time'];?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
<div class="pagination" id="list-page">
<p class="pages"><?php echo $multi;?></p>
</div>
</div>
</div>
</div>
<div class="aside" id="caside"><?php include template('tsound_wenda:side'); ?></div>
</div><?php include template('tsound_wenda:footer'); ?>