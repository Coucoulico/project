<?php require($_SERVER['DOCUMENT_ROOT']."/php/beans/Festival.php");
require($_SERVER['DOCUMENT_ROOT']."/php/beans/Reservation.php");?>

<?php 
if(isset($_GET['action'])&& (!is_null($_GET['action']))&& ($_GET['action']=="facturation")){
	$panier=Panier::panierOfSession();

	if(!$panier->estVide()){
		$res=$panier->count_all();
		$spec=count($panier->__get('reservations'));
		$panier->validerOffre();
		$t1=$panier->gettotalSansremise();
     $t=$panier->gettotal();
     $offert=$panier->toOffre();
	require($_SERVER['DOCUMENT_ROOT']."/Vues/VuesFacturation/vueFacturation.php");
	}
	else {
		 header("location:"."/public_html/error404.html"); 
	} 
	 
}