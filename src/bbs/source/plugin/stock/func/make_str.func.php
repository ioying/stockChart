<?php

/**
 * @author Leo1119
 * @copyright 2009
 */


function make_str($make_str) //�ַ���������

{
    global $i, $arrtest, $key; //
    $make_str = '    ' . $make_str . '    '; // �����˼ӿո� Ϊ�Ժ����� ==!
//    echo gb('<br />���������ַ���Ϊ:' ). $make_str; //��������ʾ�����Ϣ
    $testregex="/[^\+\-\/\(\,\*\%\^\;\s\)\:]+/i"; // ƥ������ �� +��*/�ȣ���ƥ�������
    //$testregex="/(?<=[\b\+\-\/\(\,\*\%\^\;\s])\w+(?=[\+\-\/\)\,\*\%\^\;\b\s])|(\+|\-)?([1-9]\d+)?[0-9]+(\.[0-9]+)/i";
    // ԭƥ�乫ʽ�� ���ǲ���ƥ�人�֣�
    preg_match_all($testregex,
        $make_str, $newstr6); //ƥ�����в�����
    //       print_r($newstr6);
    foreach ($newstr6[0] as $eachkey) //�����ж�

    {
        $eachkey = trim($eachkey);
        //                 echo '<br>' . $eachkey . '<br>';
        if (!array_key_exists($eachkey, $arrtest)) {
            if (!is_numeric(trim($eachkey))) {
      //                       echo gb('����' . $eachkey . 'û�ж���,��ʱ�顰0������<br>');
                $make_str = preg_replace("/((?<=[\b\+\-\/\(\,\*\%\^\;\s])$eachkey(?=[\+\-\/\)\,\*\%\^\;\b\s]))/i",
                    "0", $make_str);
                return $make_str;
            } else {
       //                         		echo	gb('*'.$eachkey.'������<br>');
            }
        } else {
       //                              echo gb($eachkey . '���Ѿ�����ı�������<br>');
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
?>