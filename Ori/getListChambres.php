<?php
spl_autoload_register();
session_start();
if(!(isset($_SESSION['login']) && $_SESSION['login']=="admin"))
{
    exit();
}
$idModele = intval($_POST['idModele']);

$chambreManager = new ChambreManager();
$lesChambres = $chambreManager->getListById_Modele($idModele);
$prixManager = new PrixManager();
$lesPrix = $prixManager->getListById_Modele($idModele);
$result=array();
if(count($lesChambres) > 0 )
{
    $j=0;
    foreach ($lesChambres as $chambre)
    {
        $result[0][$j]="<tr class=\"selected\"><td>".$chambre->getNumero()."</td></tr>";
        $j++;
    }
}
else
{
    $result[0][0]= 0;
}
if(count($lesPrix) > 0)
{
    $j=0;
    foreach($lesPrix as $prix)
    {
        $result[1][$j][0]= $prix->getCodeTarif();
        $result[1][$j][1]= $prix->getPrix();
        $j++;
    }
}
else
{
    $result[1][0]= 0;
}

$js_array = json_encode($result);
echo $js_array;
