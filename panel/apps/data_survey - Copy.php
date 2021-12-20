<?php
$str_tanggal1	= isset($_GET['t1']) ? str_replace('.', '', $_GET['t1']) : '';
$str_tanggal2	= isset($_GET['t2']) ? str_replace('.', '', $_GET['t2']) : '';
		
if ($str_tanggal1 != '' AND $str_tanggal2 != '') {
	$judul	= tglIndo($str_tanggal1) .' s/d. '. tglIndo($str_tanggal2);
} else {
	$judul = '';
}
			

$hitung = isset($_GET['hitung']) ? $_GET['hitung'] : '';
$kali	= isset($_GET['kali']) ? $_GET['kali'] : '20';
if ($hitung == 'ulang') {
	$sqlJawab = "SELECT j.jawab_id, j.opsi_id, j.created_by, o.nilai
				FROM kuisioner_jawab j
					INNER JOIN kuisioner_soal_opsi o ON j.opsi_id=o.opsi_id
				WHERE j.satpas_id='$SatuanID' 
					AND (LEFT(j.created_at, 10) BETWEEN '$str_tanggal1' AND '$str_tanggal2')";
	$exeJawab = _query($sqlJawab);
	while ($rJawab = _object($exeJawab)) {
		$jawab_id = $rJawab->jawab_id;
		$opsi_id = $rJawab->opsi_id;
		$created_by = $rJawab->created_by;
		$nilai = $rJawab->nilai;
		$this_nilai = $nilai * $kali;
		#
		$sqlUpdate = "UPDATE kuisioner_jawab SET nilai='". $this_nilai ."' WHERE jawab_id='". $jawab_id ."'";
		$exeUpdate = _query($sqlUpdate);
	}
	
	$sqlJawab = "SELECT COUNT(j.opsi_id) AS data, j.created_by, SUM(j.nilai) AS nilai
				FROM kuisioner_jawab j
					INNER JOIN kuisioner_soal_opsi o ON j.opsi_id=o.opsi_id
				WHERE j.satpas_id='$SatuanID' 
					AND (LEFT(j.created_at, 10) BETWEEN '$str_tanggal1' AND '$str_tanggal2')
				GROUP BY j.created_by";
				echo $sqlJawab .'<br>';
	$exeJawab = _query($sqlJawab);
	while ($rJawab = _object($exeJawab)) {
		$data = $rJawab->data;
		$created_by = $rJawab->created_by;
		$nilai = $rJawab->nilai;
		$this_nilai = $nilai / $data;
		#
		$sqlUpdate = "UPDATE responden SET nilai='". $this_nilai ."' WHERE id_responden='". $created_by ."'";
		$exeUpdate = _query($sqlUpdate);
		echo $sqlUpdate .'<br>';
	}
	
}
?>
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


			
<div class="card">
	<div class="card-header">
		<strong>DATA SURVEY</strong> 
	</div>
	<div class="card-body">
			<center>
			<div id="container" style="width: 90%; text-align: center" align="center">
				<h4> Data Survey | <a class="btn btn-info btn-sm" href="data_survey.php?mod=filter&t1=<?php echo $str_tanggal1;?>&t2=<?php echo $str_tanggal2;?>">Cetak</a></h4>
			</div>
			</center>
				
			<div class="container">
				<div class="row justify-content-center">
					<form action="index.php" method="get" class="form-inline" align="center">
						<input type="hidden" name="com" value="data_survey">
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
			?>	
			<div class="container">
				<div class="row">
					<div class="col-md-12">

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
  <?php
  $sqlJawab = "SELECT opsi_id, COUNT(opsi_id) AS data, jawab_id 
				FROM kuisioner_jawab 
				WHERE satpas_id='$SatuanID' 
					AND (LEFT(created_at, 10) BETWEEN '$str_tanggal1' AND '$str_tanggal2')
				GROUP BY opsi_id";
  $exeJawab = _query($sqlJawab);
  while ($rJawab = _object($exeJawab)) {
	  $opsi_id = $rJawab->opsi_id;
	  $nilai = $rJawab->data;
	  $jawab_id = $rJawab->jawab_id;
	  @$data[$opsi_id] = $nilai;
  }
  echo $sqlJawab;
  
  $sql = "SELECT soal.soal_id, soal.kategori_id, soal.soal, soal.aktif, kategori.kategori 
				FROM kuisioner_soal soal 
					INNER JOIN kuisioner_soal_kategori kategori ON soal.kategori_id=kategori.kategori_id
						AND kategori.deleted='0'
						AND kategori.kuisioner_id='". getKuisionerId() ."' 
				WHERE soal.deleted='0' 
				ORDER BY soal.aktif DESC, kategori.kategori ASC, soal.soal ASC";
  $exe = _query($sql);
  $jml = _num_rows($exe);
  $no = 1;
  while ($r = _object($exe)) {
	  $soal_id = $r->soal_id;
  ?>
    <tr>
      <td colspan="2"><?php echo $r->soal;?></td>
    </tr>
    <tr>
      <td width="50%" align="center">
      	<canvas id="canvas_<?php echo $no;?>"></canvas>
      </td>
      <td width="50%" align="left">
      	<table width="100%" border="0" cellspacing="0" cellpadding="2" class="tabel_data">
          <tbody>
            <tr>
              <td width="30%" align="center"><strong>Jml Responden</strong></td>
              <td align="center"><strong>Opsi</strong></td>
            </tr>
            <?php
			$sqlRef = "SELECT opsi_id, soal_id, opsi, nilai
							FROM kuisioner_soal_opsi 
							WHERE deleted='0' AND soal_id='". $soal_id ."'
							ORDER BY created_at ASC"; 
			$exeRef = _query($sqlRef);
			$nilai = 0;
			$theNilai = array();
			$theOpsi = array();
			while ($rRef = _object($exeRef)) {
				$opsi_id = $rRef->opsi_id;
				$opsi = $rRef->opsi;
				$nilai =  @$data[$opsi_id];
				$nilai = ($nilai > 0) ? $nilai : 0;
				$theNilai[] = $nilai;
				#$theOpsi[] = $nilai .' : ' .$opsi;
				$theOpsi[] = $opsi;
			?>
            <tr>
              <td align="center"><b><?php echo $nilai;?></b> &nbsp;</td>
              <td align="left"><?php echo $rRef->opsi;?></td>
            </tr>
            <?php
			}
			$numNilai = count($theNilai);
			$theNilai = implode(', ', $theNilai);
			$theOpsi = implode("', '", $theOpsi);
			?>
          </tbody>
        </table>
        <script>
			var ctx_<?php echo $no;?> = document.getElementById('canvas_<?php echo $no;?>').getContext('2d');
			var myChart_<?php echo $no;?> = new Chart(ctx_<?php echo $no;?>, {
				type: 'pie',
				data: {
					datasets: [{
						data: [<?php echo $theNilai;?>],
						backgroundColor: [
							<?php
							$theColor = array();
							for ($i=0; $i<$numNilai; $i++) {
								$thisColor = $listColor[$i];
								$theColor[] = 'window.chartColors.'. $thisColor;
							}
							$theColor = implode(', ', $theColor);
							?>
<?php echo $theColor;?>
						],
						label: ''
					}],
					labels: [ '<?php echo $theOpsi;?>' ]
				},
				options: {
					responsive: true,
					legend: {
						display: true,
						position: 'left'
					}
				}
			});	
		</script>
      </td>
    </tr>
  <?php
  	$no++;
  }
  ?>
  </tbody>
</table>
								
					</div> <!-- end of class col-md-12 -->
				</div> <!-- end of class row -->
			</div> <!-- end of class container -->
			<?php
			
			?>
	</div>
</div>