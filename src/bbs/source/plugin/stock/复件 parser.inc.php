<?php

/**
	Formula Editor 
	Copyright (c) 2009-2014 Ioying (http://www.ttlele.com)
	$Id: extend_common.css 2013-12-21 ioying $
 * 公式解析模块
 * 以服务方式提供解析，
 * 调用方式 $test = posttohost('http://localhost/newstock/parser.php', $data);  
 * 以 echo $json_string; 返回计算结果
 * @author Leo
 * @copyright 2009-04-22
 * 
 * 'my_replce_no_title_'  my_replce_id   my_func_
 * 
 * 20090518 解析:=  与 :  中间计算行 ':=' 不显示。 
 * 20090309 修改计划
 *   分割各功能模块，尽可能函数化模块化。 做成对象？
 *   公式解析与计算分开，计算结果存储   参考 数组先用serialize序列化再入库,取出时再反序列  BinaryFormatter这个类
 *   整理 优化函数
 *  待处理： 错误捕捉及信息反馈
 */  

// 模块化之后， 这两行无用
//include 'header.php';
//include 'func/func.php';


$replce_id = 0; //数组索引序号


function replced_id($matches)
{ //替换时去掉两边括号并添加数组索引 
    global $replce_id, $arrtest;
    $arrtest["my_replce_id$replce_id"][] = array($matches[0],'noshow');
    return preg_replace("/[\(\)]/", '', "my_replce_id" . $replce_id++);
}

function replced_func($matches)
{   // replced_id & replced_func 这两个函数，是要使整个表达式无括号化，一个替换表示计算优先次序的括号， 一个替换表示函数的括号。
    global $replce_id, $arrtest;
    $arrtest["my_replce_id$replce_id"][] = array($matches[0],'noshow');
    return "my_replce_id" . $replce_id++;
}

//此段可优化， 也许可以通过数据在库中的存储格式改变这部分的计算， 每个公式都要重新读并转换一遍，浪费。
$arrtest["open"][] = array("open",'noshow',"name" =>"Open");  
$arrtest["close"][] =array( "close",'noshow',"name" =>"Close");
$arrtest["high"][] = array("high",'noshow',"name" =>"High");
$arrtest["low"][] = array("low",'noshow',"name" =>"Low");
$arrtest["vol"][] = array("vol",'noshow',"name" =>"Vol");
$arrtest["datetime"][] = array("datetime",'noshow',"name" =>"Date");

$comm_text = strtolower($_POST["text"]); // 全部小写化， 也许没必要。 以后处理。


$comm_text = preg_replace("/[\r\n]/", "", $_POST["text"]); //去掉回车换行符号 此行曾认为无用， 屏蔽过，不过在做注释解析的时候，考虑到多行注释中换行回车符号问题，又重新启用。
$comm_text = preg_replace("/\{.+\}|\{\}/i", "", $comm_text); // 将多有 大括号之间的内容忽略。替换为空。 大括号之间为注释，将来可能还支持/* */ //等注释方式。

/*
$select_cycle1 = $_POST["select_cycle"];
if ($select_cycle1 < 20)
    $select_cycle1 = 20;
*/	
//echo gb('处理周期：'.$select_cycle);
//echo '处理周期：'.$select_cycle;
//echo $comm_text;
//$comm_text = "A: (h-l)/2;B: (REF(H,1)+REF(L,1))/2;MID:A-B;BRO:V/(H-L);";
//$comm_text = " ma5:ref(abs(l-h),5);";
//$comm_text = " ma5:ma(2*h-l,5)+o;h*abs(l-h);mama5:ma(ma5,10);mamax:=ma(ma(ma5,5),10);"; //用户输入文本 简单 ':'  分割key ';'分割命令行ma_x : ma (ma(o*2,3)-4+(5+abs(6)+((o+c)-(v-c)))+o+ma5+a2+5a+abs(7-8)+c,9);ma_y : ma ( c+ C,5);

//$comm_text = trim(str_replace(" ", "", $comm_text)); //去除字符串中半角空格     为什么要去除空格呢？ 不理解 忘记鸟
$comm_text = str_replace('%u3000', "  ", $comm_text);
$comm_text = str_replace("　", " ", $comm_text); //去除串中全角空格 全角空格改成半角空格 否则出错   全角空格接收后是编码的 %u3000
if (preg_match("/[\)]\w/", $comm_text))
{
 $errormsg=$errormsg.'缺少运算符或命令行结尾缺少“;” 或回车换行!';
    //echo gb('缺少运算符或命令行结尾缺少“;” 或回车换行!' . $comm_text);
    exit;
}
/*  判断命令行是否以; 结尾， 现在不需要了，可以以回车结尾，增加容错
$last_char=substr($comm_text,-1);
if($last_char!=";") 
{ 
echo gb('命令行结尾缺少“;”');
$comm_text=$comm_text.';';
}
*/

