
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/users.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>
<div class="item">
	<div onClick="window.location.href='<?php echo site_url('member/add'); ?>'" class="tools" id="t-1" onmouseover="get_effect('t-1')" onmouseout="remove_effect('t-1')" title="Ke Form Tambah Member">
		<img src="<?php echo base_url('assets/img/button-add.png'); ?>" alt="add" />
	</div>
	
	<?php
	
		if($this->session->flashdata('success_delete')){
			echo $this->session->flashdata('success_delete');
		}elseif($this->session->flashdata('success_add')){
			echo $this->session->flashdata('success_add');
		}
	
	?>
	
	<table class="list">
		<tr id="caption">
			<td>No</td>
			<td>Nama</td>
			<td>Nomor Telepon</td>
			<td>Actions</td>
		</tr>
		<?php
			
			$x = 1;
			foreach ($fetch as $row) {
				$class = $x % 2 == 1 ? 'odd' : 'even';
				
				echo "
					<tr class='".$class."'>
						<td style='text-align: center;'>".$x."</td>
						<td>".$row->nama."</td>
						<td>".$row->no_tlpn."</td>
						<td style='text-align: center;'> 
							".anchor('member/edit/'.$row->id_member, '<img src="'.base_url('assets/img/edit.png').'" alt="edit" />', array('title'=>'Edit'))."
							".anchor('member/delete/'.$row->id_member, '<img src="'.base_url('assets/img/failed.png').'" alt="delete" />', array('title'=>'Delete','onclick'=>"return confirm('Apakah anda yakin ingin menghapus data ini?');"))."
						</td>
					</tr>
				";
	
				$x++;
			}
		
		?>
	</table>
</div>