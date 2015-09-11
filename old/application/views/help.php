
<div class="item" style="background: #ffffff url('<?php echo base_url('assets/img/retro-blue2.png'); ?>') no-repeat right top; padding-bottom: 1px;">
	<img src="<?php echo base_url('assets/img/question.png'); ?>" class="caption" />
	<h1 class="pg-title"><?php echo $h1; ?></h1>
</div>

<div class='item'>
	<ul>
		<li>Saldo berjenis pulsa, bisa diisi di halaman <?=anchor('kartu','Kartu');?>. Sedangkan saldo berjenis satuan 
			bisa diisi di halaman <?=anchor('master_card/index/1','Master Card');?>
		</li>
		<li>Aplikasi ini dilengkapi dengan security program yang mendukung, jadi sebelum melakukan proses tracking di handphone operator,<br />
			hendaknya mengisi formulir track terlebih dahulu.
		</li>
		<li>
			Konsumen yang belum membayar(hutang) bisa diberikan keterangan di form tracking<br />dengan megisikan
			"Hutang" atau "Ngutang" atau sejenisnya (Diwajibkan menulis kata yang mengandung "tang").<br />
			pengguna bisa melihat berapa total hutang konsumen di halaman <?=anchor('tracking/hutang','Daftar Hutang');?><br />
			dengan melakukan pencarian terlebih dahulu berdasarkan kategori yang dipilih.
		</li>
		<li>
			Jika dalam proses tracking, pengguna melakukan salah kirim atau terkirim dua kali,<br />maka isilah pada form <i>Keterangan</i> dengan <i>false</i>
			Maka akan secara otomatis data tersebut masuk kedalam daftar kerugian.
		</li>
	</ul>
</div>