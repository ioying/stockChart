<?php
$conn = MySQL_connect($host_addr, $db_user, $db_pwd) or die("Could not connect: " .
    mysql_error());
MySQL_select_db($db_name);
$exe = "SELECT * FROM `daily` ORDER BY `d_date` ASC  LIMIT 0 , " . $select_cycle;
$result = MySQL_query($exe, $conn); //结束
//echo gb('<br />计算结果<br />');

//    $first_douhao = ''; // 第一个逗号
    for ($i = 0; $i < mysql_num_rows($result); $i++) {

        $row = mysql_fetch_array($result, MYSQL_ASSOC);
        $arrtest['open'][] = $row['d_open'];
        $arrtest['close'][] = $row['d_close'];
        $arrtest['high'][] = $row['d_high'];
        $arrtest['low'][] = $row['d_low'];
        $arrtest['vol'][] = $row['d_vol'];
        $arrtest['datetime'][] = $row['d_date'];
        //array(3.75,3.76,3.69,3.72),
//        $tem = $first_douhao . "array(" . $row['d_open'] . ',' . $row['d_high'] . ',' .
//            $row['d_low'] . ',' . $row['d_close'] . ")";
//        $first_douhao = ','; // echo $tem;
        // Write $somecontent to our opened file.


        //绘图数组赋值   啥用？ 
     /*   $k[$i][] = $row['d_open'];
        $k[$i][] = $row['d_high'];
        $k[$i][] = $row['d_low'];
        $k[$i][] = $row['d_close'];
        $k[$i][] = $row['d_vol'];
        $vol[] = $row['d_vol'];   */
    }
	?>