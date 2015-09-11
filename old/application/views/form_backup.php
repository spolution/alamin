
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/database.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>

<div class='item'>
	<?php
	
		if (validation_errors()) {
			echo validation_errors();
		}
	
		echo form_open('backup/do_backup', array('onsubmit'=>'return confirm(\'Proses ini akan mem-backup table-table yang anda centang. Lanjutkan?\');'));
		
	?>
	
	<table class="list">
		<tr id="caption">
			<td>No</td>
			<td>Nama table</td>
			<td><input type="checkbox" id="c_all" /> <label for="c_all">pilih semua</label></td>		
		</tr>
		<?php
		
			$x = 1;
			foreach ($tables->result_array() as $row) {
				$class = $x % 2 == 0 ? 'odd' : 'even';
				
				echo '
					<tr class="'.$class.'">
						<td style="text-align: center;">'.$x.'</td>
						<td><label for="'.$row['Tables_in_al_amin_v1.1'].'">'.strtoupper($row['Tables_in_al_amin_v1.1']).'</label></td>
						<td style="text-align: center;"><input type="checkbox" name="tables[]" id="'.$row['Tables_in_al_amin_v1.1'].'" value="'.$row['Tables_in_al_amin_v1.1'].'" /></td>
					</tr>
				';
				
				$x++;
			}
		
		?>
		<tr>
			<td colspan="3" style="text-align: center;">
				<?php echo form_submit(array('name'=>'backup','class'=>'radius','value'=>'backup database')); ?>
			</td>
		</tr>
	</table>
	<?php echo form_close(); ?>
</div>

<script type="text/javascript">
	$(function(){
		$('#c_all').click(function(){
			$(this).parents('table.list:eq(0)').
					find(':checkbox').attr('checked', this.checked);
		});
	});
</script>