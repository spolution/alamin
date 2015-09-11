
<style type="text/css">
	<!--
	
		ul#log li{
			padding: 4px 2px;
			border-bottom: 1px solid #c2c1c1;
			margin-bottom: 4px;
		}
	
	-->
</style>
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/home.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>
<div class="item">

	<?php if(empty($_POST)){ echo $pagination; } ?>
	
	<table class="list">
		<tr id="caption">
			<td>No</td>
			<td>What did I do last? These are the 10 latest.</td>
			<td>When?</td>
		</tr>
		<?php
		
			$x = 1;
			foreach ($log_list as $val) {
				$class = $x % 2 == 0 ? 'odd' : 'even';
				
				echo '
					<tr class="'.$class.'">
						<td style="text-align: center;">'.$numb.'</td>
						<td>'.$val->text.'</td>
						<td style="text-align: center;">'.$val->date.'</td>
					</tr>
				';
				
				$numb++;
				$x++;
			}
		
		?>
	</table>
	
	<?php echo $pagination; ?>
</div>