//if(substr($comm_text,-1,-1))
$comm_text = ' ' . $comm_text . ' ';
//替换所有函数为 myfunc。。。
$comm_text = preg_replace("/(\w+(?=\())/i", 'my_func_' . "\\1", $comm_text);
$comm_text = preg_replace("/(?<=\W)[oO](?=\W)|\bo(?=\W)/i", "open", $comm_text);
$comm_text = preg_replace("/(?<=\W)[cC](?=\W)|\bc(?=\W)/i", "close", $comm_text);
$comm_text = preg_replace("/(?<=\W)[hH](?=\W)|\bh(?=\W)/i", "high", $comm_text);
$comm_text = preg_replace("/(?<=\W)[lL](?=\W)|\bl(?=\W)/i", "low", $comm_text);
$comm_text = preg_replace("/(?<=\W)[vV](?=\W)|\bv(?=\W)/i", "vol", $comm_text);
//echo $comm_text;
//以';'回车换行分割用户输入  参数-1表示无数量限制
$comm_lines = preg_split('/[;\r\t]/', $comm_text, -1, PREG_SPLIT_NO_EMPTY); //怎样一次返回一个二维数组？用'/[:;]/' ？？？
//print_r($comm_lines);
/*
echo gb('行分离后的用户输入：<br>'); //显示分离后的命令行
foreach ($comm_lines as $key => $comm_splited)
{
echo $key . ':  ' . $comm_splited . "<br>";
}
// input:p1(14,1,999,1),p2(9,1,999,1);  
*/
$now_lines = 0;
foreach ($comm_lines as $comm_key) 
{
	$comm_key = preg_replace("/[\r\n\t\v\f\e\s]/", "", $comm_key); //去掉回车\换行\制表符，Tab\竖向制表符\换页符\换页符 符号
    if ($comm_key == ' ' || $comm_key=='')
        break;  // 处理空行 只有回车换行符号的空行。
    $now_lines++;
    $show = 'show'; //判断 :=为 'noshow' ，  : 为'show'  默认 'show'则显示，否则不显示
    
    if (substr_count($comm_key, ":=") == 1) //处理 := 的情况

    {
        $show = 'noshow';
        $comm_key = str_replace(":=", ":", $comm_key);
  //      echo $comm_key;
    }

    if (substr_count($comm_key, ":") == 1) //判断命令行中是否有：

    {
        $newkeys = mb_substr($comm_key, 0, strpos($comm_key, ':'));
    } else
    {
        //	echo 'commkey::::'.$comm_key;
        $newkeys = $comm_key;
    }

    if (substr_count($comm_key, ":") == 1)
    { //判断命令行中是否有：，这里暂时忽略:= 的情况！！！
        $comm_test = mb_substr($comm_key, strpos($comm_key, ':') + 1);
    } else
    {
        $comm_test = $comm_key;
    }
    //echo '<br>:后面部分：'.$comm_test.'<br>';


    $comm_test = ' ' . $comm_test . ' ';
    preg_match_all("/(?<=[\b\+\-\/\(\,\*\%\^\;\s])\w+(?=[\+\-\/\)\,\*\%\^\;\b\s])|(\+|\-)?([1-9]\d+)?[0-9]+(\.[0-9]+)/i",
        $comm_test, $newstr6);
    $comm_test1 = $comm_test;
    $tem = 0;
    for ($i = 0;; $i++)
    {
        //	echo "喜欢第".$tem++ ."次！";
        $comm_test = $comm_test1;
        $comm_test1 = preg_replace_callback("/(?<!\w)(\([^()]+\))/i", "replced_id", $comm_test1);
        $comm_test1 = preg_replace_callback("/(\w+)(\([a-z0-9\b\%\^\_\.\+\-\*\/\,\d]+\))/",
            "replced_func", $comm_test1);
        //           echo '<br>$comm_test1:  ',$comm_test1,'<br>   $comm_test:   ',$comm_test.'<br>';
        if ($comm_test == $comm_test1)
        {
            break;
        }

    } 	// while (!$comm_test == $comm_test1);
    $newkeys = preg_replace("/[\r\n\t\v\f\e\s]/", "", $newkeys);
		if (!array_key_exists($newkeys, $arrtest)) 
			// 这个判断似乎多余  的确很多余啊  不多余，删掉出错！20140207
		{
			// echo '<br>---newkeys---' . $newkeys.'==show=='.$show;
			// $arrtest[$newkeys][] = $comm_test; //以行名增加索引并以行为第一值 
        $arrtest[$newkeys][] =array($comm_test,$show,"name" =>$newkeys); 
			//	以行名增加索引并以行为第一值 尝试增加更多参数 比如 show参数 . show 已增。 20140207新增  
			//  name项，供绘图使用 

		}

			//    以前用错了符号 &&是 与  or 是或 , 单值行问题。已解决 20140128
			//    if (is_numeric($newkeys) && $newkeys == 'k_open' && $newkeys == 'k_close' && $newkeys == 'k_high' && $newkeys == 'k_low' && $newkeys == 'k_vol')

		if (is_numeric($newkeys) or $newkeys == 'open' or $newkeys == 'close' or $newkeys == 'high' or $newkeys == 'low' or $newkeys == 'vol')
    {
//              echo 'yes it is open';
        $newkeys = 'my_replce_no_title_' . $newkeys.'_'.$now_lines;
    }else{
//	          echo '-xxxxxxx-'.($newkeys == 'k_open');
	}
	
/// 	echo '<br>---newkeys---' . $newkeys."*<br>";

  //  $arrtest[$newkeys][] = $show; //处理:=的情况
}
//$arrtest['errormsg']=$errormsg;  // 错误信息的传递和显示还是个问题。
$json_string = json_encode($arrtest);    //数组转换成 json 串
echo $json_string;   //返回计算结果， 此echo 不在页面显示 
//echo '<br><pre>';
//print_r($arrtest);
 ?>