<?php if(!defined('IN_DISCUZ')) exit('Access Denied'); ?>
<!-- x{x template common/header_note x} x --><?php include template('common/header_bbs'); if($_G['forum']['ismoderator']) { ?>
<script src="<?php echo $_G['setting']['jspath'];?>forum_moderate.js?<?php echo VERHASH;?>" type="text/javascript"></script>
<?php } if(empty($_G['forum']['picstyle']) || $_G['cookie']['forumdefstyle']) { ?>
<script type="text/javascript">var lasttime = <?php echo $_G['timestamp'];?>;var listcolspan= '<?php if(!$_GET['archiveid'] && $_G['forum']['ismoderator']) { ?>6<?php } else { ?>5<?php } ?>';</script>
<?php } ?>
<script src="<?php echo $_G['setting']['jspath'];?>jquery-1.11.0.min.js" type="text/javascript"></script>
<script type="text/javascript">
jQuery.noConflict();
function preview_note(thread_id, tbody, lastpost, dateline, author, subject, lastposter) {
var noteObj = jQuery('.note-content');
noteObj.find('.title').text(subject);
noteObj.find('.meta').html('');
if (subject) {
noteObj.find('.meta').html('<span>: ' + dateline + ' by <span class="name">' + author + '</span></span><span>修改时间：' + lastpost + '  by <span class="name">' + lastposter + '</span></span>');
}
noteObj.find('.text').html('');
noteObj.find('.text').attr('id', tbody);
if (thread_id) {
previewThread(thread_id, tbody);
}
}
</script>

<div class="container">
<div class="profile_bar clearfix">
<div class="wrapper">
<div class="profile_wrapper clearfix">
<div class="pull-left">
<!-- 发新帖按钮  -->
<?php if(!$_GET['archiveid'] ) { ?><a href="javascript:;" id="newspecial" onmouseover="$('newspecial').id = 'newspecialtmp';this.id = 'newspecial';showMenu({'ctrlid':this.id})"<?php if(!$_G['forum']['allowspecialonly'] && empty($_G['forum']['picstyle']) && !$_G['forum']['threadsorts']['required']) { ?> onclick="showWindow('newthread', 'forum.php?mod=post&action=newthread&fid=<?php echo $_G['fid'];?>')"<?php } else { ?> onclick="location.href='forum.php?mod=post&action=newthread&fid=<?php echo $_G['fid'];?>';return false;"<?php } ?> title="发新帖" class="btn btn-black">发帖 </a>
<?php } ?>
<!--
<button class="btn btn-black" onclick="location.href='forum.php?mod=post&action=newthread&fid=<?php echo $_G['fid'];?>';"><i class="ico ico-plus"></i> 发帖</button>
-->

<span class="breadcrumbs">
<strong class="font-gray">您的位置：</strong>
<a href="forum.php"><?php echo $_G['setting']['navs']['2']['navname'];?></a>
<span>&gt;</span>
<a href="forum.php?mod=forumdisplay&amp;fid=<?php echo $_G['fid'];?>" class="active"><?php echo $_G['forum']['name'];?></a>
</span><!-- breadcrumbs -->
<span class="font-lightgray">|</span>
<span><strong class="font-gray">今日主题：</strong> <strong class="font-red"><?php echo $_G['forum']['todayposts'];?></strong></span>
<span class="font-lightgray">|</span>
<span><strong class="font-gray">版主：</strong> 
<strong><?php echo $moderatedby;?> </strong></span>
</div>
<div class="info_wrapper">
<form action="" class="pull-right">
<input type="text" placeholder="搜索论坛"/>
<button class="btn">搜索</button>
</form>

<hr>

</div>
</div><!-- /.profile_wrapper -->

</div>
</div><!-- /.profile_bar -->

<div class="main_page clearfix">



