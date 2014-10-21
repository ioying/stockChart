<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
loadcache('plugin');
if(!defined('DEBUG_MODE')) define('DEBUG_MODE', $_G['cache']['plugin']['milu_seotool']['show_error']);
if(DEBUG_MODE){
	ini_set("display_errors", "On");
	error_reporting(E_ALL);
}
if($_GET['inajax']) ob_start();
ob_implicit_flush();
if($_GET['inajax']) ob_end_flush();
define('GBK', strtoupper(CHARSET) == 'GBK');
define('PLUGIN_DIR', DISCUZ_ROOT.'source/plugin/milu_seotool');
define('PLUGIN_CACHE', PLUGIN_DIR.'/data/cache');
define('PLUGIN_URL', $_G['siteurl'].'source/plugin/milu_seotool/');
define('PLUGIN_PATH', DISCUZ_ROOT.'source/plugin/milu_seotool');
define('WRAP', PHP_EOL);
define('GET_URL', 'http://www.56php.com/');

//爬虫
$milu_seotool_config = array(
	'spider_type_arr' => array('googlebot' => lang('plugin/milu_seotool', 'google'), 'baiduspider' => lang('plugin/milu_seotool', 'baidu'), 'msnbot' => 'MSN','slurp' => 'Yahoo', 'sohu-search' => lang('plugin/milu_seotool', 'sohu'), 'lycos' => 'lycos','robozilla' => 'Robozilla', 'sosospider' => lang('plugin/milu_seotool', 'soso'), 'sogou' => lang('plugin/milu_seotool', 'sogou'), '360spider' => '360', 'bingbot' => lang('plugin/milu_seotool', 'bing')),//spider统一小写
	
	//数据库保存用数字比较省事
	'spider_id_arr' => array('googlebot' => 1,'baiduspider' => '2', 'msnbot' => '3','slurp' => '4', 'sohu-search' => '5','lycos' => '6','robozilla' => '7', 'sosospider' => '8','sogou' => '9', '360spider' => 10, 'bingbot' => 11), 
	
	//爬行区域分类
	'spider_group_rules' => array(
		1 => array(
			'name' => lang('plugin/milu_seotool', 'bbs'),
			'rules' => array('basescript' => 'forum'),
			'child' => array(
				1 => array(
					'name' => lang('plugin/milu_seotool', 'index_'),
					'rules' => array(),
				),
				2 => array(
					'name' => lang('plugin/milu_seotool', 'thread_list'),
					'rules' => array('mod' => 'forumdisplay', 'fid' => TRUE),
				),
				3 => array(
					'name' => lang('plugin/milu_seotool', 'thread_detail'),
					'rules' => array('mod' => 'viewthread', 'tid' => TRUE),
				),	
			)
		),
		2 => array(
			'name' => lang('plugin/milu_seotool', 'portal'),
			'rules' => array('basescript' => 'portal'),
			'child' => array(
				1 => array(
					'name' => lang('plugin/milu_seotool', 'index_'),
					'rules' => array(),
				),
				2 => array(
					'name' => lang('plugin/milu_seotool', 'article_list'),
					'rules' => array('mod' => 'list', 'gp_catid' => TRUE),
				),
				3 => array(
					'name' => lang('plugin/milu_seotool', 'article_detail'),
					'rules' => array('mod' => 'view', 'gp_aid' => TRUE),
				),	
			)
		),
		3 => array(
			'name' => lang('plugin/milu_seotool', 'blog_'),
			'rules' => array('basescript' => 'home'),
			'child' => array(
				1 => array(
					'name' => lang('plugin/milu_seotool', 'index_'),
					'rules' => array(),
				),
				2 => array(
					'name' => lang('plugin/milu_seotool', 'dongtai'),
					'rules' => array('mod' => 'space', 'gp_do' => 'home'),
				),
				3 => array(
					'name' =>  lang('plugin/milu_seotool', '_record'),
					'rules' => array('mod' => 'space', 'gp_do' => 'doing'),
				),
				4 => array(
					'name' => lang('plugin/milu_seotool', 'rizhi_'),
					'rules' => array('mod' => 'space', 'gp_do' => 'blog'),
				),	
				5 => array(
					'name' => lang('plugin/milu_seotool', 'album'),
					'rules' => array('mod' => 'space', 'gp_do' => 'album'),
				),	
				6 => array(
					'name' => lang('plugin/milu_seotool', '_thread'),
					'rules' => array('mod' => 'space', 'gp_do' => 'thread'),
				),	
				7 => array(
					'name' => lang('plugin/milu_seotool', 'share'),
					'rules' => array('mod' => 'space', 'gp_do' => 'share'),
				),	
				8 => array(
					'name' => lang('plugin/milu_seotool', 'friend'),
					'rules' => array('mod' => 'space', 'gp_do' => 'friend'),
				),	
				9 => array(
					'name' => lang('plugin/milu_seotool', 'wall_'),
					'rules' => array('mod' => 'space', 'gp_do' => 'wall'),
				),	
				10 => array(
					'name' => lang('plugin/milu_seotool', 'profile'),
					'rules' => array('mod' => 'space', 'gp_do' => 'profile'),
				),
				11 => array(
					'name' => lang('plugin/milu_seotool', 'blog_index'),
					'rules' => array('mod' => 'space', 'gp_uid' => TRUE, 'gp_view' => 'admin'),
				),		
			)
		),

	),
);


loadcache('milu_seotool');
if( (!$pluin_info = $_G['cache']['milu_seotool'] ) || ( $_G['cache']['milu_seotool']['version'] != $_G['setting']['plugins']['version']['milu_seotool'] ) || $milu_seotool_config != $_G['cache']['milu_seotool']['config']){
	$pluin_info = DB::fetch_first("SELECT * FROM ".DB::table('common_plugin')." WHERE identifier='milu_seotool'");
	$pluin_info['config'] = $milu_seotool_config;
	save_syscache('milu_seotool', $pluin_info);
}
define('PLUGIN_ID', $pluin_info['pluginid']);
define('PLUGIN_VERSION', $pluin_info['version']);//版本号
define('PLUGIN_GO', 'action=plugins&operation=config&do='.PLUGIN_ID.'&identifier=milu_seotool&pmod=');

define('PLUGIN_CACHE_SIZE', 25);//缓冲区最大空间 单位MB 超过指定大小将全部清空缓存
define('PLUGIN_ENABLE_CACHE', FALSE);//开启缓存？ TRUE

if(!defined('DISCUZ_VERSION')) require_once(DISCUZ_ROOT.'/source/discuz_version.php');
require_once(PLUGIN_DIR.'/version.php');
require_once(PLUGIN_DIR.'/lib/function.global.php');


define('SEO_WORD_FILE', PLUGIN_DIR.'/data/word.dat');//seo词库文件


?>