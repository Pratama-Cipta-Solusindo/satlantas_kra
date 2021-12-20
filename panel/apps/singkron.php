<?php
//API URL
$url = $sinc_url .'?com=transaksi';

$tanggal = isset($_GET['tgl']) ? $_GET['tgl'] : ''; #date('Y-m-d');
$data	 = isset($_GET['data']) ? $_GET['data'] : ''; #date('Y-m-d');


$headers = @get_headers($url);
if(strpos($headers[0],'404') === false) {
	$server_status = 'online';
	$button	= 'btn-success';
} else {
	$server_status = 'offline';
	$button = 'btn-danger';
}

?>

<div class="card">
	<div class="card-header">
		<strong>SINGKRONISASI DATA TRANSAKSI</strong> <span class="btn btn-sm <?php echo $button;?>">Server : <?php echo strtoupper($server_status);?></span>
	</div>
	<div class="card-body">
<?php
if ($server_status == 'online' AND $tanggal != '') {	
	//create a new cURL resource
	$ch = curl_init($url);
	
	//setup request to send json via POST
	$data_user = array(
		'sinc_user' => $sinc_user,
		'sinc_pass' => $sinc_pass
	);
	
	$data_responden	= array();
	if ($data == 'responden') {
		$sql_responden	= "SELECT * FROM responden WHERE LEFT(waktu, 10) = '". $tanggal ."' ORDER BY waktu ASC";
		#echo $sql_responden .'<br>';
		$exe_responden	= _query($sql_responden);
		while ($r_responden = _object($exe_responden)) {
			$data_responden[] = $r_responden;	
		}
	}
	
	$data_polling	= array();
	if ($data == 'polling') {
		$sql_polling	= "SELECT * FROM polling WHERE LEFT(waktu, 10) = '". $tanggal ."' ORDER BY waktu ASC";
		#echo $sql_polling .'<br>';
		$exe_polling	= _query($sql_polling);
		while ($r_polling = _object($exe_polling)) {
			$data_polling[] = $r_polling;	
		}
	}
	
	$data_survey	= array();
	if ($data == 'survey') {
		$sql_survey		= "SELECT jawab_id, satpas_id, soal_id, opsi_id, nilai, created_by, created_at
							FROM kuisioner_jawab WHERE LEFT(created_at, 10) = '". $tanggal ."' 
							ORDER BY created_at ASC";
		#echo $sql_survey .'<br>';
		$exe_survey		= _query($sql_survey);
		while ($r_survey = _object($exe_survey)) {
			$data_survey[] = $r_survey;	
		}
	}
	
	$payload = json_encode(array("user" => $data_user, 
									"responden" => $data_responden, 
									"polling" => $data_polling, 
									"survey" => $data_survey
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
						<option value="responden">Data Responden</option>
						<option value="polling">Data Polling</option>
						<option value="survey">Data Survey</option>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="tgl">Pilih Tanggal</label>
				<div class="col-sm-9">
					<input type="date" name="tgl" class="form-control" id="tgl" placeholder="Pilih Tanggal" value="<?php echo $tanggal;?>" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="kode_akses"></label>
				<div class="col-sm-9">
					<button type="submit" class="btn btn-sm btn-primary">Singkronisasi</button>
					<button type="reset" class="btn btn-sm btn-warning">Reset</button>
				</div>
			</div>			  					
		</form>
	</div> 
</div>