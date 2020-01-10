<?php 
require($_SERVER['DOCUMENT_ROOT']."/vues/VuesPanier/afficheReservation.php");
?>
<?php ob_start(); ?>
<div id="container-res" class="container-global">
  <div class="titre-global">
    <p >Mes reservation :</p>    
  </div>
  <p id="offert"><?php $nb_offert=$panier->toOffre();?>
  <?php if($nb_offert>0){?>
    vous avez <?=$nb_offert?> billet(s) qui vous sera(ont) offert(s) gratuitement
  <?php } ?>
</p>
<?php 
$reservations=$panier->__get('reservations');
if(count($panier)<=Panier::MAX){
  foreach ($reservations as  $res) {
    afficherReservation($res,$panier);
  } 
}?>
<div id="recapitulatif">
  <?php 
  $t=$panier->gettotal();
  $t1=$panier->gettotalSansremise();
  ?>
</div>
<button id="facturation">
  FACTURATION
</button>
</div>



<div id="container-conflits" class="container-global">
  <div class="titre-global">
  Les conflits
  </div>
  <?php 
  $con=$panier->__get('conflits');
  foreach ($con as $key => $value) {
      # code...
    afficherConflit($value,$panier);
  }?>

  <button id="ignore-all">
  tout ignorer
</button>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('templateVuePanier.php');?>