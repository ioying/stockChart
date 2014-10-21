<?php

/**
 * @author Leo1119
 * @copyright 2009
 */
function my_func_ma($MA_Str) //移动平均函数 ma   此函数可优化 将j值循环放在外面 +新值，-旧值

{
    global $i, $arrtest, $key, $error_zero; //
    $MA_Str = make_str($MA_Str);
//    echo $MA_Str;
    $exec_lines = preg_split('/,/', $MA_Str);
    $MA_Method = trim($exec_lines[0]);
    $k=1; //很重要哦，$MA_Period=$arrtest['x'][$k] 中$k 没赋值，这个$k与下面循环中的$k没关系
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
                $error_zero = 0; //除零错误 0无 1有
                eval("\$ma_tem=\$ma_tem+" . $tem_exec . ';');
            }
            $xxx = $ma_tem / $MA_Period;
        } else
        {
            //     	              			echo 'X:'.$x.'K:'.$k;
     //       $xxx = null;     移动平均小于 $MA_Period 的时候使用实际周期进行平均 如$MA_Period=5 则前5个数字不再是null值而是前第n个的平均    
	 //       20090604 提出异议， 此法不和惯例， 而且实际计算数据线型接头不圆滑。似乎是这个原因导致。 应该解决mull值问题。 
	  
              $ma_tem = 0;
              for ($j = 0; $j < $x; $j++)
			  {
			  	$k = $j+1;
			    $tem_exec = $MA_Method; //.$x.']';
                //				echo 'exec:'.$tem_exec.' <br>  ';
                $error_zero = 0; //除零错误 0无 1有
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