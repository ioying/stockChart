<?php

/**
 �� ���ļ�Ϊ post_to_host.inc.php ��ͼ��  
 * ԭpost_to_host.inc.php�ļ� ��ʾ��������е����ݣ����ﲻ��ʾ��ֱ�ӻ�ͼ
 * @author Leo1119  
 * @copyright 2009
 �� @ioying
 �� @2014 01 28 
 */
/*******************ԭ post_to_host.inc.php ���뿪ʼ*******************************/
include 'header.inc.php'; // 
include 'func/posttohost.func.php'; // fsockopen ����  ��һ��php�ļ�����һ����ַpost���ݣ����ñ������صı���


$comm_text = strtolower($_POST["text"]); // ���չ�ʽ����


//$select_cycle = $_POST["select_cycle"];  // ������ʾ������������20  ��������ô������ˣ�ͼ����Ʋ�������Ժ���ȷ���Ƿ���Ҫ������  20140128
//if ($select_cycle < 20)
//    $select_cycle = 20;

//echo urldecode($comm_text) ;//;
// echo $tt."text send: ".$comm_text;
//echo '<br>Selece_cycle='.$select_cycle;
$data = array('text' => $comm_text    );  //ת��һά���飬�Ա�post to host
		if ($_SERVER['SERVER_NAME'] == 'localhost'){
 
			$url='http://localhost/bbs/source/plugin/stock/parser.inc.php';
		}else{
		//print_r($data);    //��ʾ����
		//$test = posttohost('http://localstock.com/newstock/parser.php', $data);  // ʵ��ʹ�ÿ���
			$url='http://www.ttlele.com/source/plugin/stock/parser.inc.php';
		}
$test = posttohost($url, $data);   //Ϊ������ԣ�ʹ�ñ���
$mtime = explode(' ', microtime());
$parsertime = number_format(($mtime[1] + $mtime[0] - $starttime), 6);
//echo $tt.gb("@@������ʱ {$parsertime} ��;");


//echo '<br>'.date('l jS \of F Y h:i:s A');

//echo '<br>';
//echo '<br>Post to Host ';
//echo gb('���ؼ�������');
//echo $test;

$test= js_unescape($test);  // ��ajax���ݱ��������Ľ���

 //echo $tt.'text back:'.$test;

//��Ϣ��Դ��http://linux.sheup.com/linux/linux7533.htm
//$����ֵ=5; //
//$����ֵ2=gb('����');   // php ֧�����ı�������
//echo $����ֵ.$����ֵ2;
//echo '<br>Json Decode :';
$arrtest = json_decode($test, true);
// json ת���� ���� ���� true  json_decodeĬ�Ϸ��ص��� stdClass �Ķ��󣬿���ʹ��json_decode(jsonData,true)�������顣

//			echo "<pre>";
//		print_r($arrtest);	

//echo '<pre>'; //��ʽ���

//print_r(array_values($arrtest));
//print_r($test);



//return;    //�����������  ŶҲ��

include 'calculate.inc.php';

//var_dump($arrtest);
$mtime = explode(' ', microtime());
$processtime = number_format(($mtime[1] + $mtime[0] - $parsertime-$starttime), 6);
// echo $tt.gb("@������ʱ {$processtime} ��;");


// ��ʾ������   
// �洢Ϊ�ļ��������ݿ��أ�  
// ����ͼ��  δ���
/*

echo gb('<table width=\"830\" border=\"1\" cellspacing=\"0\" bordercolor=\"#666666\"><tr><td width=\"87\">����</td><td width="727">ֵ</td></tr>');

foreach ($arrtest as $key => $value) {
        if ($key != 'datetime') {
 //   if ($key != 'datetime' & !preg_match("/my_replce_/", $key) & !preg_match("/my_func_/", $key)) {
        echo "<tr><td>" . $key. "  </td><td> ";//gb($key)   ָ��ָ������ÿ�����һ����Ԫend($arrtest[$key]).
//        $Max[]=max($arrtest[$key]);
                $unshow_first = 0;
        foreach ($value as $nvalue) { //��ʱ����ʾֵ��ֻ��ʾ����
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

*/  //ԭ�����Ա����ʽ��ʾ����
/******************************ԭ post_to_host.inc.php �������***********************/
//echo gb('��ͼ���ֿ�ʼ');

