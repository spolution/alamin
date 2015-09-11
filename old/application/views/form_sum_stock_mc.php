
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/document-edit.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>
<div class="item">
	<?php
		
		if (validation_errors()) {
			echo validation_errors();
		}elseif($this->session->flashdata('sucess_edit')){
			echo $this->session->flashdata('sucess_edit');
		}
		
		echo form_open(current_url());
		
	?>
	<span class="true">*Saldo akhir : <strong>Rp <?php echo number_format($saldo_akhir, 0, null, '.'); ?></strong></span>
	<table class="input">
		<tr>
			<td>
				<label for="saldo">masukkan tambahan saldo satuan (harus diisi)</label><br />
				<?=form_input(array('name'=>'saldo','id'=>'saldo'));?>
			</td>
		</tr>
		<tr>
			<td><?=form_submit(array('name'=>'add','class'=>'radius','value'=>'tambah saldo'))
				.' '.form_reset(array('value'=>'Bersih','class'=>'radius'));?></td>
		</tr>
	</table>
	
	<?=form_close();?>	
</div>