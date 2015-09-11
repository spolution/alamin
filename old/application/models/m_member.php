<?php

	Class M_member extends CI_Model{
		
		private $primary = 'id_member';
		private $tbl = 'member';
		
		function __construct(){
			parent::__construct();
		}
		function get_data(){
			$this->db->order_by('nama', 'ASC');
			return $this->db->get($this->tbl)->result();
		}
		function add($data){
			return $this->db->insert($this->tbl, $data);
		}
		function get_once_data($id){
			$this->db->where($this->primary, $id);
			return $this->db->get($this->tbl)->row();
		}
		function update($id, $val){
			$this->db->where($this->primary, $id);
			return $this->db->update($this->tbl, $val);
		}
		function delete($id){
			$this->db->where($this->primary, $id);
			return $this->db->delete($this->tbl);
		}
		
	}

?>