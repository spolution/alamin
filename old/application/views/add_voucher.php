
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/outbox.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>
<div class="item">
	<?php
		
		if (validation_errors()) {
			echo validation_errors();
		}elseif ($this->session->flashdata('success_add')){
			echo $this->session->flashdata('success_add');
		}
		
		echo form_open(current_url());
		
	?>

	<table class="input">
		<tr class='even'>
			<td>
				<label>Kode Voucher (harus dipilih)</label><br />
				<select name='kode_vo'>
					<option value=''>-- Pilih Kode Voucher --</option>
					<?php
					
						foreach ($master_voucher->result() as $row){
							echo "<option value='".$row->kode_vo."'>".$row->kode_vo."</option>";
						}
					
					?>
				</select>
			</td>
			<td>
				<label>harga jual</label><br />
				<?=form_input(array('id'=>'hrg_jual','disabled'=>'disabled'));?>
			</td>
		</tr>
		<tr class='odd'>
			<td>
				<label>Keterangan Kode</label><br />
				<?=form_input(array('id'=>'ket','disabled'=>'disabled'));?>
			</td>
			<td>
				<?=form_submit(array('name'=>'add','class'=>'radius','value'=>'Jual Baru'))
				.' '.form_reset(array('value'=>'Bersih','class'=>'radius'));?>
			</td>
		</tr>
		<tr class='even'>
			<td>
				<label>Harga Dasar</label><br />
				<?=form_input(array('id'=>'hrg_dasar','class'=>'txt radius','disabled'=>'disabled'));?>
			</td>
		</tr>
	</table>
	<?=form_close();?>
	
</div>

<script type='text/javascript'>
	$(function(){
		$('select[name="kode_vo"]').change(function(){
			var id = $('select[name="kode_vo"]').val();

			$.ajax({
				url: '<?=site_url('voucher/ajax_get_master_voucher_data');?>',
				type: 'POST',
				dataType: 'json',
				data: 'kode_vo='+id,
				success: function(msg){
					var x = msg.split('|');

					$('input#ket').val(x[0]);
					$('input#hrg_dasar').val(x[1]);
					$('input#hrg_jual').val(x[2]);
				}
			});
		});
	});
</script>