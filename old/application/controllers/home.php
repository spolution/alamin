<?php	

	Class Home extends CI_Controller{
		
		private $data = array();
		
		function __construct(){
			parent::__construct();
			$this->access->is_logged_in();
			
			$this->load->model('m_home', 'mdl', true);
		}
		function index($offset = 0){
			$limit = 10;
			$config = array(
				'base_url'		=> site_url('home/index'),
				'uri_segment'	=> 3,
				'total_rows'	=> $this->mdl->count_all(),
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
				'cur_nav' => $this->access->set_current_nav('beranda'),
				'title' => 'Al-Amin &raquo; Sistem Aplikasi Counter Pulsa',
				'title_inf' => array('beranda'=>'home'),
				'h1' => 'Al-Amin cell &raquo; Log Activity',
				'container' => 'home',
				'log_list'	=> $this->mdl->fetch($offset,$limit)->result(),
				'numb'	=> $this->access->get_start_number($config['uri_segment']),
				'pagination' => $this->pagination->create_links()
			);
			
			$this->load->view('base', $data);
		}
		function about(){
			$data = array(
				'cur_nav' => $this->access->set_current_nav(null),
				'title' => 'Al-Amin &raquo; Tentang',
				'title_inf' => array('tentang'=>'home/about'),
				'h1' => 'tujuan pembuatan aplikasi',
				'container' => 'about'
			);
			
			$this->load->view('base', $data);
		}
		function help(){
			$data = array(
				'cur_nav' => $this->access->set_current_nav(null),
				'title' => 'Al-Amin &raquo; Bantuan',
				'title_inf' => array('bantuan'=>'home/help'),
				'h1' => 'Hal-hal penting di aplikasi',
				'container' => 'help'
			);
			
			$this->load->view('base', $data);
		}
		function contact(){
			$data = array(
				'cur_nav' => $this->access->set_current_nav(null),
				'title' => 'Al-Amin &raquo; Kontak',
				'title_inf' => array('kontak'=>'home/contact'),
				'h1' => 'Kontak Developer',
				'container' => 'contact'
			);
			
			$this->load->view('base', $data);
		}
		
	}

?>