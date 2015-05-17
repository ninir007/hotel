<?php
spl_autoload_register();
session_start();
if(!(isset($_SESSION['login']) && $_SESSION['login']=="admin"))
{
    exit();
}

$tarifManager = new TarifManager();
if($_POST['type'] == 0)
{
    $result = $tarifManager->updateTarif($_POST['codetarif'],$_POST['couleur'],$_POST['prixbebe']);
}
elseif($_POST['type'] == 1)
{
    $result = $tarifManager->insertTarif($_POST['couleur'],$_POST['prixbebe']);
}
elseif($_POST['type'] == 2)
{
    // $result = $tarifManager->supprimerTarif($_POST['codetarif']);
}
else
{
    $result = "ERROR TYPE != 0 & 1";
}
echo $result;
