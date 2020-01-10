<?php
require($_SERVER['DOCUMENT_ROOT']."/php/beans/Festival.php");
require($_SERVER['DOCUMENT_ROOT']."/php/beans/Reservation.php");
$panier=Panier::panierOfSession();
if(isset($_GET['date'])&& !is_null($_GET['date'])){
	$date=new Date($_GET['date']);
	$f=new Festival();
	$spectacles=$f->ofDay($date);
    $spectacles=SpectaclDAO::byLieu($spectacles);
    require($_SERVER['DOCUMENT_ROOT']."/vues/VuesDate/VueDate.php");
}
else{
	 header("location:"."/public_html/error404.html");  
}



