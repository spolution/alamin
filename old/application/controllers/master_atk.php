<?php

	Class Master_atk extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			$this->access->is_logged_in();
			
			$this->load->helper('form');
			$this->load->model('m_master_atk', 'mdl', true);
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
				'base_url'		=> site_url('master_atk/index'),
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
				'title' => 'Al-Amin &raquo; List Deposit ATK',
				'title_inf' => array('ATK'=>'atk','deposit'=>'master_atk'),
				'h1' => 'list deposit alat tulis kantor',
				'container'	=> 'list_master_atk',
				'data_type_atk' => $this->mdl->get_type_atk_data(),
				'fetch'	=> $this->mdl->get_data($where,$offset,$limit),
				'pagination'	=> $this->pagination->create_links(),
				'numb'	=> $this->access->get_start_number($config['uri_segment'])
			);
			
			$this->load->view('base', $data);
		}
		function add(){
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; Form Tambah Deposit ATK',
				'title_inf' => array('ATK'=>'atk','deposit'=>'master_atk', 'tambah'=>'master_atk/add'),
				'h1' => 'form tambah deposit ATK',
				'container'	=> 'add_master_atk',
				'data_type_atk'	=> $this->mdl->get_type_atk_data(),
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
					
					$this->session->set_flashdata('success_add', '<span class="true">&raquo; Data berhasil ditambah!</span>');
					redirect('master_atk');
				}else{
					$this->load->view('base', $data);
				}
			}
		}
		function edit($id){
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; Form Edit Deposit ATK',
				'title_inf' => array('ATK'=>'atk','deposit'=>'master_atk', 'edit data'=>'master_atk/edit/'.$id),
				'h1' => 'form edit deposit ATK',
				'container'	=> 'edit_master_atk',
				'data_type_atk'	=> $this->mdl->get_type_atk_data(),
				'row'	=> $this->mdl->get_once_data($id)
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
					$data['data'] = array(
						'id_type'	=> $this->input->post('id_type'),
						'nama_brg'	=> $this->input->post('nama_brg', true),
						'hrg_dasar'	=> $this->input->post('hrg_dasar', true),
						'hrg_jual'	=> $this->input->post('hrg_jual', true),
						'stock'		=> $this->input->post('stock', true)
					);
					$this->mdl->update($id, $data['data']);
					
					$this->session->set_flashdata('success_edit', '<span class="true">&raquo; Data deposit ATK berhasil diubah</span>');
					redirect('master_atk/edit/'.$id);
				}else{
					$this->load->view('base', $data);
				}
			}
		}
		function delete($id){
			$this->mdl->delete($id);
			
			$this->session->set_flashdata('success_delete', '<span class="true">&raquo; Data deposit ATK telah dihapus</span>');
			redirect('master_atk');
		}
		
	}

?>