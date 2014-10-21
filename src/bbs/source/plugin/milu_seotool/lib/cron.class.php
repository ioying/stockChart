<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id:$
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once(DISCUZ_ROOT.'source/plugin/milu_seotool/config.inc.php');
class milu_seotool_cron{
	
	//��ʱ��ѯ��¼
	public static function included_check(){
		global $_G;
		$timestamp = TIMESTAMP;
		$processname ='INCLUDED_CRON_CHECK';
		if(discuz_process::islocked($processname, 5*60)) {
			return false;
		}
		sload('F:included');
		$included_set = tool_common_get('included');
		if($included_set['is_auto_check'] != 1) return;
		@set_time_limit(1000);
		@ignore_user_abort(TRUE);
		$check_time = $included_set['auto_check_time'] ? intval($included_set['auto_check_time']) : 12;
		$aoto_check_day = $included_set['aoto_check_day'] ? intval($included_set['aoto_check_day']) : 3;
		$check_per_num = $included_set['check_per_num'] ? intval($included_set['check_per_num']) : 50;
		$included_set['included_type'] = dunserialize($included_set['included_type']);
		
		//ִ��
		$dateline = TIMESTAMP - $aoto_check_day*3600*24;
		
		$included_baidu_flag = in_array(1, $included_set['included_type']);
		$included_google_flag = in_array(2, $included_set['included_type']);
		
		//�Ż�
		if(VIP){
			$ids_arr = self::new_article($check_per_num, $dateline, 1);
			if($included_baidu_flag) $baidu_ids_arr = filter_article_data($ids_arr, 1, 1);//��Ҫ�ٶȲ�ѯ������
			batch_run($baidu_ids_arr, 1, 1);
			if($included_google_flag) $google_ids_arr = filter_article_data($ids_arr, 2, 1);//��Ҫ�ȸ��ѯ������	
			batch_run($google_ids_arr, 2, 1);	
		}
		
		//��̳
		$ids_arr = self::new_article($check_per_num, $dateline, 0);
		if($included_baidu_flag) $baidu_ids_arr = filter_article_data($ids_arr, 1, 0);//��Ҫ�ٶȲ�ѯ������
		batch_run($baidu_ids_arr, 1, 0);
		if($included_google_flag) $google_ids_arr = filter_article_data($ids_arr, 2, 0);//��Ҫ�ȸ��ѯ������
		batch_run($google_ids_arr, 2, 0);	
		
		
		tool_common_set('milu_seotool_cron', array('included_check' => TIMESTAMP + $check_time*3600 ));//�ɹ����У�ʱ�䰴��������
		discuz_process::unlock($processname);
		return true;
	}
	
	
	
	//��ʱping
	public static function ping_check(){
		global $_G;
		$timestamp = TIMESTAMP;
		$processname ='PING_CRON_CHECK';
		if(discuz_process::islocked($processname, 5*60)) {
			return false;
		}
		sload('F:included');
		$included_set = tool_common_get('included');
		if($included_set['is_auto_ping'] != 1) return;
		@set_time_limit(1000);
		@ignore_user_abort(TRUE);
		
		$check_time = $included_set['auto_ping_time'] ? intval($included_set['auto_ping_time']) : 30;
		$check_per_num = $included_set['ping_per_num'] ? intval($included_set['ping_per_num']) : 50;
		$included_set['ping_type'] = dunserialize($included_set['ping_type']);
		//ִ��
		$dateline = TIMESTAMP - 24 * 3600;//ֻ���һ��֮�ڷ���δping�����¡�
		$ping_baidu_flag = in_array(1, $included_set['ping_type']);
		$ping_google_flag = in_array(2, $included_set['ping_type']);
		
		//�Ż�
		if(VIP){
			$ids_arr = self::new_article($check_per_num, $dateline, 1);
			if($ping_baidu_flag) $baidu_ids_arr = filter_article_data($ids_arr, 3, 1);//�ٶ�ping
			batch_run($baidu_ids_arr, 3, 1);
			if($ping_google_flag) $google_ids_arr = filter_article_data($ids_arr, 4, 1);//�ȸ�ping	
			batch_run($google_ids_arr, 4, 1);
		}
		//��̳
		
		$ids_arr = self::new_article($check_per_num, $dateline, 0);
		if($ping_baidu_flag) $baidu_ids_arr = filter_article_data($ids_arr, 3, 0);//�ٶ�ping
		batch_run($baidu_ids_arr, 3, 0);
		if($ping_google_flag) $google_ids_arr = filter_article_data($ids_arr, 4, 0);//�ȸ�ping	
		batch_run($google_ids_arr, 4, 0);	
		
		
		tool_common_set('milu_seotool_cron', array('ping_check' => TIMESTAMP + $check_time*60) );
		discuz_process::unlock($processname);
		return true;
	}
	
