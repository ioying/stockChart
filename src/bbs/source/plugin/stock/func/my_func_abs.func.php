<?php

/**
 * 	@author Leo1119
 * 	@copyright 2009
 *	求绝对值。
 * 	用法:
 *	ABS(X)返回X的绝对值
 *	例如：ABS(-34)返回34
 */

function my_func_abs($MA_Str){
    global $i, $arrtest, $key, $error_zero; //
    $MA_Str = make_str($MA_Str);


    for ($k = 1; $k <= $i; $k++)
    {
        //	  	echo 'k:'.$k;
        $ma_tem = 0;
        $tem_exec = $MA_Str;
        //				echo 'exec:'.$tem_exec.$k.' <br>  ';
        $error_zero = 0; //除零错误 0无 1有
        eval("\$ma_tem=" . $tem_exec . ';');
        $xxx = abs($ma_tem);
        //        echo $error_zero;
        if ($error_zero == 0)
        {
            $arrtest[$key][$k] = $xxx;
        } else
        {
            $arrtest[$key][$k] = 0;
        }
    }
    return $xxx;


}

?>