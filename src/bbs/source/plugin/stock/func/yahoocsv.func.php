<?php
/*
* yahoocsv.func.php    另有一个yahoocsv.inc.php 文件
*读取yahoo api 格式 csv文件， 转换成计算所需格式
*  
*接收文件名   带存储地址的
*
* !!! 此函数化文件因其他文件错误，暂时未使用，以后再试，现在使用 include yahoocsv.inc.php 方式。20140218
*/

//function yahoocsv($file_name = "./source/plugin/stock/data/000001.ss_d.csv") {
//	$file_url = $_SERVER['DOCUMENT_ROOT']."/bbs/source/plugin/stock/data/";
//	$file_name = "600320_ss_d_test.csv";  //10组数据
//	$file_name = "600320_ss_d.csv";  //完整数据

//	 global  $arrtest;     //$i,, $key, $error_zero;
	
	
	
	if(file_exists($file_name)){
 
//		echo "Yeah!	";
//$test1 .='yahoocsv found data';
		$handle = fopen($file_name,"r") or   exit("Unable to open file!");

		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
//		while(! feof($handle))
//		{
		
//		$data = fgetcsv($handle,1000, ",");
//      echo "xxxxxx:".$data[0];
		if  ($data[0] != "Date" &&  $data[0] != null ){  
		//跳过第一行 表头， 不严谨。以后看有什么更正规的方法。     同时 跳过 null 空值 ，一般空值易发生在表尾部(多个回车)。 fgetcsv()函数对 csv 的空行做 null 处理，不报错。
/* 	 yahoo api 读取 csv 文件数据需要倒序   
        $arrtest['open'][] = $data[1];
        $arrtest['high'][] = $data[2];
        $arrtest['low'][] = $data[3];
        $arrtest['close'][] = $data[4];
        $arrtest['vol'][] = $data[5];
        $arrtest['datetime'][] = $data[0];
        
*/		
		$dataopen[] = $data[1];
        $datahigh[] = $data[2];
        $datalow[] = $data[3];
        $dataclose[] = $data[4];
        $datavol[] = $data[5];
        $datadatetime[] = $data[0];
			}

		}
		//	像数组内追加数组，原数组中[0]有数据，直接赋值会被覆盖。
		$arrtest['open'] = array_merge_recursive($arrtest['open'],array_reverse($dataopen))  ;
        $arrtest['high'] = array_merge_recursive($arrtest['high'],array_reverse($datahigh))  ;
        $arrtest['low'] = array_merge_recursive($arrtest['low'],array_reverse($datalow)) ;
        $arrtest['close'] = array_merge_recursive($arrtest['close'],array_reverse($dataclose))  ;
        $arrtest['vol'] = array_merge_recursive($arrtest['vol'],array_reverse($datavol))  ;
        $arrtest['datetime'] = array_merge_recursive($arrtest['datetime'],array_reverse($datadatetime));

		
		fclose($handle);
// 	return 1;
	}else{
// 	return 0;
//		echo "Oops!	";//文件未找到， 确认股票代码 或 选择远程下载， 代码以后补。

	}
//}	
?> 