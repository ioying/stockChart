<?php
/*
*  读取csv文件，  
*  专门为公式编辑时使用测试数据
*	Ioying@hotmail.com 20140222
*/

//  echo getcwd();
//	echo $_SERVER['DOCUMENT_ROOT']; 000001_ss_d.csv

	$file_url = "./data/";
//	$file_name = "600320_ss_d_test.csv";  //10组数据
	$file_name = "600320.ss_d.csv";  //完整数据

	
	
	
	
	if(file_exists($file_url.$file_name)){
 
//		echo "Yeah!	";

		$handle = fopen($file_url.$file_name,"r") or   exit("Unable to open file!");

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
		//	向数组内追加数组，原数组中[0]有数据，直接赋值会被覆盖。
		//var_dump($arrtest);
		
		$arrtest['open'] = array_merge_recursive($arrtest['open'],array_reverse($dataopen))  ;
        $arrtest['high'] = array_merge_recursive($arrtest['high'],array_reverse($datahigh))  ;
        $arrtest['low'] = array_merge_recursive($arrtest['low'],array_reverse($datalow)) ;
        $arrtest['close'] = array_merge_recursive($arrtest['close'],array_reverse($dataclose))  ;
        $arrtest['vol'] = array_merge_recursive($arrtest['vol'],array_reverse($datavol))  ;
        $arrtest['datetime'] = array_merge_recursive($arrtest['datetime'],array_reverse($datadatetime));

		
		fclose($handle);
		
	}else{

		echo "Oops!	";//文件未找到， 确认股票代码 或 选择远程下载， 代码以后补。

	}
	
	// 数据倒序  array_reverse()
	
//  		echo "<pre>";
//  		print_r($arrtest);	
//	echo "how many inside?: ". count($arrtest['open']);  //测试数据数量
	
//$json_string = json_encode($arrtest);
//echo $json_string; 

		

?> 