<?php

/**
 * @author 
 * @copyright 2008
 * ��ajax�����Ľ����������
 * 'my_replce_no_title_'  my_replce_id   my_func_
 * 
 * 20090309 �޸ļƻ�
 *   �ָ������ģ�飬�����ܺ�����ģ�黯�� ���ɶ���
 *   ��ʽ���������ֿ����������洢   �ο� ��������serialize���л������,ȡ��ʱ�ٷ�����  BinaryFormatter�����
 *   ���� �Ż�����
 * 
 * 20090420  ����ʹ��json ʵ�ֿ�Խ��������    
 */  
echo getcwd();
//echo '<font size=1>';
include 'header.php';  // ���㿪ʼʱ��  ����gb()����  ���Ժ���Լ򻯵�
include 'func/func.php';  //�����Զ�����㺯��  ����Ҫ���ļ��洢��


$replce_id = 0; //�����������

function replced_id($matches)
{ //�滻ʱȥ���������Ų������������
    global $replce_id, $arrtest;
    $arrtest["my_replce_id$replce_id"][] = $matches[0];
//     $arrtest["my_replce_id$replce_id"][] = $show; //����:=�����
     //   echo '<br />match id:'.$matches[0];
    return preg_replace("/[\(\)]/", '', "my_replce_id" . $replce_id++);
}

function replced_func($matches)
{
    global $replce_id, $arrtest;

    $arrtest["my_replce_id$replce_id"][] = $matches[0];
//       $arrtest["my_replce_id$replce_id"][] = $show; //����:=�����
    //	echo '<br />match func:'.$matches[0];
    return "my_replce_id" . $replce_id++;
}

$arrtest["open"][] = "open";
$arrtest["close"][] = "close";
$arrtest["high"][] = "high";
$arrtest["low"][] = "low";
$arrtest["vol"][] = "vol";
$arrtest["datetime"][] = "datetime";
/*
$arrtest["open"][] = "sys";
$arrtest["close"][] = "sys";
$arrtest["high"][] = "sys";
$arrtest["low"][] = "sys";
$arrtest["vol"][] = "sys";
$arrtest["datetime"][] = "sys";
*/
$comm_text = strtolower($_POST["text"]);
//$comm_text = preg_replace("/[\r\n]/", "", $_POST["text"]); //ȥ���س����з���
if (!empty($_POST["select_cycle"])){
	if ($_POST["select_cycle"] < 20)
		$select_cycle = 20;
		}else{
$select_cycle = $_POST["select_cycle"];
}
//echo gb('�������ڣ�'.$select_cycle);
//echo $comm_text;
//$comm_text = "A: (h-l)/2;B: (REF(H,1)+REF(L,1))/2;MID:A-B;BRO:V/(H-L);";
//$comm_text = " ma5:ref(abs(l-h),5);";
//$comm_text = " ma5:ma(2*h-l,5)+o;h*abs(l-h);mama5:ma(ma5,10);mamax:ma(ma(ma5,5),10);"; //�û������ı� �� ':'  �ָ�key ';'�ָ�������ma_x : ma (ma(o*2,3)-4+(5+abs(6)+((o+c)-(v-c)))+o+ma5+a2+5a+abs(7-8)+c,9);ma_y : ma ( c+ C,5);
$comm_text = trim(str_replace(" ", "", $comm_text)); //ȥ���ַ����а�ǿո�
$comm_text = str_replace("��", "", $comm_text); //ȥ������ȫ�ǿո�
if (preg_match("/[\)]\w/", $comm_text))
{
    echo gb('ȱ��������������н�βȱ�١�;�� ��س�����!' . $comm_text);
    exit;
}
/*  �ж��������Ƿ���; ��β�� ���ڲ���Ҫ�ˣ������Իس���β�������ݴ�
$last_char=substr($comm_text,-1);
if($last_char!=";") 
{ 
echo gb('�����н�βȱ�١�;��');
$comm_text=$comm_text.';';
}
*/

