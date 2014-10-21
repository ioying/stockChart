<?php

/**
 * @author 
 * @copyright 2008 6 24 21:12
 * 文件头  
 */

//页面执行时间开始计时
$mtime = explode(' ', microtime());
$starttime = $mtime[1] + $mtime[0];
//引入错误处理函数
include 'func/error_handler.php';
// 错误处理
$error = set_error_handler("error_handler");  
$error_msg = '';
$error_zero = 0;

function gb($str) //汉字 编码转换
{
    return iconv("GBK", "UTF-8", $str);
}

?>