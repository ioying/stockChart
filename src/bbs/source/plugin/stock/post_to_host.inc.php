<?php

/**
 �� ���ļ�Ϊ test_post_to_host.php �����
 * ���Ŀ�ģ�ʵ���Է���ʽ����parser.php
 * @author Leo1119  
 * @copyright 2009
 �� @ioying
 �� @2014 01 28 
 */



include 'header.inc.php'; // 
include 'func/posttohost.func.php'; // fsockopen ����  ��һ��php�ļ�����һ����ַpost���ݣ����ñ������صı���


//$comm_text = strtolower($_POST["text"]); // ���չ�ʽ����
$comm_text = $_POST["text"];   //  ����ת��ΪСд�� û��ʲôʵ�����壬����Ӱ���ע

//$select_cycle = $_POST["select_cycle"];  // ������ʾ������������20  ��������ô������ˣ�ͼ����Ʋ�������Ժ���ȷ���Ƿ���Ҫ������  20140128
//if ($select_cycle < 20)
//    $select_cycle = 20;

//echo urldecode($comm_text) ;//;
 echo $tt."text send: ".$comm_text;
//echo '<br>Selece_cycle='.$select_cycle;
$data = array('text' => $comm_text    );  //ת��һά���飬�Ա�post to host

//print_r($data);    //��ʾ����
//$test = posttohost('http://localstock.com/newstock/parser.php', $data);  // ʵ��ʹ�ÿ���
$url='http://localhost/bbs/source/plugin/stock/parser.inc.php';
$test = posttohost($url, $data);   //Ϊ������ԣ�ʹ�ñ���
$mtime = explode(' ', microtime());
$parsertime = number_format(($mtime[1] + $mtime[0] - $starttime), 6);
echo $tt.gb("@@������ʱ {$parsertime} ��;");


//echo '<br>'.date('l jS \of F Y h:i:s A');

//echo '<br>';
//echo '<br>Post to Host ';
//echo gb('���ؼ�������');
//echo $test;

$test= js_unescape($test);  // ��ajax���ݱ��������Ľ���

 echo $tt.'text back:'.$test;

 //echo '----'.substr($test,0,1).'----';
 
 if (!(substr($test,0,1) == '{' )){
 echo $tt.gb("@@��������״̬��������󣬳�����ֹ��;");

 return;
 } 
 
 
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


$mtime = explode(' ', microtime());
$processtime = number_format(($mtime[1] + $mtime[0] - $parsertime-$starttime), 6);
echo $tt.gb("@������ʱ {$processtime} ��;");


// ��ʾ������   
// �洢Ϊ�ļ��������ݿ��أ�  
// ����ͼ��  δ���
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

//echo json_encode($arrtest);
return;
//echo '<pre>';
//print_r($max);
//print_r($arrtest);

//$ma55=array_slice ($arrtest['ma5'][0],1);

//unset($ma55[0]); ɾ����ֵΪ0������Ԫ��
//print_r($ma55);

//echo 'testk:*********:';
//$test_k=array(array(3.75,3.76,3.69,3.72),array(3.72,3.73,3.66,3.68),array(3.68,3.72,3.66,3.70),array(3.71,3.78,3.67,3.75),array(3.74,3.74,3.70,3.70),array(3.70,3.70,3.59,3.60));

//echo '<pre>';
//print_r(array_values($test_k));
//echo '<br>encode testK:*******:';
//echo json_encode($test_k);
//$test = posttohost('http://localstock.com/newstock/parser.php', $data);
//$data = array('text' => $comm_text, 'oooo' => 1 //  �������ã���������
//$postk=array('text' =>json_encode($k),'oooo' => 1);

//$tem=json_encode($arrtest);
$arrsend=array('text'=>$comm_text,'select_cycle'=>$select_cycle );
//$comm_text = strtolower($_POST["text"]); // ��������
//$select_cycle = $_POST["select_cycle"];  // ������ʾ������������20
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