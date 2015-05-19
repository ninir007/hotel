<?php
spl_autoload_register();
class clientManager
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
	
	
	public function getByLogin($login)
	{

		$requete=$this->_db->prepare('select count(*) from client where login like :login');
		$requete->bindValue(':login',$login);
		
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
    public function getNomByID($id)
    {

        $requete=$this->_db->prepare('select NOM, PRENOM from client where NOCLIENT like :id');
        $requete->bindValue(':id',$id);

        try{
            $requete->execute();
            $result=$requete->fetch();
           // var_dump($result);
            return $result;
        }
        catch(error $e)
        {
            return $e;
        }
    }



	public function ajouterClient($nom,$prenom,$adresse,$npostal,$localite,$login,$password)
        {
          
           
          
            $requete=$this->_db->prepare('select ajout_client(:nom,:prenom,:adresse,:npostal,:localite,:login,:password)');
            $requete->bindValue(':nom',$nom);
            $requete->bindValue(':prenom',$prenom);
            $requete->bindValue(':adresse',$adresse);
            $requete->bindValue(':npostal',$npostal);
            $requete->bindValue(':localite',$localite);
            $requete->bindValue(':login',$login);
            $requete->bindValue(':password',$password);
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

        public function getClient($login)
	{
		
		$requete=$this->_db->prepare('select * from client where login like :login');
		$requete->bindValue(':login',$login);
        try {           
            
        		$requete->execute();
		//PDOStatement::fetchAll() — Retourne un tableau contenant toutes les lignes du jeu d'enregistrements.
                 //Le tableau représente chaque ligne comme soit un tableau de valeurs des colonnes, soit un objet avec des propriétés correspondant à chaque nom de colonne. 
				$result=$requete->fetchAll(PDO::FETCH_BOTH);
                $leClient=array();
					foreach($result as $donnee)
						{
		
						$leClient[]=new client($donnee);
				
						}
					return $leClient;
			}
		catch(error $e)
		{
			return $e;
		}

		
	}

    public function getList()
    {
        $requete=$this->_db->prepare('select * from client order by NOCLIENT');
        try
        {
            $requete->execute();
            $result=$requete->fetchAll(PDO::FETCH_BOTH);
            $lesClients=array();
            foreach($result as $donnee)
            {
                $lesClients[]=new Client($donnee);
            }
            return $lesClients;
        }
        catch(error $e)
        {
            return $e;
        }
    }






}
