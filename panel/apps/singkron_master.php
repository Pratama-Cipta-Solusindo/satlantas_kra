<?php
//API URL
$url = $sinc_url .'?com=master';

$jumlah	= isset($_GET['jumlah']) ? $_GET['jumlah'] : '';
$filter	= isset($_GET['filter']) ? $_GET['filter'] : '';
$data	= isset($_GET['data']) ? $_GET['data'] : '';


$headers = @get_headers($url);
if(strpos($headers[0],'404') === false) {
	$server_status = 'online';
	$button	= 'btn-success';
} else {
	$server_status = 'offline';
	$button = 'btn-danger';
}

if ($jumlah != '') {
	echo 111;
	exit();
}
?>

<div class="card">
	<div class="card-header">
		<strong>SINGKRONISASI DATA MASTER</strong> <span class="btn btn-sm <?php echo $button;?>">Server : <?php echo strtoupper($server_status);?></span>
	</div>
	<div class="card-body">
<?php
if ($server_status == 'online' AND $filter != '') {	
	//create a new cURL resource
	$ch = curl_init($url);
	
	//setup request to send json via POST
	$data_user = array(
		'sinc_user' => $sinc_user,
		'sinc_pass' => $sinc_pass
	);
	
	$data_kuisioner	= array();
	if ($data == 'master_kuisioner') {
		$sql_kuisioner	= "SELECT kuisioner_id, satpas_id, kuisioner, aktif, created_by, created_at
							FROM kuisioner ORDER BY kuisioner ASC";
		#echo $sql_kuisioner .'<br>';
		$exe_kuisioner	= _query($sql_kuisioner);
		while ($r_kuisioner = _object($exe_kuisioner)) {
			$data_kuisioner[] = $r_kuisioner;	
		}
	}
	
	$data_kuisioner_soal_kategori	= array();
	if ($data == 'master_kategori_pertanyaan') {
		$sql_kuisioner_soal_kategori	= "SELECT kategori_id, kuisioner_id, kategori, aktif, created_by, created_at
												FROM kuisioner_soal_kategori ORDER BY kategori ASC";
		#echo $sql_kuisioner_soal_kategori .'<br>';
		$exe_kuisioner_soal_kategori	= _query($sql_kuisioner_soal_kategori);
		while ($r_kuisioner_soal_kategori = _object($exe_kuisioner_soal_kategori)) {
			$data_kuisioner_soal_kategori[] = $r_kuisioner_soal_kategori;	
		}
	}
	
	$data_kuisioner_soal	= array();
	
	if ($data == 'master_pertanyaan') {
		$sql_kuisioner_soal		= "SELECT soal_id, kategori_id, soal, aktif, created_by, created_at
										FROM kuisioner_soal ORDER BY soal ASC";
		#echo $sql_kuisioner_soal .'<br>';
		$exe_kuisioner_soal		= _query($sql_kuisioner_soal);
		while ($r_kuisioner_soal = _object($exe_kuisioner_soal)) {
			$data_kuisioner_soal[] = $r_kuisioner_soal;	
		}
	}
	
	$data_kuisioner_soal_opsi	= array();
	if ($data == 'master_opsi_pertanyaan') {
		$sql_kuisioner_soal_opsi		= "SELECT opsi_id, soal_id, opsi, nilai, created_by, created_at
											FROM kuisioner_soal_opsi ORDER BY opsi ASC";
		#echo $sql_kuisioner_soal_opsi .'<br>';
		$exe_kuisioner_soal_opsi		= _query($sql_kuisioner_soal_opsi);
		while ($r_kuisioner_soal_opsi = _object($exe_kuisioner_soal_opsi)) {
			$data_kuisioner_soal_opsi[] = $r_kuisioner_soal_opsi;	
		}
	}
	
	$payload = json_encode(array("user" => $data_user, 
									"kuisioner" => $data_kuisioner, 
									"kategori" => $data_kuisioner_soal_kategori, 
									"soal" => $data_kuisioner_soal, 
									"opsi" => $data_kuisioner_soal_opsi
							), JSON_PRETTY_PRINT);
	
	//attach encoded JSON string to the POST fields
	curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	
	//set the content type to application/json
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	
	//return response instead of outputting
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	//execute the POST request
	$result = curl_exec($ch);
	#print_r($payload);
	//close cURL resource
	curl_close($ch);
	
	
	//Output response
	echo "<pre>$result</pre>";
}
?>
    	<form method="get" action="index.php" enctype="multipart/form-data">
			<input type="hidden" name="com" value="<?php echo $com;?>">
            <input type="hidden" name="filter" value="true">
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="data">Pilih Data</label>
				<div class="col-sm-9">
					<select id="data" class="form-control" name="data" required>
						<option value="master_kuisioner">Master Kuisioner</option>
						<option value="master_kategori_pertanyaan">Master Kategori Pertanyaan</option>
						<option value="master_pertanyaan">Master Pertanyaan</option>
						<option value="master_opsi_pertanyaan">Master Opsi Pertanyaan</option>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-9">
					<button type="button" class="btn btn-sm btn-primary" id="sinkron_master_submit">Singkronisasi</button>
				</div>
			</div>	
			<div class="progress" id="progress">
			  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%">0%</div>
			</div>			
		</form>
	</div> 
</div>