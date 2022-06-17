<?php
require_once('../system/system.php');

$com = isset($_GET['com']) ? $_GET['com'] : '';
$com = strtolower(str_replace('/', '', $com));
$com = strtolower(str_replace('.', '', $com));
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
	<meta charset="utf-8">
	<title>IKM </title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="description" content="Aplikasi Indeks Kepuasan Masyarakat">
	<meta name="author" content="CV Cipta Mandiri Solusindo">
	<!-- Chart.js -->
	<script src="../public/vendor/Chart.js/dist/Chart.min.js"></script>
	<script src="../public/vendor/Chart.js/samples/utils.js"></script>
	<style>
		body {
			font-family: 'Arial';
			font-size: 14px;
			margin-left: 0 px;
			margin-top: 0px;
			margin-right: 0px;
			margin-bottom: 0px;
			background-color: #FFF;
		}

		.kop {
			width: 850px;
			border-spacing: 0px;
			margin-top: 0;
			margin-bottom: 20px;
		}

		.tabel_isi {
			width: 850px;
			border-spacing: 0px;
			margin-top: 0;
			margin-bottom: 30px;
		}

		.logo_kop {
			width: auto;
			height: 100px;
		}

		.f30 {
			font-size: 30px;
		}

		.f20 {
			font-size: 20px;
		}

		.f15 {
			font-size: 15px;
		}

		.tabel_data {
			border-top-width: 1px;
			border-right-width: 1px;
			border-bottom-width: 1px;
			border-left-width: 1px;
			border-top-style: solid;
			border-right-style: none;
			border-bottom-style: none;
			border-left-style: solid;
			border-top-color: #000000;
			border-right-color: #000000;
			border-bottom-color: #000000;
			border-left-color: #000000;
		}

		.tabel_data td {
			border-top: 1px none #000000;
			border-right: 1px solid #000000;
			border-bottom: 1px solid #000000;
			border-left: 1px none #000000;
			padding-left: 4px;
			padding-right: 4px;
			padding-bottom: 0px;
			padding-top: 0px;
		}

		.tabel_noborder {
			border-top-width: 0px;
			border-right-width: 0px;
			border-bottom-width: 0px;
			border-left-width: 0px;
			border-top-style: solid;
			border-right-style: none;
			border-bottom-style: none;
			border-left-style: solid;
			border-top-color: #000000;
			border-right-color: #000000;
			border-bottom-color: #000000;
			border-left-color: #000000;
		}

		.tabel_noborder td {
			border-top: 0px none #000000;
			border-right: 0px solid #000000;
			border-bottom: 0px solid #000000;
			border-left: 0px none #000000;
			padding-left: 4px;
			padding-right: 4px;
			padding-bottom: 0px;
			padding-top: 0px;
		}

		canvas {
			-moz-user-select: none;
			-webkit-user-select: none;
			-ms-user-select: none;
		}
	</style>

</head>

