<!DOCTYPE HTML>
<!--********************************************************************************************
*				以下图表使用 highchart 绘制， 网址 http://www.highcharts.com/ 				   *
*							本网站也有详细中文介绍和学习笔记、范例							   *
*																							   *		
*                                      感谢 Highstock Chart                                    *
************************************************************************************************
*	//本段代码添加了中文注释，方便大家学习研究。
*
*
*	待改进和处理：
*	1 column 随涨跌变化颜色
*	2 各种线 分段条件颜色变化
*	3 关于汉化，虽然js代码经过加密，但是直接在源码上修改汉化 highstock.js文件 简化此处代码，是可行的。
*	  但如遇源码更新，可能会有未知问题。
*	4 调整 美化
*	5	    	minPadding: 0.001,  图表与数据最大/小值 余地（倍数） maxPadding: 0.002,
*	6 颜色默认顺序 黄 粉 亮绿 蓝 灰 绿 红 白（黑）	
*
************************************************************************************************
*
*  	接收参数 
*  	$_GET['stock_name']  股票全称  用于显示在图表上
*  	strtoupper($_GET['formula_name'] 大写的公式名称，显示在图表上
*  	$_GET['mainmap']   是否显示在主图上
*  	$_GET['fdataid'])  文件名， 为了便于引用，此处不包含路径 ，默认路径 './data/userdata/'
*	应该可以接收更多的参数，关于图表设定部分。 还需要补充的参数 height: 450, 
*   还有用户自定义图表风格等数据
************************************************************************************************
*                            Ioying@hotmail.com  2014.2.22                                     *
************************************************************************************************		
-->
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Draw Chart</title>
	</head>
	<body>	
	
	<?php 

	if (!empty($_GET['mainmap'])) 			//		图表呈现方式 1叠加在主图上 2副图单独显示 3与主图同时显示
	{
		$mainmap = $_GET["mainmap"];  		//		echo 'drawjs get:'.$mainmap; 
	}else{
		$mainmap = 2;  						//		echo 'drawjs defult:'.$mainmap; 
	}
	
	
	
	if(!empty($_GET['fdataid']))  			//		接收JSON数据存储文件名
	{
											//		echo $_GET["fdataid"];    
											// 		json_decode($some) 返回的是一个对象  json_decode($some, true) 返回数组。否则出现错误提示Cannot use object of type stdClass as array
											//    	echo getcwd();
		$json = json_decode(file_get_contents('./data/userdata/'.$_GET["fdataid"]),true);

											//		echo "<pre>";
											//		print_r($json);
	

		$i = count($json['open'])-1; 		//		showmessage('drawjs   found file!');
	}else{									//		echo 'not found user data file!';  参数中的文件名已经过验证，并理论上本段代码不echo提示。
											//		showmessage('drawjs not found file!');
	return;  								//		需要后补失败提示信息， 错误处理未作。
	}
											//		json数据顺序 ['时间','开','高','低','收','量'],
 



											// 		主图赋值。 k线 和 成交量 
		$data1 =' [';
		$data2 =' [';
	for ($x = 1; $x <= $i; $x++)
	{
											//		echo strtotime ( $json['datetime'][$x]).'<br>';
		$data1 .='['.strtotime ($json['datetime'][$x]).'000,'.$json['open'][$x].','.$json['high'][$x].','.$json['low'][$x].','.$json['close'][$x].'],';
		$data2 .='['.strtotime ($json['datetime'][$x]).'000,'.$json['vol'][$x].'],';
	}
		$data1 .= ']'; 						//		echo $data1.'<br>';	
		$data2 .= ']';						//		echo $data2.'<br>';
		
/* 		echo '{<br/>';
		echo '		tooltip: {<br/>';
		echo '		pointFormat: '.'<span style="color:{series.color};font-weight:bold">{series.name}</span><br/>开盘: {point.open}<br/>最高: {point.high}<br/>最低: {point.low}<br/>收盘: {point.close}<br/>' ;
		echo '		}, <br/>';
		echo '	name: "-------------",<br/>';
		echo '	type:"candlestick", <br/>';
		echo '	data: <br/>';
				echo $data1 ;
				
		echo '		}, <br/>'; */

