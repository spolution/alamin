<?php

	Class Member extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			$this->access->is_logged_in();
			
			$this->load->model('m_member', 'mdl', true);
			$this->load->helper('form');
		}
		function index(){
			$data = array(
				'cur_nav' => $this->access->set_current_nav('member'),
				'title' => 'Al-Amin &raquo; List Member',
				'title_inf' => array('member'=>'member'),
				'h1' => 'data list member',
				'container'	=> 'list_member',
				'fetch'	=> $this->mdl->get_data()
			);
			
			$this->load->view('base', $data);
		}
		function add(){
			$data = array(
				'cur_nav' => $this->access->set_current_nav('member'),
				'title' => 'Al-Amin &raquo; Member &raquo; Tambah Data',
				'title_inf' => array('member'=>'member', 'tambah data'=>'member/add'),
				'h1' => 'form tambah member',
				'container'	=> 'add_member',
				'data'	=> array(
					'nama'		=> $this->input->post('nama'),
					'no_tlpn'	=> $this->input->post('no_tlpn')
				)
			);
			
			if (empty($_POST)) {
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ', '</span>');
				
				$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
				$this->form_validation->set_rules('no_tlpn', 'Nomor Telepon', 'required|numeric|trim');
				
				if ($this->form_validation->run() == TRUE) {
					$this->access->add_logActivity('Penambahan data member dengan nama member <strong>'.$data['data']['nama'].'</strong>');
					$this->mdl->add($data['data']);
					
					$this->session->set_flashdata('success_add', '<span class="true">&raquo; Data member berhasil ditambah.</span>');
					redirect('member');
				}else{
					$this->load->view('base', $data);
				}
			}
		}
		function edit($id){
			$data = array(
				'cur_nav' => $this->access->set_current_nav('member'),
				'title' => 'Al-Amin &raquo; Member &raquo; Edit Data',
				'title_inf' => array('member'=>'member', 'edit'=>'member/edit/'.$id),
				'h1' => 'form edit member',
				'container'	=> 'edit_member',
				'row'	=> $this->mdl->get_once_data($id)
			);
			
			if (empty($_POST)) {
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ', '</span>');
				
				$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
				$this->form_validation->set_rules('no_tlpn', 'Nomor Telepon', 'required|numeric|trim');
				
				if ($this->form_validation->run() == TRUE) {
					$val = array(
						'nama'	=> $this->input->post('nama', true),
						'no_tlpn' => $this->input->post('no_tlpn', true)
					);
					$this->access->add_logActivity('Edit data member dengan nama member <strong>'.$val['nama'].'</strong>');
					$this->mdl->update($id, $val);
					
					$this->session->set_flashdata('success_edit', '<span class="true">&raquo; Data member berhasil diubah.</span>');
					redirect('member/edit/'.$id);
				}else{
					$this->load->view('base', $data);
				}
			}
		}
		function delete($id){
			$this->mdl->delete($id);
			
			$this->session->set_flashdata('success_delete', '<span class="true">&raquo; Data member telah dihapus.</span>');
			redirect('member');
		}
		
	}

?>