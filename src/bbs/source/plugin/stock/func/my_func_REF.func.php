<?php

/**
 * @author Leo1119
 * @copyright 2009
 */


function my_func_REF($MA_Str) //REF(X,A) 引用A周期前的X值。

{
    global $i, $arrtest, $key, $error_zero; //
    $MA_Str = make_str($MA_Str);
    $exec_lines = preg_split('/,/', $MA_Str);
    $MA_value = trim($exec_lines[0]);
    $MA_Period = $exec_lines[1] + 0;
    //    echo 'jjjjjjjj' . $MA_value . '    ' . $MA_Period;
    for ($j = 1; $j <= $i; $j++)
    {
        $k = $j - $MA_Period;
        if ($k > 0)
        {
            $error_zero = 0; //除零错误 0无 1有
            $ma_tem = 0;
            $tem_exec = $MA_value;
            //				echo 'exec:'.$tem_exec.$k.' <br>  ';
            eval("\$ma_tem=" . $tem_exec . ';');
            $xxx = abs($ma_tem);
        } else
        {
            $xxx = null;
        }
        if ($error_zero == 0)
        {
            $arrtest[$key][$j] = $xxx;
        } else
        {
            $arrtest[$key][$j] = 0;
        }
        //     $arrtest[$key][$j] = $xxx;
    }


    //    echo $MA_value . $MA_Period;
}
?>