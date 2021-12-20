<style>
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
</style>


			<?php
			$str_tanggal1	= isset($_GET['t1']) ? str_replace('.', '', $_GET['t1']) : '';
			$str_tanggal2	= isset($_GET['t2']) ? str_replace('.', '', $_GET['t2']) : '';
		
			if ($str_tanggal1 != '' AND $str_tanggal2 != '') {
				$judul	= tglIndo($str_tanggal1) .' s/d. '. tglIndo($str_tanggal2);
			} else {
				$judul = '';
			}
			?>
<div class="card">
	<div class="card-header">
		<strong>DETAIL IKM</strong> 
	</div>
	<div class="card-body">
			<center>
			<div id="container" style="width: 90%; text-align: center" align="center">
				<h4> Detail Indeks Kepuasan Masyarakat | <a class="btn btn-info btn-sm" href="cetak_detail.php?mod=filter&t1=<?php echo $str_tanggal1;?>&t2=<?php echo $str_tanggal2;?>">Cetak</a></h4>
			</div>
			</center>
				
			<div class="container">
				<div class="row justify-content-center">
					<form action="index.php" method="get" class="form-inline" align="center">
						<input type="hidden" name="com" value="detail">
						<input type="hidden" name="mod" value="filter">
						<div class="form-group mx-sm-3 mb-2">
							<input type="date" name="t1" class="form-control form-control-sm" id="t1" placeholder="Dari Tanggal" value="<?php echo $str_tanggal1;?>">
						</div>
						<div class="form-group mb-2">
							s/d.
						</div>
						<div class="form-group mx-sm-3 mb-2">
							<input type="date" name="t2" class="form-control form-control-sm" id="t2" placeholder="Sampai Tanggal" value="<?php echo $str_tanggal2;?>">
						</div>
						<button type="submit" class="btn btn-primary btn-sm mb-2">Filter</button>
					</form>
				</div>
			</div>
			<?php

			if ($mod == 'filter' AND $str_tanggal1 != '' AND $str_tanggal2 != '') {
				#- cek maksimal hari
				$start_date 	= new DateTime($str_tanggal1);
				$end_date 		= new DateTime($str_tanggal2);
				$interval 		= $start_date->diff($end_date);
				$jumlah_hari 	= $interval->days;
				
				#jumlah responden pria wanita
				$dataJenisKelamin = array();
				$sql = "SELECT COUNT(id_responden) as data, jk 
							FROM responden 
							WHERE satpas_id='$SatuanID' 
								AND (LEFT(waktu, 10) BETWEEN '$str_tanggal1' AND '$str_tanggal2') 
							GROUP BY jk";
				#echo $sql;
				$exe = _query($sql);
				$jmlResponden = 0;
				while ($row = _object($exe)) {
					$data 	= $row->data;
					$jk 	= $row->jk;
					$dataJenisKelamin[$jk]	= $data;
					$jmlResponden 			= $jmlResponden + $data;
				}
				#die();
				#- responden by layanan
				$dataLayanan = array();
				$sql = "SELECT COUNT(id_responden) as data, layanan 
							FROM responden 
							WHERE satpas_id='$SatuanID' 
								AND (LEFT(waktu, 10) BETWEEN '$str_tanggal1' AND '$str_tanggal2') 
							GROUP BY layanan";
				#echo $sql;
				$exe = _query($sql);
				while ($row = _object($exe)) {
					$data 	= $row->data;
					$layanan 	= $row->layanan;
					$dataLayanan[$layanan]	= $data;
				}
				#- responden by agama
				$dataAgama = array();
				$sql = "SELECT COUNT(id_responden) as data, agama 
							FROM responden 
							WHERE satpas_id='$SatuanID' 
								AND (LEFT(waktu, 10) BETWEEN '$str_tanggal1' AND '$str_tanggal2') 
							GROUP BY agama";
				#echo $sql;
				$exe = _query($sql);
				while ($row = _object($exe)) {
					$data 	= $row->data;
					$agama 	= $row->agama;
					$dataAgama[$agama]	= $data;
				}
				
				#- responden by usia
				$dataUsia = array();
				$sql = "SELECT COUNT(id_responden) as data, usia 
							FROM responden 
							WHERE satpas_id='$SatuanID' 
								AND (LEFT(waktu, 10) BETWEEN '$str_tanggal1' AND '$str_tanggal2') 
							GROUP BY usia";
				#echo $sql;
				$exe = _query($sql);
				while ($row = _object($exe)) {
					$data 	= $row->data;
					$usia 	= $row->usia;
					$dataUsia[$usia]	= $data;
				}
				
				#- responden by pendidikan
				$dataPendidikan = array();
				$sql = "SELECT COUNT(id_responden) as data, pendidikan 
							FROM responden 
							WHERE satpas_id='$SatuanID' 
								AND (LEFT(waktu, 10) BETWEEN '$str_tanggal1' AND '$str_tanggal2') 
							GROUP BY pendidikan";
				#echo $sql;
				$exe = _query($sql);
				while ($row = _object($exe)) {
					$data 	= $row->data;
					$pendidikan 	= $row->pendidikan;
					$dataPendidikan[$pendidikan]	= $data;
				}
				
				#- responden by pekerjaan
				$dataPekerjaan = array();
				$sql = "SELECT COUNT(id_responden) as data, pekerjaan 
							FROM responden 
							WHERE satpas_id='$SatuanID' 
								AND (LEFT(waktu, 10) BETWEEN '$str_tanggal1' AND '$str_tanggal2') 
							GROUP BY pekerjaan";
				#echo $sql;
				$exe = _query($sql);
				while ($row = _object($exe)) {
					$data 	= $row->data;
					$pekerjaan 	= $row->pekerjaan;
					$dataPekerjaan[$pekerjaan]	= $data;
				}	
				
				#- nilai polling 
				$dataNilai = array();
				$sql = "SELECT COUNT(id) as data, nilai 
							FROM polling
							WHERE satuan='$SatuanID' 
								AND (LEFT(waktu, 10) BETWEEN '$str_tanggal1' AND '$str_tanggal2') 
							GROUP BY nilai";
				#echo $sql;
				$exe = _query($sql);
				$jmlDataNilai = 0;
				while ($row = _object($exe)) {
					$data 	= $row->data;
					$nilai 	= $row->nilai;
					$dataNilai[$nilai]	= $data;
					$jmlDataNilai = $jmlDataNilai + $data;
				}
				#- hitung nilai
				$data_1 = @$dataNilai[1];
				$data_2 = @$dataNilai[2];
				$data_3 = @$dataNilai[3];
				$data_4 = @$dataNilai[4];
				$data_5 = @$dataNilai[5];
				$nilai_1 = 1 * $data_1 * 20;
				$nilai_2 = 2 * $data_2 * 20;
				$nilai_3 = 3 * $data_3 * 20;
				$nilai_4 = 4 * $data_4 * 20;
				$nilai_5 = 5 * $data_5 * 20;
				$jmlNilai = $nilai_1 + $nilai_2 + $nilai_3 + $nilai_4 + $nilai_5;
				$nilaiIKM = @round($jmlNilai / $jmlDataNilai, 2);
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
										<strong>PERIODE IKM</strong>
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
										<strong>NILAI IKM</strong>
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
												<tr>
												  <td align="right" valign="top"><b>Layanan : </b></td>
												  <td align="left" valign="top">
													<b><?php echo (@$dataLayanan[1] > 0) ? @$dataLayanan[1] : 0;?></b> <?php echo $listJenisLayanan[1];?><br>
													<b><?php echo (@$dataLayanan[4] > 0) ? @$dataLayanan[4] : 0;?></b> <?php echo $listJenisLayanan[4];?><br>
													<b><?php echo (@$dataLayanan[5] > 0) ? @$dataLayanan[5] : 0;?></b> <?php echo $listJenisLayanan[5];?><br>
												  </td>
												  <td align="left" valign="top">
													<b><?php echo (@$dataLayanan[2] > 0) ? @$dataLayanan[2] : 0;?></b> <?php echo $listJenisLayanan[2];?><br>
													<b><?php echo (@$dataLayanan[3] > 0) ? @$dataLayanan[3] : 0;?></b> <?php echo $listJenisLayanan[3];?><br>													
												  </td>
												</tr>
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
			</div> <!-- end of class container -->
			<?php
			}
			?>
	</div>
</div>