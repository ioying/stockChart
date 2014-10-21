<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
define('DEBUG_MODE', 0);
error_reporting(0);
if(!defined('DISCUZ_VERSION')) require_once(DISCUZ_ROOT.'/source/discuz_version.php');
class plugin_milu_seotool {
	
	var $plugin_set;
	var $vip;
	var $is_robot;
	function global_footer() {
		global $_G;
		
		$this->_add_spider_log();//监控爬虫
		
		loadcache('milu_seotool_setting');
		$setting = $_G['cache']['milu_seotool_setting'];
		if($setting['included']['is_auto_check'] != 1 && $setting['included']['is_auto_ping'] != 1 && $setting['sitemap']['is_auto'] !=1 && $setting['keyword']['is_auto_rank'] != 1) return;
		return '<img style="display:none;" width="0" height="0" src="'.$_G['siteurl'].'plugin.php?id=milu_seotool:sitemap&tpl=no&myac=milu_seotool_cron&inajax=1" />';
	}
	
	function _ini(){
		global $_G;
		if($this->plugin_set) return;
		require_once(DISCUZ_ROOT.'source/plugin/milu_seotool/config.inc.php');
		$this->plugin_set = tool_common_get();
		$this->is_robot = checkrobot();
		$this->vip = strexists(strtolower($_G['setting']['plugins']['version']['milu_seotool']), 'vip') ? TRUE : FALSE;
	}
	
	function _check_open($space, $name){
		$this->_ini();
		return $this->plugin_set[$space][$name];
	}
	
