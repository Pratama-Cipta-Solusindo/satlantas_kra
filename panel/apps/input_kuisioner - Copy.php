<?php
if ($mod == 'save') {
	$ip			= $_SERVER['REMOTE_ADDR'];
	$pin		= $_POST['pin'];
	$bulan		= $_POST['bulan'];
	list($b,$t)	= explode('-', $bulan, 2);
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
	
	$nilai1		= $_POST['nilai1'];
	$minpersen1	= $_POST['minpersen1'];
	$maxpersen1	= $_POST['maxpersen1'];
	$nilai2		= $_POST['nilai2'];
	
	$url		= "index.php?com=input_kuisioner";
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
		
		#- tidak hari libur
		if (!in_array($tanggal_ini, $hari_libur) AND $no_hari != 0) {	
			
			for ($r=1; $r<=$this_jumlah; $r++) {
				#- var
				shuffle($the_nilai);
				$nilai = $the_nilai[0];
				
				$jam	= duaDigit(rand(8,$max_jam)) .':'. duaDigit(rand(1,59)) .':'. duaDigit(rand(1,59));
				$waktu	= $this_hari .' '. $jam;
				
				#- responden
				$id			= uuid();
				$satpas_id	= getSatpasId();
				$nik		= '';
				$nama		= '';
				$jk			= rand(1,2);
				$agama		= rand(1,3);
				$usia		= rand(2,4);
				$pendidikan	= rand(2,5);
				$pekerjaan	= rand(1,8);
				$wilayah	= 0;
				$alamat		= '';
				$hp			= ''; #nosql($_POST['hp']);
				#$waktu 	= date('Y-m-d H:i:s');
				$random1	= rand(11111, 99999);
				$random2	= rand(1111, 9999);
				$signature	= $id; #md5($waktu . $nik);
		
				$sqlResponden = "INSERT INTO responden (id_responden, satpas_id, nik, nama, jk, agama, usia, pendidikan, pekerjaan, wilayah, alamat, hp, waktu, signature)  VALUES ('$id', '$satpas_id', '$nik', '$nama', '$jk', '$agama', '$usia', '$pendidikan', '$pekerjaan', '$wilayah', '$alamat', '$hp', '$waktu', '$signature')";
				$exeResponden = _query($sqlResponden);
				#echo $sqlResponden .'<br><br>';
				
				#- kuisioner 
				$sqlSoal = "SELECT soal.soal_id
									FROM kuisioner_soal soal 
										INNER JOIN kuisioner_soal_kategori kategori 
											ON soal.kategori_id=kategori.kategori_id 
												AND kategori.deleted='0'					
										INNER JOIN kuisioner 
											ON kategori.kuisioner_id=kuisioner.kuisioner_id 
												AND kuisioner.aktif='1' AND kuisioner.deleted='0'
												AND kuisioner.satpas_id='" . $satpas_id . "'
									WHERE soal.deleted='0' 
									ORDER BY soal.aktif DESC, kategori.kategori ASC, soal.soal ASC";
				#echo $sqlSoal .'<br><br>';
				
				$exeSoal = _query($sqlSoal);
				$jmlSoal = _num_rows($exeSoal);
				
				$persen = rand($minpersen1,$maxpersen1);
				$jumlah_nilai1 = round($persen / 100 * $jmlSoal);
				$jumlah_nilai2 = $jmlSoal - $jumlah_nilai1;
				$jmlNilai = 0;
				
				$sqlOpsi = "SELECT soal.soal_id, opsi.opsi_id, opsi.nilai
									FROM kuisioner_soal soal 
										INNER JOIN kuisioner_soal_kategori kategori 
											ON soal.kategori_id=kategori.kategori_id 
												AND kategori.deleted='0'					
										INNER JOIN kuisioner 
											ON kategori.kuisioner_id=kuisioner.kuisioner_id 
												AND kuisioner.aktif='1' AND kuisioner.deleted='0'
												AND kuisioner.satpas_id='" . $satpas_id . "'
										INNER JOIN kuisioner_soal_opsi opsi
											ON opsi.soal_id=soal.soal_id
												AND opsi.nilai='". $nilai1 ."'
												AND opsi.deleted='0'
									WHERE soal.deleted='0' 
									ORDER BY soal.aktif DESC, kategori.kategori ASC, soal.soal ASC
									LIMIT 0, ". $jumlah_nilai1 ."";
				#echo $sqlOpsi .'<br><br>';
				$exeOpsi = _query($sqlOpsi);
				while ($rSoal = _object($exeOpsi)) {
					$this_soal_id	= $rSoal->soal_id;
					$this_opsi_id	= $rSoal->opsi_id;
					$this_nilai		= $rSoal->nilai;
					$this_nilai 	= $this_nilai * $setNilaiKali;
					$jmlNilai		= $jmlNilai + $this_nilai;
					
					$sqlInsert = "INSERT INTO kuisioner_jawab (jawab_id, satpas_id, soal_id, opsi_id, nilai, created_by, created_at)  VALUES ('" . uuid() . "', '" . $satpas_id . "', '" . $this_soal_id . "', '" . $this_opsi_id . "', '" . $this_nilai . "', '" . $signature . "', '" . $waktu . "')";
					$exeInsert = _query($sqlInsert);
					#echo $sqlInsert .'<br>';
				}
				#-- nilai 2
				$sqlOpsi = "SELECT soal.soal_id, opsi.opsi_id, opsi.nilai
									FROM kuisioner_soal soal 
										INNER JOIN kuisioner_soal_kategori kategori 
											ON soal.kategori_id=kategori.kategori_id 
												AND kategori.deleted='0'					
										INNER JOIN kuisioner 
											ON kategori.kuisioner_id=kuisioner.kuisioner_id 
												AND kuisioner.aktif='1' AND kuisioner.deleted='0'
												AND kuisioner.satpas_id='" . $satpas_id . "'
										INNER JOIN kuisioner_soal_opsi opsi
											ON opsi.soal_id=soal.soal_id
												AND opsi.nilai='". $nilai2 ."'
												AND opsi.deleted='0'
									WHERE soal.deleted='0' 
									ORDER BY soal.aktif DESC, kategori.kategori ASC, soal.soal ASC
									LIMIT ". $jumlah_nilai1 .", ". $jumlah_nilai2 ."";
				#echo $sqlOpsi .'<br><br>';
				$exeOpsi = _query($sqlOpsi);
				while ($rSoal = _object($exeOpsi)) {
					$this_soal_id	= $rSoal->soal_id;
					$this_opsi_id	= $rSoal->opsi_id;
					$this_nilai		= $rSoal->nilai;
					$this_nilai 	= $this_nilai * $setNilaiKali;
					$jmlNilai		= $jmlNilai + $this_nilai;
					
					$sqlInsert = "INSERT INTO kuisioner_jawab (jawab_id, satpas_id, soal_id, opsi_id, nilai, created_by, created_at)  VALUES ('" . uuid() . "', '" . $satpas_id . "', '" . $this_soal_id . "', '" . $this_opsi_id . "', '" . $this_nilai . "', '" . $signature . "', '" . $waktu . "')";
					$exeInsert = _query($sqlInsert);
					#echo $sqlInsert .'<br>';
				}
				
				$this_nilai = $jmlNilai / $jmlSoal;
				$sqlUpdate = "UPDATE responden SET nilai='" . $this_nilai . "' WHERE id_responden='" . $signature . "'";
				$exeUpdate = _query($sqlUpdate);
				
				
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
		<strong>INPUT KUISIONER</strong> 
	</div>
	<div class="card-body">
    	<form method="post" action="<?php echo 'index.php?&com='. $com .'&mod=save&id='. $id;?>" enctype="multipart/form-data">
        	<input type="hidden" name="mode" value="<?php echo $mode;?>">
            <input type="hidden" name="id" value="<?php echo $id;?>">
			<?php
			echo alertdismiss();
			?>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="bulan">Bulan</label>
				<div class="col-sm-4">
					<input type="text" name="bulan" class="form-control" id="bulan" placeholder="MM-YYYY" value="" required="required">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="min1">Range Data</label>
				<div class="col-sm-2" style="background-color:#ccc;">
					Min Senin
					<input type="number" name="min1" class="form-control" id="min1" value="0">
				</div>
				<div class="col-sm-2" style="background-color:#ccc;">
					Max Senin
					<input type="number" name="max1" class="form-control" id="max1" value="0">
				</div>
				<div class="col-sm-2" style="background-color:#CBBDF5;">
					Min Selasa
					<input type="number" name="min2" class="form-control" id="min2" value="0">
				</div>
				<div class="col-sm-2" style="background-color:#CBBDF5;">
					Max Selasa
					<input type="number" name="max2" class="form-control" id="max2" value="0">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for=""></label>
				<div class="col-sm-2" style="background-color:#CBBDF5;">
					Min Rabu
					<input type="number" name="min3" class="form-control" id="min3" value="0">
				</div>
				<div class="col-sm-2" style="background-color:#CBBDF5;">
					Max Rabu
					<input type="number" name="max3" class="form-control" id="max3" value="0">
				</div>
				<div class="col-sm-2" style="background-color:#ccc;">
					Min Kamis
					<input type="number" name="min4" class="form-control" id="min4" value="0">
				</div>
				<div class="col-sm-2" style="background-color:#ccc;">
					Max Kamis
					<input type="number" name="max4" class="form-control" id="max4" value="0">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for=""></label>
				<div class="col-sm-2" style="background-color:#ccc;">
					Min Jumat
					<input type="number" name="min5" class="form-control" id="min5" value="0">
				</div>
				<div class="col-sm-2" style="background-color:#ccc;">
					Max Jumat
					<input type="number" name="max5" class="form-control" id="max5" value="0">
				</div>
				<div class="col-sm-2" style="background-color:#CBBDF5;">
					Min Sabtu
					<input type="number" name="min6" class="form-control" id="min6" value="0">
				</div>
				<div class="col-sm-2" style="background-color:#CBBDF5;">
					Max Sabtu
					<input type="number" name="max6" class="form-control" id="max6" value="0">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="libur">Tanggal Libur</label>
				<div class="col-sm-9">
					<input type="text" name="libur" class="form-control" id="libur" placeholder="Pisahkan dengan Koma" value="">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="nilai1">Nilai Pertama</label>
				<div class="col-sm-4" style="background-color:#ccc;">
					<input type="number" name="nilai1" class="form-control" id="nilai1" placeholder="Nilai Pertama" value="" required="required">
				</div>
				<div class="col-sm-5" style="background-color:#ccc;">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="minpersen1">Min % Nilai Pertama</label>
				<div class="col-sm-3" style="background-color:#ccc;">
					<input type="number" name="minpersen1" class="form-control" id="minpersen1" placeholder="1-100" value="" required="required">
				</div>
				<label class="col-form-label col-sm-3" for="maxpersen1" style="background-color:#ccc;">Max % Nilai Pertama</label>
				<div class="col-sm-3" style="background-color:#ccc;">
					<input type="number" name="maxpersen1" class="form-control" id="maxpersen1" placeholder="1-100" value="" required="required">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="nilai2">Nilai Kedua</label>
				<div class="col-sm-4">
					<input type="number" name="nilai2" class="form-control" id="nilai2" placeholder="Nilai Kedua" value="">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="pin">Masukkan PIN </label>
				<div class="col-sm-4">
					<input type="password" name="pin" class="form-control" id="pin" placeholder="Masukkan PIN" value="">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="kode_akses"></label>
				<div class="col-sm-9">
					<button type="submit" class="btn btn-sm btn-primary">Simpan</button>
					<button type="reset" class="btn btn-sm btn-warning">Reset</button>
				</div>
			</div>			  					
		</form>
	</div> 
</div>