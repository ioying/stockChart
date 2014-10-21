<!DOCTYPE HTML>

<!--
待处理：
1 column 随涨跌变化颜色
2 各种线 分段条件颜色变化
3 ××× 搞定   20140125 ohlc   汉化  应该修改 tooltip:{pointFormat} ，暂时修改 highstock.js文件 pointFormat:部分
4 调整 美化
5	    	minPadding: 0.001,  图表与数据最大/小值 余地（倍数）
	    	maxPadding: 0.002,
-->

<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Highstock Example</title>
	</head>
	<body>	
	
	<?php 
	// 应该可以接收更多的参数，关于图表设定部分。 还需要补充的参数 height: 450,			   // 图表高度       以后应 接收外部传递
	
	if (!empty($_GET['mainmap'])) ////图表呈现方式 1叠加在主图上 2副图单独显示 3与主图同时显示
	{
		$mainmap = $_GET["mainmap"];
//		echo 'candle get:'.$mainmap; 
	}else{
		$mainmap = 2;
//		echo 'candle defult:'.$mainmap; 
	}
	
	
	
	if(!empty($_GET['fdataid']))  //接收JSON数据存储文件名
	{
//	echo $_GET["fdataid"];    
// 	json_decode($some) 返回的是一个对象  json_decode($some, true) 返回数组。否则出现错误提示Cannot use object of type stdClass as array
    
	$json = json_decode(file_get_contents($_GET["fdataid"]),true);

//	echo "<pre>";
//	print_r($json);
	

	$i = count($json['open'])-1; 

	}else{
	return;  //需要后补失败提示信息
	}
//	['时间','开','高','低','收','量'],
// 主图赋值。 k线 和 成交量 
//   if ($mainmap == 2){  // 可以简化的运算部分, js注释对其中的php无效 下面 <?php if ($mainmap == 1) echo $data1 ? > 处仍输出.
//       }else{
		$data1 =' [';
		$data2 =' [';
			for ($x = 1; $x <= $i; $x++){
				$data1 .='['.strtotime ($json['datetime'][$x]).'000,'.$json['open'][$x].','.$json['high'][$x].','.$json['low'][$x].','.$json['close'][$x].'],';
				$data2 .='['.strtotime ($json['datetime'][$x]).'000,'.$json['vol'][$x].'],';
			}
		$data1 .= ']';
		$data2 .= ']';
//		}
?> 
 <?php 
// 数据生成测试


 ?>  
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> 
		<script type="text/javascript">
		//以下图表使用 highchart 绘制， 网址 http://www.highcharts.com/ 本网站也有详细中文介绍和学习笔记、范例
		//本段代码添加了中文注释，方便大家学习研究。
		//可以通过直接修改 js 文件方式，简化此处代码， 但如遇源码更新，可能会有未知问题。