	//监控爬虫
	function _add_spider_log(){
		global $_G,$navtitle;
		if($this->_check_open('spider', 'is_open_spider') !=1 ) return;
		sload('F:spider');
		spider_add_log($navtitle);
	}
	//帖子标签添加进关键词
	function _tag_add_keyword($metakeywords, $thread_info){
		if($this->_check_open('keyword', 'tag_add_keyword') !=1 ) return $metakeywords;
		$tags_arr = $thread_info['tags'];
		foreach($tags_arr as $k => $v){
			$tags_str .= $v[1].',';
		}
		$metakeywords = $tags_str.$metakeywords;
		return $metakeywords;
	}
	
	
	//文章页监控爬虫 0 论坛 1 门户
	function _included_spider_log($data_id, $data_type = 0){
		global $_G;
		$spider_type_arr = dunserialize($this->plugin_set['included']['spider_type']);
		if(!$spider_type_arr || $data_id < 1) return;
		$spider_type = strtolower($_SERVER['HTTP_USER_AGENT']);
		$spider_name = '';
		if (strpos($spider_type, 'baiduspider') !== false){//百度
			$spider_name = 'baidu';
		}else if(strpos($spider_type, 'googlebot') !== false){//谷歌
			$spider_name = 'google';
		}else{
			return;
		}
		$info = DB::fetch_first("SELECT id,baidu_spider_count,google_spider_count FROM ".DB::table('milu_seotool_included')." WHERE data_type='$data_type' AND data_id='$data_id'");
		$check = $info ? 1 : 0;
		$setarr[$spider_name.'_spider_last'] = $_G['timestamp'];
		$info[$spider_name.'_spider_count'] = $info[$spider_name.'_spider_count'] ? $info[$spider_name.'_spider_count'] : 0;
		$setarr[$spider_name.'_spider_count'] = $info[$spider_name.'_spider_count'] + 1;
		if($check){
			DB::update("milu_seotool_included", $setarr, array("id" => $info['id']));
		}else{
			$setarr['data_id'] = $data_id;
			$setarr['data_type'] = $data_type;
			$setarr[$spider_name.'_spider_count'] = 1;
			DB::insert('milu_seotool_included', $setarr, TRUE);
		}
	}
	//帖子seo
	function _thread_seo($postlist, $navtitle){
		global $_G;
		$return_data = array($postlist, $navtitle);
		$seo_set = $this->plugin_set['article_seo'];
		if($seo_set['is_open'] != 1) return $return_data;
		$seo_set['open_type'] = unserialize($seo_set['open_type']);
		$seo_set['open_forum'] = unserialize($seo_set['open_forum']);
		if(!in_array(2, $seo_set['open_type'])) return $return_data;
		if(!in_array($_G['fid'], $seo_set['open_forum'])) return $return_data;
		
		$postlist = $this->_thread_word_replace($postlist);
		$return_data = array($postlist, $navtitle);
		
		if($seo_set['is_open_seo_push'] != 1) return $return_data;
		
		$allow_uid_arr = st_format_wrap($seo_set['view_seo_uid'], '|');
		//开启了只对搜索引擎， 判断不是搜索引擎，也不是允许的uid就不执行下去
		if($seo_set['push_open_mode'] == 1 && !checkrobot() && !in_array($_G['uid'], $allow_uid_arr)) return $return_data;
		
		$seo_set['push_content_body_arr'] = st_format_wrap($seo_set['push_content_body']);
		$seo_set['push_reply_body_arr'] = st_format_wrap($seo_set['push_reply_body']);
		foreach($postlist as $pid => $post) {
			if($post['first'] == 1){
				$seo_arr = $this->_article_seo_output(array('title' => $post['subject'], 'content' => $post['message']), 1);
				$postlist[$pid]['message'] = $seo_arr['content'];
				$short_title = cutstr($seo_arr['title'], 52);
				$navtitle = str_replace($post['subject'], $seo_arr['title'], $navtitle);
				$_G['forum_thread']['short_subject'] = str_replace($_G['forum_thread']['short_subject'], $short_title, $_G['forum_thread']['short_subject']);
				$postlist[$pid]['subject'] = $_G['thread']['subject'] = $seo_arr['title'];
			}else{
				$seo_arr = $this->_article_seo_output(array('reply' => $post['message']));
				$postlist[$pid]['message'] = $seo_arr['reply'];
				
			}
			
			
			if(($post['first'] == 1 && $seo_set['push_content_body_arr']) || ($post['first'] != 1 && $seo_set['push_reply_body_arr']) ) $postlist[$pid]['message'] = preg_replace("/<br \/>|<br>/e", "\$this->_jammer(\$post['first'], 1)", $postlist[$pid]['message']);
		}
		return array($postlist, $navtitle);
	}
	
	
	function _thread_word_replace($postlist){
		//同义词
		foreach($postlist as $pid => $post){
			list($post['subject'], $post['message']) = $this->_article_word_replace(array($post['subject'], $post['message']));
			$postlist[$pid] = $post;
		}
		return $postlist;
	}
	
	//门户文章seo
	function _portal_seo($content, $article, $navtitle){
		global $_G;
		$return_data = array($content, $article, $navtitle);
		$seo_set = $this->plugin_set['article_seo'];
		if(!$this->vip || $seo_set['is_open'] != 1) return $return_data;
		$seo_set['open_type'] = unserialize($seo_set['open_type']);
		if(!in_array(1, $seo_set['open_type'])) return $return_data;
		$allow_uid_arr = st_format_wrap($seo_set['view_seo_uid'], '|');
		
		//同义词
		list($article['title'], $content['content'], $navtitle) = $this->_article_word_replace(array($article['title'], $content['content'], $navtitle));
		$return_data = array($content, $article, $navtitle);
		
		if($seo_set['is_open_seo_push'] != 1) return $return_data;
		
		if($seo_set['push_open_mode'] == 1 && !checkrobot() && !in_array($_G['uid'], $allow_uid_arr)) return $return_data;//只对搜索引擎
		$seo_arr = $this->_article_seo_output(array('content' => $content['content'], 'title' => $article['title']));
		$content['content'] = $seo_arr['content'];
		$navtitle = str_replace($article['title'], $seo_arr['title'], $navtitle);
		$article['title'] = $seo_arr['title'];
		return array($content, $article, $navtitle);
	}
	
