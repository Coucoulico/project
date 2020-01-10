<?php 
require($_SERVER['DOCUMENT_ROOT']."/php/beans/Festival.php");
require($_SERVER['DOCUMENT_ROOT']."/php/beans/Reservation.php"); 
if(isset($_GET['nom'])&&!is_null($_GET['nom'])){
	$panier=Panier::panierOfSession();
	$f=new Festival();
	$nomSpectacle=$_GET['nom'];
	$titres=array_map('strtolower',SpectaclDAO::getAllTitles($f->getSpectacls()));
	$nomSpectacle=strtolower($nomSpectacle);
	if(!in_array($nomSpectacle, $titres)){
		 header("location:"."/public_html/error404.html"); 
	}
	else{
		$spectacles=array_values(SpectaclDAO::ofTitle($f->getSpectacls(),$nomSpectacle));
		
		$spectacl=$spectacles[0];
        require($_SERVER['DOCUMENT_ROOT']."/vues/VuesTitre/VueTitre.php");
	}
}
