<?php
require 'Month.php';
/**
 * 
 */
class Date extends DateTime implements Serializable , JsonSerializable
{
	private $date;
	private $valide;
	function __construct($date)
	{
		# code...
		$this->_date=$date;
		$d=$this->parse();
		if($this->isValide())  parent::__construct($d);
		else {
			$this->_valide=true;
			parent::__construct($date);
			
		}
		
		
	}

	private  function parse(){
		$regex="#^([a-zA-Zû]+\s)?(0?[1-9]|[1-2][1-9]|3[0-1])\s([a-zA-Zû]+)\s([1-2][0-9]{3})\s(\w{2})h(\w{2})$#";
		if (preg_match($regex, $this->_date,$matches)){
			$this->_valide=true;
			$month=MonthOfYear::valueOf($matches[3]);
			$s=$matches[2]."-".$month."-".$matches[4]." ".$matches[5].":".$matches[6];
			return $s;
		}
		else{
			$this->_valide=false;
			return false;
		
	}

}
     public function isValide(){
     	return $this->_valide;
     }

     public function __toString(){
     	return ($this->format('d-m-Y'));
     }
     
     public function serialize() {
         return $this->format('d-m-Y H:i');
      }

      public function unserialize($str){
      	$this->__construct($str);
      }

      public function jsonSerialize(){
      	return [
      		'jour'=>$this->format('d-m-Y'),
      		'heure'=>$this->format('H:i')
      	];
      }

}






