<?php
require ('Trajet.php');

/**
 * class::definit la categorie des des tarifs 
 *parametre:   code ::un entier designant le cose de la categorie
*              designation::une description d'une categorie
                destineTo::à qui la categorie est detinée par age
 */
class Categorie implements JsonSerializable{

    private $_code;
    private $_designation;
    private $_destineTo;

    //constructeur ::cat designe le code de la categorie
    public function __construct($cat){
        $this->_designation=Categorie::DesignationOf($cat);
        $this->_code=$cat;
        $this->_destineTo=Categorie::Destination($cat);
    }

    //afecter une designation selon le code
    private static function DesignationOf($cat){
        switch ($cat) {
            case 1:
                # code...
            return "tarif plein"; 
            break;
            case 2:
                # code...
            return "tarif reduit"; 
            break;

            case 3:
                # code...
            return "tarif enfant"; 
            break;
            default:
                # code...
            throw new Exception("la categorie en entrée n'existe pas", 1);
            
            break;
        }
    }
     public function classOf(){
        switch ($this->_categorie) {
            case 1:
                # code...
            return "P";
                break;
            case 1:
                # code...
            return "R";
                break;
            case 3:
                # code...
            return "E";
                break;
            default:
                # code...
            throw new Exception("Error Categorie", 1);
            
                break;
        }
     }
    //obtenire à qui la categorie est destinée à partir du code
    private static function Destination($cat){
        switch ($cat) {
            case 1:
                # code...
            return "plus de 26 ans"; 
            break;
            case 2:
                # code...
            return "-26 ans,chomeurs et handicape"; 
            break;

            case 3:
                # code...
            return "-12 ans"; 
            break;
            default:
                # code...
            throw new Exception("la categorie en entrée n'existe pas", 1);
            
            break;
        }
    }
    
    // getters
    public function __get($prop){
        switch($prop){
            case 'code':
                    # code...
            return $this->_code;
            break;
            case 'designation':
                    # code...
            return $this->_designation;
            break;
            case 'destination':
                    # code...
            return $this->_destineTo;
            break;
            default:
            throw new Exception("la propriete '".$prop."' n'existe pas");
        }
    }
    
    //setters
    public function __set($prop,$val){
        switch($prop){
            case 'code':
                    # code...
            $this->_code=$val;
            break;
            case 'designation':
                    # code...
            $this->_designation=$val;
            break;
            default:
            throw new Exception("la propriete '".$prop."' n'existe pas");
        }
    }
    
    //creer un tableau de categories à partire d'un tableau de codes
    public static function categoriesOf($codes){
        return array_map(function($code){
            return new Categorie($code);
        }, $codes);
    }

    //toString
    public function __tostring(){
        return "code: ".$this->_code."des: ".$this->_designation;
    }

    public function jsonSerialize(){
        return [
            'code'=>$this->_code,
            'designation'=>$this->_designation,
            'destineTo'=>$this->_destineTo
        ];
    }
}


/*
*la class Tarif designant un tarif
*
*/

class  Tarif implements JsonSerializable{
    // categorie designe la categorie du tarif
	private $_categorie;
    //montant :: le montant associé au tarif obtenu à partir de sa categorie
    private $_montant;
    //offert ::un booleen pour dire si le billet est offert ou non vu que un billet offert peut etre à tarif reduit comme à plein tarif
    private $_offert;

    function __construct($categorie,$offert=false){
      $this->_categorie=$categorie;
      $this->_offert=$offert;
      $this->_montant=Tarif::montantOf($this->_categorie);
     }
    
    public function classOf(){
        if($this->_offert)return "O";
        else return $this->_categorie->classOf();
     
    }
   //obtenir un montant associé à une categorie
    public static function montantOf($categorie){
        $code=$categorie->__get('code');
        switch ($code) {
            case 1:
                # code...
            return 15;
            break;
            case 2:
                # code...
            return 10;
            break;
            case 3:
                # code...
            return 0;
            break;
            default:
                # code...
            throw new Exception("categorie not found exception ", 1);

            break;
        }
    }

    //params::categories =>un tableau de categories 
    //return::le tableau de tarifs assicié au tableaux de categories
    public static function TarifsOf($categories){
     return array_map(function($cat){
        return new Tarif($cat);
     }, $categories);
    }
  
