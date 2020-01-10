<?php 
require "Festival.php";


/**
 * 
 */
class SpectaclFinance extends Spectacl
{
	public static $MARGE=0.1;//represente la marge des recette sur le total
	public static $TARIFS=array("P"=>15 , "R"=>10, "O"=>-10 ,"SJ"=>-15,"SA"=>-15,"E"=>0);//negatifs si depenses
	private $_billet;
	function __construct($titre,$date,$salle,$compagnie,$billet=array("P"=>0 , "R"=>0, "O"=>0 ,"SJ"=>0,"SA"=>0,"E"=>0))
	{
		# code...
		parent::__construct($titre,$date,$salle,$compagnie);
		$this->_billet=$billet;
	}

	public function setBillet($b){
		foreach ($this->_billet as $class => $nb) {
			# code...
			$this->_billet[$class]=(int) $b[$class];
		}
	}
    
    public function getBillet(){
    	return $this->_billet;
    }

	public function getNbBillet(){
           $r=array_reduce($this->_billet, function($acc,$e){
           	
           	$acc+=$e;
           	return $acc;
           
           });
           return $r;
	}

    public static function ofCategorieof($billet,$cat){
    	return $billet[$cat];
    }

	public function ofCategorie($cat){
		return SpectaclFinance::ofCategorieof($this->_billet,$cat);
	}

	
	public static function resultatOf($cat){
		if(SpectaclFinance::$TARIFS[$cat]>=0)return SpectaclFinance::$MARGE*SpectaclFinance::$TARIFS[$cat];
		else return (SpectaclFinance::$MARGE-1)*SpectaclFinance::$TARIFS[$cat];
	}

}

/**
 * 
 */
class SpectaclDAOFinance extends SpectaclDAO
{
	
	function __construct($name)
	{
		# code...
		parent::__construct($name);
	}

	public function map_to_spectacl($input){
		 $s=$input[array_key_first($input)]." ".$input['Heure'];
       $date=new Date($s);
       $salle=new Salle($input['Lieu'],$input['Village']);
       $spec= new SpectaclFinance($input['TitreSpectacle'],$date,$salle,$input['Compagnie']);
       $spec->setBillet($input);
       return $spec;
	}

	public static function agregate($list){
		$acc=array("P"=>0 , "R"=>0, "O"=>0 ,"SJ"=>0,"SA"=>0,"E"=>0);
		$r=array_reduce($list, function($acc,$e){
			foreach ($e->getBillet() as $cat => $nb) {
				# code...
				$acc[$cat]=$acc[$cat]+$nb;
			}
			return $acc;
		});
		return $r;
	}

	public static function ofCategorieIn($list,$cat){
		return array_reduce($list, function($acc,$e)use($cat){
			$acc+=$e->ofCategorie($cat);
			return $acc;
		});
	}

	public static function associate($map){
		return array_map(function($e){
			return SpectaclDAOFinance::agregate($e);
		}, $map);
	}

	public static function resultat($input){
		$tarifs=array_keys($input);
		$r=array_map(function($e)use($input){
			return $input[$e]*SpectaclFinance::resultatOf($e);
                  
		}, $tarifs);
		return array_combine($tarifs, $r);
	}

	public static function associateResultat($map){
		$asso=SpectaclDAOFinance::associate($map);
		return array_map(function($e){
			return SpectaclDAOFinance::resultat($e);
		}, $asso);
	}
}



/**
 * 
 */
class FestivalFinance extends Festival
{
	
	public function __construct()
	{
		 $this->_dao=new SpectaclDAOFinance(Festival::FILE_NAME);
         $this->_spectacls=$this->_dao->getSpectacls();
         parent::init();
         SpectaclDAO::sort($this->_spectacls);
	}

	public function BilletByDate(){
		return SpectaclDAOFinance::associateResultat($this->byDate());
	}
	public function BilletByLieu(){
		return SpectaclDAOFinance::associateResultat($this->byLieu());
	}

	public function BilletByGroup(){
		return SpectaclDAOFinance::associateResultat($this->byGroup());
	}

}







