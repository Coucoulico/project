<?php 
require($_SERVER['DOCUMENT_ROOT']."/php/beans/Festival.php");
$f=new Festival();
$dd=$f->getDateDebut();
if(isset($_GET['date'])&& !is_null($_GET['date'])){
	$d=new Date($_GET['date']);
	//$d->add(new DateInterval('P1D'));
	$di=$dd->diff($d,false);
	$diff=$di->{'d'};
	if($diff<=0) echo $dd->format('d-m-Y');
	else echo $d->sub(new DateInterval('P1D'))->format('d-m-Y');
}