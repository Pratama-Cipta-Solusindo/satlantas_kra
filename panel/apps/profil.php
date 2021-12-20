<?php
if ($mod == 'save') {
	$password0 	= md5(base64_encode(trim($_POST['password0'])));
	$password1 	= md5(base64_encode(trim($_POST['password1'])));
	$password2 	= md5(base64_encode(trim($_POST['password2'])));
	if (trim($password0) != trim($_SESSION['cmsPassword'])) {
		$_SESSION['alert']['type'] 		= 'danger';
		$_SESSION['alert']['content'] 	= 'Password Lama tidak sesuai.';
		header('Location: index.php?com=profil');
		exit();		
	} elseif ($password1 != $password2) {
		$_SESSION['alert']['type'] 		= 'danger';
		$_SESSION['alert']['content'] 	= 'Password Baru dan Password Baru (Ulangi) tidak sama.';
		header('Location: index.php?com=profil');
		exit();		
	} else {
		$sql = "UPDATE user SET password='". $password1 ."', updated_by='". $_SESSION['cmsUserId'] ."', updated_at='". date('Y-m-d H:i:s') ."' WHERE user_id='". $_SESSION['cmsUserId'] ."'";
		$exe = _query($sql);
		if ($exe) {
			$_SESSION['cmsPassword']		= $password1;
			$_SESSION['alert']['type'] 		= 'success';
			$_SESSION['alert']['content'] 	= 'Data berhasil disimpan.';
			header('Location: index.php?com=profil');
			exit();			
		} else {
			$_SESSION['alert']['type'] 		= 'danger';
			$_SESSION['alert']['content'] 	= 'Data gagal disimpan : '. _error();
			header('Location: index.php?com=profil');
			exit();	
		}
	}
} 
	
?>
<div class="card">
	<div class="card-header">
		<strong>PROFIL</strong> 
	</div>
	<div class="card-body">
    	<form method="post" action="<?php echo 'index.php?&com='. $com .'&mod=save';?>" enctype="multipart/form-data">
			<?php
			echo alertdismiss();
			?>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="username">User Name</label>
				<div class="col-sm-9">
					<input type="text" name="username" class="form-control" id="username" placeholder="User Name" value="<?php echo $_SESSION['cmsUserName'];?>" readonly>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="nama">Nama</label>
				<div class="col-sm-9">
					<input type="text" name="nama" class="form-control" id="nama" placeholder="Nama" value="<?php echo $_SESSION['cmsNama'];?>" readonly>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="password0">Password Lama</label>
				<div class="col-sm-9">
					<input type="password" name="password0" class="form-control" id="password0" placeholder="Password Lama" value="" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="password1">Password Baru</label>
				<div class="col-sm-9">
					<input type="password" name="password1" class="form-control" id="password1" placeholder="Password Baru" value="" required>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="password2">Password Baru (Ulangi)</label>
				<div class="col-sm-9">
					<input type="password" name="password2" class="form-control" id="password2" placeholder="Password Baru (Ulangi)" value="" required>
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