
	<table class="list">
		<tr id="caption">
			<td>No</td>
			<td>Nomor HP</td>
			<td>Nama</td>
			<td>Kode</td>
			<td>Tanggal</td>
			<td>Saldo</td>
			<td>Action</td>
		</tr>
		<?php
		
			$x = 1; $hutang = 0;
			foreach ($fetch as $row) {
				$class = $x % 2 == 1 ? 'odd' : 'even';
				
				if ($data['field'] == 'no_hp') {
					$no_hp = str_replace($data['q'], '<b>'.$data['q'].'</b>', $row->no_hp);
					$nama = $row->nama;
				}else{
					$nama = str_replace(strtolower($data['q']), '<b>'.$data['q'].'</b>', strtolower($row->nama));
					$no_hp = $row->no_hp;
				}
				
				echo '
					<tr class="'.$class.'" id="tr-'.$row->id_tr.'">
						<td style="text-align: center;">'.$x.'</td>
						<td>'.$no_hp.'</td>
						<td>'.$nama.'</td>
						<td>'.$row->kode_mc.'</td>
						<td>'.$row->tanggal.'</td>
						<td>'.$row->saldo_smntr.'</td>
						<td style="text-align: center;">
							<a href="javascript:void(0)" title="Jadikan Lunas" onclick="heal_hutang(\''.$row->id_tr.'\', \''.$row->hrg_jual.'\')"><img src="'.base_url('assets/img/move.png').'" alt="heal" /></a>
						</td>
					</tr>
				';
				
				$hutang += $row->hrg_jual;
				$x++;
			}
	
		?>
		<tr>
			<td colspan='7' style="text-align: center;">
				<h2 style="font-size: 30px;">Total Hutang = <span style="color: #ff0000;" id="total-hutang"><?php echo $hutang ?></span></h2>
			</td>
		</tr>
	</table>