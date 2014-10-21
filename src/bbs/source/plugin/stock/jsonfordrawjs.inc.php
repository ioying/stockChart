<?php

/**
 * jsonfordrawjs.inc.php  
 * 根据已解析好的公式 和 指定的原始数据，为 drawjs 计算生成绘图数据 json 文件
 * @copyright 2014
 * @ioying
 * @2014 02 16 
 */

//include 'header.inc.php'; // 
//include 'func/posttohost.func.php'; // fsockopen 函数  从一个php文件向另一个地址post数据，不用表单和隐藏的变量

$test ='{"open":[{"0":"open","1":"noshow","name":"Open"}],"close":[{"0":"close","1":"noshow","name":"Close"}],"high":[{"0":"high","1":"noshow","name":"High"}],"low":[{"0":"low","1":"noshow","name":"Low"}],"vol":[{"0":"vol","1":"noshow","name":"Vol"}],"datetime":[{"0":"datetime","1":"noshow","name":"Date"}],"my_replce_id0":[["my_func_ma(close,5)","noshow"]],"ma5":[{"0":" my_replce_id0 ","1":"show","name":"ma5"}],"my_replce_id1":[["my_func_ma(close,10)","noshow"]],"ma10":[{"0":" my_replce_id1 ","1":"show","name":"ma10"}],"my_replce_id2":[["my_func_ma(close,20)","noshow"]],"ma20":[{"0":" my_replce_id2 ","1":"show","name":"ma20"}]}';
$arrtest = json_decode($test, true);
// json 转换成 对象 参数 true  json_decode默认返回的是 stdClass 的对象，可以使用json_decode(jsonData,true)创建数组。

//$file_name = './source/plugin/stock/data/000001.ss_d.csv';
$file_name = './data/tsla_d.csv';
include './func/yahoocsv.func.php';   //./source/plugin/stock/
//include 'getcsv.inc.php';
include 'calculatefordrawjs.inc.php';


//$mtime = explode(' ', microtime());
//$processtime = number_format(($mtime[1] + $mtime[0] - $parsertime-$starttime), 6);
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
//    $file_name='./data/try/try_'.$_GET['userid'].'.json';
$userfile_name='./data/userdata/tsla_d_ma.json';
	$data = json_encode($arrtest);
    file_put_contents($userfile_name,$data);

//	echo " ".getcwd();
//	echo '<iframe width=100% height=460 frameborder=1 >ihello</iframe>';
//	echo '<iframe width=100% height=460 frameborder=1 src="source/plugin/stock/candle.inc.php?fdataid='.$file_name.'&mainmap='.$_GET['mainmap'].'"></iframe>';
	



















	return;

?>