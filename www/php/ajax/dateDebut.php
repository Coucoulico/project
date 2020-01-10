<?php 
require($_SERVER['DOCUMENT_ROOT']."/php/beans/Festival.php");
$f=new Festival();
$df=$f->getDateFin();
if(isset($_GET['date'])&& !is_null($_GET['date'])){
	$d=new Date($_GET['date']);
	//$d->add(new DateInterval('P1D'));
	$di=$df->diff($d,false);
	$diff=$di->{'d'};
	if($diff<=0) echo $df->format('d-m-Y');
	else echo $d->add(new DateInterval('P1D'))->format('d-m-Y');
}
else echo $f->getDateDebut()->format('d-m-Y');



