<?php
$this_bulan = '2021-02';
$this_bulan = isset($_GET['bulan']) ? $_GET['bulan'] : $this_bulan;
if ($this_bulan == '') {
	die();
}

$jumlah		= array();

$sql_jumlah	= "SELECT LEFT(waktu, 10) AS tanggal, COUNT(nilai) AS data FROM polling WHERE satuan='". $SatuanID ."' AND LEFT(waktu, 7) = '". $this_bulan ."' GROUP BY LEFT(waktu, 10) ORDER BY waktu ASC";
$exe_jumlah = _query($sql_jumlah);
while ($row_jumlah = _object($exe_jumlah)) {
	$tanggal	= $row_jumlah->tanggal;
	$data		= $row_jumlah->data;
	echo '<br><b>'. $tanggal .' : '. $data .'</b><br>';
	
	$jml_data		= $data;
	$jml_baru		= ceil((30/100) * $jml_data);
	$jml_naik_gol	= ceil((7/100) * $jml_data);
	$jml_hilang		= (0.02/100) * $jml_data;
	$jml_rusak		= (0.01/100) * $jml_data;
	$jml_hilang		= ($jml_hilang > 1) ? ceil($jml_hilang) : 0;
	$jml_rusak		= ($jml_rusak > 1) ? ceil($jml_rusak) : 0;
	$jml_perpanjang	= $jml_data - $jml_baru - $jml_naik_gol - $jml_hilang - $jml_rusak;
	
	$sql_select	= "SELECT id, signature FROM polling WHERE satuan='". $SatuanID ."' AND LEFT(waktu, 10) = '". $tanggal ."' ORDER BY waktu ASC";
	$exe_select = _query($sql_select);
	while ($row_select = _object($exe_select)) {
		
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
		
		$id			= $row_select->id;
		$signature	= $row_select->signature;
		
		$sql_update1 = "UPDATE polling SET layanan='". $layanan ."' WHERE id='". $id ."'";
		$exe_update1 = _query($sql_update1);
		$sql_update2 = "UPDATE responden SET layanan='". $layanan ."' WHERE signature='". $signature ."'";
		$exe_update2 = _query($sql_update2);
		if ($exe_update1 AND $exe_update2) {
			echo '1 : '. $sql_update1 .' / '. $sql_update2 .'<br>';
		} else {
			echo '0 : '. $sql_update1 .' / '. $sql_update2 .'<br>';
		}
		
	}
	
}

?>