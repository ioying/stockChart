<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); include template('tsound_wenda:header'); ?><!-- 重复了？
<script src="source/plugin/tsound_wenda/template/jquery15.min.js" type="text/javascript"></script>
-->
<script type="text/javascript">

var jQGo = jQuery.noConflict(true);

jQGo(document).ready(
  function(){

   jQGo("#modCateList .item").hover(function(){
   jQGo(this).addClass("hover");

  var index =  jQGo("#modCateList .item").index(jQGo(this)); 
  jQGo("#modCatePanel"+index).show();
   
},function(){
jQGo(this).removeClass("hover");
jQGo("div[id^='modCatePanel']").hide();
}
);

jQGo("div[id^='modCatePanel']").hover(function(){
  var index =  jQGo("div[id^='modCatePanel']").index(jQGo(this)); 
  jQGo("#modCatePanel"+index).show();
   jQGo("#modCateListSub"+index).addClass("hover");

},function(){
  var index =  jQGo("div[id^='modCatePanel']").index(jQGo(this)); 
  jQGo("#modCateListSub"+index).removeClass("hover");
  jQGo("div[id^='modCatePanel']").hide();

  }
);	
   
 
  }
 )
 </script>
 

<div id="bd" class="grid-1 clearfix">
  <div class="article" id="bdarticle">
<div id="mod-slides1" class="mod-slides widget-slide" data-jss="animType:'fade',autoPlay:true,autoPlayTime:5000,animDur:300,supportMouseenter:true">
      <ul class="pic slide-content">
        <li class="pic-item selected" style="opacity: 1; "><a href="<?php echo $Ad['url'];?>" class="img" target="_blank"><img alt="<?php echo $Ad['subject'];?>" title="<?php echo $Ad['subject'];?>" src="<?php echo $Ad['pic'];?>"></a>

          <div class="info">
            <h4><a href="<?php echo $Ad['url'];?>" target="_blank"><?php echo $Ad['subject'];?></a><sup></sup></h4>
