<?php

/**
 * calculate.php ���ݽ�����Ĺ�ʽ���м��㲿��
 * @author 
 * @copyright 2008
 * 
 * 20090427
 * ����ԭ��д�� data.txt �����д���  �� ��������� JSON ����ʹ��ݡ�
 * 20140128 ʹ�� getcsv.php ��ȡ��������,ԭ data.txt ������
 *
 * 20090427
 * �Ժ�ʹ�����ݿ������������ݿ����ӣ�������ʱֱ�����ӡ�
 * �����Ժ����ʹ��������ʽ�洢���ݣ����� �ı� �ȡ�
 * 
 * 20090309 �޸ļƻ�
 *   �ָ������ģ�飬�����ܺ�����ģ�黯�� ���ɶ���
 *   ��ʽ���������ֿ����������洢   �ο� ��������serialize���л������,ȡ��ʱ�ٷ�����  BinaryFormatter�����
 *   ���� �Ż�����
 * 
 * ��ajax�����Ľ����������
 * 'my_replce_no_title_'  my_replce_id   my_func_
 * 
 */


/**
 * include 'header.inc.php';
 * include 'func/func.php';
 * include 'func/config.php';
 */
//�������ݿⲢ���ؽ����
//����Ҫ����һЩ���������� ���㷶Χ�Ǵ���ʷ������㿪ʼ�����¼��㣩����ֻ������������ ��ˢ�����ݣ� ���ָ��λ�ÿ�ʼ 200427
 

// include 'func/func.php'; // ��Ʊ��ʽ������
// ��Ҫ�Զ����� 
include DISCUZ_ROOT.'./source/plugin/stock/func/make_str.func.php'; 
include DISCUZ_ROOT.'./source/plugin/stock/func/not_a_func.func.php';

//include 'func/my_func_ma.php'; // //20090603 ����Զ� including ���������ļ����⡣  

//echo getcwd();
//include 'getcsv.inc.php';  // ��csv�ļ���ȡԭʼ����
//include 'getfromdatabase.php'; // �����ݿ��ļ���ȡԭʼ����
/*��Ϊ��ȡ csv�ļ�  �� getcsv.php  ��ԭ���ݿ����ӺͶ�ȡ���֣�ת��getfromdatabase.php 20140127 */

	
//			echo "<pre>";
//			print_r($arrtest);	
	


$i = count($arrtest['open'])-1;   // ���������ݸ���, $i ��֮��ĺ����о�Ҫʹ�õ���
	
//����ѭ����ֵ
foreach ($arrtest as $key => $value) {
    if ($key != 'open' && $key != 'close' && $key != 'high' && $key != 'low' && $key !=
        'vol' & $key != 'datetime')
        //������Ҫ�ģ���Щ���Ǳ����֣�ԭ���ϲ�����������������Ҫ����û���������������룬��������0ֵ��������Щ�ַ�����Ŀ
		// ԭ��ֵǰ�� k_  �����ֹؼ��֡�20140128

    {
 //              echo gb('�����' . $arrtest[$key][0][0] . '<br>');
 
 //20090518  ��ԭ��$arrtest[$key][0] ��Ϊ $arrtest[$key][0][0], �����һ��������ԭ�����м��㹫ʽ��Ϊ�����飬�������һ����ԭ�����м��㹫ʽ�� �ڶ���Ĭ��Ϊ show ���� noshow ��Ҳ��Ϊ�յ�ʱ�� Ĭ��Ϊ show k������ o c l h v d ��Ĭ�Ͽա� 
        if (substr_count($arrtest[$key][0][0], 'my_func')) {

            $exec = str_replace("(", "('", $arrtest[$key][0][0]); //�����ż��ϡ�
            $exec = str_replace(")", "')", $exec);
//echo '***'.$arrtest[$key][0][0] ;
//echo $exec;
//�Զ� including ���������ļ�

            preg_match("/\bmy_func_\w+/i",   $arrtest[$key][0][0], $my_func_file); // ��ȡ���������Ա�֮��including file ��my_func_emv(close,1) ��my_func_emv ���֡�
//          $my_func_file_name=dirname(__file__) . '\func\\'.$my_func_file[0].'.php';  // �˷������ļ��� б�� ��֪ windows �� linux �Ƿ���ݡ�
            
			$my_func_file_name=DISCUZ_ROOT.'./source/plugin/stock/func/'.$my_func_file[0].'.func.php';  //����ļ����� 

//echo '    $my_func_file name is:'.$my_func_file_name;

    
               if (file_exists($my_func_file_name)) 
			   { 
//			   	echo '  file in dir';
	include_once $my_func_file_name;		   	
				}else{
				echo ' undefined func() file not found!';
				return;
//                     δ���庯���Ĵ��������⡣ 
				}
				
				    
      
//					    echo gb("�Ǻ�������Ҫ�滻!�滻��Ϊ") . $exec . '<br>';
        eval("\$x=" . $exec . ";");
        } else {
//                      echo $key.gb('���Ǻ���') . $arrtest[$key][0] . '<br>';
// 						echo $key.gb('���Ǻ���') . $arrtest[$key][0][0] . '<br>';
        $exec = "not_a_func('" . $arrtest[$key][0][0] . "')";
        eval("\$x=" . $exec . ";");
        }
    }
}


?>