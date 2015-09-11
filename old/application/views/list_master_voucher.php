
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/document-file.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>
<div class="item">

	<div onClick="window.location.href='<?php echo site_url('master_voucher/add'); ?>'" class="tools" id="t-1" onmouseover="get_effect('t-1')" onmouseout="remove_effect('t-1')" title="Tambah Data Deposit Pulsa Fisik">
		<img src="<?php echo base_url('assets/img/button-add.png'); ?>" alt="add" />
	</div>
	<div class="tools search-control" id="t-2" onmouseover="get_effect('t-2')" onmouseout="remove_effect('t-2')" title="Pencarian" style="margin-top: 68px;">
		<img src="<?php echo base_url('assets/img/search.png'); ?>" alt="search" />
	</div>

	<?php
	
		if($this->session->flashdata('success_add')){
			echo $this->session->flashdata('success_add');
		}
		elseif($this->session->flashdata('success_delete')){
			echo $this->session->flashdata('success_delete');
		}
	
		echo form_open('master_voucher',array('id'=>'form_search','style'=>'display:none;'));
	
	?>

	<table>
		<tr>
			<td>
				<select name='field' id='field'>
					<option value='kode_vo'>Kode</option>
					<option value='kode_kartu'>Kartu</option>
					<option value='hrg_dasar'>Harga Dasar</option>
					<option value='hrg_jual'>Harga Jual</option>
				</select>
			</td>
			<td>
				<select name='kode_kartu' id='kode_kartu' style='display:none;'>
					<?php
					
						foreach ($kartu->result() as $row){
							echo "<option value='".$row->kode_kartu."'>".$row->nama_kartu."</option>";
						}
					
					?>
				</select>
				<?=form_input(array('name'=>'q','id'=>'q'));?>
			</td>
			<td><?=form_submit(array('name'=>'search','class'=>'radius','value'=>'cari'));?></td>
		</tr>
	</table>
	<?=form_close();?>

	<table class="list">
		<tr id="caption">
			<td>No</td>
			<td>Kartu</td>
			<td>Kode Voucher</td>
			<td>Keterangan</td>
			<td>Harga Dasar</td>
			<td>Harga Jual</td>
			<td>Actions</td>
		</tr>
		<?php
			
			$x = 1;
			foreach ($fetch as $row) {
				$class = $x % 2 == 1 ? 'odd' : 'even';
				
				echo "
					<tr class='".$class."'>
						<td style='text-align: center;'>".$x."</td>
						<td>".$row->nama_kartu."</td>
						<td>".$row->kode_vo."</td>
						<td>".$row->ket."</td>
						<td>Rp ".(number_format($row->hrg_dasar, 0, null, '.'))."</td>
						<td>Rp ".(number_format($row->hrg_jual, 0, null, '.'))."</td>
						<td style='text-align: center;'>
							".anchor('master_voucher/edit/'.$row->kode_vo, '<img src="'.base_url('assets/img/edit.png').'" alt="edit" />', array('title'=>'Edit'))."  
							".anchor('master_voucher/delete/'.$row->kode_vo, '<img src="'.base_url('assets/img/failed.png').'" alt="delete" />', array('title'=>'Delete','onclick'=>"return confirm('Apakah anda yakin ingin menghapus data ini?');"))."
						</td>
					</tr>
				";
				
				$x++;
			}
		
		?>
	</table>
</div>

<script type="text/javascript">
	
	$(function(){
		$('#field').change(function(){
			var value = $('#field').val();
			
			if(value == 'kode_kartu'){
				$('#kode_kartu').slideDown();
				$('input#q').slideUp();
			}else{
				$('#kode_kartu').slideUp();
				$('input#q').slideDown();
			}
		});
	});
	
</script>