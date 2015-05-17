<?php
class Prix
{
private $_idModele;
private $_codeTarif;
private $_prix;
public function __construct(array $donnees)
	{
		$this->hydrate($donnees);
	}
	
	public function getIdModele()
	{
		return $this->_idModele;
	}
	
	public function getCodeTarif()
	{
		return $this->_codeTarif;
	}

	public function getPrix()
	{
		return $this->_prix;
	}


	
	public function setId_Modele($modele)
	{
		$this->_idModele=$modele;
	}
	public function setCode_Tarif($codeTarif)
	{
		$this->_codeTarif=$codeTarif;
	}

	public function setPrix($prix)
	{
		$this->_prix=$prix;
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
?>