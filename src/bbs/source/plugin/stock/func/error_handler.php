<?php

/**
 * @author 
 * @copyright 2008
 * function error_handler($error_no, $error_str, $error_file, $error_line)// 错误处理函数  
 */

function error_handler($error_no, $error_str, $error_file, $error_line)
    // 错误处理函数
{
    global $error_msg, $xxx, $error_zero;
    //	echo $error_no,$error_str,$error_file, $error_line;
//    echo '******'.$error_str.'******';
    // not for @ errors
    if (error_reporting() == 0)
        return;
    // sort out what kind of error we have
    switch ($error_no)
    {
        case E_NOTICE:
            return;
            break;
        case E_USER_NOTICE:
            $continue = true;
            $type = "注意 Notice";
            break;
        case E_USER_WARNING:
        case E_WARNING:
            $continue = true;
            $type = "警告 Warning";
            break;
        case E_USER_ERROR:
        case E_ERROR:
            $type = "致命错误 Fatal Error";
            break;
        default:
            $type = "未知错误 Unknown Error";
            break;
    }
    // put in error log
    error_log("[" . date("d-M-Y H:i:s") . "] PHP $type: $error_parts[0] error in line $error_line of file $error_file",
        0);
        
        // 这部分无效  郁闷
    if ($error_str == "Call to undefined function" |strpos($error_str,"undefined function"))
    {
        echo gb("错误: 未定义函数!") . nl2br($error_str);
    }
    //*********************************************************************************************
    if ($error_str == "Division by zero")
    { // do your thing
        $error_msg = '<br />注意:出现除零错误! 本系统中允许出现除零运算，不过运算速度会受较大影响，尽量避免出现大量的除零运算。 <font color="#FF0000"> 所有运算项（括号为单位）出现除零则整项均按 0 计算</font><br />如：c/0+3.5,返回0，为避免整行结果为0，可以用括号把可能出现除0的运算括起来，比如(c/0)+3.5 ，返回 3.5';
        $error_zero = 1;
        $xxx = 0;
    } else
    { // display
        echo "\n<div>" . nl2br($error_str) . "</div>\n";
    }
    // halt for fatal errors
    if (!isset($continue))
        exit();
}


?>