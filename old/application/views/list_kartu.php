
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/document.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>
<div class="item">

	<div onClick="window.location.href='<?php echo site_url('kartu/add'); ?>'" class="tools" id="t-1" onmouseover="get_effect('t-1')" onmouseout="remove_effect('t-1')" title="Tambah Data Kartu">
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
	
		echo form_open('kartu',array('id'=>'form_search','style'=>'display: none;'));
	
	?>
	<table>
		<tr>
			<td>
				<select name='field'>
					<option value='nama_kartu'>Nama Kartu</option>
					<option value='kode_kartu'>Kode Kartu</option>
				</select>
			</td>
			<td><?=form_input(array('name'=>'q'));?></td>
			<td><?=form_submit(array('name'=>'search','class'=>'radius','value'=>'Cari'));?></td>
		</tr>
	</table>
	<?php echo form_close(); ?>
	
	<table class="list">
		<tr id="caption">
			<td>No</td>
			<td>Kode Kartu</td>
			<td>Nama Kartu</td>
			<td>Saldo Pulsa</td>
			<td>Actions</td>
		</tr>
		<?php
			
			$x = 1;
			
			foreach ($fetch->result() as $row) {
				$class = $x %2 == 1 ? 'odd' : 'even';
				
				echo "
					<tr class='".$class."'>
						<td style='text-align: center;'>".$x."</td>
						<td>".$row->kode_kartu."</td>
						<td>".$row->nama_kartu."</td>
						<td>Rp ".(number_format($row->saldo_pulsa, 0, null, '.'))."</td>
						<td style='text-align: center;'>
							".anchor('kartu/sum_stock/'.$row->kode_kartu.'/'.$row->saldo_pulsa, '<img src="'.base_url('assets/img/edit_add.png').'" alt="add" />', 'title="Tambah Saldo"')."
							".anchor('kartu/edit/'.$row->kode_kartu, '<img src="'.base_url('assets/img/edit.png').'" alt="edit" />','title="Edit"')."  
							".anchor('kartu/delete/'.$row->kode_kartu, '<img src="'.base_url('assets/img/failed.png').'" alt="delete" />', array('onclick'=>"return confirm('Apakah anda yakin ingin menghapus data ini?');",'title'=>'Delete'))."
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
		$('select[name="field"]').change(function(){
			$('input[name="q"]').focus();
		});
	});
</script>