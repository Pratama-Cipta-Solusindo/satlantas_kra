<?php
if ($mod == 'save') {
	$mode 			= nosql($_POST['mode']);
	$id 			= nosql($_POST['id']);
	$soal_id		= uuid();
	$kategori_id	= nosql($_POST['kategori_id']);
	$soal 			= nosql($_POST['soal']);
	$aktif 			= '1'; #nosql($_POST['aktif']);
	$mode_ikon		= nosql($_POST['mode_ikon']);
	
	#- add data
	if ($mode == 'add') {
		$sql = "INSERT INTO kuisioner_soal SET soal_id='". $soal_id ."', kategori_id='". $kategori_id ."', soal='". $soal ."', aktif='". $aktif ."', mode_ikon='". $mode_ikon ."', created_by='". $_SESSION['cmsUserId'] ."', created_at='". date('Y-m-d H:i:s') ."'";
		$exe = _query($sql);
		if ($exe) {
			$_SESSION['alert']['type'] 		= 'success';
			$_SESSION['alert']['content'] 	= 'Data berhasil disimpan.';
			header('Location: index.php?com=soal');
			exit();			
		} else {
			$_SESSION['alert']['type'] 		= 'danger';
			$_SESSION['alert']['content'] 	= 'Data gagal disimpan : '. _error();
			header('Location: index.php?com=soal_form&mod=add');
			exit();	
		}
	#- edit data
	} elseif ($mode == 'edit') {
		$sql = "UPDATE kuisioner_soal SET kategori_id='". $kategori_id ."', soal='". $soal ."', aktif='". $aktif ."', mode_ikon='". $mode_ikon ."', updated_by='". $_SESSION['cmsUserId'] ."', updated_at='". date('Y-m-d H:i:s') ."' WHERE soal_id='". $id ."'";
		$exe = _query($sql);
		if ($exe) {
			$_SESSION['alert']['type'] 		= 'success';
			$_SESSION['alert']['content'] 	= 'Data berhasil diubah.';
			header('Location: index.php?com=soal');
			exit();			
		} else {
			$_SESSION['alert']['type'] 		= 'danger';
			$_SESSION['alert']['content'] 	= 'Data gagal diubah : '. _error();
			header('Location: index.php?com=soal_form&mod=edit&id='. $id);
			exit();	
		}
	} else {
		#header('Location: '. $ModulData);
		exit();	
	}
} elseif ($mod == 'edit') {
	$mode 			= 'edit';
	$title 			= 'Ubah Pertanyaan';
	$id 			= 0;
	$kategori_id 	= '';
	$kategori 		= '';
	$aktif 			= '';
	$mode_ikon		= '';
	
	$id = nosql($_GET['id']);
	$sql = "SELECT soal_id, kategori_id, soal, aktif, mode_ikon 
				FROM kuisioner_soal WHERE soal_id='". $id ."'";
	$exe = _query($sql);
	while ($r = _object($exe)){
		$id 			= $r->soal_id;
		$kategori_id 	= $r->kategori_id;
		$soal 			= $r->soal;
		$aktif 			= $r->aktif;
		$mode_ikon		= $r->mode_ikon;
	}
} else {
	$mode 			= 'add';
	$title 			= 'Tambah Pertanyaan';
	$id 			= 0;
	$kategori_id 	= '';
	$soal 			= '';
	$aktif 			= '';
	$mode_ikon		= '';
}
	
?>
<div class="card">
	<div class="card-header">
		<strong><?php echo uppercase($title);?></strong> 
        <a href="index.php?com=soal&mod=add" class="btn btn-sm btn-success">Daftar Data</a>
	</div>
	<div class="card-body">
    	<form method="post" action="<?php echo 'index.php?&com='. $com .'&mod=save&id='. $id;?>" enctype="multipart/form-data">
        	<input type="hidden" name="mode" value="<?php echo $mode;?>">
            <input type="hidden" name="id" value="<?php echo $id;?>">
			<?php
			echo alertdismiss();
			?>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="kategori_id">Kategori Pertanyaan</label>
				<div class="col-sm-6">
					<select id="kategori_id" class="form-control" name="kategori_id" required>
						<option value="">Pilih</option>
						<?php
						$sqlRef = "SELECT kategori_id, kategori FROM kuisioner_soal_kategori WHERE kuisioner_id='". getKuisionerId() ."' AND deleted='0' ORDER BY aktif DESC, kategori ASC";
						$exeRef = _query($sqlRef);
						while ($rRef = _object($exeRef)) { 
							$selected = ($rRef->kategori_id == $kategori_id) ? 'selected="selected"' : '';
							echo '<option value="'. $rRef->kategori_id .'" '. $selected .'>'. $rRef->kategori .'</option>';
						}
						?>
					</select>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="soal">Pertanyaan</label>
				<div class="col-sm-9">
					<textarea type="text" name="soal" class="form-control" id="soal" placeholder="Pertanyaan" required><?php echo $soal;?></textarea>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="aktif">Mode Ikon</label>
				<div class="col-sm-3">
					<select id="mode_ikon" class="form-control" name="mode_ikon" required>
						<option value="">Pilih</option>
						<?php
						foreach($listYesNo as $key => $value) {
							$selected = ($key == $mode_ikon) ? 'selected="selected"' : '';
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