
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/briefcase.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>
<div class="item">

	<div onClick="window.location.href='<?php echo site_url('master_atk/add'); ?>'" class="tools" id="t-1" onmouseover="get_effect('t-1')" onmouseout="remove_effect('t-1')" title="Ke Form Tambah Deposit ATK">
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
		echo form_open('master_atk',array('id'=>'form_search','style'=>'display:none;'));
	
	?>

	<table>
		<tr>
			<td>
				<select name='field' id='field'>
					<option value='nama_brg'>Nama Barang</option>
					<option value='id_type'>Jenis Barang</option>
					<option value='stock'>Stock</option>
				</select>
			</td>
			<td>
				<select name='id_type' id='id_type' style="display:none;">
					<?php
					
						foreach ($data_type_atk->result() as $row) {
							echo "<option value='".$row->id_type."'>".$row->nama_type."</option>";
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
			<td>Nama Barang</td>
			<td>Jenis Barang</td>
			<td>Harga Dasar</td>
			<td>Harga Jual</td>
			<td>Stock</td>
			<td>Actions</td>
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
						<td>Rp ".(number_format($row->hrg_dasar, 0, null, '.'))."</td>
						<td>Rp ".(number_format($row->hrg_jual, 0, null, '.'))."</td>
						<td style='text-align: center;'>".$row->stock."</td>
						<td style='text-align: center;'>
							".anchor('master_atk/edit/'.$row->id_ma, '<img src="'.base_url('assets/img/edit.png').'" alt="edit" />', array('title'=>'Edit'))."  
							".anchor('master_atk/delete/'.$row->id_ma, '<img src="'.base_url('assets/img/failed.png').'" alt="delete" />', array('title'=>'Delete','onclick'=>"return confirm('Apakah anda yakin ingin menghapus data ini?');"))."
						</td>
					</tr>
				";
				
				$numb++;
				$x++;
			}
		
		?>
	</table>
	
	<?php echo $pagination; ?>
</div>

<script type="text/javascript">

	$(function(){
		$('#field').change(function(){
			var a = $('#field').val();
			if(a == 'id_type'){
				$('#id_type').slideDown();
				$('input#q').slideUp();
			}else{
				$('#id_type').slideUp();
				$('input#q').slideDown();
			}
		});
	});
	
</script>