<body>

	<table align="center" cellpadding="0" cellspacing="0" class="kop" border="0">
		<tr>
			<td align="center">
				<img src="../public/logo/logo_polri.png" border="0" class="logo_kop">
			</td>
			<td align="center">
				<font class="f30"><strong>SATLANTAS POLRES KARANGANYAR</strong></font><br>
				<font class="f20">Jl. Lawu, Dompon, Karanganyar, Kec. Karanganyar, Kab Karanganyar<br>
					Jawa Tengah Kodepos 57711</font>
			</td>
			<td align="center">
				<a href="index.php"><img src="../public/logo/logo_polda_jateng.png" border="0" class="logo_kop"></a>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<hr size="3" color="#000">
			</td>
		</tr>
	</table>

	<?php
	if ($com == '') {
		#-- Tahun
		$sql = "SELECT LEFT(waktu, 4) AS tahun FROM polling GROUP BY LEFT(waktu, 4) ORDER BY waktu ASC";
		$exe = _query($sql);
		$listTahun 		= array();
		$listSangatPuas	= array();
		$listPuas		= array();
		$listTidakPuas	= array();
		while ($row = _object($exe)) {
			$listTahun[$row->tahun] = "'" . $row->tahun . "'";
			$listSangatPuas[$row->tahun]	= 0;
			$listPuas[$row->tahun] 			= 0;
			$listTidakPuas[$row->tahun] 	= 0;
		}
		$labelTahun = implode(', ', $listTahun);

		#-- Data Sangat Puas
		$sql = "SELECT LEFT(waktu, 4) AS tahun, COUNT(nilai) AS data FROM polling WHERE satuan='$SatuanID' AND nilai='5' GROUP BY LEFT(waktu, 4) ORDER BY waktu ASC";
		$exe = _query($sql);
		while ($row = _object($exe)) {
			$listSangatPuas[$row->tahun] = $row->data;
		}
		$labelSangatPuas = implode(', ', $listSangatPuas);

		#-- Data Puas
		$sql = "SELECT LEFT(waktu, 4) AS tahun, COUNT(nilai) AS data FROM polling WHERE satuan='$SatuanID' AND nilai='4' GROUP BY LEFT(waktu, 4) ORDER BY waktu ASC";
		$exe = _query($sql);
		while ($row = _object($exe)) {
			$listPuas[$row->tahun] = $row->data;
		}
		$labelPuas = implode(', ', $listPuas);

		#-- Data Tidak Puas
		$sql = "SELECT LEFT(waktu, 4) AS tahun, COUNT(nilai) AS data FROM polling WHERE satuan='$SatuanID' AND nilai='2' GROUP BY LEFT(waktu, 4) ORDER BY waktu ASC";
		$exe = _query($sql);
		while ($row = _object($exe)) {
			$listTidakPuas[$row->tahun] = $row->data;
		}
		$labelTidakPuas = implode(',', $listTidakPuas);
	?>
		<table align="center" cellpadding="0" cellspacing="0" class="tabel_isi" border="0">
			<tr>
				<td align="center">
					<font class="f20"><strong>Statistik Indeks Kepuasan Masyarakat</strong></font>
				</td>
			</tr>
			<tr>
				<td align="center">&nbsp; </td>
			</tr>
			<tr>
				<td align="center">
					<canvas id="canvas"></canvas>
				</td>
			</tr>
			<tr>
				<td align="center">&nbsp; </td>
			</tr>
			<tr>
				<td align="center">
					<font class="f20"><strong>Data Indeks Kepuasan Masyarakat</strong></font>
				</td>
			</tr>
			<tr>
				<td align="center">&nbsp; </td>
			</tr>
			<tr>
				<td align="center">
					<table align="center" cellpadding="0" cellspacing="0" class="tabel_data tabel_isi" border="0">
						<tr bgcolor="#CCC">
							<td align="center" width="50" height="25"> <strong>No.</strong></td>
							<td align="center" width="200"> <strong>Tahun</strong></td>
							<td align="center" width="150"> <strong>Sangat Puas</strong></td>
							<td align="center" width="150"> <strong>Puas</strong></td>
							<td align="center" width="150"> <strong>Tidak Puas</strong></td>
							<td align="center" width="150"> <strong>Jumlah</strong></td>
						</tr>
						<?php
						$i = 1;
						$count_sangat_puas	= 0;
						$count_puas			= 0;
						$count_tidak_puas	= 0;
						$count_jumlah		= 0;

						#- looping tahun
						foreach ($listTahun as $key => $value) {
							$tahun 			= $key;
							$sangat_puas	= (@$listSangatPuas[$tahun] == '') ? 0 : @$listSangatPuas[$tahun];
							$puas			= (@$listPuas[$tahun] == '') ? 0 : @$listPuas[$tahun];
							$tidak_puas		= (@$listTidakPuas[$tahun] == '') ? 0 : @$listTidakPuas[$tahun];
							$jumlah			= $sangat_puas + $puas + $tidak_puas;

							$count_sangat_puas	= $count_sangat_puas + $sangat_puas;
							$count_puas			= $count_puas + $puas;
							$count_tidak_puas	= $count_tidak_puas + $tidak_puas;
							$count_jumlah		= $count_jumlah + $jumlah;

							$row_color = ($i % 2 == 0) ? '#f2f2f2' : '#ffffff';
						?>
							<tr bgcolor="<?php echo $row_color; ?>">
								<td align="center" height="25"><?php echo $i++; ?></td>
								<td align="center"><?php echo $tahun; ?></td>
								<td align="center"><?php echo $sangat_puas; ?></td>
								<td align="center"><?php echo $puas; ?></td>
								<td align="center"><?php echo $tidak_puas; ?></td>
								<td align="center"><?php echo $jumlah; ?></td>
							</tr>
						<?php
						} #. foreach
						?>
						<tr bgcolor="#CCC">
							<td align="right" height="25" colspan="2"> <strong>Total</strong></td>
							<td align="center"> <strong><?php echo $count_sangat_puas; ?></strong></td>
							<td align="center"> <strong><?php echo $count_puas; ?></strong></td>
							<td align="center"> <strong><?php echo $count_tidak_puas; ?></strong></td>
							<td align="center"> <strong><?php echo $count_jumlah; ?></strong></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<script>
			var color = Chart.helpers.color;
			var barChartData = {
				labels: [<?php echo $labelTahun; ?>],
				datasets: [{
					label: 'Sangat Puas',
					backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
					borderColor: window.chartColors.blue,
					borderWidth: 1,
					data: [<?php echo $labelSangatPuas; ?>]
				}, {
					label: 'Puas',
					backgroundColor: color(window.chartColors.yellow).alpha(0.5).rgbString(),
					borderColor: window.chartColors.yellow,
					borderWidth: 1,
					data: [<?php echo $labelPuas; ?>]
				}, {
					label: 'Tidak Puas',
					backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
					borderColor: window.chartColors.red,
					borderWidth: 1,
					data: [<?php echo $labelTidakPuas; ?>]
				}]

			};

			window.onload = function() {
				var ctx = document.getElementById('canvas').getContext('2d');
				window.myBar = new Chart(ctx, {
					type: 'bar',
					data: barChartData,
					options: {
						responsive: true,
						legend: {
							position: 'top',
						},
						title: {
							display: false,
							text: 'Statistik Indeks Kepuasan Masyarakat'
						},
						scales: {
							yAxes: [{
								ticks: {
									beginAtZero: true
								}
							}]
						}
					}
				});

			};
		</script>
	<?php
	} elseif ($com == 'hari') {
		$str_tahun	= isset($_GET['t']) ? str_replace('.', '', $_GET['t']) : '';
		$tahun_ini	= ($str_tahun != '') ? $str_tahun : date('Y');
		$str_bulan	= isset($_GET['b']) ? str_replace('.', '', $_GET['b']) : '';
		$bulan_ini	= ($str_bulan != '') ? $str_tahun . '-' . $str_bulan : date('Y-m');
		$str_hari	= isset($_GET['h']) ? str_replace('.', '', $_GET['h']) : '';
		$hari_ini	= ($str_bulan != '') ? $str_tahun . '-' . $str_bulan  . '-' . $str_hari : date('Y-m-d');

		#-- tanggal
		$listTanggal 			= array();
		$listTanggal[$hari_ini]	= $hari_ini;

		#-- Data Sangat Puas
		$sql = "SELECT LEFT(waktu, 10) AS tanggal, COUNT(nilai) AS data FROM polling WHERE satuan='$SatuanID' AND nilai='5' AND LEFT(waktu, 10) = '$hari_ini' GROUP BY LEFT(waktu, 4) ORDER BY waktu ASC";
		$exe = _query($sql);
		$listSangatPuas = array();
		while ($row = _object($exe)) {
			$listSangatPuas[$row->tanggal] = $row->data;
		}
		$labelSangatPuas = implode(', ', $listSangatPuas);

		#-- Data Puas
		$sql = "SELECT LEFT(waktu, 10) AS tanggal, COUNT(nilai) AS data FROM polling WHERE satuan='$SatuanID' AND nilai='4' AND LEFT(waktu, 10) = '$hari_ini'  GROUP BY LEFT(waktu, 4) ORDER BY waktu ASC";
		$exe = _query($sql);
		$listPuas = array();
		while ($row = _object($exe)) {
			$listPuas[$row->tanggal] = $row->data;
		}
		$labelPuas = implode(', ', $listPuas);

		#-- Data Tidak Puas
		$sql = "SELECT LEFT(waktu, 10) AS tanggal, COUNT(nilai) AS data FROM polling WHERE satuan='$SatuanID' AND nilai='2' AND LEFT(waktu, 10) = '$hari_ini'  GROUP BY LEFT(waktu, 4) ORDER BY waktu ASC";
		$exe = _query($sql);
		$listTidakPuas = array();
		while ($row = _object($exe)) {
			$listTidakPuas[$row->tanggal] = $row->data;
		}
		$labelTidakPuas = implode(',', $listTidakPuas);
	?>
		<table align="center" cellpadding="0" cellspacing="0" class="tabel_isi" border="0">
			<tr>
				<td align="center">
					<font class="f20"><strong>Statistik Indeks Kepuasan Masyarakat Tanggal <?php echo tglIndo($hari_ini); ?></strong></font>
				</td>
			</tr>
			<tr>
				<td align="center">&nbsp; </td>
			</tr>
			<tr>
				<td align="center">
					<canvas id="canvas2"></canvas>
				</td>
			</tr>
			<tr>
				<td align="center">&nbsp; </td>
			</tr>
			<tr>
				<td align="center">&nbsp; </td>
			</tr>
			<tr>
				<td align="center">
					<font class="f20"><strong>Data Indeks Kepuasan Masyarakat Tanggal <?php echo tglIndo($hari_ini); ?></strong></font>
				</td>
			</tr>
			<tr>
				<td align="center">&nbsp; </td>
			</tr>
			<tr>
				<td align="center">
					<table align="center" cellpadding="0" cellspacing="0" class="tabel_data tabel_isi" border="0">
						<tr bgcolor="#CCC">
							<td align="center" width="50" height="25"> <strong>No.</strong></td>
							<td align="center" width="200"> <strong>Tanggal</strong></td>
							<td align="center" width="150"> <strong>Sangat Puas</strong></td>
							<td align="center" width="150"> <strong>Puas</strong></td>
							<td align="center" width="150"> <strong>Tidak Puas</strong></td>
							<td align="center" width="150"> <strong>Jumlah</strong></td>
						</tr>
						<?php
						$i = 1;
						$count_sangat_puas	= 0;
						$count_puas			= 0;
						$count_tidak_puas	= 0;
						$count_jumlah		= 0;

						#- looping tanggal
						foreach ($listTanggal as $key => $value) {
							$tanggal 		= $key;
							$sangat_puas	= (@$listSangatPuas[$tanggal] == '') ? 0 : @$listSangatPuas[$tanggal];
							$puas			= (@$listPuas[$tanggal] == '') ? 0 : @$listPuas[$tanggal];
							$tidak_puas		= (@$listTidakPuas[$tanggal] == '') ? 0 : @$listTidakPuas[$tanggal];
							$jumlah			= $sangat_puas + $puas + $tidak_puas;

							$count_sangat_puas	= $count_sangat_puas + $sangat_puas;
							$count_puas			= $count_puas + $puas;
							$count_tidak_puas	= $count_tidak_puas + $tidak_puas;
							$count_jumlah		= $count_jumlah + $jumlah;

							$row_color = ($i % 2 == 0) ? '#f2f2f2' : '#ffffff';
						?>
							<tr bgcolor="<?php echo $row_color; ?>">
								<td align="center" height="25"><?php echo $i++; ?></td>
								<td align="center"><?php echo tglIndo($tanggal); ?></td>
								<td align="center"><?php echo $sangat_puas; ?></td>
								<td align="center"><?php echo $puas; ?></td>
								<td align="center"><?php echo $tidak_puas; ?></td>
								<td align="center"><?php echo $jumlah; ?></td>
							</tr>
						<?php
						} #. foreach
						?>
						<tr bgcolor="#CCC">
							<td align="right" height="25" colspan="2"> <strong>Total</strong></td>
							<td align="center"> <strong><?php echo $count_sangat_puas; ?></strong></td>
							<td align="center"> <strong><?php echo $count_puas; ?></strong></td>
							<td align="center"> <strong><?php echo $count_tidak_puas; ?></strong></td>
							<td align="center"> <strong><?php echo $count_jumlah; ?></strong></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<script>
			var config = {
				type: 'pie',
				data: {
					datasets: [{
						data: [
							<?php echo $labelSangatPuas; ?>, <?php echo $labelPuas; ?>, <?php echo $labelTidakPuas; ?>
						],
						backgroundColor: [
							window.chartColors.blue, window.chartColors.yellow, window.chartColors.red
						],
						label: 'Dataset 1'
					}],
					labels: ['Sangat Puas', 'Puas', 'Tidak Puas']
				},
				options: {
					responsive: true
				}
			};

			window.onload = function() {
				var ctx = document.getElementById('canvas2').getContext('2d');
				window.myPie = new Chart(ctx, config);
			};
		</script>
	<?php
	} elseif ($com == 'minggu') {
		$str_tanggal1	= isset($_GET['t1']) ? str_replace('.', '', $_GET['t1']) : '';
		$str_tanggal2	= isset($_GET['t2']) ? str_replace('.', '', $_GET['t2']) : '';

		if ($str_tanggal1 != '' and $str_tanggal2 != '') {
			$judul	= tglIndo($str_tanggal1) . ' s/d. ' . tglIndo($str_tanggal2);
		} else {
			$judul = '';
		}

		#- cek maksimal hari
		$start_date 	= new DateTime($str_tanggal1);
		$end_date 		= new DateTime($str_tanggal2);
		$interval 		= $start_date->diff($end_date);
		$jumlah_hari 	= $interval->days;
		if ($jumlah_hari < 4) {
			echo 'Data yang ditampilkan minimal 5 hari.';
			exit();
		} elseif ($jumlah_hari > 13) {
			echo 'Data yang ditampilkan maksimal 14 hari.';
			exit();
		}

		#- bikin array dulu
		$listTanggal = array();
		$listSangatPuas = array();
		$listPuas = array();
		$listTidakPuas = array();

		#-- Tanggal
		$mulai = ($str_tanggal1);
		$mulainya = $mulai;
		for ($i = 0; $i <= $jumlah_hari; $i++) {
			$listTanggal[$mulainya] = "'" . substr($mulainya, -2) . "'";
			$mulainya = date('Y-m-d', strtotime("+1 day", strtotime($mulainya)));
		}
		$labelTanggal = implode(', ', $listTanggal);

		$mulainya = $mulai;
		for ($i = 0; $i <= $jumlah_hari; $i++) {
			$listSangatPuas[$mulainya] = 0;
			$mulainya = date('Y-m-d', strtotime("+1 day", strtotime($mulainya)));
		}
		$mulainya = $mulai;
		for ($i = 0; $i <= $jumlah_hari; $i++) {
			$listPuas[$mulainya] = 0;
			$mulainya = date('Y-m-d', strtotime("+1 day", strtotime($mulainya)));
		}
		$mulainya = $mulai;
		for ($i = 0; $i <= $jumlah_hari; $i++) {
			$listTidakPuas[$mulainya] = 0;
			$mulainya = date('Y-m-d', strtotime("+1 day", strtotime($mulainya)));
		}

		#-- Data Sangat Puas
		$sql = "SELECT LEFT(waktu, 10) AS tanggal, COUNT(nilai) AS data FROM polling WHERE satuan='$SatuanID' AND nilai='5' AND LEFT(waktu, 10) BETWEEN '$str_tanggal1' AND '$str_tanggal2' GROUP BY LEFT(waktu, 10) ORDER BY waktu ASC";
		$exe = _query($sql);
		while ($row = _object($exe)) {
			$listSangatPuas[$row->tanggal] = $row->data;
		}
		$labelSangatPuas = implode(', ', $listSangatPuas);

		#-- Data Puas
		$sql = "SELECT LEFT(waktu, 10) AS tanggal, COUNT(nilai) AS data FROM polling WHERE satuan='$SatuanID' AND nilai='4' AND LEFT(waktu, 10) BETWEEN '$str_tanggal1' AND '$str_tanggal2' GROUP BY LEFT(waktu, 10) ORDER BY waktu ASC";
		$exe = _query($sql);
		while ($row = _object($exe)) {
			$listPuas[$row->tanggal] = $row->data;
		}
		$labelPuas = implode(', ', $listPuas);

		#-- Data Tidak Puas
		$sql = "SELECT LEFT(waktu, 10) AS tanggal, COUNT(nilai) AS data FROM polling WHERE satuan='$SatuanID' AND nilai='2' AND LEFT(waktu, 10) BETWEEN '$str_tanggal1' AND '$str_tanggal2' GROUP BY LEFT(waktu, 10) ORDER BY waktu ASC";
		$exe = _query($sql);
		while ($row = _object($exe)) {
			$listTidakPuas[$row->tanggal] = $row->data;
		}
		$labelTidakPuas = implode(',', $listTidakPuas);
	?>
		<table align="center" cellpadding="0" cellspacing="0" class="tabel_isi" border="0">
			<tr>
				<td align="center">
					<strong>
						<font class="f20">Statistik Indeks Kepuasan Masyarakat</font><br>
						<font class="f15"><?php echo $judul; ?></font>
					</strong>
				</td>
			</tr>
			<tr>
				<td align="center">&nbsp; </td>
			</tr>
			<tr>
				<td align="center">
					<canvas id="canvas"></canvas>
				</td>
			</tr>
			<tr>
				<td align="center">&nbsp; </td>
			</tr>
			<tr>
				<td align="center">
					<strong>
						<font class="f20">Data Indeks Kepuasan Masyarakat</font><br>
						<font class="f15"><?php echo $judul; ?></font>
					</strong>
				</td>
			</tr>
			<tr>
				<td align="center">&nbsp; </td>
			</tr>
			<tr>
				<td align="center">
					<table align="center" cellpadding="0" cellspacing="0" class="tabel_data tabel_isi" border="0">
						<tr bgcolor="#CCC">
							<td align="center" width="50" height="25"> <strong>No.</strong></td>
							<td align="center" width="200"> <strong>Tanggal</strong></td>
							<td align="center" width="150"> <strong>Sangat Puas</strong></td>
							<td align="center" width="150"> <strong>Puas</strong></td>
							<td align="center" width="150"> <strong>Tidak Puas</strong></td>
							<td align="center" width="150"> <strong>Jumlah</strong></td>
						</tr>
						<?php
						$i = 1;
						$count_sangat_puas	= 0;
						$count_puas			= 0;
						$count_tidak_puas	= 0;
						$count_jumlah		= 0;

						#- looping tanggal
						foreach ($listTanggal as $key => $value) {
							list($tahun, $bulan, $tanggal) = explode('-', $key, 3);
							$sangat_puas	= (@$listSangatPuas[$key] == '') ? 0 : @$listSangatPuas[$key];
							$puas			= (@$listPuas[$key] == '') ? 0 : @$listPuas[$key];
							$tidak_puas		= (@$listTidakPuas[$key] == '') ? 0 : @$listTidakPuas[$key];
							$jumlah			= $sangat_puas + $puas + $tidak_puas;

							$count_sangat_puas	= $count_sangat_puas + $sangat_puas;
							$count_puas			= $count_puas + $puas;
							$count_tidak_puas	= $count_tidak_puas + $tidak_puas;
							$count_jumlah		= $count_jumlah + $jumlah;

							$row_color = ($i % 2 == 0) ? '#f2f2f2' : '#ffffff';
						?>
							<tr bgcolor="<?php echo $row_color; ?>">
								<td align="center" height="25"><?php echo $i++; ?></td>
								<td align="center"><?php echo tglIndo($tahun . '-' . $bulan . '-' . $tanggal); ?></td>
								<td align="center"><?php echo $sangat_puas; ?></td>
								<td align="center"><?php echo $puas; ?></td>
								<td align="center"><?php echo $tidak_puas; ?></td>
								<td align="center"><?php echo $jumlah; ?></td>
							</tr>
						<?php
						} #. foreach
						?>
						<tr bgcolor="#CCC">
							<td align="right" height="25" colspan="2"> <strong>Total</strong></td>
							<td align="center"> <strong><?php echo $count_sangat_puas; ?></strong></td>
							<td align="center"> <strong><?php echo $count_puas; ?></strong></td>
							<td align="center"> <strong><?php echo $count_tidak_puas; ?></strong></td>
							<td align="center"> <strong><?php echo $count_jumlah; ?></strong></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<script>
			var config = {
				type: 'line',
				data: {
					labels: [<?php echo $labelTanggal; ?>],
					datasets: [{
						label: 'Sangat Puas',
						backgroundColor: window.chartColors.blue,
						borderColor: window.chartColors.blue,
						data: [<?php echo $labelSangatPuas; ?>],
						fill: false,
					}, {
						label: 'Puas',
						fill: false,
						backgroundColor: window.chartColors.yellow,
						borderColor: window.chartColors.yellow,
						data: [<?php echo $labelPuas; ?>],
					}, {
						label: 'Tidak Puas',
						fill: false,
						backgroundColor: window.chartColors.red,
						borderColor: window.chartColors.red,
						data: [<?php echo $labelTidakPuas; ?>],
					}]
				},
				options: {
					responsive: true,
					title: {
						display: false,
						text: 'Statistik Indeks Kepuasan Masyarakat Bulan Ini'
					},
					tooltips: {
						mode: 'index',
						intersect: false,
					},
					hover: {
						mode: 'nearest',
						intersect: true
					},
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Tanggal'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Data'
							},
							ticks: {
								beginAtZero: true
							}
						}]
					}
				}
			};

			window.onload = function() {
				var ctx = document.getElementById('canvas').getContext('2d');
				window.myLine = new Chart(ctx, config);
			};
		</script>
	<?php
	} elseif ($com == 'bulan') {
		$str_tahun	= isset($_GET['t']) ? str_replace('.', '', $_GET['t']) : '';
		$tahun_ini	= ($str_tahun != '') ? $str_tahun : date('Y');
		$str_bulan	= isset($_GET['b']) ? str_replace('.', '', $_GET['b']) : '';
		$bulan_ini	= ($str_bulan != '') ? $str_tahun . '-' . $str_bulan : date('Y-m');
		$jumlah_hari	= date('t', mktime(0, 0, 0, substr($bulan_ini, 5, 2), 1, $tahun_ini));
		#$jumlah_hari	= ($jumlah_hari > date('d')) ? date('d') : $jumlah_hari;

		#-- Tanggal
		for ($i = 1; $i <= $jumlah_hari; $i++) {
			$listTanggal[$i] = "'" . duaDigit($i) . "'";
		}
		$labelTanggal = implode(', ', $listTanggal);

		#-- Data Sangat Puas
		$sql = "SELECT LEFT(waktu, 10) AS tanggal, COUNT(nilai) AS data FROM polling WHERE satuan='$SatuanID' AND nilai='5' AND LEFT(waktu, 7) = '$bulan_ini' GROUP BY LEFT(waktu, 10) ORDER BY waktu ASC";
		$exe = _query($sql);
		$listSangatPuas = array();
		for ($i = 1; $i <= $jumlah_hari; $i++) {
			$listSangatPuas[$i] = 0;
		}
		while ($row = _object($exe)) {
			$int_data	= (int) substr($row->tanggal, 8, 10);
			$listSangatPuas[$int_data] = $row->data;
		}
		$labelSangatPuas = implode(', ', $listSangatPuas);

		#-- Data Puas
		$sql = "SELECT LEFT(waktu, 10) AS tanggal, COUNT(nilai) AS data FROM polling WHERE satuan='$SatuanID' AND nilai='4' AND LEFT(waktu, 7) = '$bulan_ini' GROUP BY LEFT(waktu, 10) ORDER BY waktu ASC";
		$exe = _query($sql);
		$listPuas = array();
		for ($i = 1; $i <= $jumlah_hari; $i++) {
			$listPuas[$i] = 0;
		}
		while ($row = _object($exe)) {
			$int_data	= (int) substr($row->tanggal, 8, 10);
			$listPuas[$int_data] = $row->data;
		}
		$labelPuas = implode(', ', $listPuas);

		#-- Data Tidak Puas
		$sql = "SELECT LEFT(waktu, 10) AS tanggal, COUNT(nilai) AS data FROM polling WHERE satuan='$SatuanID' AND nilai='2' AND LEFT(waktu, 7) = '$bulan_ini' GROUP BY LEFT(waktu, 10) ORDER BY waktu ASC";
		$exe = _query($sql);
		$listTidakPuas = array();
		for ($i = 1; $i <= $jumlah_hari; $i++) {
			$listTidakPuas[$i] = 0;
		}
		while ($row = _object($exe)) {
			$int_data	= (int) substr($row->tanggal, 8, 10);
			$listTidakPuas[$int_data] = $row->data;
		}
		$labelTidakPuas = implode(',', $listTidakPuas);
	?>
		<table align="center" cellpadding="0" cellspacing="0" class="tabel_isi" border="0">
			<tr>
				<td align="center">
					<font class="f20"><strong>Statistik Indeks Kepuasan Masyarakat Bulan <?php echo Bulan(substr($bulan_ini, 5, 2)); ?> <?php echo $tahun_ini; ?></strong></font>
				</td>
			</tr>
			<tr>
				<td align="center">&nbsp; </td>
			</tr>
			<tr>
				<td align="center">
					<canvas id="canvas"></canvas>
				</td>
			</tr>
			<tr>
				<td align="center">&nbsp; </td>
			</tr>
			<tr>
				<td align="center">
					<font class="f20"><strong>Data Indeks Kepuasan Masyarakat Bulan <?php echo Bulan(substr($bulan_ini, 5, 2)); ?> <?php echo $tahun_ini; ?></strong></font>
				</td>
			</tr>
			<tr>
				<td align="center">&nbsp; </td>
			</tr>
			<tr>
				<td align="center">
					<table align="center" cellpadding="0" cellspacing="0" class="tabel_data tabel_isi" border="0">
						<tr bgcolor="#CCC">
							<td align="center" width="50" height="25"> <strong>No.</strong></td>
							<td align="center" width="200"> <strong>Tanggal</strong></td>
							<td align="center" width="150"> <strong>Sangat Puas</strong></td>
							<td align="center" width="150"> <strong>Puas</strong></td>
							<td align="center" width="150"> <strong>Tidak Puas</strong></td>
							<td align="center" width="150"> <strong>Jumlah</strong></td>
						</tr>
						<?php
						$i = 1;
						$count_sangat_puas	= 0;
						$count_puas			= 0;
						$count_tidak_puas	= 0;
						$count_jumlah		= 0;

						#- looping tanggal
						foreach ($listTanggal as $key => $value) {
							$tanggal		= $key;
							$sangat_puas	= (@$listSangatPuas[$i] == '') ? 0 : @$listSangatPuas[$i];
							$puas			= (@$listPuas[$tanggal] == '') ? 0 : @$listPuas[$tanggal];
							$tidak_puas		= (@$listTidakPuas[$tanggal] == '') ? 0 : @$listTidakPuas[$tanggal];
							$jumlah			= $sangat_puas + $puas + $tidak_puas;

							$count_sangat_puas	= $count_sangat_puas + $sangat_puas;
							$count_puas			= $count_puas + $puas;
							$count_tidak_puas	= $count_tidak_puas + $tidak_puas;
							$count_jumlah		= $count_jumlah + $jumlah;

							$row_color = ($i % 2 == 0) ? '#f2f2f2' : '#ffffff';
						?>
							<tr bgcolor="<?php echo $row_color; ?>">
								<td align="center" height="25"><?php echo $i++; ?></td>
								<td align="center"><?php echo tglIndo($bulan_ini . '-' . $tanggal); ?></td>
								<td align="center"><?php echo $sangat_puas; ?></td>
								<td align="center"><?php echo $puas; ?></td>
								<td align="center"><?php echo $tidak_puas; ?></td>
								<td align="center"><?php echo $jumlah; ?></td>
							</tr>
						<?php
						} #. foreach
						?>
						<tr bgcolor="#CCC">
							<td align="right" height="25" colspan="2"> <strong>Total</strong></td>
							<td align="center"> <strong><?php echo $count_sangat_puas; ?></strong></td>
							<td align="center"> <strong><?php echo $count_puas; ?></strong></td>
							<td align="center"> <strong><?php echo $count_tidak_puas; ?></strong></td>
							<td align="center"> <strong><?php echo $count_jumlah; ?></strong></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<script>
			var config = {
				type: 'line',
				data: {
					labels: [<?php echo $labelTanggal; ?>],
					datasets: [{
						label: 'Sangat Puas',
						backgroundColor: window.chartColors.blue,
						borderColor: window.chartColors.blue,
						data: [<?php echo $labelSangatPuas; ?>],
						fill: false,
					}, {
						label: 'Puas',
						fill: false,
						backgroundColor: window.chartColors.yellow,
						borderColor: window.chartColors.yellow,
						data: [<?php echo $labelPuas; ?>],
					}, {
						label: 'Tidak Puas',
						fill: false,
						backgroundColor: window.chartColors.red,
						borderColor: window.chartColors.red,
						data: [<?php echo $labelTidakPuas; ?>],
					}]
				},
				options: {
					responsive: true,
					title: {
						display: false,
						text: 'Statistik Indeks Kepuasan Masyarakat Bulan Ini'
					},
					tooltips: {
						mode: 'index',
						intersect: false,
					},
					hover: {
						mode: 'nearest',
						intersect: true
					},
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Tanggal'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Data'
							},
							ticks: {
								beginAtZero: true
							}
						}]
					}
				}
			};

			window.onload = function() {
				var ctx = document.getElementById('canvas').getContext('2d');
				window.myLine = new Chart(ctx, config);
			};
		</script>
	<?php
	} elseif ($com == 'tahun') {
		$str_tahun	= isset($_GET['t']) ? str_replace('.', '', $_GET['t']) : '';
		$tahun_ini	= ($str_tahun != '') ? $str_tahun : date('Y');
		$jumlah_bulan	= 12;

		#-- Bulan
		for ($i = 1; $i <= $jumlah_bulan; $i++) {
			$listBulan[$i] = "'" . Bulan($i) . "'";
		}
		$labelBulan = implode(', ', $listBulan);

		#-- Data Sangat Puas
		$sql = "SELECT MID(waktu, 6, 2) AS bulan, COUNT(id) AS data FROM polling WHERE satuan='$SatuanID' AND nilai='5' AND LEFT(waktu, 4) = '$tahun_ini' GROUP BY LEFT(waktu, 7) ORDER BY waktu ASC";
		$exe = _query($sql);
		$listSangatPuas = array();
		for ($i = 1; $i <= $jumlah_bulan; $i++) {
			$listSangatPuas[$i] = 0;
		}
		while ($row = _object($exe)) {
			$int_data	= (int) $row->bulan;
			$listSangatPuas[$int_data] = $row->data;
		}
		$labelSangatPuas = implode(', ', $listSangatPuas);

		#-- Data Puas
		$sql = "SELECT MID(waktu, 6, 2) AS bulan, COUNT(id) AS data FROM polling WHERE satuan='$SatuanID' AND nilai='4' AND LEFT(waktu, 4) = '$tahun_ini' GROUP BY LEFT(waktu, 7) ORDER BY waktu ASC";
		$exe = _query($sql);
		$listPuas = array();
		for ($i = 1; $i <= $jumlah_bulan; $i++) {
			$listPuas[$i] = 0;
		}
		while ($row = _object($exe)) {
			$int_data	= (int) $row->bulan;
			$listPuas[$int_data] = $row->data;
		}
		$labelPuas = implode(', ', $listPuas);

		#-- Data Tidak Puas
		$sql = "SELECT MID(waktu, 6, 2) AS bulan, COUNT(id) AS data FROM polling WHERE satuan='$SatuanID' AND nilai='2' AND LEFT(waktu, 4) = '$tahun_ini' GROUP BY LEFT(waktu, 7) ORDER BY waktu ASC";
		$exe = _query($sql);
		$listTidakPuas = array();
		for ($i = 1; $i <= $jumlah_bulan; $i++) {
			$listTidakPuas[$i] = 0;
		}
		while ($row = _object($exe)) {
			$int_data	= (int) $row->bulan;
			$listTidakPuas[$int_data] = $row->data;
		}
		$labelTidakPuas = implode(',', $listTidakPuas);
	?>
		<table align="center" cellpadding="0" cellspacing="0" class="tabel_isi" border="0">
			<tr>
				<td align="center">
					<font class="f20"><strong>Statistik Indeks Kepuasan Masyarakat Tahun <?php echo $tahun_ini; ?></strong></font>
				</td>
			</tr>
			<tr>
				<td align="center">&nbsp; </td>
			</tr>
			<tr>
				<td align="center">
					<canvas id="canvas"></canvas>
				</td>
			</tr>
			<tr>
				<td align="center">&nbsp; </td>
			</tr>
			<tr>
				<td align="center">
					<font class="f20"><strong>Data Indeks Kepuasan Masyarakat Tahun <?php echo $tahun_ini; ?></strong></font>
				</td>
			</tr>
			<tr>
				<td align="center">&nbsp; </td>
			</tr>
			<tr>
				<td align="center">
					<table align="center" cellpadding="0" cellspacing="0" class="tabel_data tabel_isi" border="0">
						<tr bgcolor="#CCC">
							<td align="center" width="50" height="25"> <strong>No.</strong></td>
							<td align="center" width="200"> <strong>Bulan</strong></td>
							<td align="center" width="150"> <strong>Sangat Puas</strong></td>
							<td align="center" width="150"> <strong>Puas</strong></td>
							<td align="center" width="150"> <strong>Tidak Puas</strong></td>
							<td align="center" width="150"> <strong>Jumlah</strong></td>
						</tr>
						<?php
						$i = 1;
						$count_sangat_puas	= 0;
						$count_puas			= 0;
						$count_tidak_puas	= 0;
						$count_jumlah		= 0;

						#- looping bulan
						foreach ($listBulan as $key => $value) {
							$bulan			= $key;
							$sangat_puas	= (@$listSangatPuas[$bulan] == '') ? 0 : @$listSangatPuas[$bulan];
							$puas			= (@$listPuas[$bulan] == '') ? 0 : @$listPuas[$bulan];
							$tidak_puas		= (@$listTidakPuas[$bulan] == '') ? 0 : @$listTidakPuas[$bulan];
							$jumlah			= $sangat_puas + $puas + $tidak_puas;

							$count_sangat_puas	= $count_sangat_puas + $sangat_puas;
							$count_puas			= $count_puas + $puas;
							$count_tidak_puas	= $count_tidak_puas + $tidak_puas;
							$count_jumlah		= $count_jumlah + $jumlah;

							$row_color = ($i % 2 == 0) ? '#f2f2f2' : '#ffffff';
						?>
							<tr bgcolor="<?php echo $row_color; ?>">
								<td align="center" height="25"><?php echo $i++; ?></td>
								<td align="center"><?php echo Bulan($bulan); ?> <?php echo $tahun_ini; ?></td>
								<td align="center"><?php echo $sangat_puas; ?></td>
								<td align="center"><?php echo $puas; ?></td>
								<td align="center"><?php echo $tidak_puas; ?></td>
								<td align="center"><?php echo $jumlah; ?></td>
							</tr>
						<?php
						} #. foreach
						?>
						<tr bgcolor="#CCC">
							<td align="right" height="25" colspan="2"> <strong>Total</strong></td>
							<td align="center"> <strong><?php echo $count_sangat_puas; ?></strong></td>
							<td align="center"> <strong><?php echo $count_puas; ?></strong></td>
							<td align="center"> <strong><?php echo $count_tidak_puas; ?></strong></td>
							<td align="center"> <strong><?php echo $count_jumlah; ?></strong></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<script>
			var config = {
				type: 'line',
				data: {
					labels: [<?php echo $labelBulan; ?>],
					datasets: [{
						label: 'Sangat Puas',
						backgroundColor: window.chartColors.blue,
						borderColor: window.chartColors.blue,
						data: [<?php echo $labelSangatPuas; ?>],
						fill: false,
					}, {
						label: 'Puas',
						fill: false,
						backgroundColor: window.chartColors.yellow,
						borderColor: window.chartColors.yellow,
						data: [<?php echo $labelPuas; ?>],
					}, {
						label: 'Tidak Puas',
						fill: false,
						backgroundColor: window.chartColors.red,
						borderColor: window.chartColors.red,
						data: [<?php echo $labelTidakPuas; ?>],
					}]
				},
				options: {
					responsive: true,
					title: {
						display: false,
						text: 'Statistik Indeks Kepuasan Masyarakat Bulan Ini'
					},
					tooltips: {
						mode: 'index',
						intersect: false,
					},
					hover: {
						mode: 'nearest',
						intersect: true
					},
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Bulan'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Data'
							},
							ticks: {
								beginAtZero: true
							}
						}]
					}
				}
			};

			window.onload = function() {
				var ctx = document.getElementById('canvas').getContext('2d');
				window.myLine = new Chart(ctx, config);
			};
		</script>
	<?php
	}
	?>
	</div>
	</div>
	</div>
	<!--</main>-->


	<!-- Bootstrap core JavaScript
================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="public/assets/js/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script>
		window.jQuery || document.write('<script src="public/assets/js/jquery-slim.min.js"><\/script>')
	</script>
</body>

</html>