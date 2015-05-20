<?php
class calendrierManager {
    
    private $_db;
	public function __construct()
	{
		$this->_db=connectionSingleton::getInstance()->dbh;
		$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//Configure un attribut du gestionnaire de base de données.
		//PDO::ATTR_ERRMODE : rapport d'erreurs. 
		//PDO::ERRMODE_EXCEPTION : émet une exception. 
		
	}
	
	
	public function getList()
	{
		
		$requete=$this->_db->prepare('select * from calendrier where dateJ > now() order by dateJ');
		
                try {
                    
               
                    
                $requete->execute();
		//PDOStatement::fetchAll() — Retourne un tableau contenant toutes les lignes du jeu d'enregistrements.
                 //Le tableau représente chaque ligne comme soit un tableau de valeurs des colonnes, soit un objet avec des propriétés correspondant à chaque nom de colonne. 
		$result=$requete->fetchAll(PDO::FETCH_BOTH);
                $lesJours=array();
			foreach($result as $donnee)
				{
		
				$lesJours[]=new calendrier($donnee);
				
				}
			return $lesJours;
			}
		catch(error $e)
		{
			return $e;
		}

		
	}

	public function ajouterJours($dateDebut,$dateFin,$codeTarif,$nbLitsBebe)
        {
          
           
          
            $requete=$this->_db->prepare('select ajoutjours(:dateDebut,:dateFin,:codeTarif,:nbLitsBebe)');
            $requete->bindValue(':dateDebut',$dateDebut);
            $requete->bindValue(':dateFin',$dateFin);
            $requete->bindValue(':codeTarif',$codeTarif);
            $requete->bindValue(':nbLitsBebe',$nbLitsBebe);
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
    public function reservable($chambre,$dateDebut,$dateFin)
    {



        $requete=$this->_db->prepare('select chambre_reservable(:chambre,:dateDebut,:dateFin)');
        $requete->bindValue(':dateDebut',$dateDebut);
        $requete->bindValue(':dateFin',$dateFin);
        $requete->bindValue(':chambre',$chambre);
        try{

            $requete->execute();
            $result=$requete->fetch(PDO::FETCH_BOTH);
            return $result;
        }
        catch(error $e)
        {
            return $e;
        }


    }

    public function reserver($noclient,$dateDebut,$dateFin)
    {



        $requete=$this->_db->prepare('select ajout_reservation(:noclient,:dateDebut,:dateFin)');
        $requete->bindValue(':dateDebut',$dateDebut);
        $requete->bindValue(':dateFin',$dateFin);
        $requete->bindValue(':noclient',$noclient);
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
    public function getCodeTarifBySejour($dateDebut,$dateFin)
    {

        $requete=$this->_db->prepare('SELECT * FROM calendrier WHERE datej>= :dateDebut AND datej <= :dateFin');
        $requete->bindValue(':dateDebut',$dateDebut);
        $requete->bindValue(':dateFin',$dateFin);
        try {



            $requete->execute();
            //PDOStatement::fetchAll() — Retourne un tableau contenant toutes les lignes du jeu d'enregistrements.
            //Le tableau représente chaque ligne comme soit un tableau de valeurs des colonnes, soit un objet avec des propriétés correspondant à chaque nom de colonne.
            $result=$requete->fetchAll(PDO::FETCH_BOTH);
            $lesJours=array();
            foreach($result as $donnee)
            {

                $lesJours[]=new calendrier($donnee);

            }
            return $lesJours;
        }
        catch(error $e)
        {
            return $e;
        }


    }
}
