<?php
session_start();
spl_autoload_register();
include ('header.html');
if(!isset($_SESSION['login']))
    include ('nav_general.html');
elseif($_SESSION['login']=="admin")
    include('nav_admin.html');
elseif($_SESSION['login']=="membre")
    include('nav_membr.html');

$reservationManager = new ReservationManager();

$reservations = $reservationManager->getReservationsByClient($_SESSION['id']);
?>
    <div class="container">
        <div class="col-sm-12 col-md-9">
            <div class="container">
                <div class="col-sm-12 main center">
                    <div class="container-fluid">
                        <div class="panel panel-primary" style="background-color: rgba(41, 16, 0, 0.54)">
                            <!-- Default panel contents -->
                            <div class="panel-heading text-center" style="background-color: rgba(41, 16, 0, 0.54); color:#B6B6B6">Vos réservations</div>
                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr >
                                        <th>Date</th>
                                        <th>Numéro</th>
                                        <th>Date arrivé</th>
                                        <th>Date départ</th>
                                        <th>Prix total</th>
                                        <th>Acompte</th>
                                        <th>Date limite versement</th>
                                    </tr>
                                    </thead>
                                    <tbody>
<?php
  foreach($reservations as $reservation)
  {
      echo "<tr style='text-align: center;'>";
      echo "<td>".$reservation->getDate_Reservation()."</td>";
      echo "<td>".$reservation->getNo_Reservation()."</td>";
      echo "<td>".$reservation->getDate_Arrivee()."</td>";
      echo "<td>".$reservation->getDate_Depart()."</td>";
      echo "<td>".$reservation->getPrixtotal()." &#8364</td>";
      echo "<td>".$reservation->getAcompte_Demande()." &#8364</td>";
      echo "<td>".$reservation->getDate_Limite_Acompte()."</td>";
      echo "</tr>";
  }
  echo  "</tbody>\n</table>\n</div>\n</div>\n";

?>