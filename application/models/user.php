<?php

	class User extends CI_Model{

		private $tbl 		= 'user';
		public 	$primary 	= 'user_name';
		
		function login($data){
			$get = $this->db
					->where($this->primary, $data['user_name'])
					->where('user_password', $data['user_password'])
					->get($this->tbl);
			
			if ($get->num_rows() > 0) {
				return $get->row();
			}
		}

	}