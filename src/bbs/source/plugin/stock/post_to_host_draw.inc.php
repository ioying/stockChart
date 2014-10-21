<?php

/**
 × 此文件为 post_to_host.inc.php 绘图版  
 * 原post_to_host.inc.php文件 显示计算过程中的数据，这里不显示，直接绘图
 * @author Leo1119  
 * @copyright 2009
 × @ioying
 × @2014 01 28 
 */
/*******************原 post_to_host.inc.php 代码开始*******************************/
include 'header.inc.php'; // 
include 'func/posttohost.func.php'; // fsockopen 函数  从一个php文件向另一个地址post数据，不用表单和隐藏的变量


$comm_text = strtolower($_POST["text"]); // 接收公式数据


//$select_cycle = $_POST["select_cycle"];  // 接收显示周期数，最少20  这个参数用处不大了，图表绘制部分完成以后，再确定是否需要保留。  20140128
//if ($select_cycle < 20)
//    $select_cycle = 20;

//echo urldecode($comm_text) ;//;
// echo $tt."text send: ".$comm_text;
//echo '<br>Selece_cycle='.$select_cycle;
$data = array('text' => $comm_text    );  //转成一维数组，以便post to host
		if ($_SERVER['SERVER_NAME'] == 'localhost'){
 
			$url='http://localhost/bbs/source/plugin/stock/parser.inc.php';
		}else{
		//print_r($data);    //显示数组
		//$test = posttohost('http://localstock.com/newstock/parser.php', $data);  // 实际使用跨域
			$url='http://www.ttlele.com/source/plugin/stock/parser.inc.php';
		}
$test = posttohost($url, $data);   //为方便测试，使用本地
$mtime = explode(' ', microtime());
$parsertime = number_format(($mtime[1] + $mtime[0] - $starttime), 6);
//echo $tt.gb("@@解析用时 {$parsertime} 秒;");


//echo '<br>'.date('l jS \of F Y h:i:s A');

//echo '<br>';
//echo '<br>Post to Host ';
//echo gb('返回计算结果：');
//echo $test;

$test= js_unescape($test);  // 对ajax传递编码后的中文解码

 //echo $tt.'text back:'.$test;

//信息来源：http://linux.sheup.com/linux/linux7533.htm
//$中文值=5; //
//$中文值2=gb('中文');   // php 支持中文变量名称
//echo $中文值.$中文值2;
//echo '<br>Json Decode :';
$arrtest = json_decode($test, true);
// json 转换成 对象 参数 true  json_decode默认返回的是 stdClass 的对象，可以使用json_decode(jsonData,true)创建数组。

//			echo "<pre>";
//		print_r($arrtest);	

//echo '<pre>'; //格式输出

//print_r(array_values($arrtest));
//print_r($test);



//return;    //本段任务完成  哦也！

include 'calculate.inc.php';

//var_dump($arrtest);
$mtime = explode(' ', microtime());
$processtime = number_format(($mtime[1] + $mtime[0] - $parsertime-$starttime), 6);
// echo $tt.gb("@计算用时 {$processtime} 秒;");


// 显示计算结果   
// 存储为文件还是数据库呢？  
// 绘制图表  未完成
/*

echo gb('<table width=\"830\" border=\"1\" cellspacing=\"0\" bordercolor=\"#666666\"><tr><td width=\"87\">行名</td><td width="727">值</td></tr>');

foreach ($arrtest as $key => $value) {
        if ($key != 'datetime') {
 //   if ($key != 'datetime' & !preg_match("/my_replce_/", $key) & !preg_match("/my_func_/", $key)) {
        echo "<tr><td>" . $key. "  </td><td> ";//gb($key)   指针指向数组每行最后一个单元end($arrtest[$key]).
//        $Max[]=max($arrtest[$key]);
                $unshow_first = 0;
        foreach ($value as $nvalue) { //暂时不显示值，只显示索引
            if ($unshow_first != 0) {
                echo $nvalue . ',';
                if (!$nvalue)
                    $nvalue = 0;
                $first_douhao = ',';
            }
            $unshow_first++;
        }
        echo '</td></tr>';
    }
}

echo '</table>';

*/  //原数据以表格形式显示部分
/******************************原 post_to_host.inc.php 代码结束***********************/
//echo gb('绘图部分开始');

?>

	<?php 
	
	
	/*
<!--
待处理：
1 column 随涨跌变化颜色
2 各种线 分段条件颜色变化
2 ××× 搞定   20140125 ohlc   汉化  应该修改 tooltip:{pointFormat} ，暂时修改 highstock.js文件 pointFormat:部分

-->
	*/

