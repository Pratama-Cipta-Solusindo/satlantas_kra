<?php
if ($mod == 'save') {
	$mode 			= nosql($_POST['mode']);
	$id 			= nosql($_POST['id']);
	$opsi_id		= uuid();
	$soal_id		= nosql($_POST['soal_id']);
	$opsi			= nosql($_POST['opsi']);
	$nilai 			= nosql($_POST['nilai']);
	$ikon 			= nosql($_POST['ikon']);
	$mode_ikon		= '0'; #nosql($_POST['mode_ikon']);
	
	#- add data
	if ($mode == 'add') {
		$sql = "INSERT INTO kuisioner_soal_opsi SET opsi_id='". $opsi_id ."', soal_id='". $soal_id ."', opsi='". $opsi ."', nilai='". $nilai ."', ikon='". $ikon ."', mode_ikon='". $mode_ikon ."', created_by='". $_SESSION['cmsUserId'] ."', created_at='". date('Y-m-d H:i:s') ."'";
		$exe = _query($sql);
		if ($exe) {
			$_SESSION['alert']['type'] 		= 'success';
			$_SESSION['alert']['content'] 	= 'Data berhasil disimpan.';
			header('Location: index.php?com=soal');
			exit();			
		} else {
			$_SESSION['alert']['type'] 		= 'danger';
			$_SESSION['alert']['content'] 	= 'Data gagal disimpan : '. _error();
			header('Location: index.php?com=soal_form&mod=add&sub='. $soal_id .'');
			exit();	
		}
	#- edit data
	} elseif ($mode == 'edit') {
		$sql = "UPDATE kuisioner_soal_opsi SET opsi='". $opsi ."', nilai='". $nilai ."', ikon='". $ikon ."', mode_ikon='". $mode_ikon ."', updated_by='". $_SESSION['cmsUserId'] ."', updated_at='". date('Y-m-d H:i:s') ."' WHERE opsi_id='". $id ."'";
		$exe = _query($sql);
		if ($exe) {
			$_SESSION['alert']['type'] 		= 'success';
			$_SESSION['alert']['content'] 	= 'Data berhasil diubah.';
			header('Location: index.php?com=soal');
			exit();			
		} else {
			$_SESSION['alert']['type'] 		= 'danger';
			$_SESSION['alert']['content'] 	= 'Data gagal diubah : '. _error();
			header('Location: index.php?com=opsi_form&mod=edit&sub='. $soal_id .'&id='. $id);
			exit();	
		}
	} else {
		#header('Location: '. $ModulData);
		exit();	
	}
} elseif ($mod == 'edit') {
	$mode 			= 'edit';
	$title 			= 'Ubah Opsi Pertanyaan';
	$id 			= 0;
	$kategori_id 	= '';
	$kategori 		= '';
	$aktif 			= '';
	
	$soal_id = nosql($_GET['sub']);
	$sql = "SELECT soal.*, kategori.kategori 
					FROM kuisioner_soal soal 
					INNER JOIN kuisioner_soal_kategori kategori ON soal.kategori_id=kategori.kategori_id
						AND kategori.deleted='0' 
					WHERE soal.deleted='0' AND soal.soal_id='". $soal_id ."'";
	$exe = _query($sql);
	while ($r = _object($exe)){
		$id 			= $r->soal_id;
		$kategori_id 	= $r->kategori_id;
		$kategori 		= $r->kategori;
		$soal 			= $r->soal;
		$aktif 			= $r->aktif;
	}
	
	$opsi_id 	= '';
	$opsi 		= '';
	$nilai		= '';
	$ikon 		= '';
	$mode_ikon	= '';
	
	$id = nosql($_GET['id']);
	$sql = "SELECT opsi_id, soal_id, opsi, nilai, ikon, mode_ikon
					FROM kuisioner_soal_opsi WHERE deleted='0' AND opsi_id='". $id ."'";
	$exe = _query($sql);
	while ($r = _object($exe)){
		$id 		= $r->opsi_id;
		$opsi_id 	= $r->opsi_id;
		$soal_id 	= $r->soal_id;
		$opsi 		= $r->opsi;
		$nilai 		= $r->nilai;
		$ikon 		= $r->ikon;
		$mode_ikon	= $r->mode_ikon;
	}
	
} else {
	$mode 			= 'add';
	$title 			= 'Tambah Opsi Pertanyaan';
	$id 			= 0;
	$kategori_id 	= '';
	$soal 			= '';
	$aktif 			= '';
	
	$soal_id = nosql($_GET['sub']);
	$sql = "SELECT soal.*, kategori.kategori 
					FROM kuisioner_soal soal 
					INNER JOIN kuisioner_soal_kategori kategori ON soal.kategori_id=kategori.kategori_id
						AND kategori.deleted='0' 
					WHERE soal.deleted='0' AND soal.soal_id='". $soal_id ."'";
	$exe = _query($sql);
	while ($r = _object($exe)){
		$id 			= $r->soal_id;
		$kategori_id 	= $r->kategori_id;
		$kategori 		= $r->kategori;
		$soal 			= $r->soal;
		$aktif 			= $r->aktif;
	}
	
	$opsi_id 	= '';
	$opsi 		= '';
	$nilai		= '';
	$ikon 		= '';
	$mode_ikon	= '';
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
            <input type="hidden" name="soal_id" value="<?php echo $soal_id;?>">
            <input type="hidden" name="id" value="<?php echo $id;?>">
			<?php
			echo alertdismiss();
			?>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="kategori_id">Kategori Pertanyaan</label>
				<div class="col-sm-9">
					<input type="text" name="kategori_id" class="form-control" id="kategori_id" placeholder="Kategori Pertanyaan" value="<?php echo $kategori;?>" readonly>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="soal">Pertanyaan</label>
				<div class="col-sm-9">
					<textarea type="text" name="soal" class="form-control" id="soal" readonly><?php echo $soal;?></textarea>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="opsi">Opsi</label>
				<div class="col-sm-9">
					<input type="text" name="opsi" class="form-control" id="opsi" placeholder="Opsi" value="<?php echo $opsi;?>" required="required">
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="ikon">Ikon</label>
				<div class="col-sm-9">
					<?php
					foreach($listEmotIcon as $value) {
						$selected = ($value == $ikon) ? 'checked' : '';
						echo '<label><input type="radio" name="ikon" value="'. $value .'"'. $selected .'> <img src="../public/icons/'. $value .'" width="32"></label>';
					}
					?>
				</div>
			</div>
			<div class="form-group row">
				<label class="col-form-label col-sm-3" for="nilai">Nilai</label>
				<div class="col-sm-9">
					<input type="number" name="nilai" class="form-control" id="nilai" placeholder="Nilai" value="<?php echo $nilai;?>" required="required">
				</div>
			</div>
			<!--<div class="form-group row">
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