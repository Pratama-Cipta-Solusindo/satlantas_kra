<?php 
/*---------------------------------------------------
	Start session
----------------------------------------------------*/
session_start();
error_reporting(0);

/*---------------------------------------------------
	Konfigurasi
----------------------------------------------------*/
if (file_exists('config.php')) 			require_once('config.php');
if (file_exists('system/data.php')) 	require_once('system/data.php');
if (file_exists('system/database.php')) require_once('system/database.php');
if (file_exists('system/getdata.php')) 	require_once('system/getdata.php');
if (file_exists('../config.php')) 			require_once('../config.php');
if (file_exists('../system/data.php')) 		require_once('../system/data.php');
if (file_exists('../system/database.php')) 	require_once('../system/database.php');
if (file_exists('../system/getdata.php')) 	require_once('../system/getdata.php');

/*---------------------------------------------------
	Konfigurasi system aplikasi
----------------------------------------------------*/
#- seting timezone
if (substr(phpversion(),0,3) >= 5.1) 
{
	date_default_timezone_set('Asia/Jakarta');
}


#- nama hari
if ( ! function_exists('Hari')) 
{
	function Hari($str) 
	{	
		if($str == 'Sun') $str = 'Minggu';
		elseif($str == 'Mon') $str = 'Senin';
		elseif($str == 'Tue') $str = 'Selasa';
		elseif($str == 'Wed') $str = 'Rabu';
		elseif($str == 'Thu') $str = 'Kamis';
		elseif($str == 'Fri') $str = 'Juma\'t';
		elseif($str == 'Sat') $str = 'Sabtu';
		return $str;
	}
}

#-- funsi nama bulan
if ( ! function_exists('Bulan')) 
{
	function Bulan($str) 
	{	
		if($str == '1' OR $str == '01') $str = 'Januari';
		elseif($str == '2' OR $str == '02') $str = 'Februari';
		elseif($str == '3' OR $str == '03') $str = 'Maret';
		elseif($str == '4' OR $str == '04') $str = 'April';
		elseif($str == '5' OR $str == '05') $str = 'Mei';
		elseif($str == '6' OR $str == '06') $str = 'Juni';
		elseif($str == '7' OR $str == '07') $str = 'Juli';
		elseif($str == '8' OR $str == '08') $str = 'Agustus';
		elseif($str == '9' OR $str == '09') $str = 'September';
		elseif($str == '10') $str = 'Oktober';
		elseif($str == '11') $str = 'November';
		elseif($str == '12') $str = 'Desember';
		return $str;
	}
}

#- JS Alert
if ( ! function_exists('alertJs')) 
{
	function alertJs($str) {
		$alert = '<script>';
		$alert .= 'alert("' . $str . '");';
		$alert .= '</script>';
		return $alert;	
	}
}

#- Cek
if ( ! function_exists('checkJs')) 
{
	function checkJs($str) {
		$alert = '<script>';
		$alert .= 'alert("' . $str . '");';
		$alert .= '</script>';
		echo $alert;	
	}
}

#- JS Redirect
if ( ! function_exists('redirectJs')) 
{
	function redirectJs($str) {
		$url = '<script>';
		$url .= 'window.location.href="' . $str . '";';
		$url .= '</script>';
		return $url;
	}
}

#- JS Back
if ( ! function_exists('backJs')) 
{
	function backJs() {
		$url = '<script>';
		$url .= 'window.history.go(-1)';
		$url .= '</script>';
		return $url;
	}
}


#-- Format Angka Dua Digit
if ( ! function_exists('duaDigit')) 
{
	function duaDigit($str) 
	{
		$str = intval($str);
		if($str < 10) $str = '0'.$str ;
		return $str;
	}
}

#-- Format Angka Dua Digit
if ( ! function_exists('tigaDigit')) 
{
	function tigaDigit($str) 
	{
		$str = intval($str);
		if($str < 10) $str = '00'.$str ;
		elseif($str < 100) $str = '0'.$str ;
		return $str;
	}
}

#-- Format Angka Dua Digit
if ( ! function_exists('empatDigit')) 
{
	function empatDigit($str) 
	{
		$str = intval($str);
		if($str < 10) $str = '000'.$str ;
		elseif($str < 100) $str = '00'.$str ;
		elseif($str < 1000) $str = '0'.$str ;
		return $str;
	}
}

