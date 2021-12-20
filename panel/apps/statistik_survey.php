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
			$layanan_id		= isset($_GET['layanan_id']) ? $_GET['layanan_id'] : '99';
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
		<strong>STATISTIK SURVEY</strong> 
	</div>
	<div class="card-body">
			<center>
			<div id="container" style="width: 90%; text-align: center" align="center">
				<h4> Detail Survey | <a class="btn btn-info btn-sm" href="cetak_detail2.php?mod=filter&t1=<?php echo $str_tanggal1;?>&t2=<?php echo $str_tanggal2;?>&layanan_id=<?php echo $layanan_id;?>">Cetak</a></h4>
			</div>
			</center>
				
			<div class="container">
				<div class="row justify-content-center">
					<form action="index.php" method="get" class="form-inline" align="center">
						<input type="hidden" name="com" value="statistik_survey">
						<input type="hidden" name="mod" value="filter">
						<div class="form-group mb-2">
							<input type="date" name="t1" class="form-control form-control-sm" id="t1" placeholder="Dari Tanggal" value="<?php echo $str_tanggal1;?>">
						</div>
						<div class="form-group mb-2">
							s/d.
						</div>
						<div class="form-group mb-2">
							<input type="date" name="t2" class="form-control form-control-sm" id="t2" placeholder="Sampai Tanggal" value="<?php echo $str_tanggal2;?>">
						</div>
						<div class="form-group mb-2">
							<select id="layanan_id" class="form-control-sm" name="layanan_id" required>
								<option value="">Pilih Layanan</option>
								<?php
								foreach($listJenisLayanan as $key => $value) {
									$selected = ($key == $layanan_id) ? 'selected="selected"' : '';
									echo '<option value="'. $key .'" '. $selected .'>'. $value .'</option>';
								}
								?>
								<option value="99">Semua Layanan</option>
							</select>
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
			</div> <!-- end of class container -->
			<?php
			}
			?>
	</div>
</div>