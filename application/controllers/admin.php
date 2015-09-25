<?php

	Class Admin extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			$this->load->model('m_admin','mdl',true);
		}
		function login(){
			if ($this->session->userdata('is_login') === TRUE) {
				redirect('home');
				exit();
			}else{
				$this->load->helper('form');
				
				if (empty($_POST)) {
					$this->load->view('login');
				}else{
					$this->load->library('form_validation');
					$this->form_validation->set_error_delimiters('<span class="error">&raquo; ', '</span>');
					
					$this->form_validation->set_rules('username','Username','required|trim|xss_clean');
					$this->form_validation->set_rules('psw','Password','required|trim|xss_clean|md5');
					
					if ($this->form_validation->run() == TRUE) {
						$data['uname'] = $this->input->post('username',true);
						$data['psw'] = $this->input->post('psw',true);
						
						$logindata = $this->mdl->check_login($data);
						$this->access->login($logindata);
					}else{
						$this->load->view('login');
					}
				}
			}
		}
		function logout(){
			$this->access->logout();
		}
		function date(){
			echo $this->access->get_date();
		}
		
	}