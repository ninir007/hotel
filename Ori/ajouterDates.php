<?php 

session_start();
include ('header.html');
if(!isset($_SESSION['login']))
{
include ('nav_general.html');
}
elseif($_SESSION['login']=="admin")
{
include('nav_admin.html');
spl_autoload_register();

$calendrierManager=new calendrierManager();
$result=$calendrierManager->ajouterJours($_POST['dateDebut'],$_POST['dateFin'],$_POST['laSaison'],$_POST['nBebe']);
?>

    <div class="row-fluid">
	<div class="span3  offset1">
         <?php
        echo $result[0]." jours ont été ajoutés ";
         ?>
    </div>
    </div>
</body>
 
<?php
}
?>