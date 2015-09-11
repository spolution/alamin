<?php

	Class M_atk extends CI_Model{
		
		private $tbl = 'atk';
		private $primary = 'id';
		
		function __construct(){
			parent::__construct();
		}
		function get_data($where,$offset,$limit){
			$this->db->select('A.*, B.nama_brg, C.nama_type');
			$this->db->join('master_atk AS B', 'A.id_ma=B.id_ma', 'INNER');
			$this->db->join('type_atk AS C', 'B.id_type=C.id_type', 'INNER');
			
				if (! is_null($where)) {
					switch ($where['field']){
						case 'id_type' :
							$this->db->where('B.'.$where['field'], $where['value']);
						break;
						case 'nama_brg' :
							$this->db->like('B.'.$where['field'], $where['value']);
						break;
						default:
							$this->db->like('A.'.$where['field'], $where['value']);
						break;
					}
				}
			
			$this->db->order_by('A.'.$this->primary, 'DESC');
			
			return $this->db->get($this->tbl.' AS A', $limit, $offset)->result();
		}
		function delete($id){
			$this->db->where($this->primary, $id);
			return $this->db->delete($this->tbl);
		}
		function count_all($where){
			$this->db->select('A.id, B.id_ma, C.id_type');
			$this->db->from($this->tbl.' AS A');
			$this->db->join('master_atk AS B', 'A.id_ma=B.id_ma', 'INNER');
			$this->db->join('type_atk AS C', 'B.id_type=C.id_type', 'INNER');
			
			if (! is_null($where)) {
				switch ($where['field']){
					case 'id_type' :
						$this->db->where('B.'.$where['field'], $where['value']);
					break;
					case 'nama_brg' :
						$this->db->like('B.'.$where['field'], $where['value']);
					break;
					default:
						$this->db->like('A.'.$where['field'], $where['value']);
					break;
				}
			}
			
			return $this->db->count_all_results();
		}
		function get_type_atk_data(){
			$this->db->order_by('nama_type', 'ASC');
			return $this->db->get('type_atk');
		}
		function get_master_atk_data(){
			$this->db->select('id_ma, nama_brg');
			$this->db->order_by('nama_brg', 'ASC');
			
			return $this->db->get('master_atk');
		}
		function ajax_get_master_atk_data($id_type){
			$this->db->select('id_ma, nama_brg');
			$this->db->where('id_type', $id_type);
			$this->db->order_by('nama_brg', 'ASC');
			
			return $this->db->get('master_atk');
		}
		function ajax_get_once_master_atk_data($id){
			$this->db->select('hrg_dasar, hrg_jual, stock');
			$this->db->where('id_ma', $id);
			
			$stt = $this->db->get('master_atk');
			if($stt->num_rows() > 0){
				$row = $stt->row();
				return $row->hrg_dasar.'|'.$row->hrg_jual.'|'.$row->stock;
			}else{
				return '';
			}
		}
		function add($data){
			$this->db->insert($this->tbl, $data);
			
			$this->db->where('id_ma', $data['id_ma']);
			return $this->db->update('master_atk', array('stock' => $data['stock']));
		}
		
	}

?>