    function __get($prop){
     switch ($prop) {
        case 'montant':
        return $this->_montant;
        break;

        case 'categorie':
        return $this->_categorie;
        break;
        case 'is_offert':
        return $this->_offert;
        break;
        default:
        throw new Exception("propretie ".$prop." not found", 1);

        break;
        }
    }

    function __set($prop,$val){
      switch ($prop) {
        case 'montant':
        $this->_montant=$val;
        break;

        case 'categorie':
        $this->_categorie=$val;
        break;
        case 'offert':
        $this->_offert=$val;
        break;
        default:
        throw new Exception("propretie ".$prop." not found", 1);

        break;
       }
    }

    //pour calculer le montant avec remise
    public function realMonatnt(){
        if($this->_offert) return 0;
       else return Tarif::montantOf($this->_categorie);
     }

    //pour calculer le montant sans remise
    public function montantSansRemise(){
        return  Tarif::montantOf($this->_categorie);
    }


    //calculer le total avec des remise
    public static function totalOf($tarifs){
        return array_reduce($tarifs, function($acc,$tarif){
            $acc+=$tarif->realMonatnt();
            return $acc;
        });
    }
    //total without remise
    public static function totalOfSansRemise($tarifs){
        return array_reduce($tarifs, function($acc,$tarif){
            $acc+=$tarif->montantSansRemise();
            return $acc;
        });
    }

    public function __tostring(){
        return "categorie: ".$this->_categorie->__tostring()."montant: ".$this->_montant;
    }

    public function jsonSerialize(){
        return [
        'categorie'=>$this->_categorie->jsonSerialize(),
        'montant'=>$this->_montant,
        'offert'=>$this->_offert
        ];
    }
}


class Reservation implements JsonSerializable
{
	protected $_reference;//c est le numero de la reservation
	protected $_spectacl;
    protected $_montant;

    function __construct($spectacl)
    {
		# code...	
      $this->_spectacl=$spectacl;
  }

function __get($propretie){
        switch ($propretie) {
          case 'reference':
        			# code...
          return $this->_reference;
          break;
          case 'spectacle':
        			# code...
          return $this->_spectacl;
          break;
          case 'montant':
        			# code...
          return $this->_montant;
          break;
          default:
        			# code...
          throw new Exception("probretie".$propretie."is not defined", 1);
          break;
       }
}

function __set($propretie,$value){
   switch ($propretie) {
      case 'reference':
    			# code...
      $this->_reference=$value;
      break;
      case 'spectacle':
    			# code...
      $this->_spectacl=$value;
      break;
      case 'montant':
      $this->_montant=$value;
      break; 
      default:
    			# code...
      throw new Exception("probretie".$propretie."is not defined", 1);
      break;
  }
}

public function jsonSerialize(){
    return [
       'reference'=>$this->_reference,
       'spectacle'=>$this->_spectacl->jsonSerialize(),
       'montant'=>$this->_montant
    ];
 }

 

}

/**
 * 
 */
class ReservationMultiple extends Reservation implements Countable,JsonSerializable
{
    
    private $_nb_billet;
    private $_tarifs;
    

    function __construct($spectacle,$codes=[1])
    {
        parent::__construct($spectacle);
        $this->_tarifs=array();
        $this->_nb_billet=count($codes);
        $this->setTarifs($codes);
    }

    public function getClasseOfbillet(){
        $t=array();
        array_walk($this->_tarifs, function($e)use($t){
            if(in_array(array_keys($t), $e->classOf())) $t[$e->classOf()]++;
            else $t[$e->classOf()]=1;
        });
        return $t;
    }
    
    public function jsonSerialize(){
        return array_merge(parent::jsonSerialize(),['nb_billet'=>$this->_nb_billet,"tarifs"=>array_map(function($tarif){
            return $tarif->jsonSerialize();
        }, $this->_tarifs)]);
    }
    
    function __get($propretie){
        switch ($propretie) {
            case 'nb_billet':
                # code...
            return $this->_nb_billet;
            break;
            case 'tarifs':
                # code...
            return $this->_tarifs;
            break;
            
            default:
                # code...
            return parent::__get($propretie);

        }
    }


    function __set($propretie,$value){
        switch ($propretie) {
            case 'nb_billet':
                # code...
            if($value>Panier::MAX) throw new Exception("imposible de reserver plus de 12 billet", 1);
            
            $this->_nb_billet=$value;
            break;
            case 'tarifs':
                # code...
            $this->_tarifs=$value;
            break;
            
            default:
                # code...
            parent::__set($propretie,$value);

        }
    }
    
