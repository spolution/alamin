
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/document-edit.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>
<div class="item">
	<?php
		
		if (validation_errors()) {
			echo validation_errors();
		}elseif ($this->session->flashdata('success_edit')){
			echo $this->session->flashdata('success_edit');
		}
		
		echo form_open(current_url());
		
	?>

	<table class="input">
		<tr class='odd'>
			<td>
				<label for="no_hp">Nomor Handphone (harus diisi)</label><br />
				<?=form_input(array('name'=>'no_hp','id'=>'no_hp','value'=>$fetch->no_hp));?>
			</td>
			<td>
				<label for="ket">keterangan</label><br />
				<?=form_textarea(array('name'=>'ket','id'=>'ket','value'=>(str_replace('<br />', ' ', $fetch->ket))));?>
			</td>
		</tr>
		<tr>
			<td>
				<label for="nama">nama</label><br />
				<?=form_input(array('name'=>'nama','id'=>'nama','value'=>$fetch->nama,'class'=>'txt radius'));?>
			</td>
			<td>
				<?=form_submit(array('name'=>'edit','class'=>'radius','value'=>'Ubah data'))
				.' '.form_reset(array('value'=>'bersih','class'=>'radius'));?>
			</td>
		</tr>
	</table>
	
	<?=form_close();?>	
</div>