<?php
if ($mod == 'save') {
	$mode 			= nosql($_POST['mode']);
	$id 			= nosql($_POST['id']);
	$kuisioner_id	= uuid();
	$satpas_id		= getSatpasId(); #nosql($_POST['satpas_id']);
	$kuisioner 		= nosql($_POST['kuisioner']);
	$aktif 			= nosql($_POST['aktif']);
	$mode_emoticon 	= '0'; #nosql($_POST['mode_emoticon']);
	
	if ($aktif == '1') {
		$sql = "UPDATE kuisioner SET aktif='0', updated_by='". $_SESSION['cmsUserId'] ."', updated_at='". date('Y-m-d H:i:s') ."' WHERE satpas_id='". $satpas_id ."'";
		$exe = _query($sql);
	}
	
	#- add data
	if ($mode == 'add') {
		$sql = "INSERT INTO kuisioner SET satpas_id='". $satpas_id ."', kuisioner_id='". $kuisioner_id ."', kuisioner='". $kuisioner ."', aktif='". $aktif ."', mode_emoticon='". $mode_emoticon ."', created_by='". $_SESSION['cmsUserId'] ."', created_at='". date('Y-m-d H:i:s') ."'";
		$exe = _query($sql);
		if ($exe) {
			$_SESSION['alert']['type'] 		= 'success';
			$_SESSION['alert']['content'] 	= 'Data berhasil disimpan.';
			header('Location: index.php?com=kuisioner');
			exit();			
		} else {
			$_SESSION['alert']['type'] 		= 'danger';
			$_SESSION['alert']['content'] 	= 'Data gagal disimpan : '. _error();
			header('Location: index.php?com=kuisioner_form&mod=add');
			exit();	
		}
	#- edit data
	} elseif ($mode == 'edit') {
		$sql = "UPDATE kuisioner SET satpas_id='". $satpas_id ."', kuisioner='". $kuisioner ."', aktif='". $aktif ."', mode_emoticon='". $mode_emoticon ."', updated_by='". $_SESSION['cmsUserId'] ."', updated_at='". date('Y-m-d H:i:s') ."' WHERE kuisioner_id='". $id ."'";
		$exe = _query($sql);
		if ($exe) {
			$_SESSION['alert']['type'] 		= 'success';
			$_SESSION['alert']['content'] 	= 'Data berhasil diubah.';
			header('Location: index.php?com=kuisioner');
			exit();			
		} else {
			$_SESSION['alert']['type'] 		= 'danger';
			$_SESSION['alert']['content'] 	= 'Data gagal diubah : '. _error();
			header('Location: index.php?com=kuisioner_form&mod=edit&id='. $id);
			exit();	
		}
	} else {
		#header('Location: '. $ModulData);
		exit();	
	}
} elseif ($mod == 'edit') {
	$mode 			= 'edit';
	$title 			= 'Ubah Kuisioner';
	$id 			= 0;
	$kuisioner_id 	= '';
	$kuisioner 		= '';
	$aktif 			= '';
	$mode_emoticon	= '';
	
	$id = nosql($_GET['id']);
	$sql = "SELECT kuisioner_id, kuisioner, aktif, mode_emoticon FROM kuisioner WHERE kuisioner_id='". $id ."'";
	$exe = _query($sql);
	while ($r = _object($exe)){
		$id 			= $r->kuisioner_id;
		$kuisioner_id 	= $r->kuisioner_id;
		$kuisioner 		= $r->kuisioner;
		$aktif 			= $r->aktif;
		$mode_emoticon	= $r->mode_emoticon;
	}
} else {
	$mode 			= 'add';
	$title 			= 'Tambah Kuisioner';
	$id 			= 0;
	$kuisioner_id 	= '';
	$kuisioner 		= '';
	$aktif 			= '';
	$mode_emoticon	= '';
}
	
?>
<div class="card">
	<div class="card-header">
		<strong><?php echo uppercase($title);?></strong> 
        <a href="index.php?com=kuisioner&mod=add" class="btn btn-sm btn-success">Daftar Data</a>
	</div>
	<div class="card-body">
    	<form method="post" action="<?php echo 'index.php?&com='. $com .'&mod=save&id='. $id;?>" enctype="multipart/form-data">
        	<input type="hidden" name="mode" value="<?php echo $mode;?>">
            <input type="hidden" name="id" value="<?php echo $id;?>">
			<?php
			echo alertdismiss();
			?>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="kuisioner">Judul Kuisioner</label>
				<div class="col-sm-9">
					<input type="text" name="kuisioner" class="form-control" id="username" placeholder="Judul Kuisioner" value="<?php echo $kuisioner;?>" required="required">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="aktif">Aktif</label>
				<div class="col-sm-3">
					<select id="aktif" class="form-control" name="aktif" required>
						<option value="">Pilih</option>
						<?php
						foreach($listAktif as $key => $value) {
							$selected = ($key == $aktif) ? 'selected="selected"' : '';
							echo '<option value="'. $key .'" '. $selected .'>'. $value .'</option>';
						}
						?>
					</select>
				</div>
			</div>
			<!--<div class="form-group row">
				<label class="col-form-label col-sm-3" for="aktif">Mode Ikon</label>
				<div class="col-sm-3">
					<select id="mode_emoticon" class="form-control" name="mode_emoticon" required>
						<option value="">Pilih</option>
						<?php
						foreach($listYesNo as $key => $value) {
							$selected = ($key == $mode_emoticon) ? 'selected="selected"' : '';
							echo '<option value="'. $key .'" '. $selected .'>'. $value .'</option>';
						}
						?>
					</select>
				</div>
			</div>-->
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