?>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script> 
		<script type="text/javascript">

	$(function() { 
		Highcharts.setOptions({
			global: {
				useUTC:  false  				//		UTC 时间设置    没看出变化
					},
				lang: { 						//		汉化界面
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
 
        	borderColor: '#EBBA95',    	//边框颜色  宽度 圆角半径
        	borderWidth: 2,
        	borderRadius: 10 ,
			spacingTop: 10,
			height: 450,			  	// 图表高度       以后应 接收外部传递

										// 	        backgroundColor: '#FCFFC5' //背景颜色 单色

	        backgroundColor: {        	//背景颜色 渐变
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
	     title: {
	    	text: "<?php echo $_GET['stock_name'].' '.strtoupper($_GET['formula_name']) ?>",
    	    floating: true,
        	align: 'left',
        	x: 220,
        	y: 17
    	},

		 exporting: {  					 //  	输出功能，需搭建 export server 暂时关闭
			enabled: false
		},
		
		credits: {  					 //		归功于   
				enabled:true  ,
				href:"http://www.highcharts.com",
				position: {
					align: 'left',
					x: 10,
					verticalAlign: 'bottom',
					y: -5
				},
				itemStyle: {  			//		此段无效果，有空研究
					cursor: 'pointer',
					color: '#009090',
					fontSize: '20px'

				},
				text: ['感谢 Highcharts.com 提供图表支持']
				
		},
		
					//	tooltip: {
					//       shared: true,
					//       useHTML: true,
					//       headerFormat: '<small>{point.key}</small><table>',
					//       pointFormat: '<span style="color:{series.color};font-weight:bold">{series.name}</span><br/>open: {point.open}<br/>High: {point.high}<br/>Low: {point.low}<br/>Close: {point.close}<br/>',
					//       footerFormat: '</table>',
					//       valueDecimals: 2
					//   },

		
		///////////////////
		//plotOptions: {     },
		//////////////////
		
		
	    plotOptions: {        
			line: {            //图表线宽 ，spline 另一种线
				lineWidth: 1.3,
				fillOpacity: 1.1,
				marker: {
					enabled: false,
						states: {
							hover: {
								enabled: true,
							radius: 1
							}
						}
				},
				shadow: false
			},
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

									//title: {                                // 图表标题        		
									//	text: 'My Chart title ！',
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
		        height: 300,
		        lineWidth: 0.1
		    }
			
/* /////////////////////////////////////////// 定义第二y轴 vol	最后是否分开画，还要看使用体验。		
			, {
				minPadding: 0.001,
				maxPadding: 0.002,
//		        title: {
//		            text: 'Volume'
//		        },
		        top: 240,
		        height: 100,
		        offset: 0,
		        lineWidth: 1
		    }
////////////////////////////////////////////////////			 */
			],
		
	    rangeSelector: {
	    	selected: 2
	    },

	    series: [
		<?php if ($mainmap==2)  echo '/*' ?>
 		{
			tooltip: {
				pointFormat: '<span style="color:{series.color};font-weight:bold">{series.name}</span><br/>开盘: {point.open}<br/>最高: {point.high}<br/>最低: {point.low}<br/>收盘: {point.close}<br/>' 
				},
			name: "-------------",
			type:"candlestick",
			data: <?php echo $data1 ?>
				
			}, 
					<?php if ($mainmap==2) echo '*/'?>
		
		
		
/* /////////////////////// vol 分开处理
			 
			{
		        type: 'column',
		        name: '量',
		        data: <?php echo $data2 ?>,
		        yAxis: 1 

		    },
/////////////////////// vol 分开处理 结束 */
			
/////////逐个键值输出/////////////////////////////////////////////////////
//  下一步考虑处理不同的线性画法，颜色定义等。   
<?php 
		foreach ($json as $key => $value) {
								//				echo 'alert("'.$key.'")';
								//				echo 'alert("'.$json[$key][0][1].'")';
								//				echo 'alert("'.$json[$key][0][1];
			if ($json[$key][0][1] == 'show')
			{
				$data_new ='{name:"'.$json[$key][0]['name'].'",data:[';
				for ($x = 1; $x <= $i; $x++)
				{
								//echo strtotime ( $json['datetime'][$x]).'<br>';
				$data_new .='['.strtotime ($json['datetime'][$x]).'000,'.round($json[$key][$x], 3).'],';  //四舍五入 ，保留3位小数。
				}
				$data_new .= ']},';
								//				echo 'alert("'.$data_new.'")';
								//				echo 'alert("'.$json[$key][0][1].'")';
				echo $data_new ;
			}
		}
 
?>

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
	

	
<script src="http://<?php echo $_SERVER['SERVER_NAME'] ?>/highstockchart/js/highstock.js"></script>
<script src="http://<?php echo $_SERVER['SERVER_NAME'] ?>/highstockchart/js/modules/exporting.js"></script>
<!-- 适应多域名

按钮触发表格事件
<button id="showloading">Show loading</button>
<button id="hideloading">Hide loading</button>
-->
<div id="container" style="height: 420px; min-width: 500px"></div>
	</body>
</html>