//	header('Content-Type:text/html;charset=utf-8');
//	echo '<script "text/javascript">alert("im here!");</script>';
//	echo '<script>alert("are u ready?"); </script>';
//	['时间','开','高','低','收','量'],
//	echo "The Great Start!";
//echo serialize($arrtest);
//echo $_GET['userid'];  //用户论坛id
//echo $_GET['mainmap']; //图表呈现方式 1叠加在主图上 2副图单独显示 3与主图同时显示
    $file_name='./data/try/try_'.$_GET['userid'].'.json';
	$data = json_encode($arrtest);
    file_put_contents($file_name,$data);

//	echo " ".getcwd();
	if (getcwd() == 'F:\PHPnow\htdocs\bbs\source\plugin\stock'){
//	echo 'here';
	echo '<iframe width=100% height=295 frameborder=1 src="http://localhost/bbs/source/plugin/stock/candle.inc.php?fdataid='.$file_name.'&mainmap='.$_GET['mainmap'].'"></iframe>';
	}else{
//	echo '<iframe width=100% height=460 frameborder=1 >ihello</iframe>';
	echo '<iframe width=100% height=295 frameborder=1 src="http://localhost/bbs/source/plugin/stock/candle.inc.php?fdataid='.$file_name.'&mainmap='.$_GET['mainmap'].'"></iframe>';
	}
	
	return;
	
	$data1 = "[
/* May 2006 */

[1147651200000,67.37,68.38,67.12,67.79,18921051],
[1147737600000,68.10,68.25,64.75,64.98,33470860],
[1147824000000,64.70,65.70,64.07,65.26,26941146],
[1147910400000,65.68,66.26,63.12,63.18,23524811],
[1147996800000,63.26,64.88,62.82,64.51,35221586],
[1148256000000,63.87,63.99,62.77,63.38,25680800],
[1148342400000,64.86,65.19,63.00,63.15,24814061],
[1148428800000,62.99,63.65,61.56,63.34,32722949],
[1148515200000,64.26,64.45,63.29,64.33,16563319],
[1148601600000,64.31,64.56,63.14,63.55,15464811],
[1148947200000,63.29,63.30,61.22,61.22,20125338],
[1149033600000,61.76,61.79,58.69,59.77,45755325],
/* Jun 2006 */
[1149120000000,59.85,62.28,59.52,62.17,33669043],
[1149206400000,62.43,63.10,60.88,61.66,24496720],
[1149465600000,61.15,61.15,59.97,60.00,21639826],
[1149552000000,60.22,60.63,58.91,59.72,25933308],
[1149638400000,60.10,60.40,58.35,58.56,26813938],
[1149724800000,58.44,60.93,57.15,60.76,49911361],
[1149811200000,61.18,61.56,59.10,59.24,27712815],
[1150070400000,59.40,59.73,56.96,57.00,25642234],
[1150156800000,57.61,59.10,57.36,58.33,38605066],
[1150243200000,58.28,58.78,56.69,57.61,31371508],
[1150329600000,57.30,59.74,56.75,59.38,42519228],
[1150416000000,58.96,59.19,57.52,57.56,29939223],
[1150675200000,57.83,58.18,57.00,57.20,25773905],
[1150761600000,57.61,58.35,57.29,57.47,24036581],
[1150848000000,57.74,58.71,57.30,57.86,30856077],
[1150934400000,58.20,59.75,58.07,59.58,34551392],
[1151020800000,59.72,60.17,58.73,58.83,23578607],
[1151280000000,59.17,59.20,58.37,58.99,16661904],
[1151366400000,59.09,59.22,57.40,57.43,19665400],
[1151452800000,57.29,57.30,55.41,56.02,30395258],
[1151539200000,56.76,59.09,56.39,58.97,31258941],
[1151625600000,57.59,57.75,56.50,57.27,26451164]
]";
	$data2 = "[
/* May 2006 */
[1147651200000,18921051],
[1147737600000,33470860],
[1147824000000,26941146],
[1147910400000,23524811],
[1147996800000,35221586],
[1148256000000,25680800],
[1148342400000,24814061],
[1148428800000,32722949],
[1148515200000,16563319],
[1148601600000,15464811],
[1148947200000,20125338],
[1149033600000,45755325],
/* Jun 2006 */
[1149120000000,33669043],
[1149206400000,24496720],
[1149465600000,21639826],
[1149552000000,25933308],
[1149638400000,26813938],
[1149724800000,49911361],
[1149811200000,27712815],
[1150070400000, 25642234],
[1150156800000, 38605066],
[1150243200000, 31371508],
[1150329600000, 42519228],
[1150416000000, 29939223],
[1150675200000, 25773905],
[1150761600000, 24036581],
[1150848000000, 30856077],
[1150934400000, 34551392],
[1151020800000, 23578607],
[1151280000000, 16661904],
[1151366400000, 19665400],
[1151452800000, 30395258],
[1151539200000, 31258941],
[1151625600000, 26451164]
]";
	
	echo <<<EOF
	
	
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> 
		<script type="text/javascript">
		//以下图表使用 highchart 绘制， 网址 http://www.highcharts.com/ 本网站也有详细中文介绍和学习笔记、范例
		//本段代码添加了中文注释，方便大家学习研究。
