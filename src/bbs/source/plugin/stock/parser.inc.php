<?php
/**********************************************************************
 *	Formula Editor Parser
 *	Copyright (c) 2009-2014 Ioying@hotmail.com (http://www.ttlele.com, http://www.ttall.net) 
 *	 
 *  ��ʽ����ģ��
 *  �Է���ʽ�ṩ������
 *  ���÷�ʽ $test = posttohost('http://xxx.xxx.com/newstock/parser.php', $data);  
 *  �� echo $json_string; ���ؼ�����
 *  
 * 
 * 
 *  ������ ����׽����Ϣ����  die()  set_error_handler("customError");
 *  input:p1(14,1,999,1),p2(9,1,999,1);   δ����    ��������
 **********************************************************************
 */  
error_reporting(E_ALL);

$replce_id = 0; 						//		�����������


function replced_id($matches) 
	{ 	//�滻ʱȥ���������Ų������������ 
		global $replce_id, $arrtest;
		$arrtest["my_replce_id$replce_id"][] = array($matches[0],'show'=>'noshow');
		return preg_replace("/[\(\)]/", '', "my_replce_id" . $replce_id++);
	}

function replced_func($matches)
	{   // replced_id & replced_func ��������������Ҫʹ�������ʽ�����Ż���һ���滻��ʾ�������ȴ�������ţ� һ���滻��ʾ���������š�
		global $replce_id, $arrtest;
		$arrtest["my_replce_id$replce_id"][] = array($matches[0],'show'=>'noshow');
		return "my_replce_id" . $replce_id++;
	}

	//�˶ο��Ż��� Ҳ�����ͨ�������ڿ��еĴ洢��ʽ�ı��ⲿ�ֵļ��㣬 ÿ����ʽ��Ҫ���¶���ת��һ�飬�˷ѡ�
$arrtest["open"][] = array("open",'show'=>'noshow',"name" =>"Open");  
$arrtest["close"][] =array( "close",'show'=>'noshow',"name" =>"Close");
$arrtest["high"][] = array("high",'show'=>'noshow',"name" =>"High");
$arrtest["low"][] = array("low",'show'=>'noshow',"name" =>"Low");
$arrtest["vol"][] = array("vol",'show'=>'noshow',"name" =>"Vol");
$arrtest["datetime"][] = array("datetime",'show'=>'noshow',"name" =>"Date");

			//$comm_text = strtolower($_POST["text"]); 	// ȫ��Сд���� Ҳ��û��Ҫ�� �Ժ���2009��  ȷʵû��Ҫ��������ڱ������ţ��ݱ���20140222


$comm_text = preg_replace("/[\r\n]/", "", $_POST["text"]); 		
											//		ȥ���س����з��� 	��������Ϊ���ã����ι�����������ע�ͽ�����ʱ�򣬿��ǵ�����ע���л��лس��������⣬���������á�
$comm_text = preg_replace("/\{.+\}|\{\}/i", "", $comm_text); 

											// �� ������֮������ݺ��ԡ��滻Ϊ�ա� ������֮��Ϊע�ͣ��������ܻ�֧��/* */ //��ע�ͷ�ʽ��

											//echo $comm_text;
											//$comm_text = trim(str_replace(" ", "", $comm_text)); //ȥ���ַ����а�ǿո�     ΪʲôҪȥ���ո��أ� ����� ������
											
