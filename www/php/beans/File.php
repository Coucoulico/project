<?php


class File{
	protected $_path="../../data/";
	protected $_nom;
	protected $_flux;

	function __construct($_file_name){
		$this->_nom=$_file_name;
    $this->_flux=file($this->_path.$this->_nom);
	}
    
    protected function affichage(){
    	echo "le nom du fichier : ",$this->_nom,"</br>";
    }

    public function getFlux(){
    	return $this->_flux;
    }

}

/**
 * 
 */
class Csv extends File{

   private $_map;
   private $_delimiter;
   private $_headers;
   function __construct($nom,$delimiter=','){
   	parent::__construct($nom);
   	$this->_headers=str_getcsv($this->_flux[0]);
    array_shift($this->_flux);

   	$csv = array_map('str_getcsv', $this->_flux);
    array_walk($csv, function(&$a) use ($csv) {
      $a = array_combine($this->_headers, $a);
    });
    
    $this->_map=$csv;
   }

   function affichage(){
   	parent::affichage();
   	print_r($this->_headers);
   	print_r($this->_map);
   	
   	
   	
   }
   
   public function getMap(){
   	return $this->_map;
   }

   public function getHeaders(){
    return $this->_headers;
   }

	}

 

   









