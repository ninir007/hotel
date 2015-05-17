<?php
spl_autoload_register();
session_start();
if(!(isset($_SESSION['login']) && $_SESSION['login']=="admin"))
{
  exit();
}

$type = $_POST['type'];
$numero = $_POST['numero'];
$idmodele = $_POST['idmodele'];
$etage = $_POST['etage'];
$litbebe = $_POST['litbebe'];

$chambreManager = new ChambreManager();

if($type == "ins")
{
  $result = $chambreManager->insertChambre( $numero, $idmodele, $etage, $litbebe);
  echo $result;
}
elseif($type == "mod")
{
  $result = $chambreManager->modifChambre($numero, $idmodele, $etage, $litbebe);
  echo $result;
}
else
{
  echo "Pas de type lors du POST";
}
?>
