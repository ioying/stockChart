<?php
/**
 * MA(X,N) ��N�����ڣ�X���ƶ�ƽ��ֵ @author Leo1119  * @copyright 2009
 * @Ioying@hotmail.com  2014 02 28 ���Ż� +��-�� ������ʱ�������������ٱ���
 * $ma_Str ma(x,n); x : �����n��������   * ���뷵��ֵ  ���������Ҫ���ɷ��ش�����Ϣ��
 */
function my_func_ma($MA_Str) 
{
    global $i, $arrtest, $key, $error_zero; //	echo '<br/>before make str $MA_Str:'.$MA_Str.'$key:'.$key.'<br/>';	
		$MA_Str = make_str($MA_Str);   			//	echo '<br/>func ma() $MA_Str:'.$MA_Str.'<br/>';
		$exec_lines = preg_split('/,/', $MA_Str);
		$MA_Method = trim($exec_lines[0]);
		$k	=	1; 	//����ҪŶ��$MA_Period=$arrtest['x'][$k] ��$k û��ֵ�����$k������ѭ���е�$kû��ϵ
    eval("\$MA_Period=" . $exec_lines[1] . ';'); 
		$MA_Period = abs($MA_Period);
    if($MA_Period<1) $MA_Period=1; 	//    	echo '<br/>MA_Method:'.$MA_Method.' **** Period:'.$MA_Period.'*** i:'.$i.' <br>  ';
    //		echo '  $i-($MA_Period-1):',$i-($MA_Period-1).' <br>  ';
		$ma_tem = 0;
    for ($x = 1; $x <= $i; $x++)
    {
		if ($x - $MA_Period  > 0){ //		echo ">0\$ma_tem=\$ma_tem+" . $MA_Method . ';<br>';
			$k = $x;
			eval("\$ma_tem=\$ma_tem+" . $MA_Method . ';');
			$k = $x - $MA_Period ;
			eval("\$ma_tem=\$ma_tem-" . $MA_Method . ';');
			$xxx = $ma_tem / $MA_Period;
			$error_zero = 0; //������� 0�� 1�� //			echo '<br>>0$x:'.$x.'$k:'.$k.'$ma_tem:'.$ma_tem.' xxx:'.$xxx;
		}else{
			$k = $x; //		echo "<=0\$ma_tem=\$ma_tem+" . $MA_Method . ';<br>';
			eval("\$ma_tem=\$ma_tem+" . $MA_Method . ';'); 
			$xxx = $ma_tem / $x; //			echo '<br><0$x:'.$x.'$k:'.$k.'$ma_tem:'.$ma_tem.' xxx:'.$xxx;
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