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
<title>Detail Survey</title>
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="description" content="Aplikasi Indeks Kepuasan Masyarakat">
<meta name="author" content="CV Cipta Mandiri Solusindo">

<!-- Chart.js -->
<script src="../public/vendor/Chart.js/dist/Chart.min.js"></script>
<script src="../public/vendor/Chart.js/samples/utils.js"></script>
<style>
	body{
		font-family: 'Arial';
		font-size:14px;
		margin-left: 0	px;
		margin-top: 0px;
		margin-right: 0px;
		margin-bottom: 0px;
		background-color:#FFF;
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
				<font class="f30"><strong>SATLANTAS POLRES PATI</strong></font><br>
				<font class="f20">Jl. A. Yani No.1, Ngarus, Kec. Pati, Kabupaten Pati<br>
				Jawa Tengah Kodepos 59112</font>
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
	$layanan_id		= isset($_GET['layanan_id']) ? $_GET['layanan_id'] : '99';
	$str_tanggal1	= isset($_GET['t1']) ? str_replace('.', '', $_GET['t1']) : '';
	$str_tanggal2	= isset($_GET['t2']) ? str_replace('.', '', $_GET['t2']) : '';
	#- cek maksimal hari

				$start_date 	= new DateTime($str_tanggal1);
				$end_date 		= new DateTime($str_tanggal2);
				$interval 		= $start_date->diff($end_date);
				$jumlah_hari 	= $interval->days;
				
				#- where layanan_id
				$where_layanan_id = ($layanan_id != '99') ? "AND r.layanan='". $layanan_id ."'" : '';
				
				#jumlah responden pria wanita
				$dataJenisKelamin = array();
				$sql = "SELECT COUNT(r.id_responden) as data, r.jk 
							FROM responden r
							WHERE r.satpas_id='$SatuanID' AND r.nilai > 0
								AND (LEFT(r.waktu, 10) BETWEEN '$str_tanggal1' AND '$str_tanggal2') 
								$where_layanan_id
							GROUP BY r.jk";
				#echo $sql;
				$exe = _query($sql);
				$jmlResponden = 0;
				while ($row = _object($exe)) {
					$data 	= $row->data;
					$jk 	= $row->jk;
					$dataJenisKelamin[$jk]	= $data;
					$jmlResponden 			= $jmlResponden + $data;
				}
				
				#- responden by layanan
				$dataLayanan = array();
				$sql = "SELECT COUNT(r.id_responden) as data, r.layanan 
							FROM responden r
							WHERE satpas_id='$SatuanID' 
								AND (LEFT(r.waktu, 10) BETWEEN '$str_tanggal1' AND '$str_tanggal2')
								AND r.nilai > 0
								$where_layanan_id
							GROUP BY r.layanan";
				#echo $sql;
				$exe = _query($sql);
				while ($row = _object($exe)) {
					$data 	= $row->data;
					$layanan 	= $row->layanan;
					$dataLayanan[$layanan]	= $data;
				}
				
				#- responden by agama
				$dataAgama = array();
				$sql = "SELECT COUNT(r.id_responden) as data, r.agama 
							FROM responden r
							WHERE r.satpas_id='$SatuanID' AND r.nilai > 0
								AND (LEFT(r.waktu, 10) BETWEEN '$str_tanggal1' AND '$str_tanggal2')
								$where_layanan_id
							GROUP BY r.agama";
				#echo $sql;
				$exe = _query($sql);
				while ($row = _object($exe)) {
					$data 	= $row->data;
					$agama 	= $row->agama;
					$dataAgama[$agama]	= $data;
				}
				
				#- responden by usia
				$dataUsia = array();
				$sql = "SELECT COUNT(r.id_responden) as data, r.usia 
							FROM responden r
							WHERE r.satpas_id='$SatuanID' AND r.nilai > 0
								AND (LEFT(r.waktu, 10) BETWEEN '$str_tanggal1' AND '$str_tanggal2') 
								$where_layanan_id
							GROUP BY r.usia";
				#echo $sql;
				$exe = _query($sql);
				while ($row = _object($exe)) {
					$data 	= $row->data;
					$usia 	= $row->usia;
					$dataUsia[$usia]	= $data;
				}
				
				#- responden by pendidikan
				$dataPendidikan = array();
				$sql = "SELECT COUNT(r.id_responden) as data, r.pendidikan 
							FROM responden r
							WHERE r.satpas_id='$SatuanID' AND r.nilai > 0
								AND (LEFT(r.waktu, 10) BETWEEN '$str_tanggal1' AND '$str_tanggal2')  
								$where_layanan_id
							GROUP BY r.pendidikan";
				#echo $sql;
				$exe = _query($sql);
				while ($row = _object($exe)) {
					$data 	= $row->data;
					$pendidikan 	= $row->pendidikan;
					$dataPendidikan[$pendidikan]	= $data;
				}
				
				#- responden by pekerjaan
				$dataPekerjaan = array();
				$sql = "SELECT COUNT(r.id_responden) as data, r.pekerjaan 
							FROM responden r
							WHERE r.satpas_id='$SatuanID' AND r.nilai > 0
								AND (LEFT(r.waktu, 10) BETWEEN '$str_tanggal1' AND '$str_tanggal2') 
								$where_layanan_id
							GROUP BY r.pekerjaan";
				#echo $sql;
				$exe = _query($sql);
				while ($row = _object($exe)) {
					$data 	= $row->data;
					$pekerjaan 	= $row->pekerjaan;
					$dataPekerjaan[$pekerjaan]	= $data;
				}	
				
				#- nilai survey 
				$dataNilai = array();
				$sql = "SELECT r.nilai 
							FROM responden r
							WHERE r.satpas_id='$SatuanID' AND r.nilai > 0
								AND (LEFT(r.waktu, 10) BETWEEN '$str_tanggal1' AND '$str_tanggal2')
								$where_layanan_id";
								
				#echo $sql;
				$exe = _query($sql);
				$jmlData = _num_rows($exe);
				$jmlNilai = 0;
				while ($row = _object($exe)) {
					$nilai 	= $row->nilai;
					$jmlNilai = $jmlNilai + $nilai;
				}
				#- hitung nilai
				$nilaiIKM = @round($jmlNilai / $jmlData, 2);
				$nilaiIKM = ($jmlNilai < 1) ? 0 : $nilaiIKM;
			
			#--hitung skm
			$sql2 = "SELECT
						soal.soal,
						COUNT(jawab.soal_id) AS responden,
						SUM(opsi.nilai) AS nilai,
						SUM(opsi.nilai) / COUNT(jawab.soal_id) AS rerata 
					FROM
						kuisioner_soal soal
						INNER JOIN kuisioner_soal_kategori kategori ON soal.kategori_id = kategori.kategori_id 
							AND kategori.aktif = '1'
						INNER JOIN kuisioner ON kategori.kuisioner_id = kuisioner.kuisioner_id 
							AND kuisioner.aktif = '1'
						LEFT JOIN kuisioner_jawab jawab ON soal.soal_id = jawab.soal_id 
						INNER JOIN kuisioner_soal_opsi opsi ON jawab.opsi_id = opsi.opsi_id 
						INNER JOIN responden r ON jawab.created_by=r.id_responden AND r.nilai IS NOT NULL
					WHERE
					LEFT  (jawab.created_at,10) BETWEEN '$str_tanggal1'
						AND '$str_tanggal2'
						$where_layanan_id
					GROUP BY
						soal.soal 
					ORDER BY
						soal.created_at ASC";
			#echo $sql2;
			$exe = _query($sql2);
			// $jmlResponden = 0;
			$soal_skm = array();
			$nilai_skm = array();
			$rerata_skm = array();
			$i = 1;
			while ($row = _object($exe)) {
				$soal_skm[$i] 		= $row->soal;
				$nilai_skm[$i] 		= (int)$row->nilai;
				$rerata_skm[$i]	= number_format($row->rerata, '2');
				$i++;
			}
			?>	
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tbody>
							<tr>
							  <td width="39%" align="center" valign="top">								
								<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabel_data">
								  <tbody>
									<tr>
									  <td align="center" bgcolor="#ccc">
										<strong>PERIODE SURVEY</strong>
									  </td>
									</tr>
									<tr>
									  <td align="center" valign="middle" style="font-size: 30px;">
										<strong><?php echo tglIndo($str_tanggal1);?></strong><br>s/d.<br><strong><?php echo tglIndo($str_tanggal2);?></strong>
									  </td>
									</tr>
								  </tbody>
								</table>
								<br>							
								<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabel_data">
								  <tbody>
									<tr>
									  <td align="center" bgcolor="#ccc">
										<strong>NILAI</strong>
									  </td>
									</tr>
									<tr>
									  <td align="center" valign="middle" style="font-size: 125px;"><strong><?php echo $nilaiIKM;?></strong></td>
									</tr>
								  </tbody>
								</table>	
							  </td>
							  <td width="2%">&nbsp;</td>
							  <td width="59%" align="center" valign="top">								
								<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabel_data">
								  <tbody>
									<tr>
									  <td align="center" bgcolor="#ccc">
										<strong>JENIS LAYANAN : <?php echo ($layanan_id == '99') ? 'SEMUA LAYANAN' : strtoupper($listJenisLayanan[$layanan_id]);?></strong>
									  </td>
									</tr>
									<tr>
									  <td align="center" bgcolor="#ccc">
										<strong>RESPONDEN</strong>
									  </td>
									</tr>
									<tr>
									  <td align="center">
											<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabel_noborder">
												<tr>
												  <td align="right" valign="top" width="30%"><b>Jumlah Responden : </b></td>
												  <td align="left" valign="top"><b><?php echo $jmlResponden;?></b> orang</td>
												  <td align="left" valign="top">&nbsp;</td>
												</tr>
												<?php 
												if ($layanan_id == '99') {
												?>
												<tr>
												  <td align="right" valign="top"><b>Layanan : </b></td>
												  <td align="left" valign="top">
													<b><?php echo (@$dataLayanan[1] > 0) ? @$dataLayanan[1] : 0;?></b> <?php echo $listJenisLayanan[1];?><br>
													<b><?php echo (@$dataLayanan[3] > 0) ? @$dataLayanan[3] : 0;?></b> <?php echo $listJenisLayanan[3];?><br>
													<b><?php echo (@$dataLayanan[5] > 0) ? @$dataLayanan[5] : 0;?></b> <?php echo $listJenisLayanan[5];?><br>
												  </td>
												  <td align="left" valign="top">
													<b><?php echo (@$dataLayanan[2] > 0) ? @$dataLayanan[2] : 0;?></b> <?php echo $listJenisLayanan[2];?><br>
													<b><?php echo (@$dataLayanan[4] > 0) ? @$dataLayanan[4] : 0;?></b> <?php echo $listJenisLayanan[4];?><br>
													<b><?php echo (@$dataLayanan[6] > 0) ? @$dataLayanan[6] : 0;?></b> <?php echo $listJenisLayanan[6];?><br>													
												  </td>
												</tr>
												<?php
												}
												?>
												<tr>
												  <td align="right" valign="top"><b>Jenis Kelamin : </b></td>
												  <td align="left" valign="top"><b><?php echo (@$dataJenisKelamin[1] > 0) ? @$dataJenisKelamin[1] : 0;?></b> <?php echo $listJenisKelamin[1];?></td>
												  <td align="left" valign="top"><b><?php echo (@$dataJenisKelamin[2] > 0) ? @$dataJenisKelamin[2] : 0;?></b> <?php echo $listJenisKelamin[2];?></td>
												</tr>
												<tr>
												  <td align="right" valign="top"><b>Agama : </b></td>
												  <td align="left" valign="top">
													<b><?php echo (@$dataAgama[1] > 0) ? @$dataAgama[1] : 0;?></b> <?php echo $listAgama[1];?><br>
													<b><?php echo (@$dataAgama[2] > 0) ? @$dataAgama[2] : 0;?></b> <?php echo $listAgama[2];?><br>
													<b><?php echo (@$dataAgama[3] > 0) ? @$dataAgama[3] : 0;?></b> <?php echo $listAgama[3];?><br>
													<b><?php echo (@$dataAgama[4] > 0) ? @$dataAgama[4] : 0;?></b> <?php echo $listAgama[4];?><br>
												  </td>
												  <td align="left" valign="top">
													<b><?php echo (@$dataAgama[5] > 0) ? @$dataAgama[5] : 0;?></b> <?php echo $listAgama[5];?><br>
													<b><?php echo (@$dataAgama[6] > 0) ? @$dataAgama[6] : 0;?></b> <?php echo $listAgama[6];?><br>
													<b><?php echo (@$dataAgama[7] > 0) ? @$dataAgama[7] : 0;?></b> <?php echo $listAgama[7];?><br>													
												  </td>
												</tr>
												<tr>
												  <td align="right" valign="top"><b>Rentang Usia : </b></td>
												  <td align="left" valign="top">
													<b><?php echo (@$dataUsia[1] > 0) ? @$dataUsia[1] : 0;?></b> <?php echo $listUsia[1];?><br>
													<b><?php echo (@$dataUsia[2] > 0) ? @$dataUsia[2] : 0;?></b> <?php echo $listUsia[2];?><br>
													<b><?php echo (@$dataUsia[3] > 0) ? @$dataUsia[3] : 0;?></b> <?php echo $listUsia[3];?><br>
												  </td>
												  <td align="left" valign="top">
													<b><?php echo (@$dataUsia[4] > 0) ? @$dataUsia[4] : 0;?></b> <?php echo $listUsia[4];?><br>
													<b><?php echo (@$dataUsia[5] > 0) ? @$dataUsia[5] : 0;?></b> <?php echo $listUsia[5];?><br>													
												  </td>
												</tr>
												<tr>
												  <td align="right" valign="top"><b>Jenjang Pendidikan : </b></td>
												  <td align="left" valign="top">
													<b><?php echo (@$dataPendidikan[1] > 0) ? @$dataPendidikan[1] : 0;?></b> <?php echo $listPendidikan[1];?><br>
													<b><?php echo (@$dataPendidikan[2] > 0) ? @$dataPendidikan[2] : 0;?></b> <?php echo $listPendidikan[2];?><br>
													<b><?php echo (@$dataPendidikan[3] > 0) ? @$dataPendidikan[3] : 0;?></b> <?php echo $listPendidikan[3];?><br>
													<b><?php echo (@$dataPendidikan[4] > 0) ? @$dataPendidikan[4] : 0;?></b> <?php echo $listPendidikan[4];?><br>
												  </td>
												  <td align="left" valign="top">
													<b><?php echo (@$dataPendidikan[5] > 0) ? @$dataPendidikan[5] : 0;?></b> <?php echo $listPendidikan[5];?><br>
													<b><?php echo (@$dataPendidikan[6] > 0) ? @$dataPendidikan[6] : 0;?></b> <?php echo $listPendidikan[6];?><br>
													<b><?php echo (@$dataPendidikan[7] > 0) ? @$dataPendidikan[7] : 0;?></b> <?php echo $listPendidikan[7];?><br>
													<b><?php echo (@$dataPendidikan[8] > 0) ? @$dataPendidikan[8] : 0;?></b> <?php echo $listPendidikan[8];?><br>													
												  </td>
												</tr>
												<tr>
												  <td align="right" valign="top"><b>Jenis Pekerjaan : </b></td>
												  <td align="left" valign="top">
													<b><?php echo (@$dataPekerjaan[1] > 0) ? @$dataPekerjaan[1] : 0;?></b> <?php echo $listPekerjaan[1];?><br>
													<b><?php echo (@$dataPekerjaan[2] > 0) ? @$dataPekerjaan[2] : 0;?></b> <?php echo $listPekerjaan[2];?><br>
													<b><?php echo (@$dataPekerjaan[3] > 0) ? @$dataPekerjaan[3] : 0;?></b> <?php echo $listPekerjaan[3];?><br>
													<b><?php echo (@$dataPekerjaan[4] > 0) ? @$dataPekerjaan[4] : 0;?></b> <?php echo $listPekerjaan[4];?><br>
												  </td>
												  <td align="left" valign="top">
													<b><?php echo (@$dataPekerjaan[5] > 0) ? @$dataPekerjaan[5] : 0;?></b> <?php echo $listPekerjaan[5];?><br>
													<b><?php echo (@$dataPekerjaan[6] > 0) ? @$dataPekerjaan[6] : 0;?></b> <?php echo $listPekerjaan[6];?><br>
													<b><?php echo (@$dataPekerjaan[7] > 0) ? @$dataPekerjaan[7] : 0;?></b> <?php echo $listPekerjaan[7];?><br>
													<b><?php echo (@$dataPekerjaan[99] > 0) ? @$dataPekerjaan[99] : 0;?></b> <?php echo $listPekerjaan[99];?><br>													
												  </td>
												</tr>
											</table>
										</td>
									</tr>
								  </tbody>
								</table>
							  </td>
							</tr>
						  </tbody>
						</table>					
					</div> <!-- end of class col-md-12 -->
				</div> <!-- end of class row -->
			</div> <!-- end of class container ikm-->
		<div class="container">
			<div class="row">
				<div class="card-body">
					<center>
						<div id="container" style="width: 725px; height: 440px; text-align: center;page-break-before: always; " align="center">
							<h4 align="center">
								GRAFIK LAPORAN HASIL PENGOLAHAN SURVEY KEPUASAN MASYARAKAT<br> PER UNSUR PELAYANAN TAHUN <?= date('Y', strtotime($str_tanggal2)) ?><br>LAYANAN : <?php echo ($layanan_id == '99') ? 'SEMUA LAYANAN' : strtoupper($listJenisLayanan[$layanan_id]);?>
							</h4>
							<p align="center">Periode : <?= tglIndo($str_tanggal1) ?> - <?= tglIndo($str_tanggal2) ?></p>
							<canvas id="canvas"></canvas>
							<p>&nbsp;<br></p>
						</div>
					</center>
					<div class="table-responsive">
					<p>&nbsp;<br></p>
						<table align="center" cellpadding="2" cellspacing="0" class="table" border="1" style="width:768px;>
							<tr bgcolor="#CCC">
								<td align="center" width="50" height="25"> <strong>No.</strong></td>
								<td align="center"> <strong>UNSUR PELAYANAN</strong></td>
								<td align="center" width="150"> <strong>NILAI PERUNSUR</strong></td>
								<td align="center" width="150"> <strong>NILAI RATA-RATA</strong></td>
							</tr>
							<?php
							$label = array();
							$datasheet = array();
							$jumlah_data = count($soal_skm);
							for ($i = 1; $i <= $jumlah_data; $i++) {
							?>
								<tr>
									<td align="center"> <?php echo "U$i"; ?></>
									</td>
									<td align="left"> <?php echo $soal_skm[$i]; ?></td>
									<td align="center"> <?php echo $nilai_skm[$i]; ?></td>
									<td align="center"> <?php echo $rerata_skm[$i]; ?></td>
								</tr>
							<?php
								$label[] = "'U" . $i . "'";
								$datasheet_nilai[] = "'" . $nilai_skm[$i] . "'";
							}
							?>
						</table>
					</div>

					<script>
						var color = Chart.helpers.color;
						var barChartData = {
							labels: [<?php echo implode(',', $label); ?>],
							datasets: [{
								label: '',
								backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
								borderColor: window.chartColors.blue,
								borderWidth: 1,
								data: [<?php echo implode(',', $datasheet_nilai); ?>]
							}]

						};

						window.onload = function() {
							var ctx = document.getElementById('canvas').getContext('2d');
							window.myBar = new Chart(ctx, {
								type: 'bar',
								data: barChartData,
								options: {
									responsive: true,
									legend: false,
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
									},
									animation: {
										duration: 1,
										onComplete: function() {
											var chartInstance = this.chart,
												ctx = chartInstance.ctx;

											ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, Chart.defaults.global.defaultFontStyle, Chart.defaults.global.defaultFontFamily);
											ctx.textAlign = 'center';
											ctx.textBaseline = 'bottom';

											this.data.datasets.forEach(function(dataset, i) {
												var meta = chartInstance.controller.getDatasetMeta(i);
												meta.data.forEach(function(bar, index) {
													if (dataset.data[index] > 0) {
														var data = dataset.data[index];
														ctx.fillText(data, bar._model.x, bar._model.y - 5);
													}
												});
											});
										}
									}
								}
							});

						};
					</script>
				</div>
			</div> <!-- end of class row -->
		</div> <!-- end of class container skm-->
			
</div>
<!--</main>-->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="public/assets/js/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="public/assets/js/jquery-slim.min.js"><\/script>')</script>
</body>
</html>
