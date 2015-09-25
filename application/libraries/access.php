<?php

	Class Access{
		
		protected $CI;
		
		function __construct(){
			$this->CI =& get_instance();
		}
		function login($data){
			if ($data) {
				$session_data = array(
					'username'	=> $data->username,
					'name'		=> $data->nama,
					'is_login'	=> TRUE
				);
				
				$this->CI->session->set_userdata($session_data);
				redirect('home');
			}else{
				$this->CI->session->set_flashdata('error_login','<span class="error">&raquo; Kombinasi username dan password salah!</span>');
				redirect('admin/login');
			}
		}
		function logout(){
			$data = array(
				'username'	=> null,
				'name'		=> null,
				'is_login'	=> FALSE
			);
			
			$this->CI->session->unset_userdata($data);
			$this->CI->session->sess_destroy();
			
			redirect('admin/login');
		}
		function is_logged_in(){
			if ($this->CI->session->userdata('is_login') !== TRUE) {
				redirect('admin/login');
				exit();
			}
		}
		function get_start_number($segment_numb){
			if (!$this->CI->uri->segment($segment_numb)) {
				$no = 1;
			}else{
				$no = $this->CI->uri->segment($segment_numb) + 1;
			}
			
			return $no;
		}
		function now(){
			return date('Y-m-d H:i:s');
		}
		function set_current_nav($param){
			$base_nav = array(''=>'','beranda'=>'','kartu'=>'','mc'=>'','penjualan'=>'','member'=>'','lap'=>'','backup'=>'');
			$base_nav[$param] = 'current';
			
			return $base_nav;
		}
		function add_logActivity($text){
			$this->CI->load->database();
			return $this->CI->db->insert('log_activity', array('text' => $text,'date'=>$this->now()));
		}
		
	}