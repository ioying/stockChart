<?php
function showstars($num) {
	global $_G;
	$alt = 'alt="Rank: '.$num.'"';
	$str="";
	if(empty($_G['setting']['starthreshold'])) {
		for($i = 0; $i < $num; $i++) {
			$str=$str.'static/image/common/star_level1.gif|';
		}
	} else {
		for($i = 3; $i > 0; $i--) {
			$numlevel = intval($num / pow($_G['setting']['starthreshold'], ($i - 1)));
			$num = ($num % pow($_G['setting']['starthreshold'], ($i - 1)));
			for($j = 0; $j < $numlevel; $j++) {
				$str=$str.'static/image/common/star_level'.$i.'.gif|';
			}
		}
	}
	return $str;
}
?>
