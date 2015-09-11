<?php

	Class Type_aksesoris extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			$this->access->is_logged_in();
			
			$this->load->helper('form');
			$this->load->model('m_type_aksesoris','mdl',true);
		}
		function index(){
			$where = isset($_POST) ? $this->input->post('q', true) : null;
			
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; List Jenis Aksesoris',
				'title_inf' => array('aksesoris'=>'aksesoris','jenis'=>'type_aksesoris'),
				'h1' => 'list jenis aksesoris',
				'container'	=> 'list_type_akse',
				'fetch'	=> $this->mdl->get_data($where)
			);
			
			$this->load->view('base', $data);
		}
		function add(){
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; jenis Aksesoris &raquo; Tambah Data',
				'title_inf' => array('aksesoris'=>'aksesoris','jenis'=>'type_aksesoris','tambah data'=>'type_aksesoris/add'),
				'h1' => 'form tambah data jenis aksesoris',
				'container'	=> 'add_type_akse',
				'data'	=> array(
					'nama_type'	=> $this->input->post('nama_type', true)
				)
			);
			
			if (empty($_POST)) {
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ','</span>');
				
				$this->form_validation->set_rules('nama_type', 'Nama Tipe Aksesoris', 'required|trim');
				
				if ($this->form_validation->run() == TRUE) {
					$this->mdl->add($data['data']);
					
					$this->session->set_flashdata('success_add', '<span class="true">&raquo; Data jenis aksesoris berhasil ditambah.</span>');
					redirect('type_aksesoris');
				}else {
					$this->load->view('base', $data);
				}
			}
		}
		function edit($id){
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; jenis Aksesoris &raquo; Edit Data',
				'title_inf' => array('aksesoris'=>'aksesoris','jenis'=>'type_aksesoris','edit data'=>'type_aksesoris/edit/'.$id),
				'h1' => 'form edit data jenis aksesoris',
				'container'	=> 'edit_type_akse',
				'row'	=> $this->mdl->get_once_data($id)
			);
			
			if (empty($_POST)) {
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ','</span>');
				
				$this->form_validation->set_rules('nama_type', 'Nama Tipe Aksesoris', 'required|trim');
				
				if ($this->form_validation->run() == TRUE) {
					$this->mdl->update($id, array('nama_type' => $this->input->post('nama_type', true)));
					
					$this->session->set_flashdata('success_edit', '<span class="true">&raquo; Data jenis aksesoris berhasil diubah</span>');
					redirect('type_aksesoris/edit/'.$id);
				}else {
					$this->load->view('base', $data);
				}
			}
		}
		function delete($id){
			$this->mdl->delete($id);
			
			$this->session->set_flashdata('success_delete', '<span class="true">&raquo; Data jenis aksesoris telah dihapus</span>');
			redirect('type_aksesoris');
		}
		
	}

?>