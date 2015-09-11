
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/document-edit.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>
<div class="item">
	<?php
		
		if (validation_errors()) {
			echo validation_errors();
		} elseif ($this->session->flashdata('success_edit')){
			echo $this->session->flashdata('success_edit');
		}
		
		echo form_open(current_url());
		
	?>

	<table class="input">
		<tr>
			<td>
				<label for="kode_kartu">kode kartu</label><br />
				<?=form_input(array('name'=>'kode_kartu','id'=>'kode_kartu','disabled'=>'disabled','value'=>$fetch->kode_kartu));?>
				<br />&nbsp;
			</td>
			<td>
				<label for="saldo">saldo pulsa</label><br />
				<?=form_input(array('name'=>'saldo_pulsa','id'=>'saldo','value'=>$fetch->saldo_pulsa));?>
				<br /><span class='desc'>*Kosongkan bila kartu yang di input berjenis satuan.</span>
			</td>
		</tr>
		<tr>
			<td>
				<label for="nama_kartu">nama kartu (harus diisi)</label><br />
				<?=form_input(array('name'=>'nama_kartu','id'=>'nama_kartu','value'=>$fetch->nama_kartu));?>
			</td>
			<td>
				<?=form_submit(array('name'=>'add','class'=>'button radius','value'=>'edit data'))
				.' '.form_reset(array('value'=>'Bersih','class'=>'button radius'));?>
			</td>
		</tr>
	</table>

	<?=form_close();?>
</div>