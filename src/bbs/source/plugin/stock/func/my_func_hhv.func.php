<?php
/**
 * hhv(x,n) ��N������ X �����ֵ 
 * @Ioying@hotmail.com  2014 02 28 ���Ż� +��-�� ������ʱ�������������ٱ���
 * $hhvStr hhv(x,n)(x,n); x : �����n��������  nΪ����ʱȡ����ֵ��nΪ0ʱ ����Ϊ��������999999 * ���뷵��ֵ  * 
 * ���������Ҫ���ɷ��ش�����Ϣ��
 */
function my_func_hhv($hhvStr) 
{
    global $i, $arrtest, $key, $error_zero; //	echo '<br/>before make str $hhvStr:'.$hhvStr.'$key:'.$key.'<br/>';	
		$hhvStr = make_str($hhvStr);   			//	echo '<br/>func ma() $hhvStr:'.$hhvStr.'<br/>';
		$exec_lines = preg_split('/,/', $hhvStr);
		$hhvMethod = trim($exec_lines[0]);
		$k	=	1; 	//����ҪŶ��$hhvPeriod=$arrtest['x'][$k] ��$k û��ֵ�����$k������ѭ���е�$kû��ϵ
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

			$error_zero = 0; //������� 0�� 1�� //			echo '<br>>0$x:'.$x.'$k:'.$k.'$hhvtem:'.$hhvtem.' xxx:'.$xxx;
		}else{
//			$hhvtem[$x]=
			$k = $x; //		echo "<=0\$hhvtem=\$hhvtem+" . $hhvMethod . ';<br>';
			eval("\$hhvtem[\$x]=" . $hhvMethod . ';'); 
			$xxx = max($hhvtem);  //			echo '<br><0$x:'.$x.'$k:'.$k.'$hhvtem:'.$hhvtem.' xxx:'.$xxx;
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