<?php

	class Home extends CI_Controller{

		public function index(){
			$data = [
				'title'		=> 'Beranda',
				'content'	=> 'home/index'
			];

			$this->load->view('base', $data);
		}

	}