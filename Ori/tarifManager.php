<?php
spl_autoload_register();


class tarifManager {
    
    private $_db;
	public function __construct()
	{
		$this->_db=connectionSingleton::getInstance()->dbh;
		$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//Configure un attribut du gestionnaire de base de données.
		//PDO::ATTR_ERRMODE : rapport d'erreurs. 
		//PDO::ERRMODE_EXCEPTION : émet une exception. 
		
	}
	
	
	public function getSais()
    {
        $requete=$this->_db->prepare('select * from tarif order by CODE_TARIF');
        try
        {
            $requete->execute();
            $result=$requete->fetchAll(PDO::FETCH_BOTH);
            $lesTarifs=array();
            foreach($result as $donnee)
            {
                $lesTarifs[]=new Tarif($donnee);
            }
            return $lesTarifs;
        }
        catch(error $e)
        {
            return $e;
        }
    }



	   public function getList()
   {    
     $requete=$this->_db->prepare('select * from tarif order by CODE_TARIF');
     $requete->execute();
     //PDOStatement::fetchAll() — Retourne un tableau contenant toutes les lignes du jeu d'enregistrements.
     //Le tableau représente chaque ligne comme soit un tableau de valeurs des colonnes, soit un objet avec des propriétés correspondant à chaque nom de colonne. 
     $result=$requete->fetchAll(PDO::FETCH_BOTH);
     return $result;
   }

    public function updateTarif($codetarif,$couleur,$prixbebe)
    {
        $requete=$this->_db->prepare('UPDATE tarif SET COULEUR = :couleur, PRIXLITBEBE = :prixbebe WHERE CODE_TARIF = :codetarif');
        $requete->bindValue(':couleur',$couleur);
        $requete->bindValue(':prixbebe',$prixbebe);
        $requete->bindValue(':codetarif',$codetarif);
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

    public function insertTarif($couleur,$prixbebe)
    {
        $requete=$this->_db->prepare('INSERT INTO tarif VALUES(0,:couleur,:prixbebe)');
        $requete->bindValue(':couleur',$couleur);
        $requete->bindValue(':prixbebe',$prixbebe);
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

