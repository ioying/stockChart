<?php

/**
 * 	@author Leo1119
 * 	@copyright 2009
 *	求最小值。
 * 	用法:
 * 	MIN(A,B...)返回所有参数的中的最小值，参数数量最少2个，最多未设限制 （大智慧可以有2—16个）
 *	例如：MIN(CLOSE,OPEN,REF(CLOSE,1))表示返回昨收、今开、收盘三个价格中最小的价格。
 */

function my_func_min($minStr='0,1'){

		$minStr = make_str($minStr);  
		$exec_lines = preg_split('/,/', $minStr);

//var_dump($exec_lines);
$numargs = count($exec_lines);
//echo $numargs;
//return;

    global $i, $arrtest, $key, $error_zero; //
  // $i=2; 
	
    for ($k = 1; $k <= $i; $k++){
        //	  	echo 'k:'.$k;
        $ma_tem = 0;
		
			for ($arg_i = 0; $arg_i < $numargs; $arg_i++) {
				//$arg_str[$i] = make_str($arg_list[$i]);
				//$tem_exec[$arg_i] = make_str($arg_list[$arg_i]);
				$tem_exec[$arg_i] = $exec_lines[$arg_i];
				$error_zero = 0; //除零错误 0无 1有
//				echo $tem_exec[$arg_i]." xxx $arg_i  xxx ";
				eval("\$ma_tem=" . $tem_exec[$arg_i] . ';');
				$arg_result[$arg_i] = $ma_tem;
//				echo $ma_tem.PHP_EOL;
//				echo "Argument $arg_i is: " . $arg_list[$arg_i] . "<br />\n";
			}
		
		
        //$tem_exec = $MA_Str;
        //$error_zero = 0; //除零错误 0无 1有
        //eval("\$ma_tem=" . $tem_exec . ';');
        //$xxx = floor($ma_tem);
		$xxx = min($arg_result);
//echo $xxx;
        if ($error_zero == 0)
        {
            $arrtest[$key][$k] = $xxx;
        } else
        {
            $arrtest[$key][$k] = 0;
        }
    }
    return $xxx;

	

//	var_dump($arg_result);
//	echo max($arg_result);
}

/*
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
*/
//echo my_func_max();
//echo my_func_max('1+3','2*2','3','4*4','(5+1)*2','6*6','7*7','8/2','9*0');
//echo my_func_max('1+3,2*2,3,4*4,(5+1)*2,6*6,7*7,8/2,9*0');
//return;
?>