$(function() { 
Highcharts.setOptions({
		global: {
			useUTC: false  //UTC 时间设置    没看出变化
				},
	lang: { //汉化界面
			months: ['一月', '二月', '三月', '四月', '五月', '六月',  '七月', '八月', '九月', '十月', '十一', '十二月'],
			shortMonths:['一月', '二月', '三月', '四月', '五月', '六月',  '七月', '八月', '九月', '十月', '十一', '十二月'],
			weekdays: ['周日', '周一', '周二', '周三', '周四', '周五', '周六'],
			contextButtonTitle: ['输出'],
			downloadJPEG: ['另存为 JPEG 图片'],
			downloadPDF:['另存为PDF文档'],
			downloadPNG:['另存为 PNG 图片'],
			downloadSVG:['另存为 SVG 图片'],
			loading:['载入Loading...'],
			printChart:['打印图表'],
			rangeSelectorZoom:['缩放']
			}
		});


	$('#container').highcharts('StockChart', {
	

	
	
 chart: {
 
        	borderColor: '#EBBA95',    //边框颜色  宽度 圆角半径
        	borderWidth: 2,
        	borderRadius: 10 ,

			height: 600,			   // 图表高度

// 	        backgroundColor: '#FCFFC5' //背景颜色 单色
			
 
 
	        backgroundColor: {         //背景颜色 渐变
	            linearGradient: {
                    x1: 0, 
                    y1: 0, 
                    x2: 1, 
                    y2: 1
                },
                stops: [
	                [0, 'rgb(255, 255, 255)'],
	                [1, 'rgb(200, 200, 255)']
	            ]
	        } 
	    },
	    
		credits: {     //归功于   
				enabled:true  ,
				href:"http://www.highcharts.com",
				position: {
					align: 'left',
					x: 10,
					verticalAlign: 'bottom',
					y: -5
				},
				itemStyle: {  //此段无效果，有空研究
					cursor: 'pointer',
					color: '#009090',
					fontSize: '20px'

				},
				text: ['感谢 Highcharts.com 提供图表支持']
				
		},
		
	//	tooltip: {
     //       shared: true,
     //       useHTML: true,
    //        headerFormat: '<small>{point.key}</small><table>',
     //       pointFormat: '<span style="color:{series.color};font-weight:bold">{series.name}</span><br/>open: {point.open}<br/>High: {point.high}<br/>Low: {point.low}<br/>Close: {point.close}<br/>',
     //       footerFormat: '</table>',
     //       valueDecimals: 2
     //   },

		
		
		
		
	    plotOptions: {
			    	series: {		        // 动画播放时间

	    		animation: {
	    			duration: 500
	    		}
	    	},
	    	candlestick: {
				lineColor:'green',
	    		color: 'green',
	    		upColor: 'red',
				upLineColor: 'red'
	    	}
	    },

	    title: {                                // 图表标题        		
	    	text: 'My Chart title 耶！',
			
      		margin: 30                           //标题距离图表间隔
    	},

		    yAxis: [{  //定义第二个y坐标 
		        title: {
		            text: 'OHLC'
		        },
		        height: 300,
		        lineWidth: 2
		    }, {
		        title: {
		            text: 'Volume'
		        },
		        top: 390,
		        height: 100,
		        offset: 0,
		        lineWidth: 2
		    }],
		
	    rangeSelector: {
	    	selected: 1
	    },

	    series: [
		{   tooltip: {
		pointFormat: '<span style="color:{series.color};font-weight:bold">{series.name}</span><br/>开盘: {point.open}<br/>最高: {point.high}<br/>最低: {point.low}<br/>收盘: {point.close}<br/>'
				},
		    name: '--------',
			type: 'candlestick',
			data: <?php echo $data1 ?>
			}, 
			{
		        type: 'column',
		        name: '量',
		        data: <?php echo $data2 ?>,
		        yAxis: 1

		    },
		{
	        name: 'USD to EUR',
	        data: <?php echo $data1 ?>
		//	,
		//	            marker: {
        //        symbol: 'url(http://highcharts.com/demo/gfx/sun.png)' //图形符号
         //   }
	    }
			
		]
	});
	
	
		var chart = $('#container').highcharts();
    $('#showloading').click(function() {
		chart.showLoading();
	});
	$('#hideloading').click(function() {
		chart.hideLoading();
	});
	
	
});
		</script>
	

	
<script src="http://localhost/highstockchart/js/highstock.js"></script>
<script src="http://localhost/highstockchart/js/modules/exporting.js"></script>
<!--
<script src="../../js/highstock.js"></script>
<script src="../../js/modules/exporting.js"></script>
-->
<button id="showloading">Show loading</button>
<button id="hideloading">Hide loading</button>
<div id="container" style="height: 500px; min-width: 500px">ok?</div>

EOF;
	echo "What's up!";
?>