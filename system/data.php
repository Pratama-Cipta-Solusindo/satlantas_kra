<?php
/*---------------------------------------------------
	BEGIN : SYSTEM DATA AND DONT REMOVE IT ... !!!
----------------------------------------------------*/

#-- Versi Program
$programVersion	= '1.1.1'; 

#-- SetDefaultPassword
$defaultPassword	= 'Password@123'; 

#-- Ya / Tidak
$listYaTidak = array('Y'=>'Ya', 'N'=>'Tidak');

#-- Ya / Tidak
$listYesNo = array('1'=>'Ya', '0'=>'Tidak');

#-- AKtif / Tidak Aktif
$listAktif = array('1'=>'Aktif', '0'=>'Tidak Aktif');

#-- Status Perkawinan
$listStatusKawin = array('1'=>'Belum Kawin','2'=>'Kawin','3'=>'Cerai Hidup','4'=>'Cerai Mati');

#-- Golongan Darah
$listGolonganDarah = array('1'=>'A','2'=>'B','3'=>'AB', '4'=>'O', '5'=>'A+', '6'=>'A-', '7'=>'B+', '8'=>'B-', '9'=>'AB+', '10'=>'AB-', '11'=>'O+', '12'=>'O-', '98'=>'Tidak Diisi', '99'=>'Tidak Tahu');

#-- Tanda Pengenal
$listIdentitas = array('1'=>'KTP','2'=>'SIM','3'=>'Pasport','4'=>'Kitas','5'=>'Lainnya');

#-- Usia
$listUsia = array('1'=>'20 Tahun Kebawah','2'=>'21-30 Tahun','3'=>'31-40 Tahun','4'=>'41-50 Tahun','5'=>'50 Tahun Keatas');

#-- Agama
#$listAgama = array('1'=>'Islam', '2'=>'Kristen', '3'=>'Katholik', '4'=>'Hindu', '5'=>'Budha', '6'=>'Konghucu', '98'=>'Tidak diisi', '99'=>'Lainnya');
$listAgama = array('1'=>'Islam', '2'=>'Kristen', '3'=>'Katholik', '4'=>'Hindu', '5'=>'Budha', '6'=>'Konghucu', '7'=>'Kepercayaan Terhadap Tuhan YME');

#-- Jenis Kelamin
$listJenisKelamin = array('1'=>'Laki-Laki', '2'=>'Perempuan');

#-- Pendidikan
#$listPendidikan = array('0'=>'Tidak sekolah', '1'=>'PAUD', '2'=>'TK / sederajat', '3'=>'Putus SD', '4'=>'SD / sederajat', '5'=>'SMP / sederajat', '6'=>'SMA / sederajat', '7'=>'Paket A', '8'=>'Paket B', '9'=>'Paket C', '20'=>'D1', '21'=>'D2', '22'=>'D3', '23'=>'D4', '30'=>'S1', '31'=>'Profesi', '32'=>'Sp-1', '35'=>'S2', '36'=>'S2 Terapan', '37'=>'Sp-2', '40'=>'S3', '41'=>'S3 Terapan', '90'=>'Non formal', '91'=>'Informal', '99'=>'Lainnya');
$listPendidikan = array('1'=>'SD / sederajat', '2'=>'SMP / sederajat', '3'=>'SMA / sederajat', '4'=>'D1/D2', '5'=>'D3/D4', '6'=>'S1', '7'=>'S2', '8'=>'S3', );

#-- Pekerjaan
#$listPekerjaan = array('1'=>'Tidak bekerja', '2'=>'Nelayan', '3'=>'Petani', '4'=>'Peternak', '5'=>'PNS/TNI/Polri', '6'=>'Karyawan Swasta', '7'=>'Pedagang Kecil', '8'=>'Pedagang Besar', '9'=>'Wiraswasta', '10'=>'Wirausaha', '11'=>'Buruh', '12'=>'Pensiunan', '98'=>'Sudah Meninggal', '99'=>'Lainnya');
$listPekerjaan = array('1'=>'Nelayan/Petani/Peternak', '2'=>'PNS/TNI/Polri', '3'=>'Karyawan Swasta', '4'=>'Pedagang/Wiraswasta', '5'=>'Guru/Dosen', '6'=>'Dokter/Bidan/Perawat', '7'=>'Pelajar/Mahasiswa', '99'=>'Lainnya');

