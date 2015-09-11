<?php

	Class Backup extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			
			$this->access->is_logged_in();
			$this->load->helper('form');
		}
		function get_data(){
			$this->load->database();
			$data = array(
				'cur_nav' => $this->access->set_current_nav('backup'),
				'title' => 'Al-Amin &raquo; Backup Database',
				'title_inf' => array('backup'=>'backup'),
				'h1' => 'Pilih table backup database',
				'container' => 'form_backup',
				'tables' => $this->db->query('SHOW TABLES')
			);
			
			return $data;
		}
		function index(){
			$this->load->view('base', $this->get_data());
		}
		function do_backup(){
			if (empty($_POST)) {
				redirect('backup');
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ', '</span>');
				
				$this->form_validation->set_message('required', 'Field %s harus dipilih! (Minimal satu)');
				$this->form_validation->set_rules('tables', 'checkbox dari setiap table', 'required');
				
				if ($this->form_validation->run() == TRUE) {
					$this->load->dbutil();
					$this->access->add_logActivity('Backup database, dengan list table: '.implode(', ', $this->input->post('tables')));
					
					$backup =& $this->dbutil->backup(array('tables'=>$this->input->post('tables')));
					
					$this->load->helper('download');
					force_download('_aldiunanto_al-amin.sql.rar', $backup);
				}else{
					$this->load->view('base', $this->get_data());
				}
			}
		}
		
	}

?>