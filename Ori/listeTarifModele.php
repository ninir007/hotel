<?php
	
spl_autoload_register();


	if (empty($_POST['lesModeles']))
	{ 
		echo "erreur" ;
		exit();
	}
	else
	{
		include('header.html');
		include('nav_admin.html');
		$prix=new PrixManager();
		$result=$prix->getPrixByTarifModele($_POST['lesModeles'],$_POST['lesTarifs']);
		if($result[0]==0)
		{
			echo "creation ?";
		}
		else
		{
			echo "affichage prix + modif possible\n";

			echo "Modele : ".$_POST['lesModeles'];
			echo "Code Tarifaire : ".$_POST['lesTarifs'];
			$resulta=$prix->getPrix($_POST['lesModeles'],$_POST['lesTarifs']);
			echo "Prix :".$resulta[0]->getPrix();
		}

	
	
	}
?>
