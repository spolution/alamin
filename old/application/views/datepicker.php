<html>
	<head>
		<title>DatePicker</title>
	<link href="<?=base_url("assets/css/ui.all.css");?>" rel="stylesheet" type="text/css" media="screen" />
	<script type="text/javascript" src="<?=base_url("assets/js/jquery-1.4.3.min.js");?>"></script>
	<script type="text/javascript" src="<?=base_url("assets/js/ui.datepicker.js");?>"></script>
	<script type="text/javascript">
		$(function(){
			$("#tanggal").datepicker({
				dateFormat		: "yy-mm-dd",
				changeMonth		: true,
				changeYear		: true
			});
		});
	</script>
	</head>
<body>
	<form method="POST" action="">
		<input type="text" name="tanggal" id="tanggal" />
	</form>
</body>
</html>