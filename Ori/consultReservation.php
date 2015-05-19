<?php
spl_autoload_register();
session_start();
include ('header.html');
if(!isset($_SESSION['login']))
    include ('nav_general.html');
elseif($_SESSION['login']=="admin")
    include('nav_admin.html');
elseif($_SESSION['login']=="membre")
    include('nav_membr.html');

$reservationManager = new ReservationManager();
$arrivants = $reservationManager->getArrivant();
$clientmanager =  new clientManager();



?>
<h1 class="page-header">Reservations</h1>
<div class="container">
    <div class="col-xs-12 col-lg-10" id="infotarif">
        <div class="panel panel-default" style="background-color: rgba(41, 16, 0, 0.54)">
            <div class="panel-heading text-center" style="background-color: rgba(41, 16, 0, 0.54); color:#B6B6B6">Arrivants du jour : <?php print_r(date("Y-m-d"));?></div>
            <form id="arrivant" class="form-horizontal">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Numéro</th>
                            <th>Client</th>
                            <th>Nom Client</th>
                            <th>Prenom Client</th>
                            <th>Date départ</th>
                            <th>Chambre</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(empty($arrivants)){
                            print_r("<tr ><th colspan='6'style='text-align: center'>aucun arrivant aujourd'hui !</th></tr>");

                        }
                        else{
                            foreach($arrivants as $arrivant)
                            {
                                echo "<tr style='text-align: center;'>";
                                echo "<td>".$arrivant->getNo_Reservation()."</td>";
                                echo "<td>".$arrivant->getNo_Client()."</td>";
                                echo "<td>".$clientmanager->getNomByID($arrivant->getNo_Client())[0]."</td>";
                                echo "<td>".$clientmanager->getNomByID($arrivant->getNo_Client())[1]."</td>";
                                echo "<td>".$arrivant->getDate_Depart()."</td>";
                                echo "<td>".$reservationManager->getChambreByReserv($arrivant->getNo_Reservation())[0]."</td>";
                                echo "</tr>";
                            }
                        }

                        ?>
                       </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
    <div class="col-xs-12 col-lg-11" id="infotarif">
        <div class="panel panel-default" style="background-color: rgba(41, 16, 0, 0.54)">
            <div class="panel-heading text-center" style="background-color: rgba(41, 16, 0, 0.54); color:#B6B6B6">Reservations</div>
            <form id="arrivant" class="form-horizontal">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Num. Réservation</th>
                            <th>Num. Client</th>
                            <th>Date arrivé</th>
                            <th>Date départ</th>
                            <th>Prix total</th>
                            <th>Nbre.bébé</th>
                            <th>Acompte</th>
                            <th>Date lim. Acomp.</th>
                            <th>Date vers. Acomp.</th>
                            <th>Date réserv.</th>
                        </tr>
                        </thead>
                        <tbody>

                    <?php
                          $reservationManager=new ReservationManager();
                          $lesReservations= $reservationManager->getList();
                          foreach($lesReservations as $reservation)
                          {
                              echo "<tr>\n";
                              echo "<td>".$reservation->getNo_Reservation()."</td>\n";
                              echo "<td>".$reservation->getNo_Client()."</td>\n";
                              echo "<td>";
                              echo $reservation->getDate_Arrivee() != NULL ? date("d-m-Y",strtotime($reservation->getDate_Arrivee())) : "";
                              echo "</td>";
                              echo "<td>";
                              echo $reservation->getDate_Depart() != NULL ? date("d-m-Y",strtotime($reservation->getDate_Depart())) : "";
                              echo "</td>\n";
                              echo "<td>".$reservation->getPrixtotal()." €</td>\n";
                              echo "<td>".$reservation->getNbre_Bebe()."</td>\n";
                              echo "<td>".$reservation->getAcompte_Demande()." €</td>\n";
                              echo "<td>";
                              echo $reservation->getDate_Limite_Acompte() != NULL ? date("d-m-Y",strtotime($reservation->getDate_Limite_Acompte())) : "";
                              echo "</td>\n";
                              echo "<td>";
                              echo $reservation->getDate_Versement_Acompte() != NULL ? date("d-m-Y",strtotime($reservation->getDate_Versement_Acompte())) : "";
                              echo "</td>\n";
                              echo "<td>";
                              echo $reservation->getDate_Reservation() != NULL ? date("d-m-Y",strtotime($reservation->getDate_Reservation())) : "";
                              echo "</td>\n";
                              echo "</tr>\n";
                          }

                    ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
