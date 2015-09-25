<?php

	Class Access{
		
		protected $CI;
		
		function __construct(){
			$this->CI =& get_instance();
		}
		function login($data){
			if ($data) {
				$session_data = array(
					'user_name'		=> $data->user_name,
					'user_nickname'	=> $data->user_nickname,
					'is_login'		=> true
				);
				
				$this->CI->session->set_userdata($session_data);
				redirect('home');
			}else{
				$this->CI->session->set_flashdata('failed', '<div class="alert alert-danger alert-dismissable">Kombinasi Username dan Password salah!</div>');
				redirect('admin/login');
			}
		}
		function logout(){
			$data = array(
				'user_name'		=> null,
				'user_nickname'	=> null,
				'is_login'		=> false
			);
			
			$this->CI->session->unset_userdata($data);
			$this->CI->session->sess_destroy();
			
			redirect('admin/login');
		}
		function isLoggedIn(){
			if ($this->CI->session->userdata('is_login') !== true) {
				redirect('admin/login');
			}
		}
		
	}