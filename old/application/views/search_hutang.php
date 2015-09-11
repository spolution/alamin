
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/search.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>
<div class="item">
	<?php
		
		if (validation_errors()) { echo validation_errors(); }
		echo form_open(current_url());
		
	?>
	
	<table class="input">
		<tr>
			<td><label>Pencarian hutang berdasarkan : </label> </td>
			<td>
				<select name='field'>
					<option value=''>-- Pilih Kriteria --</option>
					<option value='nama'>Nama</option>
					<option value='no_hp'>Nomor HP</option>
				</select>
			</td>
			<td><?=form_input(array('name'=>'q','value'=>$data['q']));?></td>
		</tr>
		<tr>
			<td colspan='4' style="text-align: right;">
				<?=form_submit(array('name'=>'search','value'=>'cari dan kalkulasi','class'=>'radius'));?>
			</td>
		</tr>
	</table>
	
	<?php echo form_close(); if (! empty($list)) { $this->load->view($list); } ?>
	
</div>

<script type='text/javascript'>
	$(function(){
		$('select[name="field"]').change(function(){
			$('input[name="q"]').focus();
		});
	});
</script>