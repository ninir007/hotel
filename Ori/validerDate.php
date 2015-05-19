<?php
spl_autoload_register();
session_start();

header("Content-Type: text/html; charset=iso-8859-1");
$result = array();
$dateArr = $_POST['datein'];
$dateDep = $_POST['dateout'];
$chambre = $_POST['chambre'];

$calendrierManager = new CalendrierManager();
$result = $calendrierManager->reservable($chambre,$dateArr,$dateDep);
//die(print_r($_SESSION['id'],true));


//die(print_r("reservation créé",true));
//die(print_r($result[0],true));

if($result[0] == "1") {

    $calendrierManager = new CalendrierManager();
    $result2 = $calendrierManager->reserver($_SESSION['id'],$dateArr,$dateDep);

    if($result2[0] == '1') {
        die(print_r("reservation cree",true));
    }
    else{
        echo "pas reservable";
    }
}
else {
    echo "erreur date";
}