//if(substr($comm_text,-1,-1))
$comm_text = ' ' . $comm_text . ' ';
//�滻���к���Ϊ myfunc������
$comm_text = preg_replace("/(\w+(?=\())/i", 'my_func_' . "\\1", $comm_text);
$comm_text = preg_replace("/(?<=\W)[oO](?=\W)|\bo(?=\W)/i", "open", $comm_text);
$comm_text = preg_replace("/(?<=\W)[cC](?=\W)|\bc(?=\W)/i", "close", $comm_text);
$comm_text = preg_replace("/(?<=\W)[hH](?=\W)|\bh(?=\W)/i", "high", $comm_text);
$comm_text = preg_replace("/(?<=\W)[lL](?=\W)|\bl(?=\W)/i", "low", $comm_text);
$comm_text = preg_replace("/(?<=\W)[vV](?=\W)|\bv(?=\W)/i", "vol", $comm_text);
//echo $comm_text;
//��';'�س����зָ��û�����  ����-1��ʾ����������
$comm_lines = preg_split('/[;\r\t]/', $comm_text, -1, PREG_SPLIT_NO_EMPTY); //����һ�η���һ����ά���飿��'/[:;]/' ������
//print_r($comm_lines);
/*
echo gb('�з������û����룺<br>'); //��ʾ������������
foreach ($comm_lines as $key => $comm_splited)
{
echo $key . ':  ' . $comm_splited . "<br>";
}

*/
$now_lines = 0;
foreach ($comm_lines as $comm_key)
{
    if ($comm_key == ' ')
        break;
    $now_lines++;
    $show = 'show'; //�ж� :=Ϊ 'noshow' ��  : Ϊ'show'  Ĭ�� 'show'����ʾ��������ʾ
    $comm_key = preg_replace("/[\r\n\t\v\f\e\s]/", "", $comm_key); //ȥ���س�\����\�Ʊ����Tab\�����Ʊ��\��ҳ��\��ҳ�� ����
    if (substr_count($comm_key, ":=") == 1) //���� := �����

    {
        $show = 'noshow';
        $comm_key = str_replace(":=", ":", $comm_key);
    //    echo $comm_key  ;  //����ֻ�ǰ�:= �滻�� : ����ͬ�����Ժ��***
    }

    if (substr_count($comm_key, ":") == 1) //�ж����������Ƿ��У�

    {
        $newkeys = mb_substr($comm_key, 0, strpos($comm_key, ':'));
         
	//	echo "  with:".$newkeys; 
    } else
    {
        //	echo 'commkey::::'.$comm_key;
        $newkeys = $comm_key;

    }

    if (substr_count($comm_key, ":") == 1)
    { //�ж����������Ƿ��У���������ʱ����:= �����������
        $comm_test = mb_substr($comm_key, strpos($comm_key, ':') + 1);
    } else
    {
        $comm_test = $comm_key;
    }
    echo '<br>:���沿�֣�'.$comm_test.'<br>';

//	echo 'bbs_name'.$bbname;

    $comm_test = ' ' . $comm_test . ' ';
    preg_match_all("/(?<=[\b\+\-\/\(\,\*\%\^\;\s])\w+(?=[\+\-\/\)\,\*\%\^\;\b\s])|(\+|\-)?([1-9]\d+)?[0-9]+(\.[0-9]+)/i",
        $comm_test, $newstr6);
    $comm_test1 = $comm_test;
    $tem = 0;
    for ($i = 0;; $i++)
    {
        //	echo "ϲ����".$tem++ ."�Σ�";
        $comm_test = $comm_test1;
        $comm_test1 = preg_replace_callback("/(?<!\w)(\([^()]+\))/i", "replced_id", $comm_test1);
        $comm_test1 = preg_replace_callback("/(\w+)(\([a-z0-9\b\%\^\_\.\+\-\*\/\,\d]+\))/",
            "replced_func", $comm_test1);
        //           echo '<br>$comm_test1:  ',$comm_test1,'<br>   $comm_test:   ',$comm_test.'<br>';
        if ($comm_test == $comm_test1)
        {
            break;
        }

    } // while (!$comm_test == $comm_test1);
    $newkeys = preg_replace("/[\r\n\t\v\f\e\s]/", "", $newkeys);
    if (is_numeric($newkeys) && $newkeys == 'open' && $newkeys == 'close' && $newkeys ==
        'high' && $newkeys == 'low' && $newkeys == 'vol')
    {
        //     echo 'yes it is open';
        $newkeys = 'my_replce_no_title_' . $newkeys;
    }
    if (!array_key_exists($newkeys, $arrtest)) // ����ж��ƺ�����  ��ȷ�ܶ��డ

    {
        //       echo '????' . $newkeys;
        $arrtest[$newkeys][] = $comm_test; //��������������������Ϊ��һֵ

    }
  //  $arrtest[$newkeys][] = $show; //����:=�����
}

