
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/mobile.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>
<div class="item">

	<div onClick="window.location.href='<?php echo site_url('aksesoris/add'); ?>'" class="tools" id="t-1" onmouseover="get_effect('t-1')" onmouseout="remove_effect('t-1')" title="Ke Form Penjualan Aksesoris">
		<img src="<?php echo base_url('assets/img/button-add.png'); ?>" alt="add" />
	</div>
	<div class="tools search-control" id="t-2" onmouseover="get_effect('t-2')" onmouseout="remove_effect('t-2')" title="Pencarian" style="margin-top: 68px;">
		<img src="<?php echo base_url('assets/img/search.png'); ?>" alt="search" />
	</div>
	
	<?php
	
		if($this->session->flashdata('success_delete')){
			echo $this->session->flashdata('success_delete');
		}elseif($this->session->flashdata('success_add')){
			echo $this->session->flashdata('success_add');
		}
		
		if(empty($_POST)){ echo $pagination; }
		echo form_open('aksesoris',array('id'=>'form_search','style'=>'display:none;'));
	
	?>

	<table>
		<tr>
			<td>
				<select name='field' id='field'>
					<option value='nama_brg'>Nama Barang</option>
					<option value='id_type'>Jenis Barang</option>
					<option value='tanggal'>Tanggal Penjualan</option>
				</select>
			</td>
			<td>
				<select name='id_type' id='id_type' style="display:none;">
					<?php
					
						foreach ($data_type_akse->result() as $row) {
							echo "<option value='".$row->id_type."'>".$row->nama_type."</option>";
						}
					
					?>
				</select>
				<?=form_input(array('name'=>'q','id'=>'q'));?>
				<?=form_input(array('name'=>'tgl','id'=>'tgl','onmouseover'=>'get_datePlugin(\'tgl\')','style'=>'display:none;'));?>
			</td>
			<td><?=form_submit(array('name'=>'search','class'=>'button radius','value'=>'cari'));?></td>
		</tr>
	</table>
	<?=form_close();?>

	<table class="list">
		<tr id="caption">
			<td>No</td>
			<td>Nama Barang</td>
			<td>Jenis Barang</td>
			<td>Tanggal Penjualan</td>
			<td>Action</td>
		</tr>
		<?php
			
			$x = 1;
			foreach ($fetch as $row) {
				$class = $x % 2 == 1 ? 'odd' : 'even';
				
				echo "
					<tr class='".$class."'>
						<td style='text-align: center;'>".$numb."</td>
						<td>".$row->nama_brg."</td>
						<td>".$row->nama_type."</td>
						<td style='text-align: center;'>".$row->tanggal."</td>
						<td style='text-align: center;'> 
							".anchor('aksesoris/delete/'.$row->id, '<img src="'.base_url('assets/img/failed.png').'" alt="delete" />', array('title'=>'Delete','onclick'=>"return confirm('Apakah anda yakin ingin menghapus data ini?');"))."
						</td>
					</tr>
				";
				
				$numb++;
				$x++;
			}
		
		?>
	</table>
	
	<?php if(empty($_POST)){ echo $pagination; } ?>
</div>

<script type="text/javascript">

	$(function(){
		$('#field').change(function(){
			var a = $('#field').val();

			if(a == 'id_type'){
				$('#id_type').slideDown();
				$('input#q').slideUp();
				$('input#tgl').slideUp();
			}else if(a == 'tanggal'){
				$('input#tgl').slideDown();
				$('#id_type').slideUp();
				$('input#q').slideUp();
			}else{
				$('input#tgl').slideUp();
				$('#id_type').slideUp();
				$('input#q').slideDown();
			}
		});
	});
	
</script>