#-- Format TanggalInonesia
if ( ! function_exists('tglIndo')) 
{
	function tglIndo($str) 
	{
		if ($str != '') :
			list($Thn, $Bln, $Tgl) = explode('-', $str, 3);
			$str = $Tgl . ' ' . Bulan($Bln) . ' ' . $Thn;
			return $str;
		else :
			return '';
		endif;	
	}
}

#-- Format Sql Datetime To Indo Datetime
if ( ! function_exists('SqlDatetimeToIndoDatetime')) 
{
	function SqlDatetimeToIndoDatetime($str)
	{
		if ($str != '') :
			list($tgle, $jam) = explode(' ', $str, 2);
			list($Thn, $Bln, $Tgl) = explode('-', $tgle, 3);
			$str = $Tgl . ' ' . Bulan($Bln) . ' ' . $Thn . ' '. substr($jam,0,5);
			return $str;
		else :
			return '';
		endif;	
	}
}
#-- Format Sql Datetime To Indo Date
if ( ! function_exists('SqlDatetimeToIndoDate')) 
{
	function SqlDatetimeToIndoDate($str)
	{
		if ($str != '') :
			list($tgle, $jam) = explode(' ', $str, 2);
			list($Thn, $Bln, $Tgl) = explode('-', $tgle, 3);
			$str = $Tgl . ' ' . Bulan($Bln) . ' ' . $Thn;
			return $str;
		else :
			return '';
		endif;	
	}
}

#- fungsi date diff
if ( ! function_exists('dateDiff')) 
{
	function dateDiff($date1, $date2){
		$date1 = (is_string($date1) ? strtotime($date1) : $date1);
		$date2 = (is_string($date2) ? strtotime($date2) : $date2);
	
		$diff_secs = abs($date1 - $date2);
		$base_year = min(date("Y", $date1), date("Y", $date2));
	
		$diff = mktime(0, 0, $diff_secs, 1, 1, $base_year);
		return array(
			"years" => date("Y", $diff) - $base_year,
			"months_total" => (date("Y", $diff) - $base_year) * 12 + date("n", $diff) - 1,
			"months" => date("n", $diff) - 1,
			"days_total" => floor($diff_secs / (3600 * 24)),
			"days" => date("j", $diff) - 1,
			"hours_total" => floor($diff_secs / 3600),
			"hours" => date("G", $diff),
			"minutes_total" => floor($diff_secs / 60),
			"minutes" => (int) date("i", $diff),
			"seconds_total" => $diff_secs,
			"seconds" => (int) date("s", $diff)
		);
	}
}


#- uppercase
if ( ! function_exists('uppercase')) 
{
	function uppercase($str) 
	{
		return strtoupper($str);
	}
}
#- lowercase
if ( ! function_exists('lowercase')) 
{
	function lowercase($str) 
	{
		return strtolower($str);
	}
}
#- titlecase
if ( ! function_exists('titlecase')) 
{
	function titlecase($str) 
	{
		return ucfirst(strtolower($str));
	}
}
#- capitalize
if ( ! function_exists('capitalize')) 
{
	function capitalize($str) 
	{
		return ucwords(strtolower($str));
	}
}

function cekAlpha($str) {  #-- a-z A-Z spasi
	if (preg_match("/^[a-zA-Z ]*$/",$str)) { 
		return 'valid';
	} else {
		return 'invalid';
	} 
}
function cekAlpha1($str) {  #-- a-z A-Z spasi titik koma
	if (preg_match("/^[a-zA-Z .,]*$/",$str)) { 
		return 'valid';
	} else {
		return 'invalid';
	} 
}

function cekAlphaNumeric($str) { #-- a-z A-Z 0-9 spasi
	if (preg_match("/^[a-zA-Z0-9 ]*$/",$str)) { 
		return 'valid';
	} else {
		return 'invalid';
	} 
}
function cekAlphaNumeric1($str) { #-- a-z A-Z 0-9 spasi titik koma
	if (preg_match("/^[a-zA-Z0-9 .,]*$/",$str)) { 
		return 'valid';
	} else {
		return 'invalid';
	} 
}

function cekIP($str) {
    if (filter_var($str, FILTER_VALIDATE_IP)) { 
		return 'valid';
	} else {
		return 'invalid';
	}
}

function cekEmail($str) {
	if (filter_var($str, FILTER_VALIDATE_EMAIL)) { 
		return 'valid';
	} else {
		return 'invalid';
	}
}

