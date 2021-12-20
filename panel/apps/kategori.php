<?php
if ($mod == 'delete') {
	$id = nosql($_GET['id']);
	$sql = "UPDATE kuisioner_soal_kategori SET deleted_by='". $_SESSION['cmsUserId'] ."', deleted_at='". date('Y-m-d H:i:s') ."', deleted='1' WHERE kategori_id='". $id ."'";
	$exe = _query($sql);
	if ($exe) {
		$_SESSION['alert']['type'] 		= 'success';
		$_SESSION['alert']['content'] 	= 'Data berhasil dihapus.';
	} else {
		$_SESSION['alert']['type'] 		= 'danger';
		$_SESSION['alert']['content'] 	= 'Data gagal dihapus : '. _error();
	}
	header('Location: index.php?com=kategori');
	exit();
}	
?>
<div class="card">
	<div class="card-header">
		<strong>DAFTAR KATEGORI PERTANYAAN</strong> 
        <a href="index.php?com=kategori_form&mod=add" class="btn btn-sm btn-success">Tambah Data</a>
	</div>
	<div class="card-body">
    	<?php
		echo alertdismiss();
		?>
		<?php
		$sql = "SELECT * FROM kuisioner_soal_kategori WHERE kuisioner_id='". getKuisionerId() ."' AND deleted='0' ORDER BY aktif DESC, kategori ASC";
		$exe = _query($sql);
		$jml = _num_rows($exe);
					
		if ($jml > 0) {
		?>
    	<table id="datatable" class="table table-hover dataTable" style="width:100%">
			<thead>
				<tr>
					<th width="15">No</th>
					<th>Kategori Pertanyaan</th>
					<th width="150">Aktif</th>
					<th width="100">Aksi</th>
				</tr>
			</thead>
			<tbody>
            	<?php
				$no = 1;
				while ($r = _object($exe)) {
					$id = $r->kategori_id;
				?>
            	<tr>
                	<td align="center"><?php echo $no++;?></td>
                	<td align="left"><?php echo $r->kategori;?></td>
                	<td align="center"><?php echo $listAktif[$r->aktif];?></td>
                	<td align="center">
                    	<a href="<?php echo 'index.php?com=kategori_form&mod=edit&id='. $id;?>" class="btn btn-sm btn-primary" title="Ubah">Ubah</a>
                        <a onclick="javascript: return confirm('Anda yakin menghapus data ini ?')" href="<?php echo 'index.php?com=kategori&mod=delete&id='. $id;?>" class="btn btn-sm btn-danger" data-id="<?php echo $r->id;?>" title="Hapus">Hapus</a>
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