<?php
class Tarif
{

public $_codetarif;
private $_couleur;
private $_prixlitbebe;

public function __construct(array $donnees)
	{
		$this->hydrate($donnees);
	}
	
	public function getCodeTarif()
	{
		return $this->_codetarif;
	}
	
	public function getCouleur()
	{
		return $this->_couleur;
	}

	public function getPrixLitBebe()
	{
		return $this->_prixlitbebe;
	}

	public function setPrixLitBebe($prixlitbebe)
	{
		$this->_prixlitbebe=$prixlitbebe;
	}

	
	public function setcode_tarif($code_tarif)
	{
		$this->_codetarif=$code_tarif;
	}
	public function setCouleur($couleur)
	{
		$this->_couleur=$couleur;
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