	function _blog_seo($blog, $navtitle){
		global $_G;
		$return_data = array($blog, $navtitle);
		$seo_set = $this->plugin_set['article_seo'];
		$old_subject = $blog['subject'];
		if(!$this->vip || $seo_set['is_open'] != 1) return $return_data;
		$seo_set['open_type'] = unserialize($seo_set['open_type']);
		if(!in_array(3, $seo_set['open_type'])) return $return_data;
		
		$allow_uid_arr = st_format_wrap($seo_set['view_seo_uid'], '|');
		$is_robot = checkrobot();
		
		//同义词
		list($blog['subject'], $blog['message'], $navtitle) = $this->_article_word_replace(array($blog['subject'], $blog['message'], $navtitle));
		$return_data = array($blog, $navtitle);
		
		if($seo_set['is_open_seo_push'] != 1) return $return_data;
		
		if($seo_set['push_open_mode'] == 1 && !$this->is_robot && !in_array($_G['uid'], $allow_uid_arr)) return $return_data;//只对搜索引擎
		
		$seo_arr = $this->_article_seo_output(array('title' => $blog['subject'], 'content' => $blog['message']));
		$blog['message'] = $seo_arr['content'];
		$navtitle = str_replace($blog['subject'], $seo_arr['title'], $navtitle);
		$blog['subject'] = $seo_arr['title'];
		return array($blog, $navtitle);
	}
	
	
	//同义词替换
	function _article_word_replace($data){
		if(!$this->vip) return $data;
		global $_G;
		sload('F:seo');
		$seo_set = $this->plugin_set['article_seo'];
		if($seo_set['is_open_word'] !=1 ) return $data;
		$allow_uid_arr = st_format_wrap($seo_set['view_seo_uid'], '|');
		if($seo_set['word_open_mode'] == 1 && !$this->is_robot && !in_array($_G['uid'], $allow_uid_arr)) return $data;
		return miluseo_word_replace($data);
	}
	
	function _article_seo_output($data, $bbs = 0){
		sload('F:seo');
		$seo_arr = miluseo_replace($data, $bbs);
		$arr['content'] = $seo_arr['content'];
		$arr['title'] = $seo_arr['title'];
		$arr['reply'] = $seo_arr['reply'];
		return $arr;
	}
	
	function  _jammer($first = 1, $bbs = 1) {
		$seo_set = $this->plugin_set['article_seo'];
	 	$rand_arr = $first == 1 ? $seo_set['push_content_body_arr'] : $seo_set['push_reply_body_arr'];
		$randomstr = $rand_arr[array_rand($rand_arr)];
		return mt_rand(0, 1) && $bbs==1 ? '<font class="jammer">'.$randomstr.'</font>'."<br />" :
		 "<br />".'<span style="display:none">'.$randomstr.'</span>';
	}
	
