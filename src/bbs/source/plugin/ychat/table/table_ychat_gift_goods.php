<?php
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	class table_ychat_gift_goods extends discuz_table{
		public function __construct(){
			$this->table='ychat_gift_goods';
			$this->_pk='id';
			parent::__construct();
		}
		public function fetch_all_by_cid($cid)
		{
			$result=array();
			$result=DB::fetch_all("select * from %t where cid=%d order by id asc",array($this->table,$cid));
			return $result;
		}
		public function fetch_all($start=0,$limit=0)
		{
			$result=array();
			$result=DB::fetch_all("select * from %t order by cid asc %i",array($this->table,DB::limit($start,$limit)));
			return $result;
		}
		public function fetch_count($cid)
		{
			$result=DB::result_first("select count(*) from %t ",array($this->table));
			return $result;
		}
		public function fetch_all_by_id($id)
		{
			$result=DB::fetch_first("select * from %t where id=%d",array($this->table,$id));
			return $result;
		}
	}
?>