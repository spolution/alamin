<?php

	Class M_type_atk extends CI_Model{
		
		private $tbl = 'type_atk';
		private $primary = 'id_type';
		
		function __construct(){
			parent::__construct();
		}
		function get_data($where){
			if ($where != NULL) {
				$this->db->like('nama_type', $where);
			}
			
			$this->db->order_by($this->primary, 'DESC');
			return $this->db->get($this->tbl)->result();
		}
		function add($data){
			return $this->db->insert($this->tbl, $data);
		}
		function get_once_data($id){
			$this->db->where($this->primary, $id);
			return $this->db->get($this->tbl)->row();
		}
		function update($id, $param){
			$this->db->where($this->primary, $id);
			return $this->db->update($this->tbl, $param);
		}
		function delete($id){
			$this->db->where($this->primary, $id);
			return $this->db->delete($this->tbl);
		}
		
	}

?>