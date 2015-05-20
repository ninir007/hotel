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
?>

<div class="row-fluid">
<div class="span12  offset1">
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead>
            <tr style="background-color: rgba(41, 16, 0, 0.54);">
                <th style="text-align: center"> </th>
                <th style="text-align: center">Bain(s)</th>
                <th style="text-align: center">Douche(s)</th>
                <th style="text-align: center">WC</th>
                <th style="text-align: center">Nbre. lit 1 personne</th>
                <th style="text-align: center">Nbre. lit 2 personnes</th>
                <th style="text-align: center">#</th>
            </tr>
            </thead>
            <tbody>
            <?php

            $modeleleManager= new ModeleManager();
            $lesModeles = $modeleleManager->getListObj();

            foreach($lesModeles as $modele)
            {
                $id= $modele->getId_Modele();
                echo "<tr id=modele".$modele->getId_Modele()." style='text-align: center'>\n";
                echo "<td><a type=\"button\" href=\"#$id\" title=\"Voir\" class=\"btn btn-xs btn-default\"><span class=\"glyphicon glyphicon-eye-open\"></span></a></td>";

                for($j=0;$j<3;$j++)
                {
                    echo "<td>";
                    if(($modele->getBain()==1 && $j==0) || ($modele->getDouche()==1 && $j==1) || ($modele->getWc()==1 && $j==2))
                    {
                        echo "<span class=\"glyphicon glyphicon-ok\"></span>";
                    } else {
                        echo "<span class=\"glyphicon glyphicon-remove\"></span>";
                    }
                    echo "</td>\n";
                }
                echo "<td>".$modele->getNbreLit1()."</td>\n";
                echo "<td>".$modele->getNbreLit2()."</td>\n";
                echo "<td>";
                echo $modele->getId_Modele();
                echo "</td>\n";
                echo "</tr>\n";
            }
            ?>
            </tbody>
            </table>
        </div>
    </div>
</div>
  <hr class="featurette-divider" id="1">


<div class="container marketing">
    <div class='row featurette' >
        <div class='col-md-7'  >
            <h2 class='featurette-heading'>Chambre Premier. <span class='text-muted'>Simplicité et tranquilité.</span></h2>
            <p class='lead'>Elégamment conçues, les chambres Premier offrent tout le confort qu'un hôte puisse imaginer : linge de lit délicat, espaces salon confortables, salles de bain en marbre, sans oublier les vues sur la paisible cour intérieure.</p>
        </div>
        <div class='col-md-5'>
            <img class='featurette-image img-responsive' data-src='holder.js/500x500/auto' alt='500x500' src='images/hamb1.jpg'>
        </div>
        <?php
        if(isset($_SESSION['login']) && $_SESSION['login'] == 'membre') {
            ?>
            <div class='col-lg-2 col-lg-offset-5'>
                &nbsp; <p><a class='btnshow btn btn-default' rel='1' role='button'>Reserver</a></p>
            </div>
        <?php } ?>
    </div>


<?php
$i=2;
foreach($lesModeles as $modele)
{
    if(($modele->getId_Modele() != 1)){
    echo "<hr class='featurette-divider' id='".$i."'>";
    echo file_get_contents("./content/".$i.".txt");
    echo "<div class='col-md-5'>
            <img class='featurette-image img-responsive' data-src='holder.js/500x500/auto' alt='500x500' src='images/hamb".$i.".jpg'>
        </div>";

    if(isset($_SESSION['login']) && $_SESSION['login'] == 'membre') {  ?>

                     <div class='col-lg-2 col-lg-offset-5'>
                      &nbsp; <p><a class='btnshow btn btn-default' rel='<?php echo $i?>' role='button'>Reserver</a></p>
                     </div>
    <?php  }
    echo "</div>";

 $i++;
    }
}
 ?>


</div><!-- /.container -->




<script type='text/javascript'>
    $(document).ready(function(){
        handleReservation();
    });


function handleReservation() {
    $('.btnshow').click( function() {
        var model = $(this).attr('rel');
        location.href='formReserver.php?idmodele='+model;
});

}
</script>
