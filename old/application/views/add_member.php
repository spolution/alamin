
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
				<label for="nama">Nama (harus diisi)</label><br />
				<?=form_input(array('name'=>'nama','id'=>'nama','value'=>$data['nama']));?>
			</td>
		</tr>
		<tr>
			<td>
				<label for="no_tlpn">Nomor Telepon (harus diisi)</label><br />
				<?=form_input(array('name'=>'no_tlpn','id'=>'no_tlpn','value'=>$data['no_tlpn']));?>
			</td>
		</tr>
		<tr>
			<td><?=form_submit(array('name'=>'add','class'=>'radius','value'=>'Tambah'))
				.' '.form_reset(array('value'=>'Bersih','class'=>'radius'));?></td>
		</tr>
	</table>

	<?=form_close();?>	
</div>