    public static function arrayCodes($plein=1,$reduit=0,$enfant=0){
        $cplein=array_fill(0, $plein, 1);
        $creduit=array_fill(0, $reduit, 2);
        $cenfant=array_fill(0, $enfant, 3);
        $codes=array_merge(array_merge($cplein,$creduit),$cenfant);
        $categories=array_values($codes);
        return $codes;
    }

    function setTarifs($codes=[1]){
        if(count($codes)<=Panier::MAX){
            $categories=Categorie::categoriesOf($codes);
            $this->_tarifs=Tarif::TarifsOf($categories);
            $this->_nb_billet=count($codes);
        }
        else{
            throw new Exception("vous ne pouvez pas reserver plus que ".Panier::MAX."billets", 1);
            
        }
    }

     //pour deux billets payés le client pourra benificier d'un billet pour enfant

    public function forChildren(){
        return count($this);
    }
    

    //calculer le totale de la commande avec remise  
    public function getTotal(){
      return Tarif::totalOf($this->_tarifs);
     }

   public function getTotalSansRemise(){
    return Tarif::totalOfSansRemise($this->_tarifs);
   }

    public function count(){
        return  count(array_filter($this->_tarifs,function($t){
            $categorie=$t->__get('categorie')->__get('code');
            return $categorie==1 || $categorie==2;
        }));
    } 
    
    public function count_all(){
        return count($this->_tarifs);
    }
    public function byTarif(){
        return ReservationMultiple::nbTarifs($this->_tarifs);
    }

//pour offrir un billet à une reservation

    public static function nbTarifs($tarifs){
        $c=range(1, 3);
        return array_combine($c, array_map(function($code)use($tarifs){
            return count(array_filter($tarifs,function($t)use($code){
                return $code==$t->__get('categorie')->__get('code');
            }));
        }, $c));
    }

    public function allBillet(){
        return count($this->_tarifs);
     }
}

/*
*    le pannier class
*/

class Panier implements Countable,JsonSerializable {
    //nom du fichier ou on enregistre les reservation
    public const MAX=12;
    private $_client;
    private $_reservations;
    private $_total;
    private $_date;
    private $_conflits;

    public function __construct($spectacles=null,$client=null){
        if(!is_null($spectacles)){
            if(count($spectacles)<Panier::MAX){
                $this->_reservations=array_map(function($spectacle){
                    return new ReservationMultiple($spectacle);
                }, $spectacles);
                $this->_date=new DateTime('now');
                $this->_client=$client;
            }
            else throw new Exception("le nombre max de reservation est : ".MAX, 1);
        }
        else{
            $this->_reservations=$spectacles;

        }
        $this->init_conflits();
     }

     public function init_conflits(){
        if(!$this->estVide()){
            $spec=array_map(function($e){
           return $e->__get('spectacle');
        }, $this->__get('reservations'));
        $this->_conflits=DecisionModel::allConflitsOf($spec);
        }
        
     }

     public function ignore_conflit($con){
       foreach ($this->_conflits as $key => $value) {
           # code...
        if($con->equals($value)) $value->ignore();
       }
     }

     public function ignore_all(){
        foreach ($this->_conflits as $value) {
            # code...
            $value->ignore();
        }
     }

     public function ready(){
        foreach ($this->_conflits as $key => $value) {
            # code...
            if(!$value->is_ignored())return false;
        }
        return true;
     }


public function jsonSerialize(){
    return ['client'=>"client",
    'total'=>$this->_total,
    'reservations'=>array_map(function($reservation){
        return $reservation->jsonSerialize();
    }, $this->_reservations)
];
  }

    public function __get($prop){
        switch ($prop) {
            case 'reservations':
            return $this->_reservations;
            break;
            case 'date':
            return $this->_date;
            break;
            case 'total':
            return $this->_total;
            break;
            case 'client':
            return $this->_client;
            break;

            case 'conflits':
            return $this->_conflits;
            break;
            
            default:
                # code...
            throw new Exception("propretie not found exception", 1);
            
            break;
        }
    }
    public function __set($prop,$val){
        switch ($prop) {
            case 'reservations':
            $this->_reservations=$val;
            break;
            case 'date':
            $this->_date=$val;
            break;
            case 'total':
            $this->_total=$val;
            break;
            case 'client':
            $this->_client=$val;
            break;
            default:
                # code...
            throw new Exception("propretie note found exception", 1);
            
            break;
        }
    }


