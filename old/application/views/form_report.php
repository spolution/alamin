
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/book-open-bookmark.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>

<div class='item'>
	<?php
	
		if($this->session->flashdata('free')){ echo $this->session->flashdata('free'); }
		echo form_open('report/create');
		
	?>
	
		<table class="input">
			<tr>
				<td>
					<label for="tgl_1">Cetak Laporan dari tanggal :</label><br />
					<?php echo form_input(array('name'=>'tgl_1','id'=>'tgl_1','onmouseover'=>'get_datePlugin(\'tgl_1\')','value'=>$data['tgl_1'])); ?>
				</td>
				<td>
					<label for="tgl_2">sampai tanggal :</label><br />
					<?php echo form_input(array('name'=>'tgl_2','id'=>'tgl_2','onmouseover'=>'get_datePlugin(\'tgl_2\')','value'=>$data['tgl_2'])); ?>
				</td>
			<tr>
				<td colspan='2'>
					<?=form_submit(array('name'=>'create','value'=>'buat laporan!','class'=>'radius'));?>
				</td>
			</tr>
		</table>
		
	<?=form_close();?>
</div>