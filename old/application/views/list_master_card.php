
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/document.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>
<div class="item">

	<div onClick="window.location.href='<?php echo site_url('master_card/add/'.$type); ?>'" class="tools" id="t-1" onmouseover="get_effect('t-1')" onmouseout="remove_effect('t-1')" title="Tambah Data Master Card">
		<img src="<?php echo base_url('assets/img/button-add.png'); ?>" alt="add" />
	</div>
	<div class="tools search-control" id="t-2" onmouseover="get_effect('t-2')" onmouseout="remove_effect('t-2')" title="Pencarian" style="margin-top: 68px;">
		<img src="<?php echo base_url('assets/img/search.png'); ?>" alt="search" />
	</div>

	<?php
	
		if($this->session->flashdata('success_add')){
			echo $this->session->flashdata('success_add');
		}
		elseif($this->session->flashdata('success_delete')){
			echo $this->session->flashdata('success_delete');
		}
	
		echo form_open('master_card/index/'.$type,array('id'=>'form_search','style'=>'display: none;'));
	
	?>
	<table>
		<tr>
			<td>
				<select name='field'>
					<option value='kode_mc'>Kode</option>
					<option value='ket'>Keterangan</option>
					<option value='hrg_dasar'>Harga Dasar</option>
					<option value='hrg_jual'>Harga Jual</option>
				</select>
			</td>
			<td><?=form_input(array('name'=>'q'));?></td>
			<td><?=form_submit(array('name'=>'search','class'=>'radius','value'=>'Cari'));?></td>
		</tr>
	</table>
	<?php echo form_close(); ?>	

	<table class="list">
		<tr id="caption">
			<td>No</td>
			<td>Kode</td>
			<td>Nama Kartu</td>
			<td>Keterangan Kode</td>
			<td>Type</td>
			<td>Harga Dasar</td>
			<td>Harga Jual</td>
			<?php
			
				if ($type == 1) {
					echo "<td>Saldo ".$type_name."</td>";
				}	
			
			?>
			<td>Actions</td>
		</tr>
		<?php
			
			$x = 1;
			foreach ($fetch as $row) {
				$class = $x % 2 == 1 ? 'odd' : 'even';
				
				echo "
					<tr class='".$class."'>
						<td style='text-align: center;'>".$numb."</td>
						<td>".$row->kode_mc."</td>
						<td>".$row->nama_kartu."</td>
						<td>".$row->ket."</td>
						<td style='text-align: center;'>".$row->nama_type."</td>
						<td>Rp ".(number_format($row->hrg_dasar, 0, null, '.'))."</td>
						<td>Rp ".(number_format($row->hrg_jual, 0, null, '.'))."</td>";
				
					if ($type == 1) {
						echo "<td style='text-align: center;'>".$row->saldo_satuan."</td>";
					}
				
				echo "
						<td style='text-align: center;'>
							".($type == 1 ? anchor('master_card/sum_stock/'.$type.'/'.$row->kode_mc, '<img src="'.base_url('assets/img/edit_add.png').'" alt="add" />', 'title="Tambah Saldo"') : '')."
							".anchor('master_card/edit/'.$type.'/'.$row->kode_mc, '<img src="'.base_url('assets/img/edit.png').'" alt="edit" />','title="Edit"')."  
							".anchor('master_card/delete/'.$type.'/'.$row->kode_mc, '<img src="'.base_url('assets/img/failed.png').'" alt="delete" />', array('title'=>'Delete','onclick'=>"return confirm('Apakah anda yakin ingin menghapus data ini?');"))."
						</td>
					</tr>
				";
				
				$numb++;
				$x++;
			}
		
		?>
	</table>
</div>
<?php echo $pagination; ?>

<script type="text/javascript">
	$(function(){	
		$('select[name="field"]').change(function(){
			$('input[name="q"]').focus();
		});
	});
</script>