
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
		<tr class='even'>
			<td>
				<label for="kode_vo">Kode Voucher</label><br />
				<?=form_input(array('name'=>'kode_vo','id'=>'kode_vo','disabled'=>'disabled','value'=>$row->kode_vo));?>
			</td>
			<td>
				<label for="hrg_jual">Harga jual (harus diisi)</label><br />
				<?=form_input(array('name'=>'hrg_jual','id'=>'hrg_jual','value'=>$row->hrg_jual));?>
			</td>
		</tr>
		<tr class='odd'>
			<td>
				<label for="ket">keterangan kode</label><br />
				<?=form_input(array('name'=>'ket','id'=>'ket','value'=>$row->ket));?>
			</td>
			<td>
				<?=form_submit(array('name'=>'edit','class'=>'radius','value'=>'Ubah'))
				.' '.form_reset(array('value'=>'Bersih','class'=>'radius'));?>
			</td>
		</tr>
		<tr class='even'>
			<td>
				<label for="hrg_dasar">Harga Dasar (harus diisi)</label><br />
				<?=form_input(array('name'=>'hrg_dasar','id'=>'hrg_dasar','value'=>$row->hrg_dasar));?>
			</td>
		</tr>
	</table>
	
	<?=form_close();?>	
</div>