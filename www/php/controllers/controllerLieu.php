<?php 
require($_SERVER['DOCUMENT_ROOT']."/php/beans/Festival.php");
require($_SERVER['DOCUMENT_ROOT']."/php/beans/Reservation.php");
if((isset($_GET['pourlieu'])) && (!is_null($_GET['pourlieu']))){
   $panier=Panier::panierOfSession();
   $f=new Festival();
   $spectacles=$f->getSpectacls();
   $lieu=strtolower($_GET['pourlieu']);
   $lieux=array_map('strtolower',$f->getAllLieu());
   if(in_array($lieu,$lieux,true )){
   	$spectacles=SpectaclDAO::ofLieu($f->getSpectacls(),$lieu);
      $spectacles=SpectaclDAO::byDate($spectacles);
      require($_SERVER['DOCUMENT_ROOT']."/vues/VuesLieu/Vuelieu.php");
   }
   else{
       header("location:"."/public_html/error404.html");   
   	
   	
   }
   

    
}
