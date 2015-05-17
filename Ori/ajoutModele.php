<?php
spl_autoload_register();
session_start();
if(!(isset($_SESSION['login']) && $_SESSION['login']=="admin"))
{
  exit();
}

$type = $_POST['type'];
$bain = $_POST['bain'];
$douche = $_POST['douche'];
$wc = $_POST['wc'];
$lit1p = $_POST['lit1p'];
$lit2p = $_POST['lit2p'];

$modeleManager = new ModeleManager();

if($type == "ins")
{
  $result = $modeleManager->insertModele($bain, $douche, $wc, $lit1p, $lit2p);
  echo $result;
}
elseif($type == "mod")
{
  $idmodele = $_POST['idmodele'];
  $result = $modeleManager->modifModele($idmodele, $bain, $douche, $wc, $lit1p, $lit2p);
  echo $result;
}
else
{
  echo "Pas de type lors du POST";
}
?>
