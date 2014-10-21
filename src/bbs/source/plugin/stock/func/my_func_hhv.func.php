<?php
/**
 * hhv(x,n) 求N周期内 X 的最高值 
 * @Ioying@hotmail.com  2014 02 28 已优化 +新-旧 ，计算时间与周期数不再倍增
 * $hhvStr hhv(x,n)(x,n); x : 计算项，n：周期数  n为负数时取绝对值，n为0时 周期为所有数据999999 * 无须返回值  * 
 * 如错误处理需要，可返回错误信息。
 */
function my_func_hhv($hhvStr) 
{
    global $i, $arrtest, $key, $error_zero; //	echo '<br/>before make str $hhvStr:'.$hhvStr.'$key:'.$key.'<br/>';	
		$hhvStr = make_str($hhvStr);   			//	echo '<br/>func ma() $hhvStr:'.$hhvStr.'<br/>';
		$exec_lines = preg_split('/,/', $hhvStr);
		$hhvMethod = trim($exec_lines[0]);
		$k	=	1; 	//很重要哦，$hhvPeriod=$arrtest['x'][$k] 中$k 没赋值，这个$k与下面循环中的$k没关系
    eval("\$hhvPeriod=" . $exec_lines[1] . ';'); 
		$hhvPeriod = abs($hhvPeriod);
    if($hhvPeriod == 0) $hhvPeriod=999999; 	//    	echo '<br/>hhvMethod:'.$hhvMethod.' **** Period:'.$hhvPeriod.'*** i:'.$i.' <br>  ';
    //		echo '  $i-($hhvPeriod-1):',$i-($hhvPeriod-1).' <br>  ';
	//	$hhvtem = 0;
    for ($x = 1; $x <= $i; $x++)
    {
		if ($x - $hhvPeriod  > 0){ //		echo ">0\$hhvtem=\$hhvtem+" . $hhvMethod . ';<br>';
			$k = $x;
			eval("\$hhvtem[\$x]=" . $hhvMethod . ';'); 
			$k = $x - $hhvPeriod ;
			unset($hhvtem[$k]);

			$xxx = max($hhvtem);  //

			$error_zero = 0; //除零错误 0无 1有 //			echo '<br>>0$x:'.$x.'$k:'.$k.'$hhvtem:'.$hhvtem.' xxx:'.$xxx;
		}else{
//			$hhvtem[$x]=
			$k = $x; //		echo "<=0\$hhvtem=\$hhvtem+" . $hhvMethod . ';<br>';
			eval("\$hhvtem[\$x]=" . $hhvMethod . ';'); 
			$xxx = max($hhvtem);  //			echo '<br><0$x:'.$x.'$k:'.$k.'$hhvtem:'.$hhvtem.' xxx:'.$xxx;
			$error_zero = 0; //除零错误 0无 1有
		}
        if ($error_zero == 0){
            $arrtest[$key][$x] = $xxx;
        }else{
            $arrtest[$key][$x] = 0;
        }
	}		
 //   return $xxx;
}

?>