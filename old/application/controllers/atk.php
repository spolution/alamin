<?php

	Class Atk extends CI_Controller{
		
		function __construct(){
			parent::__construct();
			$this->access->is_logged_in();
			
			$this->load->helper('form');
			$this->load->model('m_atk', 'mdl', true);
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
				'base_url'		=> site_url('atk/index'),
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
				'title' => 'Al-Amin &raquo; List Penjualan ATK',
				'title_inf' => array('ATK'=>'atk','penjualan'=>'atk'),
				'h1' => 'list penjualan alat tulis kantor',
				'container' => 'list_atk',
				'data_type_atk' => $this->mdl->get_type_atk_data(),
				'fetch'	=> $this->mdl->get_data($where,$offset,$limit),
				'pagination' => $this->pagination->create_links(),
				'numb'	=> $this->access->get_start_number($config['uri_segment'])
			);
			
			$this->load->view('base', $data);
		}
		function add(){
			$data = array(
				'cur_nav' => $this->access->set_current_nav('penjualan'),
				'title' => 'Al-Amin &raquo; Form Penjualan ATK',
				'title_inf' => array('ATK'=>'atk','penjualan'=>'atk', 'tambah'=>'atk/add'),
				'h1' => 'form penjualan alat tulis kantor',
				'container' => 'add_atk',
				/*'master_atk' => $this->mdl->get_master_atk_data(),*/
				'type_atk' => $this->mdl->get_type_atk_data(),
				'data'	=> array(
					'id_ma'	=> $this->input->post('id_ma'),
					'qty'	=> $this->input->post('qty'),
					'stock'	=> ($this->input->post('stock') - $this->input->post('qty')),
					'tanggal' => $this->access->now(),
					'total_hrg' => ($this->input->post('qty') * $this->input->post('hrg_jual'))
				)
			);
			
			if (empty($_POST)){
				$this->load->view('base', $data);
			}else{
				$this->load->library('form_validation');
				$this->form_validation->set_error_delimiters('<span class="error">&raquo; ','</span>');
				
				$this->form_validation->set_rules('id_type', 'Jenis ATK', 'required|trim|numeric');
				$this->form_validation->set_rules('id_ma', 'Nama Barang', 'required|trim|numeric');
				$this->form_validation->set_rules('qty', 'Jumlah Jual', 'required|trim|numeric');
				
				if ($this->form_validation->run() == TRUE) {
					$this->mdl->add($data['data']);
				
					$this->session->set_flashdata('success_add','<span class="true">&raquo; Penjualan ATK berhasil diproses</span>');
					redirect('atk/add');
				}else{
					$this->load->view('base', $data);
				}
			}
		}
		function ajax_get_master_atk_data(){
			$id = $_POST['id_type'];
			$a = '<option value="">-- Pilih --</option>';
			
				foreach ($this->mdl->ajax_get_master_atk_data($id)->result() as $row) {
					$a .= '<option value="'.$row->id_ma.'">'.$row->nama_brg.'</option>';
				}
				
			echo json_encode($a);
		}
		function ajax_get_once_master_atk_data(){
			$id_ma = $_POST['id_ma'];
			echo json_encode($this->mdl->ajax_get_once_master_atk_data($id_ma));
		}
		function delete($id){
			$this->mdl->delete($id);
			
			$this->session->set_flashdata('success_delete', '<span class="true">&raquo; Data penjualan ATK berhasil dihapus.</span>');
			redirect('atk');
		}
		
	}

?>