<div class="clearfix">
<div class="list_wrapper pull-left">
<div class="list_title row">
<div class="cell1 cell">
<strong>全部主题</strong>
<a href="###" class="font-green">最新</a>
<a href="###" class="font-green">最热</a>
<a href="###" class="font-green">精华</a>
</div>
<div class="cell2 cell">
<strong>作者</strong>
</div>
<div class="cell2 cell">
<strong>回复/查看</strong>
</div>
<div class="cell2 cell">
<strong>最后发表</strong>
</div>
</div>
<ul class="list_body"><?php if(is_array($_G['forum_threadlist'])) foreach($_G['forum_threadlist'] as $key => $thread) { if(in_array($thread['displayorder'], array(1, 2, 3, 4))) { ?>				
<li>
<div class="article row">
<div class="cell cell1">
<h3 ><i class="ico ico-top"></i>

<img src="<?php echo IMGDIR;?>/pin_<?php echo $thread['displayorder'];?>.gif" alt="<?php echo $_G['setting']['threadsticky'][3-$thread['displayorder']];?>" />

<a href="javascript:;" onclick="preview_note('<?php echo $thread['tid'];?>', '<?php echo $thread['id'];?>', '<?php echo $thread['lastpost'];?>', '<?php echo $thread['dateline'];?>','<?php echo $thread['author'];?>', '<?php echo $thread['subject'];?>', '<?php echo $thread['lastposter'];?>');" class="font-hot">
<span><?php echo $thread['subject'];?></span></a>

</h3>
</div>
<div class="cell cell2">
<a href="home.php?mod=space&amp;username=<?php echo $thread['author'];?>"><?php echo $thread['author'];?></a>
<br>
<span class="font-gray"><?php echo $thread['dateline'];?></span>
</div>
<div class="cell cell2">
<span class="font-green"><a href="forum.php?mod=viewthread&amp;tid=<?php echo $thread['tid'];?>&amp;extra=<?php echo $extra;?>" class="xi2"><?php echo $thread['allreplies'];?></a></span>
<br>
<span class="font-gray"><?php echo $thread['views'];?></span>
</div>
<div class="cell cell2">
<cite><?php if($thread['lastposter']) { ?>
<a href="<?php if($thread['digest'] != -2) { ?>home.php?mod=space&username=<?php echo $thread['lastposterenc'];?><?php } else { ?>forum.php?mod=viewthread&tid=<?php echo $thread['tid'];?>&page=<?php echo max(1, $thread['pages']);; } ?>" c="1" class="font-gray"><?php echo $thread['lastposter'];?></a><?php } else { ?><?php echo $_G['setting']['anonymoustext'];?><?php } ?></cite>
<br>
<em><a href="<?php if($thread['digest'] != -2 && !$thread['ordertype']) { ?>forum.php?mod=redirect&tid=<?php echo $thread['tid'];?>&goto=lastpost<?php echo $highlight;?>#lastpost<?php } else { ?>forum.php?mod=viewthread&tid=<?php echo $thread['tid'];?><?php if(!$thread['ordertype']) { ?>&page=<?php echo max(1, $thread['pages']);; } } ?>"><?php echo $thread['lastpost'];?></a></em>
</div>
</div><!-- /.article -->

</li>
<?php } ?>	
<?php } ?>						
</ul><!--/.list_body-->
<div class="list_title row">
<div class="cell1 cell">
<strong>本版主题</strong>
</div>
<div class="cell2 cell">
<strong>作者</strong>
</div>
<div class="cell2 cell">
<strong>回复/查看</strong>
</div>
<div class="cell2 cell">
<strong>最后发表</strong>
</div>
</div><!--/.list_title-->

<ul class="list_body">
<?php if($_G['forum_threadcount']) { if(is_array($_G['forum_threadlist'])) foreach($_G['forum_threadlist'] as $key => $thread) { ?><li>
<div class="article row">
<div class="cell cell1">
<h3  onclick="preview_note('<?php echo $thread['moved'] ? $thread['closed'] : $thread['tid']; ?>', '<?php echo $thread['id'];?>', '<?php echo $thread['lastpost'];?>', '<?php echo $thread['dateline'];?>','<?php echo $thread['author'];?>', '<?php echo $thread['subject'];?>', '<?php echo $thread['lastposter'];?>');"><i class="ico ico-top"></i><?php echo $thread['subject'];?><?php echo $thread['displayorder'];?></h3>
</div>
<div class="cell cell2">
<a href="home.php?mod=space&amp;username=<?php echo $thread['author'];?>"><?php echo $thread['author'];?></a>
<br>
<span class="font-gray"><?php echo $thread['dateline'];?></span>
</div>
<div class="cell cell2">
<span class="font-green"><a href="forum.php?mod=viewthread&amp;tid=<?php echo $thread['tid'];?>&amp;extra=<?php echo $extra;?>" class="xi2"><?php echo $thread['allreplies'];?></a></span>
<br>
<span class="font-gray"><?php echo $thread['views'];?></span>
</div>
<div class="cell cell2">
<cite><?php if($thread['lastposter']) { ?>
<a href="<?php if($thread['digest'] != -2) { ?>home.php?mod=space&username=<?php echo $thread['lastposterenc'];?><?php } else { ?>forum.php?mod=viewthread&tid=<?php echo $thread['tid'];?>&page=<?php echo max(1, $thread['pages']);; } ?>" c="1" class="font-gray"><?php echo $thread['lastposter'];?></a><?php } else { ?><?php echo $_G['setting']['anonymoustext'];?><?php } ?></cite>
<em><a href="<?php if($thread['digest'] != -2 && !$thread['ordertype']) { ?>forum.php?mod=redirect&tid=<?php echo $thread['tid'];?>&goto=lastpost<?php echo $highlight;?>#lastpost<?php } else { ?>forum.php?mod=viewthread&tid=<?php echo $thread['tid'];?><?php if(!$thread['ordertype']) { ?>&page=<?php echo max(1, $thread['pages']);; } } ?>"><?php echo $thread['lastpost'];?></a></em>

<br>
<span class="font-gray"><a href="<?php if($thread['digest'] != -2 && !$thread['ordertype']) { ?>forum.php?mod=redirect&tid=<?php echo $thread['tid'];?>&goto=lastpost<?php echo $highlight;?>#lastpost<?php } else { ?>forum.php?mod=viewthread&tid=<?php echo $thread['tid'];?><?php if(!$thread['ordertype']) { ?>&page=<?php echo max(1, $thread['pages']);; } } ?>"><?php echo $thread['lastpost'];?></a></span>
</div>
</div><!-- /.article -->
</li>	
<?php } } else { ?>
本版块或指定的范围内尚无主题
<?php } ?>						
</ul><!--/.list_body-->
</div><!-- /.list_wrapper -->

