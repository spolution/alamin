<?php

	Class Voucher extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			$this->access->is_logged_in();
			
			$this->load->helper('form');
			$this->load->model('m_voucher','mdl',true);
		}
		function index($offset=0){
			
			if (!empty($_POST)) {
				$where['field'] = $this->input->post('field');
				
				if ($where['field'] == 'kode_vo') {
					$where['value'] = $this->input->post('kode_vo');
				}else{
					$where['value'] = $this->input->post('tgl', true);
				}
			}else{
				$where = NULL;
			}
			
			$limit = 40;
			$config = array(
				'base_url'		=> site_url('voucher/index'),
				'per_page'		=> $limit,
				'uri_segment'	=> 3,
				'total_rows'	=> $this->mdl->count_all($where),
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
				'title' => 'Al-Amin &raquo; List Penjualan Pulsa Fisik',
				'title_inf' => array('pulsa fisik'=>'voucher','penjualan'=>'voucher'),
				'h1' => 'list penjualan pulsa fisik',
				'container'	=> 'list_voucher',
				'master_voucher' => $this->mdl->get_master_voucher_data(),
				'fetch'	=> $this->mdl->get_data($where,$offset,$limit),
				'pagination'	=> $this->pagination->create_links(),
				'numb'	=> $this->access->get_start_number($config['uri_segment'])
			);
			
			$this->load->view('base', $data);
		}
		function add(){
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; Pulsa Fisik &raquo; Form Penjualan',
				'title_inf' => array('pulsa fisik'=>'voucher','form penjualan'=>'voucher/add'),
				'h1' => 'form penjualan pulsa fisik',
				'container'	=> 'add_voucher',
				'master_voucher'	=> $this->mdl->get_master_voucher_data()
			);
			
			if (empty($_POST)) {
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ','</span>');
				
				$this->form_validation->set_rules('kode_vo','Kode Voucher','required');
				
				if ($this->form_validation->run() == TRUE) {
					$this->mdl->add(array('kode_vo'=>$this->input->post('kode_vo'),'tanggal'=>$this->access->now()));
					
					$this->session->set_flashdata('success_add','<span class="true">&raquo; Penjualan pulsa fisik telah berhasil!</span>');
					redirect('voucher/add');
				}else{
					$this->load->view('base', $data);
				}
			}
		}
		function ajax_get_master_voucher_data(){
			$id = $_POST['kode_vo'];
			echo json_encode($this->mdl->ajax_get_master_voucher_data($id));
		}
		function delete($id){
			$this->mdl->delete($id);
			
			$this->session->set_flashdata('success_delete','<span class="true">&raquo Data penjualan pulsa fisik telah dihapus.</span>');
			redirect('voucher');
		}
	}

?>