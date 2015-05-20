<?php
spl_autoload_register();
class ReservationManager
{
    private $_db;

    public function __construct()
    {
        $this->_db = connectionSingleton::getInstance()->dbh;
        $this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function getList()
    {
        $requete=$this->_db->prepare('select * from reservation order by NORESERVATION');
        try
        {
            $requete->execute();
            $result=$requete->fetchAll(PDO::FETCH_BOTH);
            $lesReservations=array();
            foreach($result as $donnee)
            {
                $lesReservations[]=new Reservation($donnee);
            }
            return $lesReservations;
        }
        catch(error $e)
        {
            return $e;
        }
    }
    public function getLastReservationByClient($noclient)
    {
        $requete = $this->_db->prepare('SELECT MAX(NORESERVATION) FROM RESERVATION WHERE NOCLIENT = :noclient');
        $requete->bindValue(':noclient', $noclient);
        try {
            $requete->execute();
            $result = $requete->fetch();
            return $result;
        } catch (error $e) {
            return $e;
        }
    }
    public function deleteReservation($num)
    {
        $requete=$this->_db->prepare('DELETE FROM reservation WHERE NORESERVATION = :num');
        $requete->bindValue(':num',$num);
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
    public function confirmerReservation($noreservation,$numerochambre)
    {
        $requete=$this->_db->prepare('CALL ajout_pour(:noreservation,:numerochambre,@bool)');
        $requete->bindValue(':noreservation',$noreservation);
        $requete->bindValue(':numerochambre',$numerochambre);
        try
        {
            $requete->execute();
        }
        catch(error $e)
        {
            return $e;
        }
    }
    public function updateReservation($noreservation,$prix,$acompte,$dateacompte,$bebe)
    {
        $requete=$this->_db->prepare('UPDATE reservation SET PRIXTOTAL = :prix, ACOMPTE_DEMANDE = :acompte, NBRE_BEBE = :bebe, DATE_LIMITEACOMPTE = :dateacompte WHERE NORESERVATION = :noreservation');
        $requete->bindValue(':noreservation',$noreservation);
        $requete->bindValue(':prix',$prix);
        $requete->bindValue(':bebe',$bebe);
        $requete->bindValue(':acompte',$acompte);
        $requete->bindValue(':dateacompte',$dateacompte);
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
    public function getReservationsByClient($noclient)
    {
        $requete=$this->_db->prepare('SELECT * FROM RESERVATION WHERE NOCLIENT = :noclient');
        $requete->bindValue(':noclient',$noclient);
        try
        {
            $requete->execute();
            $result=$requete->fetchAll(PDO::FETCH_BOTH);
            $lesReservations=array();
            foreach($result as $donnee)
            {
                $lesReservations[]=new Reservation($donnee);
            }
            return $lesReservations;
        }
        catch(error $e)
        {
            return $e;
        }
    }
    public function getArrivant()
    {
        $requete=$this->_db->prepare('SELECT * FROM RESERVATION WHERE DATE_ARRIVEE = CURDATE()');

        try
        {
            $requete->execute();
            $result=$requete->fetchAll(PDO::FETCH_BOTH);
            $lesReservations=array();
            foreach($result as $donnee)
            {
                $lesReservations[]=new Reservation($donnee);
            }
            return $lesReservations;
        }
        catch(error $e)
        {
            return $e;
        }
    }
    public function getChambreByReserv($reserv)
    {
        $requete=$this->_db->prepare('SELECT numero FROM pour WHERE NORESERVATION = :reserv');
        $requete->bindValue(':reserv',$reserv);
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
}