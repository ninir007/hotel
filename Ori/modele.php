<?php

class Modele {

private $_id_Modele;
private $_bain;
private $_douche;
private $_wc;
private $_nbreLit2;
private $_nbreLit1;


public function getId_Modele()
{
    return  $this->_id_Modele;
}
public function getBain()
{
    return  $this->_bain;
}
public function getDouche()
{
    return  $this->_douche;
}
public function getWc()
{
    return  $this->_wc;
}
public function getNbreLit2()
{
    return   $this->_nbreLit2;
}
public function getNbreLit1()
{
    return  $this->_nbreLit1;
}
public function setId_Modele($id_modele)
{
     $this->_id_Modele=$id_modele;
}
public function setBain($bain)
{
     $this->_bain=$bain;
}
public function setDouche($douche)
{
   $this->_douche=$douche;
}
public function setWc($wc)
{
    $this->_wc=$wc;
}
public function setNbreLit2($nblit2)
{
    $this->_nbreLit2=$nblit2;
}
public function setNbreLit1($nblit1)
{
    $this->_nbreLit1=$nblit1;
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

?>
