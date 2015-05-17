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

      <div class="row featurette" >
        <div class="col-md-7"  >
          <h2 class="featurette-heading">Chambre Premier. <span class="text-muted">Simplicité et tranquilité.</span></h2>
          <p class="lead">Elégamment conçues, les chambres Premier offrent tout le confort qu'un hôte puisse imaginer : linge de lit délicat, espaces salon confortables, salles de bain en marbre, sans oublier les vues sur la paisible cour intérieure.</p>
        </div>
        <div class="col-md-5">
          <img class="featurette-image img-responsive" data-src="holder.js/500x500/auto" alt="500x500" src="images/hamb2.jpg">
        </div>
      </div>

      <hr class="featurette-divider" id="2">

      <div class="row featurette" >
        <div class="col-md-5">
          <img class="featurette-image img-responsive" data-src="holder.js/500x500/auto" alt="Generic placeholder image" src="images/hamb1.jpg">
        </div>
        <div class="col-md-7">
          <h2 class="featurette-heading" >Chambre Superieur. <span class="text-muted">Intimité.</span></h2>
          <p class="lead">Conçues sur mesure pour s'adapter à vos besoins, les Suites Premier apporteront un sentiment de bien-être résidentiel instantané. Equipées des meilleures technologies tout en apportant toute l'intimité d'un pied-à-terre.</p>
        </div>
      </div>

      <hr class="featurette-divider" id="3">

      <div class="row featurette" >
        <div class="col-md-7">
          <h2 class="featurette-heading" >Chambre Grand Deluxe. <span class="text-muted"> Spacieuse et luxueuse.</span></h2>
          <p class="lead">Meublée avec chic dans le style contemporain, elle dispose du service Alhambra, d'une technologie de pointe, d'un système audiovisuel hors pair et de la connexion haut débit.</p>
        </div>
        <div class="col-md-5">
          <img class="featurette-image img-responsive" data-src="holder.js/500x500/auto" alt="Generic placeholder image" src="images/hamb3.jpg">
        </div>
      </div>

      <hr class="featurette-divider" id="4">


      <div class="row featurette" >
        <div class="col-md-5">
          <img class="featurette-image img-responsive" data-src="holder.js/500x500/auto" alt="Generic placeholder image" src="images/hamb1.jpg">
        </div>
        <div class="col-md-7">
          <h2 class="featurette-heading" >Suite Marco Polo. <span class="text-muted">Historique.</span></h2>
          <p class="lead">Baigné de lumière naturelle, l'intérieur se pare, dans l'esprit thématique, de tissus d'ameublement en soie, sublimés d'antiquités raffinées, de chandeliers de cristal et de cheminées décoratives.</p>
        </div>
      </div>

      <hr class="featurette-divider" id="5">

      <div class="row featurette" >
        <div class="col-md-7">
          <h2 class="featurette-heading" >Suite Superieur. <span class="text-muted">Vivez l'expérience du luxe.</span></h2>
          <p class="lead">Ressourcez-vous dans la salle de bains en marbre, et laissez le confort de cette Suite satisfaire toutes vos exigeances.</p>
        </div>
        <div class="col-md-5">
          <img class="featurette-image img-responsive" data-src="holder.js/500x500/auto" alt="Generic placeholder image" src="images/hamb3.jpg">
        </div>
      </div>

      <hr class="featurette-divider" id="6">

      <div class="row featurette">
        <div class="col-md-5">
          
    <!-- Carousel
    ================================================== -->
    <div id="myCarousel"  class="carousel slide" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators" >
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1"></li>
        <li data-target="#myCarousel" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner">
        <div class="item active">
          <img src="./images/chamb/Suite Royale/1.jpg" alt="First slide" height="600">
          <div class="container">
            <div class="carousel-caption">
              
            </div>
          </div>
        </div>
        <div class="item">
          <img src="./images/chamb/Suite Royale/2.jpg" alt="Second slide" height="600">
          <div class="container">
            <div class="carousel-caption">
              
            </div>
          </div>
        </div>
        <div class="item">
          <img src="./images/chamb/Suite Royale/3.jpg" alt="Third slide" height="600">
          <div class="container">
            <div class="carousel-caption">
              
            </div>
          </div>
        </div>

       



      </div>

      <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
      <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
    </div><!-- /.carousel -->


        </div>
        <div class="col-md-7" >
          <h2 class="featurette-heading">Suite Al Hambra. <span class="text-muted"><br>Raffinement.</span></h2>
          <p class="lead">Véritable appartement, la Suite Al Hambra respire le chic contemporain. Au sommet de la tour des Dames, cette suite offre une vue à couper le souffle.</p>
        
          <div class="btn-group btn-group-xs">
             &nbsp; <p><a class="btn btn-default" href="#" role="button">Reserver</a></p> 
            </div>
        </div>


      </div>

      <hr class="featurette-divider">

      <!-- /END THE FEATURETTES -->


          </div><!-- /.container -->
