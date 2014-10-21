<?php

/**
 × 此文件为 test_post_to_host.php 整理版
 * 最初目的：实现以服务方式访问parser.php
 * @author Leo1119  
 * @copyright 2009
 × @ioying
 × @2014 01 28 
 */



include 'header.inc.php'; // 
include 'func/posttohost.func.php'; // fsockopen 函数  从一个php文件向另一个地址post数据，不用表单和隐藏的变量


//$comm_text = strtolower($_POST["text"]); // 接收公式数据
$comm_text = $_POST["text"];   //  不再转换为小写， 没有什么实际意义，而且影响标注

//$select_cycle = $_POST["select_cycle"];  // 接收显示周期数，最少20  这个参数用处不大了，图表绘制部分完成以后，再确定是否需要保留。  20140128
//if ($select_cycle < 20)
//    $select_cycle = 20;

//echo urldecode($comm_text) ;//;
 echo $tt."text send: ".$comm_text;
//echo '<br>Selece_cycle='.$select_cycle;
$data = array('text' => $comm_text    );  //转成一维数组，以便post to host

//print_r($data);    //显示数组
//$test = posttohost('http://localstock.com/newstock/parser.php', $data);  // 实际使用跨域
$url='http://localhost/bbs/source/plugin/stock/parser.inc.php';
$test = posttohost($url, $data);   //为方便测试，使用本地
$mtime = explode(' ', microtime());
$parsertime = number_format(($mtime[1] + $mtime[0] - $starttime), 6);
echo $tt.gb("@@解析用时 {$parsertime} 秒;");


//echo '<br>'.date('l jS \of F Y h:i:s A');

//echo '<br>';
//echo '<br>Post to Host ';
//echo gb('返回计算结果：');
//echo $test;

$test= js_unescape($test);  // 对ajax传递编码后的中文解码

 echo $tt.'text back:'.$test;

 //echo '----'.substr($test,0,1).'----';
 
 if (!(substr($test,0,1) == '{' )){
 echo $tt.gb("@@解析调试状态或解析错误，程序终止！;");

 return;
 } 
 
 
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


$mtime = explode(' ', microtime());
$processtime = number_format(($mtime[1] + $mtime[0] - $parsertime-$starttime), 6);
echo $tt.gb("@计算用时 {$processtime} 秒;");


// 显示计算结果   
// 存储为文件还是数据库呢？  
// 绘制图表  未完成
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

//echo json_encode($arrtest);
return;
//echo '<pre>';
//print_r($max);
//print_r($arrtest);

//$ma55=array_slice ($arrtest['ma5'][0],1);

//unset($ma55[0]); 删除键值为0的数组元素
//print_r($ma55);

//echo 'testk:*********:';
//$test_k=array(array(3.75,3.76,3.69,3.72),array(3.72,3.73,3.66,3.68),array(3.68,3.72,3.66,3.70),array(3.71,3.78,3.67,3.75),array(3.74,3.74,3.70,3.70),array(3.70,3.70,3.59,3.60));

//echo '<pre>';
//print_r(array_values($test_k));
//echo '<br>encode testK:*******:';
//echo json_encode($test_k);
//$test = posttohost('http://localstock.com/newstock/parser.php', $data);
//$data = array('text' => $comm_text, 'oooo' => 1 //  此行无用，纯属凑数
//$postk=array('text' =>json_encode($k),'oooo' => 1);

//$tem=json_encode($arrtest);
$arrsend=array('text'=>$comm_text,'select_cycle'=>$select_cycle );
//$comm_text = strtolower($_POST["text"]); // 接收数据
//$select_cycle = $_POST["select_cycle"];  // 接收显示周期数，最少20
$url=urldecode("text={$comm_text}&select_cycle={$select_cycle}");
//echo 'ddddddddddddddddd';
//echo $url;
//echo "<img src=\"makechart.php?{$url}}\"/>";
//echo "<img src=\"makechart.php\"/>";
return;




$tem=serialize($arrtest);


echo 'JSON_encode $arrtest:';
echo $tem;
echo '<br>';
$postk=array('text'=>$tem,'ooo'=>1);
//echo '<br>$postk:';
//echo json_encode($postk);
//print_r(array_values($postk));
//$ntest = posttohost('http://localhost/newstock/test_array.php', $postk);
$ntest = posttohost('http://localhost/newstock/test_post.php', $postk);  
echo 'test_post return:';
echo $ntest;
//echo "<img src=\"test_array.php?text=" . $tem . "\"/>";
//echo $tem;
//$tem1 = json_decode($tem, true);
//print_r(array_values($tem1));
//echo 'ntest:' + $ntest;
?>