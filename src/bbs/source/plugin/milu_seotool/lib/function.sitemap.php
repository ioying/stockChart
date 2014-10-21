<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function update_sitemap($sitemap_set = ''){
	global $_G;
	if(!$sitemap_set) {	//计划任务调用的时候
		$sitemap_set = tool_common_get('sitemap');
		$sitemap_set['max_article_num'] = $sitemap_set['max_article_num'] ? $sitemap_set['max_article_num'] : 500;
		$sitemap_set['max_threads_num'] = $sitemap_set['max_threads_num'] ? $sitemap_set['max_threads_num'] : 500;
	}
	$sitemap_set['sitemap_type'] = dunserialize($sitemap_set['sitemap_type']);
	if(!function_exists('gzopen')) unset($sitemap_set['sitemap_type'][array_search('gz', $sitemap_set['sitemap_type'])]);
	$sitemap_data = array();
	$sitemap_data['catid']  = article_catid_data();
	$sitemap_data['fid'] = get_forum_data();
	$sitemap_data['thread'] = sitemap_article_data($sitemap_set['max_threads_num'], 0, 0);
	$sitemap_data['aritcle'] = sitemap_article_data($sitemap_set['max_article_num'], 0, 1);
	$charset = GBK ? 'gb2312' : 'UTF-8';
	$xml = "<?xml version=\"1.0\" encoding=\"$charset\"?>\n";
	$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"'."\r\n".'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"'."\r\n".'xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9'."\r\n".'http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">'."\r\n".'<!-- created with http://www.56php.com/ -->'."\r\n";
	$txt = $html = '';
	$url_count = 0;
	$xml_is_open = in_array('xml', (array)$sitemap_set['sitemap_type']);//xml
	$txt_is_open = in_array('txt',(array) $sitemap_set['sitemap_type']);//txt
	$gz_is_open = in_array('gz', (array)$sitemap_set['sitemap_type']);//gz
	$html_is_open = in_array('html', (array)$sitemap_set['sitemap_type']);//html
	
	foreach($sitemap_data as $k => $v){
		foreach($v as $k1 => $v1){
			$url_count++;
			//xml地图
			$xml .= xml_url_output($v1);
			
			//txt地图
			$txt .= $v1['url']."\r\n";
			
			//html地图
			$html .= '<tr><td class="lpage"><a href="'.$v1['url'].'" title="'.dhtmlspecialchars($v1['title']).'">'.$v1['title'].'</a></td><td class="lpage" >'.$v1['lastmod'].'</td></tr>'."\r\n";
		}
	}	
	$xml .= "</urlset>\n";
	
	$robots_str = @file_get_contents(DISCUZ_ROOT.'/robots.txt');
	//html地图
	if($html_is_open){
		$sitemap['title'] = stlang('sitemap').'-'.$_G['setting']['bbname'];
		$sitemap['url_count'] = $url_count;
		$sitemap['update_dateline'] = dgmdate($_G['timestamp']);
		$sitemap['show_url'] = $html;
		ob_start();
		include template('milu_seotool:sitemap_tpl');
		$sitemap_html = ob_get_contents();
		ob_end_clean () ;
		file_put_contents(DISCUZ_ROOT.'/sitemap.html', $sitemap_html);
		$robots_str .= !strexists($robots_str, 'sitemap.html') ? "\r\n".'Sitemap: '.$_G['siteurl'].'sitemap.html' : '';
	}else{
		@unlink(DISCUZ_ROOT.'/sitemap.html');
		$robots_str = str_replace("\r\n".'Sitemap: '.$_G['siteurl'].'sitemap.html', '', $robots_str);
	}
	
	//txt
	if($txt_is_open) {
		file_put_contents(DISCUZ_ROOT.'/sitemap.txt', $txt);
		$robots_str .= !strexists($robots_str, 'sitemap.txt') ? "\r\n".'Sitemap: '.$_G['siteurl'].'sitemap.txt' : '';
	}else{
		$robots_str = str_replace("\r\n".'Sitemap: '.$_G['siteurl'].'sitemap.txt', '', $robots_str);
		@unlink(DISCUZ_ROOT.'/sitemap.txt');
	}
	
	//xml
	if($xml_is_open) {
		file_put_contents(DISCUZ_ROOT.'/sitemap.xml', $xml);
		$robots_str .= !strexists($robots_str, 'sitemap.xml') ? "\r\n".'Sitemap: '.$_G['siteurl'].'sitemap.xml' : '';
	}else{
		@unlink(DISCUZ_ROOT.'/sitemap.xml');
		$robots_str = str_replace("\r\n".'Sitemap: '.$_G['siteurl'].'sitemap.xml', '', $robots_str);
	}
	
	//gz
	if($gz_is_open) {
		$robots_str .= !strexists($robots_str, 'sitemap.xml.gz') ? "\r\n".'Sitemap: '.$_G['siteurl'].'sitemap.xml.gz' : '';
		create_gzfile(DISCUZ_ROOT.'/sitemap.xml', $xml);
	}else{
		@unlink(DISCUZ_ROOT.'/sitemap.xml.gz');
		$robots_str = str_replace("\r\n".'Sitemap: '.$_G['siteurl'].'sitemap.xml.gz', '', $robots_str);
	}
	$set['sitemap_url_count'] = $url_count;
	$set['updateline'] = $_G['timestamp'];
	file_put_contents(DISCUZ_ROOT.'/robots.txt', $robots_str);
	return $set;
}

