<?php

/**
 * jsonfordrawjs.inc.php  
 * �����ѽ����õĹ�ʽ �� ָ����ԭʼ���ݣ�Ϊ drawjs �������ɻ�ͼ���� json �ļ�
 * @copyright 2014
 * @ioying
 * @2014 02 16 
 */

//include 'header.inc.php'; // 
//include 'func/posttohost.func.php'; // fsockopen ����  ��һ��php�ļ�����һ����ַpost���ݣ����ñ������صı���

$test ='{"open":[{"0":"open","1":"noshow","name":"Open"}],"close":[{"0":"close","1":"noshow","name":"Close"}],"high":[{"0":"high","1":"noshow","name":"High"}],"low":[{"0":"low","1":"noshow","name":"Low"}],"vol":[{"0":"vol","1":"noshow","name":"Vol"}],"datetime":[{"0":"datetime","1":"noshow","name":"Date"}],"my_replce_id0":[["my_func_ma(close,5)","noshow"]],"ma5":[{"0":" my_replce_id0 ","1":"show","name":"ma5"}],"my_replce_id1":[["my_func_ma(close,10)","noshow"]],"ma10":[{"0":" my_replce_id1 ","1":"show","name":"ma10"}],"my_replce_id2":[["my_func_ma(close,20)","noshow"]],"ma20":[{"0":" my_replce_id2 ","1":"show","name":"ma20"}]}';
$arrtest = json_decode($test, true);
// json ת���� ���� ���� true  json_decodeĬ�Ϸ��ص��� stdClass �Ķ��󣬿���ʹ��json_decode(jsonData,true)�������顣

//$file_name = './source/plugin/stock/data/000001.ss_d.csv';
$file_name = './data/tsla_d.csv';
include './func/yahoocsv.func.php';   //./source/plugin/stock/
//include 'getcsv.inc.php';
include 'calculatefordrawjs.inc.php';


//$mtime = explode(' ', microtime());
//$processtime = number_format(($mtime[1] + $mtime[0] - $parsertime-$starttime), 6);
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
//    $file_name='./data/try/try_'.$_GET['userid'].'.json';
$userfile_name='./data/userdata/tsla_d_ma.json';
	$data = json_encode($arrtest);
    file_put_contents($userfile_name,$data);

//	echo " ".getcwd();
//	echo '<iframe width=100% height=460 frameborder=1 >ihello</iframe>';
//	echo '<iframe width=100% height=460 frameborder=1 src="source/plugin/stock/candle.inc.php?fdataid='.$file_name.'&mainmap='.$_GET['mainmap'].'"></iframe>';
	



















	return;

?>