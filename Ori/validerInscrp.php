<?php
	spl_autoload_register();
	print_r($_POST);
	$client= new clientManager();
	$result= $client->ajouterClient($_POST['nom'],$_POST['prenom'],$_POST['adress'],$_POST['postal'],$_POST['loc'],$_POST['login'],$_POST['password']);
	if($result[0]==-2)
	{
		include('header.html');
		include('nav_consulter.html');
		echo "inscription refusé, veuillez choisir un autre login !!";
	}
	else
	{
		if($result[0]==-1)
		{

			include('header.html');
			include('nav_consulter.html');
			echo "inscription refusé, vous êtes deja inscrit !!";
		}

		else
		{
			include('header.html');
			include ('nav_general.html');
			echo "inscription réussi, vous pouvez reserver !!";
		}
				
		
	}
?>


