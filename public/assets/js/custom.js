$(document).ready(function(){ 
	/* step form */
	$("#blok_1").hide();
	$("#blok_2").hide();
	$("#blok_3").hide();
	$("#blok_4").hide();	
	$("#blok_back_2").hide();
	$("#blok_back_3").hide();
	$("#blok_back_4").hide();	
	$("#blok_next_1").hide();
	$("#blok_next_2").hide();
	$("#blok_next_3").hide();
	$("#blok_next_4").hide();
	
	$("#blok_1").show();
	$("#blok_next_1").show();
	
	$('#tombol_next_1').click( function() {
		$("#blok_1").hide();
		$("#blok_next_1").hide();
		
		$("#blok_2").show();
		$("#blok_back_2").show();
		$("#blok_next_2").show();
	});
	
	$('#tombol_back_2').click( function() {
		$("#blok_2").hide();
		$("#blok_back_2").hide();
		$("#blok_next_2").hide();
		
		$("#blok_1").show();
		$("#blok_next_1").show();
	});	
	$('#tombol_next_2').click( function() {
		$("#blok_2").hide();
		$("#blok_back_2").hide();
		$("#blok_next_2").hide();
		
		$("#blok_3").show();
		$("#blok_back_3").show();
		$("#blok_next_3").show();
	});
	
	$('#tombol_back_3').click( function() {
		$("#blok_3").hide();
		$("#blok_back_3").hide();
		$("#blok_next_3").hide();
		
		$("#blok_2").show();
		$("#blok_back_2").show();
		$("#blok_next_2").show();
	});	
	$('#tombol_next_3').click( function() {
		$("#blok_3").hide();
		$("#blok_back_3").hide();
		$("#blok_next_3").hide();
		
		$("#blok_4").show();
		$("#blok_back_4").show();
		$("#blok_next_4").show();
	});
	
	$('#tombol_back_4').click( function() {
		$("#blok_4").hide();
		$("#blok_back_4").hide();
		$("#blok_next_4").hide();
		
		$("#blok_3").show();
		$("#blok_back_3").show();
		$("#blok_next_3").show();
	});	
	
	
	/* step form */

	$("#loading").hide();
	
	$('#nik').keyboard({type:'numpad'});
	$('#hp').keyboard({type:'numpad'});
	$('#nama').keyboard({initCaps:true});
	$('#alamat').keyboard({initCaps:true});
	$('#saran').keyboard({initCaps:true});
			
	// $("#kecamatan").change(function(){
	// 	$("#kelurahan").hide();
	// 	$("#loading").show();
	// 	var kecamatan = $("#kecamatan").val();
		
	// 	$.ajax({
	// 		type: "GET", 
	// 		url: "index.php?com=getdesa", 
	// 		data: {kecamatan : kecamatan}, 
	// 		dataType: "json",
	// 		beforeSend: function(e) {
	// 			if(e && e.overrideMimeType) {
	// 				e.overrideMimeType("application/json;charset=UTF-8");
	// 			}
	// 		},
	// 		success: function(response){ 
	// 			$("#loading").hide(); 
	// 			$("#kelurahan").html(response.data_kelurahan).show();
	// 		},
	// 		error: function (xhr, ajaxOptions, thrownError) { 
	// 			alert(thrownError); 
	// 		}
	// 	});
	// });
	
	// $('input:radio[name="provinsi"]').change(function(){
	// 	$("#kabupaten").hide();
	// 	$("#loading").show();
	// 	var provinsi = this.value;
	// 	//alert(provinsi);
	// 	$.ajax({
	// 		type: "GET", 
	// 		url: "index.php?com=getkabupaten", 
	// 		data: {provinsi : provinsi}, 
	// 		dataType: "json",
	// 		beforeSend: function(e) {
	// 			if(e && e.overrideMimeType) {
	// 				e.overrideMimeType("application/json;charset=UTF-8");
	// 			}
	// 		},
	// 		success: function(response){ 
	// 			$("#loading").hide(); 
	// 			$("#kabupaten").html(response.data_kabupaten).show();
	// 		},
	// 		error: function (xhr, ajaxOptions, thrownError) { 
	// 			alert(thrownError); 
	// 		}
	// 	});
	// });

	// $('input:radio[name="kabupaten"]').change(function(){
	// 	alert(1);
	// });

$(document).ready(function(){
 
			// sembunyikan form kabupaten, kecamatan dan desa
			$("#label_kab").hide();
			$("#label_kec").hide();
			$("#label_des").hide();
 
			$("#form_kab").hide();
			$("#form_kec").hide();
			$("#form_des").hide();
 
			// ambil data kabupaten ketika data memilih provinsi
			$('body').on("change","#form_prov",function(){
				var id = $(this).val();
				var data = "id="+id+"&data=kabupaten";
				$.ajax({
					type: 'POST',
					url: "get_daerah.php",
					data: data,
					success: function(hasil) {
						$("#form_kab").html(hasil);
						$("#label_kab").show();
						$("#form_kab").show();
						$("#form_kec").hide();
						$("#form_des").hide();
					}
				});
			});
 
			// ambil data kecamatan/kota ketika data memilih kabupaten
			$('body').on("change","#form_kab",function(){
				var id = $(this).val();
				var data = "id="+id+"&data=kecamatan";
				$.ajax({
					type: 'POST',
					url: "get_daerah.php",
					data: data,
					success: function(hasil) {
						$("#form_kec").html(hasil);
						$("#label_kec").show();
						$("#form_kec").show();
						$("#form_des").hide();
					}
				});
			});
 
			// ambil data desa ketika data memilih kecamatan/kota
			$('body').on("change","#form_kec",function(){
				var id = $(this).val();
				var data = "id="+id+"&data=desa";
				$.ajax({
					type: 'POST',
					url: "get_daerah.php",
					data: data,
					success: function(hasil) {
						$("#form_des").html(hasil);
						$("#label_des").show();
						$("#form_des").show();
					}
				});
			});
});








	$('input:radio[name="kecamatan"]').change(function(){
		$("#kelurahan").hide();
		$("#loading").show();
		var kecamatan = this.value;
		$.ajax({
			type: "GET", 
			url: "index.php?com=getdesa2", 
			data: {kecamatan : kecamatan}, 
			dataType: "json",
			beforeSend: function(e) {
				if(e && e.overrideMimeType) {
					e.overrideMimeType("application/json;charset=UTF-8");
				}
			},
			success: function(response){ 
				$("#loading").hide(); 
				$("#kelurahan").html(response.data_kelurahan).show();
			},
			error: function (xhr, ajaxOptions, thrownError) { 
				alert(thrownError); 
			}
		});
	});
	
	$('input#submitForm').click( function() {
		var nik = $("#nik").val();
		var nama = $("#nama").val();
		var jk = $('input:radio[name="jk"]:checked').val(); //$("#jk").val();
		var agama = $('input:radio[name="agama"]:checked').val(); //$("#agama").val();
		var usia = $('input:radio[name="usia"]:checked').val(); //$("#usia").val();
		var alamat = $("#alamat").val();
		var kelurahan = $('input:radio[name="kelurahan"]:checked').val(); //$("#kelurahan").val();
		var pendidikan = $('input:radio[name="pendidikan"]:checked').val(); //$("#pendidikan").val();
		var pekerjaan = $('input:radio[name="pekerjaan"]:checked').val(); //$("#pekerjaan").val();
		
		if (nik == '' || nama == '' || jk == '' || agama == '' || usia == '' || alamat == '' || kelurahan == '' || pendidikan == '' || pekerjaan == '') {
			alert("Semua Isian Harus Diisi...!!!");
		} else {
			$.ajax({
				url: 'index.php?com=save',
				type: 'POST',
				dataType: 'json',
				data: $('form#cmsForm').serialize(),
				beforeSend: function(e) {
					if(e && e.overrideMimeType) {
						e.overrideMimeType("application/json;charset=UTF-8");
					}
				},
				success: function(response){
					var status = response.status;
					
					if (status == 'save') {
						setTimeout("location.href = 'menu.php';", 1);
					} else {
						alert('Gagal tersimpan..!!');
						setTimeout("location.href = 'index.php';", 1);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) { 
					alert(thrownError); 
				}
			});
		}
	});
	
	$('input#submitFormSoal').click( function() {
		var jawab = $('input:radio[name="jawab"]:checked').val(); //$("#jawab").val();
		
		if (jawab == '') {
			alert("Semua Isian Harus Diisi...!!!");
		} else {
			$.ajax({
				url: 'index.php?com=save_soal',
				type: 'POST',
				dataType: 'json',
				data: $('form#cmsFormSoal').serialize(),
				beforeSend: function(e) {
					if(e && e.overrideMimeType) {
						e.overrideMimeType("application/json;charset=UTF-8");
					}
				},
				success: function(response){ 
					alert('Data berhasil disimpan. Terimakasih.');
					setTimeout("location.href = 'menu.php';", 1);
				},
				error: function (xhr, ajaxOptions, thrownError) { 
					alert(thrownError); 
				}
			});
		}
	});
	
	$('input#submitSaran').click( function() {
		var saran = $("#saran").val();
		
		if (saran == '') {
			alert("Saran Harus Diisi...!!!");
		} else {
			$.ajax({
				url: 'index.php?com=save_saran',
				type: 'POST',
				dataType: 'json',
				data: $('form#cmsFormSaran').serialize(),
				beforeSend: function(e) {
					if(e && e.overrideMimeType) {
						e.overrideMimeType("application/json;charset=UTF-8");
					}
				},
				success: function(response){ 
					alert('Data berhasil disimpan. Terimakasih.');
					setTimeout("location.href = 'menu.php';", 1);
				},
				error: function (xhr, ajaxOptions, thrownError) { 
					alert(thrownError); 
				}
			});
		}
	});
});