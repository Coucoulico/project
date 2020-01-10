<?php
/**
 * 
 */
class Salle implements JsonSerializable
{
	private $_nom;
	private $_village;
	//les spectacls se derouleront en plein air donc pas de capacité à gerer
	function __construct($nom,$village)
	{
		# code...
		$this->_nom=$nom;
		$this->_village=$village;
	}
	public function getNom(){
		return $this->_nom;
	}

	public function getVillage(){
		return $this->_village;
	}

	function __toString(){
		return $this->_nom.$this->_village;
	} 
	public function jsonSerialize(){
		return [
          'nom'=>trim($this->_nom),
          'village'=>trim($this->_village)
		];
	}
	
	
}
