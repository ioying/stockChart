<?php

/**
 * @author Leo1119
 * @copyright 2009
 */


function make_str($make_str) //字符串整理函数

{
    global $i, $arrtest, $key; //
    $make_str = '    ' . $make_str . '    '; // 串两端加空格 为以后正则 ==!
//    echo gb('<br />传过来的字符串为:' ). $make_str; //调试期显示相关信息
    $testregex="/[^\+\-\/\(\,\*\%\^\;\s\)\:]+/i"; // 匹配所有 非 +—*/等，即匹配运算项。
    //$testregex="/(?<=[\b\+\-\/\(\,\*\%\^\;\s])\w+(?=[\+\-\/\)\,\*\%\^\;\b\s])|(\+|\-)?([1-9]\d+)?[0-9]+(\.[0-9]+)/i";
    // 原匹配公式， 但是不能匹配汉字，
    preg_match_all($testregex,
        $make_str, $newstr6); //匹配所有操作项
    //       print_r($newstr6);
    foreach ($newstr6[0] as $eachkey) //逐项判断

    {
        $eachkey = trim($eachkey);
        //                 echo '<br>' . $eachkey . '<br>';
        if (!array_key_exists($eachkey, $arrtest)) {
            if (!is_numeric(trim($eachkey))) {
      //                       echo gb('变量' . $eachkey . '没有定义,暂时归“0”处理<br>');
                $make_str = preg_replace("/((?<=[\b\+\-\/\(\,\*\%\^\;\s])$eachkey(?=[\+\-\/\)\,\*\%\^\;\b\s]))/i",
                    "0", $make_str);
                return $make_str;
            } else {
       //                         		echo	gb('*'.$eachkey.'是数字<br>');
            }
        } else {
       //                              echo gb($eachkey . '是已经定义的变量或函数<br>');
            if (!is_numeric(trim($eachkey))) //不处理纯数字项

            {
                $make_str = preg_replace("/((?<=[\b\+\-\/\(\,\*\%\^\;\s])$eachkey(?=[\+\-\/\)\,\*\%\^\;\b\s]))/i",
                    "\$arrtest['" . "\\1" . "'][\$k]", $make_str);
            }
            //           echo '处理完毕:' . $make_str . ' <br>  ';
        }

    }
    return $make_str;
}
?>