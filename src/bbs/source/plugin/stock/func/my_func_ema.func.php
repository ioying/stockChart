<?php
/**求指数平滑移动平均。
 *用法: EMA(X,N),求X的N日指数平滑移动平均。算法：若Y=EMA(X,N)
 *则Y=[2*X+(N-1)*Y']/(N+1),其中Y'表示上一周期Y值。
 *例如：EMA(CLOSE,30)表示求30日指数平滑均价
 * @Ioying@hotmail.com  2014 02 28  开始使用驼峰命名，尽量不用 "_"
 * $MAStr Ema(x,n); x : 计算项，n：周期数    * 无须返回值  如错误处理需要，可返回错误信息。
 */
function my_func_ema($MAStr) 
{
    global $i, $arrtest, $key, $error_zero; //	echo '<br/>before make str $MAStr:'.$MAStr.'$key:'.$key.'<br/>';	
		$MAStr = make_str($MAStr);   			//	echo '<br/>func ma() $MAStr:'.$MAStr.'<br/>';
		$ExecLines = preg_split('/,/', $MAStr);
		$MaMethod = trim($ExecLines[0]);
		$k	=	1; 	//很重要哦，$MaPeriod=$arrtest['x'][$k] 中$k 没赋值，这个$k与下面循环中的$k没关系
/*     if (eval("\$MaPeriod=" . $ExecLines[1] . ';')){  // 尝试错误处理, eval 错误 返回 false
	echo '---error:::';
	}else{
	echo '---real error:::';
	} */
	eval("\$MaPeriod=" . $ExecLines[1] . ';');
		$MaPeriod = abs($MaPeriod);
    if($MaPeriod<1) $MaPeriod=1; 	//    	echo '<br/>MaMethod:'.$MaMethod.' **** Period:'.$MaPeriod.'*** i:'.$i.' <br>  ';
    //		echo '  $i-($MaPeriod-1):',$i-($MaPeriod-1).' <br>  ';
		$MaTem = 0;
    for ($x = 1; $x <= $i; $x++)
    {
		if ($x - $MaPeriod  > 0){ //		echo ">0\$MaTem=\$MaTem+" . $MaMethod . ';<br>';
			$k = $x;
				eval("\$MaTem=" .$MaMethod . ';'); 
				$lastY = $arrtest[$key][($x-1)];
				$MaTem = (2*$MaTem +($MaPeriod-1)*$lastY)/($MaPeriod+1)	;	
				$xxx = $MaTem;				
/* 			$k = $x - $MaPeriod ;
			eval("\$MaTem=\$MaTem-" . $MaMethod . ';');
			$xxx = $MaTem / $MaPeriod;
 */			$error_zero = 0; //除零错误 0无 1有 //		
// echo '<br>>0$x:'.$x.'$k:'.$k.'$MaTem:'.$MaTem.' xxx:'.$xxx;
		}else{
			$k = $x; //		echo "<=0\$MaTem=\$MaTem+" . $MaMethod . ';<br>';
//*则Y=[2*X+(N-1)*Y']/(N+1),其中Y'表示上一周期Y值。
//			eval("\$MaTem=\$MaTem+" . 2*$MaMethod . ';'); 
				eval("\$MaTem=" .$MaMethod . ';'); 
			if ($k == 1){
				$lastY = $MaTem;
//				echo '@@k==1lastY:'.$lastY;
	//			echo "\$MaTem= (2*". $MaMethod ."  +\$x*\$lastY)/(\$x+1) ". ';';
	//			eval("\$MaTem= (2*". $MaMethod ."  +\$x*\$lastY)/(\$x+1) ".';'; 
				$MaTem = (2*$MaTem +($x-1)*$lastY)/($x+1) ;
			}else{										
	//			echo 'matem:'.$MaTem;
				$lastY = $arrtest[$key][($x-1)];
//					echo 'lastY >1 :'.$lastY .'<br/>';
				$MaTem = (2*$MaTem +($x-1)*$lastY)/($x+1) ;
				//			eval("\$MaTem=" .(2* $MaMethod . +($x-1)*$lastY)/$x+1 ';'); 									
			}
//			$MaTem= (2*$arrtest['close'][$k] +$x*$lastY)/($x+1) ;
			$xxx = $MaTem ;// $x; //			
//			echo '<br><0$x:'.$x.'$k:'.$k.'$MaTem:'.$MaTem.' xxx:'.$xxx.'<br/>';
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