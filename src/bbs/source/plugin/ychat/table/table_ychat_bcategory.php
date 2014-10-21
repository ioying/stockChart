<?php
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	class table_ychat_bcategory extends discuz_table{
		public function __construct(){
			$this->table='ychat_bcategory';
			$this->_pk='bCategoryID';
			parent::__construct();
		}
		public function fetch_all()
		{
			$result=array();
			$result=DB::fetch_all("select * from %t order by bCategoryID asc",array($this->table));
			return $result;
		}
	}
?>