<?php
spl_autoload_register();

class ChambreManager
{
  private $_db;
  public function __construct()
  {
    $this->_db=connectionSingleton::getInstance()->dbh;
    $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //Configure un attribut du gestionnaire de base de donn�es.
    //PDO::ATTR_ERRMODE : rapport d'erreurs. 
    //PDO::ERRMODE_EXCEPTION : �met une exception.     
  } 
  
  public function getListById_Modele($idModele)
  {    
    $requete=$this->_db->prepare('select * from chambre where id_modele like :id_Modele order by id_Modele');
    $requete->bindValue(':id_Modele',$idModele);
    try
    { 
      $requete->execute();
      $result=$requete->fetchAll(PDO::FETCH_BOTH);
      $lesChambres=array();
      foreach($result as $donnee)
      {		
        $lesChambres[]=new Chambre($donnee);				
      }
      return $lesChambres;
    }
    catch(error $e)
    {
      return $e;
    }
  }  
  
  public function getList()
  {    
    $requete=$this->_db->prepare('select * from chambre order by ETAGE,NUMERO');
    try
    { 
      $requete->execute();
      $result=$requete->fetchAll(PDO::FETCH_BOTH);
      $lesChambres=array();
      foreach($result as $donnee)
      {		
        $lesChambres[] = new Chambre($donnee);
      }
      return $lesChambres;
    }
    catch(error $e)
    {
      return $e;
    }
  }
  
  public function getListChambresReservableById_Modele($idModele, $dateArr, $dateDep, $bool_litbebe)
  {    
    $requete=$this->_db->prepare('select * from chambre b where chambre_reservable(b.numero,:dateArr,:dateDep) and id_modele = :idModele and litbebe = :litbebe order by numero');
    $requete->bindValue(':idModele',$idModele);
    $requete->bindValue(':dateArr',$dateArr);
    $requete->bindValue(':dateDep',$dateDep);
    $requete->bindValue(':litbebe',$bool_litbebe);
    try
    { 
      $requete->execute();
      $result=$requete->fetchAll(PDO::FETCH_BOTH);
      $lesChambres=array();
      foreach($result as $donnee)
      {		
        $lesChambres[]=new Chambre($donnee);				
      }
      return $lesChambres;
    }
    catch(error $e)
    {
      return $e;
    }
  }
  
    public function getCountChambres()
  {    
    $requete=$this->_db->prepare('select count(*) from chambre ');
    try
    { 
      $requete->execute();
      $result=$requete->fetch();
      return $result;
    }
    catch(error $e)
    {
      return $e;
    }
  }
  
  public function getCountChambresLibres()
  {    
    $requete=$this->_db->prepare('SELECT COUNT(*) FROM `disponibilite` WHERE datej = CURDATE()');
    try
    { 
      $requete->execute();
      $result=$requete->fetch();
      return $result;
    }
    catch(error $e)
    {
      return $e;
    }
  }
  
  public function insertChambre($numero, $idmodele, $etage, $litbebe)
  {
    $requete=$this->_db->prepare('INSERT INTO chambre VALUES(:numero,:idmodele,:etage, :litbebe)');
    $requete->bindValue(':numero',$numero);
    $requete->bindValue(':idmodele',$idmodele);
    $requete->bindValue(':etage',$etage);
    $requete->bindValue(':litbebe',$litbebe);
    try
    {    
      $result = $requete->execute();
      return $result;
    }
    catch(error $e)
    {
      return $e;
    }
  }    
  
  public function modifChambre($numero, $idmodele, $etage, $litbebe)
  {
    $requete=$this->_db->prepare('UPDATE chambre SET ID_MODELE = :idmodele, ETAGE = :etage, LITBEBE = :litbebe WHERE NUMERO = :numero ');
    $requete->bindValue(':numero',$numero);
    $requete->bindValue(':idmodele',$idmodele);
    $requete->bindValue(':etage',$etage);
    $requete->bindValue(':litbebe',$litbebe);
    try
    {    
      $result = $requete->execute();
      return $result;
    }
    catch(error $e)
    {
      return $e;
    }
  }  
}
?>