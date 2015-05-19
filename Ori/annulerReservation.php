<?php
spl_autoload_register();
session_start();


$idModele = intval($_POST['reservation']);
$reservationManager = new ReservationManager();

$noreservation = $reservationManager->deleteReservation($_SESSION['reservation']);
if($noreservation == true)
{
    $_SESSION['reservation'] = '/';
    $_SESSION['chambre'] = '/';
    $_SESSION['modele'] = '/';
    $_SESSION['lit'] = '/';
    $_SESSION['in'] = '/';
    $_SESSION['out'] ='/';
    $_SESSION['somme'] = '/';
    $_SESSION['acompte'] = '/';
    unset( $_SESSION['tarif'] );

    echo 1;
}
else
{
    echo 0;
}
