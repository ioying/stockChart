<?php

class seoOutput{
	public static function show_table($data, $name, $args = array()){
		$data_arr = $data[$name];
		$th_arr = $td_arr = $value_arr = array();
		$args['td_width'] = $args['td_width'] ? $args['td_width'] : 'auto';
		$args['table_width'] = $args['table_width'] ? $args['table_width'] : 'auto';
		foreach($data_arr as $k => $v){
			$th_arr[] = '<th class="split" width="'.$args['td_width'].'"><div class="box box-center">'.stlang($v['name']).'</div></th>';
			$value_arr = !is_array($v['value']) ? array($v['value']) : $v['value'];
			foreach($value_arr as $k2 => $v2){
				$td_arr[$k2][] = '<td class="split" width="'.$args['td_width'].'"><div class="box box-center">'.$v2.'</div></td>';
			}
		}
		$td_str = '';
		$th_str = implode('', $th_arr);
		foreach($td_arr as $k => $v){
			$td_str .= '<tr class="seo-general-keyword-summary  even ">'.implode('', $v).'</tr>';
		}
		return '<table  class="tb_seo table-2 table-seo-general" style="border-collapse:separate;  margin-right: 8px;width:'.$args['table_width'].'"><tbody><tr><caption><span style=" float:left">'.stlang($name).'</span>'.$args['caption'].'</caption></tr></tbody><tbody class="list-seo-general-keyword-detail"><tr class="header">'.$th_str.'</tbody> <tbody class="list_detail">'.$td_str.'</tbody></tbody><tbody></tbody><tbody></tbody></table>';
	}
	
	//输出头部
	public static function pick_header_output($args = array()){
		global $header_arr,$head_url;
		if(!$header_arr) return;
		$head_url = $head_url ? $head_url : '?'.PLUGIN_GO.$_GET['pmod'].'&myac=';
		$myac = $_GET['myac'];
		if(!$myac) $myac = $header_arr[0];
		$str = '<div class="itemtitle"><ul class="tab1" style="margin-top:8px;">';
		foreach($header_arr as $k => $v){	
			$current = $v == $myac || $args['current'] == $v ? 'class="current"' : ''; 
			$str .= '<li '.$current.'><a href="'.$head_url.$v.'"><span>'.stlang($v).'</span></a></li>';
		}
		$str .='</ul></div>';
		return $str;
	}
	
	static public function  show_tr($args , $type = 'input'){
		extract($args);
		$html = $html ? $html : self::$type($args['arr'], $args['info']);
		return "\n\r".self::add_tr($args, $html)."\n\r";
	}
	static public function add_tr($args, $html = ''){
		extract($args);
		$output = $name ? '<tr ><td colspan="2" class="td27" s="1">'.$name.':</td></tr>' : '';
		$tr_id = $tr_id ? 'id="'.$tr_id.'"' : '';
		$output .= '<tr '.$tr_id.' class="noborder" '.$style.'><td class="vtop rowform">'.$html.'</td><td class="vtop tips2" s="1">'.$desc.'</td></tr>';
		return $output;
	}
	static public function show_title($title){
		return '<tr><th colspan="15" class="partition">'.$title.'</th></tr>';
	}
	static public function input($args, $info = array()){
		extract($args);
		$length = $length ? $length : 6;
		$info[$name] = $info[$name] ? $info[$name] : $int_val;
		$set_name = $set_name == 1 || $type == 'file' ? $name : 'set['.$name.']';
		$type = $type ? $type : 'text';
		return '<input id="'.$name.'" type="'.$type.'" '.$js.' class="txt length_'.$length.'" name="'.$set_name.'" value="'.$info[$name].'">';
	}
	
	
	static public function textarea($args, $info = array()){
		extract($args);
		$length = $length ? $length : 6;
		$height = $height ? $height : 81;
		$info[$name] = $info[$name] ? $info[$name] : $int_val;
		$set_name = $set_name == 1 ? $name : 'set['.$name.']';
		return '<textarea rows="6" ondblclick="textareasize(this, 1)" cols="50"  \'..\'="" onkeyup="textareasize(this, 0)" id="'.$name.'" '.$js.' class="tarea length_'.$length.'" style="height:'.$height.'px;" name="'.$set_name.'">'.$info[$name].'</textarea>';
		
	}

	public static function ifcheck($var) {
		return $var ? ' checked' : '';
	}
	
