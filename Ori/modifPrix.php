<?php
spl_autoload_register();
session_start();
if(!(isset($_SESSION['login']) && $_SESSION['login']=="admin"))
{
    exit();
}
$prixManager = new PrixManager();
$idModele = intval($_POST['idModele']);
foreach ($_POST as $key => $value) {
    if( $key != "idModele" && $value != 0)
    {
        $safe_value = intval($value);
        $duplicate = $prixManager->checkDuplicate($idModele,substr($key,9));
        if($duplicate[0] > 0)
        {
            $result = $prixManager->modifierPrix($idModele,substr($key,9),$safe_value);
        }
        else
        {
            $result = $prixManager->insertPrix($idModele,substr($key,9),$safe_value);
        }
        if($result != 1)
        {
            echo "<div class=\"alert alert-warning center\" role=\"alert\">Erreur lors de la requéte SQL pour idModele= ".$idModele." codetarif = ".substr($key,9)." prix = ".$safe_value."</div>";
        }
    }
}

