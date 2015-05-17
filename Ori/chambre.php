<?php
class Chambre 
{
  private $_numero;
  private $_id_modele;
  private $_etage;
  private $_litbebe;

  public function __construct(array $donnees)
  {
    $this->hydrate($donnees);
  }
  
  public function getNumero()
  {
    return  $this->_numero;
  }

  public function getId_Modele()
  {
    return  $this->_id_modele;
  }

  public function getEtage()
  {
    return  $this->_etage;
  }
  
  public function getLitbebe()
  {
    return  $this->_litbebe;
  }
  
  public function setNumero($numero)
  {
    $this->_numero = $numero;
  }

  public function setId_modele($idmodele)
  {
    $this->_id_modele = $idmodele;
  }

  public function setEtage($etage)
  {
    $this->_etage = $etage;
  }
  
  public function setLitbebe($litbebe)
  {
    $this->_litbebe = $litbebe;
  }

  function hydrate(array $donnees)
  {
    foreach ($donnees as $key => $value)
    {
     $method='set'.ucfirst($key);
     if(method_exists($this,$method))
       $this->$method($value);				
    }
  }
}
