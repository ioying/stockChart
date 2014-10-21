<?php
/*  get csv file from yahoo api

	http://ichart.yahoo.com/table.csv?s=000001.ss&a=0&b=1&c=1990&d=0&e=31&f=2014&g=d&ignore=.csv

		参数
		s – 股票名称
		a – 起始时间，月
		b – 起始时间，日
		c – 起始时间，年
		d – 结束时间，月
		e – 结束时间，日
		f – 结束时间，年
		g – 时间周期。

	Example: g=w, 表示周期是’周’。d->’日’(day), w->’周’(week)，m->’月’(mouth)，v->’dividends only  股息’
	g=d 日 m 月 w 周


	接收参数 ，全新下载，补充下载。
	先看文件是否存在， 如果在，则判断最后更新日期， 如果为最新，则返回
	否则，补充更新为最新数据
    否则， 下载全新数据。					


*   curl 效率比 file_get_contents()高 以后换。file_get_contents($url,true)


	//		接收参数，以后可以写短一些。并预留一些参数位。
	//		函数化， 失败 return 0， 成功 return 字节数， 文件较新不需更新 return 1 （暂定1天内不更新）
*/				
function getcsvfromyahoo($stock_code='000001.ss', $stock_cycle = 'd') {


				//$file_url = $_SERVER['DOCUMENT_ROOT']."/bbs/source/plugin/stock/data/";  这个写法兼容差
$file_url = "./source/plugin/stock/data/";
$file_name=$file_url.$stock_code.'_'.$stock_cycle.'.csv';

	if (file_exists($file_name)) { 		//		如果文件已经存在
		$shicha=time()-filemtime($file_name);
		$dates=floor(($shicha)/46400); 	// 	was 86400	echo $dates."day<br>";

				if ($dates > 0) {	   	// 		文件数据超过1天没有更新
				
/////////////////////////读取最后更新日期


					$handle = fopen($file_name,"r") or   exit("Unable to open file!");
					while (($updatedata = fgetcsv($handle, 1000, ",")) !== FALSE) {
						if  ($updatedata[0] != "Date" &&  $updatedata[0] != null ){  
							//跳过 表头， 不严谨。以后看有什么更正规的方法。     同时 跳过 null 空值 ，一般空值易发生在表尾部(多个回车)。 fgetcsv()函数对 csv 的空行做 null 处理，不报错。

							$start_d	=	getdate(strtotime($updatedata[0]));
							$end_d		=	getdate(time());

							//date ("F d Y H:i:s.", filemtime($file_name)); */   
							//此段原计划只更新从文件最后更新日期至当前日期的数据，减少传输量，比如只下载2天数据，但如果日期太少，yahoo api 不提供数据，最少可能7～10天。 愿望总是美好的。暂时更新全部数据。
							//$url         = 'http://ichart.yahoo.com/table.csv?s='.$stock_code.'&a='.$start_d['mon'].'&b='.$start_d['mday'].'&c='.$start_d['year'].'&d='.$end_d['mon'].'&e='.$end_d['mday'].'&f='.$end_d['year'].'&g='.$stock_cycle.'&ignore=.csv';
							// 最后更新日期 a月 b日 c年
							break;
						}

					}
		
				fclose($handle);
		


/////////////////////////////////////////////////////////////////////////





								//				echo 'too old, days: '.$dates.'<br>';
				}
				else{
								//				echo 'too young,only hours'.$hours.'<br>';
				return 1 ;    	//				暂不作处理		以后做 数据更新下载。	 yahoo不理想 考虑换数据源，或交费购买20140222			
				}


	}else{       				//	未发现文件存在	//		echo 'get now!';
	}

		$start_date  = '2010';    // 起始日期
		$end_date    = '2025';    // 截至日期
		$url         = 'http://ichart.yahoo.com/table.csv?s='.$stock_code.'&a=0&b=1&c='.$start_date.'&d=5&e=31&f='.$end_date.'&g='.$stock_cycle.'&ignore=.csv';
					//		http://ichart.yahoo.com/table.csv?s=000001.ss&a=0&b=1&c=2012&d=5&e=31&f=2014&g=w&ignore=.csv
					//		echo $url;
		@$data = file_get_contents($url,true);
					//		$data=curl_get_contents($url)   ;  // curl 效率更高， 以后换。
					//		echo '<pre>';
					//		var_dump($http_response_header); 
					//		$data=fgetcsv($handle, 1000, ",")
        if (stristr($http_response_header[0],'404 Not Found')){
					//		echo 'not found such file o!';
			$ok=0;
		}else{
					//		$file_name='./'.$stock_code.'_'.$stock_cycle.'.csv';
			$ok=file_put_contents($file_name,$data);
		}
//	}
return $ok ;
}
?>