
<?php
require($_SERVER['DOCUMENT_ROOT']."/php/beans/Festival.php");
require($_SERVER['DOCUMENT_ROOT']."/php/beans/Reservation.php"); 


function actionne(){
	session_start();
    $panier=Panier::panierOfSession();
	if(isset($_POST['action'])){
		$action=$_POST['action'];    
		
		if(isset($_POST['spectacle'])){
			$e=$_POST['spectacle'];
			$salle=$e['salle'];
			$salle=new Salle($salle['nom'],$salle['village']);
			$spectacle=new Spectacl($e['titre'],new Date($e['date']),$salle,$e['compagnie']);
			$res=new ReservationMultiple($spectacle);
			switch ($action) {
				case 'add':
				$panier->add($res);
				break;
				case 'delete':
				$panier->remove($res);
				break;
				case 'update':
				if (isset($_POST['tarifs'])&& !is_null($_POST['tarifs'])){
					$byCategories=json_decode($_POST['tarifs'],true);
					$codes=ReservationMultiple::arrayCodes($byCategories['plein'],$byCategories['reduit'],$byCategories['enfant']);
					$panier->update($spectacle,$codes);  }

				break;
				default:
				break;
			}	
		}
		else{
			if($action=="ignore"){
				$c1=$_POST['data'][0];
			$c1=new Spectacl($c1['titre'],new Date($c1['date']),new Salle($c1['salle']['nom'],$c1['salle']['village']),$c1['compagnie']);
			$c2=$_POST['data'][1];
			$c2=new Spectacl($c2['titre'],new Date($c2['date']),new Salle($c2['salle']['nom'],$c2['salle']['village']),$c2['compagnie']);
			$panier->ignore_conflit(new Conflit($c1,$c2));
			}
			

			elseif ($action=="ignore-all") {
			# code...
			$panier->ignore_all();
		}
			
      
		} 
		
		$panier->save(); 	
	}       
            $con=array_filter($panier->__get('conflits'),function($e){
                   return !$e->is_ignored();
            });
			$msg=["spectacles" => count($panier), "conflits" => count($con)];
			echo json_encode($msg);
}
actionne();






