<?php
require($_SERVER['DOCUMENT_ROOT']."/php/beans/Festival.php");
require($_SERVER['DOCUMENT_ROOT']."/php/beans/Reservation.php");
if(isset($_GET['compagnie'])&& !is_null($_GET['compagnie'])){
   $f=new Festival();
   $compagnie=strtolower($_GET['compagnie']);
   $compagnies=array_map('strtolower',$f->getCompagnies());
   if(in_array($compagnie,$compagnies,TRUE )){
     $spectacles=SpectaclDAO::ofGroupe($f->getSpectacls(),$compagnie);
     $spectacles=SpectaclDAO::byDate($spectacles);
     require($_SERVER['DOCUMENT_ROOT']."/vues/VuesCompagnie/VueCompagnie.php");
   }
   else{
    header("location:"."/public_html/error404.html");   
   	
   }
   
    
}
