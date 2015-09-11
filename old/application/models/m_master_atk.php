<?php

	Class M_master_atk extends CI_Model{
		
		private $tbl = 'master_atk';
		private $primary = 'id_ma';
		
		function __construct(){
			parent::__construct();
		}
		function get_data($where,$offset,$limit){
			$this->db->select('A.*, B.nama_type');
			$this->db->join('type_atk AS B', 'A.id_type = B.id_type');
			
				if (! is_null($where)) {
					switch ($where['field']){
						case 'id_type' :
							$this->db->where('A.'.$where['field'], $where['value']);
						break;
						default:
							$this->db->like('A.'.$where['field'], $where['value']);
						break;
					}
				}
			
			$this->db->order_by('A.nama_brg', 'ASC');
			
			return $this->db->get($this->tbl.' AS A', $limit, $offset)->result();
		}
		function count_all($where){
			$this->db->select('A.*');
			$this->db->from($this->tbl.' AS A');
			$this->db->join('type_atk AS B', 'A.id_type = B.id_type');
			
				if (! is_null($where)) {
					switch ($where['field']){
						case 'id_type' :
							$this->db->where('A.'.$where['field'], $where['value']);
						break;
						default:
							$this->db->like('A.'.$where['field'], $where['value']);
						break;
					}
				}
			
			$this->db->order_by('A.'.$this->primary, 'DESC');
			
			return $this->db->count_all_results();
		}
		function get_type_atk_data(){
			$this->db->order_by('id_type', 'ASC');
			return $this->db->get('type_atk');
		}
		function add($param){
			return $this->db->insert($this->tbl, $param);
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