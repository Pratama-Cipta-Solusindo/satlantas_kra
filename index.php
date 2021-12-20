<?php
require_once('system/system.php');

if ($com == 'getdesa') {
	$kecamatan = nosql($_GET['kecamatan']);
	$sqlRef = "SELECT kode, nama_wilayah FROM wilayah WHERE kode_master='" . $kecamatan . "' ORDER BY nama_wilayah ASC";
	$exeRef = _query($sqlRef);
	$html = '<option value="">- Pilih Desa/Kelurahan -</option>';
	while ($rRef = _array($exeRef)) {
		$html .= '<option value="' . $rRef[0] . '">' . $rRef[1] . '</option>';
	}
	$callback = array('data_kelurahan' => $html);
	echo json_encode($callback);
	exit();
	//desa
} elseif ($com == 'getdesa2') {
	$kecamatan = nosql($_GET['kecamatan']);
	$sqlRef = "SELECT kode, nama_wilayah FROM wilayah WHERE kode_master='" . $kecamatan . "' ORDER BY nama_wilayah ASC";
	$exeRef = _query($sqlRef);
	$html = '';
	while ($rRef = _array($exeRef)) {
		$html .= '<div class="form-check">';
		$html .= '<input class="form-check-input" type="radio" name="wilayah" id="wilayah' . $rRef[0] . '" value="' . $rRef[0] . '">';
		$html .= '<label class="form-check-label" for="wilayah' . $rRef[0] . '"> ' . $rRef[1] . '</label>';
		$html .= '</div>';
	}
	$callback = array('data_kelurahan' => $html);
	echo json_encode($callback);
	exit();
	//kabupaten
} elseif ($com == 'getkabupaten') {
	$provinsi = nosql($_GET['provinsi']);
	$sqlRef = "SELECT kode, nama_wilayah FROM wilayah WHERE kode_master='" . $provinsi . "' ORDER BY nama_wilayah ASC";
	$exeRef = _query($sqlRef);
	$html = '';
	while ($rRef = _array($exeRef)) {
		$html .= '<div class="form-check">';
		$html .= '<input class="form-check-input" type="radio" name="kabupaten" id="kabupaten' . $rRef[0] . '" value="' . $rRef[0] . '">';
		$html .= '<label class="form-check-label" for="kabupaten' . $rRef[0] . '"> ' . $rRef[1] . '</label>';
		$html .= '</div>';
	}
	$callback = array('data_kabupaten' => $html);
	echo json_encode($callback);
	exit();
	//kecamatan
} elseif ($com == 'save') {
	#- variabel
	$id			= uuid();
	$satpas_id	= $SatuanID;
	$nik		= nosql($_POST['nik']);
	$nama		= uppercase(nosql($_POST['nama']));
	$jk			= nosql($_POST['jk']);
	$agama		= nosql($_POST['agama']);
	$usia		= nosql($_POST['usia']);
	$pendidikan	= nosql($_POST['pendidikan']);
	$pekerjaan	= nosql($_POST['pekerjaan']);
	$layanan	= isset($_POST['layanan']) ? nosql($_POST['layanan']) : 0; #- Add : 23-08-2021
	$wilayah	= nosql($_POST['wilayah']);
	$alamat		= uppercase(nosql($_POST['alamat']));
	$hp			= nosql($_POST['hp']);
	$waktu 		= date('Y-m-d H:i:s');
	$signature	= $id; #md5($waktu . $nik);

	$_SESSION['waktu'] 			= $waktu;
	$_SESSION['signature'] 		= $id; #$signature;
	$_SESSION['koresponden_id']	= $id;
	$_SESSION['status_responden'] = '1';
	$_SESSION['layanan']		= $layanan; #- Add : 23-08-2021

	$sql = "INSERT INTO responden (id_responden, satpas_id, nik, nama, jk, agama, usia, pendidikan, pekerjaan, layanan, wilayah, alamat, hp, waktu, signature)  VALUES ('$id', '$satpas_id', '$nik', '$nama', '$jk', '$agama', '$usia', '$pendidikan', '$pekerjaan', '$layanan', '$wilayah', '$alamat', '$hp', '$waktu', '$signature')";
	$exe = _query($sql);
	if ($exe) {
		$status = 'save';
	} else {
		$status = 'notsave';
	}
	#echo $sql;
	$callback = array('status' => $status);
	echo json_encode($callback);
	exit();
} elseif ($com == 'save_soal') {
	#- variabel
	$satpas_id		= $SatuanID;
	$koresponden_id	= $_SESSION['koresponden_id'];
	$waktu 			= $_SESSION['waktu'];
	$signature		= $_SESSION['signature'];
	$jml_soal		= $_SESSION['jumlah_soal'];
	$jawab			= $_POST['jawab'];

	$jmlJawab		= count($jawab);

	$jmlNilai = 0;
	foreach ($jawab as $soal_id => $value) {
		list($opsi_id, $nilai) = explode('_', $value, 2);
		$nilai = $nilai * $setNilaiKali;
		$jmlNilai = $jmlNilai + $nilai;

		$sqlInsert = "INSERT INTO kuisioner_jawab (jawab_id, satpas_id, soal_id, opsi_id, nilai, created_by, created_at)  VALUES ('" . uuid() . "', '" . $satpas_id . "', '" . $soal_id . "', '" . $opsi_id . "', '" . $nilai . "', '" . $koresponden_id . "', '" . $waktu . "')";
		$exeInsert = _query($sqlInsert);
	}

	$this_nilai = $jmlNilai / $jml_soal;
	$sqlUpdate = "UPDATE responden SET nilai='" . $this_nilai . "' WHERE id_responden='" . $koresponden_id . "'";
	$exeUpdate = _query($sqlUpdate);
	if ($exeUpdate) {
		$status = 'save';
		$_SESSION['status_survey'] = '1';
	} else {
		$status = 'notsave';
		$_SESSION['status_survey'] = '0';
	}
	$callback = array('status' => $status);
	echo json_encode($callback);
	exit();

	#- saran	
} elseif ($com == 'save_saran') {
	#- variabel
	$satpas_id		= $SatuanID;
	$koresponden_id	= $_SESSION['koresponden_id'];
	$waktu 			= $_SESSION['waktu'];
	$signature		= $_SESSION['signature'];
	$saran			= $_POST['saran'];

	$sqlUpdate = "UPDATE responden SET kritik_saran='" . $saran . "' WHERE id_responden='" . $koresponden_id . "'";
	$exeUpdate = _query($sqlUpdate);
	if ($exeUpdate) {
		$status = 'save';
		$_SESSION['status_saran'] = '1';
	} else {
		$status = 'notsave';
		$_SESSION['status_saran'] = '0';
	}

	$callback = array('status' => $status);
	echo json_encode($callback);
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
	<meta name="author" content="CV. Cipta Mandiri Solusindo">
	<link rel="shortcut icon" href="public/logo/logo_polri.png" />

	<!-- CSS -->
	<link href="public/assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="public/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="public/vendor/jqbtk/jqbtk.css" rel="stylesheet">
	<link href="public/assets/css/custom.css" rel="stylesheet">

	<!---Front CSS ---->
	<!-- Custom Fonts -->
	<link href="public/front/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
	<link href="public/front/vendor/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="public/front/css/stylish-portfolio.min.css" rel="stylesheet">
	<link href="public/vendor/multisteps-form/build/style.css" rel="stylesheet">

	<script src="public/vendor/Chart.js/dist/Chart.min.js"></script>
	<script src="public/vendor/Chart.js/samples/utils.js"></script>
	<script src="public/vendor/multisteps-form/build/script.js"></script>


	<style>
		html {

			overflow-y: hidden;
		}
	</style>

</head>

<body>

	<!-- Navigation -->
	<a class="menu-toggle rounded" href="#">
		<i class="fas fa-bars"></i>
	</a>
	<nav id="sidebar-wrapper">
		<ul class="sidebar-nav">
			<li class="sidebar-brand">
				<a class="js-scroll-trigger" href="#page-top">IKM - Polres Karanganyar</a>
			</li>
			<li class="sidebar-nav-item">
				<a class="js-scroll-trigger" href="#page-top"><i class="fa fa-home"></i> Home</a>
			</li>
			<li class="sidebar-nav-item">
				<a class="js-scroll-trigger" href="#" data-toggle="modal" data-target="#modalResponden"><i class="fa fa-paper-plane"></i> Isi IKM</a>
			</li>
			<li class="sidebar-nav-item">
				<a class="js-scroll-trigger" href="#" data-toggle="modal" data-target="#cmsStatistik"><i class="fa fa-chart-bar"></i> Statistik IKM</a>
			</li>

		</ul>
	</nav>
	<!-- Header -->
	<header class="masthead d-flex">
		<div class="container text-center my-auto">
			<img src="public/front/img/satlantas.png" height="200px" class="rounded float-left" alt="Satuan">
			<img src="public/front/img/polres.png" height="200px" class="rounded float-right" alt="Polres">
			<h1 class=" text-white">IKM
			</h1>

			<h2 class="mt-1 text-white">SATLANTAS POLRES KARANGANYAR</h2>
			<h3 class="mb-5 text-white">
				<em>Indeks Kepuasan Masyarakat <br>Satuan Lalu Lintas <br>Polres Karanganyar</em>
			</h3>

			<button data-toggle="modal" data-target="#modalResponden" class="btn btn-primary btn-xl  js-scroll-trigger">
				<i class="fa fa-paper-plane"></i>&nbsp;ISI IKM SATLANTAS</button>
		</div>
	</header>


	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-md-12 big-box">
				<div class="modal fade" id="modalResponden" tabindex="-1" role="dialog" aria-labelledby="modalRespondenLabel" aria-hidden="true">

					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" align="center">Isikan Identitas Diri</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times; Tutup</span>
								</button>
							</div> <!-- end of class modal-header -->
							<div class="modal-body">
								<form action="index.php?com=save" method="post" id="cmsForm" name="cmsForm" class="multisteps-form__form">
									<input type="hidden" name="act" value="save">
									<div class="container-fluid">
										<div class="row">
											<div class="col-md-12">
												<div id="blok_1">
													<div class="form-group row">
														<label for="nik" class="col-sm-3 col-form-label pull-right"><b>NIK</b></label>
														<div class="col-sm-9">
															<input type="text" name="nik" id="nik" class="form-control kb form-control-lg" placeholder="NIK" autocomplete="off" required>
														</div>
													</div>
													<div class="form-group row">
														<label for="nama" class="col-sm-3 col-form-label"><b>NAMA LENGKAP</b></label>
														<div class="col-sm-9">
															<input type="text" name="nama" id="nama" class="form-control kb form-control-lg" placeholder="Nama Lengkap" autocomplete="off" required>
														</div>
													</div>
													<div class="form-group row">
														<label for="nik" class="col-sm-3 col-form-label pull-right"><b>NO. HP</b></label>
														<div class="col-sm-9">
															<input type="text" name="hp" id="hp" class="form-control kb form-control-lg" placeholder="No. HP" autocomplete="off">
														</div>
													</div>
													<div class="form-group row">
														<label for="jk" class="col-sm-3 col-form-label"><b>JENIS KELAMIN</b></label>
														<div class="col-sm-9">
															<?php
															foreach ($listJenisKelamin as $key => $value) {
															?>
																<div class="form-check">
																	<input class="form-check-input radio_big" type="radio" name="jk" id="jk<?php echo $key; ?>" value="<?php echo $key; ?>">
																	<label class="form-check-label radio_big" for="jk<?php echo $key; ?>"> <?php echo $value; ?></label>
																</div>
															<?php
															}
															?>
														</div>
													</div>
												</div>
												<div id="blok_2">
													<div class="form-group row">
														<div class="col-sm-6">
															AGAMA : <br>
															<?php
															foreach ($listAgama as $key => $value) {
															?>
																<div class="form-check">
																	<input class="form-check-input" type="radio" name="agama" id="agama<?php echo $key; ?>" value="<?php echo $key; ?>">
																	<label class="form-check-label" for="agama<?php echo $key; ?>"> <?php echo $value; ?></label>
																</div>
															<?php
															}
															?>
														</div>
														<div class="col-sm-6">
															RENTANG USIA : <br>
															<?php
															foreach ($listUsia as $key => $value) {
															?>
																<div class="form-check">
																	<input class="form-check-input" type="radio" name="usia" id="usia<?php echo $key; ?>" value="<?php echo $key; ?>">
																	<label class="form-check-label" for="usia<?php echo $key; ?>"> <?php echo $value; ?></label>
																</div>
															<?php
															}
															?>
														</div>
													</div>
												</div>
												<div id="blok_3">
													<div class="form-group row">
														<label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
														<div class="col-sm-9">
															<input type="text" name="alamat" id="alamat" class="form-control kb form-control-lg" placeholder="Alamat - RT/RW" autocomplete="off" required>
														</div>
													</div>
													<div class="form-group row">
														<label for="alamat" class="col-sm-3 col-form-label">Provinsi</label>
														<div class="col-sm-9">
															<select class="select form-control form-control-lg" name="provinsi" id="form_prov" required>
																<option value="">- Pilih Provinsi -</option>
																<?php
																$sqlRef = "SELECT kode, nama_wilayah FROM wilayah WHERE CHAR_LENGTH(kode)=2 ORDER BY nama_wilayah ASC";
																$exeRef = _query($sqlRef);
																while ($rRef = _array($exeRef)) {
																?>
																	<option value="<?php echo $rRef[0]; ?>"><?php echo $rRef[1]; ?></option>
																<?php
																}
																?>
															</select>
														</div>
													</div>
													<div class="form-group row">
														<label for="kabupaten" id="label_kab" class="col-sm-3 col-form-label">Kabupaten</label>
														<div class="col-sm-9">
															<select class="select form-control form-control-lg" name="kabupaten" id="form_kab" required>
																<option value="">- Pilih Provinsi Dahulu -</option>
															</select>
														</div>
													</div>
													<div class="form-group row">
														<label for="kecamatan" id="label_kec" class="col-sm-3 col-form-label">Kecamatan</label>
														<div class="col-sm-9">
															<select class="select form-control form-control-lg" name="kecamatan" id="form_kec" required>
																<option value="">- Pilih Kabupaten Dahulu -</option>
															</select>
														</div>
													</div>
													<div class="form-group row">
														<label for="desa" id="label_des" class="col-sm-3 col-form-label">Desa</label>
														<div class="col-sm-9">
															<select class="select form-control form-control-lg" name="wilayah" id="form_des" required>
																<option value="">- Pilih Desa Dahulu -</option>
															</select>
														</div>
													</div>
												</div>
												<div id="blok_4">
													<div class="form-group row">
														<div class="col-sm-4">
															JENJANG PENDIDIKAN : <br>
															<?php
															foreach ($listPendidikan as $key => $value) {
															?>
																<div class="form-check">
																	<input class="form-check-input" type="radio" name="pendidikan" id="pendidikan<?php echo $key; ?>" value="<?php echo $key; ?>">
																	<label class="form-check-label" for="pendidikan<?php echo $key; ?>"> <?php echo $value; ?></label>
																</div>
															<?php
															}
															?>
														</div>
														<div class="col-sm-4">
															JENIS PEKERJAAN : <br>
															<?php
															foreach ($listPekerjaan as $key => $value) {
															?>
																<div class="form-check">
																	<input class="form-check-input" type="radio" name="pekerjaan" id="pekerjaan<?php echo $key; ?>" value="<?php echo $key; ?>">
																	<label class="form-check-label" for="pekerjaan<?php echo $key; ?>"> <?php echo $value; ?></label>
																</div>
															<?php
															}
															?>
														</div>
														<div class="col-sm-4">
															JENIS LAYANAN : <br>
															<?php
															foreach ($listJenisLayanan as $key => $value) {
															?>
																<div class="form-check">
																	<input class="form-check-input" type="radio" name="layanan" id="layanan<?php echo $key; ?>" value="<?php echo $key; ?>">
																	<label class="form-check-label" for="layanan<?php echo $key; ?>"> <?php echo $value; ?></label>
																</div>
															<?php
															}
															?>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div> <!-- end of class container-fluid -->
								</form>
							</div> <!-- end of class modal-body -->
							<div class="modal-footer">
								<div class="container-fluid">
									<div class="row">
										<div class="col-md-4" align="left">
											<div id="blok_back_2"><input type="button" class="btn btn-primary btn-block btn-lg" id="tombol_back_2" value="Sebelumnya"></div>
											<div id="blok_back_3"><input type="button" class="btn btn-primary btn-block btn-lg" id="tombol_back_3" value="Sebelumnya"></div>
											<div id="blok_back_4"><input type="button" class="btn btn-primary btn-block btn-lg" id="tombol_back_4" value="Sebelumnya"></div>
										</div>
										<div class="col-md-4" align="center">
										</div>
										<div class="col-md-4" align="right">
											<div id="blok_next_1"><input type="button" class="btn btn-primary btn-block btn-lg" id="tombol_next_1" value="Selanjutnya"></div>
											<div id="blok_next_2"><input type="button" class="btn btn-primary btn-block btn-lg" id="tombol_next_2" value="Selanjutnya"></div>
											<div id="blok_next_3"><input type="button" class="btn btn-primary btn-block btn-lg" id="tombol_next_3" value="Selanjutnya"></div>
											<div id="blok_next_4"><input type="submit" class="btn btn-primary btn-block btn-lg" id="submitForm" name="submitForm" value="Selanjutnya"></div>
										</div>
									</div>
								</div>
							</div> <!-- end of class modal-footer -->
						</div> <!-- end of class modal-content -->
					</div> <!-- end of class modal-dialog -->
				</div> <!-- end of class modal -->
			</div>
		</div>
	</div>


	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-md-12">
				<div class="modal fade" id="cmsStatistik" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" align="center">Statistik Bulan Ini</h4>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times; Tutup</span>
								</button>
							</div> <!-- end of class modal-header -->
							<div class="modal-body modal-bodys " style="background-color: white; color:black;">


								<div class="row">
									<?php
									#-- Bulan
									$this_bulan = date('Y-m');

									#-- Data Sangat Puas
									$sql = "SELECT id FROM polling WHERE satuan='$SatuanID' AND nilai='5' AND LEFT(waktu, 7)='$this_bulan'";
									$exe = _query($sql);
									$numSangatPuas = _num_rows($exe);
									#-- Data Puas
									$sql = "SELECT id FROM polling WHERE satuan='$SatuanID' AND  nilai='4' AND LEFT(waktu, 7)='$this_bulan'";
									$exe = _query($sql);
									$numPuas = _num_rows($exe);

									#-- Data Tidak Puas
									$sql = "SELECT id FROM polling WHERE satuan='$SatuanID' AND nilai='2' AND LEFT(waktu, 7)='$this_bulan'";
									$exe = _query($sql);
									$numTidakPuas = _num_rows($exe);
									?>
									<div class="col-lg-12">
										<center>
											<div style="width: 60%; text-align: center" align="center">
												<h4> Grafik Bulan Ini</h4>
												<canvas id="canvas"></canvas>
											</div>
										</center>
									</div>
									<script>
										var color = Chart.helpers.color;
										var barChartData = {
											labels: [""],
											datasets: [{
												label: 'Sangat Puas',
												backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
												borderColor: window.chartColors.blue,
												borderWidth: 1,
												data: [<?php echo $numSangatPuas; ?>]
											}, {
												label: 'Puas',
												backgroundColor: color(window.chartColors.yellow).alpha(0.5).rgbString(),
												borderColor: window.chartColors.yellow,
												borderWidth: 1,
												data: [<?php echo $numPuas; ?>]
											}, {
												label: 'Tidak Puas',
												backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
												borderColor: window.chartColors.red,
												borderWidth: 1,
												data: [<?php echo $numTidakPuas; ?>]
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
								</div>
							</div> <!-- end of class modal-body -->
						</div> <!-- end of class modal-content -->
					</div> <!-- end of class modal-dialog -->
				</div> <!-- end of class modal -->
			</div>
		</div>
	</div>

	<!-- Custom scripts for this template -->
	<script src="public/front/vendor/jquery/jquery.min.js"></script>
	<script src="public/front/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<!-- Plugin JavaScript -->
	<script src="public/front/vendor/jquery-easing/jquery.easing.min.js"></script>
	<script src="public/front/js/stylish-portfolio.min.js"></script>
	<!-- JavaScript -->
	<script src="public/assets/js/jquery.min.js"></script>
	<script src="public/assets/js/popper.min.js"></script>
	<script src="public/assets/js/bootstrap.min.js"></script>
	<script src="public/vendor/jqbtk/jqbtk.js"></script>

	<script src="public/assets/js/custom.js"></script>


</body>

</html>