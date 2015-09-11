<?php

	Class M_master_voucher extends CI_Model{
		
		private $tbl = 'master_voucher';
		private $primary = 'kode_vo';
		
		function __construct(){
			parent::__construct();
		}
		function get_data($where){
			$this->db->select('A.*, B.nama_kartu');
			$this->db->from($this->tbl.' AS A');
			$this->db->join('kartu AS B', 'A.kode_kartu = B.kode_kartu', 'INNER');
			
				if ($where != NULL) {
					if ($where['field'] == 'kode_kartu') {
						$this->db->where('A.kode_kartu', $where['value']);
					}else{
						$this->db->like('A.'.$where['field'], $where['value']);
					}
				}
			
			$this->db->order_by('A.'.$this->primary, 'DESC');
			
			return $this->db->get()->result();
		}
		function get_kartu_data(){
			$this->db->select('kode_kartu,nama_kartu');
			$this->db->order_by('kode_kartu', 'ASC');
			
			return $this->db->get('kartu');
		}
		function ajax_get_shortcut_name($id){
			$this->db->select('nama_kartu,kode_kartu');
			$this->db->where('kode_kartu', $id);
			
			$row = $this->db->get('kartu')->row();
			return $row->nama_kartu.'|'.$row->kode_kartu;
		}
		function check_kode($kode){
			$this->db->select('kode_vo');
			$this->db->where('kode_vo', $kode);
			$query = $this->db->get($this->tbl);
			
			if ($query->num_rows() > 0) {
				return FALSE;
			}else{
				return TRUE;
			}
		}
		function add($data){
			return $this->db->insert($this->tbl, $data);
		}
		function get_once_data($id){
			$this->db->where($this->primary, $id);
			return $this->db->get($this->tbl)->row();
		}
		function update($id,$value){
			$this->db->where($this->primary, $id);
			return $this->db->update($this->tbl, $value);
		}
		function delete($id){
			$this->db->where($this->primary, $id);
			return $this->db->delete($this->tbl);
		}
		
	}

?>