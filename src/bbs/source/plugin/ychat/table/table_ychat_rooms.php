<?php
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	class table_ychat_rooms extends discuz_table{
		public function __construct(){
			$this->table='ychat_rooms';
			$this->_pk='roomID';
			parent::__construct();
		}

		public function fetch_all($type=1,$start=0,$limit=0)
		{
			$result=array();
			$result=DB::fetch_all("select * from ".DB::table($this->table)." ".DB::limit($start,$limit));
			return $result;
		}
		
		public function fetch_all_by_roomID($roomID)
		{
			if(!$roomID)
			{
				return null;
			}
			$result=DB::fetch_first("select * from %t where roomID = %d",array($this->table,$roomID));
			return $result;
		}

		public function update_by_id($id,$data)
		{
			if(!$id && empty($data) && !is_array($data)) {
				return null;
			}
			DB::update($this->_table, $data, DB::field($this->_pk, $id));
		}

		public function fetch_by_crole_count($categoryID)
		{
			if(!$categoryID)
			{
				return null;
			}
			$result=DB::result_first("SELECT sum(cnum) FROM %t where categoryID=%d ", array($this->_table,$categoryID));
			return $result;
		}
		
		public function fetch_all_by_order_type($ordertype='top',$start=0,$limit=0)
		{
			$result=array();
			$result=DB::fetch_all("select * from ".DB::table($this->table)." order by ".$ordertype." desc ". DB::limit($start, $limit));
			return $result;
		}

		public function fetch_all_by_category($categoryID,$start=0,$limit=0)
		{
			if(!$categoryID)
			{
				return null;
			}
			$result=array();
			$result=DB::fetch_all("select * from ".DB::table($this->table)." where categoryID=".$categoryID." order by cnum desc ". DB::limit($start, $limit));
			
			return $result;
		}

		public function fetch_count()
		{
			return DB::result_first("select count(*) from ".DB::table($this->table));
		}
		public function delete_category_by_id($categoryid)
		{
			DB::query("delete from %t where categoryID=%d",array($this->table,$categoryid));
		}
	}
?>