$(function() { 
	Highcharts.setOptions({
		global: {
			useUTC:  false  //UTC 时间设置    没看出变化
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
        	borderWidth: 1,
        	borderRadius: 10 ,
			spacingTop: 5,
			height: 286,			   // 图表高度       以后应 接收外部传递

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
	    },		    colors: [   '#2f7ed8',    '#0d233a',    '#8bbc21',    '#910000',    '#1aadce',    '#492970',   '#f28f43',    '#77a1e5',    '#c42525',    '#a6c96a',   '#4572A7',    '#AA4643',    '#89A54E',    '#80699B',    '#3D96AE',    '#DB843D',    '#92A8CD',    '#A47D7C',    '#B5CA92'],
	     title: {
	    	text: '测试数据',
    	    floating: true,
        	align: 'left',
        	x: 220,
        	y: 17
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
	
	    plotOptions: {  
				spline: {            //图表线宽 ，spline 另一种线
				lineWidth: 1.3,
				fillOpacity: 1.1,
				marker: {
					enabled: false,
						states: {
							hover: {
								enabled: true,
							radius: 2   
							}
						}
				},
				shadow: false
			},		
			line: {            //图表线宽 ，line 另一种线
				lineWidth: 1.3,
				fillOpacity: 1.1,
				marker: {
					enabled: false,
						states: {
							hover: {
								enabled: true,
							radius: 2   
							}
						}
				},
				shadow: false
			},
			    	series: {		        // 动画播放时间

	    		animation: {
	    			duration: 200
	    		}
	    	},
	    	candlestick: {
				lineColor:'green',
	    		color: 'green',
	    		upColor: 'red',
				upLineColor: 'red'
	    	}
	    },

	    //title: {                                // 图表标题        		
	    //	text: 'My Chart title 耶！',
      	//	margin: 0                           //标题距离图表间隔
    	//},
		//图表最大值与实际数据最大值之间倍数
//		yAxis: {
//	    	minPadding: 0.01,
//	    	maxPadding: 0.01
//	    },
		    yAxis: [{
	    	minPadding: 0.001,
	    	maxPadding: 0.002,
			//定义第二个y坐标 
//		        title: {          //y轴标题
//		            text: 'OHLC'
//		        },
		        height: 200,
		        lineWidth: 0.1
		    }
			
/* /////////////////////////////////////////// 定义第二y轴 vol	分开画		
//			, {
//				minPadding: 0.001,
//				maxPadding: 0.002,
//		        title: {
//		            text: 'Volume'
//		        },
		        // top: 240,
		        // height: 100,
		        // offset: 0,
		        // lineWidth: 1
		    // }
////////////////////////////////////////////////////			 */
			],
		navigator: {
	    	enabled: false
	    },
	    rangeSelector: {
	    	selected: 2
	    },

	    series: [
		<?php if ($mainmap==2) echo '/*'?>
		{
			tooltip: {
				pointFormat: '<span style="color:{series.color};font-weight:bold">{series.name}</span><br/>开盘: {point.open}<br/>最高: {point.high}<br/>最低: {point.low}<br/>收盘: {point.close}<br/>'
				},
		    name: '--------',
			type: 'candlestick',
			data: <?php if ($mainmap == 1) echo $data1 ?>
			},
			<?php if ($mainmap==2) echo '*/' ?>
/* /////////////////////// vol 分开处理
//			 
//			{
//		        type: 'column',
//		        name: '量',
//		        data: <?php // echo $data2 ?>,
//		        yAxis: 1 
//
//		    },
/////////////////////// vol 分开处理 结束 */
			
/////////逐个键值输出/////////////////////////////////////////////////////
/////////逐个键值输出/////////////////////////////////////////////////////
 //   
<?php 
		foreach ($json as $key => $value) {
			if ($json[$key][0]['show'] == 'show')
			{
			switch ($json[$key][0]['ChartTypes'])
				{
				case 'columnrange':
					$data_new ='{name:"'.$json[$key][0]['name'].'",type:"'.$json[$key][0]['ChartTypes'].'",color:"red",data:[';
					$data_new1 ='{name:"'.$json[$key][0]['name'].'",type:"'.$json[$key][0]['ChartTypes'].'",color:"green",data:[';
					for ($x = 1; $x <= $i; $x++){
						//echo strtotime ( $json['datetime'][$x]).'<br>';
						      if ($json[$key][$x] > 0){
						$data_new .='['.strtotime ($json['datetime'][$x]).'000,0,'.$json[$key][$x].'],';
						}else{
						$data_new1 .='['.strtotime ($json['datetime'][$x]).'000,'.$json[$key][$x].',0],';
						}
					}
					$data_new1 .= ']},';
					$data_new .= ']},'.$data_new1;
				break;
				case 2:
				  echo "Number 2";
				  break;
				case 3:
				  echo "Number 3";
				  break;
				default:
					$data_new ='{name:"'.$json[$key][0]['name'].'",type:"'.$json[$key][0]['ChartTypes'].'",data:[';
					for ($x = 1; $x <= $i; $x++){
						//echo strtotime ( $json['datetime'][$x]).'<br>';
						$data_new .='['.strtotime ($json['datetime'][$x]).'000,'.$json[$key][$x].'],';
					}
					$data_new .= ']},';
				//	echo $data_new ;

				}
						
				echo $data_new ;
			
/* //尝试 vol上涨红，下跌绿，失败，主要 highstockchart 有bug，数据过多时 marker 无效。 图表不显示。暂时单色显示	
			if ($json[$key][0]['ColorTypes'] == 'UpDown') {

				$data_new ='{name:"'.$json[$key][0]['name'].'",type:"'.$json[$key][0]['ChartTypes'].'",	marker: { enabled: true	},color: "green",data:[';  //color: "green",

					for ($x = 1; $x <= $i; $x++){
						$data_new .='{x:'.strtotime ($json['datetime'][$x]).'000,';
					
						if ($json['open'][$x] < $json['close'][$x]){
						   	$data_new .='y:'. $json[$key][$x].',color:"red"},';
						   }else{
						   $data_new .='y:'. $json[$key][$x].'},';
						   } 
						   
					}
					
				}else{
				}
*/

			}
		}
 
//		?>
//////////////////////////////////////////////////////////////////////////		
//////////////////////////////////////////////////////////////////////////			
			
			
//		{
//	        name: 'USD to EUR',
//	        data: <?php echo $data1 ?>
		//	,
		//	            marker: {
        //        symbol: 'url(http://highcharts.com/demo/gfx/sun.png)' //图形符号
         //   }
//	    }
			
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
<script src="http://localhost/highstockchart/js/highcharts-more.js"></script>
<script src="http://localhost/highstockchart/js/modules/exporting.js"></script>
<!--
<script src="../../js/highstock.js"></script>
<script src="../../js/modules/exporting.js"></script>

<button id="showloading">Show loading</button>
<button id="hideloading">Hide loading</button>
-->
<div id="container" style="height: 275px; min-width: 200px"></div>
	</body>
</html>
