
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
				<label>Kode Kartu</label><br />
				<?=form_input(array('value'=>$row->kode_kartu,'disabled'=>'disabled'));?>
			</td>
			<td>
				<label for="hrg_dasar">Harga Dasar (harus diisi)</label><br />
				<?=form_input(array('name'=>'hrg_dasar','id'=>'hrg_dasar','value'=>$row->hrg_dasar));?>
			</td>
		</tr>
		<tr>
			<td>
				<label>Tipe (harus dipilih)</label><br />
				<select name='id_type' id='id_type'>
					<option value=''>-- Pilih --</option>
					<?php
					
						foreach ($type_perdana->result() as $baris){
							if ($row->id_type == $baris->id_type) {
								$choose = 'selected';
							}else{
								$choose = NULL;
							}
							
							echo "<option value='".$baris->id_type."' ".$choose.">".$baris->nama_type."</option>";
						}
					
					?>
				</select>
			</td>
			<td>
				<label for="hrg_jual">Harga Jual (harus diisi)</label><br />
				<?=form_input(array('name'=>'hrg_jual','id'=>'hrg_jual','value'=>$row->hrg_jual));?>
			</td>
		</tr>
		<tr>
			<td>
				<label for="nomor">Nomor Handphone (harus diisi)</label><br />
				<?=form_input(array('name'=>'nomor','id'=>'nomor','value'=>$row->nomor));?>
			</td>
			<td>
				<?=form_submit(array('name'=>'edit','class'=>'radius','value'=>'Ubah Data'))
				.' '.form_reset(array('value'=>'bersih','class'=>'radius'));?>
			</td>
		</tr>
	</table>

	<?=form_close();?>
</div>