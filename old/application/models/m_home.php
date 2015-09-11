<?php

	Class M_home extends CI_Model{
		
		private $tbl = 'log_activity';
		private $primary = 'id_act';
		
		function __construct(){
			parent::__construct();
		}
		function fetch($offset, $limit){
			$this->db->select('*');
			$this->db->order_by($this->primary, 'DESC');
			
			return $this->db->get($this->tbl, $limit, $offset);
		}
		function count_all(){
			$this->db->select('*');
			$this->db->from('log_activity');
			
			return $this->db->count_all_results();
		}
		
	}

?>