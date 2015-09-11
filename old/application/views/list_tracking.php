
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/chart-area-up.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>
<div class="item">

	<div onClick="window.location.href='<?php echo site_url('tracking/add/'.$type); ?>'" class="tools" id="t-1" onmouseover="get_effect('t-1')" onmouseout="remove_effect('t-1')" title="Track Baru">
		<img src="<?php echo base_url('assets/img/button-add.png'); ?>" alt="add" />
	</div>
	<div class="tools search-control" id="t-2" onmouseover="get_effect('t-2')" onmouseout="remove_effect('t-2')" title="Pencarian" style="margin-top: 68px;">
		<img src="<?php echo base_url('assets/img/search.png'); ?>" alt="search" />
	</div>
	
	<?php
	
		if($this->session->flashdata('success_delete')){
			echo $this->session->flashdata('success_delete');
		}elseif($this->session->flashdata('error_stock')){
			echo $this->session->flashdata('error_stock');
		}
		
		if(empty($_POST)){ echo $pagination; }
		echo form_open('tracking/index/'.$type,array('id'=>'form_search','style'=>'display:none;'));
	
	?>

	<table>
		<tr>
			<td>
				<select name='field'>
					<option value='nama'>Nama</option>
					<option value='kode_mc'>Kode Master Card</option>
					<option value='no_hp'>Nomor Handphone</option>
					<option value='tanggal'>Tanggal Penjualan</option>
					<option value='ket'>Keterangan</option>
				</select>
			</td>
			<td>
				<select name='kode_mc' style='display:none;'>
					<?php
					
						foreach ($master_card->result() as $row){
							echo "<option value='".$row->kode_mc."'>".$row->kode_mc."</option>";
						}
					
					?>
				</select>
				<?php
					echo form_input(array('name'=>'q')).
						 form_input(array('name'=>'tgl','onmouseover'=>'get_datePlugin(\'tgl\')','style'=>'display:none;'));
				?>
			</td>
			<td><?=form_submit(array('name'=>'search','class'=>'radius','value'=>'cari'));?></td>
		</tr>
	</table>
	<?php echo form_close();?>
	
	<table class="list">
		<tr id="caption">
			<td>No</td>
			<td>Nomor HP</td>
			<td>Nama</td>
			<td>Kode</td>
			<td>Tanggal</td>
			<td>Saldo</td>
			<td>Keterangan</td>
			<td>Actions</td>
		</tr>
		<?php
			
			$x = 1;
			foreach ($fetch as $row) {
				$class = $x % 2 == 1 ? 'odd' : 'even';
				
				echo "
					<tr class='".$class."' style='text-align: center;'>
						<td>".$numb."</td>
						<td>".$row->no_hp."</td>
						<td>".(empty($row->nama) ? '-' : $row->nama)."</td>
						<td>".$row->kode_mc."</td>
						<td>".$row->tanggal."</td>
						<td>".($type == '2' ? 'Rp '.(number_format($row->saldo_smntr, 0, null, '.')) : $row->saldo_smntr)."</td>
						<td>".(empty($row->ket) ? '-' : $row->ket)."</td>
						<td>
							".anchor('tracking/edit/'.$type.'/'.$row->id_tr, '<img src="'.base_url('assets/img/edit.png').'" alt="edit" />','title="Edit"')."  
							".anchor('tracking/delete/'.$type.'/'.$row->id_tr, '<img src="'.base_url('assets/img/failed.png').'" alt="delete" />', array('title'=>'Delete','onclick'=>"return confirm('Apakah anda yakin ingin menghapus data ini?');"))."
						</td>
					</tr>
				";
				
				$numb++;
				$x++;
			}
		
		?>
	</table>
	
	<?php if(empty($_POST)){ echo $pagination; } ?>
</div>

<script type="text/javascript">

	$(function(){	
		$('select[name="field"]').change(function(){
			var value = $('select[name="field"]').val();
			
			if(value == 'kode_mc'){
				$('select[name="kode_mc"]').slideDown();
				$('input[name="q"]').slideUp();
				$('input[name="tgl"]').slideUp();
			}else if(value == 'tanggal'){
				$('input[name="tgl"]').slideDown();
				$('select[name="kode_mc"]').slideUp();
				$('input[name="q"]').slideUp();
			}else{
				$('input[name="tgl"]').slideUp();
				$('select[name="kode_mc"]').slideUp();
				$('input[name="q"]').slideDown();
			}
		});		
	});
	
</script>