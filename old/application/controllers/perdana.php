<?php

	Class Perdana extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			$this->access->is_logged_in();
			
			$this->load->helper('form');
			$this->load->model('m_perdana','mdl', true);
		}
		function index($offset=0){
			
			if (!empty($_POST)) {
				$where['field'] = $this->input->post('field');
				
				if ($where['field'] == 'kode_kartu') {
					$where['value'] = $this->input->post('kode_kartu');
				}elseif ($where['field'] == 'id_type'){
					$where['value'] = $this->input->post('id_type');
				}elseif ($where['field'] == 'tanggal'){
					$where['value'] = $this->input->post('tgl');
				}else{
					$where['value'] = $this->input->post('q');
				}
			}else{
				$where = null;
			}
			
			$limit = 40;
			$config = array(
				'base_url'		=> site_url('perdana/index'),
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
				'title' => 'Al-Amin &raquo; List Penjualan Kartu Perdana',
				'title_inf' => array('kartu perdana'=>'perdana'),
				'h1' => 'list penjualan kartu perdana',
				'container'	=> 'list_perdana',
				'kartu'	=> $this->mdl->get_other_table_data('kartu'),
				'type_perdana'	=> $this->mdl->get_other_table_data('type_perdana'),
				'fetch'	=> $this->mdl->get_data($where,$offset,$limit),
				'pagination' => $this->pagination->create_links(),
				'numb'	=> $this->access->get_start_number($config['uri_segment'])
			);
			
			$this->load->view('base', $data);
		}
		function add(){
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; Form Penjualan Kartu Perdana',
				'title_inf' => array('kartu perdana'=>'perdana','penjualan'=>'perdana/add'),
				'h1' => 'form penjualan kartu perdana',
				'container'	=> 'add_perdana',
				'kartu'	=> $this->mdl->get_other_table_data('kartu'),
				'type_perdana'	=> $this->mdl->get_other_table_data('type_perdana'),
				'data' => array(
					'kode_kartu'	=> $this->input->post('kode_kartu'),
					'id_type'	=> $this->input->post('id_type'),
					'nomor'		=> $this->input->post('nomor', true),
					'hrg_dasar'	=> $this->input->post('hrg_dasar', true),
					'hrg_jual'	=> $this->input->post('hrg_jual', true),
					'tanggal'	=> $this->access->now()
				)
			);
			
			if (empty($_POST)) {
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ','</span>');
				
				$this->form_validation->set_rules('kode_kartu', 'Kode Kartu', 'required');
				$this->form_validation->set_rules('id_type', 'Tipe', 'required');
				$this->form_validation->set_rules('nomor', 'Nomor Handphone', 'is_natural|required|trim');
				$this->form_validation->set_rules('hrg_dasar', 'Harga Dasar', 'numeric|required|trim');
				$this->form_validation->set_rules('hrg_jual', 'Harga Jual', 'numeric|required|trim');
				
				if ($this->form_validation->run() == TRUE) {
					$this->mdl->add($data['data']);
					
					$this->session->set_flashdata('success_add','<span class="true">&raquo; Penjualan kartu perdana telah berhasil.</span>');
					redirect('perdana');
				}else{
					$this->load->view('base', $data);
				}
			}
		}
		function delete($id){
			$this->mdl->delete($id);
			
			$this->session->set_flashdata('success_delete','<span class="true">&raquo; Data penjualan kartu perdana telah dihapus.</span>');
			redirect('perdana');
		}
		function edit($id){
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; Form Edit Kartu Perdana',
				'title_inf' => array('kartu perdana'=>'perdana','edit data'=>'perdana/edit/'.$id),
				'h1' => 'form edit kartu perdana',
				'container'	=> 'edit_perdana',
				'type_perdana' => $this->mdl->get_other_table_data('type_perdana'),
				'row'	=> $this->mdl->get_once_data($id)
			);
			
			if (empty($_POST)) {
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ','</span>');
				
				$this->form_validation->set_rules('id_type', 'Tipe', 'required');
				$this->form_validation->set_rules('nomor', 'Nomor Handphone', 'required|trim|is_natural');
				$this->form_validation->set_rules('hrg_dasar', 'Harga Dasar', 'required|trim|numeric');
				$this->form_validation->set_rules('hrg_jual', 'Harga Jual', 'required|trim|numeric');
				
				if ($this->form_validation->run() == TRUE) {
					$data['data'] = array(
						'id_type'	=> $this->input->post('id_type'),
						'nomor'		=> $this->input->post('nomor', true),
						'hrg_dasar'	=> $this->input->post('hrg_dasar', true),
						'hrg_jual'	=> $this->input->post('hrg_jual', true)
					);
					
					$this->mdl->update($id, $data['data']);
					$this->session->set_flashdata('success_edit', '<span class="true">&raquo; Data penjualan kartu perdana berhasil diubah</span>');
					
					redirect('perdana/edit/'.$id);
				}else{
					$this->load->view('base', $data);
				}
			}
		}
		
	}

?>