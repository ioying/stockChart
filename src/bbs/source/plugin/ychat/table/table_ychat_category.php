<?php
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	class table_ychat_category extends discuz_table{
		public function __construct(){
			$this->table='ychat_category';
			$this->_pk='categoryID';
			parent::__construct();
		}
		public function fetch_all_by_bcategoryid($bcategoryID)
		{
			$result=array();
			$result=DB::fetch_all("select * from %t where bCategoryID=%d order by categoryID asc ",array($this->table,$bcategoryID));
			return $result;
		}
		public function fetch_by_categoryid($categoryid)
		{
			if(!$categoryid)
			{
				return null;
			}
			$result=DB::fetch_first("select * from %t where categoryID=%d",array($this->table,$categoryid));
			return $result;
		}
	}
?>