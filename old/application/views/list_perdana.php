
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/chart-area-up.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>
<div class="item">

	<div onClick="window.location.href='<?php echo site_url('perdana/add'); ?>'" class="tools" id="t-1" onmouseover="get_effect('t-1')" onmouseout="remove_effect('t-1')" title="Ke Form Penjualan Kartu Perdana">
		<img src="<?php echo base_url('assets/img/button-add.png'); ?>" alt="add" />
	</div>
	<div class="tools search-control" id="t-2" onmouseover="get_effect('t-2')" onmouseout="remove_effect('t-2')" title="Pencarian" style="margin-top: 68px;">
		<img src="<?php echo base_url('assets/img/search.png'); ?>" alt="search" />
	</div>
	
	<?php
	
		if($this->session->flashdata('success_delete')){
			echo $this->session->flashdata('success_delete');
		}elseif($this->session->flashdata('success_add')){
			echo $this->session->flashdata('success_add');
		}
		
		if(empty($_POST)){ echo $pagination; }
		echo form_open('perdana',array('id'=>'form_search','style'=>'display:none;'));
	
	?>

	<table>
		<tr>
			<td>
				<select name='field' id='field'>
					<option value='nomor'>Nomor</option>
					<option value='kode_kartu'>Kode Kartu</option>
					<option value='id_type'>Tipe</option>
					<option value='hrg_dasar'>Harga Dasar</option>
					<option value='hrg_jual'>Harga Jual</option>
					<option value='tanggal'>Tanggal Penjualan</option>
				</select>
			</td>
			<td>
				<select name='kode_kartu' id='kode_kartu' style='display:none;'>
					<?php
					
						foreach ($kartu->result() as $row){
							echo "<option value='".$row->kode_kartu."'>".$row->kode_kartu."</option>";
						}
					
					?>
				</select>
				<select name='id_type' id='id_type' style='display:none;'>
					<?php
					
						foreach ($type_perdana->result() as $row){
							echo "<option value='".$row->id_type."'>".$row->nama_type."</option>";
						}
					
					?>
				</select>
				<?=form_input(array('name'=>'q','id'=>'q','class'=>'txt radius'));?>
				<?=form_input(array('name'=>'tgl','id'=>'tgl','class'=>'txt radius','onmouseover'=>'get_datePlugin(\'tgl\')','style'=>'display:none;'));?>
			</td>
			<td><?=form_submit(array('name'=>'search','class'=>'radius','value'=>'cari'));?></td>
		</tr>
	</table>
	<?=form_close();?>

	<table class="list">
		<tr id="caption">
			<td>No</td>
			<td>Kode</td>
			<td>Tipe</td>
			<td>Nomor</td>
			<td>Harga Dasar</td>
			<td>Harga Jual</td>
			<td>Tanggal Penjualan</td>
			<td>Actions</td>
		</tr>
		<?php
			
			$x = 1;
			foreach ($fetch as $row) {
				$class = $x % 2 == 1 ? 'odd' : 'even';
				
				echo "
					<tr class='".$class."'>
						<td style='text-align: center;'>".$numb."</td>
						<td>".$row->kode_kartu."</td>
						<td>".$row->nama_type."</td>
						<td>".$row->nomor."</td>
						<td>Rp ".(number_format($row->hrg_dasar, 0, null, '.'))."</td>
						<td>Rp ".(number_format($row->hrg_jual, 0, null, '.'))."</td>
						<td style='text-align: center;'>".$row->tanggal."</td>
						<td style='text-align: center;'>
							".anchor('perdana/edit/'.$row->id_per, '<img src="'.base_url('assets/img/edit.png').'" alt="edit" />', array('title'=>'Edit'))."  
							".anchor('perdana/delete/'.$row->id_per, '<img src="'.base_url('assets/img/failed.png').'" alt="delete" />', array('title'=>'Delete','onclick'=>"return confirm('Apakah anda yakin ingin menghapus data ini?');"))."
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

		$('#field').change(function(){
			var value = $('#field').val();
			
			if(value == 'kode_kartu'){
				$('#kode_kartu').slideDown();
				$('input#tgl').slideUp();
				$('input#q').slideUp();
				$('#id_type').slideUp();
			}else if (value == 'tanggal'){
				$('#kode_kartu').slideUp();
				$('input#tgl').slideDown();
				$('input#q').slideUp();
				$('#id_type').slideUp();
			}else if (value == 'id_type'){
				$('#kode_kartu').slideUp();
				$('input#tgl').slideUp();
				$('input#q').slideUp();
				$('#id_type').slideDown();
			}else{
				$('#kode_kartu').slideUp();
				$('input#tgl').slideUp();
				$('input#q').slideDown();
				$('#id_type').slideUp();
			}
		});
		
	});
</script>