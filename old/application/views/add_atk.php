
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/button-add.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>
<div class="item">
	<?php
		
		if (validation_errors()) {
			echo validation_errors();
		}elseif($this->session->flashdata('success_add')){
			echo $this->session->flashdata('success_add');
		}
		
		echo form_open(current_url());
		
	?>
	
	<table class="input">
		<tr>
			<td>
				<label>Jenis ATK (harus dipilih)</label><br />
				<select name="id_type">
					<option value=''>-- Pilih --</option>
					<?php
					
						foreach ($type_atk->result() as $row){
							echo "<option value='".$row->id_type."'>".$row->nama_type."</option>";
						}
					
					?>
				</select>
			</td>
			<td>
				<label>Stock</label><br />
				<?=form_input(array('name'=>'stock'));?>
			</td>
		</tr>
		<tr>
			<td>
				<label>nama barang (harus dipilih)</label><br />
				<select name="id_ma">
					<!-- AJAX Processing -->
				</select>
			</td>
			<td>
				<label for="qty">jumlah jual (harus diisi)</label><br />
				<?=form_input(array('name'=>'qty','id'=>'qty','value'=>'1'));?>
			</td>
		</tr>
		<tr>
			<td>
				<label>Harga Dasar</label><br />
				<?=form_input(array('name'=>'hrg_dasar'));?>
			</td>
			<td>
				<?=form_submit(array('name'=>'add','id'=>'add','class'=>'radius','value'=>'Jual'))
				.' '.form_reset(array('value'=>'Bersih','class'=>'radius'));?>
			</td>
		</tr>
		<tr>
			<td>
				<label>Harga jual</label><br />
				<?=form_input(array('name'=>'hrg_jual'));?>
			</td>
		</tr>
	</table>
	
	<?=form_close();?>	
</div>

<script type='text/javascript'>

	$(function(){	
		$('select[name="id_type"]').change(function(){ 
			$.ajax({
				url: '<?=site_url('atk/ajax_get_master_atk_data');?>',
				type: 'POST',
				dataType: 'json',
				data: 'id_type='+$('select[name="id_type"]').val(),
				success: function(msg){
					$('select[name="id_ma"]').html(msg);
				}
			});

			$('input[name="hrg_dasar"]').val('');
			$('input[name="hrg_jual"]').val('');
			$('input[name="stock"]').val('');
		});

		$('select[name="id_ma"]').change(function(){
			$.ajax({
				url: '<?=site_url('atk/ajax_get_once_master_atk_data');?>',
				type: 'POST',
				dataType: 'json',
				data: 'id_ma='+$('select[name="id_ma"]').val(),
				success: function(msg){
					var x = msg.split('|');

					$('input[name="hrg_dasar"]').val(x[0]);
					$('input[name="hrg_jual"]').val(x[1]);
					$('input[name="stock"]').val(x[2]);
				}
			});
		});		
	});
	
</script>