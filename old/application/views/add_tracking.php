
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
		
		echo form_open(current_url(), array('id'=>'my_form'));
		
	?>

	<input type='hidden' id='last' value='<?=$last;?>' />
	<table class="input">
		<tr>
			<td style="width: 500px;">
				<label>Kode (harus dipilih)</label><br />
				<select name='kode_mc' id='kode_mc'>
					<option value=''>-- Pilih --</option>
					<?php
					
						foreach ($master_card->result() as $row){
							echo "<option value='".$row->kode_mc."'>".$row->kode_mc."</option>";
						}
					
					?>
				</select>
			</td>
			<td>
				<label for="nama">Nama</label><br />
				<?=form_input(array('name'=>'nama','id'=>'nama','value'=>$data['nama']));?>
			</td>
		</tr>
		<tr>
			<td>
				<label>Keterangan Kode</label><br />
				<?=form_input(array('id'=>'ket_mc','disabled'=>'disabled'));?>
			</td>
			<td>
				<label for="ket">Keterangan</label><br />
				<?=form_textarea(array('name'=>'ket','id'=>'ket','value'=>$data['ket']));?>
			</td>
		</tr>
		<tr>
			<td>
				<label for="no_hp">nomor handphone (harus diisi)</label> <i>atau <?=anchor_js('a_member', 'Pilih Member &raquo;');?></i><br />
				<?php
				
					echo '<select id="id_member" style="display:none;">';
					echo '<option value="">-- Pilih Member --</option>';
					
						foreach ($member->result() as $val) {
							echo '<option value="'.$val->id_member.'">'.$val->nama.'</option>';
						}
					
					echo '</select>';
					echo form_input(array('name'=>'no_hp','id'=>'no_hp','value'=>$data['no_hp']));
				
				?>
			</td>
			<td>
				<?=form_submit(array('name'=>'add','class'=>'radius','value'=>'Track Now'))
				.' '.form_reset(array('value'=>'Bersih','class'=>'radius'));?>
			</td>
		</tr>
	</table>
	<?=form_close();?>
	
</div>

<script type='text/javascript'>
	function check_utang(val){
		$.ajax({
			url: '<?=site_url('tracking/ajax_check_utang');?>',
			type: 'POST',
			dataType: 'json',
			data: 'no_hp='+val,
			success: function(msg){
				if(msg == 'utang'){
					alert('Pembeli dengan nomor HP yang anda masukkan telah terdaftar hutang sebelumnya.');
				}
			}
		});
	}
	$(function(){
		$('#kode_mc').change(function(){
			var id = $('#kode_mc').val();

			$.ajax({
				url: '<?=site_url('tracking/ajax_get_master_card_name');?>',
				type: 'POST',
				dataType: 'json',
				data: 'kode_mc='+id,
				success: function(msg){
					$('input#ket_mc').val(msg);
				}
			});
		});
		$('form#my_form').submit(function(){
			var value = $('input#no_hp').val();

			if(value == $('input#last').val()){
				var txt = 'Nomor yang anda masukkan sama dengan nomor sebelumnya!\nLanjutkan proses tracking?\n';
				txt += '(Kami menyarankan agar proses dibatalkan. Hal ini dapat mencegah terjadinya double tracking).';
				 
				return confirm(txt);
			}else{
				return true;
			}
		});
		$('input[name="no_hp"]').keyup(function(){
			check_utang($('input[name="no_hp"]').val());
		});
		$('a#a_member').click(function(){
			$('a#a_member').hide();
			$('#id_member').slideDown('slow');
		});
		$('#id_member').change(function(){
			var id = $('#id_member').val();

			$.ajax({
				url: '<?=site_url('tracking/ajax_get_member_data');?>',
				type: 'POST',
				dataType: 'json',
				data: 'id_member='+id,
				success: function(msg){
					var x = msg.split('|');

					$('input#nama').val(x[0]);
					$('input#no_hp').val(x[1]);
					
					check_utang(x[1]);
				}
			});
		});
	});
</script>

