<?php
/**
 * LLV(x,n) ��N������ X �����ֵ 
 * @Ioying@hotmail.com  2014 02 28 ���Ż� +��-�� ������ʱ�������������ٱ���
 * $LlvStr LLV(x,n)(x,n); x : �����n��������  nΪ����ʱȡ����ֵ��nΪ0ʱ ����Ϊ��������999999 * ���뷵��ֵ  * 
 * ���������Ҫ���ɷ��ش�����Ϣ��
 */
function my_func_llv($LlvStr) 
{
    global $i, $arrtest, $key, $error_zero; //	echo '<br/>before make str $LlvStr:'.$LlvStr.'$key:'.$key.'<br/>';	
		$LlvStr = make_str($LlvStr);   			//	echo '<br/>func ma() $LlvStr:'.$LlvStr.'<br/>';
		$exec_lines = preg_split('/,/', $LlvStr);
		$LlvMethod = trim($exec_lines[0]);
		$k	=	1; 	//����ҪŶ��$LlvPeriod=$arrtest['x'][$k] ��$k û��ֵ�����$k������ѭ���е�$kû��ϵ
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

			$error_zero = 0; //������� 0�� 1�� //			echo '<br>>0$x:'.$x.'$k:'.$k.'$Llvtem:'.$Llvtem.' xxx:'.$xxx;
		}else{
//			$llvtem[$x]=
			$k = $x; //		echo "<=0\$Llvtem=\$Llvtem+" . $LlvMethod . ';<br>';
			eval("\$Llvtem[\$x]=" . $LlvMethod . ';'); 
			$xxx = min($Llvtem);  //			echo '<br><0$x:'.$x.'$k:'.$k.'$Llvtem:'.$Llvtem.' xxx:'.$xxx;
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