<?php
class Reservation
{
    private $_no_reservation;
    private $_no_client;
    private $_date_arrivee;
    private $_date_depart;
    private $_prixtotal;
    private $_nbre_bebe;
    private $_acompte_demande;
    private $_date_limite_acompte;
    private $_date_versement_acompte;
    private $_date_reservation;

    public function __construct(array $donnees)
    {
        $this->hydrate($donnees);
    }
    public function getNo_Reservation()
    {
        return  $this->_no_reservation;
    }

    public function getNo_Client()
    {
        return  $this->_no_client;
    }

    public function getDate_Arrivee()
    {
        return  $this->_date_arrivee;
    }

    public function getDate_Depart()
    {
        return  $this->_date_depart;
    }

    public function getPrixtotal()
    {
        return   $this->_prixtotal;
    }

    public function getNbre_Bebe()
    {
        return  $this->_nbre_bebe;
    }

    public function getAcompte_Demande()
    {
        return  $this->_acompte_demande;
    }

    public function getDate_Limite_Acompte()
    {
        return  $this->_date_limite_acompte;
    }

    public function getDate_Versement_Acompte()
    {
        return  $this->_date_versement_acompte;
    }

    public function getDate_Reservation()
    {
        return  $this->_date_reservation;
    }




    public function setNoreservation($noreservation)
    {
        $this->_no_reservation = $noreservation;
    }

    public function setNoclient($noclient)
    {
        $this->_no_client = $noclient;
    }

    public function setDate_arrivee($datearrivee)
    {
        $this->_date_arrivee = $datearrivee;
    }

    public function setDate_depart($datedepart)
    {
        $this->_date_depart = $datedepart;
    }

    public function setPrixtotal($prixtotal)
    {
        $this->_prixtotal = $prixtotal;
    }

    public function setNbre_bebe($nbrebebe)
    {
        $this->_nbre_bebe = $nbrebebe;
    }

    public function setAcompte_demande($acomptedemande)
    {
        $this->_acompte_demande = $acomptedemande;
    }

    public function setDate_limiteacompte($limiteacompte)
    {
        $this->_date_limite_acompte = $limiteacompte;
    }

    public function setDate_versementacompte($versementacompte)
    {
        $this->_date_versement_acompte = $versementacompte;
    }

    public function setDate_reservation($datereservation)
    {
        $this->_date_reservation = $datereservation;
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
