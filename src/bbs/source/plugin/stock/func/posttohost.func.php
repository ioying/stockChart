<?php

/**
 * 如何从一个php文件向另一个地址post数据，不用表单和隐藏的变量
 * $url 链接地址   $data 数组 目前只能是一维数组  二维数组报错 rawurlencode() expects parameter 1 to be string, array given
 * http://www.phpe.net/faq/71.shtml
 * @author Leo1119
 * @copyright 2009
 */

function posttohost($url, $data)
{

    $url = parse_url($url); //解析url
    if (!$url)
        return "couldn't parse url";
    if (!isset($url['port'])) {
        $url['port'] = "";
    }
    if (!isset($url['query'])) {
        $url['query'] = "";
    }

    $encoded = "";
    //echo $url,$data;
    //print_r($url);
    while (list($this_list_k, $this_list_v) = each($data)) {
        $encoded .= ($encoded ? "&" : "");
        $encoded .= rawurlencode($this_list_k) . "=" . rawurlencode($this_list_v);
    }

    $fp = fsockopen($url['host'], $url['port'] ? $url['port'] : 80);
    if (!$fp)
        return "Failed to open socket to $url[host]";

    fputs($fp, sprintf("POST %s%s%s HTTP/1.0\n", $url['path'], $url['query'] ? "?" :
        "", $url['query']));
    fputs($fp, "Host: $url[host]\n");
    fputs($fp, "Content-type: application/x-www-form-urlencoded\n");
    fputs($fp, "Content-length: " . strlen($encoded) . "\n");
    fputs($fp, "Connection: close\n\n");
    fputs($fp, "$encoded\n");

    $line = fgets($fp, 1024);
//    if (!eregi("^HTTP/1\.. 200", $line))
//echo $line;
//echo strpos($line, "200");
//	if (!preg_match("^HTTP/1\.. 200", $line))
	if (strpos($line,"200" )<1)
    return;

/* $subject = "abcdef";
$pattern = '/^def/';
preg_match($pattern, $subject, $matches, PREG_OFFSET_CAPTURE, 3);		
 */
		
    $results = "";
    $inheader = 1;
    while (!feof($fp)) {
        $line = fgets($fp, 4096);
        //fgets(file,length) lenth 为可选参数。指定需要读取的字节数。默认值是1024个字节
        if ($inheader && ($line == "\n" || $line == "\r\n")) {
            $inheader = 0;
        } elseif (!$inheader) {
            $results .= $line;
        }
    }
    fclose($fp);

    return $results;
}




?>