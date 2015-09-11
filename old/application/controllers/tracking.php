<?php

	Class Tracking extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			
			$this->access->is_logged_in();
			
			$this->load->helper('form');
			$this->load->model('m_tracking','mdl',true);
		}
		function index($type,$offset=0){
			$name = $type == '1' ? 'Satuan' : 'Pulsa';
			
			if (!empty($_POST)) {
				$where['field'] = $this->input->post('field');
				
				if ($where['field'] == 'kode_mc') {
					$where['value'] = $this->input->post('kode_mc');
				}elseif ($where['field'] == 'tanggal'){
					$where['value'] = $this->input->post('tgl');
				}else{
					$where['value'] = $this->input->post('q', true);
				}
				
				$config['uri_segment'] = 4;
				$limit = '';
			}else{
				$where = NULL;
				
				$limit = 40;
				$config = array(
					'base_url'		=> site_url('tracking/index/'.$type),
					'total_rows'	=> $this->mdl->count_all($type,$where),
					'per_page'		=> $limit,
					'uri_segment'	=> 4,
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
			}

			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; Elektrik &raquo; '.$name,
				'title_inf' => array('elektrik'=>'tracking/index/'.$type,$name=>'tracking/index/'.$type),
				'h1' => 'list penjualan pulsa elektrik ('.$name.')',
				'type' => $type,
				'type_name' => $name,
				'container' => 'list_tracking',
				'fetch' => $this->mdl->get_data($type,$where,$offset,$limit),
				'master_card' => $this->mdl->get_master_card_data($type),
				'numb'	=> $this->access->get_start_number($config['uri_segment'])
			);
			
			if(empty($_POST)){
				$data['pagination'] = $this->pagination->create_links();
			}
			
			$this->load->view('base', $data);
		}
		function add($type){
			$name = $type == '1' ? 'Satuan' : 'Pulsa';
			
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; Penj. Elektrik &raquo; '.$name,
				'title_inf' => array('elektrik'=>'tracking/index/'.$type,$name=>'tracking/index/'.$type,'penjualan'=>'tracking/add/'.$type),
				'h1' => 'Form penjualan pulsa elektrik ('.$name.')',
				'type' => $type,
				'type_name' => $name,
				'container' => 'add_tracking',
				'master_card' => $this->mdl->get_master_card_data($type),
				'last'	=> $this->mdl->get_last_data($type),
				'member' => $this->mdl->get_member_data(),
				'data' => array(
					'kode_mc' => $this->input->post('kode_mc'),
					'tanggal' => $this->access->now(),
					'nama' => $this->input->post('nama', true),
					'no_hp' => $this->input->post('no_hp', true),
					'ket' => nl2br($this->input->post('ket'))
				)
			);
			
			if (empty($_POST)) {
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ','</span>');
				
				$this->form_validation->set_rules('kode_mc', 'Kode', 'required');
				$this->form_validation->set_rules('no_hp', 'Nomor Handphone', 'required|trim|is_natural');
				
				if ($this->form_validation->run() == TRUE) {
					
					if ($type == '1') {
						$final = $this->mdl->reduce_satuan_stock($data['data']['kode_mc']);
					}else{
						$final = $this->mdl->reduce_pulsa_stock($data['data']['kode_mc']);
					}
					
					if ($final == FALSE) {
						$this->session->set_flashdata('error_stock', '<span class="error">&raquo; Maaf, saldo sudah habis. Proses tracking gagal!</span>');
					}else{
						$data['data']['saldo_smntr'] = $this->mdl->saldo;
						
						$this->mdl->add($data['data']);
						$this->session->set_flashdata('success_add','<span class="true">&raquo; Proses tracking berhasil.</span>');
					}
				
					redirect('tracking/add/'.$type);
				}else{
					$this->load->view('base', $data);
				}
			}
		}
		function ajax_get_master_card_name(){
			$id = $_POST['kode_mc'];
			echo json_encode($this->mdl->ajax_get_master_card_name($id));
		}
		function ajax_get_member_data(){
			$id = $_POST['id_member'];
			echo json_encode($this->mdl->ajax_get_member_data($id));
		}
		function ajax_check_utang(){
			$no_hp = $_POST['no_hp'];
			echo json_encode($this->mdl->ajax_check_utang($no_hp));
		}
		function delete($type,$id){
			$this->mdl->delete($id);
			$this->session->set_flashdata('success_delete','<span class="true">&raquo; Data penjualan berhasil dihapus</span>');
			
			redirect('tracking/index/'.$type);
		}
		function edit($type,$id){
			$name = $type == '1' ? 'Satuan' : 'Pulsa';
			
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; Edit Penj. Elektrik &raquo; '.$name,
				'title_inf' => array('elektrik'=>'tracking/index/'.$type,$name=>'tracking/index/'.$type,'edit data'=>'tracking/edit/'.$type),
				'h1' => 'Form edit pulsa elektrik ('.$name.')',
				'type' => $type,
				'type_name' => $name,
				'container' => 'edit_tracking',
				'fetch'	=> $this->mdl->get_once_data($id)
			);
			
			if (empty($_POST)) {
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ','</span>');
				
				$this->form_validation->set_rules('no_hp','Nomor Handphone','required|trim|is_natural');
				$this->form_validation->set_rules('nama','Nama','trim');
				$this->form_validation->set_rules('ket','Keterangan','trim');
				
				if ($this->form_validation->run() == TRUE) {
					$data['data'] = array(
						'no_hp'	=> $this->input->post('no_hp', true),
						'nama'	=> $this->input->post('nama', true),
						'ket'	=> $this->input->post('ket', true)
					);
					
					$this->mdl->update($id, $data['data']);
					
					$this->session->set_flashdata('success_edit','<span class="true">&raquo; Data penjualan pulsa elektrik berhasil diubah</span>');
					redirect('tracking/edit/'.$type.'/'.$id);
				}else{
					$this->load->view('base', $data);
				}
			}
		}
		function hutang(){
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; Daftar Hutang',
				'title_inf' => array('daftar hutang'=>'tracking/hutang'),
				'h1' => 'Form pencarian daftar hutang',
				'container'	=> 'search_hutang',
				'data' => array(
					'q'	=> $this->input->post('q', true),
					'field' => $this->input->post('field')
				)
			);
				
			if (empty($_POST)) {
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ','</span>');
				
				$this->form_validation->set_rules('field', 'Kategori', 'required');
				$this->form_validation->set_rules('q', 'Query', 'required|trim|xss_clean');
				
				if ($this->form_validation->run() == TRUE) {
					$this->access->add_logActivity('Pencarian daftar hutang dengan kategori <strong>'.$data['data']['field'].'</strong> dan query = <strong>'.$data['data']['q'].'</strong>');
					
					$data['fetch'] = $this->mdl->get_hutang_data($data['data']);
					$data['h1'] = 'Hasil Pencarian Daftar Hutang';
					$data['list'] = 'list_hutang';
				}
				
				
				$this->load->view('base', $data);
			}
		}
		function ajax_heal_hutang(){
			$data = array('ket'=>($_POST['cond'] == 'lunas' ? '' : 'hutang'));
			$this->mdl->ajax_heal_hutang($_POST['id_tr'],$data);
		}
		public function new_healHutang(){
			$this->mdl->new_healHutang($_POST['id_tr'], array('ket' => ''));
			echo 'success';
		}
		
	}

?>