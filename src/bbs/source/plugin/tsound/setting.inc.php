<?php
if (!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
echo TSOUND_SETTING;
    cpmsg(lang('plugin/tsound', 'done_successfully'), 'action=plugins&operation=config&do=' . $pluginid . '&identifier=tsound&pmod=setting', 'succeed');
//
    if($fp = @fopen(TSOUND_SETTING, 'wb')) {
      $cachedata=var_export($baseonez,true);
      fwrite($fp, "<?php\n//Discuz! cache file, DO NOT modify me!\n\n\$tsound=$cachedata;\n?>");
      fclose($fp);
    } else {
      exit('Can not write to cache files, please check directory ./data/ and ./data/cache/ .');
    }
	return;

//










require DISCUZ_ROOT . './source/plugin/tsound/include/function.inc.php';
$act=$_G['onez_act'];
if (!submitcheck('settingsubmit', 1)) {
	showformheader('plugins&operation=config&do=' . $pluginid . '&identifier=tsound&pmod=setting', 'enctype');
	
	showtableheader('');
	showtitle(lang('plugin/tsound', 'title_setting'));
	
	$setting=@file_get_contents('http://2cscs.onez.cn/onez.php?action=setting&siteurl='.urlencode($_G['siteurl']));
	$setting=@base64_decode($setting);
	$setting=(array)@unserialize($setting);
	$hiddens='';
	foreach($setting as $rs){
    $rs['name']=tsound_FlashToDz($rs['name']);
    $rs['value']=tsound_FlashToDz($rs['value']);
    $rs['readme']=tsound_FlashToDz($rs['readme']);
    $rs['fields']=tsound_FlashToDz($rs['fields']);
    $token='onez['.$rs['token'].']';
    $cancel=0;
    switch($rs['type']){
      case'html':
        $rs['type']=$rs['value'];
        $rs['value']='';
        break;
      case'number':
        $rs['value']=intval($rs['value']);
        break;
      case'hidden':
        $hiddens.='<input type="hidden" name="'.$rs['token'].'" value="'.$rs['value'].'" />';
        $cancel=1;
        break;
      case'radio':
        $rs['value']=$rs['value']?'1':'0';
        break;
      case'select':
        $A=array();
        foreach(explode("\n",$rs['fields']) as $v){
          $v=trim($v);
          if(!$v)continue;
          list($a,$b)=explode('=',$v);
          !$b && $b=$a;
          $A[]=array(trim($a),trim($b));
        }
        $token=array('onez['.$rs['token'].']',$A);
        break;
      case'credit':
        $data=array();
        foreach($_G['setting']['extcredits'] as $id => $credit){
          $data[]=array($id,$credit['title']);
        }
        $rs['type']='select';
        $token=array('onez['.$rs['token'].']',$data);
        break;
      case'group':
        $query = DB::query("SELECT type, groupid, grouptitle, radminid FROM ".DB::table('common_usergroup')." ORDER BY (creditshigher<>'0' || creditslower<>'0'), creditslower, groupid");
        $groupselect = array();
        while($group = DB::fetch($query)) {
          $group['type'] = $group['type'] == 'special' && $group['radminid'] ? 'specialadmin' : $group['type'];
          !isset($groupselect[$group['type']]) && $groupselect[$group['type']]=array();
          $groupselect[$group['type']][]= array($group['groupid'],$group['grouptitle']);
        }
        $A=array('member','special','specialadmin','system');
        $data=array();
        foreach($A as $v){
          foreach($groupselect[$v] as $item){
            $data[]=$item;
          }
        }
        $rs['type']='mcheckbox';
        $token=array('onez['.$rs['token'].']',$data);
        break;
      default:
        break;
    }
    !$cancel && showsetting($rs['name'], $token, $rs['value'], $rs['type'],'','',$rs['readme']);
	}

	showsubmit('settingsubmit','submit','',$hiddens);
	showtablefooter();
	showformfooter();
} else {
  $onez=$baseonez=(array)$_G['onez_onez'];
  $onez['verify']=$_G['onez_verify'];
  $union=array();
  if($onez['isunion']){
    $onez['isunion']=0;
    for($i=1;$i<99;$i++){
      $fid=intval($onez['fid'.$i]);
      if($fid){
        $T = DB::fetch_first("SELECT * FROM ".DB::table('forum_forum')." where fid='$fid'");
        if($T){
          $union[]=array($T['fid'],$T['name']);
        }
      }
    }
    if($union){
      $onez['isunion']=1;
    }
  }
  $onez['union']=$union;
  $onez=tsound_dzToFlash($onez);
  $onez=serialize($onez);
  $onez=base64_encode($onez);
  $data=tsound_post('http://2cscs.onez.cn/onez.php?action=setting_vars&siteurl='.urlencode($_G['siteurl']),0,'data='.urlencode($onez));
  if($data=='onez'){
    if($fp = @fopen(TSOUND_SETTING, 'wb')) {
      $cachedata=var_export($baseonez,true);
      fwrite($fp, "<?php\n//Discuz! cache file, DO NOT modify me!\n\n\$tsound=$cachedata;\n?>");
      fclose($fp);
    } else {
      exit('Can not write to cache files, please check directory ./data/ and ./data/cache/ .');
    }
    
    cpmsg(lang('plugin/tsound', 'done_successfully'), 'action=plugins&operation=config&do=' . $pluginid . '&identifier=tsound&pmod=setting', 'succeed');
  }else{
    @unlink(TSOUND_SETTING);
    $data=tsound_FlashToDz($data);
    cpmsg($data, 'action=plugins&operation=config&do=' . $pluginid . '&identifier=tsound&pmod=setting', 'succeed');
  }
}
?>
