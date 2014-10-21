<?php

/**
 * @author Andrew
 * @copyright 2008
 * try to make function 
 * function error_handler($error_no, $error_str, $error_file, $error_line)// ��������
 * my_func_ma($MA_Str)   //�ƶ�ƽ������ ma   �˺������Ż� ��jֵѭ���������� +��ֵ��-��ֵ
 * make_str($make_str)   //�ַ���������
 * my_func_abs($MA_Str)  // ����ֵ���� abs����
 * not_a_func($MA_Str)   //����Ǻ����ַ���
 * my_func_REF(X,A)              //����A����ǰ��Xֵ��
 * gb($str)  //���� ����ת��
 */
function gb($str) //���� ����ת��

{
    return iconv("GBK", "UTF-8", $str);
}
function error_handler($error_no, $error_str, $error_file, $error_line)
    // ��������

{
    global $error_msg, $xxx, $error_zero;
    //	echo $error_no,$error_str,$error_file, $error_line;
    // not for @ errors
    if (error_reporting() == 0)
        return;
    // sort out what kind of error we have
    switch ($error_no)
    {
        case E_NOTICE:
            return;
            break;
        case E_USER_NOTICE:
            $continue = true;
            $type = "Notice";
            break;
        case E_USER_WARNING:
        case E_WARNING:
            $continue = true;
            $type = "Warning";
            break;
        case E_USER_ERROR:
        case E_ERROR:
            $type = "Fatal Error";
            break;
        default:
            $type = "Unknown Error";
            break;
    }
    // put in error log
    error_log("[" . date("d-M-Y H:i:s") . "] PHP $type: $error_parts[0] error in line $error_line of file $error_file",
        0);
    if ($error_str == "Call to undefined function")
    {
        echo gb("����: δ���庯��!") . nl2br($error_str);
    }
    if ($error_str == "Division by zero")
    { // do your thing
        $error_msg = '<br />ע��:���ֳ������!';
        $error_zero = 1;
        $xxx = 0;
    } else
    { // display
        echo "\n<div>" . nl2br($error_str) . "</div>\n";
    }

    // halt for fatal errors
    if (!isset($continue))
        exit();
}

//set_error_handler("error_handler");

//*******************************************************************************************
function make_str($make_str) //�ַ���������

{
    global $i, $arrtest, $key; //
    $make_str = '    ' . $make_str . '    '; // �����˼ӿո� Ϊ�Ժ����� ==!
    
//	    echo gb('<br />���������ַ���Ϊ:' . $make_str); //��������ʾ�����Ϣ
    preg_match_all("/(?<=[\b\+\-\/\(\,\*\%\^\;\s])\w+(?=[\+\-\/\)\,\*\%\^\;\b\s])|(\+|\-)?([1-9]\d+)?[0-9]+(\.[0-9]+)/i",
        $make_str, $newstr6); //ƥ�����в�����
    //       print_r($newstr6);
    foreach ($newstr6[0] as $eachkey) //�����ж�

    {
        $eachkey = trim($eachkey);
        //                 echo '<br>' . $eachkey . '<br>';
        if (!array_key_exists($eachkey, $arrtest))
        {
            if (!is_numeric(trim($eachkey)))
            {
                echo gb('����' . $eachkey . 'û�ж���,�顰0������<br>');
                return 0;
                /*
                foreach ($arrtest as $key => $value)
                {
                echo "   " . gb($key).'   ';  
                }
                echo '***end***';
                */
            } else
            {
                //                		echo	gb('*'.$eachkey.'������<br>');
            }
        } else
        {
            //                         echo gb($eachkey . '���Ѿ�����ı�������<br>');
            if (!is_numeric(trim($eachkey))) //������������

            {
                $make_str = preg_replace("/((?<=[\b\+\-\/\(\,\*\%\^\;\s])$eachkey(?=[\+\-\/\)\,\*\%\^\;\b\s]))/i",
                    "\$arrtest['" . "\\1" . "'][\$k]", $make_str);
            }
            //           echo '�������:' . $make_str . ' <br>  ';
        }

    }
    return $make_str;
}
//**********************************************************************************
function my_func_REF($MA_Str) //REF(X,A) ����A����ǰ��Xֵ��

