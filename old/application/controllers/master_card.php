<?php

	Class Master_card extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			
			$this->access->is_logged_in();
			
			$this->load->helper('form');
			$this->load->model('m_master_card','mdl',true);
		}
		function index($type,$offset=0){
			$name = $type == '1' ? 'Satuan' : 'Pulsa';
			
			if (!empty($_POST)) {
				$where['field'] = $this->input->post('field');
				$where['value'] = $this->input->post('q', true);
			}else{
				$where = NULL;
			}
			
			$limit = 40;
			$config = array(
				'base_url'		=> site_url('master_card/index/'.$type),
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
			
			$data = array(
				'title' => 'Al-Amin &raquo; Master Card &raquo; '.$name,
				'title_inf' => array('master card'=>'master_card/index/'.$type,$name=>'master_card/index/'.$type),
				'type' => $type,
				'type_name' => $name,
				'h1' => 'data list master card ('.$name.')',
				'container' => 'list_master_card',
				'fetch' => $this->mdl->get_data($type,$where,$offset,$limit),
				'pagination' => $this->pagination->create_links(),
				'numb'	=> $this->access->get_start_number($config['uri_segment']),
				'cur_nav' => $this->access->set_current_nav('mc')
			);
			
			$this->load->view('base', $data);
		}
		function add($type){
			$name = $type == '1' ? 'Satuan' : 'Pulsa';
			
			$data = array(
				'cur_nav' => $this->access->set_current_nav('mc'),
				'title' => 'Al-Amin &raquo; Master Card &raquo; '.$name.' &raquo; Tambah Data',
				'title_inf' => array('master card'=>'master_card/index/'.$type,$name=>'master_card/index/'.$type,'tambah data'=>'master_card/add/'.$type),
				'type' => $type,
				'h1' => 'tambah data master card ('.$name.')',
				'type' => $type,
				'type_name' => $name,
				'container' => 'add_master_card',
				'kartu' => $this->mdl->get_kartu_data(),
				'data' => array(
					'kode_mc' => $this->input->post('kode_mc', true),
					'kode_kartu' => $this->input->post('kode_kartu'),
					'id_type' => $this->input->post('id_type'),
					'ket' => $this->input->post('ket', true),
					'hrg_dasar' => $this->input->post('hrg_dasar', true),
					'hrg_jual' => $this->input->post('hrg_jual', true),
					'saldo_satuan' => $this->input->post('saldo_satuan', true)
				)
			);
			
			if (empty($_POST)) {
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ','</span>');
				
				$this->form_validation->set_rules('kode_kartu','Nama Kartu','required');
				$this->form_validation->set_rules('kode_mc','Kode Master Card','required|trim|xss_clean');
				$this->form_validation->set_rules('ket','Keterangan Kode','required|trim');
				$this->form_validation->set_rules('hrg_dasar','Harga Dasar','required|numeric|trim');
				$this->form_validation->set_rules('hrg_jual','Harga Jual','required|numeric|trim');
				
				if ($type == 1) {
					$this->form_validation->set_rules('saldo_satuan','Saldo Satuan','required|numeric|trim');
				}
				
				if ($this->form_validation->run() == TRUE) {
					if ($this->mdl->check_kode($type, $data['data']['kode_mc']) == TRUE) {
						$this->access->add_logActivity('Penambahan data master card '.$name.' dengan kode master card <strong>'.$data['data']['kode_mc'].'</strong>');
						$this->mdl->add($data['data']);
						
						$this->session->set_flashdata('success_add','<span class="true">&raquo; Data master card berhasil di tambah.</span>');
						redirect('master_card/index/'.$type);
					}else{
						$this->session->set_flashdata('error_kode','<span class="error">&raquo; Kode Master Card yang anda masukkan sudah terdaftar sebelumnya!</span>');
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
		function edit($type,$id){
			$name = $type == '1' ? 'Satuan' : 'Pulsa';
			
			$data = array(
				'cur_nav' => $this->access->set_current_nav('mc'),
				'title' => 'Al-Amin &raquo; Master Card &raquo; '.$name.' &raquo; edit Data',
				'title_inf' => array('master card'=>'master_card/index/'.$type,$name=>'master_card/index/'.$type,'edit data'=>'master_card/add/'.$type.'/'.$id),
				'h1' => 'edit data master card ('.$name.')',
				'type' => $type,
				'type_name' => $name,
				'container' => 'edit_master_card',
				'kartu' => $this->mdl->get_kartu_data(),
				'fetch' => $this->mdl->get_once_data($id)
			);
			
			if (empty($_POST)) {
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ','</span>');
				
				$this->form_validation->set_rules('kode_kartu','Nama Kartu','required');
				$this->form_validation->set_rules('kode_mc','Kode','required|trim|xss_clean');
				$this->form_validation->set_rules('ket','Keterangan Kode','required|trim');
				$this->form_validation->set_rules('hrg_dasar','Harga Dasar','required|trim|numeric');
				$this->form_validation->set_rules('hrg_jual','Harga Jual','required|trim|numeric');
				
				if ($type == 1) {
					$this->form_validation->set_rules('saldo_satuan','Saldo Satuan','required|trim|numeric');
				}
				
				if ($this->form_validation->run() == TRUE) {
					$data['data'] = array(
						'kode_mc' => $this->input->post('kode_mc', true),
						'kode_kartu' => $this->input->post('kode_kartu'),
						'ket' => $this->input->post('ket', true),
						'hrg_dasar' => $this->input->post('hrg_dasar', true),
						'hrg_jual' => $this->input->post('hrg_jual', true),
						'saldo_satuan' => $this->input->post('saldo_satuan', true)
					);
					
					$this->access->add_logActivity('Edit data master card '.$name.' dengan kode master card <strong>'.$id.'</strong>');
					$this->mdl->update($id, $data['data']);
					$this->session->set_flashdata('success_edit','<span class="true">&raquo; Data berhasil diubah!</span>');
					
					redirect('master_card/edit/'.$type.'/'.$data['data']['kode_mc']);
				}else{
					$this->load->view('base', $data);
				}
			}
		}
		function delete($type,$id){
			$name = $type == '1' ? 'Satuan' : 'Pulsa';
			
			$this->access->add_logActivity('Penghapusan data master card '.$name.' dengan kode master card <strong>'.$id.'</strong>');
			$this->mdl->delete($id);
			
			$this->session->set_flashdata('success_delete','<span class="true">&raquo; Data master card berhasil dihapus.</span>');
			redirect('master_card/index/'.$type);
		}
		function sum_stock($type, $id){
			$data = array(
				'title' => 'Al-Amin &raquo; Master Card &raquo; Tambah Saldo satuan',
				'title_inf' => array('master card'=>'master_card/index/'.$type,'saldo satuan'=>'master_card/sum_stock/'.$type.'/'.$id),
				'cur_nav' => $this->access->set_current_nav('mc'),
				'h1'	=> 'Form Tambah saldo satuan',
				'container' => 'form_sum_stock_mc',
				'saldo_akhir' => $this->mdl->get_last_saldo($id)->saldo_satuan
			);
			
			if (empty($_POST)) {
				$this->load->view('base', $data);;
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ','</span>');
				
				$this->form_validation->set_rules('saldo','Tambahan saldo', 'required|numeric');
				
				if ($this->form_validation->run() === TRUE) {
					$this->access->add_logActivity('Penambahan saldo master card '.$name.' dengan kode master card <strong>'.$id.'</strong>'); 
					$this->mdl->stock_plus($id, $this->input->post('saldo'));
					
					$this->session->set_flashdata('sucess_edit', '<span class="true">&raquo; Saldo satuan berhasil ditambah.</span>');
					redirect('master_card/sum_stock/'.$type.'/'.$id);
				}else{
					$this->load->view('base', $data);
				}
			}	
		}
		
	}

?>