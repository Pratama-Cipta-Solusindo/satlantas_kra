<?php
require_once('system/system.php');

if (!isset($_SESSION['status_responden']) or $_SESSION['status_responden'] != '1') {
	echo 1;
	header('Location: index.php');
	exit();
}

if (isset($_GET['com']) and $_GET['com'] == 'exit') {
	session_destroy();
	header('Location: index.php');
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

		/* HIDE RADIO */
		.radioicon [type=radio] {
			position: absolute;
			opacity: 0;
			width: 0;
			height: 0;
		}

		/* IMAGE STYLES */
		.radioicon [type=radio]+img {
			cursor: pointer;
			width: 128px;
			height: 128px;
			-webkit-filter: brightness(1.2) grayscale(.75) opacity(.5);
			-moz-filter: brightness(1.2) grayscale(.75) opacity(.5);
			filter: brightness(1.2) grayscale(.75) opacity(.5);
		}

		.radioicon [type=radio]:hover+img {
			outline: 0px solid #f00;
			-webkit-filter: brightness(1) grayscale(0) opacity(1);
			-moz-filter: brightness(1) grayscale(0) opacity(1);
			filter: brightness(1) grayscale(0) opacity(1);
		}

		.radioicon [type=radio]:checked+img {
			outline: 0px solid #f00;
			-webkit-filter: brightness(1) grayscale(0) opacity(1);
			-moz-filter: brightness(1) grayscale(0) opacity(1);
			filter: brightness(1) grayscale(0) opacity(1);
		}
	</style>

</head>

<body style="background-color:#000000; color:#ffffff;">
	<div class="container">
		<div class="row">
			<div class="col-md-12" align="center" id="title" style="margin-top:50px; margin-bottom:50px;">
				<h1>SILAHKAN PILIH MENU DIBAWAH INI<br></h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3" align="center" id="menuIkm">
				<?php
				if (!isset($_SESSION['status_ikm']) or $_SESSION['status_ikm'] == '0') {
				?>
					<a class="js-scroll-trigger" href="index2.php">
						<img src="public/images/rating.png">
					</a>
				<?php
				} else {
				?>
					<a class="js-scroll-trigger" href="#">
						<img src="public/images/rating_off.png">
					</a>
				<?php
				}
				?>
			</div>
			<div class="col-md-3" align="center" id="menuSurvey">
				<?php
				if (!isset($_SESSION['status_survey']) or $_SESSION['status_survey'] == '0') {
				?>
					<a class="js-scroll-trigger" href="#" data-toggle="modal" data-target="#modalSoal">
						<img src="public/images/survey.png">
					</a>
				<?php
				} else {
				?>
					<a class="js-scroll-trigger" href="#">
						<img src="public/images/survey_off.png">
					</a>
				<?php
				}
				?>
			</div>
			<div class="col-md-3" align="center" id="menuSurvey">
				<?php
				if ((isset($_SESSION['status_ikm']) or isset($_SESSION['status_survey'])) and (!isset($_SESSION['status_saran']) or $_SESSION['status_saran'] == '0')) {
				?>
					<a class="js-scroll-trigger" href="#" data-toggle="modal" data-target="#modalSaran">
						<img src="public/images/saran.png">
					</a>
				<?php
				} else {
				?>
					<a class="js-scroll-trigger" href="#">
						<img src="public/images/saran_off.png">
					</a>
				<?php
				}
				?>
			</div>
			<div class="col-md-3" align="center" id="menuSurvey">
				<?php
				if ((isset($_SESSION['status_ikm']) and $_SESSION['status_ikm'] == '1')
					or (isset($_SESSION['status_survey']) and $_SESSION['status_survey'] == '1')
				) {
				?>
					<a class="js-scroll-trigger" href="menu.php?com=exit">
						<img src="public/images/exit.png">
					</a>
				<?php
				} else {
				?>
					<a class="js-scroll-trigger" href="#">
						<img src="public/images/exit_off.png">
					</a>
				<?php
				}
				?>
			</div>
		</div>

	</div> <!-- end og class container-fluid -->



	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-md-12 big-box">
				<div class="modal fade" id="modalSoal" tabindex="-1" role="dialog" aria-labelledby="modalSoalLabel" aria-hidden="true">

					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" align="center" style="color:#000000;">Silahkan Jawab Pertanyaan Dibawah Ini</h4>
							</div> <!-- end of class modal-header -->

							<div class="modal-body">
								<form action="index.php?com=save_soal" method="post" id="cmsFormSoal" name="cmsFormSoal" class="" enctype="multipart/form-data">
									<input type="hidden" name="act" value="save">
									<div class="container-fluid">
										<div class="row">
											<div class="col-md-12">
												<?php
												$sqlSoal = "SELECT soal.soal_id, soal.kategori_id, soal.soal, soal.aktif, soal.mode_ikon,
					kategori.kategori,
					kuisioner.kuisioner, kuisioner.mode_emoticon
			FROM kuisioner_soal soal 
				INNER JOIN kuisioner_soal_kategori kategori 
					ON soal.kategori_id=kategori.kategori_id 
						AND kategori.deleted='0'					
				INNER JOIN kuisioner 
					ON kategori.kuisioner_id=kuisioner.kuisioner_id 
						AND kuisioner.aktif='1' AND kuisioner.deleted='0'
						AND kuisioner.satpas_id='" . $SatuanID . "'
			WHERE soal.deleted='0' 
			ORDER BY soal.aktif DESC, kategori.kategori ASC, soal.soal ASC";
												#echo $sqlSoal;
												$exeSoal = _query($sqlSoal);
												$jmlSoal = _num_rows($exeSoal);
												$no = 1;
												$_SESSION['jumlah_soal'] = $jmlSoal;

												while ($rSoal = _object($exeSoal)) {
													$soal_id = $rSoal->soal_id;
													$mode_emoticon 	= $rSoal->mode_emoticon;
													$mode_ikon		= $rSoal->mode_ikon;
													#$class_div_icon = $mode_emoticon == 1 ? 'radioicon' : '';
													$class_div_icon = $mode_ikon == 1 ? 'radioicon' : '';
												?>
													<div id="soal_<?php echo $no; ?>">
														<div class="form-group row">
															<div class="col-sm-12 <?php echo $class_div_icon; ?>">
																<?php echo uppercase($rSoal->kategori); ?><br>
																<?php echo $rSoal->soal; ?> <br>
																<?php
																$sqlRef = "SELECT opsi_id, soal_id, opsi, nilai, ikon, mode_ikon
								FROM kuisioner_soal_opsi 
								WHERE deleted='0' AND soal_id='" . $soal_id . "'
								ORDER BY created_at ASC";
																$exeRef = _query($sqlRef);
																while ($rRef = _object($exeRef)) {
																	$opsi_id 	= $rRef->opsi_id;
																?>
																	<?php
																	#if ($mode_emoticon == 0) {
																	if ($mode_ikon == 0) {
																	?>
																		<div class="form-check">
																			<input class="form-check-input" type="radio" name="jawab[<?php echo $soal_id; ?>]" id="jawab_<?php echo $opsi_id; ?>" value="<?php echo $opsi_id; ?>_<?php echo $rRef->nilai; ?>">

																			<label class="form-check-label" for="jawab_<?php echo $opsi_id; ?>"> <?php echo $rRef->opsi; ?></label>
																		</div>
																	<?php
																	} else {
																	?>
																		<label>
																			<input class="form-check-input" type="radio" name="jawab[<?php echo $soal_id; ?>]" id="jawab_<?php echo $opsi_id; ?>" value="<?php echo $opsi_id; ?>_<?php echo $rRef->nilai; ?>">
																			<img src="public/icons/<?php echo $rRef->ikon; ?>" style="padding: 10px;">
																		</label>
																	<?php
																	}
																	?>
																<?php
																}
																?>
															</div>
														</div>
													</div>
												<?php
													$no++;
												}
												?>
											</div>
										</div>
									</div> <!-- end of class container-fluid -->
									<!--<input type="submit" value="simpan">-->
								</form>
							</div> <!-- end of class modal-body -->

							<div class="modal-footer">
								<div class="container-fluid">
									<div class="row">
										<div class="col-md-4" align="left">
											<?php
											$iBack = 2;
											while ($iBack <= $jmlSoal) {
											?>
												<div id="soal_back_<?php echo $iBack; ?>"><input type="button" class="btn btn-primary btn-block btn-lg" id="tombol_soal_back_<?php echo $iBack; ?>" value="Sebelumnya"></div>
											<?php
												$iBack++;
											}
											?>
										</div>
										<div class="col-md-4" align="center">
										</div>
										<div class="col-md-4" align="right">
											<?php
											$iNext = 1;
											while ($iNext < $jmlSoal) {
											?>
												<div id="soal_next_<?php echo $iNext; ?>"><input type="button" class="btn btn-primary btn-block btn-lg" id="tombol_soal_next_<?php echo $iNext; ?>" value="Selanjutnya"></div>
											<?php
												$iNext++;
											}
											?>
											<div id="soal_next_<?php echo $jmlSoal; ?>"><input type="submit" class="btn btn-primary btn-block btn-lg" id="submitFormSoal" name="submitFormSoal" value="Simpan"></div>
										</div>
									</div>
								</div>
							</div> <!-- end of class modal-footer -->
						</div> <!-- end of class modal-content -->
					</div> <!-- end of class modal-dialog -->
				</div> <!-- end of class modal -->
			</div> <!-- end of class col big-box -->
		</div> <!-- enf og class row -->
	</div> <!-- end og class container-fluid -->



	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-md-12 big-box">
				<div class="modal fade" id="modalSaran" tabindex="-1" role="dialog" aria-labelledby="modalSaranLabel" aria-hidden="true">

					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h4 class="modal-title" align="center" style="color:#000000;">Silahkan Beri Masukan Berupa Kritik dan Saran</h4>
							</div> <!-- end of class modal-header -->

							<div class="modal-body">
								<form action="index.php?com=save_saran" method="post" id="cmsFormSaran" name="cmsFormSaran" class="" enctype="multipart/form-data">
									<input type="hidden" name="act" value="save">
									<div class="container-fluid">
										<div class="row">
											<div class="col-md-12">
												<textarea cols="5" name="saran" id="saran" class="form-control kb form-control-lg" placeholder="Masukan Kritik dan Saran Anda" autocomplete="off" required></textarea>
											</div>
										</div>
									</div> <!-- end of class container-fluid -->
									<!--<input type="submit" value="simpan">-->
								</form>
							</div> <!-- end of class modal-body -->

							<div class="modal-footer">
								<div class="container-fluid">
									<div class="row">
										<div class="col-md-4" align="left">
										</div>
										<div class="col-md-4" align="center">
										</div>
										<div class="col-md-4" align="right">
											<div id=""><input type="submit" class="btn btn-primary btn-block btn-lg" id="submitSaran" name="submitSaran" value="Simpan"></div>
										</div>
									</div>
								</div>
							</div> <!-- end of class modal-footer -->
						</div> <!-- end of class modal-content -->
					</div> <!-- end of class modal-dialog -->
				</div> <!-- end of class modal -->
			</div> <!-- end of class col big-box -->
		</div> <!-- enf og class row -->
	</div> <!-- end og class container-fluid -->




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

	<script>
		$(document).ready(function() {
			<?php
			$iSoal = 2;
			while ($iSoal <= $jmlSoal) {
			?>
				$("#soal_<?php echo $iSoal; ?>").hide();
			<?php
				$iSoal++;
			}
			?>
			<?php
			$iBack = 2;
			while ($iBack <= $jmlSoal) {
			?>
				$("#soal_back_<?php echo $iBack; ?>").hide();
			<?php
				$iBack++;
			}
			?>
			<?php
			$iNext = 2;
			while ($iNext <= $jmlSoal) {
			?>
				$("#soal_next_<?php echo $iNext; ?>").hide();
			<?php
				$iNext++;
			}
			?>
			<?php
			$iSoal = 1;
			while ($iSoal <= $jmlSoal) {
				$iSoalMin = $iSoal - 1;
				$iSoalPlus = $iSoal + 1;
			?>

				$('#tombol_soal_back_<?php echo $iSoal; ?>').click(function() {
					$("#soal_<?php echo $iSoal; ?>").hide();
					$("#soal_back_<?php echo $iSoal; ?>").hide();
					$("#soal_next_<?php echo $iSoal; ?>").hide();

					$("#soal_<?php echo $iSoalMin; ?>").show();
					$("#soal_back_<?php echo $iSoalMin; ?>").show();
					$("#soal_next_<?php echo $iSoalMin; ?>").show();
				});
				$('#tombol_soal_next_<?php echo $iSoal; ?>').click(function() {
					$("#soal_<?php echo $iSoal; ?>").hide();
					$("#soal_back_<?php echo $iSoal; ?>").hide();
					$("#soal_next_<?php echo $iSoal; ?>").hide();

					$("#soal_<?php echo $iSoalPlus; ?>").show();
					$("#soal_back_<?php echo $iSoalPlus; ?>").show();
					$("#soal_next_<?php echo $iSoalPlus; ?>").show();
				});
			<?php
				$iSoal++;
			}
			?>
		});
	</script>


</body>

</html>