	//array('name' => 'avatar_setting_member', 'int_val' => 1, 'js' => array('show_user_set(1)', 'show_user_set(2)'), 'lang' => array('no_avatar_member', 'user_set'))
	static public function radio($args, $info = array()){
		extract($args);
		$str = '<ul onmouseover="altStyle(this);">';
		$lang = $lang ? $lang : array('yes', 'no');
		if($int_val && !$info[$name]) $info[$name] = $int_val;
		$info[$name] = $info[$name] ? $info[$name] : 1;
		$lang = $lang_arr ? $lang_arr : ($lang_type == 1 || !$lang_type ? array(stlang('_open'), stlang('_close')) : array(stlang('yes'), stlang('no')));
		$arr = $js_arr = array();
		if(count($lang) == 2 && $lang_type !=3) {
			$arr[1] = $lang[0];
			$arr[2] = $lang[1];
			$js_arr[1] = $js[0];
			$js_arr[2] = $js[1];
		}else{
			$arr = $lang;
			$js_arr = $js;
		}
		
		foreach($arr as $i => $v){
			$li_checked = 'class="'.self::ifcheck($info[$name] == $i).'"';
			$radio_checked = self::ifcheck($info[$name] == $i);
			$js_show = $js_arr[($i)] ? 'onclick="'.$js_arr[($i)].'"' : '';
			$str .= '<li  '.$li_checked.'><label><input '.$js_show.' '.$radio_checked.' name="set['.$name.']" type="radio" class="radio '.$name.'" id="'.$name.'_'.$i.'"  value="'.$i.'"><span>'.$v.'</span></label></li>';
		}
		
		$str .= '</ul>';
		return $str;
	}
	
	static public function select($args, $info = array()){
		extract($args);
		$flag = $flag ? $flag : 0;
		$multiple = $multiple ? 'multiple="multiple" size="10"' : '';
		$show_name = $multiple ? $name.'[]' : $name;
		$select = '<select '.$js.' name="'.$show_name.'" '.$multiple.' class="'.$class.'" id="'.$id.'">';
		$key_arr = array_keys($option_arr);
		$int_val = isset($info[$name]) ? $info[$name] : $int_val;
		$int_val = isset($int_val) ? $int_val : $key_arr[0];
		$int_val_arr = is_array($int_val) ? $int_val : array($int_val);
		foreach($option_arr as $k => $v){
			$select_value = $flag == 0 ? $v : $k;
			$select_value = (string)$select_value;
			$selected = in_array($select_value, $int_val_arr) ? 'selected="selected"' : '';
			$select .= '<option '.$selected.' value="'.strip_tags($select_value).'">'.$v.'</option>';
		}
		$select .= '</select>';
		return $select;
	}
	
	static public function checkbox($args, $info = array()){
		extract($args);
		$html = '';
		$int_val = isset($info[$name]) ? $info[$name] : $int_val;
		$int_val_arr = is_array($int_val) ? $int_val : array($int_val);
		foreach($option_arr as $k => $v){
			$checked = in_array($k, $int_val_arr) ? 'checked="checked"' : '';
			$html .= '<input '.$checked.' id="'.$name.$k.'" name="'.$name.'[]" type="checkbox" value="'.$k.'" /><label for="'.$name.$k.'">'.$v.'</label>';
		}
		return $html;
	}
	
	
	static public function show_page_rank($pr){
		if(!in_array($data, range(0,9)))  $pr = 0;
		return '<img src="'.PLUGIN_URL.'/static/image/ranks/Rank_'.$pr.'.gif" width="45" height="20" />';
	}
	
	static public function show_baidu_rank($data){
		if(!in_array($data, range(0,9))) $data = 0;
		return '<img src="'.PLUGIN_URL.'/static/image/baiduapp/'.$data.'.gif" width="45" height="20" />';
	}
	