#-- Penghasilan
$listPenghasilan = array(''=>'Tidak berpenghasilan', '11'=>'Kurang dari Rp. 500,000', '12'=>'Rp. 500,000 - Rp. 999,999', '13'=>'Rp. 1,000,000 - Rp. 1,999,999', '14'=>'Rp. 2,000,000 - Rp. 4,999,999', '15'=>'Rp. 5,000,000 - Rp. 20,000,000', '16'=>'Lebih dari Rp. 20,000,000');

#-- Jenis Tinggal
$listJenisTinggal = array(''=>'', '1'=>'Bersama orang tua', '2'=>'Wali', '3'=>'Kost', '4'=>'Asrama', '5'=>'Panti asuhan', '99'=>'Lainnya');

#-- ekstensi dokumen
$listEkstensiDokumen = array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'mdb', 'accdb', 'txt', 'pdf', 'odt', 'ods', 'odp', 'obd', 'odg', 'fodg', 'odf', 'odc', 'odi', 'odm', 'sql');
#-- ekstensi gambar
$listEkstensiGambar = array('jpeg', 'jpg', 'png', 'gif', 'bmp');
#-- ekstensi arsip
$listEkstensiArsip = array('zip', '7z', 'rar', 'tar.gz', 'gz', 'tar', 'dep', 'rpm', 'iso');
#-- ekstensi musik
$listEkstensiAudio = array('mp3', 'wav', 'm4a', 'wma', 'au', 'aiff', 'aac', 'flac', 'pcm', 'oog');
#-- ekstensi video
$listEkstensiVideo = array('asf', 'avi', 'mp4', 'm4v', 'mov', 'mpg', 'swf', 'wmv', 'flv', 'div', 'webm', 'divx', 'mkv', 'gifv');
#-- ekstensi file
$listEkstensiFile = array_merge($listEkstensiDokumen, $listEkstensiGambar, $listEkstensiArsip, $listEkstensiArsip, $listEkstensiAudio, $listEkstensiVideo);

#-- Proses Activity
$listProsesAktifitas = array('Insert'=>'Insert Data', 'Update'=>'Update Data', 'Delete'=>'Delete Data'); 
#-- Sorting
$listSorting = array('ASC'=>'ASC', 'DESC'=>'DESC');
#-- Level User
$listLevelUser = array('admin'=>'Administrator', 'user'=>'User');

$listColor = array(0=>'grey', 1=>'red', 2=>'orange', 3=>'yellow', 4=>'green', 5=>'blue');

/*---------------------------------------------------
	END : SYSTEM DATA AND DONT REMOVE IT ... !!!
----------------------------------------------------*/

#-- list ikon
$listEmotIcon = array('emot_1.png', 'emot_2.png', 'emot_3.png', 'emot_4.png', 
						'emot_5.png', 'emot_6.png', 'emot_7.png', 'emot_8.png');

#-- List Satuan #1 spkt #2 sat intel #3 sat reskrim #4 sat lantas
$listSatuan = array('1'=>'SPKT', '2'=>'SAT INTELKAM', '3'=>'SAT RESKRIM', '4'=>'SAT LANTAS', '5'=>'SAT RESNARKOBA', '6'=>'SAT TAHTI');

#-- List Jenis Layanan
$listJenisLayanan = array('1'=>'Baru', '2'=>'Perpanjangan', '3'=>'Peningkatan', '4'=>'Penurunan', '5'=>'Hilang/Rusak', '6'=>'Habis Masa Berlaku');

#-- Default Satuan
$SatuanID = '4'; 

#-- ID Kabupaten
$KabupatenID = '3371'; #3371 Magelang Kota


$setNilaiKali = 25; # biar dapet angka 100, jika 5 maka 20, jika 4 maka 25