	//��ʱ�������
	public static function keyword_rank_check(){
		global $_G;
		sload('F:keyword');
		$timestamp = TIMESTAMP;
		$processname ='KEYWORD_RANK_CRON_CHECK';
		if(discuz_process::islocked($processname, 5*60)) {
			return false;
		}
		
		$keyword_set = tool_common_get('keyword');
		if($keyword_set['is_auto_rank'] != 1) return;
		@set_time_limit(1000);
		@ignore_user_abort(TRUE);
		
		$check_time = 15 * 3600;//ÿ��15��Сʱ����һ��
		//ִ��
		$cache_keyword_data = $keyword_set['keyword_data'];
		if($cache_keyword_data){
			foreach($cache_keyword_data as $k => $v){
				get_rank_data($k);
			}
		}else{
			$query = DB::query("SELECT name FROM ".DB::table('milu_seotool_keyword'));
			while($rs = DB::fetch($query)) {
				get_rank_data($rs['name']);
			}
		}
		tool_common_set('milu_seotool_cron', array('keyword_rank_check' => TIMESTAMP + $check_time));
		discuz_process::unlock($processname);
		return true;
	}
	
	
	//��վ��ͼ����
	public static function sitemap_maker(){
		global $_G;
		sload('F:sitemap');
		$timestamp = TIMESTAMP;
		$processname ='SITEMAP_CRON_CHECK';
		if(discuz_process::islocked($processname, 5*60)) {
			return false;
		}
		$sitemap_set = tool_common_get('sitemap');
		if($sitemap_set['is_auto'] != 1) return;
		@set_time_limit(1000);
		@ignore_user_abort(TRUE);
		$sitemap_set['auto_time'] = $sitemap_set['auto_time'] ? $sitemap_set['auto_time'] : 1;
		$check_time = $sitemap_set['auto_time'] * 3600*24;	
		$update_info = update_sitemap($sitemap_set);
		save_syscache('milu_seotool_sitemap', $update_info);
		tool_common_set('milu_seotool_cron', array('sitemap_maker' => TIMESTAMP + $check_time));
		discuz_process::unlock($processname);
		return true;
	}
	
	
	public static function new_article($max_num, $dateline, $data_type = 0){
		$where_sql = " AND dateline>'$dateline'";
		$count = get_article_count($data_type, $where_sql);
		if(!$count) return FALSE;
		if($data_type == 1){//�Ż�
			$query = DB::query("SELECT aid,dateline FROM ".DB::table('portal_article_title')." WHERE status='0' $where_sql  ORDER BY dateline DESC LIMIT $max_num");
		}else{
			$query = DB::query("SELECT tid as aid,dateline FROM ".DB::table('forum_thread')." WHERE displayorder='0' $where_sql  ORDER BY dateline DESC LIMIT $max_num");
		}
		while($rs = DB::fetch($query)) {
			$ids_arr[] = $rs['aid'];
		}
		return $ids_arr;
	}
	


}

?>