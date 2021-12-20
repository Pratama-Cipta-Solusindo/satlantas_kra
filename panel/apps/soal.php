<?php
if ($mod == 'delete') {
	$id = nosql($_GET['id']);
	$sql = "UPDATE kuisioner_soal SET deleted_by='". $_SESSION['cmsUserId'] ."', deleted_at='". date('Y-m-d H:i:s') ."', deleted='1' WHERE soal_id='". $id ."'";
	$exe = _query($sql);
	if ($exe) {
		$_SESSION['alert']['type'] 		= 'success';
		$_SESSION['alert']['content'] 	= 'Data berhasil dihapus.';
	} else {
		$_SESSION['alert']['type'] 		= 'danger';
		$_SESSION['alert']['content'] 	= 'Data gagal dihapus : '. _error();
	}
	header('Location: index.php?com=soal');
	exit();
} elseif ($mod == 'delete_opsi') {
	$id = nosql($_GET['id']);
	$sql = "UPDATE kuisioner_soal_opsi SET deleted_by='". $_SESSION['cmsUserId'] ."', deleted_at='". date('Y-m-d H:i:s') ."', deleted='1' WHERE opsi_id='". $id ."'";
	$exe = _query($sql);
	if ($exe) {
		$_SESSION['alert']['type'] 		= 'success';
		$_SESSION['alert']['content'] 	= 'Data berhasil dihapus.';
	} else {
		$_SESSION['alert']['type'] 		= 'danger';
		$_SESSION['alert']['content'] 	= 'Data gagal dihapus : '. _error();
	}
	header('Location: index.php?com=soal');
	exit();
}	
?>
<div class="card">
	<div class="card-header">
		<strong>DAFTAR PERTANYAAN</strong> 
        <a href="index.php?com=soal_form&mod=add" class="btn btn-sm btn-success">Tambah Data</a>
	</div>
	<div class="card-body">
    	<?php
		echo alertdismiss();
		?>
		<?php
		$sql = "SELECT soal.soal_id, soal.kategori_id, soal.soal, soal.aktif, kategori.kategori 
					FROM kuisioner_soal soal 
					INNER JOIN kuisioner_soal_kategori kategori ON soal.kategori_id=kategori.kategori_id
						AND kategori.deleted='0'
						AND kategori.kuisioner_id='". getKuisionerId() ."' 
					WHERE soal.deleted='0' 
					ORDER BY soal.aktif DESC, kategori.kategori ASC, soal.soal ASC";
		$exe = _query($sql);
		$jml = _num_rows($exe);
					
		if ($jml > 0) {
		?>
    	<table id="datatable" class="table table-hover dataTable" style="width:100%">
			<thead>
				<tr>
					<th width="15">No</th>
					<th>Pertanyaan</th>
					<th width="200">Aksi</th>
				</tr>
			</thead>
			<tbody>
            	<?php
				$no = 1;
				while ($r = _object($exe)) {
					$soal_id = $r->soal_id;
				?>
            	<tr>
                	<td align="center" valign="top">
						<?php echo $no++;?>                        
                    </td>
                	<td align="left" valign="top">
					<?php echo $r->soal;?><br>
					<?php 
					$sqlRef = "SELECT opsi_id, soal_id, opsi, nilai
										FROM kuisioner_soal_opsi 
										WHERE deleted='0' AND soal_id='". $soal_id ."'
										ORDER BY created_at ASC"; 
					$exeRef = _query($sqlRef);
					while ($rRef = _object($exeRef)) {
						$opsi_id = $rRef->opsi_id;
					?>
					<a href="<?php echo 'index.php?com=opsi_form&mod=edit&sub='. $soal_id .'&id='. $opsi_id;?>" class="" title="Ubah Opsi"><i class="fa fa-pencil"></i></a>
                    <a onclick="javascript: return confirm('Anda yakin menghapus data ini ?')" href="<?php echo 'index.php?com=soal&mod=delete_opsi&id='. $opsi_id;?>" class="" data-id="<?php echo $rRef->opsi_id;?>" title="Hapus"><i class="fa fa-trash"></i></a>&nbsp;
					<?php echo '<b>['. $rRef->nilai .']</b> '. $rRef->opsi .'<br>';?>
					<?php		
					}
					?>
                    </td>
                	<td align="center" valign="top">
                    	<a href="<?php echo 'index.php?com=opsi_form&mod=add&sub='. $soal_id;?>" class="btn btn-sm btn-success" title="Tambah Opsi"><i class="fa fa-plus"></i> Opsi</a>
                    	<a href="<?php echo 'index.php?com=soal_form&mod=edit&id='. $soal_id;?>" class="btn btn-sm btn-primary" title="Ubah">Ubah</a>
                        <a onclick="javascript: return confirm('Anda yakin menghapus data ini ?')" href="<?php echo 'index.php?com=soal&mod=delete&id='. $soal_id;?>" class="btn btn-sm btn-danger" data-id="<?php echo $r->soal_id;?>" title="Hapus">Hapus</a>
                    </td>
                </tr>
                <?php
				} #. end of while ($r = _object($exe)) {
				?> 
			</tbody>
		</table>
        <?php
		} else {
			echo '<b> Belum ada data.</b>';	
		}
		?>
	</div> 
</div>