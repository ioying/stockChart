<?php

/**
 * calculate.php 根据解析后的公式进行计算部分
 * @author 
 * @copyright 2008
 * 
 * 20090427
 * 剥离原来写入 data.txt 的所有代码  ， 程序最后以 JSON 输出和传递。
 * 20140128 使用 getcsv.php 获取行情数据,原 data.txt 废弃。
 *
 * 20090427
 * 以后使用数据库组件来完成数据库连接，这里暂时直接连接。
 * 而且以后可能使用其他方式存储数据，比如 文本 等。
 * 
 * 20090309 修改计划
 *   分割各功能模块，尽可能函数化模块化。 做成对象？
 *   公式解析与计算分开，计算结果存储   参考 数组先用serialize序列化再入库,取出时再反序列  BinaryFormatter这个类
 *   整理 优化函数
 * 
 * 用ajax制作的交互界面调试
 * 'my_replce_no_title_'  my_replce_id   my_func_
 * 
 */


/**
 * include 'header.inc.php';
 * include 'func/func.php';
 * include 'func/config.php';
 */
//连接数据库并返回结果集
//将来要接受一些参数，比如 计算范围是从历史数据起点开始（重新计算）还是只计算新增部分 （刷新数据） 或从指定位置开始 200427
 

// include 'func/func.php'; // 股票公式函数库
// 需要自动包含 
include DISCUZ_ROOT.'./source/plugin/stock/func/make_str.func.php'; 
include DISCUZ_ROOT.'./source/plugin/stock/func/not_a_func.func.php';

//include 'func/my_func_ma.php'; // //20090603 解决自动 including 函数定义文件问题。  

//echo getcwd();
//include 'getcsv.inc.php';  // 从csv文件读取原始数据
//include 'getfromdatabase.php'; // 从数据库文件读取原始数据
/*改为读取 csv文件  ， getcsv.php  ，原数据库连接和读取部分，转至getfromdatabase.php 20140127 */

	
//			echo "<pre>";
//			print_r($arrtest);	
	


$i = count($arrtest['open'])-1;   // 数组中数据个数, $i 在之后的函数中均要使用到。
	
//数组循环赋值
foreach ($arrtest as $key => $value) {
    if ($key != 'open' && $key != 'close' && $key != 'high' && $key != 'low' && $key !=
        'vol' & $key != 'datetime')
        //此行需要改，这些都是保留字，原则上不可以用作行名，需要处理没有行名的这类输入，即行名和0值均等于这些字符的项目
		// 原键值前加 k_  以区分关键字。20140128

    {
 //              echo gb('命令串：' . $arrtest[$key][0][0] . '<br>');
 
 //20090518  将原来$arrtest[$key][0] 改为 $arrtest[$key][0][0], 数组第一项数据由原来的行计算公式改为子数组，子数组第一项是原来的行计算公式， 第二项默认为 show 或者 noshow ，也有为空的时候。 默认为 show k线数据 o c l h v d 等默认空。 
        if (substr_count($arrtest[$key][0][0], 'my_func')) {

            $exec = str_replace("(", "('", $arrtest[$key][0][0]); //将括号加上“
            $exec = str_replace(")", "')", $exec);
//echo '***'.$arrtest[$key][0][0] ;
//echo $exec;
//自动 including 函数定义文件

            preg_match("/\bmy_func_\w+/i",   $arrtest[$key][0][0], $my_func_file); // 读取函数名，以备之后including file 即my_func_emv(close,1) 中my_func_emv 部分。
//          $my_func_file_name=dirname(__file__) . '\func\\'.$my_func_file[0].'.php';  // 此方法组文件名 斜杠 不知 windows 和 linux 是否兼容。
            
			$my_func_file_name=DISCUZ_ROOT.'./source/plugin/stock/func/'.$my_func_file[0].'.func.php';  //组成文件名。 

//echo '    $my_func_file name is:'.$my_func_file_name;

    
               if (file_exists($my_func_file_name)) 
			   { 
//			   	echo '  file in dir';
	include_once $my_func_file_name;		   	
				}else{
				echo ' undefined func() file not found!';
				return;
//                     未定义函数的错误处理问题。 
				}
				
				    
      
//					    echo gb("是函数，需要替换!替换后为") . $exec . '<br>';
        eval("\$x=" . $exec . ";");
        } else {
//                      echo $key.gb('不是函数') . $arrtest[$key][0] . '<br>';
// 						echo $key.gb('不是函数') . $arrtest[$key][0][0] . '<br>';
        $exec = "not_a_func('" . $arrtest[$key][0][0] . "')";
        eval("\$x=" . $exec . ";");
        }
    }
}


?>