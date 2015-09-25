<?php

	Class Admin extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			$this->load->model('user', '', true);
		}
		function login(){
			if ($this->session->userdata('is_login') === true) {
				redirect('home');
			}else{
				$this->load->helper('form');
				
				if (empty($_POST)) {
					$this->load->view('admin/login');
				}else{
					$this->load->library('form_validation');
					$this->form_validation->set_error_delimiters('<div class="alert alert-danger alert-dismissable">', '</div>');
					
					$this->form_validation->set_rules('user_name', 'Username', 'required|trim|xss_clean');
					$this->form_validation->set_rules('user_password', 'Password', 'required|trim|xss_clean|md5');
					
					if ($this->form_validation->run() == TRUE) {
						$data['user_name'] 		= $this->input->post('user_name',true);
						$data['user_password'] 	= $this->input->post('user_password',true);
						
						$logindata = $this->user->login($data);
						$this->access->login($logindata);
					}else{
						$this->load->view('admin/login');
					}
				}
			}
		}
		function logout(){
			$this->access->logout();
		}
		
	}