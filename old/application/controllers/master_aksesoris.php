<?php

	Class Master_aksesoris extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			$this->access->is_logged_in();
			
			$this->load->helper('form');
			$this->load->model('m_master_akse', 'mdl', true);
		}
		function index($offset=0){	
			if (!empty($_POST)) {
				$where['field'] = $this->input->post('field');
				$where['value'] = $where['field'] == 'id_type' ? $this->input->post('id_type') : $this->input->post('q', true);
			}else{
				$where = null;
			}
			
			$limit = 40;
			$config = array(
				'base_url'		=> site_url('master_aksesoris/index'),
				'uri_segment'	=> 3,
				'total_rows'	=> $this->mdl->count_all($where),
				'per_page'		=> $limit,
				'cur_tag_open'	=> '<span id="cur">',
				'cur_tag_close'	=> '</span>',
				'full_tag_open'	=> '<div class="pagination radius">',
				'full_tag_close'=> '</div>',
				'next_link'		=> 'Next &raquo;',
				'prev_link'		=> '&laquo; Previous',
				'first_link'	=> '&lsaquo; First',
				'last_link'		=> 'Last &rsaquo;'
			);
			
			$this->load->library('pagination');
			$this->pagination->initialize($config);
			
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; List Deposit Aksesoris',
				'title_inf' => array('aksesoris'=>'aksesoris','deposit'=>'master_aksesoris'),
				'h1' => 'list deposit aksesoris',
				'container'	=> 'list_master_akse',
				'data_type_akse' => $this->mdl->get_type_akse_data(),
				'fetch'	=> $this->mdl->get_data($where,$offset,$limit),
				'pagination'	=> $this->pagination->create_links(),
				'numb'	=> $this->access->get_start_number($config['uri_segment'])
			);
			
			$this->load->view('base', $data);
		}
		function add(){
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; Deposit Aksesoris &raquo; Tambah Data',
				'title_inf' => array('aksesoris'=>'aksesoris','deposit'=>'master_aksesoris','tambah data'=>'master_aksesoris/add'),
				'h1' => 'form tambah data deposit aksesoris',
				'container'	=> 'add_master_akse',
				'data_type_akse'	=> $this->mdl->get_type_akse_data(),
				'data'	=> array(
					'id_type'	=> $this->input->post('id_type'),
					'nama_brg'	=> $this->input->post('nama_brg', true),
					'hrg_dasar'	=> $this->input->post('hrg_dasar', true),
					'hrg_jual'	=> $this->input->post('hrg_jual', true),
					'stock'		=> $this->input->post('stock', true)
				)
			);
			
			if (empty($_POST)) {
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ', '</span>');
				
				$this->form_validation->set_rules('id_type', 'Jenis Barang', 'required');
				$this->form_validation->set_rules('nama_brg', 'Nama Barang', 'required|trim');
				$this->form_validation->set_rules('hrg_dasar', 'Harga Dasar', 'required|numeric|trim');
				$this->form_validation->set_rules('hrg_jual', 'Harga Jual', 'required|trim|numeric');
				$this->form_validation->set_rules('stock', 'Stock', 'required|trim|numeric');
				
				if ($this->form_validation->run() == TRUE) {
					$this->mdl->add($data['data']);
					
					$this->session->set_flashdata('success_add', '<span class="true">&raquo; Data deposit aksesoris berhasil ditambah</span>');
					redirect('master_aksesoris');
				}else{
					$this->load->view('base', $data);
				}
			}
		}
		function edit($id){
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; Deposit Aksesoris &raquo; Edit Data',
				'title_inf' => array('aksesoris'=>'aksesoris','deposit'=>'master_aksesoris','edit data'=>'master_aksesoris/edit/'.$id),
				'h1' => 'form edit data deposit aksesoris',
				'container'	=> 'edit_master_akse',
				'data_type_akse'	=> $this->mdl->get_type_akse_data(),
				'row'	=> $this->mdl->get_once_data($id)
			);
			
			if (empty($_POST)) {
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo;', '</span>');
				
				$this->form_validation->set_rules('id_type', 'Jenis Barang', 'required');
				$this->form_validation->set_rules('nama_brg', 'Nama Barang', 'required|trim');
				$this->form_validation->set_rules('hrg_dasar', 'Harga Dasar', 'required|numeric|trim');
				$this->form_validation->set_rules('hrg_jual', 'Harga Jual', 'required|trim|numeric');
				$this->form_validation->set_rules('stock', 'Stock', 'required|trim|numeric');
				
				if ($this->form_validation->run() == TRUE) {
					$data['data'] = array(
						'id_type'	=> $this->input->post('id_type'),
						'nama_brg'	=> $this->input->post('nama_brg', true),
						'hrg_dasar'	=> $this->input->post('hrg_dasar', true),
						'hrg_jual'	=> $this->input->post('hrg_jual', true),
						'stock'		=> $this->input->post('stock', true)
					);
					$this->mdl->update($id, $data['data']);
					
					$this->session->set_flashdata('success_edit', '<span class="true">&raquo; Data deposit aksesoris berhasil diubah</span>');
					redirect('master_aksesoris/edit/'.$id);
				}else{
					$this->load->view('base', $data);
				}
			}
		}
		function delete($id){
			$this->mdl->delete($id);
			
			$this->session->set_flashdata('success_delete', '<span class="true">&raquo; Data deposit aksesoris telah dihapus</span>');
			redirect('master_aksesoris');
		}
		
	}

?>