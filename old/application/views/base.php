<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title><?php echo $title; ?></title>
		
		<link rel="stylesheet" href="<?php echo base_url('assets/css/reset.css'); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>" type="text/css" />
		<link rel="stylesheet" href="<?php echo base_url("assets/css/ui.all.css");?>" type="text/css" />
		
		<script type="text/javascript" src="<?php echo base_url('assets/js/jquery-1.4.3.min.js'); ?>"></script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/ui.datepicker.js'); ?>"></script>
		<script type="text/javascript">var site_url = '<?php echo site_url('/') ?>';</script>
		<script type="text/javascript" src="<?php echo base_url('assets/js/my_js.js'); ?>"></script>
	</head>
	<body>	
		<header>
			<div class="main center">
				<a id="logo" class="center" href="<?php echo base_url(); ?>"><img src="<?php echo base_url('assets/img/logo-3.png'); ?>" alt="Logo" /></a>
				
				<nav class="main center">
					<ul id="nav">
						<li class="<?php echo $cur_nav['beranda']; ?>"><?php echo anchor(null, 'beranda'); ?></li>
						<li class="<?php echo $cur_nav['kartu']; ?>"><?php echo anchor('kartu', 'kartu'); ?></li>
						<li class="<?php echo $cur_nav['mc']; ?>"><span>master card</span>
							<ul>
								<li><?php echo anchor('master_card/index/1', 'satuan'); ?></li>
								<li><?php echo anchor('master_card/index/2', 'pulsa'); ?></li>
							</ul>
						</li>
						<li class="<?php echo $cur_nav['penjualan']; ?>"><span>penjualan</span>
							<ul>
								<li><span>pulsa elektrik</span>
									<ul>
										<li><?php echo anchor('tracking/index/1', 'satuan'); ?></li>
										<li><?php echo anchor('tracking/index/2', 'pulsa'); ?></li>
									</ul>
								</li>
								<li><span>pulsa fisik</span>
									<ul>
										<li><?php echo anchor('voucher', 'data penjualan'); ?></li>
										<li><?php echo anchor('master_voucher', 'deposit'); ?></li>
									</ul>
								</li>
								<li><?php echo anchor('perdana', 'kartu perdana'); ?></li>
								<li><span>akesoris</span>
									<ul>
										<li><?php echo anchor('aksesoris', 'data penjualan'); ?></li>
										<li><?php echo anchor('master_aksesoris', 'deposit'); ?></li>
										<li><?php echo anchor('type_aksesoris', 'jenis aksesoris'); ?></li>
									</ul>
								</li>
								<li><span>alat tulis kantor</span>
									<ul>
										<li><?php echo anchor('atk', 'data penjualan'); ?></li>
										<li><?php echo anchor('master_atk', 'deposit'); ?></li>
										<li><?php echo anchor('type_atk', 'jenis alat tulis kantor'); ?></li>
									</ul>
								</li>
								<li><?php echo anchor('tracking/hutang', 'daftar hutang'); ?></li>
							</ul>
						</li>
						<li class="<?php echo $cur_nav['member']; ?>"><?php echo anchor('member', 'data member'); ?></li>
						<li class="<?php echo $cur_nav['lap']; ?>"><span>laporan</span>
							<ul>
								<li><?php echo anchor('report/create','bulan ini', array('onClick'=>'return confirm(\'Lanjutkan pembuatan laporan bulan ini?\');')); ?></li>
								<li><?php echo anchor('report/costumize','bulan yang ditentukan'); ?></li>
							</ul>
						</li>
						<li class="<?php echo $cur_nav['backup']; ?>"><?php echo anchor('backup', 'backup'); ?></li>
						<li><?php echo anchor('admin/logout', 'logout', array('onClick' => "return confirm('Apakah anda yakin ingin keluar dari aplikasi?');")); ?></li>
					</ul>
				</nav>
				
				<div id="time"><h3 id="h2time"></h3></div>
				<div id="title-inform">
					<h2 class="two hidden" style="padding: 17px 35px;" title="&laquo; Home" onClick="window.location.href='<?php echo site_url(); ?>'"><img src="<?php echo base_url('assets/img/a-letter.png'); ?>" alt="a" /></h2>
					<?php
					
						$class = array('three','four','five','six'); $x = 0;
						
						foreach($title_inf as $cap => $link){
							echo '<h2 class="'.$class[$x].' hidden" onClick="window.location.href=\''.site_url($link).'\'">'.$cap.'</h2>';
							$x++;
						}
					
					?>
				</div>
				<div style="background-color: #383838; height: 8px; box-shadow: 1px 1px 3px #333333;" class="main"></div>
				<div class="endFloat"></div>
				
			</div>
		</header>
		
		<section id="container" class="one hidden">
			<div class="main center">
				<?php $this->load->view($container); ?>
			</div>
		</section>
		<footer>
			<div class="top">
				<?php
					
					echo anchor('','beranda');
					echo anchor('home/contact','kontak');
					echo anchor('home/about','tentang');
					echo anchor('home/help','bantuan');
					echo anchor('admin/logout','logout');
				
				?>
			</div>
			<div class="bottom">
				<br />
				<p>&copy;2013 <?php echo anchor(null, 'Al-Amin - Sistem Aplikasi Counter Pulsa'); ?>. All Rights Reserved.</p>
				<p>
					Designer & Developer : Aldi Unanto<br />
					aldiunanto@yahoo.com
				</p>
			</div>
		</footer>
	</body>
</html>