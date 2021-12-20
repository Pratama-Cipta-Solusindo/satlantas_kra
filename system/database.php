<?php
/*---------------------------------------------------
	Koneksi dan Pemilihan Database
----------------------------------------------------*/
/*
 * Database Main
 */
#- connection local
$con = @mysqli_connect($dbHost, $dbUser, $dbPass, $dbName, $dbPort);

#- cek koneksi ke main db
if (!$con) {	
	$_SESSION['pesan'] = 'Gagal tersambung ke main database, <b>"'. mysqli_connect_error($con) .'"</b>.';
	exit();	
}

/*---------------------------------------------------
	Fungsi MySQL
----------------------------------------------------*/
#- fungsi koneksi ke database
if ( ! function_exists('_connect')) 
{
	function _connect()
	{ 
		global $con;
		
		return $con; 
	} 
}

#- fungsi jalankan query 
if ( ! function_exists('_query')) 
{
	function _query($str)
	{ 
		global $con;
		
		return @mysqli_query($con, $str); 
	}
}

#- autocommit 
if ( ! function_exists('_autocommit')) 
{
	function _autocommit()
	{ 
		global $con;
		
		return @mysqli_autocommit($con, false); 
	}
}

#- commit 
if ( ! function_exists('_commit')) 
{
	function _commit()
	{ 
		global $con;
		
		return @mysqli_commit($con); 
	}
}

#- rollback 
if ( ! function_exists('_rollback')) 
{
	function _rollback()
	{ 
		global $con;
		
		return @mysqli_rollback($con); 
	}
}

#- fungsi real escape 
if ( ! function_exists('_real_escape')) 
{
	function _real_escape($str)
	{ 
		global $con;
		
		return @mysqli_real_escape_string($con, $str); 
	}
}

#- fungsi fetch object
if ( ! function_exists('_object')) 
{
	function _object($str)
	{ 
		return @mysqli_fetch_object($str);
	}
}

#- fungsi fetch array
if ( ! function_exists('_array')) 
{
	function _array($str)
	{ 
		return @mysqli_fetch_array($str); 
	}
}

#- fungsi num rows
if ( ! function_exists('_num_rows')) 
{
	function _num_rows($str)
	{ 
		return @mysqli_num_rows($str);
	}
}

#- fungsi last insert id
if ( ! function_exists('_insert_id')) 
{
	function _insert_id()
	{ 
		global $con;
		
		return @mysqli_insert_id($con);
	}
}

#- fungsi last insert id
if ( ! function_exists('_field_count')) 
{
	function _field_count($str)
	{ 
		return @mysqli_field_count($str);
	}
}

#- fungsi last insert id
if ( ! function_exists('_error')) 
{
	function _error()
	{  
		global $con;
		
		return mysqli_error($con);
	}
}

#- tolak sql injection
if ( ! function_exists('nosql')) 
{
	function nosql($data)
	{
		$filter_sql = _real_escape(stripslashes(strip_tags(trim($data))));
		return $filter_sql;
	}
}

#- fungsi last insert id
if ( ! function_exists('_close')) 
{
	function _close()
	{ 
		global $con;
		
		return @mysqli_close($con);
	}
}

?>