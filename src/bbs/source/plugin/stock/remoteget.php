<?php
/* remote get file
http://ichart.yahoo.com/table.csv?s=000001.ss&a=0&b=1&c=1990&d=0&e=31&f=2014&g=d&ignore=.csv


g=d 日 m 月 w 周
*/

$url='http://ichart.yahoo.com/table.csv?s=000001.ss&a=0&b=1&c=1990&d=0&e=31&f=2014&g=d&ignore=.csv'
$data=file_get_contents($url,true);


echo $data;

?>