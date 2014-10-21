<?php
/**
 *      [G1 Studio!] (C)2012-2013.
 *
 *      $Id: xm.inc.php 29558 2013-03-07 11:15 genee $
 */
if (! defined ( 'IN_DISCUZ' )) {
	exit ( 'Access Denied' );
}
global $_G;
$cvar = $_G ['cache'] ['plugin'] ['tsound_wenda'];
$qid = addslashes ( $_GET ['qid'] );
$credit = 0;
if ($_G ['uid']) {
	$ispay = DB::fetch_first ( "SELECT * FROM " . DB::table ( "tsound_wenda_paylog" ) . " WHERE qid='$qid' and uid='$_G[uid]' " );
	if (! empty ( $ispay )) {
		include template ( 'tsound_wenda:pay1' );
		
	} else {
		
		$currtime1 = date ( "Y-m-d H:i:s", time () );
		
		$r = DB::fetch_first ( "SELECT * FROM " . DB::table ( "common_member_count" ) . " WHERE uid='$_G[uid]'" );
		$rs = DB::fetch_first ( "SELECT * FROM " . DB::table ( "tsound_wenda_question" ) . " WHERE qid='$qid' " );
		if ($r)
			$credit = $r ['extcredits' . $cvar ['pay_type']];
		
		if ($_GET ['submit'] != 'yes') {
			include template ( 'tsound_wenda:pay' );
		} else {
			
			if ($credit >= $rs ['readpay']) {
				updatemembercount ( $_G ['uid'], array ('extcredits' . $cvar ['pay_type'] => "-" . $rs ['readpay'] ), true, '', 0, '' );
				updatemembercount ( $rs ['uid'], array ('extcredits' . $cvar ['pay_type'] => $rs ['readpay'] ), true, '', 0, '' );
				
				DB::query ( "INSERT INTO " . DB::table ( 'tsound_wenda_paylog' ) . " (qid,   uid,create_time) VALUES ('$qid',  '$_G[uid]', '$currtime1')" );
				
				showmessage ( lang ( 'plugin/tsound_wenda', 'gvar12' ), $_SERVER ['HTTP_REFERER'], '', array ('showmsg' => lang ( 'plugin/tsound_wenda', 'gvar12' ) ) );
			} else {
				showmessage ( lang ( 'plugin/tsound_wenda', 'gvar13' ), $_SERVER ['HTTP_REFERER'], '', array ('showmsg' => lang ( 'plugin/tsound_wenda', 'gvar13' ) ) );
			}
		}
	
	}
} else {
	showmessage ( 'to_login', NULL, array (), array ('login' => 1 ) );
}

?>