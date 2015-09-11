
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
		<tr>
			<td>
				<label>nama kartu (harus diisi)</label><br />
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
		<tr>
			<td>
				<label for="kode_mc">Kode Master Card (harus diisi)</label><br />
				<?=form_input(array('name'=>'kode_mc','id'=>'kode_mc','value'=>$data['kode_mc']));?>
			</td>
			<td>
				<label for="hrg_jual">Harga Jual (harus diisi)</label><br />
				<?=form_input(array('name'=>'hrg_jual','id'=>'hrg_jual','value'=>$data['hrg_jual']));?>
			</td>
		</tr>
		<tr>
			<td>
				<label>tipe</label><br />
				<?php 
				
					echo form_input(array('disabled'=>'disabled','value'=>$type_name)).
						 form_hidden('id_type',$type);
						 
				?>
			</td>
			<?php
			
				if ($type == 1) {
					echo "
						<td>
							<label for='saldo_satuan'>saldo satuan (harus diisi)</label><br />".
							form_input(array('name'=>'saldo_satuan','id'=>'saldo_satuan','value'=>$data['saldo_satuan']))
						."</td>
					";
				}
			
			?>
		</tr>
		<tr>
			<td>
				<label for="ket">Keterangan Kode</label><br />
				<?=form_input(array('name'=>'ket','id'=>'ket','value'=>$data['ket']));?>
			</td>
			<td>
				<?=form_submit(array('name'=>'add','class'=>'radius','value'=>'Tambah data'))
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
				url: '<?=site_url('master_card/ajax_get_shortcut_name');?>',
				type: 'POST',
				dataType: 'json',
				data: 'kode_kartu='+id,
				success: function(msg){
					var x = msg.split('|');
					
					$('input#kode_mc').val(x[1]);
					$('input#ket').val(x[0]);
				}
			});
		});
	});
</script>