	function _seo_info_output($data_id, $data_type = 0){
		global $_G;
		if(!$data_id || $this->is_robot) return;
		$included_set = $this->plugin_set['included'];
		if($included_set['is_show'] == 2) return;
		if($included_set['view_user_type'] == 1){//用户组
			$view_user_group = unserialize($included_set['view_user_group']);
			if(!$view_user_group || !in_array($_G['groupid'], $view_user_group)) return;
		}else{//自定义用户
			$allow_uid_arr = st_format_wrap($included_set['view_user'], '|');
			if(!$allow_uid_arr || !in_array($_G['uid'], $allow_uid_arr)) return;
		}
		sload('F:included');
		$str = '<div style="background: #E5EDF2;margin: 0px auto; width:960px;">';
		$info = DB::fetch_first("SELECT * FROM ".DB::table('milu_seotool_included')." WHERE data_type='$data_type' AND data_id='$data_id'");
		if(!$info){
			$str .= '<div class="notice">'.stlang('no_seo_data').'</div>';
		}else{
			$aritcle_url = get_article_url($data_id, $data_type);
			$aritcle_url_encode = urlencode($aritcle_url);
			$baidu_query_url = 'http://www.baidu.com/s?wd='.$aritcle_url_encode;
			$google_query_url = 'http://www.google.com.hk/search?q='.$aritcle_url_encode;
			$show_arr = array();
			$show_arr['baidu']['included'] = $info['baidu_included'] ? '<a href="'.$baidu_query_url.'" target="_blank">'.dgmdate($info['baidu_included'], 'Y-m-d').'</a>' : '-';
			$show_arr['google']['included'] = $info['google_included'] ? '<a href="'.$google_query_url.'" target="_blank">'.dgmdate($info['google_included'], 'Y-m-d').'</a>' : '-';
			$show_arr['baidu']['spider_count'] = $info['baidu_spider_count'];
			$show_arr['google']['spider_count'] = $info['google_spider_count'];
			$show_arr['baidu']['last_spider'] = $info['baidu_spider_last'] ? dgmdate($info['baidu_spider_last'], 'u') : '-';
			$show_arr['google']['last_spider'] = $info['google_spider_last'] ? dgmdate($info['google_spider_last'], 'u') : '-';
			$show_arr['baidu']['ping'] = $info['baidu_ping'] ? dgmdate($info['baidu_ping'], 'u') : '-';
			$show_arr['google']['ping'] = $info['google_ping'] ? dgmdate($info['google_ping'], 'u') : '-';
			foreach($show_arr as $k => $v){
				$str .= '<div class="notice">'.stlang('article_seo_info_output', array('a' => stlang($k), 'b' => $v['included'], 'c' => $v['spider_count'], 'd' => $v['last_spider'], 'e' => $v['ping'])).'</div>';
			}
		}
		$str .= '</div>';
		return $str;
	}
	
	function _portal_seo_info_output($aid){
		$str = $this->_seo_info_output($aid, 1);
		if(!$str) return;
		$script = "\n<script charset=\"".CHARSET."\" type=\"text/javascript\">
		var div = document.createElement('div');
		div.style.display = 'block';
		div.style.margin = '0 auto';
		div.style.width = '960';
		div.innerHTML = '$str';
		$('hd').appendChild(div);</script>\n";
		return $script;
	}
	
}

class plugin_milu_seotool_forum extends plugin_milu_seotool {

	function viewthread_bottom_output(){
		global $metakeywords,$postlist,$navtitle,$_G;
		$this->_ini();
		$thread_info = reset($postlist);
		$metakeywords = $this->_tag_add_keyword($metakeywords, $thread_info);//
		$this->_included_spider_log($thread_info['tid'], 0);
		$seo_data = $this->_thread_seo($postlist, $navtitle);
		if($seo_data) list($postlist, $navtitle) = $seo_data;
	}
	
	function viewthread_top_output(){
		global $_G;
		$this->_ini();
		return $this->_seo_info_output($_G['tid']);
	}
}

class plugin_milu_seotool_portal extends plugin_milu_seotool {
	

	function view_article_content_output(){
		global $_G,$content,$article,$navtitle;
		$this->_ini();
		$this->_included_spider_log($article['aid'], 1);
		$seo_data = $this->_portal_seo($content, $article, $navtitle);
		if($seo_data) list($content, $article, $navtitle) = $seo_data;
		$article['summary'] .= $this->_portal_seo_info_output($article['aid']);
	}

}


class plugin_milu_seotool_home extends plugin_milu_seotool {
	
	function plugin_milu_seotool_home(){
		
	}
	
	function space_blog_title_output(){
		global $_G,$blog,$navtitle;
		$this->_ini();
		$seo_data = $this->_blog_seo($blog, $navtitle);
		if($seo_data) list($blog, $navtitle) = $seo_data;
	}

}	




?>