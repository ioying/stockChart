<?php
	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
	class table_ychat_config extends discuz_table{
		public function __construct(){
			$this->table='ychat_config';
			$this->_pk='var';
			parent::__construct();
		}
		public function fetch_all()
		{
			$result=array();
			$result=DB::fetch_all("select * from ".DB::table($this->table));
			return $result;
		}
	}
?>