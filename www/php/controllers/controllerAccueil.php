<?php
require($_SERVER['DOCUMENT_ROOT']."/php/beans/Festival.php");

$f=new Festival();
$dd=$f->getDateDebut();
$df=$f->getDateFin();
$nb_spec=count($f->getSpectacls());
$nb_group=count($f->ByGroup());
$nb_lieu=count($f->ByLieu());
require($_SERVER['DOCUMENT_ROOT']."/vues/vueAccueil.php");
