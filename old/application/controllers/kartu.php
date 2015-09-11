<?php

	Class Kartu extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			
			$this->access->is_logged_in();
			
			$this->load->helper('form');
			$this->load->model('m_kartu', 'mdl', true);
		}
		function index(){
			if (!empty($_POST)) {
				$where['field'] = $this->input->post('field');
				$where['value'] = $this->input->post('q', true);
			}else{
				$where = NULL;
			}
			
			$data['title'] = 'Al-Amin &raquo; Kartu';
			$data['title_inf'] = array('kartu' => 'kartu');
			$data['h1'] = 'data list kartu';
			$data['container'] = 'list_kartu';
			$data['cur_nav'] = $this->access->set_current_nav('kartu');
			$data['fetch'] = $this->mdl->get_data($where);
			
			$this->load->view('base', $data);
		}
		function delete($id){
			if ($this->mdl->delete($id) == TRUE) {
				$this->access->add_logActivity('Penghapusan data kartu dengan kode kartu <strong>'.$id.'</strong>');
				$this->session->set_flashdata('success_delete','<span class="true">&raquo; Data Kartu berhasil di hapus!</span>');
				
				redirect('kartu');
			}
		}
		function add(){
			$data = array(
				'title' => 'Al-Amin &raquo; Kartu &raquo; Tambah Data',
				'title_inf' => array('kartu'=>'kartu','Tambah Data'=>'kartu/add'),
				'cur_nav' => $this->access->set_current_nav('kartu'),
				'h1'	=> 'Tambah Data Kartu',
				'container' => 'add_kartu',
				'data' => array(
					'nama_kartu' => $this->input->post('nama_kartu', true),
					'kode_kartu' => $this->input->post('kode_kartu', true),
					'saldo_pulsa' => $this->input->post('saldo_pulsa', true)
				)
			);
			
			if (empty($_POST)) {
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ','</span>');
				
				$this->form_validation->set_rules('nama_kartu','Nama Kartu','required|trim');
				$this->form_validation->set_rules('kode_kartu','Kode Kartu','required|trim');
				$this->form_validation->set_rules('saldo_pulsa','Saldo Pulsa','trim|numeric');
				
				if ($this->form_validation->run() == TRUE) {
					$this->mdl->add($data['data']);
					$this->access->add_logActivity('Penambahan data kartu baru dengan kode kartu <strong>'.$data['data']['kode_kartu'].'</strong>');
					
					$this->session->set_flashdata('success_add','<span class="true">&raquo; Data kartu berhasil ditambah</span>');
					redirect('kartu');
				}else{
					$this->load->view('base', $data);
				}
			}
		}
		function edit($id){
			$data = array(
				'title' => 'Al-Amin &raquo; Kartu &raquo; Edit Data',
				'title_inf' => array('kartu'=>'kartu','edit data'=>'kartu/edit/'.$id),
				'cur_nav' => $this->access->set_current_nav('kartu'),
				'h1'	=> 'Edit Data Kartu',
				'container' => 'edit_kartu',
				'fetch' => $this->mdl->get_once_data($id)
			);
			
			if (empty($_POST)) {
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ','</span><br />');
				
				$this->form_validation->set_rules('nama_kartu','Nama Kartu','required|trim');
				$this->form_validation->set_rules('saldo_pulsa','Saldo Pulsa','trim|numeric');
				
				if ($this->form_validation->run() == TRUE) {
					$data['data'] = array(
						'nama_kartu' => $this->input->post('nama_kartu', true),
						'saldo_pulsa' => $this->input->post('saldo_pulsa', true)
					);
					
					$this->access->add_logActivity('Edit data kartu dengan kode kartu <strong>'.$id.'</strong>');
					$this->mdl->edit($id,$data['data']);
					$this->session->set_flashdata('success_edit','<span class="true">&raquo; Data kartu berhasil diedit</span>');
					
					redirect('kartu/edit/'.$id);
				}else{
					$this->load->view('base', $data);
				}
			}
		}
		function sum_stock($id){
			$data = array(
				'title' => 'Al-Amin &raquo; Kartu &raquo; Tambah Saldo Kartu',
				'title_inf' => array('kartu'=>'kartu','Tambah saldo'=>'kartu/sum_stock/'.$id),
				'cur_nav' => $this->access->set_current_nav('kartu'),
				'h1'	=> 'Form Tambah saldo pulsa',
				'container' => 'form_sum_stock_kartu',
				'saldo_akhir' => $this->mdl->get_last_saldo($id)->saldo_pulsa
			);
			
			if (empty($_POST)) {
				$this->load->view('base', $data);;
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ','</span>');
				
				$this->form_validation->set_rules('saldo','Tambahan saldo', 'required|numeric');
				
				if ($this->form_validation->run() === TRUE) { 
					$saldo = $this->input->post('saldo');
					
					$this->access->add_logActivity('Penambahan saldo pulsa kartu sebesar Rp '.number_format($saldo, 0, null, '.').' dengan kode kartu <strong>'.$id.'</strong>');
					$this->mdl->stock_plus($id, $saldo);
					
					$this->session->set_flashdata('sucess_edit', '<span class="true">&raquo; Saldo pulsa berhasil ditambah.</span>');
					redirect('kartu/sum_stock/'.$id.'/'.$this->uri->segment(4));
				}else{
					$this->load->view('base', $data);
				}
			}
		}
		
	}

?>