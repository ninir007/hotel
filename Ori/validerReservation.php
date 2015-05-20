<?php

spl_autoload_register();
session_start();


$reservationManager = new ReservationManager();
$noreservation = $reservationManager->confirmerReservation($_SESSION['reservation'],$_SESSION['chambre']);

$noreservation = $reservationManager->updateReservation($_SESSION['reservation'],$_SESSION['somme'],$_SESSION['acompte'],$_SESSION['in'],$_SESSION['lit']);

if($noreservation == true){
    echo 1;
}
else
{
    echo 0;
}