function article_catid_data(){
	global $_G;
	loadcache('portalcategory');
	$cat_arr = $_G['cache']['portalcategory'];
	$data = array();
	foreach($cat_arr as $k => $v){
		$priority = rand(1,10)/10;
		$data[] = array('title' => $v['catname'], 'url' => $v['caturl'], 'priority' => $priority, 'changefreq' => 'daily', 'lastmod' => date("Y-m-d"));
	}
	return $data;
}

function get_forum_data(){
	global $_G;
	loadcache('forums');
	$cat_arr = $_G['cache']['forums'];
	$data = array();
	foreach($cat_arr as $k => $v){
		$priority = rand(1,10)/10;
		$data[] = array('title' => $v['name'], 'url' => get_forum_url($v['fid']), 'priority' => $priority, 'changefreq' => 'daily', 'lastmod' => date("Y-m-d"));
	}
	return $data;
}


function create_gzfile($file, $text){
	if(!function_exists('gzopen') ) return FALSE;
	$gzfile = $file.'.gz';
	// Open the gz file (w9 is the highest compression)
	$fp = gzopen ($gzfile, 'w9');
	gzwrite ($fp, file_get_contents($file));
	gzclose($fp);
	return;
}
function get_forum_url($fid){
	global $_G;
	if(in_array('forum_forumdisplay', (array)$_G['setting']['rewritestatus'])) {
		$url = $_G['siteurl'].rewriteoutput('forum_forumdisplay', 1, '', $fid, 1, '', '');
	} else {
		$url = $_G['siteurl'].'forum.php?mod=forumdisplay&fid='.$fid;
	}
	return $url;
}

//$data_type 0论坛 1门户
function sitemap_article_data($max_num, $dateline = 0, $data_type = 0){
	$where_sql = $dateline > 0 ? " AND dateline>'$dateline'" : '';
	sload('F:included');
	$count = get_article_count($data_type, $where_sql);
	if(!$count) return FALSE;
	if($data_type == 1){//门户
		$query = DB::query("SELECT aid,title,dateline FROM ".DB::table('portal_article_title')." WHERE status='0' $where_sql  ORDER BY dateline DESC LIMIT $max_num");
	}else{
		$query = DB::query("SELECT tid as aid,subject as title,dateline FROM ".DB::table('forum_thread')." WHERE displayorder='0' $where_sql  ORDER BY dateline DESC LIMIT $max_num");
	}
	while($rs = DB::fetch($query)) {
		$priority = rand(1,10)/10;
		$data[] = array('title' => $rs['title'], 'url' => get_article_url($rs['aid'], $data_type), 'priority' => $priority, 'changefreq' => 'daily', 'lastmod' => date("Y-m-d", $rs['dateline']));
	}
	return $data;
}


function xml_url_output($info){
	$info['url'] = dhtmlspecialchars($info['url']);
	$xml = "<url>\n";
	$xml .= "<loc>$info[url]</loc>\n";
	$xml .= "<priority>$info[priority]</priority>\n";
	$xml .= "<lastmod>$info[lastmod]</lastmod>\n";
	$xml .= "<changefreq>$info[changefreq]</changefreq>\n";
	$xml .= "</url>\n";
	return $xml;
}
?>