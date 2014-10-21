<?php
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	class table_ychat_gift_categories extends discuz_table{
		public function __construct(){
			$this->table='ychat_gift_categories';
			$this->_pk='id';
			parent::__construct();
		}
		public function fetch_all()
		{
			$result=array();
			$result=DB::fetch_all("select * from %t order by id asc",array($this->table));
			return $result;
		}
		public function fetch_by_id($id)
		{
			if(!$id)
			{
				return null;
			}
			return DB::fetch_first("select * from %t where id=%d",array($this->table,$id));
		}
	}
?>