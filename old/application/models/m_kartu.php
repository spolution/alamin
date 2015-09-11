<?php

	Class M_kartu extends CI_Model{
		
		private $tbl = 'kartu';
		private $primary = 'kode_kartu';
		
		function __construct(){
			parent::__construct();
		}
		function get_data($where){
			if ($where != NULL) {
				$this->db->like($where['field'], $where['value']);
			}
			
			$this->db->order_by($this->primary, 'ASC');
			return $this->db->get($this->tbl);
		}
		function delete($id){
			$this->db->where($this->primary, $id);
			return $this->db->delete($this->tbl);
		}
		function add($data){
			return $this->db->insert($this->tbl, $data);
		}
		function get_once_data($id){
			$this->db->where($this->primary, $id);
			return $this->db->get($this->tbl)->row();
		}
		function get_last_saldo($id){
			$this->db->select('saldo_pulsa');
			$this->db->where($this->primary, $id);
			
			return $this->db->get($this->tbl)->row();
		}
		function edit($id,$data){
			$this->db->where($this->primary, $id);
			return $this->db->update($this->tbl, $data);
		}
		function stock_plus($id, $val){
			/*$this->db->where($this->primary, $id);
			return $this->db->update($this->tbl, $data);*/
			return $this->db->query('
				UPDATE '.$this->tbl.'
					SET saldo_pulsa = saldo_pulsa + '.$val.'
				WHERE '.$this->primary.' = "'.$id.'"
			');
		}
		
	}

?>