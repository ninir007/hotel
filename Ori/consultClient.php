<?php
spl_autoload_register();
session_start();
require_once('header.html');
if(!isset($_SESSION['login'])) {
    include ('nav_general.html');
}

else if($_SESSION['login']=="admin") {
    include('nav_admin.html');
}

else if($_SESSION['login']=="membre") {
    include('nav_membr.html');
}
?>

<h1 class="page-header">Clients</h1>
<div class="table-responsive">
  <table class="table table-striped table-bordered">
    <thead>
      <tr class="info" >
        <th style="background-color: rgba(41, 16, 0, 0.54);text-align: center">Numéro Client</th>
        <th style="background-color: rgba(41, 16, 0, 0.54);text-align: center">Nom</th>
        <th style="background-color: rgba(41, 16, 0, 0.54);text-align: center">Prénom</th>
        <th style="background-color: rgba(41, 16, 0, 0.54);text-align: center">Adresse</th>
        <th style="background-color: rgba(41, 16, 0, 0.54);text-align: center">Code Postal</th>
        <th style="background-color: rgba(41, 16, 0, 0.54);text-align: center">Localité</th>
        <th style="background-color: rgba(41, 16, 0, 0.54);text-align: center">Login</th>
      </tr>
    </thead>
    <tbody>
<?php
    $clientManager=new ClientManager();
    $lesClients= $clientManager->getList();
    foreach($lesClients as $client)
    {
        echo "<tr style='text-align: center'>\n";
        echo "<td>".$client->getIdClient()."</td>\n";
        echo "<td>".$client->getNom()."</td>\n";
        echo "<td>".$client->getPrenom()."</td>\n";
        echo "<td>".$client->getAdresse()."</td>\n";
        echo "<td>".$client->getPostal()."</td>\n";
        echo "<td>".$client->getLocalite()."</td>\n";
        echo "<td>".$client->getLogin()."</td>\n";
        echo "</tr>\n";
    }
    echo  "</tbody>\n</table>\n</div>\n";
