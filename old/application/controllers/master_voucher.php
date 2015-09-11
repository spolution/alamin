<?php

	Class Master_voucher extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			
			$this->access->is_logged_in();
			
			$this->load->helper('form');
			$this->load->model('m_master_voucher','mdl',TRUE);
		}
		function index(){
			if (!empty($_POST)) {
				$where['field'] = $this->input->post('field');
				
				if ($where['field'] == 'kode_kartu') {
					$where['value'] = $this->input->post('kode_kartu');
				}else{
					$where['value'] = $this->input->post('q', true);
				}
			}else{
				$where = null;
			}
			
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; List Deposit Voucher',
				'title_inf' => array('pulsa fisik'=>'voucher','deposit'=>'master_voucher'),
				'h1' => 'list deposit pulsa fisik',
				'container'	=> 'list_master_voucher',
				'fetch'	=> $this->mdl->get_data($where),
				'kartu'	=> $this->mdl->get_kartu_data()
			);
			
			$this->load->view('base', $data);
		}
		function add(){
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; Deposit Voucher &raquo; Tambah Data',
				'title_inf' => array('pulsa fisik'=>'voucher','deposit'=>'master_voucher','Tambah Data'=>'master_voucher/add'),
				'h1' => 'form tambah data deposit voucher',
				'container'	=> 'add_master_voucher',
				'kartu'	=> $this->mdl->get_kartu_data(),
				'data'	=> array(
					'kode_kartu'=> $this->input->post('kode_kartu'),
					'kode_vo'	=> $this->input->post('kode_vo', true),
					'ket'		=> $this->input->post('ket', true),
					'hrg_dasar'	=> $this->input->post('hrg_dasar', true),
					'hrg_jual'	=> $this->input->post('hrg_jual', true)
				)
			);
			
			if (empty($_POST)) {
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo;','</span>');
				
				$this->form_validation->set_rules('kode_vo', 'Kode Voucher', 'required|trim|xss_clean');
				$this->form_validation->set_rules('kode_kartu', 'Nama Kartu', 'required');
				$this->form_validation->set_rules('hrg_dasar', 'Harga Dasar', 'required|trim|numeric');
				$this->form_validation->set_rules('hrg_jual', 'Harga Jual', 'required|trim|numeric');
				
				if ($this->form_validation->run() == TRUE) {
					if ($this->mdl->check_kode($data['data']['kode_vo']) == TRUE) {
						$this->mdl->add($data['data']);
						$this->session->set_flashdata('success_add','<span class="true">&raquo; Data deposit voucher berhasil ditambah</span>');
						
						redirect('master_voucher');
					}else{
						$this->session->set_flashdata('error_kode','<span class="error">&raquo; Maaf, kode yang anda masukkan sudah terdaftar sebelumnya!</span>');
						$this->load->view('base', $data);
					}
				}else{
					$this->load->view('base', $data);
				}
			}
		}
		function ajax_get_shortcut_name(){
			$id = $_POST['kode_kartu'];
			echo json_encode($this->mdl->ajax_get_shortcut_name($id));
		}
		function edit($id){
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; Deposit Voucher &raquo; Edit Data',
				'title_inf' => array('pulsa fisik'=>'voucher','deposit'=>'master_voucher','Edit Data'=>'master_voucher/edit/'.$id),
				'h1' => 'form edit data deposit pulsa fisik',
				'container'	=> 'edit_master_voucher',
				'row'	=> $this->mdl->get_once_data($id)
			);
			
			if (empty($_POST)) {
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ','</span>');
				
				$this->form_validation->set_rules('ket','Keterangan Kode','required|trim');
				$this->form_validation->set_rules('hrg_dasar','Harga Dasar','required|trim|numeric');
				$this->form_validation->set_rules('hrg_jual','Harga Jual','required|trim|numeric');
				
				if ($this->form_validation->run() == TRUE) {
					$value = array(
						'ket'	=> $this->input->post('ket', true),
						'hrg_dasar'	=> $this->input->post('hrg_dasar', true),
						'hrg_jual'	=> $this->input->post('hrg_jual', true)
					);
					$this->mdl->update($id,$value);
					
					$this->session->set_flashdata('success_edit','<span class="true">&raquo; Data deposit voucher berhasil diubah.</span>');
					redirect('master_voucher/edit/'.$id);
				}else{
					$this->load->view('base', $data);
				}
			}
		}
		function delete($id){
			$this->mdl->delete($id);
			
			$this->session->set_flashdata('success_delete','<span class="true">&raquo; Data deposit pulsa fisik berhasil dihapus.</span>');
			redirect('master_voucher');
		}
		
	}

?>