<?php require($_SERVER['DOCUMENT_ROOT']."/php/beans/Festival.php");
require($_SERVER['DOCUMENT_ROOT']."/php/beans/Reservation.php");?>

<?php 
if(isset($_GET['action'])&& (!is_null($_GET['action']))&& ($_GET['action']=="panier")){
	$panier=Panier::panierOfSession();
	if ($panier->estVide()) {
		# code...
		 header("location:"."/public_html/error404.html");   
	}
	else require($_SERVER['DOCUMENT_ROOT']."/Vues/VuesPanier/vuePanier.php");
}