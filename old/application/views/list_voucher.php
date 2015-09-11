
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/document-file.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>
<div class="item">

	<div onClick="window.location.href='<?php echo site_url('voucher/add'); ?>'" class="tools" id="t-1" onmouseover="get_effect('t-1')" onmouseout="remove_effect('t-1')" title="Ke Form Penjualan Voucher">
		<img src="<?php echo base_url('assets/img/button-add.png'); ?>" alt="add" />
	</div>
	<div class="tools search-control" id="t-2" onmouseover="get_effect('t-2')" onmouseout="remove_effect('t-2')" title="Pencarian" style="margin-top: 68px;">
		<img src="<?php echo base_url('assets/img/search.png'); ?>" alt="search" />
	</div>
	
	<?php
	
		if($this->session->flashdata('success_delete')){
			echo $this->session->flashdata('success_delete');
		}
		
		if(empty($_POST)){ echo $pagination; }
		echo form_open('voucher',array('id'=>'form_search','style'=>'display:none;'));
	
	?>
	
	<table>
		<tr>
			<td>
				<select name='field' id='field'>
					<option value='tanggal'>Tanggal Pembelian</option>
					<option value='kode_vo'>Kode</option>
				</select>
			</td>
			<td>
				<select name='kode_vo' id='kode_vo' style='display:none;'>
					<?php
					
						foreach ($master_voucher->result() as $row){
							echo "<option value='".$row->kode_vo."'>".$row->kode_vo."</option>";
						}
					
					?>
				</select>
				<?=form_input(array('name'=>'tgl','id'=>'tgl','onmouseover'=>'get_datePlugin(\'tgl\')','class'=>'txt radius'));?>
			</td>
			<td><?=form_submit(array('name'=>'search','class'=>'button radius','value'=>'cari'));?></td>
		</tr>
	</table>
	<?=form_close();?>
	
	<table class="list">
		<tr id="caption">
			<td>No</td>
			<td>Kode Voucher</td>
			<td>Keterangan Kode</td>
			<td>Tanggal Penjualan</td>
			<td>Action</td>
		</tr>
		<?php
			
			$x = 1;
			foreach ($fetch as $row) {
				$class = $x % 2 == 1 ? 'odd' : 'even';
				
				echo "
					<tr class='".$class."'>
						<td align='center'>".$numb."</td>
						<td>".$row->kode_vo."</td>
						<td>".$row->ket."</td>
						<td style='text-align: center;'>".$row->tanggal."</td>
						<td style='text-align: center;'> 
							".anchor('voucher/delete/'.$row->id, '<img src="'.base_url('assets/img/failed.png').'" alt="delete" />', array('title'=>'Delete','onclick'=>"return confirm('Apakah anda yakin ingin menghapus data ini?');"))."
						</td>
					</tr>
				";
				
				$numb++; $x++;
			}
		
		?>
	</table>
	
	<?php if(empty($_POST)){ echo $pagination; } ?>
</div>

<script type="text/javascript">
	
	$(function(){		
		$('#field').change(function(){
			var value = $('#field').val();
			
			if(value == 'kode_vo'){
				$('#kode_vo').slideDown();
				$('input#tgl').slideUp();
			}else{
				$('#kode_vo').slideUp();
				$('input#tgl').slideDown();
			}
		});
	});
	
</script>