<?php

	Class M_perdana extends CI_Model{
		
		private $tbl = 'perdana';
		private $primary = 'id_per';
		
		function __construct(){
			parent::__construct();
		}
		function get_data($where,$offset,$limit){
			$this->db->select('A.*, B.kode_kartu, C.nama_type');
			$this->db->join('kartu AS B', 'A.kode_kartu = B.kode_kartu', 'INNER');
			$this->db->join('type_perdana AS C', 'A.id_type = C.id_type', 'INNER');
			
			if (!is_null($where)) {
				switch ($where['field']){
					case 'kode_kartu' :
						$this->db->where('B.'.$where['field'], $where['value']);
					break;
					case 'id_type' :
						$this->db->where('C.'.$where['field'], $where['value']);
					break;
					default :
						$this->db->like('A.'.$where['field'], $where['value']);
					break;
				}
			}
			
			$this->db->order_by('A.'.$this->primary, 'DESC');
			
			return $this->db->get($this->tbl.' AS A', $limit, $offset)->result();
		}
		function count_all($where){
			$this->db->select('A.*, B.kode_kartu, C.nama_type');
			$this->db->from($this->tbl.' AS A');
			$this->db->join('kartu AS B', 'A.kode_kartu = B.kode_kartu', 'INNER');
			$this->db->join('type_perdana AS C', 'A.id_type = C.id_type', 'INNER');
			
			if (!is_null($where)) {
				switch ($where['field']){
					case 'kode_kartu' :
						$this->db->where('B.'.$where['field'], $where['value']);
					break;
					case 'id_type' :
						$this->db->where('C.'.$where['field'], $where['value']);
					break;
					default :
						$this->db->like('A.'.$where['field'], $where['value']);
					break;
				}
			}
			
			return $this->db->count_all_results();
		}
		function get_other_table_data($table){
			return $this->db->get($table);
		}
		function add($data){
			return $this->db->insert($this->tbl, $data);
		}
		function delete($id){
			$this->db->where($this->primary, $id);
			return $this->db->delete($this->tbl);
		}
		function get_once_data($id){
			$this->db->select('A.*, B.kode_kartu');
			$this->db->join('kartu AS B', 'A.kode_kartu = B.kode_kartu', 'INNER');
			$this->db->where('A.'.$this->primary, $id);
			
			return $this->db->get($this->tbl.' AS A')->row();
		}
		function update($id, $param){
			$this->db->where($this->primary, $id);
			return $this->db->update($this->tbl, $param);
		}
		
	}

?>