<?php
require_once('system/system.php');

#- vote
if (!isset($_SESSION['signature'])) header('Location: index.php');

if (isset($_GET['com']) and $_GET['com'] == 'vote') {
	$id		= uuid();
	$waktu	= $_SESSION['waktu']; #date('Y-m-d H:i:s');
	$ip		= $_SERVER['REMOTE_ADDR'];
	$nilai	= $_GET['nilai'];
	$layanan = $_SESSION['layanan']; #- Add : 23-08-2021
	$signature = $_SESSION['koresponden_id'];

	$sql = "INSERT INTO polling SET id='$id', satuan='$SatuanID', layanan='$layanan', waktu='$waktu', ip='$ip', nilai='$nilai', signature='$signature'";
	$exe = _query($sql);
	if ($exe) {
		echo 1;
		$_SESSION['status_ikm'] = '1';
	} else {
		echo 0;
		$_SESSION['status_ikm'] = '0';
	}
	exit();
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
	<meta charset="utf-8">
	<title>IKM : Polres Karanganyar</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="Aplikasi Indeks Kepuasan Masyarakat">
	<meta name="author" content="CV Cipta Mandiri Solusindo">
	<link rel="shortcut icon" href="public/logo/logo_polri.png" />
	<style>
		body {
			font-family: 'Tahoma';
			background-color: #000;
			color: #fff;
		}

		.intro {
			font-family: 'Arial';
			color: yellow;
			font-size: 25px;
			text-align: center;
		}

		.intro2 {
			font-family: 'Arial';
			color: yellow;
			font-size: 17px;
			text-align: center;
		}

		.overlay {
			height: 0%;
			width: 100%;
			position: fixed;
			z-index: 1;
			top: 0;
			left: 0;
			background-color: rgb(0, 0, 0);
			background-color: rgba(0, 0, 0, 0.9);
			overflow-y: hidden;
			transition: 0.5s;
		}

		.overlay-content {
			position: relative;
			top: 15%;
			width: 100%;
			text-align: center;
			margin-top: 30px;
			font-size: 30px;
			font-weight: bold;
		}

		.overlay a {
			padding: 8px;
			text-decoration: none;
			font-size: 36px;
			color: #fff;
			display: block;
			transition: 0.3s;
		}

		.overlay a:hover,
		.overlay a:focus {
			color: #f1f1f1;
		}

		.overlay .closebtn {
			position: absolute;
			top: 20px;
			right: 45px;
			font-size: 60px;
		}

		.img_emoticon {
			width: 150px;
			height: auto;
		}


		.kop {
			width: 950px;
			border-spacing: 0px;
			margin-top: 0;
			margin-bottom: 60px;
		}

		.kop td {
			border: 0px solid;
			font-weight: bold;
			padding: 0;
			spacing: 0;
		}

		.logo_kop {
			width: auto;
			height: 100px;
		}

		.kop1 {
			font-size: 30px;
		}

		.kop2 {
			font-size: 20px;
		}


		.tabel_opsi {
			border-spacing: 0px;
			margin-top: 0;
		}

		.tabel_opsi td {
			border: 0px solid;
			padding: 0 60px 0 60px;
		}


		@media screen and (max-width: 1080px) {
			.tabel_opsi td {
				border: 0px solid;
				padding: 0 60px 0 60px;
			}

			.img_emoticon {
				width: 100px;
				height: auto;
			}

			.overlay-content {
				position: relative;
				top: 10%;
				width: 100%;
				text-align: center;
				margin-top: 30px;
				font-size: 30px;
				font-weight: bold;
			}

			.kop {
				width: 900px;
				margin-bottom: 50px;
			}

			.logo_kop {
				width: auto;
				height: 90px;
			}

			.kop1 {
				font-size: 30px;
			}

			.kop2 {
				font-size: 20px;
			}

			.intro {
				font-size: 25px;
			}

			.intro2 {
				font-size: 17px;
			}
		}

		@media screen and (max-width: 960px) {
			.tabel_opsi td {
				border: 0px solid;
				padding: 0 50px 0 50px;
			}

			.img_emoticon {
				width: 100px;
				height: auto;
			}

			.overlay-content {
				margin-top: 30px;
				font-size: 20px;
			}

			.kop {
				width: 680px;
				margin-bottom: 20px;
			}

			.logo_kop {
				width: auto;
				height: 80px;
			}

			.kop1 {
				font-size: 25px;
			}

			.kop2 {
				font-size: 15px;
			}

			.intro {
				font-size: 18px;
			}

			.intro2 {
				font-size: 15px;
			}
		}

		@media screen and (max-width: 780px) {
			.tabel_opsi td {
				border: 0px solid;
				padding: 0 30px 0 30px;
			}

			.img_emoticon {
				width: 90px;
				height: auto;
			}

			.overlay-content {
				margin-top: 30px;
				font-size: 20px;
			}

			.kop {
				width: 550px;
				margin-bottom: 20px;
			}

			.logo_kop {
				width: auto;
				height: 70px;
			}

			.kop1 {
				font-size: 20px;
			}

			.kop2 {
				font-size: 12px;
			}

			.intro {
				font-size: 18px;
			}

			.intro2 {
				font-size: 12px;
			}
		}

		@media screen and (max-width: 460px) {
			.tabel_opsi td {
				border: 0px solid;
				padding: 0 10px 0 10px;
			}

			.img_emoticon {
				width: 80px;
				height: auto;
			}

			.overlay-content {
				margin-top: 30px;
				font-size: 15px;
			}

			.kop {
				width: 100%;
				margin-bottom: 50px;
			}

			.logo_kop {
				width: 0;
				height: 0;
			}

			.kop1 {
				font-size: 15px;
			}

			.kop2 {
				font-size: 12px;
			}

			.intro {
				font-size: 15px;
			}

			.intro2 {
				font-size: 12px;
			}
		}
	</style>
	<script type="text/javascript" src="public/assets/js/jquery-3.4.1.min.js"></script>
	<script>
		$(document).ready(function() {
			$("#nilai_5").click(function() {
				$.ajax({
					type: "get",
					url: "index2.php?com=vote",
					data: "nilai=5",
					success: function(msg) {
						if (msg == 1) openNav_5();
						else alert('Gagal menyimpan pilihan');
						setTimeout("location.href = 'menu.php';", 3000);
					}
				});
			});
			$("#nilai_4").click(function() {
				$.ajax({
					type: "get",
					url: "index2.php?com=vote",
					data: "nilai=4",
					success: function(msg) {
						if (msg == 1) openNav_4();
						else alert('Gagal menyimpan pilihan');
						setTimeout("location.href = 'menu.php';", 3000);
					}
				});
			});
			$("#nilai_2").click(function() {
				$.ajax({
					type: "get",
					url: "index2.php?com=vote",
					data: "nilai=2",
					success: function(msg) {
						if (msg == 1) openNav_2();
						else alert('Gagal menyimpan pilihan');
						setTimeout("location.href = 'menu.php';", 3000);
					}
				});
			});
		});
	</script>
</head>

<body>




	<table align="center" cellpadding="0" cellspacing="0" class="kop" border="0">
		<tr>
			<td align="center">
				<img src="public/logo/logo_polri.png" border="0" class="logo_kop">
			</td>
			<td align="center">
				<font class="kop1"><strong>SATLANTAS POLRES KARANGANYAR</strong></font><br>
				<font class="kop2">Jl. A. Yani No.1, Ngarus, Kec. Karanganyar, Kabupaten Karanganyar<br>
					Jawa Tengah Kodepos 59112</font>
			</td>
			<td align="center">
				<a href="statistik.php"><img src="public/logo/logo_polda_jateng.png" border="0" class="logo_kop"></a>
			</td>
		</tr>
	</table>
	<p class="intro">
		Puaskah Anda Dengan Pelayanan di Kantor Kami? <br>
		<font class="intro2"> Pilih Dengan Menekan Salah Satu Tombol Dibawah Ini</font>
	</p>
	<table align="center" class="tabel_opsi">
		<tr>
			<td>
				<img src="public/icons/icon_t_1.png" class="img_emoticon" id="nilai_5">
			</td>
			<td>
				<img src="public/icons/icon_t_2.png" class="img_emoticon" id="nilai_4">
			</td>
			<td>
				<img src="public/icons/icon_t_3.png" class="img_emoticon" id="nilai_2">
			</td>
		</tr>
	</table>
	<p class="kop2" align="center" style="margin-top:30px;">
		<font class="intro"><strong><span id="jam"></span>:<span id="menit"></span>:<span id="detik"></span></strong></font><br>
		<?php echo Hari(date('D')); ?>, <?php echo tglIndo(date('Y-m-d')); ?>
	</p>
	<!-- SANGAT PUAS -->
	<div id="myNav_5" class="overlay">
		<div class="overlay-content">
			<p align="center">
				<img src="public/icons/icon_tt_1.png" class="img_emoticon">
			</p>
			<p align="center">
				<font color="yellow">TERIMA KASIH...!!!</font>
			</p>
			<p align="center">Anda Telah Membantu Kami<br>Untuk Melayani Lebih Baik Lagi.</p>
		</div>
	</div>

	<!-- PUAS -->
	<div id="myNav_4" class="overlay">
		<div class="overlay-content">
			<p align="center">
				<img src="public/icons/icon_tt_2.png" class="img_emoticon">
			</p>
			<p align="center">
				<font color="yellow">TERIMA KASIH...!!!</font>
			</p>
			<p align="center">Anda Telah Membantu Kami<br>Untuk Melayani Lebih Baik Lagi.</p>
		</div>
	</div>

	<!-- TIDAK PUAS -->
	<div id="myNav_2" class="overlay">
		<div class="overlay-content">
			<p align="center">
				<img src="public/icons/icon_tt_3.png" class="img_emoticon">
			</p>
			<p align="center">
				<font color="yellow">TERIMA KASIH...!!!</font>
			</p>
			<p align="center">Anda Telah Membantu Kami<br>Untuk Melayani Lebih Baik Lagi.</p>
		</div>
	</div>

	<audio id="audio" src="public/sound/terima_kasih.mp3"></audio>
	<script>
		//-- SOUND
		function play() {
			var audio = document.getElementById("audio");
			audio.play();
		}

		function EvalSound(soundobj) {
			var thissound = document.getElementById(soundobj);
			thissound.Play();
		}

		//-- JAM
		window.setTimeout("waktu()", 1000);

		function waktu() {
			var waktu = new Date();
			setTimeout("waktu()", 1000);
			var jam = waktu.getHours();
			if (jam < 10) jam = "0" + jam;
			var menit = waktu.getMinutes();
			if (menit < 10) menit = "0" + menit;
			var detik = waktu.getSeconds();
			if (detik < 10) detik = "0" + detik;
			document.getElementById("jam").innerHTML = jam;
			document.getElementById("menit").innerHTML = menit;
			document.getElementById("detik").innerHTML = detik;
		}

		//-- SANGAT PUAS
		function openNav_5() {
			document.getElementById("myNav_5").style.height = "100%";
			play();
			setTimeout(closeNav_5, 1500);
		}

		function closeNav_5() {
			document.getElementById("myNav_5").style.height = "0%";
		}
		//-- PUAS
		function openNav_4() {
			document.getElementById("myNav_4").style.height = "100%";
			play();
			setTimeout(closeNav_4, 1500);
		}

		function closeNav_4() {
			document.getElementById("myNav_4").style.height = "0%";
		}
		//-- TIDAK PUAS
		function openNav_2() {
			document.getElementById("myNav_2").style.height = "100%";
			play();
			setTimeout(closeNav_2, 1500);
		}

		function closeNav_2() {
			document.getElementById("myNav_2").style.height = "0%";
		}
	</script>

</body>

</html>