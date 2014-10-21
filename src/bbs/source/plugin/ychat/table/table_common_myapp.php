<?php
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	class table_common_myapp extends discuz_table{
		public function __construct(){
			$this->table='common_myapp';
			$this->_pk='appid';
			parent::__construct();
		}
		public function fetch_all($start=0,$limit=0)
		{
			$result=array();
			
			$result=DB::fetch_all('SELECT * FROM '.DB::table($this->table)." WHERE flag>=0  ORDER BY flag DESC, displayorder ".DB::limit($star,$limit));
			return $result;
		}
	}
?>