<?php
/**��ָ��ƽ���ƶ�ƽ����
 *�÷�: EMA(X,N),��X��N��ָ��ƽ���ƶ�ƽ�����㷨����Y=EMA(X,N)
 *��Y=[2*X+(N-1)*Y']/(N+1),����Y'��ʾ��һ����Yֵ��
 *���磺EMA(CLOSE,30)��ʾ��30��ָ��ƽ������
 * @Ioying@hotmail.com  2014 02 28  ��ʼʹ���շ��������������� "_"
 * $MAStr Ema(x,n); x : �����n��������    * ���뷵��ֵ  ���������Ҫ���ɷ��ش�����Ϣ��
 */
function my_func_ema($MAStr) 
{
    global $i, $arrtest, $key, $error_zero; //	echo '<br/>before make str $MAStr:'.$MAStr.'$key:'.$key.'<br/>';	
		$MAStr = make_str($MAStr);   			//	echo '<br/>func ma() $MAStr:'.$MAStr.'<br/>';
		$ExecLines = preg_split('/,/', $MAStr);
		$MaMethod = trim($ExecLines[0]);
		$k	=	1; 	//����ҪŶ��$MaPeriod=$arrtest['x'][$k] ��$k û��ֵ�����$k������ѭ���е�$kû��ϵ
/*     if (eval("\$MaPeriod=" . $ExecLines[1] . ';')){  // ���Դ�����, eval ���� ���� false
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
 */			$error_zero = 0; //������� 0�� 1�� //		
// echo '<br>>0$x:'.$x.'$k:'.$k.'$MaTem:'.$MaTem.' xxx:'.$xxx;
		}else{
			$k = $x; //		echo "<=0\$MaTem=\$MaTem+" . $MaMethod . ';<br>';
//*��Y=[2*X+(N-1)*Y']/(N+1),����Y'��ʾ��һ����Yֵ��
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
			$error_zero = 0; //������� 0�� 1��
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