$comm_text = str_replace('%u3000', "  ", $comm_text);
$comm_text = str_replace("��", "", $comm_text); //ȥ������ȫ�ǿո� ȫ�ǿո�ĳɰ�ǿո� �������   ȫ�ǿո���պ��Ǳ���� %u3000
if (preg_match("/[\)]\w/", $comm_text))
{
 $errormsg=$errormsg.'ȱ��������������н�βȱ�١�;�� ��س�����!';
											//echo gb('ȱ��������������н�βȱ�١�;�� ��س�����!' . $comm_text);
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


//$comm_text = preg_replace("/(\w+(?=\())/i", 'my_func_' . "\\1", $comm_text);
/* $comm_text = preg_replace("/(?<=\W)[oO](?=\W)|\bo(?=\W)/i", "open", $comm_text);
$comm_text = preg_replace("/(?<=\W)[cC](?=\W)|\bc(?=\W)/i", "close", $comm_text);
$comm_text = preg_replace("/(?<=\W)[hH](?=\W)|\bh(?=\W)/i", "high", $comm_text);
$comm_text = preg_replace("/(?<=\W)[lL](?=\W)|\bl(?=\W)/i", "low", $comm_text);
$comm_text = preg_replace("/(?<=\W)[vV](?=\W)|\bv(?=\W)/i", "vol", $comm_text); */

//  echo $comm_text;
//��';'�س����зָ��û�����  ����-1��ʾ����������
$comm_lines = preg_split('/[;\r\t]/', $comm_text, -1, PREG_SPLIT_NO_EMPTY); //����һ�η���һ����ά���飿��'/[:;]/' ������
//print_r($comm_lines);

//echo gb('�з������û����룺<br>'); //��ʾ������������
/*foreach ($comm_lines as $key => $comm_splited)
{
echo $key . ':  ' . $comm_splited . "<br>";
}

// input:p1(14,1,999,1),p2(9,1,999,1);   δ����    

*/
$now_lines = 0;
foreach ($comm_lines as $CommKey) 
{
	$CommKey = preg_replace("/[\r\n\t\v\f\e\s]/", "", $CommKey); //ȥ���س�\����\�Ʊ����Tab\�����Ʊ��\��ҳ��\��ҳ�� ����
    if ($CommKey == ' ' || $CommKey=='')
        break;  // ������� ֻ�лس����з��ŵĿ��С�
    
	
//	echo 'CommKey:'.$CommKey.'---<br/>';

	$show = 'show'; //�ж� :=Ϊ 'noshow' ��  : Ϊ'show'  Ĭ�� 'show'����ʾ��������ʾ
	// ��ͼ���δ���
		$ChartTypes = 'line';
		$ColorTypes = '';
		$ReplaceCount=0;
	$find = array(",VOLSTICK",", VOLSTICK");     //�ɽ��������� ��״ͼ type: 'column' ��ɫ ���� �µ�
	$replace = '';
	$CommKey = str_ireplace($find,$replace = '',$CommKey,$ReplaceCount);
		if ($ReplaceCount == 1) {
		$ChartTypes = 'column';
		$ColorTypes = 'UpDown';
		$Show = 'show';
		}else{
		}

		$find = array(",COLORSTICK",", COLORSTICK");     // ������״ͼ type: 'columnrange' ��ɫ ���� �� ���� ��
		$replace = '';
	$CommKey = str_ireplace($find,$replace = '',$CommKey,$ReplaceCount);
		if ($ReplaceCount == 1) {
			$ChartTypes = 'columnrange';
			$ColorTypes = 'byZero';
			$Show = 'show';
		}else{
		}
		
		
//	echo 'CommKeyReplaced:'.$CommKey.$ReplaceCount.$ChartTypes.'---<br/>';
	
	$now_lines++;
    
    
    if (substr_count($CommKey, ":=") == 1) //���� := �����
    {
        $show = 'noshow';
        $CommKey = str_replace(":=", ":", $CommKey);
  //      echo $CommKey;
    }

    if (substr_count($CommKey, ":") == 1) //�ж����������Ƿ��У�
    {
        $newkeys = mb_substr($CommKey, 0, strpos($CommKey, ':'));
    } else
    {
        //	echo 'commkey::::'.$CommKey;
        $newkeys = $CommKey;
    }

    if (substr_count($CommKey, ":") == 1)
    { //�ж����������Ƿ��У���������ʱ����:= �����������
        $comm_test = mb_substr($CommKey, strpos($CommKey, ':') + 1);
    } else
    {
        $comm_test = $CommKey;
    }
	$comm_test = ' ' . $comm_test . ' ';
		$comm_test = preg_replace("/(\w+(?=\())/i", 'my_func_' . "\\1", $comm_test);  	
					//	�滻���к���Ϊ myfunc������������������ģ����ޡ������ļ������У�keyֵ��Ӧ��ʾ my_func, �ʲ���key���滻
		$comm_test = preg_replace("/(?<=\W)[oO](?=\W)|\bo(?=\W)/i", "open", $comm_test);
		$comm_test = preg_replace("/(?<=\W)[cC](?=\W)|\bc(?=\W)/i", "close", $comm_test);
		$comm_test = preg_replace("/(?<=\W)[hH](?=\W)|\bh(?=\W)/i", "high", $comm_test);
		$comm_test = preg_replace("/(?<=\W)[lL](?=\W)|\bl(?=\W)/i", "low", $comm_test);
		$comm_test = preg_replace("/(?<=\W)[vV](?=\W)|\bv(?=\W)/i", "vol", $comm_test);
    //echo '<br>:���沿�֣�'.$comm_test.'<br>';


    $comm_test = ' ' . $comm_test . ' ';
				//	$_SERVER['SERVER_NAME'] �������ڷ�����ѡ���ļ�

	 include 'jmafter.php';
    $comm_test1 = $comm_test;
    $tem = 0;
    for ($i = 0;$i < 1000; $i++)
    {
        //	echo " ��".$tem++ ."�Σ�";
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
		
				if (is_numeric($newkeys) or $newkeys == 'open' or $newkeys == 'close' or $newkeys == 'high' or $newkeys == 'low' or $newkeys == 'vol')
    {
			//              echo 'yes it is open';
        
		$name = $newkeys;
		$newkeys = 'my_replce_no_title_' . $newkeys.'_'.$now_lines;
		
    }else{
	$name = $newkeys;
				//	          echo '-xxxxxxx-'.($newkeys == 'k_open');
	}
		
		
		
		
		if (!array_key_exists($newkeys, $arrtest)) 
			// ����ж��ƺ�����  ��ȷ�ܶ��డ  �����࣬ɾ������20140207
		{
			// echo '<br>---newkeys---' . $newkeys.'==show=='.$show;
			// $arrtest[$newkeys][] = $comm_test; //��������������������Ϊ��һֵ 
        $arrtest[$newkeys][] =array($comm_test,'show'=>$show,"name" =>$name,'ChartTypes'=>$ChartTypes,'ColorTypes'=>$ColorTypes); 
			//	��������������������Ϊ��һֵ �������Ӹ������ ���� show���� . show ������ 20140207����  
			//  name�����ͼʹ�� ,'ChartTypes'=>$ChartTypes,'ColorTypes'=>$ColorTypes

		}

			//    ��ǰ�ô��˷��� &&�� ��  or �ǻ� , ��ֵ�����⡣�ѽ�� 20140128
			//    if (is_numeric($newkeys) && $newkeys == 'k_open' && $newkeys == 'k_close' && $newkeys == 'k_high' && $newkeys == 'k_low' && $newkeys == 'k_vol')

/* 		if (is_numeric($newkeys) or $newkeys == 'open' or $newkeys == 'close' or $newkeys == 'high' or $newkeys == 'low' or $newkeys == 'vol')
    {
			//              echo 'yes it is open';
        $newkeys = 'my_replce_no_title_' . $newkeys.'_'.$now_lines;
    }else{
				//	          echo '-xxxxxxx-'.($newkeys == 'k_open');
	}
	 */
				/// 	echo '<br>---newkeys---' . $newkeys."*<br>";

				//  $arrtest[$newkeys][] = $show; 	//����:=�����
}
//$arrtest['errormsg']=$errormsg;  				//������Ϣ�Ĵ��ݺ���ʾ���Ǹ����⡣
$json_string = json_encode($arrtest);    		//����ת���� json ��
echo $json_string;   							//���ؼ������� ��echo ����ҳ����ʾ 
												//echo '<br><pre>';
												//print_r($arrtest);
 ?>