	static public function dateline($args, $info){
		global $_G;
		extract($args);
		$date_str = $date_type == 2 ? 'Y-m-d' : 'Y-m-d H:i';
		$length = $length ? $length : 2;
		$name_start = $name_arr[0] ? $name_arr[0] : $name.'_start';
		$name_end = $name_arr[1] ? $name_arr[1] : $name.'_end';
		$min_dateline = $_G['timestamp'] - 20*360*24*3600;//时间戳小于这个数，就不转换
		$start_time = ($info[$name_start] && is_int($info[$name_start]) && $info[$name_start] > $min_dateline) ? date($date_str, $info[$name_start]) : $info[$name_start];
		$end_time = ($info[$name_end] && is_int($info[$name_end]) && $info[$name_end] > $min_dateline) ? date($date_str, $info[$name_end]) : $info[$name_end];
		return '<script src="static/js/calendar.js?3R4" type="text/javascript" type="text/javascript"></script><input name="set['.$name_start.']" type="text" onclick="showcalendar(event, this, false)" value="'.$start_time.'" class="px length_'.$length.' '.$date_type.' mr20"><span class="mr20">'.stlang('_to').'</span><input name="set['.$name_end.']" type="text" value="'.$end_time.'" onclick="showcalendar(event, this, false)" class="px length_'.$length.' '.$date_type.' mr20">';	
	}
	
	static public function show_qq($qq, $style = 0){
		if(!$qq) return;
		return $style == 1 ? '<a target="_blank" style="float:left; width:23px; display:block; text-align:right" href="http://wpa.qq.com/msgrd?v=3&amp;uin='.$qq.'&amp;site=qq&amp;menu=yes"><img style="float:rigth; cursor:pointer" border="0" src="http://wpa.qq.com/pa?p=1:'.$qq.':4&i='.time().'" alt="'.stlang('hits_send_msg').'" title="'.stlang('hits_send_msg').'"></a>' : '<a target="_blank"  href="http://wpa.qq.com/msgrd?v=3&amp;uin='.$qq.'&amp;site=qq&amp;menu=yes"><img style=cursor:pointer" border="0" src="http://wpa.qq.com/pa?p=1:'.$qq.':4&i='.time().'" alt="'.stlang('hits_send_msg').'" title="'.stlang('hits_send_msg').'"></a>';
	}
	
	static public function user_group_select($name, $ini_val = array(), $args = array()){
		global $_G,$lang;
		extract($args);
		$name = $name ? $name : 'groupid';
		$groupselect = array();
		$usergroupid = $ini_val;
		$query = DB::query("SELECT type, groupid, grouptitle, radminid FROM ".DB::table('common_usergroup')." WHERE groupid NOT IN ('6', '7') ORDER BY (creditshigher<>'0' || creditslower<>'0'), creditslower, groupid");
		while($group = DB::fetch($query)) {
			if($group_arr && !in_array($group['type'], $group_arr)) continue;
			$group['type'] = $group['type'] == 'special' && $group['radminid'] ? 'specialadmin' : $group['type'];
			$groupselect[$group['type']] .= "<option value=\"$group[groupid]\" ".(in_array($group['groupid'], $usergroupid) ? 'selected' : '').">$group[grouptitle]</option>\n";
		}
		$groupselect = ($groupselect['member'] ? '<optgroup label="'.$lang['usergroups_member'].'">'.$groupselect['member'].'</optgroup>' : '').
			($groupselect['special'] ? '<optgroup label="'.$lang['usergroups_special'].'">'.$groupselect['special'].'</optgroup>' : '').
			($groupselect['specialadmin'] ? '<optgroup label="'.$lang['usergroups_specialadmin'].'">'.$groupselect['specialadmin'].'</optgroup>' : '').
			'<optgroup label="'.$lang['usergroups_system'].'">'.$groupselect['system'].'</optgroup>';
		return '<select name="'.$name.'[]" multiple="multiple" size="10">'.($no_epmty ? '' : '<option value="">'.stlang('empty').'</option>').$groupselect.'</select>';
	}
	
	static public function show_tips($msg, $args = array()){
		extract($args);
		$title = $title ? $title : stlang('msg_notice');
		$w = $w ? $w : 600;
		$h = $h ? $h : 387;
		$html = '<script type="text/javascript" language="javascript">
	show_html_window(\''.$key.'\', \'<em>'.$title.'</em>\', '.$w.', '.$h.', \'<div class="c bart" style=" width:100%; height:'.($h - 60).'px;">'.$msg.'</div><p class="o pns"><button onclick="plugin_tips(\\\''.$key.'\\\');hideWindow(\\\''.$key.'\\\');" class="pn pnc" name="dsf" type="submit"><span>'.stlang('never_notice').'</span></button></p>\');</script>';
		return $html;
	}
	//$type right error notice
	static public function show_status($type = 'right'){
		return '<span class="status_'.$type.'"></span>';
	}
	

}
?>