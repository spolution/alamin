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
				<label>Jenis Barang (harus dipilih)</label><br />
				<select name='id_type'>
					<option value=''>-- Pilih --</option>
					<?php
					
						foreach ($data_type_atk->result() as $row) {
							echo "<option value='".$row->id_type."'>".$row->nama_type."</option>";
						}
					
					?>
				</select>
			</td>
			<td>
				<label for="hrg_jual">harga jual(harus diisi)</label><br />
				<?=form_input(array('name'=>'hrg_jual','id'=>'hrg_jual','value'=>$data['hrg_jual']));?>
			</td>
		</tr>
		<tr>
			<td>
				<label for="nama_brg">Nama Barang (harus diisi)</label><br />
				<?=form_input(array('name'=>'nama_brg','id'=>'nama_brg','value'=>$data['nama_brg']));?>
			</td>
			<td>
				<label for="stock">stock (harus diisi)</label><br />
				<?=form_input(array('name'=>'stock','id'=>'stock','value'=>$data['stock']));?>
			</td>
		</tr>
		<tr>
			<td>
				<label for="hrg_dasar">Harga Dasar(harus diisi)</label><br />
				<?=form_input(array('name'=>'hrg_dasar','id'=>'hrg_dasar','value'=>$data['hrg_dasar']));?>
			</td>
			<td>
				<?=form_submit(array('name'=>'add','class'=>'radius','value'=>'Tambah'))
				.' '.form_reset(array('value'=>'Bersih','class'=>'radius'));?>
			</td>
		</tr>
	</table>
	
	<?=form_close();?>	
</div>