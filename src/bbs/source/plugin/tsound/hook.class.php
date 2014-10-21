<?php
/**
 *	[������(sound.{modulename})] (C)2012-2099 Powered by .
 *	Version: 1.0
 *	Date: 2012-12-20 16:48
 */

if (! defined ( 'IN_DISCUZ' )) {
	exit ( 'Access Denied' );
}
class plugin_tsound {
	public function global_header() {
		
		return '<link href="source/plugin/tsound/template/images/style.css" rel="stylesheet" type="text/css" />';
	}
	public function discuzcode() {
		global $tsound, $_G;
		require_once DISCUZ_ROOT . './source/plugin/tsound/include/function.inc.php';
		$_G ['discuzcodemessage'] = preg_replace ( "/\[tsound\]([^\[]+)\[\/tsound\]/ies", "tsound_parse('\\1','$_G[fid]','$_G[tid]','$_G[pid]')", $_G ['discuzcodemessage'] );
	}
}

class plugin_tsound_forum extends plugin_tsound {
	function forumdisplay_postbutton_top() {
		//return;
		global $tsound, $_G;
		require_once DISCUZ_ROOT . './source/plugin/tsound/include/function.inc.php';
		$groups = ( array ) @unserialize ( $tsound ['groups'] );
		if (! in_array ( $_G ['groupid'], $groups ))
			return;
		$forums = ( array ) @unserialize ( $tsound ['forums'] );
		if (! in_array ( $_G ['fid'], $forums ))
			return;
		$fid = $_G ['fid'];
		$data = '';
		if ($tsound ['btn']) {
			$data .= '<img src="./source/plugin/tsound/template/button.gif" onclick="showWindow(\'tsound\', \'' . BASEURL . 'action=select&fid=' . $fid . '\')" style="cursor:pointer" title="' . lang ( 'plugin/tsound', 'select' ) . '" />';
		}
		return $data;
	}
	function viewthread_postbutton_top() {
		global $tsound, $_G;
		require_once DISCUZ_ROOT . './source/plugin/tsound/include/function.inc.php';
		$groups = ( array ) @unserialize ( $tsound ['groups'] );
		if (! in_array ( $_G ['groupid'], $groups ))
			return;
		$forums = ( array ) @unserialize ( $tsound ['forums'] );
		if (! in_array ( $_G ['fid'], $forums ))
			return;
		$fid = $_G ['fid'];
		$data = '';
		if ($tsound ['btn']) {
			$data .= '<img src="./source/plugin/tsound/template/button.gif" onclick="showWindow(\'tsound\', \'' . BASEURL . 'action=select&fid=' . $fid . '\')" style="cursor:pointer" title="' . lang ( 'plugin/tsound', 'select' ) . '" />';
		}
		return $data;
	}
	function post_editorctrl_left() {
		global $tsound, $_G;
		
		require_once DISCUZ_ROOT . './source/plugin/tsound/include/function.inc.php';
		return tsound_button ( $_G ['onez_action'] == 'newthread' ? 1 : 0 );
	}
	function viewthread_fastpost_ctrl_extra() {
		global $tsound, $_G;
		require_once DISCUZ_ROOT . './source/plugin/tsound/include/function.inc.php';
		return tsound_button ( 0 );
	}
	function post_middle() {
		global $tsound, $_G;
		require_once DISCUZ_ROOT . './source/plugin/tsound/include/function.inc.php';
		$groups = ( array ) @unserialize ( $tsound ['groups'] );
		if (! in_array ( $_G ['groupid'], $groups ))
			return;
		$forums = ( array ) @unserialize ( $tsound ['forums'] );
		if (! in_array ( $_G ['fid'], $forums ))
			return;
		$auto = $_G ['onez_auto'];
		$baseurl = BASEURL;
		if ($auto == 'audio') {
			return <<<ONEZ
<script>
showWindow('tsound', '{$baseurl}action=record&type=audio&isthread=1');
</script>
ONEZ;
		} elseif ($auto == 'video') {
			return <<<ONEZ
<script>
showWindow('tsound', '{$baseurl}action=record&type=video&isthread=1');
</script>
ONEZ;
		}
	}
	
	function forumdisplay_thread_subject_output() {
		global $_G, $threadlist;
		$tsoundthread = DB::fetch_all("SELECT r.*,m.username,t.subject as thread FROM ".DB::table('tsound_record')." r left join ".DB::table('common_member')." m on m.uid=r.uid left join  ".DB::table('forum_thread')." t on t.tid=r.tid where r.status>0 ");
		
		foreach ( $tsoundthread as $tsound ) {
			$ts [] = $tsound ['tid'];
		}
		
		foreach ( $_G ['forum_threadlist'] as $k => $thread ) {
			if (in_array ( $thread ['tid'], $ts )) {
				 
					$var [$k] = '<img style="padding-top:2px;" src="source/plugin/tsound/template/images/tsound_small.png" />';
			
			}
		}
		return $var;
	}
}


class plugin_tsound_home extends plugin_tsound {
	function spacecp_blog_top() {
		global $tsound, $_G;
		require_once DISCUZ_ROOT . './source/plugin/tsound/include/function.inc.php';
		return tsound_button ( $_G ['onez_action'] == 'newthread' ? 1 : 0 );
	}
}

?>