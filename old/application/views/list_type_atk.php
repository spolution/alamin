
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/computer.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>
<div class="item">

	<div onClick="window.location.href='<?php echo site_url('type_atk/add'); ?>'" class="tools" id="t-1" onmouseover="get_effect('t-1')" onmouseout="remove_effect('t-1')" title="Ke Form Tambah Jenis ATK">
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
		
		echo form_open('type_atk',array('id'=>'form_search','style'=>'display:none;'));
	
	?>

	<table>
		<tr>
			<td>Nama tipe : </td>
			<td><?=form_input(array('name'=>'q'));?></td>
			<td><?=form_submit(array('name'=>'search','class'=>'radius','value'=>'cari'));?></td>
		</tr>
	</table>
	<?=form_close();?>

	<table class="list">
		<tr id="caption">
			<td>No</td>
			<td>Nama Jenis</td>
			<td>Actions</td>
		</tr>
		<?php
			
			$x = 1;
			foreach ($fetch as $row) {
				$class = $x % 2 == 1 ? 'odd' : 'even';
				
				echo "
					<tr class='".$class."'>
						<td style='text-align: center;'>".$x."</td>
						<td>".$row->nama_type."</td>
						<td style='text-align: center;'>
							".anchor('type_atk/edit/'.$row->id_type, '<img src="'.base_url('assets/img/edit.png').'" alt="edit" />', array('title'=>'Edit'))."  
							".anchor('type_atk/delete/'.$row->id_type, '<img src="'.base_url('assets/img/failed.png').'" alt="delete" />', array('title'=>'Delete','onclick'=>"return confirm('Apakah anda yakin ingin menghapus data ini?');"))."
						</td>
					</tr>
				";
				
				$x++;
			}
		
		?>
	</table>
</div>