//�������ݿⲢ���ؽ����
$conn = MySQL_connect("localhost", "root", "root") or die("Could not connect: " .
    mysql_error());
MySQL_select_db("stock");
$exe = "SELECT * FROM `daily` ORDER BY `d_date` ASC  LIMIT 0 , " . $select_cycle;
$result = MySQL_query($exe, $conn); //����
echo gb('<br />������<br />');
$filename = 'data.txt';
// Let's make sure the file exists and is writable first.
if (is_writable($filename))
{

    // In our example we're opening $filename in append mode.
    // The file pointer is at the bottom of the file hence
    // that's where $somecontent will go when we fwrite() it.
    if (!$handle = fopen($filename, 'w'))
    {
        echo "Cannot open file ($filename)";
        exit;
    }

    if (fwrite($handle, "<?php \r\n \$k=array(") === false)
    {
        echo "Cannot write to file ($filename)";
        exit;
    }

    $first_douhao = '';
    for ($i = 0; $i < mysql_num_rows($result); $i++)
    {

        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $arrtest['open'][] = $row['d_open'];
        $arrtest['close'][] = $row['d_close'];
        $arrtest['high'][] = $row['d_high'];
        $arrtest['low'][] = $row['d_low'];
        $arrtest['vol'][] = $row['d_vol'];
        $arrtest['datetime'][] = $row['d_date'];
        //array(3.75,3.76,3.69,3.72),
        $tem = $first_douhao . "array(" . $row['d_open'] . ',' . $row['d_high'] . ',' .
            $row['d_low'] . ',' . $row['d_close'] . ")";
        $first_douhao = ','; // echo $tem;
        // Write $somecontent to our opened file.
        if (fwrite($handle, $tem) === false)
        {
            echo "Cannot write to file ($filename)";
            exit;
        }


        //��ͼ���鸳ֵ
        $k[$i][] = $row['d_open'];
        $k[$i][] = $row['d_high'];
        $k[$i][] = $row['d_low'];
        $k[$i][] = $row['d_close'];
        $vol[] = $row['d_vol'];
    }
    if (fwrite($handle, "); \r\n ") === false)
    {
        echo "Cannot write to file ($filename)";
        exit;
    }

    //   echo "Success, wrote ($tem) to file ($filename)";

    fclose($handle);
} else
{
    echo "The file $filename is not writable";
}

//����ѭ����ֵ
foreach ($arrtest as $key => $value)
{
    if ($key != 'open' && $key != 'close' && $key != 'high' && $key != 'low' && $key !=
        'vol' & $key != 'datetime')
        //������Ҫ�ģ���Щ���Ǳ����֣�ԭ���ϲ�����������������Ҫ����û���������������룬��������0ֵ��������Щ�ַ�����Ŀ

    {
        //       echo gb('�����' . $arrtest[$key][0] . '<br>');
        if (substr_count($arrtest[$key][0], 'my_func'))
        {

            $exec = str_replace("(", "('", $arrtest[$key][0]); //�����ż��ϡ�
            $exec = str_replace(")", "')", $exec);
            //            echo "�Ǻ�������Ҫ�滻!�滻��Ϊ" . $exec . '<br>';
            eval("\$x=" . $exec . ";");
        } else
        {
            //            echo '���Ǻ���' . $arrtest[$key][0] . '<br>';
            $exec = "not_a_func('" . $arrtest[$key][0] . "')";
            eval("\$x=" . $exec . ";");
        }
    }
}

// ������д���ļ�������ͼʹ��  ---------��ռ��ʽ �Ժ��

