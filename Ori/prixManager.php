<?php
spl_autoload_register();
class PrixManager
{
	private $_db;
	public function __construct()
	{
		$this->_db=connectionSingleton::getInstance()->dbh;
		$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//Configure un attribut du gestionnaire de base de données.
		//PDO::ATTR_ERRMODE : rapport d'erreurs. 
		//PDO::ERRMODE_EXCEPTION : émet une exception. 
		
	}
	

		public function modifiePrix($idModele,$codeTarif,$prix)
        {
          
            $requete=$this->_db->prepare('select modifie_prix(:idModele,:codeTarif,:prix)');
            $requete->bindValue(':idModele',$idModele);
            $requete->bindValue(':codeTarif',$codeTarif);
            $requete->bindValue(':prix',$prix);
            try{
                       
			$requete->execute();
			$result=$requete->fetch();
			return $result;
			}
		catch(error $e)
		{
			return $e;
		}
            
            
        }
    public function checkDuplicate($idmodele,$codetarif)
    {
        $requete=$this->_db->prepare('select count(*) from prix where ID_MODELE = :idmodele and CODE_TARIF = :codetarif');
        $requete->bindValue(':idmodele',$idmodele);
        $requete->bindValue(':codetarif',$codetarif);
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
    public function getListById_Modele($idmodele)
    {
        $requete=$this->_db->prepare('select * from prix where ID_MODELE = :id_modele order by CODE_TARIF');
        $requete->bindValue(':id_modele',$idmodele);
        try
        {
            $requete->execute();
            $result=$requete->fetchAll(PDO::FETCH_BOTH);
            $lesPrix=array();
            foreach($result as $donnee)
            {
                $lesPrix[]=new Prix($donnee);
            }
            return $lesPrix;
        }
        catch(error $e)
        {
            return $e;
        }
    }


        public function getPrixByTarifModele($modele,$tarif)
	{
		
		$requete=$this->_db->prepare('select count(*) from prix where id_modele like :modele and code_tarif like :tarif');
		$requete->bindValue(':modele',$modele);
		$requete->bindValue(':tarif',$tarif);
               try{
			$requete->execute();
			$result=$requete->fetch();
			return $result;
			}
		catch(error $e)
		{
			return $e;
		}

	}
    public function modifierPrix($idmodele,$codetarif,$prix)
    {
        $requete=$this->_db->prepare('select modifie_prix(:idmodele,:codetarif,:prix)');
        $requete->bindValue(':idmodele',$idmodele);
        $requete->bindValue(':codetarif',$codetarif);
        $requete->bindValue(':prix',$prix);
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

    public function insertPrix($idmodele,$codetarif,$prix)
    {
        $requete=$this->_db->prepare('INSERT INTO prix VALUES(:idmodele,:codetarif,:prix)');
        $requete->bindValue(':idmodele',$idmodele);
        $requete->bindValue(':codetarif',$codetarif);
        $requete->bindValue(':prix',$prix);
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

	public function getPrix($modele,$tarif)
	{
		$requete=$this->_db->prepare('select * from prix where id_modele like :modele and code_tarif like :tarif');
		$requete->bindValue(':modele',$modele);
		$requete->bindValue(':tarif',$tarif);
        try{
            $requete->execute();
			$result = $requete->fetchAll(PDO::FETCH_BOTH);
			$lesPrix = array();
			

			foreach($result as $donnee)
				{
		
				$lesPrix[] = new Prix($donnee);
				
				}
			return $lesPrix;
			}
		catch(error $e)
		{
			return $e;
		}
	}
}
