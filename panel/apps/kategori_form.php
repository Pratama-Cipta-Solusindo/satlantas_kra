<?php
if ($mod == 'save') {
	$mode 			= nosql($_POST['mode']);
	$id 			= nosql($_POST['id']);
	$kategori_id	= uuid();
	$kuisioner_id	= getKuisionerId(); #nosql($_POST['satpas_id']);
	$kategori 		= nosql($_POST['kategori']);
	$aktif 			= nosql($_POST['aktif']);
	
	#- add data
	if ($mode == 'add') {
		$sql = "INSERT INTO kuisioner_soal_kategori SET kuisioner_id='". $kuisioner_id ."', kategori_id='". $kategori_id ."', kategori='". $kategori ."', aktif='". $aktif ."', created_by='". $_SESSION['cmsUserId'] ."', created_at='". date('Y-m-d H:i:s') ."'";
		$exe = _query($sql);
		if ($exe) {
			$_SESSION['alert']['type'] 		= 'success';
			$_SESSION['alert']['content'] 	= 'Data berhasil disimpan.';
			header('Location: index.php?com=kategori');
			exit();			
		} else {
			$_SESSION['alert']['type'] 		= 'danger';
			$_SESSION['alert']['content'] 	= 'Data gagal disimpan : '. _error();
			header('Location: index.php?com=kategori_form&mod=add');
			exit();	
		}
	#- edit data
	} elseif ($mode == 'edit') {
		$sql = "UPDATE kuisioner_soal_kategori SET kuisioner_id='". $kuisioner_id ."', kategori='". $kategori ."', aktif='". $aktif ."', updated_by='". $_SESSION['cmsUserId'] ."', updated_at='". date('Y-m-d H:i:s') ."' WHERE kategori_id='". $id ."'";
		$exe = _query($sql);
		if ($exe) {
			$_SESSION['alert']['type'] 		= 'success';
			$_SESSION['alert']['content'] 	= 'Data berhasil diubah.';
			header('Location: index.php?com=kategori');
			exit();			
		} else {
			$_SESSION['alert']['type'] 		= 'danger';
			$_SESSION['alert']['content'] 	= 'Data gagal diubah : '. _error();
			header('Location: index.php?com=kategori_form&mod=edit&id='. $id);
			exit();	
		}
	} else {
		#header('Location: '. $ModulData);
		exit();	
	}
} elseif ($mod == 'edit') {
	$mode 			= 'edit';
	$title 			= 'Ubah Kategori Pertanyaan';
	$id 			= 0;
	$kategori_id 	= '';
	$kategori 		= '';
	$aktif 			= '';
	
	$id = nosql($_GET['id']);
	$sql = "SELECT kategori_id, kategori, aktif FROM kuisioner_soal_kategori WHERE kategori_id='". $id ."'";
	$exe = _query($sql);
	while ($r = _object($exe)){
		$id 			= $r->kategori_id;
		$kategori_id 	= $r->kategori_id;
		$kategori 		= $r->kategori;
		$aktif 			= $r->aktif;
	}
} else {
	$mode 			= 'add';
	$title 			= 'Tambah Kategori Pertanyaan';
	$id 			= 0;
	$kategori_id 	= '';
	$kategori 		= '';
	$aktif 			= '';
}
	
?>
<div class="card">
	<div class="card-header">
		<strong><?php echo uppercase($title);?></strong> 
        <a href="index.php?com=kategori&mod=add" class="btn btn-sm btn-success">Daftar Data</a>
	</div>
	<div class="card-body">
    	<form method="post" action="<?php echo 'index.php?&com='. $com .'&mod=save&id='. $id;?>" enctype="multipart/form-data">
        	<input type="hidden" name="mode" value="<?php echo $mode;?>">
            <input type="hidden" name="id" value="<?php echo $id;?>">
			<?php
			echo alertdismiss();
			?>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="kategori">Kategori Pertanyaan</label>
				<div class="col-sm-9">
					<input type="text" name="kategori" class="form-control" id="kategori" placeholder="Kategori Pertanyaan" value="<?php echo $kategori;?>" required="required">
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