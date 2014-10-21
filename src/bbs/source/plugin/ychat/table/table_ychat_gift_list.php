<?php
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	class table_ychat_gift_list extends discuz_table{
		public function __construct(){
			$this->table='ychat_gift_list';
			$this->_pk='id';
			parent::__construct();
		}
		public function fetch_by_gift_star($gid,$starttime,$endtime)
		{
			if(!$gid || !$starttime || !$endtime)
			{
				return null;
			}
			$result=DB::fetch_first("select sum(num) AS cc,rid from ".DB::table("ychat_gift_list")." where gid=".$gid." and dateline>".$starttime." and dateline<".$endtime." 
			group by rid 
			order by cc desc 
			limit 0,1");
			return $result;
		}
		public function fetch_by_rank($start=0,$limit=0,$type='rid',$gongshi='num')
		{
			$result=array();
			$result=DB::fetch_all("select sum(".$gongshi.") AS gnum,".$type." from ".DB::table('ychat_gift_list')." group by ".$type." order by gnum desc ".DB::limit($start,$limit));
			return $result;
		}
	}
?>