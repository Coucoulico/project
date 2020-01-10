
<?php 
require($_SERVER['DOCUMENT_ROOT']."/vues/VuesSpectacle/VueSpectacle.php");
?>
<?php ob_start(); ?>

<div class="container-global">
  <div class="titre-global">
    <p >Compagnie :  <?=$compagnie?></p>    
  </div>
  <?php foreach ($spectacles as $date=>$spectaclofDate) {?>
    <div class="container-section">
      <p class="titre-section">Le <date><?=$date?></date>
        <span class="allOfDate">voir tout les spectacle de cette date.</span>
      </p>
      <div class="section-content">
        <?php foreach ($spectaclofDate as $spectacl) {
          afficherSpectacle($spectacl,$panier);}?>
      </div>
 </div> 
<?php } ?>
</div>
<?php $content = ob_get_clean(); ?>
<?php require('templateVueCompagnie.php');?>