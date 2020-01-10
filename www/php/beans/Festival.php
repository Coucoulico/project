<?php
require ('Spectacl.php');
require ('File.php');
/**
 * 
 */
class Festival
{
 const FILE_NAME="ResultatsFestival.csv";
 protected $_date_debut;
 protected $_date_fin;
 protected $_lieu;
 protected $_groupe;
 protected $_spectacls;
 protected $_dao;
	
	function __construct()
	{
		# code...
		 $this->_dao=new SpectaclDAO(Festival::FILE_NAME);
         $this->_spectacls=$this->_dao->getSpectacls();
         $this->init();
         SpectaclDAO::sort($this->_spectacls);
	}
	protected function init(){
       
        $this->_date_debut=SpectaclDAO::open_date($this->_spectacls);
        $this->_date_fin=SpectaclDAO::close_date($this->_spectacls);
        $l=SpectaclDAO::getAllLieu($this->_spectacls);
        $this->_lieu=array_values($l);
        $g=SpectaclDAO::getAllGroupes($this->_spectacls);
        $this->_groupe=array_values($g);
	}
  public function getDAO(){
    return $this->_dao;
  }
  public function getSpectacls(){
    return $this->_dao->getSpectacls();
  }
  public function getCompagnies(){
    return $this->_groupe;
  }
  public function getAllLieu(){
    return $this->_lieu;
  }

  public function getTitres(){
    return $this->_dao->getAllTitles($this->_spectacls);
  }
    /*************. of.  attribut. ********/
    public function ofLieu($place){
             return SpectaclDAO::OfLieu($this->_spectacls,$place);
    }

    public function ofDay($date){
    	return SpectaclDAO::ofDay($this->_spectacls,$date);
    }

    public function ofGroupe($groupeName){
    	return SpectaclDAO::OfGroupe($this->_spectacls,$groupeName);
    }

    //************grouped by**************//
    public function byLieu(){
    	return array_combine($this->_lieu,array_map(function($lieu){
    		return $this->ofLieu($lieu);
    	}, $this->_lieu));
    }

    public function byGroup(){
    	return array_combine($this->_groupe,array_map(function($groupe){
    		return $this->ofGroupe($groupe);
    	}, $this->_groupe));
    }

    protected function byDate(){
    	$dates=SpectaclDAO::getAllDates($this->_spectacls);
    	return array_combine($dates,
    		array_map(function($date){
    		      return $this->ofDay($date);
    	}, $dates));
    }
  public function affichage(){
  	echo $this->_date_debut->format('d-m-y');
  	echo $this->_date_fin->format('d-m-y');
  	print_r($this->_lieu);
  	print_r($this->_groupe);
  	print_r($this->_spectacls);
  }

  public function getDateDebut(){
    return $this->_date_debut;
  }
  public function getDateFin(){
    return $this->_date_fin;
  }

  
}


