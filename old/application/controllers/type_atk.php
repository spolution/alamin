<?php

	Class Type_atk extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			$this->access->is_logged_in();
			
			$this->load->helper('form');
			$this->load->model('m_type_atk','mdl',true);
		}
		function index(){
			$where = isset($_POST) ? $this->input->post('q', true) : null;
			
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; List Jenis ATK',
				'title_inf' => array('ATK'=>'atk','jenis'=>'type_atk'),
				'h1' => 'list jenis alat tulis kantor',
				'container'	=> 'list_type_atk',
				'fetch'	=> $this->mdl->get_data($where)
			);
			
			$this->load->view('base', $data);
		}
		function add(){
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; jenis ATK &raquo; Tambah Data',
				'title_inf' => array('ATK'=>'atk','jenis'=>'type_atk','tambah data'=>'type_atk/add'),
				'h1' => 'form tambah data jenis ATK',
				'container'	=> 'add_type_atk',
				'data'	=> array(
					'nama_type'	=> $this->input->post('nama_type', true)
				)
			);
			
			if (empty($_POST)) {
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ','</span>');
				
				$this->form_validation->set_rules('nama_type', 'Nama Tipe Alat Tulis', 'required|trim');
				
				if ($this->form_validation->run() == TRUE) {
					$this->mdl->add($data['data']);
					
					$this->session->set_flashdata('success_add', '<span class="true">&raquo; Data jenis alat tulis kantor berhasil ditambah.</span>');
					redirect('type_atk');
				}else {
					$this->load->view('base', $data);
				}
			}
		}
		function edit($id){
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; jenis ATK &raquo; Edit Data',
				'title_inf' => array('ATK'=>'atk','jenis'=>'type_atk','edit data'=>'type_atk/edit/'.$id),
				'h1' => 'form edit data jenis ATK',
				'container'	=> 'edit_type_atk',
				'row'	=> $this->mdl->get_once_data($id)
			);
			
			if (empty($_POST)) {
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ','</span>');
				
				$this->form_validation->set_rules('nama_type', 'Nama Tipe Alat Tulis', 'required|trim');
				
				if ($this->form_validation->run() == TRUE) {
					$this->mdl->update($id, array('nama_type' => $this->input->post('nama_type', true)));
					
					$this->session->set_flashdata('success_edit', '<span class="true">&raquo; Data jenis alat tulis kantor berhasil diubah</span>');
					redirect('type_atk/edit/'.$id);
				}else {
					$this->load->view('base', $data);
				}
			}
		}
		function delete($id){
			$this->mdl->delete($id);
			
			$this->session->set_flashdata('success_delete', '<span class="true">&raquo; Data jenis alat tulis kantor telah dihapus</span>');
			redirect('type_atk');
		}
		
	}

?>