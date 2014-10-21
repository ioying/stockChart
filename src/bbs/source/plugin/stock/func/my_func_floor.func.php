<?php

/**
 * 	@author Leo1119
 * 	@copyright 2009
 *	floor() 向数值减小方向舍入。
 *	用法:
 *	FLOOR(A)返回沿A数值减小方向最接近的整数
 *	例如：FLOOR(12.3)求得12,FLOOR(-3.5)求得-4
 */

function my_func_floor($MA_Str){
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
        $xxx = floor($ma_tem);
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