<?php 
/**
 * 
 */
class Personne implements JsonSerializable,serializable
{
	private $_nom;
	private $_prenom;
	private $_date_naissance;
	private $_tel;
	private $_mail;

	function __construct($nom,$prenom,$date)
	{
		# code...
		$this->_nom=$nom;
		$this->_prenom=$prenom;
		$this->_date_naissance=$date;
	}
    
    public function jsonSerialize(){
        return 
        [
            'nom'   => $this->_nom,
            'prenom'=>$this->_prenom,
            'date_naissance' => $this->_date_naissance->format("d-m-Y H:i"),
            'mail'=>$this->_mail,
            'tel'=>$this->_tel
        ];
    }

    public function serialize(){
        return serialize($this->jsonSerialize());
    }

    public function unserialize($str){
      
    }
    
    function getNom(){
    	return $this->_nom;
    }
    
    function getPrenom(){
    	return $this->_prenom;
    }

    public function setNom($nom){
    	return $this->_nom=$nom;
    }
    public function setPrenom($prenom){
    	$this->_prenom=$prenom;
    }
    public function setDateNaissance($date){
    	$this->_date_naissance=$date;
    }
    public function setTel($tel){
    	$this->_tel=$tel;
    }
    public function setMail($mail){
    	$this->_mail=$mail;
    }

    public function getAge(){
        return $this->_date_naissance->diff(new DateTime("now"))->y;
    }
}

