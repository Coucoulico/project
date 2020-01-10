<?php require ($_SERVER['DOCUMENT_ROOT']."/vues/VuesSpectacle/VueSpectacle.php");?>
<?php 

function afficherReservationInfo($reservation,$panier=null){ 
  $res=$reservation->byTarif();
  $total=$reservation->allBillet();
  $rest=Panier::MAX-count($panier);

  ?>  

  <div class="reservation-info">
    <div class="control-reservation">
      <img class="delete-reservation" src="/images/icons/delete.png">

      <span>nombre de billets pour ce spectacle :
        <total><?=$total?></total> 
      </span>

    </div>

    <div class="info-categories">
      <?php foreach ($res as $code => $nb) {
        $tarif=new Tarif(new Categorie($code));
        $categorie=$tarif->__get('categorie')->__get('destination');
        ?>
        <p class="info-categorie"> 
         <select value=<?=$code?>>
          <?php 
          $low=afficher($code,$res);
          if($code==3) $hight=$reservation->forChildren();
          else $hight=$nb+$rest;
          for ($i=$low; $i <= $hight; $i++) { 
            ?>
            <option <?php if($i==$nb){?>selected <?php }?>><?=$i?></option> 
          <?php } ?>

        </select>
        pour <?=$categorie?>
      </p>
    <?php }?> 
  </div>
</div>
<?php }


function afficher($cat,$bayCat){
  if($cat==3)return 0;
  else{
    foreach ($bayCat as $code => $nb) {
      if($code!=3){
       if($cat!=$code && $nb>0)return 0;
     }
   }
   return 1;
 }
}



function afficherReservation($res,$panier=null){?>

  <div class="reservation-container">
    <?php
    afficherSpectacle($res->__get('spectacle'),$panier);
    afficherReservationInfo($res,$panier);
    ?>
    
  </div>

<?php }

function afficherConflit($c,$panier){?>
  <div class="container-conflit">
    <div class="spectacles">
      <?php afficherSpectacle($c->getS1(),$panier);
      afficherSpectacle($c->getS2(),$panier);?>

    </div>
    <button class="ignore-conflit">
      ignorer ce conflit
    </button>
    
  </div>
  

  

<?php }










