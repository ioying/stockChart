<?php
if (! defined ( 'IN_DISCUZ' ) || ! defined ( 'IN_ADMINCP' )) {
	exit ( 'Access Denied' );
}

if (! submitcheck ( 'settingsubmit', 1 )) {
	
	showformheader ( 'plugins&operation=config&do=' . $pluginid . '&identifier=tsound_wenda&pmod=category&act=' . $act . '&id=' . $id, 'enctype' );
	
	showtableheader ( lang ( 'plugin/tsound_wenda', $act == 'add' ? 'addcategory2' : 'editcategory2' ) );
	
	showsetting ( lang ( 'plugin/tsound_wenda', 'categoryparent' ), '', '', $categoryparent );
	
	$data = array ();
	foreach ( array ('default', 'none', 'help' ) as $v ) {
		$data [] = array ($v, lang ( 'plugin/tsound_wenda', 'category_' . $v ) );
	}
	showsetting ( lang ( 'plugin/tsound_wenda', 'categoryname' ), 'onez[name]', $onez ['name'], 'text' );
	showsetting ( lang ( 'plugin/tsound_wenda', 'categoryreadme' ), 'onez[readme]', $onez ['readme'], 'textarea' );
	showsetting ( lang ( 'plugin/tsound_wenda', 'categorystep' ), 'onez[step]', ( int ) $onez ['step'], 'number' );
	
	//add by genee 20130429 start
	$categorymodule = 'source/plugin/tsound_wenda/include/include_category_module.inc.php';
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
		DB::insert ( 'tsound_wenda_category', $onez );
	} else {
		DB::update ( 'tsound_wenda_category', $onez, "cid='$id'" );
	}
	cpmsg ( lang ( 'plugin/tsound_wenda', 'done_successfully' ), 'action=plugins&operation=config&do=' . $pluginid . '&identifier=tsound_wenda&pmod=category', 'succeed' );
}
?>
