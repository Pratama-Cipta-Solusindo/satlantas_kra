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
<title>Data Survey</title>
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
			$str_tanggal1	= isset($_GET['t1']) ? str_replace('.', '', $_GET['t1']) : '';
			$str_tanggal2	= isset($_GET['t2']) ? str_replace('.', '', $_GET['t2']) : '';
		
			if ($str_tanggal1 != '' AND $str_tanggal2 != '') {
				$judul	= tglIndo($str_tanggal1) .' s/d. '. tglIndo($str_tanggal2);
			} else {
				$judul = '';
			}
			?>
    <table align="center" cellpadding="0" cellspacing="0" class="tabel_isi" border="0">
			<tr>
				<td align="center">
					<strong><font class="f20">Statistik Survey</font><br><font class="f15"><?php echo $judul;?></font></strong>
				</td>
			</tr>
    </table>
	<table width="768" border="0" cellspacing="0" cellpadding="4" align="center">
  <tbody>
  <?php
  $sqlJawab = "SELECT opsi_id, COUNT(opsi_id) AS data 
				FROM kuisioner_jawab 
				WHERE satpas_id='$SatuanID' 
					AND (LEFT(created_at, 10) BETWEEN '$str_tanggal1' AND '$str_tanggal2')
				GROUP BY opsi_id";
  $exeJawab = _query($sqlJawab);
  while ($rJawab = _object($exeJawab)) {
	  $opsi_id = $rJawab->opsi_id;
	  $nilai = $rJawab->data;
	  @$data[$opsi_id] = $nilai;
  }
  
  
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
</div>
<!--</main>-->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="public/assets/js/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script>window.jQuery || document.write('<script src="public/assets/js/jquery-slim.min.js"><\/script>')</script>
</body>
</html>
