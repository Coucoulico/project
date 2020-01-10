<?php ob_start(); ?>
<div class="container">
 <div class="titre-global">Recapitulatif de la commande</div>
  <p>Vous avez commander <?=$res?> billets pour <?=$spec?> spectacle(s)</P>
  <?php if($offert>0){?>
        <P><span><?=$offert?></span>vous sera(ont) offert<?php if($offert>1){?>s<?php } ?> gratuitement</p>
  <?php } ?> 
    
  <p>Montant globale :<span><?=$t1?></span></p>
  <?php if($offert>0){ ?>
  <p>Montant globale deduit (le montant à regler):<span><?=$t?></span></p><?php }?>
</div>
<form>
  <div class="titre-global">Information client et facturation</div>
    <label for="fname">Nom</label>
    <input type="text" id="fname" name="firstname" minlength="2 " maxlength="50" required placeholder="Nom..">

    <label for="lname">Prenom</label>
    <input type="text" id="lname" name="lastname" minlength="2 " maxlength="50" required placeholder="Votre prenom..">
    <label for="lname">Mail</label>
    <input type="mail" name="mail" name="mail" minlength="2 " maxlength="60" required placeholder="exemple@gmail.fr">
    <input type="submit" value="Payer">
</form>
<?php $content = ob_get_clean(); ?>
<?php require('templateVueFacturation.php'); ?>