{
    global $i, $arrtest, $key, $error_zero; //
    $MA_Str = make_str($MA_Str);
    $exec_lines = preg_split('/,/', $MA_Str);
    $MA_value = trim($exec_lines[0]);
    $MA_Period = $exec_lines[1] + 0;
    //    echo 'jjjjjjjj' . $MA_value . '    ' . $MA_Period;
    for ($j = 1; $j < $i; $j++)
    {
        $k = $j - $MA_Period;
        if ($k > 0)
        {
            $error_zero = 0; //������� 0�� 1��
            $ma_tem = 0;
            $tem_exec = $MA_value;
            //				echo 'exec:'.$tem_exec.$k.' <br>  ';
            eval("\$ma_tem=" . $tem_exec . ';');
            $xxx = abs($ma_tem);
        } else
        {
            $xxx = null;
        }
        if ($error_zero == 0)
        {
            $arrtest[$key][$j] = $xxx;
        } else
        {
            $arrtest[$key][$j] = 0;
        }
        //     $arrtest[$key][$j] = $xxx;
    }


    //    echo $MA_value . $MA_Period;
}
//**********************************************************************************
function my_func_abs($MA_Str) // ����ֵ���� abs����

{
    global $i, $arrtest, $key, $error_zero; //
    $MA_Str = make_str($MA_Str);


    for ($k = 1; $k < $i; $k++)
    {
        //	  	echo 'k:'.$k;
        $ma_tem = 0;
        $tem_exec = $MA_Str;
        //				echo 'exec:'.$tem_exec.$k.' <br>  ';
        $error_zero = 0; //������� 0�� 1��
        eval("\$ma_tem=" . $tem_exec . ';');
        $xxx = abs($ma_tem);
        //        echo $error_zero;
        if ($error_zero == 0)
        {
            $arrtest[$key][$k] = $xxx;
        } else
        {
            $arrtest[$key][$k] = 0;
        }
    }
    return $xxx;


}
//*************************************************************************************
function not_a_func($MA_Str) //����Ǻ����ַ���

{
    global $i, $arrtest, $key, $error_zero; //
    $MA_Str = make_str($MA_Str);
//         echo 'not_a_func:'.$MA_Str;
    for ($k = 1; $k < $i; $k++)
    {
        //	  	echo 'k:'.$k;
        $ma_tem = 0;
        $tem_exec = $MA_Str;
        //        				echo 'exec:'.$tem_exec.$k.' <br>  ';
        $error_zero = 0; //������� 0�� 1��
        eval("\$ma_tem=" . $tem_exec . ';');
        $xxx = $ma_tem;
        //       echo $error_zero;
        if ($error_zero == 0)
        {
            $arrtest[$key][$k] = $xxx;
        } else
        {
            $arrtest[$key][$k] = 0;
        }
        //       $arrtest[$key][$k] = $xxx;
    }
    return $xxx;


    //		$MA_Period= $exec_lines[1]+0;
}
//*******************************************************************************
function my_func_ma($MA_Str) //�ƶ�ƽ������ ma   �˺������Ż� ��jֵѭ���������� +��ֵ��-��ֵ

{
    global $i, $arrtest, $key, $error_zero; //
    $MA_Str = make_str($MA_Str);
    $exec_lines = preg_split('/,/', $MA_Str);
    $MA_Method = trim($exec_lines[0]);
    $MA_Period = $exec_lines[1] + 0;
    //echo 'MA_Method:'.$MA_Method.'  per:'.$MA_Period.' i:'.$i.' <br>  ';
    //echo '  $i-($MA_Period-1):',$i-($MA_Period-1).' <br>  ';
    for ($x = 1; $x < $i; $x++)
    {
   //     	  	echo 'k:'.$k;
        if ($x - $MA_Period + 1 > 0)
        {
            $ma_tem = 0;
            for ($j = 0; $j < $MA_Period; $j++)
            {
                $k = $x - $j;
    //            			echo 'X:'.$x.'K:'.$k;

                $tem_exec = $MA_Method; //.$x.']';
                //				echo 'exec:'.$tem_exec.' <br>  ';
                $error_zero = 0; //������� 0�� 1��
                eval("\$ma_tem=\$ma_tem+" . $tem_exec . ';');
            }
            $xxx = $ma_tem / $MA_Period;
        } else
        {
   //     	              			echo 'X:'.$x.'K:'.$k;
            $xxx = null;
        }
        if ($error_zero == 0)
        {
            $arrtest[$key][$x] = $xxx;
        } else
        {
            $arrtest[$key][$x] = 0;
        }
        //        $arrtest[$key][$x] = $xxx;
    }
    return $xxx;
    //}


}


