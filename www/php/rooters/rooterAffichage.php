<?php 
$action="/php/controllers/controllerAccueil.php";
session_start();
if(isset($_GET['action'])&&(!is_null($_GET['action']))){
	if($_GET['action']=="panier"){
		$action="/php/controllers/controllerpanier.php";
	}
    elseif ($_GET['action']=="facturation") {
    	# code...
    	$action="/php/controllers/controllerFacturation.php";
    }
    elseif ($_GET['action']=="finance") {
    	# code...
    	$action="/php/controllers/controllerFinance.php";
    }
	else{
			if(isset($_GET['date'])&&(!is_null($_GET['date']))){
          $action="/php/controllers/controllerDate.php";
	}
	elseif(isset($_GET['pourlieu'])&&(!is_null($_GET['pourlieu']))){
		$action="/php/controllers/controllerLieu.php";
	}
	elseif(isset($_GET['compagnie'])&&(!is_null($_GET['compagnie']))){
		$action="/php/controllers/controllerCompagnie.php";
	}
	elseif(isset($_GET['nom'])&&(!is_null($_GET['nom']))){
		$action="/php/controllers/controllerTitre.php";
	}
	elseif(isset($_GET['spectacle'])&&(!is_null($_GET['spectacle']))){
		$action="/php/controllers/controllerSpectacle.php";
	}
	else header("location:"."/error404.html");  
	}
     
    }
    require($_SERVER['DOCUMENT_ROOT'].$action);

 
	   
    