<div class="view_wrapper">
<div class="title_bar">
<div class="article_title view_inner">
<img src="tests/avator.png" class="pull-left" alt="">
<div class="title_info">
<h3>学渣不要再发起挑战了</h3> <a href="###" class="btn btn-small">复制链接</a>
<hr>
<div>
<span class="pull-right">升降机直达: <input type="text" class="input-mini"></span>
<a href="###" class="font-pink">Hello醒醒</a> <span class="font-gray">创建时间：2012-01-01</span>
</div>
</div>
</div><!--/.article_title-->
</div><!--/.title_bar-->
<div class="view_body">
<div class="view_inner">
<div class="card_layout">
<div class="article">
<p>大声道萨达撒的撒旦撒旦撒</p>
<p>大声道萨达撒的撒旦撒旦撒大声道萨达撒的撒旦撒旦撒大声道萨达撒的撒旦撒旦撒大声道萨达撒的撒旦撒旦撒大声道萨达撒的撒旦撒旦撒大声道萨达撒的撒旦撒旦撒大声道萨达撒的撒旦撒旦撒大声道萨达撒的撒旦撒旦撒</p>
</div>
<p class="btns">
<a href="###" class="btn btn-small">收藏</a>
<a href="###" class="btn btn-small">举报</a>
</p>
</div><!-- card_layout -->
<form action="###" class="feed_form">
<input type="text">
<a href="###" class="btn">发表点评</a>
</form>
<div class="card_layout feed clearfix">
<div class="one clearfix">
<img src="tests/avator.png" width="50" class="pull-left" alt="">
<div class="one_body">
<h4><a href="#" class="font-blue">男生:</a></h4>
<p>
撒旦撒浪费了的撒开发sd卡反馈独守空房快独守空房快递费健身卡
</p>
<span class="font-gray">2小时</span>
<div class="one_btns">
<a href="###"><i class="ico ico-reply"></i> 回复</a>
<a href="###"><i class="ico ico-good"></i> 赞(1)</a>
</div>
</div>
</div><!--/.one-->
<div class="sub_feed">
<div class="one clearfix">
<img src="tests/avator.png" width="50" class="pull-left" alt="">
<div class="one_body">
<h4><a href="#" class="font-blue">男生:</a></h4>
<p>
撒旦撒浪费了的撒开发sd卡反馈独守空房快独守空房快递费健身卡
</p>
<span class="font-gray">2小时</span>
<div class="one_btns">
<a href="###"><i class="ico ico-reply"></i> 回复</a>
<a href="###"><i class="ico ico-good"></i> 赞(1)</a>
</div>
</div>
</div><!--/.one-->
<div class="sub_feed">
<div class="one clearfix">
<img src="tests/avator.png" width="50" class="pull-left" alt="">
<div class="one_body">
<h4><a href="#" class="font-blue">男生:</a></h4>
<p>
撒旦撒浪费了的撒开发sd卡反馈独守空房快独守空房快递费健身卡
</p>
<span class="font-gray">2小时</span>
<div class="one_btns">
<a href="###"><i class="ico ico-reply"></i> 回复</a>
<a href="###"><i class="ico ico-good"></i> 赞(1)</a>
</div>
</div>
</div><!--/.one-->
</div><!--/.sub-feed-->
</div><!--/.sub-feed-->
</div><!-- card_layout -->
</div><!--/.view_inner-->
</div><!--/.view_body-->
</div><!-- /.editor_wrapper -->
</div><!-- /.clearfix -->

