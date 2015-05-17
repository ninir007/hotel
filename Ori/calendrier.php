<?php


class calendrier {
    
    private $_dateJ;
    private $_code_tarif;
    private $_nbebedispo;
    public function getDateJ()
    {
        return $this->_dateJ;
    }
     public function getCode_tarif()
    {
        return $this->_code_tarif;
    }
     public function getNbebedispo()
    {
        return $this->_nbebedispo;
    }
    public function setDateJ($dateJ)
    {
        $this->_dateJ=$dateJ;
    }
     public function setCode_tarif($code_tarif)
    {
         $this->_code_tarif=$code_tarif;
    }
     public function setNbebedispo($nbebedispo)
    {
         $this->_nbebedispo=$nbebedispo;
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
    public function __construct(array $donnees)
	{
		$this->hydrate($donnees);
	}
    
}
