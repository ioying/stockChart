<?php

/**
 * @author 
 * @copyright 2008
 ******************************************************
 ******注意！！！ 有echo 输出时，图片不能正常显示******
 ******************************************************
 * stock_code  		股票代码  
 * cycle       		数据周期  分钟 日 周 月
 * select_cycle 	周期数量  默认100 
 * formul_aname     公式名称
 * chart_numbers	图表组合数量  默认2 
 * chart_width      图表宽度  默认
 * chart_high       图表高度
 *
 *http://localhost/bbs/source/plugin/stock/charting.php?stock_code=6001988&cycle=day1&select_cycle=100&chart_width=900&chart_high=700&formul_aname=test9g
 *
 */
 
// if(!defined('IN_DISCUZ')){
//	exit('Access Denied');
//}

 
 
  echo "select_cycle ".$_GET["select_cycle"]."<br>"; 
  echo "stock_code ".$_GET["stock_code"]."<br>"; 
  echo "formul_aname ".$_GET["formul_aname"]."<br>"; 
  echo "chart_width ".$_GET["chart_width"]."<br>"; 
  echo "chart_high ".$_GET["chart_high"]."<br>"; 
  echo "cycle ".$_GET["cycle"]."<br>"; 
		
  
// echo getcwd();
//include './data.txt';
//include $_SERVER['DOCUMENT_ROOT'].'/plchart/v1/newgraph.php';
// echo $_GET["a"];
$data=array(//'vol_line'=> array($vol,'column_2d','columns',2),
             'K_line'=>array($k,'stock_shle','stock',0),
             'ma_line' => array($ma5,'line_single','columns',8)
			 ); //default,line_scatter
$data_keys=array_keys($data);
foreach($data as $line_data)
{
//echo max($line_data);
//echo '<br>line_data_count:'.count($line_data);
//echo '<br>'.$line_data[0].'   - '.$line_data[1];
//for($i = 0; $i < count($line_data); $i++)
//{
//	echo $line_data[$i][0].'  ' .$line_data[$i][1].'  ' .'<br>';
//print_r($line_data);
//echo '<br>'.'------------------';
//	}
	}
$demo = new plchart($data, 600, 400, 'png');
$demo->set_background(array(255,255,255));  
$text   =   "测试显示中文abc123ABC#$%^&";  
$demo->set_title($text, 9, 0, 10, 15, 'simsun', array(244, 26, 4));
$label1=array('1'=>array('中国银行',12,0,300,15,'simsun',array(255,0,0)),
              '2'=>array('601988',12,0,400,15,'arial',array(255,0,0)),
			  '3'=>array('test',12,0,400,35,'arial',array(255,0,0))                      
				);
$demo->add_label($label1);
$demo->set_scale(array(3.00, 3.10, 3.20, 3.30, 3.40,3.50,3.60,3.70,3.80,3.90), array( ));
$demo->set_desc();
$demo->set_graph(10, 30, 540, 350,0);
//$save = '/test.gif';
$demo->output();

?>