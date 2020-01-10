<?php
require($_SERVER['DOCUMENT_ROOT']."/php/beans/finance.php"); 
$f=new FestivalFinance();
error_reporting(E_ERROR | E_WARNING);
if(isset($_POST['strategy'])){
	$t;
	switch ($_POST['strategy']) {
		
		case 'dates':
			# code...
		$t=$f->BilletByDate();
			break;
		case 'compagnies':
			# code...
		$t=$f->BilletByGroup();
			break;
		case 'lieux':
			# code...
		$t=$f->BilletByLieu();
			break;
		
		default:
			# code...
		throw new Exception("action does not existe", 1);
		
			break;
	}
	echo json_encode($t,JSON_UNESCAPED_UNICODE);
	
	}


