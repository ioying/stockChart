<?php
if (! defined ( 'IN_DISCUZ' ) || ! defined ( 'IN_ADMINCP' )) {
	exit ( 'Access Denied' );
}
require_once DISCUZ_ROOT . './source/plugin/tsound_wenda/include/function.inc.php';
//add by genee 20130429 start
$authoritymodule = 'source/plugin/tsound_wenda/include/include_authority_module.inc.php';
if (file_exists ( $authoritymodule )) {
	require_once ($authoritymodule);
}
//add by genee 20130429 end



?>