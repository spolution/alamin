<?php

	Class M_voucher extends CI_Model{
		
		private $tbl = 'voucher';
		private $primary = 'id';
		
		function __construct(){
			parent::__construct();
		}
		function get_master_voucher_data(){
			$this->db->order_by('kode_vo','ASC');
			return $this->db->get('master_voucher');
		}
		function get_data($where,$offset,$limit){
			$this->db->select('A.*, B.kode_vo, B.ket');
			$this->db->join('master_voucher AS B', 'A.kode_vo = B.kode_vo', 'INNER');
			
				if ($where != NULL) {
					if ($where['field'] == 'kode_vo') {
						$this->db->where('A.'.$where['field'], $where['value']);
					}else{
						$this->db->like('A.'.$where['field'], $where['value']);
					}
				}
			
			$this->db->order_by('A.'.$this->primary, 'DESC');
			
			return $this->db->get($this->tbl.' AS A', $limit, $offset)->result();
		}
		function count_all($where){
			$this->db->select('A.*, B.kode_vo');
			$this->db->join('master_voucher AS B', 'A.kode_vo=B.kode_vo', 'INNER');
			
			if ($where != NULL) {
				if ($where['field'] == 'kode_vo') {
					$this->db->where('A.'.$where['field'], $where['value']);
				}else{
					$this->db->like('A.'.$where['field'], $where['value']);
				}
			}
			
			return $this->db->count_all_results($this->tbl.' AS A');
		}
		function ajax_get_master_voucher_data($id){
			$this->db->where('kode_vo', $id);
			$stt =  $this->db->get('master_voucher');
			
			if ($stt->num_rows() > 0) {
				$row = $stt->row();
				return $row->ket.'|'.$row->hrg_dasar.'|'.$row->hrg_jual;
			}else{
				return '';
			}
		}
		function add($value){
			return $this->db->insert($this->tbl, $value);
		}
		function delete($id){
			$this->db->where($this->primary, $id);
			return $this->db->delete($this->tbl);
		}
		
	}

?>