<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once DISCUZ_ROOT . './source/plugin/tsound/include/function.inc.php';
$action=$_G['onez_action'];
if($action=='insert'){
  $fid=$_G['onez_fid'];
  $type=$_G['onez_type'];
  $name=$_G['onez_name'];
  $readme=$_G['onez_readme'];
  $isthread=(int)$_G['onez_isthread'];
  DB::query('DELETE FROM '. DB::table('tsound_record')." where uid='$_G[uid]' and status=-1");
  $rid=DB::insert('tsound_record',array(
    'name'=>tsound_FlashToDz($name),
    'readme'=>tsound_FlashToDz($readme),
    'uid'=>$_G['uid'],
    'time'=>TIMESTAMP,
    'status'=>'-1',
    'type'=>$type,
    'isthread'=>$isthread,
  ),true);
  $T = DB::fetch_first('SELECT * FROM '. DB::table('tsound_record')." where uid='$uid' and status=-1");
  $flashvars='rid='.$rid;
  if($type=='video'){
    $flashvars.='&timelength='.(int)$tsound['timelength2'];
    $flashvars.='&cloud='.($tsound['cloud_video']?'1':'0');
    $flash=tsound_insertflash('source/plugin/tsound/template/CamRecord.swf',$flashvars,367,482,'tsound_insert2');
    include template('tsound:insert2');
  }else{
    $flashvars.='&timelength='.(int)$tsound['timelength'];
    $flashvars.='&cloud='.($tsound['cloud_audio']?'1':'0');
    $flash=tsound_insertflash('source/plugin/tsound/template/MicRecord.swf',$flashvars,470,250,'tsound_insert');
    include template('tsound:insert');
  }
}elseif($action=='share'){
  $last=(int)$_G['onez_last'];
  $num=(int)$_G['onez_num'];
  $num=max(10,$num);
  $num=min(100,$num);
  $query = DB::query("SELECT * FROM ".DB::table('tsound_record')." where status=1 and rid>$last order by rid desc limit $num");
  $A=array();
  while($rs = DB::fetch($query)) {
    $A[]=$rs;
  }
  echo tsound_dzToFlash(tsound_json($A));
}elseif($action=='select'){
  $fid=$_G['onez_fid'];
  if($tsound['enabled_audio'] && !$tsound['enabled_video']){
    $js='location.href="forum.php?mod=post&action=newthread&fid='.$fid.'&auto=audio"</script>';
  }elseif(!$tsound['enabled_audio'] && $tsound['enabled_video']){
    $js='location.href="forum.php?mod=post&action=newthread&fid='.$fid.'&auto=video"</script>';
  }else{
  
  }
  include template('tsound:select');
}elseif($action=='record'){
  $type=$_G['onez_type'];
  $isthread=$_G['onez_isthread'];
  if($tsound['notitle']){
    header('location:'.BASEURL.'action=insert&isthread='.$isthread.'&type='.$type.'&infloat=yes&handlekey=tsound');
    exit();
  }
  $ti=lang('plugin/tsound', 'record_'.$type);
  include template('tsound:record2');
  exit();
  $page=(int)$_G['onez_page'];
  $isthread=(int)$_G['onez_isthread'];
  if($type=='video'){
    $list['video']=' class="a"';
    $xxx=" and type='video'";
    $buttonname=lang('plugin/tsound', 'record_video');
  }else{
    $list['audio']=' class="a"';
    $xxx=" and type='audio'";
    $buttonname=lang('plugin/tsound', 'record_audio');
    $type='audio';
  }
  $record=array();
  $page = max(1, $page);
  $perpage=10;
  $count=DB::num_rows(DB::query("SELECT * FROM ".DB::table('tsound_record')." where uid='$_G[uid]' and status>=0$xxx"));
  $multi=multi($count, $perpage, $page, BASEURL.'action=record&type='.$type.'&infloat=yes&handlekey=tsound');
  $query = DB::query("SELECT * FROM ".DB::table('tsound_record')." where uid='$_G[uid]' and status>=0$xxx order by rid desc limit ".(($page - 1) * $perpage).','.$perpage);
  while($rs = DB::fetch($query)) {
    $rs['time']=date('Y-m-d H:i:s',$rs['time']);
    $rs['sec']=floatval($rs['sec']/100);
    $record[]=$rs;
  }
  include template('tsound:record');
}elseif($action=='record2'){
  $type=$_G['onez_type'];
  $isthread=$_G['onez_isthread'];
  if($tsound['notitle']){
    header('location:'.BASEURL.'action=insert&isthread='.$isthread.'&type='.$type);
    exit();
  }
  $ti=lang('plugin/tsound', 'record_'.$type);
  include template('tsound:record2');
}elseif($action=='upload'){
  set_time_limit(0);
  $credittype=$tsound['credittype'];
  $credit=$tsound['credit'];
  if($credit>0){
    $row = DB::fetch_first('SELECT * FROM '. DB::table('common_member_count').' where uid='.$_G['uid']); 
    $money = (int)$row['extcredits'.$credittype];
    if($money<$credit){
      exit(tsound_dzToFlash(lang('plugin/tsound','lowcredit')));
    }
    updatemembercount($_G['uid'], array($credittype => -$credit));
  }
  $url=tsound_upload();
  exit($url);
}elseif($action=='upload2'){
  set_time_limit(0);
  $credittype=$tsound['credittype'];
  $credit=$tsound['credit2'];
  if($credit>0){
    $row = DB::fetch_first('SELECT * FROM '. DB::table('common_member_count').' where uid='.$_G['uid']); 
    $money = (int)$row['extcredits'.$credittype];
    if($money<$credit){
      exit(tsound_dzToFlash(lang('plugin/tsound','lowcredit')));
    }
    updatemembercount($_G['uid'], array($credittype => -$credit));
  }
  tsound_upload2();
  $id=$_G['onez_flvid'];
  $rid=(int)$_G['onez_rid'];
  if(!$tsound['cloud_video']){
    set_time_limit(0);
    $info=parse_url($_G['siteurl']);
    $site=strtolower($info['host']);
    $url="http://2cscs.onez.cn/flvs/$site/$id.flv";
    $file=DISCUZ_ROOT.'/'.$tsound['path_video'].'/'.$id.'.flv';
    $data=@file_get_contents($url);
    if($data){
      if(!file_exists($file))@mkdir(dirname($file),0777);
      @file_put_contents($file,$data);
      DB::update('tsound_record',array(
        'file'=>$tsound['path_video'].'/'.$id.'.flv',
      ),"rid='$rid'");
    }
  }
  exit("ok$rid");
}elseif($action=='parse'){
  $rid=$_G['onez_rid'];
  $data=tsound_parse($rid);
  $data=tsound_dzToFlash($data);
  exit("onez$data");
}elseif($action=='push'){
  $fid=(int)$_G['onez_fid'];
  $subject=tsound_flashToDz($_G['onez_subject']);
  $content=tsound_flashToDz($_G['onez_content']);
  $uid=tsound_flashToDz($_G['onez_uid']);
  $username=tsound_flashToDz($_G['onez_username']);
  $T = DB::fetch_first("SELECT * FROM ".DB::table('tsound_myunion')." where fid='$fid'");
  !$tsound['push_uid'] && $tsound['push_uid']=$uid;
  !$tsound['push_username'] && $tsound['push_username']=$username;
  $uid=$tsound['push_uid'];
  $username=$tsound['push_username'];
  if($T){
    $data=array(
      'fid'=>$fid,
      'author'=>$username,
      'authorid'=>$uid,
      'subject'=>$subject,
      'dateline'=>TIMESTAMP,
      'lastpost'=>TIMESTAMP,
      'lastposter'=>$username,
      
    );
    $tid=DB::insert('forum_thread', $data,true);
    $position=0;
    $first=1;
    $pid=DB::result_first("select pid from ". DB::table('forum_post')." order by pid desc");
    $pid++;
    $pid2=DB::result_first("select pid from ". DB::table('forum_post_tableid')." order by pid desc");
    $pid2++;
    $pid=max($pid,$pid2);
    $position++;
    $data=array(
      'pid'=>$pid,
      'fid'=>$fid,
      'tid'=>$tid,
      'first'=>'0',
      'author'=>$username,
      'authorid'=>$uid,
      'dateline'=>TIMESTAMP,
      'message'=>$content,
      'useip'=>'0.0.0.0',
      'bbcodeoff'=>'0',
      'smileyoff'=>'-1',
      'parseurloff'=>'0',
      'htmlon'=>'0',
      'position'=>$position,
    );
    DB::insert("forum_post",$data);
    $data=array(
      'pid'=>$pid,
    );
    DB::insert("forum_post_tableid",$data);
    DB::query("UPDATE ". DB::table('forum_forum')." SET lastpost='$tid\t$subject\t".time()."\t$username', posts=posts+1, todayposts=todayposts+1 WHERE fid='$fid'");
    DB::query("UPDATE ". DB::table('forum_thread')." SET lastpost='".time()."', lastposter='$username',displayorder=0 WHERE tid='$tid'");
    
    DB::query("UPDATE ". DB::table('tsound_myunion')." SET num=num+1 WHERE union_id='$T[union_id]'");
    
  }
  exit('onez');
}elseif($action=='mp3'){
  $key=$_G['onez_key'];
  $url=trim($_G['siteurl'],'/').'/'.$tsound['path_audio'].'/'.$key.'.mp3';
  exit($url);
}elseif($action=='flv'){
  $rid=$_G['onez_flvid'];
  $T = DB::fetch_first("SELECT * FROM ".DB::table('tsound_record')." where rid='$rid'");
  if($T){
    $url=$T['file'];
    if(substr($url,0,7)!='http://'){
      $url=trim($_G['siteurl'],'/').'/'.$url;
    }
  }
  exit($url);
}else{
  $type=$_G['onez_type'];
  $page=(int)$_G['onez_page'];
  if($type=='video'){
    $list['video']=' class="a"';
    $xxx=" and type='video'";
    $xxx2=" and r.type='video'";
  }else{
    $list['audio']=' class="a"';
    $xxx=" and type='audio'";
    $xxx2=" and r.type='audio'";
    $type='audio';
  }
  $record=array();
  $page = max(1, $page);
  $perpage=10;
  $count=DB::num_rows(DB::query("SELECT * FROM ".DB::table('tsound_record')." where status>0$xxx"));
  $multi=multi($count, $perpage, $page, BASEURL.'type='.$type);
  $query = DB::query("SELECT r.*,m.username,t.subject as thread FROM ".DB::table('tsound_record')." r left join ".DB::table('common_member')." m on m.uid=r.uid left join  ".DB::table('forum_thread')." t on t.tid=r.tid where r.status>0$xxx2 ORDER BY r.rid desc limit ".(($page - 1) * $perpage).','.$perpage);
  while($rs = DB::fetch($query)) {
    $rs['time']=date('Y-m-d H:i:s',$rs['time']);
    $rs['sec']=floatval($rs['sec']/100);
    $record[]=$rs;
  }
  include template('tsound:list');
}
?>