<?php

/**
 * @author Leo1119
 * @copyright 2009
 */
function my_func_ma($MA_Str) //�ƶ�ƽ������ ma   �˺������Ż� ��jֵѭ���������� +��ֵ��-��ֵ

{
    global $i, $arrtest, $key, $error_zero; //
    $MA_Str = make_str($MA_Str);
//    echo $MA_Str;
    $exec_lines = preg_split('/,/', $MA_Str);
    $MA_Method = trim($exec_lines[0]);
    $k=1; //����ҪŶ��$MA_Period=$arrtest['x'][$k] ��$k û��ֵ�����$k������ѭ���е�$kû��ϵ
    eval("\$MA_Period=" . $exec_lines[1] . ';');  
    if($MA_Period<1) $MA_Period=1;
    //echo 'MA_Method:'.$MA_Method.'  per:'.$MA_Period.' i:'.$i.' <br>  ';
    //echo '  $i-($MA_Period-1):',$i-($MA_Period-1).' <br>  ';
    for ($x = 1; $x <= $i; $x++)
    {
        //     	  	echo 'k:'.$k;
        if ($x - $MA_Period + 1 > 0)
        {
            $ma_tem = 0;
            for ($j = 0; $j < $MA_Period; $j++)
            {
                $k = $x - $j;
                //            			echo 'X:'.$x.'K:'.$k;

                $tem_exec = $MA_Method; //.$x.']';
                //				echo 'exec:'.$tem_exec.' <br>  ';
                $error_zero = 0; //������� 0�� 1��
                eval("\$ma_tem=\$ma_tem+" . $tem_exec . ';');
            }
            $xxx = $ma_tem / $MA_Period;
        } else
        {
            //     	              			echo 'X:'.$x.'K:'.$k;
     //       $xxx = null;     �ƶ�ƽ��С�� $MA_Period ��ʱ��ʹ��ʵ�����ڽ���ƽ�� ��$MA_Period=5 ��ǰ5�����ֲ�����nullֵ����ǰ��n����ƽ��    
	 //       20090604 ������飬 �˷����͹����� ����ʵ�ʼ����������ͽ�ͷ��Բ�����ƺ������ԭ���¡� Ӧ�ý��mullֵ���⡣ 
	  
              $ma_tem = 0;
              for ($j = 0; $j < $x; $j++)
			  {
			  	$k = $j+1;
			    $tem_exec = $MA_Method; //.$x.']';
                //				echo 'exec:'.$tem_exec.' <br>  ';
                $error_zero = 0; //������� 0�� 1��
                eval("\$ma_tem=\$ma_tem+" . $tem_exec . ';');
			  }
			  $xxx = $ma_tem / $x;
          
        }
        if ($error_zero == 0)
        {
            $arrtest[$key][$x] = $xxx;
        } else
        {
            $arrtest[$key][$x] = 0;
        }
        //        $arrtest[$key][$x] = $xxx;
    }
    return $xxx;
    //}


}


?>