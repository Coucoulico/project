<?php require($_SERVER['DOCUMENT_ROOT']."/vues/VuesSpectacle/VueSpectacle.php");?>
<?php ob_start(); ?>
<?php
# code...
$date=$spectacl->getDate()->format('d-m-Y');
$lieu=$spectacl->getSalle()->getVillage();
$description=$spectacl->getDescription();
?>
<div class="container-global">
  <div class="titre-global">
    <p ><?=$date?></p>    
  </div>
  <div class="container-section">
    <p class="titre-section">à 
      <lieu><?=$lieu?></lieu>
      <span class="allOfLieu">voir tout les spectacle de ce lieu.</span>
    </p>
    <div id ="section-content">
      <?php afficherSpectacle($spectacl);?>
      <div id="more">
        <p class="more-info">plus d'infos</p>
        <p class="description" >
        <?=$description?>
      </p>
      </div>
      
    </div>
  </div>
</div>
<?php $content = ob_get_clean(); ?>


<?php require('templateVueTitre.php');?>