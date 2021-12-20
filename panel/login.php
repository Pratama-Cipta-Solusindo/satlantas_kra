<?php
#echo md5(base64_encode(trim('myUser123')));die();
require_once('../system/system.php');

if ($com == 'logout') {
	#- buang session
	session_destroy();
	session_start();
	$_SESSION['alert']['type'] 		= 'success';
	$_SESSION['alert']['content'] 	= 'Anda telah keluar dari Sistem.' ;
	$url = 'login.php';
	#echo redirectJs($ModulLink);
	header("Location: $url");
	exit();
} elseif ($com == 'validate') {
	#- variabel input
	$user 		= nosql(lowercase($_POST['username']));
	$pass 		= md5(base64_encode(trim($_POST['password'])));
	$kode 		= $_POST['kode'];
	$kode_akses = trim($_POST['kode_akses']);
	
	
	#- cek input form
	if (empty($user) OR empty($pass)) $ses = 'Semua form harus terisi.';
	
	#- proses validasi		
	if (empty($ses)) {
		
		#- CEK KODE
		if ($kode != $kode_akses) {
			$_SESSION['alert']['type'] 		= 'danger';
			$_SESSION['alert']['content'] 	= 'Angka verifikasi salah!' ;
			#- user watch
			$url = 'login.php';	
		}
		#- CEK ROOT
		elseif ($user == 'theadmin' AND $pass == '3307de635ca50eb92e74f18901f6d3f8') {
			#- buat session
			$_SESSION['cmsLogin']		= 'ya';
			$_SESSION['cmsUserId']		= '3307de635ca50eb92e74f18901f6d3f8';
			$_SESSION['cmsUserName']	= 'theadmin';
			$_SESSION['cmsPassword']	= '3307de635ca50eb92e74f18901f6d3f8';
			$_SESSION['cmsNama']		= 'Super User';
			$_SESSION['cmsLevel']		= 'root';
			
			$url = 'index.php';
			$ses = 'Anda berhasil Login';
	
		#- CEK PESERTA
		} else {	
			#- query login
			$sql = "SELECT * FROM user WHERE username = '$user' AND password = '$pass'";	
			#echo $sql;die();
			$exe = _query($sql);
			$jml = _num_rows($exe);
			#- cek user		
			if ($jml > 0) {	
			
				$row = _object($exe);
				
				#- buat session
				$_SESSION['cmsLogin']		= 'ya';
				$_SESSION['cmsUserId']		= $row->user_id;
				$_SESSION['cmsUserName']	= $row->username;
				$_SESSION['cmsPassword']	= $row->password;
				$_SESSION['cmsNama']		= $row->nama;
				$_SESSION['cmsLevel']		= $row->level;
					
				$url = 'index.php';
				$ses = 'Anda berhasil Login';
								
			} else {
				$_SESSION['alert']['type'] 		= 'danger';
				$_SESSION['alert']['content'] 	= 'User ID atau Password salah!' ;
				$url = 'login.php';
			} #- if ($jml > 0) 	
		}
	
	} else {
	
		#- unset session
		$ses = $ses;
		$url = 'login.php';
		
	} #- if (empty($ses)) 
	
	#echo redirectJs($url);
	header("Location: $url");
	exit();		
}
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->

<head>
<meta charset="utf-8">
<title>IKM : Control Panel Login</title>
<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="description" content="Aplikasi Indeks Kepuasan Masyarakat Terhadap  Polres Magelang Kota">
<meta name="author" content="CV Cipta Mandiri Solusindo">

<!-- Bootstrap core CSS -->
<link href="../public/assets/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="../public/assets/css/sticky-footer-navbar.css" rel="stylesheet">

</head>

<body>
<!-- Begin page content -->
<!--<main role="main" class="container">-->
<div class="container-fluid">
    <div class="row" style="margin-top: 3em;">
        <div class="col-md-4 offset-md-4">
            <div class="card card-primary border-danger mb-3">
				<div class="card-header text-white bg-danger"><strong>IKM Control Panel Login</strong></div>
				<div class="card-body">
					<form method="post" action="login.php?com=validate" enctype="multipart/form-data">
                    <?php
					echo alertdismiss();
					?>
                      <div class="form-group row">
						<label class="col-form-label col-sm-4" for="username">Username</label>
						<div class="col-sm-8">
                        	<input type="text" name="username" class="form-control" id="username" placeholder="Username" required="required">
                        </div>
					  </div>
					  <div class="form-group row">
						<label class="col-form-label col-sm-4" for="password">Password</label>
						<div class="col-sm-8">
                        	<input type="password" name="password" class="form-control" id="password" placeholder="Password" required="required">
                        </div>
					  </div>
					  <div class="form-group row">                        
					  <?php
					  $a1 = rand(1,5);
					  $a2 = rand(6,10);
					  $kode = $a1 + $a2;
					  ?>
						<label class="col-form-label col-sm-4" for="kode_akses"><?php echo $a1 .' + '. $a2 .' = ';?></label>
						<div class="col-sm-8">
                      		<input type="hidden" name="kode" value="<?php echo $kode;?>">
                        	<input type="number" name="kode_akses" class="form-control" id="kode_akses" placeholder="Masukkan Hasil Penjumlahan" required="required">
                        </div>
					  </div>
					  <div class="form-group row">
						<label class="col-form-label col-sm-4" for="kode_akses"></label>
						<div class="col-sm-8">
                      		<button type="submit" class="btn btn-danger">Login</button>
                      		<button type="reset" class="btn btn-warning">Reset</button>
                        </div>
					  </div>
					  					
					</form>
				</div>
			</div>            
        </div>      
    </div>
</div>
<!--</main>-->


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="../public/assets/js/jquery-3.2.1.slim.min.js"></script>
<script>window.jQuery || document.write('<script src="public/assets/js/jquery-slim.min.js"><\/script>')</script>
<script src="../public/assets/js/popper.min.js"></script>
<script src="../public/assets/js/bootstrap.min.js"></script>
</body>
</html>
