<?php
if ($mod == 'save') {
	$ip			= $_SERVER['REMOTE_ADDR'];
	$pin		= $_POST['pin'];
	$tanggal	= $_POST['tanggal'];
	$this_hari	= $tanggal;
	
	$layanan_id	= $_POST['layanan_id'];
	
	$layanan_1	= $_POST['layanan_1'];
	$layanan_2	= $_POST['layanan_2'];
	$layanan_3	= $_POST['layanan_3'];
	$layanan_4	= $_POST['layanan_4'];
	$layanan_5	= $_POST['layanan_5'];
	$layanan_6	= $_POST['layanan_6'];
	
	$this_jumlah= $layanan_1 + $layanan_2 + $layanan_3 + $layanan_4 + $layanan_5 + $layanan_6;
	
	$random1	= rand(85, 90);
	$lima 		= round(($random1/100) * $this_jumlah);
	$empat		= $this_jumlah - $lima;
	
	$jumlah_data= $_POST['jumlah_data'];
	$hari_libur	= '0,0';
	$hari_libur	= explode(',', $hari_libur);
	
	$nilai1		= $_POST['nilai1'];
	$minpersen1	= $_POST['minpersen1'];
	$maxpersen1	= $_POST['maxpersen1'];
	$nilai2		= $_POST['nilai2'];
	
	$url		= "index.php?com=input_kuisioner_tanggal";
	if ($pin != $pin_petugas) {
		echo "<script>alert('PIN salah...!!!');</script>";
		echo "<script>window.history.back();</script>";
		exit();
	}
	#echo $jml_hari;die();
	#- looping hari
	#for ($i=1; $i<$jml_hari; $i++) {
		#- var
		$the_nilai		= array(4, 5);
		$no_hari		= date('w', strtotime($this_hari));
		if ($no_hari == 1) {
			$max_jam	= 15;
		} elseif ($no_hari == 2) {
			$max_jam	= 15;
		} elseif ($no_hari == 3) {
			$max_jam	= 15;
		} elseif ($no_hari == 4) {
			$max_jam	= 15;
		} elseif ($no_hari == 5) {
			$max_jam	= 12;
		} elseif ($no_hari == 6) {
			$max_jam	= 12;
		}
		#$this_jumlah = $jumlah_data;

		
		#echo $this_jumlah;die();
		#- tidak hari libur
		#if (!in_array($tanggal_ini, $hari_libur) AND $no_hari != 0) {	
			
			for ($r=1; $r<=$this_jumlah; $r++) {
				#- var
				shuffle($the_nilai);
				$nilai = $the_nilai[0];
				
				$jam	= duaDigit(rand(8,$max_jam)) .':'. duaDigit(rand(1,59)) .':'. duaDigit(rand(1,59));
				$waktu	= $this_hari .' '. $jam;
				
				#--- tipe layanan
				if ($layanan_1 != 0) {
					$layanan	= 1;
					$layanan_1--;
				} elseif ($layanan_2 != 0) {
					$layanan	= 2;
					$layanan_2--;
				} elseif ($layanan_3 != 0) {
					$layanan	= 3;
					$layanan_3--;
				} elseif ($layanan_4 != 0) { #- 5
					$layanan	= 4;
					$layanan_4--;
				} elseif ($layanan_5 != 0) { #- 6
					$layanan	= 5;
					$layanan_5--;
				} elseif ($layanan_6 != 0) { #- 6
					$layanan	= 6;
					$layanan_6--;
				} else {
					$layanan	= 0;
				}
				
				#--- ikm
				if ($lima != 0) {
					$nilai_ikm	= 5;
					$lima--;
				} elseif ($empat != 0) {
					$nilai_ikm	= 4;
					$empat--;
				} else {
					$nilai_ikm = 5;
				}
				
				#--- tipe layanan
				#echo $layanan_id;
				#if ($layanan_id == 99) {
				#	$layanan = $layanan;
				#} else {
				#	$layanan = $layanan_id;
				#}
				
				#- responden
				$id			= uuid();
				$satpas_id	= getSatpasId();
				$nik		= '';
				$nama		= '';
				$jk			= rand(1,2);
				$agama		= rand(1,3);
				$usia		= rand(2,4);
				$pendidikan	= rand(2,6);
				$pekerjaan	= rand(1,8);
				$wilayah	= 0;
				$alamat		= '';
				$hp			= ''; #nosql($_POST['hp']);
				#$waktu 	= date('Y-m-d H:i:s');
				$random1	= rand(11111, 99999);
				$random2	= rand(1111, 9999);
				$signature	= $id; #md5($waktu . $nik);
		
				$sqlResponden = "INSERT INTO responden (id_responden, satpas_id, nik, nama, jk, agama, usia, pendidikan, pekerjaan, layanan, wilayah, alamat, hp, waktu, signature)  VALUES ('$id', '$satpas_id', '$nik', '$nama', '$jk', '$agama', '$usia', '$pendidikan', '$pekerjaan', '$layanan', '$wilayah', '$alamat', '$hp', '$waktu', '$signature')";
				$exeResponden = _query($sqlResponden);
				#echo $sqlResponden .'<br><br>';
				
				#- kuisioner 
				$sqlSoal = "SELECT soal.soal_id, opsi.opsi_id, opsi.nilai
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
												AND opsi.deleted='0'
												AND opsi.nilai IN ('". $nilai1 ."', '". $nilai2 ."')
									WHERE soal.deleted='0' 
									ORDER BY RAND()";
				#echo $sqlSoal .'<br><br>';				
				$exeSoal = _query($sqlSoal);
				$jmlSoal = _num_rows($exeSoal);
				$jmlSoal = $jmlSoal / 2;
				$persen = rand($minpersen1,$maxpersen1);
				$jumlah_nilai1 = ceil($persen / 100 * $jmlSoal);
				$jumlah_nilai2 = $jmlSoal - $jumlah_nilai1;
				
				$this_data_array	= array();
				$this_soal_id_array = array();
				$this_jumlah_nilai_1 = 0;
				$this_jumlah_nilai_2 = 0;
				while ($rSoal = _object($exeSoal)) {
					$this_soal_id	= $rSoal->soal_id;
					$this_opsi_id	= $rSoal->opsi_id;
					$this_nilai		= $rSoal->nilai;
					if (!in_array($this_soal_id, $this_soal_id_array)) {
						if ($this_nilai == $nilai1 AND $this_jumlah_nilai_1 <= $jumlah_nilai1) {
							$this_data_array[]	= $this_soal_id .'#'. $this_opsi_id .'#'. $this_nilai;
							$this_jumlah_nilai_1++;
							$this_soal_id_array[] = $this_soal_id;
						} elseif ($this_nilai == $nilai2 AND $this_jumlah_nilai_2 <= $jumlah_nilai2) {
							$this_data_array[]	= $this_soal_id .'#'. $this_opsi_id .'#'. $this_nilai;
							$this_jumlah_nilai_2++;
							$this_soal_id_array[] = $this_soal_id;
						}
					}
				}
				$count_data_array = count($this_data_array);
				#echo $count_data_array;
				shuffle($this_data_array);
				#print_r($this_data_array); #die();
				#echo $jmlSoal;die();
				$jmlNilai = 0;
				#echo $count_data_array; #die();
				for($j=0; $j < $count_data_array; $j++) {
					$this_data = $this_data_array[$j];
					list($this_soal_id, $this_opsi_id, $this_nilai) = explode('#', $this_data, 3);
					$this_nilai		= $this_nilai * $setNilaiKali;
					$sqlInsert = "INSERT INTO kuisioner_jawab (jawab_id, satpas_id, soal_id, opsi_id, nilai, created_by, created_at)  VALUES ('" . uuid() . "', '" . $satpas_id . "', '" . $this_soal_id . "', '" . $this_opsi_id . "', '" . $this_nilai . "', '" . $signature . "', '" . $waktu . "')";
					$exeInsert = _query($sqlInsert);
					#echo $sqlInsert .'<br>';
					$jmlNilai		= $jmlNilai + $this_nilai;
					#echo '<b>'. $this_data .'</b><br>';
					#echo $j .'<br>';
				}
				#die();
				#echo '<br><br>';
				#$this_nilai = $jmlNilai;# / $jmlSoal;
				$this_nilai = $jmlNilai / $count_data_array;
				$sqlUpdate = "UPDATE responden SET nilai='" . $this_nilai . "' WHERE id_responden='" . $signature . "'";
				$exeUpdate = _query($sqlUpdate);
				#echo $sqlUpdate .'<br><br>';
				
				
				#--- UNTUK IKM
				$sqlPolling = "INSERT INTO polling SET id='$signature', satuan='$satpas_id', layanan='$layanan', waktu='$waktu', ip='$ip', nilai='$nilai_ikm', signature='$signature'";
				$exe = _query($sqlPolling);
				
				
			}
		#} #- end of !in_array
	#}
	#die();
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
				<label class="col-form-label col-sm-3" for="tanggal">Tanggal</label>
				<div class="col-sm-4">
					<input type="date" name="tanggal" class="form-control" id="tanggal" placeholder="Tanggal" required="required">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="layanan_id">Layanan</label>
				<div class="col-sm-4" style="">
					
						<?php
						foreach($listJenisLayanan as $key => $value) {
						?>
						<?php echo $value;?><input type="number" name="layanan_<?php echo $key;?>" class="form-control" id="layanan_<?php echo $key;?>" value="0">
						<?php
						}
						?>
				</div>
				<div class="col-sm-5" style="">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="nilai1">Nilai Pertama</label>
				<div class="col-sm-4" style="">
					<input type="number" name="nilai1" class="form-control" id="nilai1" placeholder="Nilai Pertama" value="" required="required">
				</div>
				<div class="col-sm-5" style="">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="minpersen1">Min % Nilai Pertama</label>
				<div class="col-sm-3" style="">
					<input type="number" name="minpersen1" class="form-control" id="minpersen1" placeholder="1-100" value="" required="required">
				</div>
				<label class="col-form-label col-sm-3" for="maxpersen1" style="">Max % Nilai Pertama</label>
				<div class="col-sm-3" style="">
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