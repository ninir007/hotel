<?php
spl_autoload_register();
session_start();

header("Content-Type: text/html; charset=iso-8859-1");
$result = array();
$dateArr = $_POST['datein'];
$dateDep = $_POST['dateout'];
$chambre = $_POST['chambre'];

$chambreManager = new ChambreManager();
$lachambre = $chambreManager->getLaChambre($chambre);

foreach($lachambre as $ch) {
    $ko = $ch->getLitbebe();
}
$_SESSION['reservation'] = '';
$_SESSION['chambre'] = $chambre;
$_SESSION['lit'] = $ko;
$_SESSION['in'] = $dateArr;
$_SESSION['out'] = $dateDep;
$_SESSION['somme'] = 0;
$_SESSION['sommeLit'] = 0;
//DEBUT -------VERIF DATE, DISPO CHAMBRE
$calendrierManager = new CalendrierManager();
$result = $calendrierManager->reservable($chambre,$dateArr,$dateDep);


$reponse = array();
$noreservation = array();


if($result[0] == "1") {

    $calendrierManager = new CalendrierManager();
    $result2 = $calendrierManager->reserver($_SESSION['id'],$dateArr,$dateDep);

    if($result2[0] == '1') {
        //hotel ouvert + chambre dispo

        $reservationManager = new ReservationManager();
        $noreservation = $reservationManager->getLastReservationByClient($_SESSION['id']);
        $_SESSION['reservation'] = $noreservation[0];
        $reponse[0] = $noreservation[0];



        //DEBUT -------CALCULE SEJOUR
                $lestarifs = $calendrierManager->getCodeTarifBySejour($dateArr,$dateDep);
                $i = 0;
                $_SESSION['tarif'] = array();
                foreach($lestarifs as $tarif){

                    $_SESSION['tarif'][$i] = $tarif->getCode_tarif();
                    $i++;
                }

                $prixmanager = new PrixManager();
                $tarification = $prixmanager->getListById_Modele($_SESSION['modele']);

                //sejour avec lit bebe
                if($_SESSION['lit'] == 1) {
                    $tarifmanager = new tarifManager();
                    $leslits = $tarifmanager->getSais();
                    foreach($leslits as $lit){
                        $prixlitbebe = $lit->getPrixLitBebe();
                        $code = $lit->getCodeTarif();
                        for($i=0;$i< count($_SESSION['tarif']);$i++) {
                            if($_SESSION['tarif'][$i] == $code){
                                $_SESSION['sommeLit'] += $prixlitbebe ;
                            }
                        }
                    }
                }
                foreach($tarification as $prix){
                    $prixParJour = $prix->getPrix();
                    $codeTarif = $prix->getCodeTarif();

                    for($i=0;$i< count($_SESSION['tarif']);$i++) {

                        if($_SESSION['tarif'][$i] == $codeTarif) {

                            $_SESSION['somme'] += $prixParJour;
                        }

                    }

                }
        //FIN----------CALCULE SEJOUR


    }
    else{
        $reponse[0] = 'reservation nok';
    }

}
else if($result[0] == "11"){

    $reponse[0] = 'hotel pas ouvert';
}

else{

    $reponse[0] = 'chambre pas disponible';
}
//FIN -------VERIF DATE, DISPO CHAMBRE




$x = json_encode($reponse);
echo $x;



