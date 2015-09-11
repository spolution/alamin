
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/document-edit.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>
<div class="item">
	<?php
		
		if (validation_errors()) {
			echo validation_errors();
		}elseif($this->session->flashdata('success_edit')){
			echo $this->session->flashdata('success_edit');
		}
		
		echo form_open(current_url());
		
	?>

	<table class="input">
		<tr>
			<td>
				<label for="nama_type">Nama Tipe Aksesoris (harus diisi)</label><br />
				<?=form_input(array('name'=>'nama_type','id'=>'nama_type','value'=>$row->nama_type));?>
			</td>
		</tr>
		<tr>
			<td><?=form_submit(array('name'=>'edit','class'=>'radius','value'=>'Ubah'))
				.' '.form_reset(array('value'=>'Bersih','class'=>'radius'));?></td>
		</tr>
	</table>
	
	<?=form_close();?>	
</div>