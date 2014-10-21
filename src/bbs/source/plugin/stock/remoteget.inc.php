<?php
/* remote get file
http://ichart.yahoo.com/table.csv?s=000001.ss&a=0&b=1&c=1990&d=0&e=31&f=2014&g=d&ignore=.csv
g=d 日 m 月 w 周
*/

//全部读取
$stock_code  = '000001.ss';
$stock_cycle = 'd';
$start_date  = '1900';    // 起始日期
$end_date    = '2015';    // 截至日期
$url='http://ichart.yahoo.com/table.csv?s='.$stock_code.'&a=0&b=1&c='.$start_date.'&d=0&e=31&f='.$end_date.'&g='.$stock_cycle.'&ignore=.csv';
//echo $url;
$data = file_get_contents($url,true);
//$data=fgetcsv($handle, 1000, ",")

	$file_name='./'.$stock_code.'_'.$stock_cycle.'.csv';
echo $file_name;
	//	$data = json_encode($data);
     file_put_contents($file_name,$data);

//echo $data;

?>