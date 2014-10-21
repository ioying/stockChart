<?php
/**
 * LLV(x,n) 求N周期内 X 的最低值 
 * @Ioying@hotmail.com  2014 02 28 已优化 +新-旧 ，计算时间与周期数不再倍增
 * $LlvStr LLV(x,n)(x,n); x : 计算项，n：周期数  n为负数时取绝对值，n为0时 周期为所有数据999999 * 无须返回值  * 
 * 如错误处理需要，可返回错误信息。
 */
function my_func_llv($LlvStr) 
{
    global $i, $arrtest, $key, $error_zero; //	echo '<br/>before make str $LlvStr:'.$LlvStr.'$key:'.$key.'<br/>';	
		$LlvStr = make_str($LlvStr);   			//	echo '<br/>func ma() $LlvStr:'.$LlvStr.'<br/>';
		$exec_lines = preg_split('/,/', $LlvStr);
		$LlvMethod = trim($exec_lines[0]);
		$k	=	1; 	//很重要哦，$LlvPeriod=$arrtest['x'][$k] 中$k 没赋值，这个$k与下面循环中的$k没关系
    eval("\$LlvPeriod=" . $exec_lines[1] . ';'); 
		$LlvPeriod = abs($LlvPeriod);
    if($LlvPeriod == 0) $LlvPeriod=999999; 	//    	echo '<br/>LlvMethod:'.$LlvMethod.' **** Period:'.$LlvPeriod.'*** i:'.$i.' <br>  ';
    //		echo '  $i-($LlvPeriod-1):',$i-($LlvPeriod-1).' <br>  ';
	//	$llvtem = 0;
    for ($x = 1; $x <= $i; $x++)
    {
		if ($x - $LlvPeriod  > 0){ //		echo ">0\$Llvtem=\$Llvtem+" . $LlvMethod . ';<br>';
			$k = $x;
			eval("\$Llvtem[\$x]=" . $LlvMethod . ';'); 
			$k = $x - $LlvPeriod ;
			unset($Llvtem[$k]);

			$xxx = min($Llvtem);  //

			$error_zero = 0; //除零错误 0无 1有 //			echo '<br>>0$x:'.$x.'$k:'.$k.'$Llvtem:'.$Llvtem.' xxx:'.$xxx;
		}else{
//			$llvtem[$x]=
			$k = $x; //		echo "<=0\$Llvtem=\$Llvtem+" . $LlvMethod . ';<br>';
			eval("\$Llvtem[\$x]=" . $LlvMethod . ';'); 
			$xxx = min($Llvtem);  //			echo '<br><0$x:'.$x.'$k:'.$k.'$Llvtem:'.$Llvtem.' xxx:'.$xxx;
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