<?php
if (isset($_GET['mod']) AND $_GET['mod'] == 'simpan_data') {
	$ip			= $_SERVER['REMOTE_ADDR'];
	$nilai_sp	= $_POST['sp'];
	$nilai_p	= $_POST['p'];
	$nilai_tp	= $_POST['tp'];
	$pin		= $_POST['pin'];
	$t			= $_POST['t'];
	$b			= $_POST['b'];
	$h			= $_POST['h'];
	$jml_data	= $nilai_sp + $nilai_p + $nilai_tp;
	
	$jml_baru		= ceil((30/100) * $jml_data);
	$jml_naik_gol	= ceil((7/100) * $jml_data);
	$jml_hilang		= (0.02/100) * $jml_data;
	$jml_rusak		= (0.01/100) * $jml_data;
	$jml_hilang		= ($jml_hilang > 1) ? ceil($jml_hilang) : 0;
	$jml_rusak		= ($jml_rusak > 1) ? ceil($jml_rusak) : 0;
	$jml_perpanjang	= $jml_data - $jml_baru - $jml_naik_gol - $jml_hilang - $jml_rusak;
	
	$url		= "index.php?com=ikm&mod=hari&t=$t&b=$b&h=$h";
	if ($pin != $pin_petugas) {
		echo "<script>alert('PIN salah...!!!');</script>";
		echo "<script>window.history.back();</script>";
		exit();
	}
	for ($i=0; $i<$nilai_sp; $i++) {
		#--- tipe layanan
		if ($jml_baru != 0) {
			$layanan	= 1;
			$jml_baru--;
		} elseif ($jml_perpanjang != 0) {
			$layanan	= 2;
			$jml_perpanjang--;
		} elseif ($jml_naik_gol != 0) {
			$layanan	= 3;
			$jml_naik_gol--;
		} elseif ($jml_hilang != 0) {
			$layanan	= 4;
			$jml_hilang--;
		} elseif ($jml_rusak != 0) {
			$layanan	= 5;
			$jml_rusak--;
		} else {
			$layanan	= 0;
		}
		#--- tipe layanan
		
		#- responden
		$id			= uuid();
		$satpas_id	= getSatpasId();
		$nik		= '';
		$nama		= '';
		$jk			= rand(1,2);
		$agama		= rand(1,3);
		$usia		= rand(2,4);
		$pendidikan	= rand(3,6);
		$pekerjaan	= rand(1,8);
		$wilayah	= 0;
		$alamat		= '';
		$hp			= ''; #nosql($_POST['hp']);
		$waktu 		= date('Y-m-d H:i:s');
		$random1	= rand(11111, 99999);
		$random2	= rand(1111, 9999);
		$signature	= $id; #md5($waktu . $nik);

		$sqlResponden = "INSERT INTO responden (id_responden, satpas_id, nik, nama, jk, agama, usia, pendidikan, pekerjaan, layanan, wilayah, alamat, hp, waktu, signature)  VALUES ('$id', '$satpas_id', '$nik', '$nama', '$jk', '$agama', '$usia', '$pendidikan', '$pekerjaan', '$layanan', '$wilayah', '$alamat', '$hp', '$waktu', '$signature')";
		$exeResponden = _query($sqlResponden);
		
		#- polling
		$nilai	= 5;
		$jam	= duaDigit(rand(8,15)) .':'. duaDigit(rand(1,59)) .':'. duaDigit(rand(1,59));
		$waktu	= $t .'-'. $b .'-'. $h .' '. $jam;
		$sqlPolling = "INSERT INTO polling SET id='$id', satuan='$SatuanID', layanan='$layanan', waktu='$waktu', ip='$ip', nilai='$nilai', signature='$signature'";
		$exe = _query($sqlPolling);
		
	}
	for ($a=0; $a<$nilai_p; $a++) {
		#--- tipe layanan
		if ($jml_baru != 0) {
			$layanan	= 1;
			$jml_baru--;
		} elseif ($jml_perpanjang != 0) {
			$layanan	= 2;
			$jml_perpanjang--;
		} elseif ($jml_naik_gol != 0) {
			$layanan	= 3;
			$jml_naik_gol--;
		} elseif ($jml_hilang != 0) {
			$layanan	= 4;
			$jml_hilang--;
		} elseif ($jml_rusak != 0) {
			$layanan	= 5;
			$jml_rusak--;
		} else {
			$layanan	= 0;
		}
		#--- tipe layanan
		
		#- responden
		$id			= uuid();
		$nik		= '';
		$nama		= '';
		$jk			= rand(1,2);
		$agama		= rand(1,3);
		$usia		= rand(2,4);
		$pendidikan	= rand(3,6);
		$pekerjaan	= rand(1,8);
		$wilayah	= 0;
		$alamat		= '';
		$hp			= ''; #nosql($_POST['hp']);
		$waktu 		= date('Y-m-d H:i:s');
		$random1	= rand(11111, 99999);
		$random2	= rand(1111, 9999);
		$signature	= md5($waktu . $random1 . $random2);

		$sqlResponden = "INSERT INTO responden (id_responden, satpas_id, nik, nama, jk, agama, usia, pendidikan, pekerjaan, layanan, wilayah, alamat, hp, waktu, signature)  VALUES ('$id', '$satpas_id', '$nik', '$nama', '$jk', '$agama', '$usia', '$pendidikan', '$pekerjaan', '$layanan', '$wilayah', '$alamat', '$hp', '$waktu', '$signature')";
		$exeResponden = _query($sqlResponden);
		
		#- polling
		$nilai	= 4;
		$jam	= duaDigit(rand(8,15)) .':'. duaDigit(rand(1,59)) .':'. duaDigit(rand(1,59));
		$waktu	= $t .'-'. $b .'-'. $h .' '. $jam;
		$sqlPolling = "INSERT INTO polling SET id='$id', satuan='$SatuanID', layanan='$layanan', waktu='$waktu', ip='$ip', nilai='$nilai', signature='$signature'";
		$exe = _query($sqlPolling);
	}
	for ($e=0; $e<$nilai_tp; $e++) {
		#--- tipe layanan
		if ($jml_baru != 0) {
			$layanan	= 1;
			$jml_baru--;
		} elseif ($jml_perpanjang != 0) {
			$layanan	= 2;
			$jml_perpanjang--;
		} elseif ($jml_naik_gol != 0) {
			$layanan	= 3;
			$jml_naik_gol--;
		} elseif ($jml_hilang != 0) {
			$layanan	= 4;
			$jml_hilang--;
		} elseif ($jml_rusak != 0) {
			$layanan	= 5;
			$jml_rusak--;
		} else {
			$layanan	= 0;
		}
		#--- tipe layanan
		
		#- responden
		$id			= uuid();
		$nik		= '';
		$nama		= '';
		$jk			= rand(1,2);
		$agama		= rand(1,3);
		$usia		= rand(2,4);
		$pendidikan	= rand(3,6);
		$pekerjaan	= rand(1,8);
		$wilayah	= 0;
		$alamat		= '';
		$hp			= ''; #nosql($_POST['hp']);
		$waktu 		= date('Y-m-d H:i:s');
		$random1	= rand(11111, 99999);
		$random2	= rand(1111, 9999);
		$signature	= md5($waktu . $random1 . $random2);

		$sqlResponden = "INSERT INTO responden (id_responden, satpas_id, nik, nama, jk, agama, usia, pendidikan, pekerjaan, layanan, wilayah, alamat, hp, waktu, signature)  VALUES ('$id', '$satpas_id', '$nik', '$nama', '$jk', '$agama', '$usia', '$pendidikan', '$pekerjaan', '$layanan', '$wilayah', '$alamat', '$hp', '$waktu', '$signature')";
		$exeResponden = _query($sqlResponden);
		
		#- polling
		$nilai	= 2;
		$jam	= duaDigit(rand(8,15)) .':'. duaDigit(rand(1,59)) .':'. duaDigit(rand(1,59));
		$waktu	= $t .'-'. $b .'-'. $h .' '. $jam;
		$sqlPolling = "INSERT INTO polling SET id='$id', satuan='$SatuanID', layanan='$layanan', waktu='$waktu', ip='$ip', nilai='$nilai', signature='$signature'";
		$exe = _query($sqlPolling);
	}
	sleep(1);
	echo "<script>alert('Data berhasil disimpan...!!!');</script>";
	echo "<script>window.location.href = '". $url ."';</script>";
	exit();
	
} elseif (isset($_GET['mod']) AND $_GET['mod'] == 'simpan_data_bulan') {
	$ip			= $_SERVER['REMOTE_ADDR'];
	$pin		= $_POST['pin'];
	$t			= $_POST['t'];
	$b			= $_POST['b'];
	$jml_hari	= date('t', mktime(0, 0, 0, $b, 1, $t));
	$this_tahun	= $t;
	$this_bulan	= $this_tahun .'-'. $b;
	
	$min1		= $_POST['min1'];
	$min2		= $_POST['min2'];
	$min3		= $_POST['min3'];
	$min4		= $_POST['min4'];
	$min5		= $_POST['min5'];
	$min6		= $_POST['min6'];
	$max1		= $_POST['max1'];
	$max2		= $_POST['max2'];
	$max3		= $_POST['max3'];
	$max4		= $_POST['max4'];
	$max5		= $_POST['max5'];
	$max6		= $_POST['max6'];
	$hari_libur	= $_POST['libur'];
	$hari_libur	= explode(',', $hari_libur);
	
	$url		= "index.php?com=ikm&mod=bulan&t=$t&b=$b";
	if ($pin != $pin_petugas) {
		echo "<script>alert('PIN salah...!!!');</script>";
		echo "<script>window.history.back();</script>";
		exit();
	}
	#- looping hari
	for ($i=1; $i<$jml_hari; $i++) {
		#- var
		$the_nilai		= array(4, 5);
		$tanggal_ini	= duaDigit($i);
		$this_hari		= $this_bulan .'-'. $tanggal_ini;
		$no_hari		= date('w', strtotime($this_hari));
		if ($no_hari == 1) {
			$min_jumlah	= $min1;
			$max_jumlah	= $max1;
			$max_jam	= 15;
		} elseif ($no_hari == 2) {
			$min_jumlah	= $min2;
			$max_jumlah	= $max2;
			$max_jam	= 15;
		} elseif ($no_hari == 3) {
			$min_jumlah	= $min3;
			$max_jumlah	= $max3;
			$max_jam	= 15;
		} elseif ($no_hari == 4) {
			$min_jumlah	= $min4;
			$max_jumlah	= $max4;
			$max_jam	= 15;
		} elseif ($no_hari == 5) {
			$min_jumlah	= $min5;
			$max_jumlah	= $max5;
			$max_jam	= 12;
		} elseif ($no_hari == 6) {
			$min_jumlah	= $min6;
			$max_jumlah	= $max6;
			$max_jam	= 12;
		}
		$this_jumlah = rand($min_jumlah,$max_jumlah);
		
		
		#-- jumlah per layanan
		$jml_baru		= ceil((30/100) * $this_jumlah);
		$jml_naik_gol	= ceil((7/100) * $this_jumlah);
		$jml_hilang		= (0.02/100) * $this_jumlah;
		$jml_rusak		= (0.01/100) * $this_jumlah;
		$jml_hilang		= ($jml_hilang > 1) ? ceil($jml_hilang) : 0;
		$jml_rusak		= ($jml_rusak > 1) ? ceil($jml_rusak) : 0;
		$jml_perpanjang	= $this_jumlah - $jml_baru - $jml_naik_gol - $jml_hilang - $jml_rusak;
		#-- jumlah per layanan
		
		#- tidak hari libur
		if (!in_array($tanggal_ini, $hari_libur) AND $no_hari != 0) {	
			
			for ($r=1; $r<=$this_jumlah; $r++) {
				#- var
				shuffle($the_nilai);
				$nilai = $the_nilai[0];
				
				$jam	= duaDigit(rand(8,$max_jam)) .':'. duaDigit(rand(1,59)) .':'. duaDigit(rand(1,59));
				$waktu	= $this_hari .' '. $jam;
				
				#--- tipe layanan
				if ($jml_baru != 0) {
					$layanan	= 1;
					$jml_baru--;
				} elseif ($jml_perpanjang != 0) {
					$layanan	= 2;
					$jml_perpanjang--;
				} elseif ($jml_naik_gol != 0) {
					$layanan	= 3;
					$jml_naik_gol--;
				} elseif ($jml_hilang != 0) {
					$layanan	= 4;
					$jml_hilang--;
				} elseif ($jml_rusak != 0) {
					$layanan	= 5;
					$jml_rusak--;
				} else {
					$layanan	= 0;
				}
				#--- tipe layanan
				
				
				#- responden
				$id			= uuid();
				$satpas_id	= getSatpasId();
				$nik		= '';
				$nama		= '';
				$jk			= rand(1,2);
				$agama		= rand(1,3);
				$usia		= rand(2,4);
				$pendidikan	= rand(3,6);
				$pekerjaan	= rand(1,8);
				$wilayah	= 0;
				$alamat		= '';
				$hp			= ''; #nosql($_POST['hp']);
				#$waktu 		= date('Y-m-d H:i:s');
				$random1	= rand(11111, 99999);
				$random2	= rand(1111, 9999);
				$signature	= $id; #md5($waktu . $nik);
		
				$sqlResponden = "INSERT INTO responden (id_responden, satpas_id, nik, nama, jk, agama, usia, pendidikan, pekerjaan, layanan, wilayah, alamat, hp, waktu, signature)  VALUES ('$id', '$satpas_id', '$nik', '$nama', '$jk', '$agama', '$usia', '$pendidikan', '$pekerjaan', '$layanan', '$wilayah', '$alamat', '$hp', '$waktu', '$signature')";
				$exeResponden = _query($sqlResponden);
				#echo $sqlResponden .'<br>';
				
				#- polling 
				$sqlPolling = "INSERT INTO polling SET id='$id', satuan='$SatuanID', layanan='$layanan', waktu='$waktu', ip='$ip', nilai='$nilai', signature='$signature'";
				$exe = _query($sqlPolling);
				#echo $sqlPolling .'<br>';
			}
		} #- end of !in_array
	}
	
	sleep(1);
	echo "<script>alert('Data berhasil disimpan...!!!');</script>";
	echo "<script>window.location.href = '". $url ."';</script>";
	exit();
}	
?>
<div class="card">
	<div class="card-header">
		<strong>INDEKS KEPUASAN MASYARAKAT</strong> 
	</div>
	<div class="card-body">
    	<?php
	if ($mod == '') {
		#-- Tahun
		$sql = "SELECT LEFT(waktu, 4) AS tahun FROM polling GROUP BY LEFT(waktu, 4) ORDER BY waktu ASC";
		$exe = _query($sql);
		$listTahun 		= array();
		$listSangatPuas	= array();
		$listPuas		= array();
		$listTidakPuas	= array();
		while ($row = _object($exe)) {
			$listTahun[$row->tahun] 		= "". $row->tahun ."";
			$listSangatPuas[$row->tahun]	= 0;
			$listPuas[$row->tahun] 			= 0;
			$listTidakPuas[$row->tahun] 	= 0;
		}
		$labelTahun = implode(', ', $listTahun);
		
		#-- Data Sangat Puas
		$sql = "SELECT LEFT(waktu, 4) AS tahun, COUNT(id) AS data FROM polling WHERE satuan='$SatuanID' AND nilai='5' GROUP BY LEFT(waktu, 4) ORDER BY waktu ASC";
		$exe = _query($sql);		
		while ($row = _object($exe)) {
			$listSangatPuas[$row->tahun] = $row->data;
		}
		$labelSangatPuas = implode(', ', $listSangatPuas);
		
		#-- Data Puas
		$sql = "SELECT LEFT(waktu, 4) AS tahun, COUNT(id) AS data FROM polling WHERE satuan='$SatuanID' AND  nilai='4' GROUP BY LEFT(waktu, 4) ORDER BY waktu ASC";
		$exe = _query($sql);
		while ($row = _object($exe)) {
			$listPuas[$row->tahun] = $row->data;
		}
		$labelPuas = implode(', ', $listPuas);
		
		#-- Data Tidak Puas
		$sql = "SELECT LEFT(waktu, 4) AS tahun, COUNT(id) AS data FROM polling WHERE satuan='$SatuanID' AND nilai='2' GROUP BY LEFT(waktu, 4) ORDER BY waktu ASC";
		$exe = _query($sql);
		while ($row = _object($exe)) {
			$listTidakPuas[$row->tahun] = $row->data;
		}
		$labelTidakPuas = implode(',', $listTidakPuas);
	?>	
		<center>
		<div id="container" style="width: 90%; text-align: center" align="center">
			<h4> Statistik Indeks Kepuasan Masyarakat | <a class="btn btn-info btn-sm" href="cetak.php">Cetak</a></h4>
			<canvas id="canvas"></canvas>
		</div>
		</center>
		
		<div class="table-responsive">					
			<table align="center" cellpadding="0" cellspacing="0" class="table" border="0">
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
				foreach($listTahun as $key => $value) {
					$tahun 			= $key;
					$sangat_puas	= ( @$listSangatPuas[$tahun] == '') ? 0 : @$listSangatPuas[$tahun];
					$puas			= ( @$listPuas[$tahun] == '' ) ? 0 : @$listPuas[$tahun];
					$tidak_puas		= ( @$listTidakPuas[$tahun] == '' ) ? 0 : @$listTidakPuas[$tahun];
					$jumlah			= $sangat_puas + $puas + $tidak_puas;
							
					$count_sangat_puas	= $count_sangat_puas + $sangat_puas;
					$count_puas			= $count_puas + $puas;
					$count_tidak_puas	= $count_tidak_puas + $tidak_puas;
					$count_jumlah		= $count_jumlah + $jumlah;
							
					$row_color = ($i%2 == 0) ? '#f2f2f2' : '#ffffff';
				?>
				<tr bgcolor="<?php echo $row_color;?>">
					<td align="center" height="25"><?php echo $i++;?></td>
					<td align="center"><a href="index.php?com=ikm&mod=tahun&t=<?php echo $tahun;?>"><strong><?php echo $tahun;?></strong></a></td>
					<td align="center"><?php echo $sangat_puas;?></td>
					<td align="center"><?php echo $puas;?></td>
					<td align="center"><?php echo $tidak_puas;?></td>
					<td align="center"><?php echo $jumlah;?></td>
				</tr>
				<?php
				} #. foreach
				?>
				<tr bgcolor="#CCC">
					<td align="right" height="25" colspan="2"> <strong>Total</strong></td>
					<td align="center"> <strong><?php echo $count_sangat_puas;?></strong></td>
					<td align="center"> <strong><?php echo $count_puas;?></strong></td>
					<td align="center"> <strong><?php echo $count_tidak_puas;?></strong></td>
					<td align="center"> <strong><?php echo $count_jumlah;?></strong></td>
				</tr>
			</table>
		</div>
		
		<script>
			var color = Chart.helpers.color;
			var barChartData = {
				labels: [<?php echo $labelTahun;?>],
				datasets: [{
					label: 'Sangat Puas',
					backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
					borderColor: window.chartColors.blue,
					borderWidth: 1,
					data: [ <?php echo $labelSangatPuas;?> ]
				}, {
					label: 'Puas',
					backgroundColor: color(window.chartColors.yellow).alpha(0.5).rgbString(),
					borderColor: window.chartColors.yellow,
					borderWidth: 1,
					data: [ <?php echo $labelPuas;?> ]
				}, {
					label: 'Tidak Puas',
					backgroundColor: color(window.chartColors.red).alpha(0.5).rgbString(),
					borderColor: window.chartColors.red,
					borderWidth: 1,
					data: [ <?php echo $labelTidakPuas;?> ]
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
							yAxes: [ {
								ticks: {
									beginAtZero: true
								}
							} ]
						}
					}
				});

			};

		</script>
	<?php
	}
	elseif ($mod == 'hari') {
		$str_tahun	= isset($_GET['t']) ? str_replace('.', '', $_GET['t']) : '';
		$tahun_ini	= ($str_tahun != '') ? $str_tahun : date('Y');
		$str_bulan	= isset($_GET['b']) ? str_replace('.', '', $_GET['b']) : '';		
		$bulan_ini	= ($str_bulan != '') ? $str_tahun .'-'. $str_bulan : date('Y-m');
		$str_hari	= isset($_GET['h']) ? str_replace('.', '', $_GET['h']) : '';
		$hari_ini	= ($str_bulan != '') ? $str_tahun .'-'. $str_bulan  .'-'. $str_hari : date('Y-m-d');
		
		#-- tanggal
		$listTanggal 			= array();
		$listTanggal[$hari_ini]	= $hari_ini;
		
		#-- Data Sangat Puas
		$sql = "SELECT LEFT(waktu, 10) AS tanggal, COUNT(nilai) AS data FROM polling WHERE  satuan='$SatuanID' AND nilai='5' AND LEFT(waktu, 10) = '$hari_ini' GROUP BY LEFT(waktu, 4) ORDER BY waktu ASC";
		$exe = _query($sql);
		$listSangatPuas = array();
		while ($row = _object($exe)) {
			$listSangatPuas[$row->tanggal] = $row->data;
		}
		$labelSangatPuas = implode(', ', $listSangatPuas);
		
		#-- Data Puas
		$sql = "SELECT LEFT(waktu, 10) AS tanggal, COUNT(nilai) AS data FROM polling WHERE  satuan='$SatuanID' AND nilai='4' AND LEFT(waktu, 10) = '$hari_ini'  GROUP BY LEFT(waktu, 4) ORDER BY waktu ASC";
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
		<center>
		<div id="container" style="width: 100%; text-align: center" align="center">
			<h4> Statistik Indeks Kepuasan Masyarakat Tanggal <?php echo tglIndo($hari_ini);?> | <a class="btn btn-info btn-sm" href="cetak.php?com=hari&t=<?php echo $tahun_ini;?>&b=<?php echo substr($bulan_ini, 5, 2);?>&h=<?php echo substr($hari_ini, 8, 2);?>">Cetak</a></h4>
			<canvas id="canvas2"></canvas>
			<p>&nbsp; </p>
		</div>
		</center>
		
		<div class="table-responsive">
			<table align="center" cellpadding="0" cellspacing="0" class="table" border="0">
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
				foreach($listTanggal as $key => $value) {
					$tanggal 		= $key;
					$sangat_puas	= ( @$listSangatPuas[$tanggal] == '') ? 0 : @$listSangatPuas[$tanggal];
					$puas			= ( @$listPuas[$tanggal] == '' ) ? 0 : @$listPuas[$tanggal];
					$tidak_puas		= ( @$listTidakPuas[$tanggal] == '' ) ? 0 : @$listTidakPuas[$tanggal];
					$jumlah			= $sangat_puas + $puas + $tidak_puas;
						
					$count_sangat_puas	= $count_sangat_puas + $sangat_puas;
					$count_puas			= $count_puas + $puas;
					$count_tidak_puas	= $count_tidak_puas + $tidak_puas;
					$count_jumlah		= $count_jumlah + $jumlah;
							
					$row_color = ($i%2 == 0) ? '#f2f2f2' : '#ffffff';
				?>
				<tr bgcolor="<?php echo $row_color;?>">
					<td align="center" height="25"><?php echo $i++;?></td>
					<td align="center"><?php echo tglIndo($tanggal);?></td>
					<td align="center"><?php echo $sangat_puas;?></td>
					<td align="center"><?php echo $puas;?></td>
					<td align="center"><?php echo $tidak_puas;?></td>
					<td align="center"><a href="#" data-toggle="modal" data-target="#cmsModalCenter" style="color: #000; text-decoration: none;"><?php echo $jumlah;?></a></td>
				</tr>
				<?php
				} #. foreach
				?>
				<tr bgcolor="#CCC">
					<td align="right" height="25" colspan="2"> <strong>Total</strong></td>
					<td align="center"> <strong><?php echo $count_sangat_puas;?></strong></td>
					<td align="center"> <strong><?php echo $count_puas;?></strong></td>
					<td align="center"> <strong><?php echo $count_tidak_puas;?></strong></td>
					<td align="center"> <strong><?php echo $count_jumlah;?></strong></td>
				</tr>
			</table>
		</div>
		
		<!-- Modal -->
		<div class="modal fade" id="cmsModalCenter" tabindex="-1" role="dialog" aria-labelledby="cmsModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<form action="index.php?com=ikm&mod=simpan_data" method="post">
						<input type="hidden" name="t" value="<?php echo $tahun_ini;?>">
						<input type="hidden" name="b" value="<?php echo substr($bulan_ini, -2);?>">
						<input type="hidden" name="h" value="<?php echo substr($hari_ini, -2);?>">
						<div class="modal-header">
							<h6 class="modal-title" id="exampleModalCenterTitle">Akses Petugas</h6>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">						
							<div class="row" id="input_data">
								<div class="col-md-4">
									Sangat Puas
									<input type="number" class="form-control form-control-sm" id="sp" name="sp">
								</div>
								<div class="col-md-4">
									Puas
									<input type="number" class="form-control form-control-sm" id="p" name="p">
								</div>
								<div class="col-md-4">
									Tidak Puas
									<input type="number" class="form-control form-control-sm" id="tp" name="tp">
								</div>
							</div>
							<div class="form-group">
								<label for="recipient-name" class="col-form-label">Masukkan PIN :</label>
								<input type="password" class="form-control form-control-sm" id="pin" name="pin">
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Keluar</button>
							<button type="submit" class="btn btn-sm btn-primary" id="simpan">Simpan</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<script>			
			var config = {
				type: 'pie',
				data: {
					datasets: [{
						data: [
							<?php echo $labelSangatPuas;?>, <?php echo $labelPuas;?>, <?php echo $labelTidakPuas;?>
						],
						backgroundColor: [
							window.chartColors.blue, window.chartColors.yellow, window.chartColors.red
						],
						label: 'Dataset 1'
					}],
					labels: [ 'Sangat Puas', 'Puas', 'Tidak Puas' ]
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
	}
	elseif ($mod == 'minggu') {
		$str_tanggal1	= isset($_GET['t1']) ? str_replace('.', '', $_GET['t1']) : '';
		$str_tanggal2	= isset($_GET['t2']) ? str_replace('.', '', $_GET['t2']) : '';
		
		if ($str_tanggal1 != '' AND $str_tanggal2 != '') {
			$judul	= tglIndo($str_tanggal1) .' s/d. '. tglIndo($str_tanggal2);
		} else {
			$judul = '';
		}
	?>
		<center>
			<div id="container" style="width: 100%; text-align: center" align="center">
				<h4> Statistik Indeks Kepuasan Masyarakat  |  <a class="btn btn-info btn-sm" href="cetak.php?com=minggu&t1=<?php echo $str_tanggal1;?>&t2=<?php echo $str_tanggal2;?>">Cetak</a><br><?php #echo $judul;?></h4>
			</div>
		</center>
			
		<div class="container">
			<div class="row justify-content-center">
				<form action="index.php" method="get" class="form-inline" align="center">
					<input type="hidden" name="com" value="ikm">
					<input type="hidden" name="mod" value="minggu">
					<input type="hidden" name="sub" value="filter">
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

		if ($sub == 'filter' AND $str_tanggal1 != '' AND $str_tanggal2 != '') {
			#- cek maksimal hari
			$start_date 	= new DateTime($str_tanggal1);
			$end_date 		= new DateTime($str_tanggal2);
			$interval 		= $start_date->diff($end_date);
			$jumlah_hari 	= $interval->days;
			if ($jumlah_hari < 4 ) {
				echo 'Data yang ditampilkan minimal 5 hari.';
				exit();
			} elseif ($jumlah_hari > 13 ) {
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
			for ($i=0;$i <= $jumlah_hari; $i++) {
				$listTanggal[$mulainya] = "'". substr($mulainya, -2) ."'";
				$mulainya = date ('Y-m-d', strtotime("+1 day", strtotime($mulainya)));
			}
			$labelTanggal = implode(', ', $listTanggal);
			
			$mulainya = $mulai;
			for ($i=0;$i <= $jumlah_hari; $i++) {
				$listSangatPuas[$mulainya] = 0;
				$mulainya = date ('Y-m-d', strtotime("+1 day", strtotime($mulainya)));
			}
			$mulainya = $mulai;
			for ($i=0;$i <= $jumlah_hari; $i++) {
				$listPuas[$mulainya] = 0;
				$mulainya = date ('Y-m-d', strtotime("+1 day", strtotime($mulainya)));
			}
			$mulainya = $mulai;
			for ($i=0;$i <= $jumlah_hari; $i++) {
				$listTidakPuas[$mulainya] = 0;
				$mulainya = date ('Y-m-d', strtotime("+1 day", strtotime($mulainya)));
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
			<center>
			<div id="container" style="width: 100%; text-align: center" align="center">
				<canvas id="canvas"></canvas>
			</div>
			</center>
			
			<div class="table-responsive">
				<table align="center" cellpadding="0" cellspacing="0" class="table" border="0">
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
					foreach($listTanggal as $key => $value) {
						list($tahun, $bulan, $tanggal) = explode('-', $key, 3);
						$sangat_puas	= ( @$listSangatPuas[$key] == '') ? 0 : @$listSangatPuas[$key];
						$puas			= ( @$listPuas[$key] == '' ) ? 0 : @$listPuas[$key];
						$tidak_puas		= ( @$listTidakPuas[$key] == '' ) ? 0 : @$listTidakPuas[$key];
						$jumlah			= $sangat_puas + $puas + $tidak_puas;
								
						$count_sangat_puas	= $count_sangat_puas + $sangat_puas;
						$count_puas			= $count_puas + $puas;
						$count_tidak_puas	= $count_tidak_puas + $tidak_puas;
						$count_jumlah		= $count_jumlah + $jumlah;
								
						$row_color = ($i%2 == 0) ? '#f2f2f2' : '#ffffff';
					?>
					<tr bgcolor="<?php echo $row_color;?>">
						<td align="center" height="25"><?php echo $i++;?></td>
						<td align="center"><a href="index.php?com=ikm&mod=hari&t=<?php echo $tahun;?>&b=<?php echo $bulan;?>&h=<?php echo $tanggal;?>"><strong><?php echo tglIndo($tahun .'-'. $bulan .'-'. $tanggal);?></strong></a></td>
						<td align="center"><?php echo $sangat_puas;?></td>
						<td align="center"><?php echo $puas;?></td>
						<td align="center"><?php echo $tidak_puas;?></td>
						<td align="center"><?php echo $jumlah;?></td>
					</tr>
					<?php
					} #. foreach
					?>
					<tr bgcolor="#CCC">
						<td align="right" height="25" colspan="2"> <strong>Total</strong></td>
						<td align="center"> <strong><?php echo $count_sangat_puas;?></strong></td>
						<td align="center"> <strong><?php echo $count_puas;?></strong></td>
						<td align="center"> <strong><?php echo $count_tidak_puas;?></strong></td>
						<td align="center"> <strong><?php echo $count_jumlah;?></strong></td>
					</tr>
				</table>
			</div>
			
			<script>
				var config = {
					type: 'line',
					data: {
						labels: [<?php echo $labelTanggal;?>],
						datasets: [{
							label: 'Sangat Puas',
							backgroundColor: window.chartColors.blue,
							borderColor: window.chartColors.blue,
							data: [ <?php echo $labelSangatPuas;?> ],
							fill: false,
						}, {
							label: 'Puas',
							fill: false,
							backgroundColor: window.chartColors.yellow,
							borderColor: window.chartColors.yellow,
							data: [ <?php echo $labelPuas;?> ],
						}, {
							label: 'Tidak Puas',
							fill: false,
							backgroundColor: window.chartColors.red,
							borderColor: window.chartColors.red,
							data: [ <?php echo $labelTidakPuas;?> ],
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
		}
		?>
	<?php
	}
	elseif ($mod == 'bulan') {
		$str_tahun	= isset($_GET['t']) ? str_replace('.', '', $_GET['t']) : '';
		$tahun_ini	= ($str_tahun != '') ? $str_tahun : date('Y');
		$str_bulan	= isset($_GET['b']) ? str_replace('.', '', $_GET['b']) : '';		
		$bulan_ini	= ($str_bulan != '') ? $str_tahun .'-'. $str_bulan : date('Y-m');
		$jumlah_hari	= date('t', mktime(0, 0, 0, substr($bulan_ini, 5, 2), 1, $tahun_ini));
		#$jumlah_hari	= ($jumlah_hari > date('d')) ? date('d') : $jumlah_hari;
		
		#-- Tanggal
		for ($i=1;$i <= $jumlah_hari; $i++) {
			$listTanggal[$i] = "'". duaDigit($i) ."'";
		}
		$labelTanggal = implode(', ', $listTanggal);
		
		#-- Data Sangat Puas
		$sql = "SELECT LEFT(waktu, 10) AS tanggal, COUNT(nilai) AS data FROM polling WHERE satuan='$SatuanID' AND nilai='5' AND LEFT(waktu, 7) = '$bulan_ini' GROUP BY LEFT(waktu, 10) ORDER BY waktu ASC";
		$exe = _query($sql);
		$listSangatPuas = array();
		for ($i=1;$i <= $jumlah_hari; $i++) {
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
		for ($i=1;$i <= $jumlah_hari; $i++) {
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
		for ($i=1;$i <= $jumlah_hari; $i++) {
			$listTidakPuas[$i] = 0;
		}
		while ($row = _object($exe)) {
			$int_data	= (int) substr($row->tanggal, 8, 10);
			$listTidakPuas[$int_data] = $row->data;
		}
		$labelTidakPuas = implode(',', $listTidakPuas);
	?>	
		<center>
		<div id="container" style="width: 100%; text-align: center" align="center">
			<h4> Statistik Indeks Kepuasan Masyarakat Bulan <?php echo Bulan(substr($bulan_ini, 5, 2));?> <?php echo $tahun_ini;?> |  <a class="btn btn-info btn-sm" href="cetak.php?com=bulan&t=<?php echo $tahun_ini;?>&b=<?php echo substr($bulan_ini, 5, 2);?>">Cetak</a></h4>
			<canvas id="canvas"></canvas>
		</div>
		</center>
		
		<div class="table-responsive">
			<table align="center" cellpadding="0" cellspacing="0" class="table" border="0">
				<tr bgcolor="#CCC">
					<td align="center" width="50" height="25"> <strong>No.</strong></td>
					<td align="center" width="200"> <strong>Tanggal</strong></td>
					<td align="center" width="150"> <strong>Sangat Puas</strong></td>
					<td align="center" width="150"> <strong>Puas</strong></td>
					<td align="center" width="150"> <strong>Tidak Puas</strong></td>
					<td align="center" width="150"> <strong><a href="#" data-toggle="modal" data-target="#cmsModalGenerateBulan" style="color: #000; text-decoration: none;">Jumlah</a></strong></td>
				</tr>
				<?php
				$i = 1;
				$count_sangat_puas	= 0;
				$count_puas			= 0;
				$count_tidak_puas	= 0;
				$count_jumlah		= 0;
						
				#- looping tanggal
				foreach($listTanggal as $key => $value) {
					$tanggal		= $key;
					$sangat_puas	= ( @$listSangatPuas[$i] == '') ? 0 : @$listSangatPuas[$i];
					$puas			= ( @$listPuas[$tanggal] == '' ) ? 0 : @$listPuas[$tanggal];
					$tidak_puas		= ( @$listTidakPuas[$tanggal] == '' ) ? 0 : @$listTidakPuas[$tanggal];
					$jumlah			= $sangat_puas + $puas + $tidak_puas;
							
					$count_sangat_puas	= $count_sangat_puas + $sangat_puas;
					$count_puas			= $count_puas + $puas;
					$count_tidak_puas	= $count_tidak_puas + $tidak_puas;
					$count_jumlah		= $count_jumlah + $jumlah;
							
					$row_color = ($i%2 == 0) ? '#f2f2f2' : '#ffffff';
				?>
				<tr bgcolor="<?php echo $row_color;?>">
					<td align="center" height="25"><?php echo $i++;?></td>
					<td align="center"><a href="index.php?com=ikm&mod=hari&t=<?php echo $tahun_ini;?>&b=<?php echo substr($bulan_ini, 5, 2);?>&h=<?php echo duaDigit($tanggal);?>"><strong><?php echo tglIndo($bulan_ini .'-'. $tanggal);?></strong></a></td>
					<td align="center"><?php echo $sangat_puas;?></td>
					<td align="center"><?php echo $puas;?></td>
					<td align="center"><?php echo $tidak_puas;?></td>
					<td align="center"><?php echo $jumlah;?></td>
				</tr>
				<?php
				} #. foreach
				?>
				<tr bgcolor="#CCC">
					<td align="right" height="25" colspan="2"> <strong>Total</strong></td>
					<td align="center"> <strong><?php echo $count_sangat_puas;?></strong></td>
					<td align="center"> <strong><?php echo $count_puas;?></strong></td>
					<td align="center"> <strong><?php echo $count_tidak_puas;?></strong></td>
					<td align="center"> <strong><?php echo $count_jumlah;?></strong></td>
				</tr>
			</table>
		</div>
		
        
        <!-- Modal -->
		<div class="modal fade" id="cmsModalGenerateBulan" tabindex="-1" role="dialog" aria-labelledby="cmsModalGenerateBulan" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<form action="index.php?com=ikm&mod=simpan_data_bulan" method="post">
						<input type="hidden" name="t" value="<?php echo $tahun_ini;?>">
						<input type="hidden" name="b" value="<?php echo substr($bulan_ini, -2);?>">
						<div class="modal-header">
							<h6 class="modal-title" id="exampleModalCenterTitle">Akses Petugas</h6>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">						
							<div class="row" id="input_data">
								<div class="col-md-3" style="background-color:#ccc;">
									Min Senin <input type="number" class="form-control form-control-sm" id="min1" name="min1">
								</div>
								<div class="col-md-3" style="background-color:#ccc;">
									Max Senin <input type="number" class="form-control form-control-sm" id="max1" name="max1">
								</div>
								<div class="col-md-3" style="background-color:#CBBDF5;">
									Min Selasa <input type="number" class="form-control form-control-sm" id="min2" name="min2">
								</div>
								<div class="col-md-3" style="background-color:#CBBDF5;">
									Max Selasa <input type="number" class="form-control form-control-sm" id="max2" name="max2">
								</div>
								<div class="col-md-3" style="background-color:#CBBDF5;">
									Min Rabu <input type="number" class="form-control form-control-sm" id="min3" name="min3">
								</div>
								<div class="col-md-3" style="background-color:#CBBDF5;">
									Max Rabu <input type="number" class="form-control form-control-sm" id="max3" name="max3">
								</div>
								<div class="col-md-3" style="background-color:#ccc;">
									Min Kamis <input type="number" class="form-control form-control-sm" id="min4" name="min4">
								</div>
								<div class="col-md-3" style="background-color:#ccc;">
									Max Kamis <input type="number" class="form-control form-control-sm" id="max4" name="max4">
								</div>
								<div class="col-md-3" style="background-color:#ccc;">
									Min Jumat <input type="number" class="form-control form-control-sm" id="min5" name="min5">
								</div>
								<div class="col-md-3" style="background-color:#ccc;">
									Max Jumat <input type="number" class="form-control form-control-sm" id="max5" name="max5">
								</div>
								<div class="col-md-3" style="background-color:#CBBDF5;">
									Min Sabtu <input type="number" class="form-control form-control-sm" id="min6" name="min6">
								</div>
								<div class="col-md-3" style="background-color:#CBBDF5;">
									Max Sabtu <input type="number" class="form-control form-control-sm" id="max6" name="max6">
								</div>
							</div>
							<div class="form-group">
								<label for="recipient-name" class="col-form-label">Tanggal Libur</label>
								<input type="text" class="form-control form-control-sm" id="libur" name="libur">
							</div>
							<div class="form-group">
								<label for="recipient-name" class="col-form-label">Masukkan PIN :</label>
								<input type="password" class="form-control form-control-sm" id="pin" name="pin">
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Keluar</button>
							<button type="submit" class="btn btn-sm btn-primary" id="simpan">Simpan</button>
						</div>
					</form>
				</div>
			</div>
		</div>
        
		<script>
			var config = {
				type: 'line',
				data: {
					labels: [<?php echo $labelTanggal;?>],
					datasets: [{
						label: 'Sangat Puas',
						backgroundColor: window.chartColors.blue,
						borderColor: window.chartColors.blue,
						data: [ <?php echo $labelSangatPuas;?> ],
						fill: false,
					}, {
						label: 'Puas',
						fill: false,
						backgroundColor: window.chartColors.yellow,
						borderColor: window.chartColors.yellow,
						data: [ <?php echo $labelPuas;?> ],
					}, {
						label: 'Tidak Puas',
						fill: false,
						backgroundColor: window.chartColors.red,
						borderColor: window.chartColors.red,
						data: [ <?php echo $labelTidakPuas;?> ],
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
	}
	elseif ($mod == 'tahun') {
		$str_tahun	= isset($_GET['t']) ? str_replace('.', '', $_GET['t']) : '';
		$tahun_ini	= ($str_tahun != '') ? $str_tahun : date('Y');
		#$jumlah_hari	= date('t', mktime(0, 0, 0, date('m'), 1, date('Y')));
		$jumlah_hari	= 12;
		
		#-- Bulan
		for ($i=1;$i <= $jumlah_hari; $i++) {
			$listBulan[$i] = "'". Bulan($i) ."'";
		}
		$labelBulan = implode(', ', $listBulan);
		
		#-- Data Sangat Puas
		$sql = "SELECT MID(waktu, 6, 2) AS bulan, COUNT(nilai) AS data FROM polling WHERE satuan='$SatuanID' AND nilai='5' AND LEFT(waktu, 4) = '$tahun_ini' GROUP BY LEFT(waktu, 7) ORDER BY waktu ASC";
		$exe = _query($sql);
		$listSangatPuas = array();
		for ($i=1;$i <= $jumlah_hari; $i++) {
			$listSangatPuas[$i] = 0;
		}
		while ($row = _object($exe)) {
			$int_data	= (int) $row->bulan;
			$listSangatPuas[$int_data] = $row->data;
		}
		$labelSangatPuas = implode(', ', $listSangatPuas);
		
		#-- Data Puas
		$sql = "SELECT MID(waktu, 6, 2) AS bulan, COUNT(nilai) AS data FROM polling WHERE satuan='$SatuanID' AND nilai='4' AND LEFT(waktu, 4) = '$tahun_ini' GROUP BY LEFT(waktu, 7) ORDER BY waktu ASC";
		$exe = _query($sql);
		$listPuas = array();
		for ($i=1;$i <= $jumlah_hari; $i++) {
			$listPuas[$i] = 0;
		}
		while ($row = _object($exe)) {
			$int_data	= (int) $row->bulan;
			$listPuas[$int_data] = $row->data;
		}
		$labelPuas = implode(', ', $listPuas);
		
		#-- Data Tidak Puas
		$sql = "SELECT MID(waktu, 6, 2) AS bulan, COUNT(nilai) AS data FROM polling WHERE satuan='$SatuanID' AND nilai='2' AND LEFT(waktu, 4) = '$tahun_ini' GROUP BY LEFT(waktu, 7) ORDER BY waktu ASC";
		$exe = _query($sql);
		$listTidakPuas = array();
		for ($i=1;$i <= $jumlah_hari; $i++) {
			$listTidakPuas[$i] = 0;
		}
		while ($row = _object($exe)) {
			$int_data	= (int) $row->bulan;
			$listTidakPuas[$int_data] = $row->data;
		}
		$labelTidakPuas = implode(',', $listTidakPuas);
	?>	
		<center>
		<div id="container" style="width: 100%; text-align: center" align="center">
			<h4> Statistik Indeks Kepuasan Masyarakat Tahun <?php echo $tahun_ini;?> |  <a class="btn btn-info btn-sm" href="cetak.php?com=tahun&t=<?php echo $tahun_ini;?>">Cetak</a></h4>
			<canvas id="canvas"></canvas>
		</div>
		</center>
		
		<div class="table-responsive">
			<table align="center" cellpadding="0" cellspacing="0" class="table" border="0">
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
						
				#- looping bulan
				foreach($listBulan as $key => $value) {
					$bulan			= $key;
					$sangat_puas	= ( @$listSangatPuas[$bulan] == '') ? 0 : @$listSangatPuas[$bulan];
					$puas			= ( @$listPuas[$bulan] == '' ) ? 0 : @$listPuas[$bulan];
					$tidak_puas		= ( @$listTidakPuas[$bulan] == '' ) ? 0 : @$listTidakPuas[$bulan];
					$jumlah			= $sangat_puas + $puas + $tidak_puas;
						
					$count_sangat_puas	= $count_sangat_puas + $sangat_puas;
					$count_puas			= $count_puas + $puas;
					$count_tidak_puas	= $count_tidak_puas + $tidak_puas;
					$count_jumlah		= $count_jumlah + $jumlah;
							
					$row_color = ($i%2 == 0) ? '#f2f2f2' : '#ffffff';
				?>
				<tr bgcolor="<?php echo $row_color;?>">
					<td align="center" height="25"><?php echo $i++;?></td>
					<td align="center"><a href="index.php?com=ikm&mod=bulan&t=<?php echo $tahun_ini;?>&b=<?php echo duaDigit($bulan);?>"><strong><?php echo Bulan($bulan);?> <?php echo $tahun_ini;?></strong></a></td>
					<td align="center"><?php echo $sangat_puas;?></td>
					<td align="center"><?php echo $puas;?></td>
					<td align="center"><?php echo $tidak_puas;?></td>
					<td align="center"><?php echo $jumlah;?></td>
				</tr>
				<?php
				} #. foreach
				?>
				<tr bgcolor="#CCC">
					<td align="right" height="25" colspan="2"> <strong>Total</strong></td>
					<td align="center"> <strong><?php echo $count_sangat_puas;?></strong></td>
					<td align="center"> <strong><?php echo $count_puas;?></strong></td>
					<td align="center"> <strong><?php echo $count_tidak_puas;?></strong></td>
					<td align="center"> <strong><?php echo $count_jumlah;?></strong></td>
				</tr>
			</table>
		</div>
        
		
		<script>
			var config = {
				type: 'line',
				data: {
					labels: [<?php echo $labelBulan;?>],
					datasets: [{
						label: 'Sangat Puas',
						backgroundColor: window.chartColors.blue,
						borderColor: window.chartColors.blue,
						data: [ <?php echo $labelSangatPuas;?> ],
						fill: false,
					}, {
						label: 'Puas',
						fill: false,
						backgroundColor: window.chartColors.yellow,
						borderColor: window.chartColors.yellow,
						data: [ <?php echo $labelPuas;?> ],
					}, {
						label: 'Tidak Puas',
						fill: false,
						backgroundColor: window.chartColors.red,
						borderColor: window.chartColors.red,
						data: [ <?php echo $labelTidakPuas;?> ],
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