#- alert with dismiss
if ( ! function_exists('alertdismiss')) 
{
	function alertdismiss($type = '', $content = '', $attrib = '') 
	{
		$ses_type 	= isset($_SESSION['alert']['type']) 	? $_SESSION['alert']['type'] : '';
		$ses_content= isset($_SESSION['alert']['content']) 	? $_SESSION['alert']['content'] : '';
		$type 		= ($type != "") 	? $type 	: $ses_type;
		$content 	= ($content != "") 	? $content 	: $ses_content;
		
		#- type : warning, danger, success, info
		$str = '<div class="alert alert-dismissible alert-'. $type .'">';
		$str .= '<button type="button" class="close" data-dismiss="alert">&times;</button>';
		$str .= $content;
		$str .= '</div>';
		unset($_SESSION['alert']);
		if ($type == "" OR $content == "") $str = '';
		else return $str;
	}
}
#- alert
if ( ! function_exists('alert')) 
{
	function alert($type = '', $content = '', $attrib = '') 
	{
		$ses_type 	= isset($_SESSION['alert']['type']) 	? $_SESSION['alert']['type'] : '';
		$ses_content= isset($_SESSION['alert']['content']) 	? $_SESSION['alert']['content'] : '';
		$type 		= ($type != "") 	? $type 	: $ses_type;
		$content 	= ($content != "") 	? $content 	: $ses_content;
		
		#- type : warning, danger, success, info
		$str = '<div class="alert alert-'. $type .'">';
		$str .= $content;
		$str .= '</div>';
		unset($_SESSION['alert']);
		if ($type == "" OR $content == "") $str = '';
		else return $str;
	}
}

#- getValue
if ( ! function_exists('getValue')) 
{
	function getValue($table, $field, $where = '') {
		#- variabel variabel global
		global $con;
		
		$sql = "SELECT $field FROM $table WHERE $where LIMIT 0, 1";
		$exe = _query($sql);
		
		while ($r = _array($exe)) {
			return $r[0];
		}
		
	}
}

#- option
if ( ! function_exists('option')) 
{
	function option($str) {
		global $con;
		
		$sql = "SELECT option_value FROM options WHERE option_name='$str' LIMIT 0, 1";
		$exe = _query($sql);
		
		while ($r = _array($exe)) {
			return $r[0];
		}
		
	}
}

function uuid() {
	global $SatuanID;
	#- get ID of system
	$cms_id			= (isset($SatuanID) AND !empty($SatuanID)) ? $SatuanID : rand(100,999);
	#- get datetime
	$waktu_sekarang	= date('Y-m-d H:i:s');
	#- get URI
	$alamat_url		= (isset($_SERVER["HTTPS"]) ? "https://" : "http://").$_SERVER["HTTP_HOST"];
	$alamat_url		.= str_replace(basename($_SERVER["SCRIPT_NAME"]), "", $_SERVER["SCRIPT_NAME"]);
	#- make random number
	$angka_acak1		= rand(1000000, 9999999);
	$angka_acak2		= rand(100000, 999999);
	#- merge all of
	$unik_gabung	= $cms_id . $waktu_sekarang . $alamat_url . $angka_acak1 . $angka_acak2;
	#- make hashing with md5
	$hash 			= md5($unik_gabung);
	return sprintf('%08s-%04s-%04x-%04x-%12s',
		// 32 bits for "time_low"
		substr($hash, 0, 8),
		// 16 bits for "time_mid"
		substr($hash, 8, 4),
		// 16 bits for "time_hi_and_version",
		// four most significant bits holds version number 5
		(hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,
		// 16 bits, 8 bits for "clk_seq_hi_res",
		// 8 bits for "clk_seq_low",
		// two most significant bits holds zero and one for variant DCE1.1
		(hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,
		// 48 bits for "node"
		substr($hash, 20, 12)
	);
}

#- option
if ( ! function_exists('getSatpasId')) 
{
	function getSatpasId() {
		global $con;
		global $SatuanID;
		
		return $SatuanID;		
		/*$sql = "SELECT satpas_id FROM satpas WHERE aktif='1' AND deleted='0' LIMIT 0, 1";
		$exe = _query($sql);
		
		while ($r = _array($exe)) {
			return $r[0];
		}*/
		
	}
}
if ( ! function_exists('getKuisionerId')) 
{
	function getKuisionerId() {
		global $con;
		
		$satpas_id = getSatpasId();
		
		$sql = "SELECT kuisioner_id FROM kuisioner WHERE satpas_id='$satpas_id' AND aktif='1' AND deleted='0' LIMIT 0, 1";
		$exe = _query($sql);
		
		while ($r = _array($exe)) {
			return $r[0];
		}
		
	}
}
#echo md5(base64_encode('Magelang@Polres45'));
?>