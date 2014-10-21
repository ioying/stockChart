<?php

global $_G, $tsound_wenda;
foreach ( $_GET as $k => $v ) {
	$_G ['onez_' . $k] = function_exists ( 'daddslashes' ) ? daddslashes ( $v ) : $v;
}
foreach ( $_POST as $k => $v ) {
	$_G ['onez_' . $k] = function_exists ( 'daddslashes' ) ? daddslashes ( $v ) : $v;
}
$tsound_wenda = $_G ['cache'] ['plugin'] ['tsound_wenda'];

function tsound_wenda_flashToDz($str) {
	global $_G;
	if (strtolower ( $_G ['charset'] ) != 'utf-8') {
		if (is_array ( $str )) {
			foreach ( $str as $k => $v ) {
				$str [$k] = tsound_wenda_flashToDz ( $v );
			}
		} else {
			$str = tsound_wenda_oiconv ( 'utf-8', $_G ['charset'], $str );
		}
	}
	return $str;
}
function tsound_wenda_dzToFlash($str) {
	global $_G;
	if (strtolower ( $_G ['charset'] ) != 'utf-8') {
		if (is_array ( $str )) {
			foreach ( $str as $k => $v ) {
				$str [$k] = tsound_wenda_dzToFlash ( $v );
			}
		} else {
			$str = tsound_wenda_oiconv ( $_G ['charset'], 'utf-8', $str );
		}
	}
	return $str;
}
function tsound_wenda_oiconv($from, $to, $string) {
	if (function_exists ( 'mb_convert_encoding' )) {
		return mb_convert_encoding ( $string, $to, $from );
	} else {
		return iconv ( $from, $to, $string );
	}
}
function tsound_wenda_upload() {
	global $tsound_wenda, $_G;
	
	$token = 'data';
	$name = $_FILES [$token] ['name'];
	$_FILES [$token] ['error'] && exit ( 'Error' );
	if (! $_FILES [$token] ['tmp_name']) {
		return 'none';
	}
	$filetype = strtolower ( end ( explode ( '.', $name ) ) );
	if ($filetype != 'mp3')
		exit ( 'Error Format' );
	$soundpath = dirname ( dirname ( __FILE__ ) ) . '/data';
	if (! file_exists ( $soundpath ))
		@mkdir ( $soundpath, 0777 );
	@touch ( "$soundpath/index.html" );
	$key = uniqid ();
	$file = $key . '.' . $filetype;
	if (@copy ( $_FILES [$token] ['tmp_name'], $soundpath . '/' . $file )) {
		$succeed = true;
	} elseif (function_exists ( 'move_uploaded_file' ) && @move_uploaded_file ( $_FILES [$token] ['tmp_name'], $path . '/' . $file )) {
		$succeed = true;
	}
	$file = 'source/plugin/tsound_wenda/data/' . $key . '.mp3';
	
	if ($succeed) {
		$rid = ( int ) $_G ['onez_rid'];
		$size = ( int ) $_G ['onez_size'];
		$sec = ( int ) $_G ['onez_sec'];
		$rid = DB::insert ( 'tsound_wenda_record', array ('uid' => $_G ['uid'], 'time' => TIMESTAMP, 'status' => '1', 'type' => 'audio', 'size' => $size, 'sec' => $sec, 'file' => $file ), 1 );
		return 'ok' . $rid . '|' . $_G ['siteurl'] . '/' . $file;
	} else {
		exit ( 'Can not write to cache files, please check directory ./' . $soundpath . '/ .' );
	}
}
function tsound_wenda_addpic() {
	global $tsound_wenda, $_G;
	
	$token = 'Filedata';
	$name = $_FILES [$token] ['name'];
	$_FILES [$token] ['error'] && exit ( 'Error' );
	if (! $_FILES [$token] ['tmp_name']) {
		return 'none';
	}
	$filetype = strtolower ( end ( explode ( '.', $name ) ) );
	if (! in_array ( $filetype, array ('gif', 'jpg', 'jpeg', 'png' ) ))
		exit ( 'Error Format' );
	$soundpath = dirname ( dirname ( __FILE__ ) ) . '/data';
	if (! file_exists ( $soundpath ))
		@mkdir ( $soundpath, 0777 );
	@touch ( "$soundpath/index.html" );
	$key = uniqid ();
	$file = $key . '.jpg';
	if (@copy ( $_FILES [$token] ['tmp_name'], $soundpath . '/' . $file )) {
		$succeed = true;
	} elseif (function_exists ( 'move_uploaded_file' ) && @move_uploaded_file ( $_FILES [$token] ['tmp_name'], $path . '/' . $file )) {
		$succeed = true;
	}
	$file = 'source/plugin/tsound_wenda/data/' . $key . '.' . $filetype;
	
	if ($succeed) {
		return 'ok[P=' . $key . ']';
	} else {
		exit ( 'Can not write to cache files, please check directory ./' . $soundpath . '/ .' );
	}
}
function tsound_wenda_ubb($str) {
	$str = preg_replace ( '/\[P=([a-z0-9]+)\]/i', '<img src="source/plugin/tsound_wenda/data/$1.jpg" onload="if(this.width>600)this.width=600" />', $str );
	return $str;
}
function tsound_wenda_player($rid) {
	global $_G;
	if (! $rid)
		return;
	if (! is_numeric ( $rid )) {
		$file = $_G ['siteurl'] . '/' . $rid;
	} else {
		$T = DB::fetch_first ( 'SELECT * FROM ' . DB::table ( 'tsound_wenda_record' ) . ' where rid=' . $rid );
		if (! $T ['file'])
			return;
		$file = $_G ['siteurl'] . '/' . $T ['file'];
	}
	return tsound_wenda_insertflash ( 'source/plugin/tsound_wenda/template/player.swf', 'son=' . $file, 100, 40, 'player' );
}
function tsound_wenda_insertflash($Flash, $Vars, $width, $Height, $ID) {
	strpos ( $Flash, '?' ) === false && $Flash .= '?t=' . @filemtime ( $Flash );
	$fullcode = 0;
	if ($fullcode) {
		$FlashHtml = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" ';
		$FlashHtml .= 'codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" ';
		$FlashHtml .= 'width="' . $width . '" height="' . $Height . '" id="' . $ID . '">';
		$FlashHtml .= '<param name="movie" value="' . $Flash . '">';
		$FlashHtml .= '<param name="quality" value="high">';
		$FlashHtml .= '<param name="allowFullScreen" value="true">';
		$FlashHtml .= '<param name="wmode" value="transparent">';
		$FlashHtml .= '<param name="allowscriptaccess" value="always">';
		$FlashHtml .= '<param name="FlashVars" value="' . $Vars . '">';
	}
	$FlashHtml .= '<embed src="' . $Flash . '" name="' . $ID . '" quality="high" allowscriptaccess="always" pluginspage="http://www.macromedia.com/go/getflashplayer" ';
	$FlashHtml .= 'type="application/x-shockwave-flash" width="' . $width . '" FlashVars="' . $Vars . '" wmode="transparent" allowFullScreen="true" height="' . $Height . '"></embed>';
	if ($fullcode) {
		$FlashHtml .= '</object>';
	}
	return $FlashHtml;
}
function tsound_wenda_json($a = false) {
	if (is_null ( $a ))
		return 'null';
	if ($a === false)
		return 'false';
	if ($a === true)
		return 'true';
	if (is_scalar ( $a )) {
		if (is_float ( $a )) {
			return floatval ( str_replace ( ",", ".", strval ( $a ) ) );
		}
		if (is_string ( $a )) {
			$jsonReplaces = array (array ("\\", "/", "\n", "\t", "\r", "\b", "\f", '"' ), array ('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"' ) );
			return '"' . str_replace ( $jsonReplaces [0], $jsonReplaces [1], $a ) . '"';
		} else {
			return $a;
		}
	}
	$isList = true;
	for($i = 0, reset ( $a ); $i < count ( $a ); $i ++, next ( $a )) {
		if (key ( $a ) !== $i) {
			$isList = false;
			break;
		}
	}
	$result = array ();
	if ($isList) {
		foreach ( $a as $v )
			$result [] = tsound_wenda_json ( $v );
		return '[' . join ( ',', $result ) . ']';
	} else {
		foreach ( $a as $k => $v )
			$result [] = tsound_wenda_json ( $k ) . ':' . tsound_wenda_json ( $v );
		return '{' . join ( ',', $result ) . '}';
	}
}
function tsound_wenda_addcontent($basecontent, $content, $type, $uid, $rid) {
	return "$basecontent$\t$\t$" . implode ( "#\t#\t#", array ($content, $type, $uid, $rid ) );
}
function tsound_wenda_content($T, $q = 1) {
	global $baseurl, $A, $Q, $_G;
	$S = array ('content' => '', 'other' => array (), 'buttons' => array (), 'next' => '' );
	
	foreach ( explode ( "$\t$\t$", $T ['content'] ) as $V ) {
		list ( $content, $type, $uid, $rid ) = explode ( "#\t#\t#", $V );
		$content = tsound_wenda_ubb ( $content );
		if ($type) {
			$S ['other'] [] = array ('type' => $type, 'content' => $content, 'rid' => $rid );
		} else {
			$S ['content'] .= $content . ' ' . (tsound_wenda_player ( $T ['rid'] ? $T ['rid'] : $T ['file'] ));
		}
		$S ['next'] = '';
		if (! $q) {
			if ($Q ['uid'] == $_G ['uid'] && $uid != $Q ['uid']) {
				$S ['next'] = array ('f', $_G ['uid'] );
			}
			if ($T ['uid'] == $_G ['uid'] && $uid != $T ['uid'] && $uid) {
				$S ['next'] = array ('a', $_G ['uid'] );
			}
		}
	}
	if ($q) {
		if ($T ['uid'] == $_G ['uid'] && ! $A) {
			$S ['buttons'] [] = '<button onclick="showWindow(\'tsound_wenda_other\', \'' . $baseurl . '&action=question_other&qid=' . $T ['qid'] . '\')" class="pn pnc"><strong>' . lang ( 'plugin/tsound_wenda', 'other_b' ) . '</strong></button>';
			$S ['buttons'] [] = '<button onclick="showWindow(\'tsound_wenda_other\', \'' . $baseurl . '&action=coinadd&qid=' . $T ['qid'] . '\')" class="pn pnc"><strong>' . lang ( 'plugin/tsound_wenda', 'coinadd' ) . '</strong></button>';
		
		}

		$deletemodule = 'source/plugin/tsound_wenda/include/include_coindelete1.inc.php';
		if (file_exists ( $deletemodule )) {
			require_once ($deletemodule);
		}
	} else {
		if (! $Q ['aid']) {
			if ($Q ['uid'] == $_G ['uid'] && $T ['uid'] != $_G ['uid']) {
				$S ['buttons'] [] = '<form action="' . $baseurl . '&action=setbest&qid=' . $T ['qid'] . '&aid=' . $T ['aid'] . '" method="post"><button type="submit" class="pn pnc"><strong>' . lang ( 'plugin/tsound_wenda', 'setbest' ) . '</strong><input name="aid" type="hidden" value="' . $T ['aid'] . '"></button></form>';
			}
			if ($S ['next'] [0] == 'f') {
				$S ['buttons'] [] = '<button onclick="showWindow(\'tsound_wenda_other\', \'' . $baseurl . '&action=answer_other&type=f&aid=' . $T ['aid'] . '\')" class="pn pnc"><strong>' . lang ( 'plugin/tsound_wenda', 'other_f' ) . '</strong></button>';
			} elseif ($S ['next'] [0] == 'a') {
				$S ['buttons'] [] = '<button onclick="showWindow(\'tsound_wenda_other\', \'' . $baseurl . '&action=answer_other&type=a&aid=' . $T ['aid'] . '\')" class="pn pnc"><strong>' . lang ( 'plugin/tsound_wenda', 'other_a' ) . '</strong></button>';
			}
		}
	}
	$data = '<div class="wd_co">' . $S ['content'] . '</div>';
	$data .= '<ul class="wd_other">';
	foreach ( $S ['other'] as $v ) {
		$data .= '<li>';
		$data .= '<div class="wd_l c_' . $v ['type'] . '">' . lang ( 'plugin/tsound_wenda', 'other_' . $v ['type'] ) . '</div>';
		$data .= '<div class="wd_r">' . $v ['content'] . tsound_wenda_player ( $v ['rid'] ) . '</div>';
		$data .= '<div class="wd_cl"></div>';
		$data .= '</li>';
	}
	$data .= '</ul>';
	$btns = '';
	if ($S ['buttons']) {
		$btns .= '<table><tr>';
		foreach ( $S ['buttons'] as $v ) {
			$btns .= '<td>' . $v . '</td>';
		}
		$btns .= '</tr></table>';
	}
	return array ($data, $btns );
}

function getIp1() {
	if (getenv ( "HTTP_CLIENT_IP" ) && strcasecmp ( getenv ( "HTTP_CLIENT_IP" ), "unknown" ))
		$ip = getenv ( "HTTP_CLIENT_IP" );
	else if (getenv ( "HTTP_X_FORWARDED_FOR" ) && strcasecmp ( getenv ( "HTTP_X_FORWARDED_FOR" ), "unknown" ))
		$ip = getenv ( "HTTP_X_FORWARDED_FOR" );
	else if (getenv ( "REMOTE_ADDR" ) && strcasecmp ( getenv ( "REMOTE_ADDR" ), "unknown" ))
		$ip = getenv ( "REMOTE_ADDR" );
	else if (isset ( $_SERVER ['REMOTE_ADDR'] ) && $_SERVER ['REMOTE_ADDR'] && strcasecmp ( $_SERVER ['REMOTE_ADDR'], "unknown" ))
		$ip = $_SERVER ['REMOTE_ADDR'];
	else
		$ip = "unknown";
	return ($ip);
}
?>