<?php
class Client
{

private $_noclient;
private $_nom;
private $_prenom;
private $_adresse;
private $_npostal;
private $_localite;
private $_login;
private $_password;


public function __construct(array $donnees)
	{
		$this->hydrate($donnees);
	}
	
	public function getLogin()
	{
		return $this->_login;
	}
	
	public function getPassword()
	{
		return $this->_password;
	}
	public function getIdClient()
	{
		return $this->_noclient;
	}
	public function getNom()
	{
		return $this->_nom;
	}
	public function getPrenom()
	{
		return $this->_prenom;
	}
		public function getAdresse()
	{
		return $this->_adresse;
	}
		public function getPostal()
	{
		return $this->_npostal;
	}
	public function getLocalite()
	{
		return $this->_localite;
	}

public function setlocalite($loc)
	{
		$this->_localite=$loc;
	}
public function setnpostal($code)
	{
		$this->_npostal=$code;
	}
public function setadresse($adr)
	{
		$this->_adresse=$adr;
	}
public function setprenom($prenom)
	{
		$this->_prenom=$prenom;
	}
public function setnom($nom)
	{
		$this->_nom=$nom;
	}
	public function setnoclient($nocli)
	{
		$this->_noclient=$nocli;
	}
	public function setLogin($login)
	{
		$this->_login=$login;
	}
	public function setPassword($password)
	{
		$this->_password=$password;
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