</div><!-- /.main_page -->

<div class="footer wrapper clearfix">
<ul class="nav">
<li><a href="###" title="关于另客">关于另客</a></li>
<li><a href="###" title="联系我们">联系我们</a></li>
<li><a href="###" title="留言板">留言板</a></li>
<li><a href="###" title="推荐链接">推荐链接</a></li>
<li><a href="###" title="申请友链">申请友链</a></li>
</ul>
</div><!-- /.footer -->

</div><!-- /.container -->


<div class="container">
<div class="main_page clearfix"> <!--note-main-->
<div class="profile_bar clearfix">
<div class="wrapper">
 <!--<div class="list_top_bar clearfix"> -->
<!-- 发新帖按钮  -->
<?php if(!$_GET['archiveid'] ) { ?><a href="javascript:;" id="newspecial" onmouseover="$('newspecial').id = 'newspecialtmp';this.id = 'newspecial';showMenu({'ctrlid':this.id})"<?php if(!$_G['forum']['allowspecialonly'] && empty($_G['forum']['picstyle']) && !$_G['forum']['threadsorts']['required']) { ?> onclick="showWindow('newthread', 'forum.php?mod=post&action=newthread&fid=<?php echo $_G['fid'];?>')"<?php } else { ?> onclick="location.href='forum.php?mod=post&action=newthread&fid=<?php echo $_G['fid'];?>';return false;"<?php } ?> title="发新帖" class="btn btn-black">发帖 </a>
<?php } ?>
<!--
<button class="btn btn-black" onclick="location.href='forum.php?mod=post&action=newthread&fid=<?php echo $_G['fid'];?>';"><i class="ico ico-plus"></i> 发帖</button>
-->
<span class="breadcrumbs">
<strong class="font-gray">您的位置：</strong>
<a href="forum.php"><?php echo $_G['setting']['navs']['2']['navname'];?></a>
<span>&gt;</span>
<a href="forum.php?mod=forumdisplay&amp;fid=<?php echo $_G['fid'];?>" class="active"><?php echo $_G['forum']['name'];?></a>
</span><!-- breadcrumbs -->

<span class="font-lightgray">|</span>
<span><strong class="font-gray">今日主题：</strong> <strong class="font-red"><?php echo $_G['forum']['todayposts'];?></strong></span>
<span class="font-lightgray">|</span>
<span><strong class="font-gray">版主：</strong> 
<strong><?php echo $moderatedby;?> </strong>
<!--
<a href="###" class="font-green">test1</a>, <a href="###" class="font-green">test1</a>, <a href="###" class="font-green">test1</a>, <a href="###" class="font-green">test1</a>
-->
</span>


<div class="info_wrapper"  style="">
<form action="" class="pull-right">
<input type="text" placeholder="搜索论坛"/>
<button class="btn">搜索</button>
</form>

</div><!-- /.profile_wrapper -->
</div><!--/.list-top-bar-->






