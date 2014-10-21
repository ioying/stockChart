<?php
if (! defined ( 'IN_DISCUZ' ) || ! defined ( 'IN_ADMINCP' )) {
	exit ( 'Access Denied' );
}

if (! submitcheck ( 'settingsubmit', 1 )) {
	
	showformheader ( 'plugins&operation=config&do=' . $pluginid . '&identifier=linkscheer&pmod=category&act=' . $act . '&id=' . $id, 'enctype' );
	
	showtableheader ( lang ( 'plugin/linkscheer', $act == 'add' ? 'addcategory2' : 'editcategory2' ) );
	
	showsetting ( lang ( 'plugin/linkscheer', 'categoryparent' ), '', '', $categoryparent );
	
	$data = array ();
	foreach ( array ('default', 'none', 'help' ) as $v ) {
		$data [] = array ($v, lang ( 'plugin/linkscheer', 'category_' . $v ) );
	}
	showsetting ( lang ( 'plugin/linkscheer', 'categoryname' ), 'onez[name]', $onez ['name'], 'text' );
	showsetting ( lang ( 'plugin/linkscheer', 'categoryreadme' ), 'onez[readme]', $onez ['readme'], 'textarea' );
	showsetting ( lang ( 'plugin/linkscheer', 'categorystep' ), 'onez[step]', ( int ) $onez ['step'], 'number' );
	
	//add by genee 20130429 start
	$categorymodule = 'source/plugin/linkscheer/include/include_category_module.inc.php';
	if (file_exists ( $categorymodule )) {
		require_once ($categorymodule);
	}
	//add by genee 20130429 end

	showsubmit ( 'settingsubmit', 'submit', '', "<input type=\"hidden\" name=\"onez[pcid]\" value=\"$onez[pcid]\">" );
	showtablefooter ();
	showformfooter ();
} else {
	$onez = ( array ) $_G ['onez_onez'];
	$onez ['authority'] = serialize ( $onez ['authority'] );
	if ($act == 'add') {
		DB::insert ( 'linkscheer_category', $onez );
	} else {
		DB::update ( 'linkscheer_category', $onez, "cid='$id'" );
	}
	cpmsg ( lang ( 'plugin/linkscheer', 'done_successfully' ), 'action=plugins&operation=config&do=' . $pluginid . '&identifier=linkscheer&pmod=category', 'succeed' );
}
?>
