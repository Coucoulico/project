<?php

function afficherSpectacle($spectacl,$panier=null){

 $heure=$spectacl->getDate()->format('H:i');
 $date=$spectacl->getDate()->format('d-m-Y');
 $salle=$spectacl->getSalle()->getNom();
 $lieu=$spectacl->getSalle()->getVillage();
 $titre=$spectacl->getTitre();
 $image=$spectacl->getImage();
 $compagnie=$spectacl->getCompagnie();?>
 <div class="spectacl-container">
  <p class="titre-spectacl">Spectacle: <titre><?=$titre?></titre></p>  
  <hr width="80%" size="2">
  <img class="img-spectacl" src="<?=$image?>" ></img>
  <div class="info-spectacl">
    <!--<img src="<?=$image?>">-->

    
    <p><date class="hidden"><?=$date ?></date> l'heure : <heure><?=$heure ?></heure>.</p>
    <p><lieu class="hidden"><?=$lieu?></lieu> la salle : <salle><?=$salle?></salle>.</p>
    
    <p> la compgnie : <compagnie><?=$compagnie?></compagnie>.</p>
  </div>
   <?php 
   if(!is_null($panier)) afficherButton($spectacl,$panier);
   ?>
</div>

<?php }?>

<?php 

function  afficherButton($spectacle,$panier){
 $retirer="retirer de mon panier";
 $ajouter="ajouter à mon panier";?>
<div class="reservation"> 
  <?php if($panier->estVide()){?>
  <?=$ajouter?>
<?php }
else{

 if($panier->contains($spectacle)){
  ?>
  <?=$retirer?>

  <?php 
}
else{?>
 <?=$ajouter?>
 <?php
}
}?>
  
</div>
  <?php }
?>






















