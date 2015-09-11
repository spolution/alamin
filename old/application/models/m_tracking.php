<?php

	Class M_tracking extends CI_Model{
		
		private $primary = 'id_tr';
		private $tbl = 'tracking';
		public $saldo = 0;
		
		function __construct(){
			parent::__construct();
		}
		function set_saldo($value){
			return ($value == NULL ? $this->saldo = 0 : $this->saldo = $value);
		}
		function get_data($type,$where,$offset,$limit){
			$this->db->select('A.*, B.kode_mc, B.ket AS ket_mc, B.saldo_satuan');
			$this->db->join('master_card AS B', 'A.kode_mc = B.kode_mc', 'INNER');
			$this->db->where('B.id_type',$type);
			
				if ($where != null) {
					if ($where['field'] == 'kode_mc') {
						$this->db->where('A.'.$where['field'], $where['value']);
					}else{
						$this->db->like('A.'.$where['field'], $where['value']);
					}
				}
			
			$this->db->order_by('A.'.$this->primary, 'DESC');
			
			return $this->db->get($this->tbl.' AS A', $limit, $offset)->result();
		}
		function count_all($type,$where){
			$this->db->select('A.*, B.id_type');
			$this->db->from($this->tbl.' AS A');
			$this->db->join('master_card AS B', 'A.kode_mc=B.kode_mc', 'INNER');
			
				if ($where != null) {
					if ($where['field'] == 'kode_mc') {
						$this->db->where('A.'.$where['field'], $where['value']);
					}else{
						$this->db->like('A.'.$where['field'], $where['value']);
					}
				}
			
			$this->db->where('B.id_type', $type);
			
			return $this->db->count_all_results();
		}
		function get_member_data(){
			$this->db->order_by('nama', 'ASC');
			return $this->db->get('member');
		}
		function get_master_card_data($type){
			$this->db->where('id_type', $type);
			$this->db->order_by('kode_mc', 'ASC');
			
			return $this->db->get('master_card');
		}
		function ajax_get_master_card_name($id){
			$this->db->select('ket');
			$this->db->where('kode_mc', $id);
			
			$row = $this->db->get('master_card')->row();
			return $row->ket;
		}
		function ajax_get_member_data($id){
			$this->db->where('id_member', $id);
			
			$row = $this->db->get('member')->row();
			return $row->nama.'|'.$row->no_tlpn;
		}
		function add($data){
			$this->set_saldo(NULL);
			return $this->db->insert($this->tbl, $data);
		}
		function reduce_satuan_stock($kode_mc){
			$this->db->select('saldo_satuan');
			$this->db->where('kode_mc', $kode_mc);
			
			$row = $this->db->get('master_card')->row();
			$final = $row->saldo_satuan - 1;
			
			if ($final < 0) {
				return FALSE;
			}else{
				$this->set_saldo($final);
				
				$this->db->where('kode_mc', $kode_mc);
				$this->db->update('master_card',array('saldo_satuan'=>$final));
				
				return TRUE;
			}
		}
		function ajax_check_utang($no_hp){
			$this->db->select('ket');
			$this->db->from($this->tbl);
			$this->db->where('no_hp', $no_hp);
			$this->db->like('ket', 'tang');
			
			return ($this->db->count_all_results() > 0 ? 'utang' : 'none');
		}
		function reduce_pulsa_stock($kode_mc){
			$query = $this->db->query("
				SELECT A.kode_kartu, A.hrg_dasar, B.saldo_pulsa
					FROM master_card AS A
					INNER JOIN(kartu AS B)
					ON(A.kode_kartu = B.kode_kartu)
				WHERE A.kode_mc = '".$kode_mc."'
			");
			$row = $query->row();
			#proccessing reduce
			$final = $row->saldo_pulsa - $row->hrg_dasar;
			
			if ($final < 0) {
				return FALSE;
			}else{
				$this->set_saldo($final);
				
				$this->db->where('kode_kartu', $row->kode_kartu);
				$this->db->update('kartu', array('saldo_pulsa'=>$final));
				
				return TRUE;
			}
		}
		function delete($id){
			$this->db->where($this->primary, $id);
			return $this->db->delete($this->tbl);
		}
		function get_once_data($id){
			$this->db->where($this->primary, $id);
			return $this->db->get($this->tbl)->row();
		}
		function update($id,$value){
			$this->db->where($this->primary, $id);
			return $this->db->update($this->tbl, $value);
		}
		function get_last_data($type){
			$this->db->select('A.no_hp');
			$this->db->from($this->tbl.' AS A');
			$this->db->join('master_card AS B', 'A.kode_mc = B.kode_mc', 'INNER');
			$this->db->where('B.id_type', $type);
			$this->db->order_by($this->primary, 'DESC');
			$this->db->limit(1);
			
			$row = $this->db->get()->row();
			return $row->no_hp;
		}
		function get_hutang_data($where){
			$this->db->select('A.*, B.kode_mc, B.id_type, B.hrg_dasar, B.hrg_jual');
			$this->db->from($this->tbl.' AS A');
			$this->db->join('master_card AS B', 'A.kode_mc = B.kode_mc', 'INNER');
			$this->db->like('A.ket', 'tang');
			
				if ($where['field'] == 'nama') {
					$this->db->like('A.'.$where['field'], $where['q']);
				}else {
					$this->db->where('A.'.$where['field'], $where['q']);
				}
			
			$this->db->order_by('A.'.$this->primary, 'DESC');
			
			return $this->db->get()->result();
		}
		function ajax_heal_hutang($id_tr,$data){
			$this->db->where($this->primary, $id_tr);
			return $this->db->update($this->tbl, $data);
		}
		public function new_healHutang($id_tr, $params){
			$this->db->where($this->primary, $id_tr);
			return $this->db->update($this->tbl, $params);
		}
		
	}

?>