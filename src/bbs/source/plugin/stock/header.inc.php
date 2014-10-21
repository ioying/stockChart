<?php

/**
 * @author ioying
 * @copyright 2008 6 24 21:12
 * 文件头   临时作用。
 * 计算各模块程序起始时间
 * 定义了两个临时函数， 将来如果需要保留，可以移动至函数库中。
 * gb($str)  
 * js_unescape($str='return utf-8')
 * 
 * 
 * 尚未完成部分  整个程序的错误处理 ！！！
 */

//页面执行时间开始计时

	$mtime = explode(' ', microtime());
	$starttime = $mtime[1] + $mtime[0];

//引入错误处理函数 

	include 'func/error_handler.php';

// 错误处理
//$error = set_error_handler("error_handler");  
//$error_msg = '';
//$error_zero = 0;
	
	$tt='<br>From '.$_SERVER["PHP_SELF"]."  "; //所有调试程序时显示均带上文件路径及文件名 ，以便查找

	function gb($str) //汉字 编码转换
		{
			return iconv("GBK", "UTF-8", $str);
		}
 

	function js_unescape($str='return utf-8')  // 对应ajax escape函数， 主要解决ajax post 	数据中的中文在php 接收后无法还原为中文的问题。
		//来源于 http://topic.csdn.net/u/20071006/18/34e13f63-970a-4bb8-8671-20d7fd701fe5.html
	{ 
		$ret = ''; 
        $len = strlen($str); 
        for ($i = 0; $i < $len; $i++) 
			{ 
                if ($str[$i] == '%' && $str[$i+1] == 'u') 
                { 
                        $val = hexdec(substr($str, $i+2, 4)); 

                        if ($val < 0x7f) $ret .= chr($val); 
                        else if($val < 0x800) $ret .= chr(0xc0|($val>>6)).chr(0x80|($val&0x3f)); 
                        else $ret .= chr(0xe0|($val>>12)).chr(0x80|(($val>>6)&0x3f)).chr(0x80|($val&0x3f)); 

                        $i += 5; 
                } 
                else if ($str[$i] == '%') 
                { 
                        $ret .= urldecode(substr($str, $i, 3)); 
                        $i += 2; 
                } 
                else $ret .= $str[$i]; 
			} 
        return $ret; 
	}


?>