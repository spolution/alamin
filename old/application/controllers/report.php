<?php

	Class Report extends CI_Controller{
		
		private $total = array('count'=>0,'luck'=>0,'count_tang'=>0,'luck_tang'=>0,'sell_out'=>0);
		private $tot_per = array('count'=>0,'luck'=>0,'sell_out'=>0);
		private $luck = 0;
		
		private $time = array();
		
		function __construct(){
			parent::__construct();
			$this->access->is_logged_in();
			
			$this->load->helper('form');
		}
		function get_date_string(){
			$data = array(
				'01'=>'Januari','02'=>'Februari','03'=>'Maret','04'=>'April','05'=>'Mei','06'=>'Juni','07'=>'Juli',
				'08'=>'Agustus','09'=>'September','10'=>'Oktober','11'=>'November','12'=>'Desember'
			);
			
			return $data;
		}
		function index(){
			redirect('home');
		}
		function set_selected_date($when, $date1=null, $date2=null){
			if ($when == 'now') {
				$this->time[0] = "MID(A.tanggal, 1, 4) IN('".date('Y')."')";
				$this->time[1] = "MID(A.tanggal, 6, 2) IN('".date('m')."')";
				/*$this->db->where("MID(A.tanggal, 1, 4) IN('".date('Y')."')");
				$this->db->where("MID(A.tanggal, 6, 2) IN('".date('m')."')");*/
			}else{
				$this->time[0] = 'A.tanggal BETWEEN "'.$date1.'" AND "'.substr($date2, 0, 8).(substr($date2, 8, 2)).'"';
				//$this->db->where('A.tanggal BETWEEN "'.$date1.'" AND "'.$date2.'"');
			}
			
			return $this->time;
		}
		function costumize(){
			$data = array(
				'cur_nav' => $this->access->set_current_nav('lap'),
				'title' => 'Al-Amin &raquo; Form Pembuatan Laporan',
				'title_inf' => array('laporan'=>'report/costumize'),
				'h1' => 'Form pembuatan laporan',
				'container' => 'form_report',
				'data' => array(
					'tgl_1' => $this->input->post('tgl_1'),
					'tgl_2' => $this->input->post('tgl_2')
				)
			);
			
			$this->load->view('base', $data);
		}
		function create(){
			/*$tgl_1 = $this->input->post('tgl_1');
			$tgl_2 = $this->input->post('tgl_2');
			
			$this->set_selected_date('cos', $tgl_1, $tgl_2);
			
			echo $this->time['0'];*/
			$this->load->database();
			
			if (empty($_POST)) {
				$this->access->add_logActivity('Cetak laporan terakhir bulan ini. ('.date('M Y').')');
				$this->set_selected_date('now');
			}else{
				$tgl_1 = $this->input->post('tgl_1');
				$tgl_2 = $this->input->post('tgl_2');
				
				if (! empty($tgl_1) && ! empty($tgl_2)) {
					$this->access->add_logActivity('Cetak laporan berdasarkan tanggal yang ditentukan, <strong>'.$tgl_1.' - '.$tgl_2.'</strong>');
					$this->set_selected_date('cos', $tgl_1, $tgl_2);
				}else{
					$this->session->set_flashdata('free', '<span class="error">&raquo; Field tanggal pertama dan kedua harus diisi!</span>');
					redirect('report/costumize');
				}
			}
			
			$data = $this->get_date_string();
			$count = count($this->time);
			
			echo "<html><head><title>Laporan ".($count == 2 ? 'bulan ke - '.date('m').'('.$data[date('m')].') '.date('Y') : 'dari tanggal '.$tgl_1.' sampai '.$tgl_2)."</title></head><style type='text/css'>";
			echo "<!--body{padding-top: 10px; margin: 5px; font-family:Verdana;font-size:11px;}table{box-shadow: 2px 5px 8px #c2c1c1; border-collapse: collapse; font-size:11px;}table tr td{ padding: 3px; }table.final{color:#1361aa;font-size:12px;}h1{color:#ff0000;}-->";
			echo "</style><body><center><h1>Laporan ".($count == 2 ? 'bulan '.$data[date('m')].' '.date('Y') : 'dari tanggal '.$tgl_1.' sampai '.$tgl_2)."</h1><hr style='border: 2px dashed #1361aa;'></center>";
					
			$this->create_trackingReport(1);
			$this->create_trackingReport(2);
				
			$this->db->select('A.ket, B.hrg_dasar, B.hrg_jual');
			$this->db->from('tracking AS A');
				foreach ($this->time as $val){
					$this->db->where($val);
				}
			$this->db->join('master_card AS B', 'A.kode_mc = B.kode_mc', 'INNER');
			$this->db->like('A.ket','false');
			$this->db->order_by('A.id_tr','DESC');
			
			$stt = $this->db->get();
			
			$false = 0;
			foreach ($stt->result() as $row) {
				$false += $row->hrg_dasar;
			}
					
					echo "<center>
						<table class='final'>
							<tr>
								<td>Total Tracking</td>
								<td>:</td>
								<td>".$this->total['count']."x</td>
							</tr>
							<tr>
								<td>Total Keuntungan</td>
								<td>:</td>
								<td>Rp ".(number_format($this->total['luck'], 0, null, '.'))."</td>
							</tr>
							<tr>
								<td>Total Hutang</td>
								<td>:</td>
								<td>".$this->total['count_tang']."x | Rp ".(number_format($this->total['luck_tang'], 0, null, '.'))."</td>
							</tr>
							<tr>
								<td>Total Sell Out</td>
								<td>:</td>
								<td>Rp ".(number_format($this->total['sell_out'], 0, null, '.'))."</td>
							</tr>
							<tr>
								<td>Total Salah Kirim</td>
								<td>:</td>
								<td>Rp ".(number_format($false, 0, null, '.'))."</td>
							</tr>
						</table>
					</center>";
					$this->luck += $this->total['luck'];
					
					$this->create_voucherReport();
					$this->create_perdanaReport(1);
					$this->create_perdanaReport(2);
					
					echo "<center>
						<table class='final'>
							<tr>
								<td>Total Penjualan Kartu Perdana</td>
								<td>:</td>
								<td>".$this->tot_per['count']."x</td>
							</tr>
							<tr>
								<td>Total Keuntungan</td>
								<td>:</td>
								<td>Rp ".(number_format($this->tot_per['luck'], 0, null, '.'))."</td>
							</tr>
							<tr>
								<td>Total Sell Out</td>
								<td>:</td>
								<td>Rp ".(number_format($this->tot_per['sell_out'], 0, null, '.'))."</td>
							</tr>
						</table>
					</center>";
					
					$this->create_aksesorisReport();
					$this->create_atkReport();
					
					echo "<p>&nbsp;</p><center>
						<h2 >Total keuntungan ".($count == 2 ? 'bulan '.$data[date('m')].' '.date('Y') : 'dari tanggal '.$tgl_1.' sampai '.$tgl_2)." adalah :<br /><span style='color: #ff0000;'>Rp ".number_format($this->luck, 0, null, '.')."</span></h2><p>&nbsp;</p>";
					echo '<script type="text/javascript">
						if(window.print){
							document.write("<button onClick=\'window.print();\'>Cetak Ke Printer</button>");
						}
					</script></center>';
					
					echo "</body></html>";
		}
		function create_trackingReport($tipe){
			$type['numb'] = $tipe;
			$type['desc'] = $tipe == 1 ? 'Satuan' : 'Pulsa';
			
			echo "<h4>Penjualan Pulsa Elektrik ".$type['desc']." :</h4>";
			echo "<table border='1'><tr>";
					
			$x = 1; $total = array('count'=>0,'luck'=>0,'sell_out'=>0,'count_tang'=>0,'luck_tang'=>0);
			$stt = $this->db->get('kartu');
			foreach ($stt->result() as $row) {
				
				echo "<td align='left' valign='top'>";
				echo $x.". ".$row->nama_kartu."(".$row->kode_kartu.") : <ul>";
				
				$this->db->select('A.nama, A.no_hp, B.id_type, B.hrg_dasar, B.hrg_jual, C.nama_kartu');
				$this->db->from('tracking AS A');
				$this->db->join('master_card AS B', 'A.kode_mc=B.kode_mc', 'INNER');
				$this->db->join('kartu AS C', 'B.kode_kartu=C.kode_kartu', 'INNER');
				$this->db->where('B.id_type = '.$type['numb']);
				$this->db->where('B.kode_kartu = "'.$row->kode_kartu.'"');
					foreach ($this->time as $val){
						$this->db->where($val);
					}
				$this->db->not_like('A.ket', 'tang');
				$this->db->where('A.ket !=','false');
				$this->db->order_by('A.id_tr', 'DESC');
						
				$query = $this->db->get();

				$count = 0; $luck = 0; $sell_out = 0;
				foreach ($query->result() as $val) {
					$luck += ($val->hrg_jual - $val->hrg_dasar);
					$sell_out += $val->hrg_dasar;
					$count++;
				}
				
				echo "<li>Total = ".$count."x Track</li>";
				echo "<li>Keuntungan = Rp ".(number_format($luck, 0, null, '.'))."</li>";
				echo "<li>Sell Out = Rp ".(number_format($sell_out, 0, null, '.'))."</li>";
						
				echo "</ul> </td>";
				$x++; $total['count'] += $count; $total['luck'] += $luck; $total['sell_out'] += $sell_out;
			}
			
			echo "</tr></table>";
			
			$this->db->select('A.ket,A.tanggal,B.hrg_dasar,B.hrg_jual');
			$this->db->join('master_card AS B', 'A.kode_mc = B.kode_mc');
				foreach ($this->time as $val){
					$this->db->where($val);
				}
			$this->db->where('B.id_type', $type['numb']);
			$this->db->like('A.ket', 'tang');
			$stt_tang = $this->db->get('tracking AS A');
			
			foreach ($stt_tang->result() as $row_tang) {
				$total['count_tang']++;
				$total['luck_tang'] += $row_tang->hrg_dasar;
			}
			
			echo "<ul>
				<li>Total Tracking ".$type['desc']." = <b>".$total['count']."</b></li>
				<li>Total Keuntungan = <b>Rp ".(number_format($total['luck'], 0, null, '.'))."</b></li>
				<li>Total Hutang = <b>".$total['count_tang']."x Track | Rp ".(number_format($total['luck_tang'], 0, null, '.'))."</b></li>
				<li>Total Sell Out = <b>Rp ".(number_format($total['sell_out'], 0, null, '.'))."</b></li>
			</ul>";
			
			$this->total['count'] += $total['count'];
			$this->total['luck'] += $total['luck'];
			$this->total['count_tang'] += $total['count_tang'];
			$this->total['luck_tang'] += $total['luck_tang'];
			$this->total['sell_out'] += $total['sell_out'];

		}
		function create_voucherReport(){
			echo "<h4>Penjualan Voucher :</h4>";
			echo "<table border='1'><tr>";
			
			$stt = $this->db->get('kartu'); $x = 1;
			$total = array('count'=>0,'luck'=>0,'sell_out'=>0);
			
			foreach ($stt->result() as $row) {
				echo "<td align='left' valign='top'>";
				echo $x.". ".$row->nama_kartu."(".$row->kode_kartu.") : <ul>";
				
					$this->db->select('A.kode_vo, A.tanggal, B.kode_kartu, B.hrg_dasar, B.hrg_jual');
					$this->db->join('master_voucher AS B', 'A.kode_vo=B.kode_vo', 'INNER');
					$this->db->where('B.kode_kartu', $row->kode_kartu);
						foreach ($this->time as $val){
							$this->db->where($val);
						}
					$this->db->order_by('A.id', 'DESC');
					
					$count = 0; $luck = 0; $sell_out = 0;
					$query = $this->db->get('voucher AS A');
					foreach ($query->result() as $val) {
						$count++;
						$luck += ($val->hrg_jual - $val->hrg_dasar);
						$sell_out += $val->hrg_dasar;
					}
				
				echo "<li>Total = ".$count."x Pembelian</li>";
				echo "<li>Keuntungan = Rp ".(number_format($luck, 0, null, '.'))."</li>";
				echo "<li>Sell Out = Rp ".(number_format($sell_out, 0, null, '.'))."</li>";
						
				echo "</ul> </td>"; $x++;
				
				$total['count'] += $count;
				$total['luck'] += $luck;
				$total['sell_out'] += $sell_out;
			}
			
			echo "</tr></table><br />";
			
			echo "<center>
						<table class='final'>
							<tr>
								<td>Total Penjualan Voucher</td>
								<td>:</td>
								<td>".$total['count']."x</td>
							</tr>
							<tr>
								<td>Total Keuntungan</td>
								<td>:</td>
								<td>Rp ".(number_format($total['luck'], 0, null, '.'))."</td>
							</tr>
							<tr>
								<td>Total Sell Out</td>
								<td>:</td>
								<td>Rp ".(number_format($total['sell_out'], 0, null, '.'))."</td>
							</tr>
						</table>
					</center>";
			
			$this->luck += $total['luck'];
		}
		function create_perdanaReport($type){
			$tipe = array('numb'=>$type,'desc'=>($type == 1 ? 'Biasa' : 'Cantik'));
			
			echo "<h4>Penjualan Kartu Perdana(".$tipe['desc']."):</h4>";
			echo "<table border='1'><tr>";
			
			$stt = $this->db->get('kartu'); $x = 1;
			$total = array('count'=>0,'luck'=>0,'sell_out'=>0);
			
			foreach ($stt->result() as $row) {
				echo "<td align='left' valign='top'>";
				echo $x.". ".$row->nama_kartu."(".$row->kode_kartu.") : <ul>";
				
					$this->db->select('A.hrg_dasar, A.hrg_jual');
					$this->db->join('type_perdana AS B', 'A.id_type=B.id_type', 'INNER');
					$this->db->where('A.kode_kartu', $row->kode_kartu);
					$this->db->where('A.id_type', $tipe['numb']);
						foreach ($this->time as $val){
							$this->db->where($val);
						}
					$this->db->order_by('A.id_per', 'DESC');
					
					$count = 0; $luck = 0; $sell_out = 0;
					$query = $this->db->get('perdana AS A');
					foreach ($query->result() as $val) {
						$count++;
						$luck += ($val->hrg_jual - $val->hrg_dasar);
						$sell_out += $val->hrg_dasar;
					}
				
				echo "<li>Total = ".$count."x Pembelian</li>";
				echo "<li>Keuntungan = Rp ".(number_format($luck, 0, null, '.'))."</li>";
				echo "<li>Sell Out = Rp ".(number_format($sell_out, 0, null, '.'))."</li>";
						
				echo "</ul> </td>"; $x++;
				
				$total['count'] += $count;
				$total['luck'] += $luck;
				$total['sell_out'] += $sell_out;
			}
			
			echo "</tr></table>";
			
			echo "<ul>
				<li>Total Penjualan Kartu Perdana(".$tipe['desc'].") = <b>".$total['count']."</b></li>
				<li>Total Keuntungan = <b>Rp ".(number_format($total['luck'], 0, null, '.'))."</b></li>
				<li>Total Sell Out = <b>Rp ".(number_format($total['sell_out'], 0, null, '.'))."</b></li>
			</ul>";
			
			$this->tot_per['count'] += $total['count'];
			$this->tot_per['luck'] += $total['luck'];
			$this->tot_per['sell_out'] += $total['sell_out'];
			
			$this->luck += $total['luck'];
		}
		function create_aksesorisReport(){
			echo "<h4>Penjualan Aksesoris :</h4>";
			echo "<table border='1'>";
			
			$total = array('count'=>0,'luck'=>0,'sell_out'=>0); $x = 1;
			$stt = $this->db->get('type_aksesoris');
			
			foreach ($stt->result() as $row) {
				if($x%7 == 0 || $x == 1){
					echo "<tr>";
				}
				
				echo "<td align='left' valign='top'>";
				echo $x.". ".$row->nama_type." : <ul>";
				
					$this->db->select('B.hrg_dasar, B.hrg_jual');
					$this->db->join('master_aksesoris AS B', 'A.id_ma=B.id_ma', 'INNER');
					$this->db->where('B.id_type', $row->id_type);
						foreach ($this->time as $val){
							$this->db->where($val);
						}
					$this->db->order_by('A.id', 'DESC');
					
					$count = 0; $luck = 0; $sell_out = 0;
					$query = $this->db->get('aksesoris AS A');
					foreach ($query->result() as $val) {
						$count++;
						$luck += ($val->hrg_jual - $val->hrg_dasar);
						$sell_out += $val->hrg_dasar;
					}
				
				echo "<li>Total = ".$count."x Pembelian</li>";
				echo "<li>Keuntungan = Rp ".(number_format($luck, 0, null, '.'))."</li>";
				echo "<li>Sell Out = Rp ".(number_format($sell_out, 0, null, '.'))."</li>";
				echo "</ul> </td>"; $x++;
				
				if($x%7 == 0 || $x == 1){
					echo "</tr>";
				}
				
				$total['count'] += $count;
				$total['luck'] += $luck;
				$total['sell_out'] += $sell_out;
			}
			
			echo "</table><br />";
			
			echo "<center>
						<table class='final'>
							<tr>
								<td>Total Penjualan Aksesoris</td>
								<td>:</td>
								<td>".$total['count']."x</td>
							</tr>
							<tr>
								<td>Total Keuntungan</td>
								<td>:</td>
								<td>Rp ".(number_format($total['luck'], 0, null, '.'))."</td>
							</tr>
							<tr>
								<td>Total Sell Out</td>
								<td>:</td>
								<td>Rp ".(number_format($total['sell_out'], 0, null, '.'))."</td>
							</tr>
						</table>
					</center>";
			
			$this->luck += $total['luck'];
		}
		function create_atkReport(){
			echo "<h4>Penjualan Alat Tulis Kantor :</h4>";
			echo "<table border='1'>";
			
			$total = array('count'=>0,'luck'=>0,'sell_out'=>0,'item'=>0); $x = 1;
			$stt = $this->db->get('type_atk');
			
			foreach ($stt->result() as $row) {
				if($x%7 == 0 || $x == 1){
					echo "<tr>";
				}
				
				echo "<td align='left' valign='top'>";
				echo $x.". ".$row->nama_type." : <ul>";
				
					$this->db->select('A.qty, B.hrg_dasar, B.hrg_jual');
					$this->db->join('master_atk AS B', 'A.id_ma=B.id_ma', 'INNER');
					$this->db->where('B.id_type', $row->id_type);
						foreach ($this->time as $val){
							$this->db->where($val);
						}
					$this->db->order_by('A.id', 'DESC');
					
					$count = 0; $luck = 0; $sell_out = 0; $item = 0;
					$query = $this->db->get('atk AS A');
					foreach ($query->result() as $val) {
						$count++; $item += $val->qty;
						$luck += ($val->hrg_jual - $val->hrg_dasar) * $val->qty;
						$sell_out += $val->hrg_dasar * $val->qty;
					}
				
				echo "<li>Total = ".$count."x Penjualan</li>";
				echo "<li>Total item terjual = ".$item." Item</li>";
				echo "<li>Keuntungan = Rp ".(number_format($luck, 0, null, '.'))."</li>";
				echo "<li>Sell Out = Rp ".(number_format($sell_out, 0, null, '.'))."</li>";
				echo "</ul> </td>"; $x++;
				
				if($x%7 == 0 || $x == 1){
					echo "</tr>";
				}
				
				$total['count'] += $count;
				$total['luck'] += $luck;
				$total['sell_out'] += $sell_out;
				$total['item'] += $item;
			}
			
			echo "</table><br />";
			
			echo "<center>
						<table class='final'>
							<tr>
								<td>Total Penjualan Aksesoris</td>
								<td>:</td>
								<td>".$total['count']."x</td>
							</tr>
							<tr>
								<td>Total Item Terjual</td>
								<td>:</td>
								<td>".$total['item']." Item</td>
							</tr>
							<tr>
								<td>Total Keuntungan</td>
								<td>:</td>
								<td>Rp ".(number_format($total['luck'], 0, null, '.'))."</td>
							</tr>
							<tr>
								<td>Total Sell Out</td>
								<td>:</td>
								<td>Rp ".(number_format($total['sell_out'], 0, null, '.'))."</td>
							</tr>
						</table>
					</center>";
			
			$this->luck += $total['luck'];
		}
		
	}

?>