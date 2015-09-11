<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Login Administrator</title>
		
		<link href="<?php echo base_url('assets/css/reset.css');?>" rel="stylesheet" media="screen" type="text/css" />
		<link href="<?php echo base_url('assets/css/login_style.css');?>" rel="stylesheet" media="screen" type="text/css" />
		<link href="<?php echo base_url('assets/css/tips-form.css');?>" rel="stylesheet" media="screen" type="text/css" />
		
		<script type='text/javascript' src='<?php echo base_url('assets/js/jquery.tools.min.js');?>'></script>
	</head>

	<body>
		<section id="container">
			<div class="main center">
				<div id="back" class="center">
					<div class="frame">
						<img src="<?php echo base_url('assets/img/a-letter.png'); ?>" alt="A" />
						<hgroup>
							<h1>al - amin cell</h1>
							<h3>Sistem aplikasi counter pulsa</h3>
						</hgroup>
						<div class="endFloat"></div>
						
						<?php
				
							if (validation_errors()) {
								echo validation_errors();
							}elseif ($this->session->flashdata('error_login')){
								echo $this->session->flashdata('error_login');
							}
						
						?>
						<div style="opacity: 0.7; position: absolute; top: 298px; left: 338px; display: none;" class="tooltip"></div>
						
						<?php echo form_open('admin/login', array('id' => 'myform')); ?>
						<table class="center">
							<tr>
								<td><label for="username"><img src="<?php echo base_url('assets/img/user.png'); ?>" alt="username" title="Username" /></label></td>
								<td><?php echo form_input(array('name'=>'username','id'=>'username','title'=>'Masukkan Username yang sudah terdata','placeholder'=>'Username ...')); ?></td>
							</tr>
							<tr>
								<td><label for="psw"><img src="<?php echo base_url('assets/img/lock.png'); ?>" alt="password" title="Password" /></label></td>
								<td><?php echo form_password(array('name'=>'psw','id'=>'psw','title'=>'Masukkan Password yang sudah terdata','placeholder'=>'Password ...')); ?></td>
							</tr>
							<tr>
								<td>&nbsp;</td>
								<td>
									<?php
									
										echo form_button('login', '<img src="'.base_url('assets/img/navigation-right.png').'" alt="power" />', 'class="radius" title="Masuk Ke Aplikasi" onClick="this.form.submit()"').
											 '&emsp;'.form_button('reset', '<img src="'.base_url('assets/img/button-rotate-cw.png').'" alt="reset" />', 'class="radius" title="Bersihkan" onClick="window.location.reload(true)"');
										
									?>
								</td>
							</tr>
						</table>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</section>
		
		<script type="text/javascript">
		
			$(function(){
				$('div#back').fadeIn(800);
				$('input#username').focus();
				
				$("form#myform :input").tooltip({
					position: "center right",
				    offset: [-2, 10],
					effect: "fade",
					opacity: 0.7,
					tip: '.tooltip'
		
				});
				
			});
		
		</script>
	</body>
</html>