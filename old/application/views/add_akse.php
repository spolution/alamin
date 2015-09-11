
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
				<label>jenis aksesoris (Harus dipilih)</label><br />
				<select name='id_type' id='id_type'>
					<option value=''>-- Pilih --</option>
					<?php
					
						foreach ($data_type_akse->result() as $row){
							echo "<option value='".$row->id_type."'>".$row->nama_type."</option>";
						}
					
					?>
				</select>
			</td>
			<td>
				<label for="hrg_jual">harga jual</label><br />
				<?=form_input(array('id'=>'hrg_jual','disabled'=>'disabled'));?>
			</td>
		</tr>
		<tr>
			<td>
				<label>pilih aksesoris (harus dipilih)</label><br />
				<select name="id_ma">
					
				</select>
			</td>
			<td>
				<label for="stock">stock</label><br />
				<?=form_input(array('id'=>'stock','disabled'=>'disabled'));?>
			</td>
		</tr>
		<tr>
			<td>
				<label for="hrg_dasar">harga dasar</label><br />
				<?=form_input(array('id'=>'hrg_dasar','disabled'=>'disabled'));?>
			</td>
			<td>
				<?=form_submit(array('name'=>'add','id'=>'add','class'=>'radius','value'=>'Jual','disabled'=>'disabled'))
				.' '.form_reset(array('value'=>'Bersih','class'=>'radius'));?>
			</td>
		</tr>
	</table>
	
	<?=form_close();?>	
</div>

<script type='text/javascript'>

	$(function(){
		$('#id_type').change(function(){
			$.ajax({
				url: '<?=site_url('aksesoris/ajax_get_master_akse');?>',
				type: 'POST',
				dataType: 'json',
				data: 'id_type='+$('#id_type').val(),
				success: function(msg){
					$('select[name="id_ma"]').html(msg);
				}
			});

			$('input#hrg_dasar').val('');
			$('input#hrg_jual').val('');
			$('input#stock').val('');
		});
		$('select[name="id_ma"]').change(function(){
			$.ajax({
				url: '<?=site_url('aksesoris/ajax_get_once_master_akse');?>',
				type: 'POST',
				dataType: 'json',
				data: 'id_ma='+$('select[name="id_ma"]').val(),
				success: function(msg){
					var x = msg.split('|');

					$('input#hrg_dasar').val(x[0]);
					$('input#hrg_jual').val(x[1]);
					$('input#stock').val(x[2]);

					if($('input#stock').val() == ''){
						$('input#add').attr('disabled', 'disabled');
					}else if($('input#stock').val() <= 0){
						alert('Stock sudah habis.\nAnda tidak bisa melanjutkan proses penjualan.');
						$('input#add').attr('disabled', 'disabled');
					}else{
						$('input#add').removeAttr('disabled');
					}
				}
			});
		});
	});
	
</script>