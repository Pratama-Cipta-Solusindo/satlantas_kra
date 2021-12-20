<?php
include 'system/system.php';

$data = $_POST['data'];
//var_dump($data);
$id = $_POST['id'];

// $n = strlen($id);
// $m = ($n == 2 ? 5 : ($n == 5 ? 8 : 13));
// // $wil=($n==2?'Kota/Kab':($n==5?'Kecamatan':'Desa/Kelurahan'));
?>
<?php
if ($data == "kabupaten") {
?>
	Kabupaten/Kota
	<select id="form_kab">
		<option value="">Pilih Kabupaten/Kota</option>
		<?php

		$sqlRef = "SELECT kode, nama_wilayah FROM wilayah WHERE kode_master=$id ORDER BY nama_wilayah ASC";
		$exeRef = _query($sqlRef);
		while ($rRef = _array($exeRef)) {
		?>
			<option value="<?php echo $rRef[0]; ?>"><?php echo $rRef[1]; ?></option>
		<?php
		}
		?>

	</select>

<?php
} else if ($data == "kecamatan") {
?>
	<select id="form_kec">
		<option value="">Pilih Kecamatan</option>
		<?php

		$sqlRef = "SELECT kode, nama_wilayah FROM wilayah WHERE kode_master=$id ORDER BY nama_wilayah ASC";
		$exeRef = _query($sqlRef);
		while ($rRef = _array($exeRef)) {
		?>
			<option value="<?php echo $rRef[0]; ?>"><?php echo $rRef[1]; ?></option>
		<?php
		}
		?>
	</select>

<?php
} else if ($data == "desa") {
?>

	<select id="form_kel">
		<option value="">Pilih Desa</option>
		<?php

		$sqlRef = "SELECT kode, nama_wilayah FROM wilayah WHERE kode_master=$id ORDER BY nama_wilayah ASC";
		$exeRef = _query($sqlRef);
		while ($rRef = _array($exeRef)) {
		?>
			<option value="<?php echo $rRef[0]; ?>"><?php echo $rRef[1]; ?></option>
		<?php
		}
		?>
	</select>

<?php

}
?>