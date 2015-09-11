
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/button-add.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>
<div class="item">
	<?php
		
		if (validation_errors()) {
			echo validation_errors();
		}elseif ($this->session->flashdata('error_kode')){
			echo $this->session->flashdata('error_kode');
		}
		
		echo form_open(current_url());
		
	?>

	<table class="input">
		<tr class='even'>
			<td>
				<label>Nama Kartu (harus dipilih)</label><br />
				<select name='kode_kartu' id='kode_kartu'>
					<option value=''>-- Pilih --</option>
					<?php
					
						foreach ($kartu->result() as $row){
							echo "<option value='".$row->kode_kartu."'>".$row->nama_kartu."</option>";
						}
					
					?>
				</select>
			</td>
			<td>
				<label for="hrg_dasar">Harga Dasar (harus diisi)</label><br />
				<?=form_input(array('name'=>'hrg_dasar','id'=>'hrg_dasar','value'=>$data['hrg_dasar']));?>
			</td>
		</tr>
		<tr class='odd'>
			<td>
				<label for="kode_vo">Kode Voucher (harus diisi)</label><br />
				<?=form_input(array('name'=>'kode_vo','id'=>'kode_vo'));?>
			</td>
			<td>
				<label for="hrg_jual">Harga jual (harus diisi)</label><br />
				<?=form_input(array('name'=>'hrg_jual','id'=>'hrg_jual','value'=>$data['hrg_jual']));?>
			</td>
		</tr>
		<tr class='even'>
			<td>
				<label for="ket">keterangan kode</label><br />
				<?=form_input(array('name'=>'ket','id'=>'ket'));?>
			</td>
			<td>
				<?=form_submit(array('name'=>'add','class'=>'radius','value'=>'Tambah'))
				.' '.form_reset(array('value'=>'Bersih','class'=>'radius'));?>
			</td>
		</tr>
	</table>
	
	<?=form_close();?>	
</div>

<script type='text/javascript'>
	$(function(){
		$('#kode_kartu').change(function(){
			var id = $('#kode_kartu').val();

			$.ajax({
				url: '<?=site_url('master_voucher/ajax_get_shortcut_name');?>',
				type: 'POST',
				dataType: 'json',
				data: 'kode_kartu='+id,
				success: function(msg){
					var x = msg.split('|');
					
					$('input#kode_vo').val(x[1]);
					$('input#ket').val(x[0]);

					$('input#kode_vo').focus();
				}
			});
		});
	});
</script>