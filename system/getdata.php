<?php
/*---------------------------------------------------
	Data Statis
----------------------------------------------------*/
#- ID
$id = isset($_GET['id']) ? nosql($_GET['id']) : '';

$com = (isset($_GET['com']) AND !empty($_GET['com'])) ?  nosql($_GET['com']) :'';
$com = strtolower(str_replace('/', '', $com));
$com = strtolower(str_replace('&frasl;', '', nosql($com)));
$mod = (isset($_GET['mod']) AND !empty($_GET['mod'])) ?  nosql($_GET['mod']) :'';
$mod = strtolower(str_replace('/', '', $mod));
$mod = strtolower(str_replace('&frasl;', '', nosql($mod)));
$sub = (isset($_GET['sub']) AND !empty($_GET['sub'])) ?  nosql($_GET['sub']) :'';
$sub = strtolower(str_replace('/', '', $sub));
$sub = strtolower(str_replace('&frasl;', '', nosql($sub)));
	
#- Mode
$mode = isset($_POST['mode']) ? nosql($_POST['mode']) : '';
#- error
$error = array();

#- periode
$from	= isset($_GET['from']) ? nosql($_GET['from']) : '';
$to		= isset($_GET['to']) ? nosql($_GET['to']) : '';


#- variabel-variabel temporary
$a = isset($_GET['a']) ? nosql($_GET['a']) : '';
$b = isset($_GET['b']) ? nosql($_GET['b']) : '';
$c = isset($_GET['c']) ? nosql($_GET['c']) : '';
$d = isset($_GET['d']) ? nosql($_GET['d']) : '';
$e = isset($_GET['e']) ? nosql($_GET['e']) : '';
$f = isset($_GET['f']) ? nosql($_GET['f']) : '';
$g = isset($_GET['g']) ? nosql($_GET['g']) : '';
$h = isset($_GET['h']) ? nosql($_GET['h']) : '';
$i = isset($_GET['i']) ? nosql($_GET['i']) : '';
$j = isset($_GET['j']) ? nosql($_GET['j']) : '';