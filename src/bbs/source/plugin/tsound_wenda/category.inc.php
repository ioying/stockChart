<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require_once DISCUZ_ROOT . './source/plugin/tsound_wenda/include/function.inc.php';
$pmod='category';
$act=$_G['onez_act'];
$id=(int)$_G['onez_id'];
if(in_array($act,array('add','edit','copy'))){
  $pcid=(int)$_G['onez_pcid'];
  if($act=='add'){
    $onez=array(
      'pcid'=>$pcid
    );
  }else{
    $onez=DB::fetch_first('SELECT * FROM '. DB::table('tsound_wenda_category').' where cid='.$id); 
    $pcid=$onez['pcid'];
  }
  $pcid_=$pcid;
  while($pcid_>0){
    $T=DB::fetch_first('SELECT * FROM '. DB::table('tsound_wenda_category').' where cid='.$pcid_); 
    $categoryparent2=' &raquo; '.$T['name'].$categoryparent2;
    $pcid_=(int)$T['pcid'];
  }
  $categoryparent=lang('plugin/tsound_wenda', 'categorymain').$categoryparent2;
  include_once(dirname(__FILE__).'/category.edit.php');
  exit();
}
if(submitcheck('submit')){

	if ($_G['onez_delete']) {
    DB::query("delete from ".DB::table('tsound_wenda_category')." where cid in (".implode(',',array_keys($_G['onez_delete'])).")");
	}
	$name=(array)$_G['onez_name'];
	$step=(array)$_G['onez_step'];
	if($name){
    foreach($name as $id=>$v){
      DB::update('tsound_wenda_category',array(
        'name'=>$name[$id],
        'step'=>(int)$step[$id],
      ), "cid='$id'");
    }
	}
	cpmsg(lang('plugin/tsound_wenda', 'done_successfully'), 'action=plugins&operation=config&do=' . $pluginid . '&identifier=tsound_wenda&pmod='.$pmod, 'succeed');
}else{
	showsubmenu("<a href=\"?action=plugins&operation=config&do=$pluginid&identifier=tsound_wenda&pmod=$pmod&act=add\" class=\"act\">".lang('plugin/tsound_wenda', 'addcategory')."</a>");
	showformheader('plugins&operation=config&do=' . $pluginid . '&identifier=tsound_wenda&pmod='.$pmod);
	showtableheader(lang('plugin/tsound_wenda', 'categoryti'), 'nobottom');
	showtablerow('',
    array('', '', '', '','', '', '', '', '', '', '', ''),
    array(
      '',
      lang('plugin/tsound_wenda', 'categoryid'),
      lang('plugin/tsound_wenda', 'categoryname'),
      lang('plugin/tsound_wenda', 'categorystep'),
  ));
  function _weixin_categorys($pcid=0,$step=0){
    global $pluginid,$pmod;
    $query = DB::query("SELECT * FROM ".DB::table('tsound_wenda_category')." where pcid='$pcid' ORDER BY step,cid");
    for($i=0;$i<$step;$i++){
      $pre.='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    }
    while($rs = DB::fetch($query)) {
      $addchild=$rs['pcid']==0?" <a href=\"?action=plugins&operation=config&do=$pluginid&identifier=tsound_wenda&pmod=$pmod&act=add&pcid=$rs[cid]\" class=\"act\">".lang('plugin/tsound_wenda', 'addchildcategory')."</a> ":'';
      showtablerow('', '', array(
            "<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$rs[cid]]\" value=\"$rs[cid]\">",
            '<font color=red>'.$rs['cid'].'</font>',
            $pre."<input class=\"text\" type=\"text\" name=\"name[$rs[cid]]\" value=\"$rs[name]\">",
            "<input class=\"text\" type=\"text\" name=\"step[$rs[cid]]\" value=\"$rs[step]\">",
            "<a href=\"?action=plugins&operation=config&do=$pluginid&identifier=tsound_wenda&pmod=$pmod&act=edit&id=$rs[cid]\" class=\"act\">".lang('plugin/tsound_wenda', 'edit')."</a> $addchild"
          ));
      _weixin_categorys($rs['cid'],$step+1);
    }
  }
  _weixin_categorys();
	showsubmit('submit', 'submit', 'del', "", $multipage);
	showtablefooter();
	showformfooter();		
}
?>