?>

	<?php 
	
	
	/*
<!--
������
1 column ���ǵ��仯��ɫ
2 ������ �ֶ�������ɫ�仯
2 ������ �㶨   20140125 ohlc   ����  Ӧ���޸� tooltip:{pointFormat} ����ʱ�޸� highstock.js�ļ� pointFormat:����

-->
	*/

//	header('Content-Type:text/html;charset=utf-8');
//	echo '<script "text/javascript">alert("im here!");</script>';
//	echo '<script>alert("are u ready?"); </script>';
//	['ʱ��','��','��','��','��','��'],
//	echo "The Great Start!";
//echo serialize($arrtest);
//echo $_GET['userid'];  //�û���̳id
//echo $_GET['mainmap']; //ͼ����ַ�ʽ 1��������ͼ�� 2��ͼ������ʾ 3����ͼͬʱ��ʾ
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
		//����ͼ��ʹ�� highchart ���ƣ� ��ַ http://www.highcharts.com/ ����վҲ����ϸ���Ľ��ܺ�ѧϰ�ʼǡ�����
		//���δ������������ע�ͣ�������ѧϰ�о���
$(function() { 
Highcharts.setOptions({
		global: {
			useUTC: false  //UTC ʱ������    û�����仯
				},
	lang: { //��������
			months: ['һ��', '����', '����', '����', '����', '����',  '����', '����', '����', 'ʮ��', 'ʮһ', 'ʮ����'],
			shortMonths:['һ��', '����', '����', '����', '����', '����',  '����', '����', '����', 'ʮ��', 'ʮһ', 'ʮ����'],
			weekdays: ['����', '��һ', '�ܶ�', '����', '����', '����', '����'],
			contextButtonTitle: ['���'],
			downloadJPEG: ['���Ϊ JPEG ͼƬ'],
			downloadPDF:['���ΪPDF�ĵ�'],
			downloadPNG:['���Ϊ PNG ͼƬ'],
			downloadSVG:['���Ϊ SVG ͼƬ'],
			loading:['����Loading...'],
			printChart:['��ӡͼ��'],
			rangeSelectorZoom:['����']
			}
		});


	$('#container').highcharts('StockChart', {
	

	
	
 chart: {
 
        	borderColor: '#EBBA95',    //�߿���ɫ  ��� Բ�ǰ뾶
        	borderWidth: 2,
        	borderRadius: 10 ,

			height: 600,			   // ͼ��߶�

// 	        backgroundColor: '#FCFFC5' //������ɫ ��ɫ
			
 
 
	        backgroundColor: {         //������ɫ ����
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
	    
		credits: {     //�鹦��   
				enabled:true  ,
				href:"http://www.highcharts.com",
				position: {
					align: 'left',
					x: 10,
					verticalAlign: 'bottom',
					y: -5
				},
				itemStyle: {  //�˶���Ч�����п��о�
					cursor: 'pointer',
					color: '#009090',
					fontSize: '20px'

				},
				text: ['��л Highcharts.com �ṩͼ��֧��']
				
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
			    	series: {		        // ��������ʱ��

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

	    title: {                                // ͼ�����        		
	    	text: 'My Chart title Ү��',
			
      		margin: 30                           //�������ͼ����
    	},

		    yAxis: [{  //����ڶ���y���� 
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
		pointFormat: '<span style="color:{series.color};font-weight:bold">{series.name}</span><br/>����: {point.open}<br/>���: {point.high}<br/>���: {point.low}<br/>����: {point.close}<br/>'
				},
		    name: '--------',
			type: 'candlestick',
			data: <?php echo $data1 ?>
			}, 
			{
		        type: 'column',
		        name: '��',
		        data: <?php echo $data2 ?>,
		        yAxis: 1

		    },
		{
	        name: 'USD to EUR',
	        data: <?php echo $data1 ?>
		//	,
		//	            marker: {
        //        symbol: 'url(http://highcharts.com/demo/gfx/sun.png)' //ͼ�η���
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