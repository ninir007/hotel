<?php
spl_autoload_register();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ModeleManager
 *
 * @author francoise
 */
class ModeleManager {
    //put your code here
    private $_db;
	public function __construct()
	{
		$this->_db=connectionSingleton::getInstance()->dbh;
		$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//Configure un attribut du gestionnaire de base de données.
		//PDO::ATTR_ERRMODE : rapport d'erreurs. 
		//PDO::ERRMODE_EXCEPTION : émet une exception. 
		
	}
	
	
	public function getListObj()
    {
        $requete=$this->_db->prepare('select * from modele order by id_Modele');
        try
        {
            $requete->execute();
            $result=$requete->fetchAll(PDO::FETCH_BOTH);
            $lesModeles=array();
            foreach($result as $donnee)
            {
                $lesModeles[]=new Modele($donnee);
            }
            return $lesModeles;
        }
        catch(error $e)
        {
            return $e;
        }
    }
	


		public function getList()
	{
		
		$requete=$this->_db->prepare('select * from modele order by id_Modele');
		$requete->execute();
		//PDOStatement::fetchAll() — Retourne un tableau contenant toutes les lignes du jeu d'enregistrements.
                 //Le tableau représente chaque ligne comme soit un tableau de valeurs des colonnes, soit un objet avec des propriétés correspondant à chaque nom de colonne. 
		$result=$requete->fetchAll(PDO::FETCH_BOTH);
		return $result;
	}
    public function insertModele($bain, $douche, $wc, $lit1p, $lit2p)
    {
        $requete=$this->_db->prepare('INSERT INTO modele VALUES(NULL,:bain, :douche, :wc, :lit2p, :lit1p)');
        $requete->bindValue(':bain',$bain);
        $requete->bindValue(':douche',$douche);
        $requete->bindValue(':wc',$wc);
        $requete->bindValue(':lit1p',$lit1p);
        $requete->bindValue(':lit2p',$lit2p);
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

    public function modifModele($idmodele, $bain, $douche, $wc, $lit1p, $lit2p)
    {
        $requete=$this->_db->prepare('UPDATE modele SET BAIN = :bain, DOUCHE = :douche, WC = :wc, NBRELIT2 = :lit2p, NBRELIT1 = :lit1p WHERE ID_MODELE = :idmodele');
        $requete->bindValue(':idmodele',$idmodele);
        $requete->bindValue(':bain',$bain);
        $requete->bindValue(':douche',$douche);
        $requete->bindValue(':wc',$wc);
        $requete->bindValue(':lit1p',$lit1p);
        $requete->bindValue(':lit2p',$lit2p);
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