    static function in_pannier($spectacle,$pannier){
        if (!$pannier->estVide()) {
            if(!is_null($spectacle)){
               $r=array_map(function($res){
                return $res->__get('spectacle');
               }, $pannier->__get('reservations'));
               return in_array($spectacle, $r);
            }
            else return true;

        }
        else return false;

    }

    function contains($spectacle){
        return Panier::in_pannier($spectacle,$this);
    }

    public function count(){
        if(!is_null($this->__get('reservations'))){
            return array_reduce($this->__get('reservations'), function($acc,$reservation){
                $acc+=count($reservation);
                return $acc;
            });
        }
        else return 0;

    }

    public function count_all(){
        return array_reduce($this->_reservations, function($acc,$e){
            $acc+=$e->count_all();
            return $acc;
        });
    }

    public function add($reservation){
        if(!$this->contains($reservation->__get('spectacle'))){
            if($this->count()<=Panier::MAX){
                if($this->count()+count($reservation)<=Panier::MAX){
                    if($this->estVide())$this->_reservations[]=$reservation;
                    else array_push($this->_reservations,$reservation);
                    $this->init_conflits();
                }
                else{
                    throw new Exception("vous ne pouvez reservé que ".((Panier::MAX)-count($this)), 1);

                }

            }
            else throw new Exception("vous avez dejà reservé votre quota ".Panier::MAX, 1);
        }
        else throw new Exception("vous avez déja une reservation pour ce spectacle", 1);


    }

    public function estVide(){
        return (is_null($this->_reservations))||(count($this)==0);
    }
    public function remove($reservation){
        $toremove=$reservation->__get('spectacle');
        if($this->contains($toremove)){
            $this->_reservations=array_filter($this->_reservations,function($res)use($toremove){
                return $toremove!=$res->__get('spectacle');
            });

            $this->init_conflits();
        }
        else throw new Exception("vous essayez de supprimer une reservation qui n'existe pas", 1);

    }


    public static function savePanier($panier){
     $_SESSION['panier']=serialize($panier);
 }

 public function save(){
   Panier::savePanier($this);
}


public static function panierOfSession(){

    if (isset($_SESSION['panier'])) {
        $panier=unserialize($_SESSION['panier']);
    }
    else {
        $panier=new Panier();
        $_SESSION['panier']=serialize($panier);
}
return $panier;
}

public static function updateTarifs($panier,$spectacle,$codes){
     if($panier->contains($spectacle)){
            foreach ($panier->__get('reservations') as $r) { 
                if($r->__get('spectacle')==$spectacle) {
                    $r->setTarifs($codes);
                    return 1;
                }

            }
     }
}
public function update($spectacle,$codes){
    Panier::updateTarifs($this,$spectacle,$codes);
}
public function toOffre(){
    return Panier::count_billets_to_offre($this);
}
public static function count_billets_to_offre($panier){
         $c=count($panier);
         if($c>10) return 2;
         else if($c>5)return 1;
         else return 0;
}

public function offrir($nb_billet){
    if($nb_billet<count($this)){
        $nb_offert=0;
       foreach ($this->__get('reservations') as $r) {
           # code...
        foreach ($r->__get('tarifs') as $t) {
            # code...
            if($t->__get('categorie')->__get('code')==2){
                $t->__set('offert',true);
                $t->__set('montant',0);
                $nb_offert++;
                if($nb_offert==$nb_billet) return;

            }
        }
        }

        if($nb_offert<$nb_billet){
              foreach ($this->__get('reservations') as $r) {
           # code...
        foreach ($r->__get('tarifs') as $t) {
            # code...
            if($t->__get('categorie')->__get('code')==1){
                $t->__set('offert',true);
                $t->__set('montant',0);
                $nb_offert++;
                if($nb_offert==$nb_billet) return;

            }
        }
        }
        }
       
    }
}

public function validerOffre(){
    $this->offrir($this->toOffre());
}

//ici pour la validation des conflit




    //calculer le totale de la commande avec remise  
    public function gettotal(){
        if($this->estVide()) return 0;
      return array_reduce($this->_reservations, function($acc,$r){
              $acc+=$r->getTotal();
              return $acc;
      });
     }

   public function gettotalSansRemise(){
    if($this->estVide()) return 0;
     return array_reduce($this->_reservations, function($acc,$r){
              $acc+=$r->getTotalSansRemise();
              return $acc;
      });
   }
//mise à jour du fichier csv
   public function updateData(){
              
   }

}

?>






