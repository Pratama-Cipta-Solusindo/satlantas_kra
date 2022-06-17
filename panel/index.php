<?php
require_once('../system/system.php');
#echo md5(base64_encode('sattahti'));
#die();
if (!isset($_SESSION['cmsLogin'])) {
	header('Location: login.php');
	exit();
}

$start_time = microtime(true);
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
	<meta charset="utf-8">
	<title>IKM : Control Panel</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="Aplikasi Indeks Kepuasan Masyarakat">
	<meta name="author" content="CV Cipta Mandiri Solusindo">

	<!-- Bootstrap core CSS -->
	<link href="../public/assets/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="../public/assets/css/sticky-footer-navbar.css" rel="stylesheet">

	<!-- styles for datatables -->
	<link rel="stylesheet" type="text/css" href="../public/vendor/DataTables/datatables.min.css" />

	<!-- styles for font-awesome -->
	<link href="../public/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">

	<!-- Chart.js -->
	<script src="../public/vendor/Chart.js/dist/Chart.min.js"></script>
	<script src="../public/vendor/Chart.js/samples/utils.js"></script>
	<style>
		canvas {
			-moz-user-select: none;
			-webkit-user-select: none;
			-ms-user-select: none;
		}
	</style>

</head>

<body>
	<!-- Begin page content -->
	<!--<main role="main" class="container">-->
	<div class="container-fluid">
		<div class="row" style="margin-top: 1em;">
			<div class="col-lg-3 col-md-3 col-sm-3">
				<div class="card">
					<div class="card-header" align="center">
						<a href="index.php"><img src="../public/logo/logo_polda_jateng_satlantas.png" class="img-fluid" width="170"></a><br>
						<strong>INDEKS KEPUASAN MASYARAKAT</strong><br>
						<strong>SATLANTAS <br>POLRES KARANGANYAR</strong>
					</div>
					<div class="card-footer" align="center">
						<strong>I K M</strong>
					</div>
					<div class="card-body">
						<a class="nav-link" href="index.php">Home</a>
						<a class="nav-link" href="index.php?com=ikm&mod=hari">Statistik IKM Hari Ini </a>
						<a class="nav-link" href="index.php?com=ikm&mod=bulan">Statistik IKM Bulan Ini </a>
						<a class="nav-link" href="index.php?com=ikm&mod=tahun">Statistik IKM Tahun Ini </a>
						<a class="nav-link" href="index.php?com=ikm&mod=minggu">Statistik IKM Mingguan </a>
						<a class="nav-link" href="index.php?com=detail">Detail Statistik</a>
					</div>
					<div class="card-footer" align="center">
						<strong>S U R V E Y</strong>
					</div>
					<div class="card-body">
						<a class="nav-link" href="index.php?com=kuisioner">Daftar Kuisioner</a>
						<a class="nav-link" href="index.php?com=kategori">Daftar Kategori Pertanyaan</a>
						<a class="nav-link" href="index.php?com=soal">Daftar Pertanyaan</a>
						<a class="nav-link" href="index.php?com=data_survey">Data Survey </a>
						<a class="nav-link" href="index.php?com=statistik_survey">Statistik Survey </a>
						<?php
						if ($_SESSION['cmsLevel'] == 'root' or $_SESSION['cmsLevel'] == '1') {
						?>
							<!--<a class="nav-link" href="index.php?com=input_kuisioner">Input Data Per Bulan </a>-->
							<a class="nav-link" href="index.php?com=input_kuisioner_tanggal">Input Data Per Tanggal</a>
						<?php
						}
						?>
					</div>
					<div class="card-footer" align="center">
						<strong>SINGKRONISASI</strong>
					</div>
					<div class="card-body">
						<a class="nav-link" href="index.php?com=singkron_master">Singkron Data Master</a>
						<a class="nav-link" href="index.php?com=singkron">Singkron Data Transaksi</a>
					</div>
					<div class="card-footer" align="center">
						<strong>U S E R</strong>
					</div>
					<div class="card-body">
						<a class="nav-link" href="index.php?com=profil">Ubah Password</a>
						<a class="nav-link" href="login.php?com=logout"><strong>LOGOUT</strong></a>
					</div>
				</div>
				<div> &nbsp;</div>
			</div>
			<div class="col-md-9 col-sm-9 col-xs-12">
				<?php
				if (!empty($com)) {
					if (file_exists('apps/' . $com . '.php')) {
						include 'apps/' . $com . '.php';
					} else {
						include 'apps/ikm.php';
						exit();
					}
				} else {
					if (file_exists('apps/ikm.php')) {
						include 'apps/ikm.php';
					} else {
						die('#system_offline');
					}
				}
				?>
			</div>
		</div>
	</div>
	<!--</main>-->
	<?php
	$end_time = microtime(true);
	$lama = $end_time - $start_time;
	//echo "<span style='padding-left: 16px;'>process time : " . $lama . " ms</span>";
	?>

	<!-- Bootstrap core JavaScript
================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="../public/assets/js/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script>
		window.jQuery || document.write('<script src="public/assets/js/jquery-slim.min.js"><\/script>')
	</script>
	<script src="../public/assets/js/popper.min.js"></script>
	<script src="../public/assets/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../public/vendor/DataTables/datatables.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.dataTable').DataTable();

			$("#progress").hide();

			$('#sinkron_master_submit').click(function() {
				var data = $("#data").val();
				//alert(data);
				$.ajax({
					type: "get",
					url: "index.php?com=singkron_master&jumlah=true",
					data: "data=1",
					success: function(msg) {
						alert(1);
						alert(msg);
					}
				});
			});

		});
	</script>
</body>

</html>