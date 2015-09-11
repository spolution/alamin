<?php

	Class M_admin extends CI_Model{
		
		private $primary = 'username';
		private $tbl = 'admin';
		
		function __construct(){
			parent::__construct();
		}
		function check_login($data){
			$this->db->where($this->primary, $data['uname']);
			$this->db->where('password', $data['psw']);
			
			$query = $this->db->get($this->tbl);
			
			if ($query->num_rows() > 0) {
				return $query->row();
			}
		}
		
	}

?>