</div>
</div><!-- /.profile_bar -->



        <div class=""><!--rf-sidebar-->
            <div class="lf note-list">
                <div class="title"><img src="/static/note/imgs/notebook-ico.png" alt="" class="notebook-ico"><?php echo $navtitle;?></div>
                <div class="note-list">
                    <ul>
                        <?php if($_G['forum_threadcount']) { ?>
                        <?php if(is_array($_G['forum_threadlist'])) foreach($_G['forum_threadlist'] as $key => $thread) { ?>                        <li>
                            <!-- <div class="tag"><a href="/" class="pink">Top</a><a href="/">Top</a></div>  -->
                            <h3  onclick="preview_note('<?php echo $thread['moved'] ? $thread['closed'] : $thread['tid']; ?>', '<?php echo $thread['id'];?>', '<?php echo $thread['lastpost'];?>', '<?php echo $thread['dateline'];?>','<?php echo $thread['author'];?>', '<?php echo $thread['subject'];?>', '<?php echo $thread['lastposter'];?>');"><?php echo $thread['subject'];?></h3>
                            <span class="time-ago"><?php echo $thread['lastpost'];?></span>
                            <span class="summary" id="content_<?php echo $thread['tid'];?>" title="更多操作" onclick="CONTENT_TID='<?php echo $thread['tid'];?>';CONTENT_ID='<?php echo $thread['id'];?>';showMenu({'ctrlid':this.id,'menuid':'content_menu'})"><?php echo $thread['typehtml'];?> <?php echo $thread['sorthtml'];?></span>
                        </li>						
<?php } } else { ?>
本版块或指定的范围内尚无主题
<?php } ?>
                    </ul>
                    <div class="note-list-bottom">
                        排列顺序：<span class="on">更新</span>  <span>创建</span>  <span>标题</span>
                    </div>
                </div>
            </div>
            <div class="lf note-content">
                <div class="title"><h2><?php echo $_G['forum_threadlist']['0']['subject'];?></h2></div>
                <div class="meta"><span>创建时间111: <?php echo $_G['forum_threadlist']['0']['dateline'];?> by <span class="name"><?php echo $_G['forum_threadlist']['0']['author'];?></span></span><span>修改时间：<?php echo $_G['forum_threadlist']['0']['lastpost'];?>  by <span class="name"><?php echo $_G['forum_threadlist']['0']['lastposter'];?></span></span></div>
                <div class="content">
                    <div class="content-bg">
                        <!-- <div class="praise-btn lf"><span>0</span></div> -->
                        <div class="text J_note_text" id="<?php echo $_G['forum_threadlist']['0']['id'];?>">
                        <script>preview_note('<?php echo $_G['forum_threadlist']['0']['tid'];?>', '<?php echo $_G['forum_threadlist']['0']['id'];?>', '<?php echo $_G['forum_threadlist']['0']['lastpost'];?>', '<?php echo $_G['forum_threadlist']['0']['dateline'];?>','<?php echo $_G['forum_threadlist']['0']['author'];?>', '<?php echo $_G['forum_threadlist']['0']['subject'];?>', '<?php echo $_G['forum_threadlist']['0']['lastposter'];?>');</script>
                        </div>
                        <!-- <div class="content-bottom-bar tag"><a href="/">编辑笔记</a><a href="/">删除笔记</a></div> -->
                    </div>
                    <!--
                    <div class="revert-bar clearfix">
                        <form action="/">
                            <textarea name="" id="" class="content-bg" placeholder="输入您的点评"></textarea>
                            <button type="button" class="submit-btn">发表点评</button>
                        </form>
                    </div>
                    
                    <div class="content-bg comment clearfix">
                        <ul>
                            <li class="comment-list">
                                <div class="clearfix comment-wrapper">
                                    <div class="comment-main">
                                        <span class="name">Jim：</span>
                                        <span>LINKS a bilingual community/video keyword/desk/English Corner old/Chinese Corner/Log in...</span>
                                        <span class="time-ago">2小时前</span>
                                    </div>
                                    <div class="comment-meta"><span class="lf"><a href="/" class="reply">回复</a><a href="/" class="up">赞(123)</a></span><span class="rf comment-user-bar"><a href="/">编辑</a><a href="/">删除</a></span></div>
                                </div>
                                <div class="re-comment">
                                    <div class="comment-main">
                                        <span class="name">Jim：</span>
                                        <span>LINKS a bilingual community/video keyword/desk/English Corner old/Chinese Corner/Log in...</span>
                                        <span class="time-ago">2小时前</span>
                                    </div>
                                    <div class="comment-meta"><span class="lf"><a href="/" class="reply">回复</a><a href="/" class="up">赞(123)</a></span><span class="rf comment-user-bar"><a href="/">编辑</a><a href="/">删除</a></span></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    -->
                </div>
            </div>
        </div>
    </div>
</div>    
<!-- 底部分页 -->
<?php if($_G['setting']['threadmaxpages'] > 1 && $page && !$subforumonly) { ?>
<script type="text/javascript">document.onkeyup = function(e){keyPageScroll(e, <?php if($page > 1) { ?>1<?php } else { ?>0<?php } ?>, <?php if($page < $_G['setting']['threadmaxpages'] && $page < $_G['page_next']) { ?>1<?php } else { ?>0<?php } ?>, 'forum.php?mod=forumdisplay&fid=<?php echo $_G['fid'];?>&filter=<?php echo $filter;?>&orderby=<?php echo $_GET['orderby'];?><?php echo $forumdisplayadd['page'];?>&<?php echo $multipage_archive;?>', <?php echo $page;?>);}</script>
<?php } if(empty($_G['forum']['picstyle']) && $_GET['orderby'] == 'lastpost' && empty($_GET['filter']) ) { ?>
<script type="text/javascript">checkForumnew_handle = setTimeout(function () {checkForumnew(<?php echo $_G['fid'];?>, lasttime);}, checkForumtimeout);</script>
<?php } if(empty($_G['setting']['disfixednv_forumdisplay']) ) { ?><script>fixed_top_nv();</script><?php } include template('common/footer_note'); ?>