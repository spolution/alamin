
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/button-add.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>
<div class="item">
	<?php
		
		if (validation_errors()) { echo validation_errors(); }
		echo form_open(current_url());
		
	?>

	<table class="input">
		<tr>
			<td>
				<label>Kode Kartu (harus dipilih)</label><br />
				<select name='kode_kartu' id='kode_kartu'>
					<option value=''>-- Pilih --</option>
					<?php
					
						foreach ($kartu->result() as $row){
							echo "<option value='".$row->kode_kartu."'>".$row->kode_kartu."</option>";
						}
					
					?>
				</select>
			</td>
			<td>
				<label for="hrg_dasar">Harga Dasar (harus diisi)</label><br />
				<?=form_input(array('name'=>'hrg_dasar','id'=>'hrg_dasar','value'=>$data['hrg_dasar']));?>
			</td>
		</tr>
		<tr>
			<td>
				<label>Tipe (harus dipilih)</label><br />
				<select name='id_type' id='id_type'>
					<option value=''>-- Pilih --</option>
					<?php
					
						foreach ($type_perdana->result() as $row){
							echo "<option value='".$row->id_type."'>".$row->nama_type."</option>";
						}
					
					?>
				</select>
			</td>
			<td>
				<label for="hrg_jual">Harga Jual (harus diisi)</label><br />
				<?=form_input(array('name'=>'hrg_jual','id'=>'hrg_jual','value'=>$data['hrg_jual']));?>
			</td>
		</tr>
		<tr>
			<td>
				<label for="nomor">Nomor Handphone (harus diisi)</label><br />
				<?=form_input(array('name'=>'nomor','id'=>'nomor','value'=>$data['nomor']));?>
			</td>
			<td>
				<?=form_submit(array('name'=>'add','class'=>'button radius','value'=>'Jual baru'))
				.' '.form_reset(array('value'=>'Bersih','class'=>'button radius'));?>
			</td>
		</tr>
	</table>
	
	<?=form_close();?>	
</div>