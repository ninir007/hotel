<?php
session_start();



	spl_autoload_register();
	$employeManager=new EmployeManager();
	$resultEmp=$employeManager->getByLogin($_POST['login'],$_POST['password']);
	if($resultEmp[0]==1)
	{
		$_SESSION['login']="admin";
		header('Location: index.php');
	}
	else
	{
		$clientManager=new ClientManager();
		$resultClient=$clientManager->getByLogin($_POST['login'],$_POST['password']);
		if($resultClient[0]==1)
		{
			$infos=array();
			$infos=$clientManager->getClient($_POST['login']);
			$_SESSION['login']="membre";      
              foreach($infos as $cli)
              {
                 $_SESSION['id']=$cli->getIdClient();
                 $_SESSION['pseudo']=$cli->getLogin();
              }		 
			header('Location: index.php');

		}
		else
		{
			include('login.html');
		}
	}
?>