<br/>
<h4><a href="<?php echo $baseurl;?>&action=selectcourse">教程主选单</a>
</h4>

            <ul>
            <!-- 付费浏览{x  loop <?php echo $list1;?> <?php echo $rs;?>   关闭x}-x-x>
              <li><a <?php if($rs['readpay']&&$rs['readpay']>0&&$_G['uid']!=$rs['uid']) { } else { ?>target="_blank"<?php } ?> href="<?php if($rs['readpay']&&$rs['readpay']>0&&$_G['uid']!=$rs['uid']) { ?>javascript:showWindow('tsound_wenda', 'plugin.php?id=tsound_wenda:xm&qid=<?php echo $rs['qid'];?>');<?php } else { ?><?php echo $baseurl;?>&action=comment&qid=<?php echo $rs['qid'];?><?php } ?>"><?php echo $rs['title'];?></a></li>
            <!x-x-{x /loop} -->
            </ul>
          </div>
        </li>
      </ul>
    </div>
    <div class="mod-qa-list" id="mod-unresolved">
      <div class="hd">
        <h3 class="t1">待评分语音作业</h3>
        <p class="more"><a text="mod-unresolved-more" href="<?php echo $baseurl;?>&action=tasklist&type=wait">更多&gt;&gt;</a></p>
      </div>
      <div class="bd">
        <div class="cls-qa-list-1">
          <ul>
            <?php if(is_array($list2)) foreach($list2 as $rs) { ?>            <li><span class="s0"><a title="<?php echo $rs['title'];?>" <?php if($rs['readpay']&&$rs['readpay']>0&&$_G['uid']!=$rs['uid']) { } else { ?>target="_blank"<?php } ?> href="<?php if($rs['readpay']&&$rs['readpay']>0&&$_G['uid']!=$rs['uid']) { ?>javascript:showWindow('tsound_wenda', 'plugin.php?id=tsound_wenda:xm&qid=<?php echo $rs['qid'];?>');<?php } else { ?><?php echo $baseurl;?>&action=comment&qid=<?php echo $rs['qid'];?><?php } ?>"><?php echo $rs['title'];?></a></span><?php if($rs['readpay']>0) { ?><span class="s0" style="color: red;right:50px;"><img src="source/plugin/tsound_wenda/template/images/t0184b8666a05c54450.png" />&nbsp;<?php echo $rs['readpay'];?></span><?php } ?>
<span class="s1">
<a target="_blank" href="home.php?mod=space&amp;uid=<?php echo $rs['uid'];?>"><?php echo $rs['username'];?>&nbsp&nbsp&nbsp </a>
</span>
<span class="s1"><?php echo $rs['answer'];?>点评</span></li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="mod-qa-list" id="mod-highAsk">
<!--  悬赏
<div class="hd">
<h3 class="t2">111高分悬赏问题</h3>
<p class="more"><a text="mod-highAsk-more" href="<?php echo $baseurl;?>&action=category&type=high">更多&gt;&gt;</a></p>
</div>
-->		
      <div class="bd">
        <div class="cls-qa-list-1">
          <ul>
            <?php if(is_array($list3)) foreach($list3 as $rs) { ?>            <li><span class="s0"><a title="<?php echo $rs['title'];?>" <?php if($rs['readpay']&&$rs['readpay']>0&&$_G['uid']!=$rs['uid']) { } else { ?>target="_blank"<?php } ?> href="<?php if($rs['readpay']&&$rs['readpay']>0&&$_G['uid']!=$rs['uid']) { ?>javascript:showWindow('tsound_wenda', 'plugin.php?id=tsound_wenda:xm&qid=<?php echo $rs['qid'];?>');<?php } else { ?><?php echo $baseurl;?>&action=comment&qid=<?php echo $rs['qid'];?><?php } ?>"><?php echo $rs['title'];?></a></span><?php if($rs['readpay']>0) { ?><span class="s0" style="color: red;right:50px;"><img src="source/plugin/tsound_wenda/template/images/t0184b8666a05c54450.png" />&nbsp;<?php echo $rs['readpay'];?></span><?php } ?><span class="s1"><?php echo $rs['answer'];?>点评</span></li>
            <?php } ?>
          </ul>
        </div>
      </div>
  
    </div>
  </div>
  <div class="aside">
    <div class="mod-cate">
<!--
<div class="hd">
        <h3>所有课程分类</h3>
     </div>
-->	 
      <div class="bd">
        <ul id="modCateList" class="list">
          <?php $kk=0;?>          <?php if(is_array($categorys)) foreach($categorys as $cat) { ?>          <li data-index="<?php echo $kk;?>" id="modCateListSub<?php echo $kk;?>" class="item">
            <h4><a href="<?php echo $baseurl;?>&action=category&cid=<?php echo $cat['1'];?>"><?php echo $cat['0'];?></a></h4>
            <ul>
              <?php if(is_array($cat['2'])) foreach($cat['2'] as $c) { ?>              <li><a href="<?php echo $baseurl;?>&action=category&cid=<?php echo $c['1'];?>"><?php echo $c['0'];?></a></li>
              <?php } ?>
            </ul>
          </li>
          <?php $kk++;?>         <?php } ?>
        </ul>
        <?php $kk=0;?>        <?php if(is_array($categorys)) foreach($categorys as $cat1) { ?>          <?php $mm=(int)$kk*57;?>          <?php if(!empty($cat1['3'])) { ?>
          <div id="modCatePanel<?php echo $kk;?>" class="panel-cate" style="top: <?php echo $mm;?>px; display: none; ">
          <ul class="clearfix">
          <?php if(is_array($cat1['3'])) foreach($cat1['3'] as $c1) { ?>          <li><a href="<?php echo $baseurl;?>&action=category&cid=<?php echo $c1['1'];?>"><?php echo $c1['0'];?></a></li>
          <?php } ?>
           </ul>
           </div>
           <?php } ?>
           <?php $kk++;?>           
        <?php } ?>
        
         </div>
        
        
      <div class="ft"></div>
    </div>
  </div>
  <div class="extra">
  <?php include template('tsound_wenda:side'); ?>  </div>
</div><?php include template('tsound_wenda:footer'); ?>