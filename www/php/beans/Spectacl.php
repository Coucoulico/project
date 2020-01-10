<?php
require('Date.php');
require('Salle.php');
/**
 * la classe spectacle
 */
class Spectacl implements JsonSerializable
{
	protected static $PATHIMAGE="/images/spectacles/";
  public const DUREE=2;//la duree de tous les spectacle est estiumé à 2h
	protected $_titre;
	protected $_date;
	protected $_salle;
	protected $_compagnie;
	protected $_reservations;
	protected $_image;
	function __construct($titre,$date,$salle,$compagnie)
	{
		# code...

		$this->_titre=$titre;
		$this->_date=$date;
		$this->_salle=$salle;
		$this->_compagnie=$compagnie;
		$this->initImage();

	}

	public function getDescription(){
		$content=file_get_contents("../../data/spectacleDescription.xml");
		$texts=new SimpleXMLElement($content);
		$titre=implode("", array_map('trim',explode(" ", $this->_titre)));
		$titre=mb_strtolower($titre);
		foreach ($texts as $text) {
			# code...
			$t=implode("", array_map('trim',explode(" ",$text->{'titre'})));
			$t=mb_strtolower($t);
			if($t==$titre)return strval($text->{'description'});
		}
		

	}

	static function searchImage($s,$from){
	$path=$from;
     $titre ="#".$s->getTitre()."#";
     foreach (glob($path."*") as $fileName) {
     	# code...
     	if(preg_match(implode("", explode(" ",$titre)), $fileName)) {
     		return basename($fileName);
     	}
     }



}
    public function getImage(){
    	return $this->_image;
    }

    public function initImage(){
          $this->_image=Spectacl::$PATHIMAGE.Spectacl::searchImage($this,$_SERVER['DOCUMENT_ROOT'].Spectacl::$PATHIMAGE);
    }
	public function getDate(){
		return $this->_date;
	}
	public function getSalle(){
		return $this->_salle;
	}
	public function getCompagnie(){
		return $this->_compagnie;
	}
    
    public function getTitre(){
		return $this->_titre;
	}
	public function toString(){
		return "</br>titre = ".$this->_titre."</br>date =".($this->_date->format('d-m-Y H:i'))."</br>lieu = ".$this->_salle->getNom()."</br>village = ".$this->_salle->getVillage()."</br>companie = ".$this->_compagnie;
	}

	public function jsonSerialize(){
		return 
        [
            'titre'   => $this->_titre,
            'date' => $this->_date->JsonSerialize(),
            'salle'=>$this->_salle->jsonSerialize(),
            'compagnie'=>trim($this->_compagnie)
            
        ];
	}

}

class SpectaclDAO{
   protected $_fileName;
   protected $_csv;
   protected $_spectals;
   
    function __construct($name){
    
    $this->_spectals=array();
   	$this->_fileName=$name;
   	$this->_csv=new Csv($name);
   	$m=$this->_csv->getMap();
    $this->getAllSpectacls($m);
   }

   public function getAllSpectacls($spectacls){
   	foreach ($spectacls as $map) {
   		# code...
        array_push($this->_spectals, $this->map_to_spectacl($map));
   	  }
    }

   public function map_to_spectacl($input){

       $s=$input[array_key_first($input)]." ".$input['Heure'];
       $date=new Date($s);
       $salle=new Salle($input['Lieu'],$input['Village']);
       return new Spectacl($input['TitreSpectacle'],$date,$salle,$input['Compagnie']);
     }
    
    public function getSpectacls(){
      return $this->_spectals;
    }
   public function affichage(){
     foreach ($this->_spectals as $s) {
       # code...
      echo ($s->toString());
     }
   }

   public static function getAllDates($spectacls){
      $dates=array();
      foreach ($spectacls as $s) {
        # code...
        $d=new Date($s->getDate()->format('d-m-Y'));
        if(!in_array($d, $dates)) array_push($dates, $d);

      }
      return $dates;
   }
   
   public static function getAllSalles($spectacls){
        $places = array();
        foreach ($spectacls as $s) {
          # code...
          array_push($places, $s->getSalle());
        }
        return array_unique($places);
   }
   
   public static function getAllGroupes($spectacls){
    $Compagnies=array();
    foreach ($spectacls as $s) {
      # code...
      array_push($Compagnies, $s->getCompagnie());

    }
    return array_unique(array_map('strtolower',$Compagnies));
    
   }

   public static function getAllLieu($spectacls){
    $lieux = array();
    foreach ($spectacls as $s) {
      array_push($lieux, $s->getSalle()->getVillage());
   }
    return array_unique(array_map('strtolower',$lieux));

   }

   public static function getAllTitles($spectacls){
    $titles=array();
    foreach ($spectacls as $s) {
      # code...
      array_push($titles, $s->getTitre());

    }
    return array_unique(array_map('strtolower',$titles));
   }

   public static function ofDay($spectacls,$date){
    return array_filter($spectacls,function($e)use ($date){
      return ($e->getDate()->format('d-m-Y')===$date->format('d-m-Y'));
    });
   }

   public static function ofLieu($spectacls,$lieu){
    return array_filter($spectacls,function($e)use($lieu){
           $s1=mb_strtolower($e->getSalle()->getVillage());
           $s2=mb_strtolower($lieu);
           return ($s1==$s2);
    });
   }

   public static function ofGroupe($spectacls,$compagnie){
    return array_filter($spectacls,function($e)use($compagnie){
           $s1=mb_strtolower($e->getCompagnie());
           $s2=mb_strtolower($compagnie);
           return $s1==$s2;
    });
   }
   public static function ofTitle($spectacls,$titre){
    return array_filter($spectacls,function($e)use($titre){
           $s1=mb_strtolower($e->getTitre());
           $s2=mb_strtolower($titre);
           return $s1==$s2;
    
   });
 }
   
   public static function byDate($spectacls){
    $dates=SpectaclDAO::getAllDates($spectacls);
      return array_combine($dates,
        array_map(function($date)use($spectacls){
              return SpectaclDAO::ofDay($spectacls,$date);
      }, $dates));
   }


   public static function byGroup($spectacls){
    $groupes=SpectaclDAO::getAllGroupes($spectacls);
        return array_combine($groupes, array_map(function($groupe)use($spectacls){
          return SpectaclDAO::ofGroupe($spectacls,$groupe);
        }, $groupes));
    }

    public static function byLieu($spectacls){
      $lieu=SpectaclDAO::getAllLieu($spectacls);
      return array_combine($lieu,array_map(function($lieu)use($spectacls){
        return SpectaclDAO::ofLieu($spectacls,$lieu);
      }, $lieu));
    }

    public static function byTitle($spectacls){
      $titres=SpectaclDAO::getAllTitles($spectacls);
        return array_combine($groupes, array_map(function($titre)use($spectacls){
          return SpectaclDAO::ofTitle($spectacls,$titre);
        }, $titres));
    }
    
   public static function open_date($spectacls){
    return min(SpectaclDAO::getAllDates($spectacls));
   }

   public static function close_date($spectacls){
    return max(SpectaclDAO::getAllDates($spectacls));
   }

   public static function sort($spectacls){
    usort($spectacls, function($a,$b){
      if ($a->getDate()==$b->getDate())return 0;
        else return ($a->getDate()<$b->getDate())? -1:1;
    });
  }
 }