/*
$conn=MySQL_connect ("localhost", "root", "root") or die("Could not connect: " .mysql_error());

MySQL_select_db("stock"); 
echo $conn.'<br>';
$exe="SELECT * FROM `stock_code`LIMIT 0 , 1060  ";  
$result=MySQL_query($exe,$conn); 
while($rs=MySQL_fetch_object($result)) 
{
echo "*".$rs->s_code.'-'.$rs->s_name."<br>";  
}
*/


/*2.�������Ժ���
*
*����PHP����ĵ���һֱ��һ������ͷ�۵��£����Ȳ���VB�ȸ߼����������м��ɵı�*����Ի�����Ҳ����Perl����������Linux����DOS������ֱ�����С���ʵ��������ȫ��*��ͨ������ʹ��echo�������ɶ�PHP�ĵ��Թ����� 
*
*��������ļ�����������������ʱ�鿴�������κα��������ͼ���ֵ�� 
*��Ҫ��ʱ���ڳ����м򵥵ؼ��������һ�����뼴�ɲ鿴�����е���ʹ�õı�������*������Ͷ��󣩵����ͺ�ֵ�� 
*
*echo ss_as_string($my_variable);  
*
*����ʹ���������䣬���ǿ���ֱ�Ӳ鿴���������еı�����ֵ�� 
*
*echo ss_as_string($GLOBALS);  
*

���ź� �д��� ������


function ss_array_as_string (&$array, $column = 0) 
{ 
��$str = 'Array(
n'; 
����while(list($var, $val) = each($array)){ 
������for ($i = 0; $i < $column��1; $i����){ 
��������$str .= "&nbsp;&nbsp;&nbsp;&nbsp;"; 
������} 
������$str .= $var. ==�� ; 
������$str .= ss_as_string($val, $column��1)." n"; 
����} 
����for ($i = 0; $i < $column; $i����){ 
������$str .= "&nbsp;&nbsp;&nbsp;&nbsp;"; 
����} 
����return $str.); 
��} 
��function ss_object_as_string (&$object, $column = 0) { 
����if (empty($object����classname)) { 
������return "$object"; 
����} 
����else { 
������$str = $object����classname."( n"; 
��������while (list(,$var) = each($object����persistent_slots)) { 
����������for ($i = 0; $i < $column; $i����){ 
������������$str .= "&nbsp;&nbsp;&nbsp;&nbsp;"; 
����������} 
����������global $$var; 
����������$str .= $var. ==�� ; 
����������$str .= ss_as_string($$var, column��1)." n"; 
��������} 
��������for ($i = 0; $i < $column; $i����){ 
����������$str .= "&nbsp;&nbsp;&nbsp;&nbsp;"; 
��������} 
��������return $str.); 
����} 
��} 
��function ss_as_string (&$thing, $column = 0) { 
������if (is_object($thing)) { 
��������return ss_object_as_string($thing, $column); 
������} 
������elseif (is_array($thing)) { 
��������return ss_array_as_string($thing, $column); 
������} 
������elseif (is_double($thing)) { 
��������return "Double(".$thing.")"; 
������} 
������elseif (is_long($thing)) { 
��������return "Long(".$thing.")"; 
������} 
������elseif (is_string($thing)) { 
��������return "String(".$thing.")"; 
������} 
������else { 
��������return "Unknown(".$thing.")"; 
������} 
��} 
}
*/

/*   �� make_str��������
$MA_Str = '    ' . $MA_Str . '    ';
echo '���������ַ���Ϊ:' . $MA_Str . '   $i:' . $i . '  Key:' . $key;
preg_match_all("/(?<=[\b\+\-\/\(\,\*\%\^\;\s])\w+(?=[\+\-\/\)\,\*\%\^\;\b\s])|(\+|\-)?([1-9]\d+)?[0-9]+(\.[0-9]+)/i",
$MA_Str, $newstr6);
//print_r($newstr6);
foreach ($newstr6[0] as $eachkey)
{
$eachkey = trim($eachkey);
echo '<br>' . $eachkey . '<br>';
if (!array_key_exists($eachkey, $arrtest))
{
if (!is_numeric($eachkey))
{
echo '��������' . $eachkey . 'û�ж���<br>';
} else
{
//		echo	'*'.$eachkey.'������<br>';
}
} else
{
echo $eachkey . '���Ѿ�����ı�������<br>';
$MA_Str = preg_replace("/((?<=[\b\+\-\/\(\,\*\%\^\;\s])$eachkey(?=[\+\-\/\)\,\*\%\^\;\b\s]))/i",
"\$arrtest['" . "\\1" . "'][\$k]", $MA_Str);
echo $MA_Str . ' <br>  ';
}
}
*/ //�� make_str��������






?>  
 

