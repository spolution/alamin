<?php

	Class Aksesoris extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			$this->access->is_logged_in();
			
			$this->load->helper('form');
			$this->load->model('m_aksesoris', 'mdl', true);
		}
		function index($offset=0){
			if (!empty($_POST)) {
				$where['field'] = $this->input->post('field');
				
				switch ($where['field']){
					case 'id_type' :
						$where['value'] = $this->input->post('id_type');
					break;
					case 'tanggal' :
						$where['value'] = $this->input->post('tgl', true);
					break;
					default:
						$where['value'] = $this->input->post('q', true);
					break;
				}
			}else{
				$where = null;
			}
			
			$limit = 40;
			$config = array(
				'base_url'		=> site_url('aksesoris/index'),
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
				'title' => 'Al-Amin &raquo; List Penjualan Aksesoris',
				'title_inf' => array('aksesoris'=>'aksesoris','penjualan'=>'aksesoris'),
				'h1' => 'list penjualan aksesoris',
				'container' => 'list_aksesoris',
				'data_type_akse' => $this->mdl->get_type_akse_data(),
				'fetch'	=> $this->mdl->get_data($where,$offset,$limit),
				'pagination' => $this->pagination->create_links(),
				'numb'	=> $this->access->get_start_number($config['uri_segment'])
			);
			
			$this->load->view('base', $data);
		}
		function add(){
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; Form Penjualan Aksesoris',
				'title_inf' => array('aksesoris'=>'aksesoris','penjualan'=>'aksesoris','tambah'=>'aksesoris/add'),
				'h1' => 'form penjualan aksesoris',
				'container' => 'add_akse',
				'data_type_akse' => $this->mdl->get_type_akse_data()
			);
			
			if (empty($_POST)){
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ','</span>');
				$this->form_validation->set_rules('id_ma', 'Pilih Aksesoris', 'required');
				
				if ($this->form_validation->run() === TRUE) {
					$this->mdl->add(array('id_ma'=>$this->input->post('id_ma'),'tanggal'=>$this->access->now()));
				
					$this->session->set_flashdata('success_add','<span class="true">&raquo; Penjualan aksesoris berhasil diproses.</span>');
					redirect('aksesoris');
				}else{
					$this->load->view('base', $data);
				}
			}
		}
		function ajax_get_master_akse(){
			$id_type = $_POST['id_type'];
			$a = '<option value="">-- Pilih --</option>';
			
				foreach ($this->mdl->ajax_get_master_akse($id_type)->result() as $row) {
					$a .= '<option value="'.$row->id_ma.'">'.$row->nama_brg.'</option>';
				}
				
			echo json_encode($a);
		}
		function ajax_get_once_master_akse(){
			$id = $_POST['id_ma'];
			echo json_encode($this->mdl->ajax_get_once_master_akse($id));
		}
		function delete($id){
			$this->mdl->delete($id);
			
			$this->session->set_flashdata('success_delete', '<span class="true">&raquo; Data penjualan aksesoris telah dihapus.</span>');
			redirect('aksesoris');
		}
		
	}

?>