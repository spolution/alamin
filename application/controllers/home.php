<?php

	class Home extends CI_Controller{

		public function __construct(){
			parent::__construct();
			$this->access->isLoggedIn();
		}
		public function index(){
			$data = [
				'title'		=> 'Beranda',
				'content'	=> 'home/index'
			];

			$this->load->view('base', $data);
		}

	}