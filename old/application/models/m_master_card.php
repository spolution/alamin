<?php

	Class M_master_card extends CI_Model{
		
		private $primary = 'kode_mc'; private $tbl = 'master_card';
		
		function __construct(){
			parent::__construct();
		}
		function get_data($type,$where,$offset,$limit){
			$this->db->select('A.*, B.nama_kartu, C.nama_type');
			$this->db->join('kartu AS B', 'A.kode_kartu = B.kode_kartu', 'INNER');
			$this->db->join('type AS C', 'A.id_type = C.id_type', 'INNER');
			$this->db->where('A.id_type',$type);
			
				if ($where != null) {
					if ($where['field'] == 'hrg_dasar' || $where['field'] == 'hrg_jual') {
						$this->db->where('A.'.$where['field'], $where['value']);
					}else{
						$this->db->like('A.'.$where['field'], $where['value']);
					}
				}
			
			$this->db->order_by($this->primary, 'ASC');
			
			return $this->db->get($this->tbl.' AS A', $limit, $offset)->result();
		}
		function stock_plus($id, $val){
			return $this->db->query('
				UPDATE '.$this->tbl.'
					SET saldo_satuan = saldo_satuan + '.$val.'
				WHERE '.$this->primary.' = "'.$id.'"
			');
		}
		function get_last_saldo($id){
			$this->db->select('saldo_satuan');
			$this->db->where($this->primary, $id);
			
			return $this->db->get($this->tbl)->row();
		}
		function count_all($type,$where){
			if ($where != null) {
				if ($where['field'] == 'hrg_dasar' || $where['field'] == 'hrg_jual') {
					$this->db->where($where['field'], $where['value']);
				}else{
					$this->db->like($where['field'], $where['value']);
				}
			}
			
			$this->db->where('id_type', $type);
			$this->db->from($this->tbl);
			
			return $this->db->count_all_results();
		}
		function get_kartu_data(){
			$this->db->order_by('nama_kartu','ASC');
			return $this->db->get('kartu');
		}
		function ajax_get_shortcut_name($id){
			$this->db->select('nama_kartu,kode_kartu');
			$this->db->where('kode_kartu', $id);
			$query = $this->db->get('kartu');
			
			if($query->num_rows() > 0){
				$row = $query->row();
				return $row->nama_kartu.'|'.$row->kode_kartu;
			}else{
				return NULL;
			}
		}
		function add($data){
			return $this->db->insert($this->tbl, $data);
		}
		function check_kode($type, $kode){
			$this->db->select($this->primary);
			$this->db->where($this->primary, $kode);
			$this->db->where('id_type', $type);
			
			$query = $this->db->get($this->tbl);
			
			if ($query->num_rows() > 0) {
				return FALSE;
			}else{
				return TRUE;
			}
		}
		function get_once_data($id){
			$this->db->where($this->primary, $id);
			return $this->db->get($this->tbl)->row();
		}
		function update($id,$param){
			$this->db->where($this->primary, $id);
			return $this->db->update($this->tbl, $param);
		}
		function delete($id){
			$this->db->where($this->primary, $id);
			return $this->db->delete($this->tbl);
		}
		
	}

?>