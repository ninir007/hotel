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
if(isset($_SESSION['tarif'])){
    $_SESSION['acompte'] = $_SESSION['somme']*0.1;
?>
<div id="recap" class="container">
    <div class="col-sm-12 col-md-8 col-md-offset-2">
        <h2 class="well form-title" id="recap1">Résumé de la réservation </h2>
        <div class="well">
            <ul class="summary">
                <li>N° reservation : <span id="li_idmodele"> <?php echo $_SESSION['reservation']?> </span></li>
                <li>Modéle : <span id="li_idmodele"> <?php echo $_SESSION['modele'] ?> </span></li>
                <li>Chambre : <span id="li_nbrechambre"> <?php echo $_SESSION['chambre'] ?> </span></li>
                <li>Date checkin : <span id="li_datein"> <?php print_r($_SESSION['in']) ?> </span></li>
                <li>Date checkout : <span id="li_dateout"> <?php  print_r($_SESSION['out']) ?> </span></li>
                <li>Prix total TTC : <span id="li_prix"> <?php print_r($_SESSION['somme']) ?> </span> €</li>
                <li>Acompte à verser : <span id="li_acompte"> <?php print_r($_SESSION['acompte']) ?> </span> €</li>
                <li>Avant le : <span id="li_date_limite_acompte"> <?php  print_r($_SESSION['in']) ?> </span></li>
            </ul>


        </div>
        <div class="col-lg-10 col-lg-offset-4">
            <input class="btn btn-default"  id="boutonAnnuler" onclick=javascript:annulerReserv() type="button" value="Annuler">
            <input class="btn btn-default"  id="boutonValider" onclick=javascript:validerReserv() type="button" value="Valider">
        </div>

    </div>
</div>

<?php
}
?>
<script language="javascript">
    $(document).ready(function(){






    });

    function annulerReserv() {
        var xhr = getXhr();
        var reservation = <?php echo $_SESSION['reservation']; ?>;
        xhr.onreadystatechange = function()
        {
            if(xhr.readyState == 4 && xhr.status == 200)
            {
                var result = xhr.responseText;
                var js_result = eval(result);
                if(js_result=='1'){
                    alert("Reservation annulée");
                    location.href='consulterModeles.php';
                }

            }
            else{

            }
        };
        xhr.open("POST","annulerReservation.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xhr.send("reservation=" + reservation);

    }
    function validerReserv() {
        var xhr = getXhr();
        var reservation = <?php echo $_SESSION['reservation']; ?>;
        xhr.onreadystatechange = function()
        {
            if(xhr.readyState == 4 && xhr.status == 200)
            {
                var result = xhr.responseText;
                var js_result = eval(result);
                if(js_result=='1'){
                    alert("Reservation enregistrée");
                    location.href='consulterModeles.php';
                }

            }
            else{

            }
        };
        xhr.open("POST","validerReservation.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xhr.send("reservation=" + reservation);

    }

</script>