<?php
if ($mod == 'delete') {
	$id = nosql($_GET['id']);
	$sql = "UPDATE kuisioner SET deleted_by='". $_SESSION['cmsUserId'] ."', deleted_at='". date('Y-m-d H:i:s') ."', deleted='1' WHERE kuisioner_id='". $id ."'";
	$exe = _query($sql);
	if ($exe) {
		$_SESSION['alert']['type'] 		= 'success';
		$_SESSION['alert']['content'] 	= 'Data berhasil dihapus.';
	} else {
		$_SESSION['alert']['type'] 		= 'danger';
		$_SESSION['alert']['content'] 	= 'Data gagal dihapus : '. _error();
	}
	header('Location: index.php?com=kuisioner');
	exit();
}	
?>
<div class="card">
	<div class="card-header">
		<strong>DAFTAR KUISIONER</strong> 
        <a href="index.php?com=kuisioner_form&mod=add" class="btn btn-sm btn-success">Tambah Data</a>
	</div>
	<div class="card-body">
    	<?php
		echo alertdismiss();
		?>
		<?php
		$sql = "SELECT * FROM kuisioner WHERE deleted='0' ORDER BY aktif DESC, kuisioner ASC";
		$exe = _query($sql);
		$jml = _num_rows($exe);
					
		if ($jml > 0) {
		?>
    	<table id="datatable" class="table table-hover dataTable" style="width:100%">
			<thead>
				<tr>
					<th width="15">No</th>
					<th>Kuisioner</th>
					<th width="150">Aktif</th>
					<th width="100">Aksi</th>
				</tr>
			</thead>
			<tbody>
            	<?php
				$no = 1;
				while ($r = _object($exe)) {
					$id = $r->kuisioner_id;
				?>
            	<tr>
                	<td align="center"><?php echo $no++;?></td>
                	<td align="left"><?php echo $r->kuisioner;?></td>
                	<td align="center"><?php echo $listAktif[$r->aktif];?></td>
                	<td align="center">
                    	<a href="<?php echo 'index.php?com=kuisioner_form&mod=edit&id='. $id;?>" class="btn btn-sm btn-primary" title="Ubah">Ubah</a>
                        <a onclick="javascript: return confirm('Anda yakin menghapus data ini ?')" href="<?php echo 'index.php?com=kuisioner&mod=delete&id='. $id;?>" class="btn btn-sm btn-danger" data-id="<?php echo $r->id;?>" title="Hapus">Hapus</a>
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