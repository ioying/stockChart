<?php

/**
 * @author Leo1119
 * @copyright 2009
 */

function not_a_func($MA_Str) //����Ǻ����ַ���

{
    global $i, $arrtest, $key, $error_zero; //
    $MA_Str = make_str($MA_Str);

//       echo 'in not_a_func:'.$MA_Str;

    for ($k = 1; $k <= $i; $k++)
    {
        //	  	echo 'k:'.$k;
        $ma_tem = 0;
        $tem_exec = $MA_Str;
//               echo 'xxxx in not a func exec:'.$tem_exec.$k.' <br>  ';
        $error_zero = 0; //������� 0�� 1��
        eval("\$ma_tem=" . $tem_exec . ';');
        $xxx = $ma_tem;
        //       echo $error_zero;
        if ($error_zero == 0)
        {
            $arrtest[$key][$k] = $xxx;
        } else
        {
            $arrtest[$key][$k] = 0;
        }
        //       $arrtest[$key][$k] = $xxx;
    }
    return $xxx;


    //		$MA_Period= $exec_lines[1]+0;
}

?>