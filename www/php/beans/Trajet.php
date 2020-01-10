<?php
/**
 * 
 */
class Trajet 
{
	private $_pointA;
	private $_pointB;
	private $_distance;//en km
	private $_duree;//en minute
	function __construct($a,$b,$distance,$duree)
	{
		$this->_pointA=$a;
		$this->_pointB=$b;
		$this->_distance=$distance;
		$this->_duree=$duree;
	}
	public function __get($prop){
		switch ($prop) {
			case 'pointA':
				# code...
			return $this->_pointA;
			break;
			case 'pointB':
				# code...
			return $this->_pointB;
			break;
			case 'distance':
				# code...
			return $this->_distance;
			break;
			case 'duree':
				# code...
			return $this->_duree;
			break;
			
			default:
				# code...
			throw new Exception("proprtie ".$prop." note found", 1);
			
			break;
		}
	}

	public function __set($prop,$val){
		switch ($prop) {
			case 'pointA':
				# code...
			$this->_pointA=$val;
			break;
			case 'pointB':
				# code...
			$this->_pointB=$val;
			break;
			case 'distance':
				# code...
			$this->_distance=$val;
			break;
			case 'duree':
				# code...
			$this->_duree=$val;
			break;
			
			default:
				# code...
			throw new Exception("proprtie ".$prop." note found", 1);
			break;
		}
	}
	public function equals($trajet){
		return (($this->_pointA==$trajet->_pointA) && ($this->_pointB==$trajet->_pointB))||(($this->_pointA==$trajet->_pointB) && ($this->_pointB==$trajet->_pointA));

	}

	public static function estimerRetard($heure){
		if($heure>17 && $heure<19)return 10;
		else return 0;
	}

}




/**
 * 
 */
class TrajetDAO 
{
	private static  $fileName;
	function __construct($fileName="ville.csv")
	{
		# code...
		self::$fileName=$fileName;
	}
	protected static function mapToTrajet($map){
		$trajet=new Trajet("","",0,"");
		foreach ($map as $prop => $val) {
			# code...
			$trajet->__set($prop,$val);
		}
		
		return $trajet;
	}
	
	public static function findAllTraject(){
		$csv=new Csv(self::$fileName);
		$map=$csv->getMap();
		$trajets=array();
		array_walk($map, function($e)use(&$trajets){
			$t=TrajetDAO::mapToTrajet($e);

			array_push($trajets,$t);
		});
		return $trajets;

	}

	public  static function trajectOf($pointA,$pointB){
		if($pointA==$pointB) return new Trajet($pointA,$pointB,0,0);
		else{
			$t=self::findAllTraject();
			array_walk($t, function($e)use($pointA,$pointB,&$res){
				$c1=(mb_strtolower($e->__get('pointA'))==mb_strtolower($pointA));
				$c2=(mb_strtolower($e->__get('pointB'))==mb_strtolower($pointB ));
				$c=$c1||$c2;

				if($c) $res=$e;
			});
			if(is_null($res))throw new Exception("no traject for this cities", 1);
			return $res;
		}
	}
	public  static function trajectBetween($spectacle1,$spectacle2){
		$p1=$spectacle1->getSalle()->getVillage();
		$p2=$spectacle2->getSalle()->getVillage();
		return self::trajectOf($p1,$p2);
	}
}

/**
 * 
 */
class DecisionModel
{
	private  $_panier;
	function __construct($panier=null)
	{
		# code...
		$this->_panier=$panier;
	}
	

	public static function inConflits($s1,$s2){
		if($s1==$s2)return false;
		if($s2->getDate()->format('d-m-Y')!=$s2->getDate()->format('d-m-Y'))return false;
		else{
			$ant=$s2;
			$post=$s1;
			if($s2->getDate()>$s1->getDate()){
				$ant=$s1;
				$post=$s2;
			}
			$d=new DateInterval("PT".Spectacl::DUREE."H");
		$date_ant=new Date($ant->getDate()->format('d-m-Y H:i'));//on ajoute la duree du spectacle
		$date_ant->add($d);

		
		//on ajoute le retard si il en existe
		$heure=(int)$date_ant->format('H');
		$retard=Trajet::estimerRetard($heure);
		$date_ant=$date_ant->add(new DateInterval("PT".$retard."M"));
        //on ajoute la duree du trajet
		$dureeTrajet=TrajetDAO::trajectBetween($s1,$s2)->__get('duree');
		$date_ant=$date_ant->add(new DateInterval("PT".$dureeTrajet."M"));
		$date_post=$post->getDate();
        return ($date_ant>$date_post);
    }

}
public static function allConflitsOf($spectacls){
	$spectaclsByDate=SpectaclDAO::byDate($spectacls);
	$listConflits=array();
	foreach ($spectaclsByDate as  $date => $s) {
		$s=array_values($s);
		if(count($s)>1){
			for ($i=0; $i <count($s) ; $i++) { 
           		# code...

				for ($j=$i+1; $j <count($s) ; $j++) { 
					$c=DecisionModel::inConflits($s[$i],$s[$j]);
					if($c) {	
						$listConflits[]=new Conflit($s[$i],$s[$j]);
					}
				}
			}
		}
	}
	return $listConflits;
}

public function getAllConflits(){
	$c= self::allConflitsOf($this->_panier->__get('spectacls'));
	for ($i=0; $i <count($c) ; $i++) { 
		# code...
		$con=$c[$i];
		for ($j=$i; $j <count($c) ; $j++) { 
			# code...
			if($con->equals($c[$j])) {
				unset($c[$j]);
				$c=array_values($c);
			}
		}
	}
	return $c;
}


}

/**
 * 
 */
class Conflit
{
	private $_spectacle1;
	private $_spectacle2;
	private $_ingnored;
	function __construct($s1,$s2)
	{
		# code...
		$this->_spectacle1=$s1;
		$this->_spectacle2=$s2;
		$this->_ingnored=false;
		
	}
    
    public function ignore(){
    	$this->_ingnored=true;
    }
    public function is_ignored(){
    	return $this->_ingnored;
    }
    public function getS1(){
    	return $this->_spectacle1;
    }
    public function getS2(){
    	return $this->_spectacle2;
    }
	public function equals($conflit){
		return ($this->_spectacle1==$conflit->_spectacle1 && $this->_spectacle2==$conflit->_spectacle2)||($this->_spectacle1==$conflit->_spectacle2 && $this->_spectacle2==$conflit->_spectacle1);
	}
}