$filename = 'data.txt';
$somecontent = "Add this to the file\n";
// Let's make sure the file exists and is writable first.
if (is_writable($filename))
{

    // In our example we're opening $filename in append mode.
    // The file pointer is at the bottom of the file hence
    // that's where $somecontent will go when we fwrite() it.
    if (!$handle = fopen($filename, 'a'))
    {
        echo "Cannot open file ($filename)";
        exit;
    }

    //***********************************************************
    echo gb('<table width=\"830\" border=\"1\" cellspacing=\"0\" bordercolor=\"#666666\"><tr><td width=\"87\">����</td><td width="727">ֵ</td></tr>');
    foreach ($arrtest as $key => $value)
    {
   //     if ($key != 'datetime')
                   if ($key != 'datetime' & !preg_match("/my_replce_/", $key) & !preg_match("/my_func_/", $key))

        {
            echo "<tr><td>" . gb($key) . ' </td><td> ';
            //       echo "<input type=\"text\" name=".$key." id=".$key." width=\"727\" value=";
            //        echo "<input type=\"text\" name=".$key." id=".$key." width=\"727\" value=";
            //        $max_array[]=max(array_slice($arrtest[$key],1));
            //        $min_array[]=min(array_slice($arrtest[$key],1));
            //        print_r($arrtest[$key]);


            // Write $somecontent to our opened file.

            if (fwrite($handle, '$' . $key . '=array(') === false)
            {
                echo "Cannot write to file ($filename)";
                exit;
            }
            $first_douhao = '';
            $unshow_first = 0;
            foreach ($value as $nvalue)
            { //��ʱ����ʾֵ��ֻ��ʾ����
                if ($unshow_first != 0)
                {
                    echo $nvalue . ',';
                    if (!$nvalue)
                        $nvalue = 0;
                    if (fwrite($handle, $first_douhao . $nvalue) === false)
                    {
                        echo "Cannot write to file ($filename)";
                        exit;
                    }
                    $first_douhao = ',';
                }
                $unshow_first++;
            }
            echo '</td></tr>';
            if (fwrite($handle, "); //cs******* \r\n ") === false)
            {
                echo "Cannot write to file ($filename)";
                exit;
            }
        }
    }

    echo '</table>';
    if (fwrite($handle, '  ?>') === false)
    {
        echo "Cannot write to file ($filename)";
        exit;
    }

    //   echo "Success, wrote ($somecontent) to file ($filename)";

    fclose($handle);
} else
{
    echo "The file $filename is not writable";
}
// �ж����������ֵ����Сֵ Ϊ��ͼ��׼��
//echo max($max_array),min($min_array);
//echo 'MAX of Array:'.max($arrtest);
//print_r($max_array);
//print_r($min_array);
//echo min($min_array);
echo $error_msg;
$mtime = explode(' ', microtime());
$processtime = number_format(($mtime[1] + $mtime[0] - $starttime), 6);
echo gb("<br />������ʱ {$processtime} ��;");
/**
 * ��ʼ����ͼƬ
 * ����ֳ�2���ļ���
 */
$tem = rand(); //echo $tem;
//echo "<img src=\"test_array.php?a=".$tem. "\"/>";


$mtime = explode(' ', microtime());
$chart_time = number_format(($mtime[1] + $mtime[0] - $processtime - $starttime),
    6);
$all_time = number_format(($mtime[1] + $mtime[0] - $starttime), 6);
echo gb("<br />��ͼ��ʱ {$chart_time} ��;  <br />ȫ����ʱ {$all_time} ��;");
echo getcwd();
echo "<img src=\"source/plugin/stock/test_array.php?a=" . $tem . "\"/>";
//<img src="template/my1/image/logo.png" 
echo "<br /><a href=\"test_array.php?a=" . $tem . "\" target=_blank>http://localhost/stock_chart/test_array.php</a>";
/*����post����
//$x=iconv("GBK",   "UTF-8",'��ѡ�����:').iconv("GBK",   "UTF-8",$_GET['q']);
$PostContent=iconv("UTF-8","gb2312",$_POST["postcontent"]); 
$url=iconv("UTF-8","gb2312",$_POST["url"]); 
echo "UTF-8 to gb2312 PostContent:".$PostContent."<br />UTF-8 to gb2312 URL:".$url."<br />No iconv PostContent:".$_POST["postcontent"];
$x=iconv("GBK",   "UTF-8",'GBK to UTF-8 ���������ѡ�����:').iconv("GBK",   "UTF-8",$_POST['postcontent'])."<br />rand:".rand();
echo "<br />".$x; 
$post_text=preg_replace("/[\r\n]/","<br />",$_POST["text"]);
echo "�滻��".$post_text;
echo iconv("GBK",   "UTF-8","<br />�ı������ݣ�").$_POST["text"];
*/ ?>