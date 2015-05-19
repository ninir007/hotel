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


$tarifManager=new TarifManager();
$lesTarifs= $tarifManager->getSais();
?>
<h1 class="page-header">Reservation modéle <?php echo $_GET['idmodele']?></h1>


<!--TARIF-->
<div class="col-xs-12 col-lg-4">
    <div class="panel panel-default" style="background-color: rgba(41, 16, 0, 0.54)">
        <div class="panel-heading text-center" style="background-color: rgba(41, 16, 0, 0.54); color:#B6B6B6">Tarifs des saisons pour le modéle <?php echo $_GET['idmodele']?></div>
        <form id="modifTarifs" class="form-horizontal" role="form" action=javascript:modifierTarif(<?php echo count($lesTarifs) ?>) method=POST>
            <?php
            foreach($lesTarifs as $tarif)
            {
                echo "<div class=\"form-group ";
                echo "\">\n<label class=\"col-xs-10 col-lg-2 control-label\">".strtoupper($tarif->getCouleur())."</label>";
                echo "<div class=\"col-xs-9 col-lg-9\">\n";
                echo "<input disabled class=\"form-control\" min=0 type=\"number\" id=\"codetarif".$tarif->getCodeTarif()."\" name=\"codetarif".$tarif->getCodeTarif()."\" required>\n";
                echo "\n</div>\n</div>";
            }
            ?>
        </form>
    </div>
</div>
<form class="form-inline well" id="form" action=javascript:checkReservable() method="post">
<div class="col-xs-12 col-lg-2">
    <div class="panel panel-default ">
        <div class="panel-heading text-center">Chambres séléctionnées</div>
        <select class="form-control" id="idBodyChambres">

        </select>
    </div>
</div>
<div class="col-xs-12 col-lg-3">
    <div class="panel panel-default" style="background-color: rgba(41, 16, 0, 0.54)">
        <div class="panel-heading text-center" style="background-color: rgba(41, 16, 0, 0.54); color:#B6B6B6">Selectionner periode</div>

                <div class="form-group col-lg-offset-4">
                <label class="col-lg-12" >Date début</label>
                <input type="text" id="dateDebut" name=dateDebut class="date"><br>
                <label class="col-lg-12">Date fin</label>
                <input type="text" id="dateFin" name=dateFin class="date">
                </div>
                <br><center><input class="btn btn-default" type="submit" ></center>

        </div>
    </div>
</div>
</form>






<script language="javascript">
    $(document).ready(function(){

//autocomplete date
     var date = new Date();


     $( "#dateDebut" ).datepicker({
         altField: "#datepicker",
         closeText: 'Fermer',
         prevText: 'Précédent',
         nextText: 'Suivant',
         currentText: 'Aujourd\'hui',
         monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
         monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
         dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
         dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
         dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
         weekHeader: 'Sem.',
         dateFormat: 'dd-mm-yy',
         minDate: new Date(date.getFullYear(),date.getMonth(), date.getDate()+1),
         maxDate: new Date(date.getFullYear(),date.getMonth()+6, date.getDate()),
         onSelect: function() {
             var minDate = $(this).datepicker('getDate');
             minDate.setDate(minDate.getDate()+1);
             $("#dateFin").datepicker("option","minDate", minDate);
             $(this).change();
         }
     });

        $( "#dateFin" ).datepicker({
            altField: "#datepicker",
            closeText: 'Fermer',
            prevText: 'Précédent',
            nextText: 'Suivant',
            currentText: 'Aujourd\'hui',
            monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
            dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
            dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
            weekHeader: 'Sem.',
            dateFormat: 'dd-mm-yy',
            minDate: new Date(date.getFullYear(),date.getMonth(), date.getDate()+1),
            maxDate: new Date(date.getFullYear(),date.getMonth()+6, date.getDate()),
            onSelect: function() {
                var maxDate = $(this).datepicker('getDate');
                maxDate.setDate(maxDate.getDate()-1);
                $("#dateDebut").datepicker( "option", "maxDate", maxDate);
                $(this).change();
            }
        });






//autocomplete tarification
        var idmodele = <?php echo $_GET['idmodele']; ?>;


        var xhr = getXhr();

        xhr.onreadystatechange = function()
        {
            if(xhr.readyState == 4 && xhr.status == 200)
            {
                var result = xhr.responseText;
                var js_result = eval(result);
                if(js_result[0][0] !=  0)
                {
                    var append = "";
                    for(var i = 0; i < js_result[0].length; i++ )
                    {
                        append = append.concat(js_result[0][i]);
                    }
                    document.getElementById('idBodyChambres').innerHTML = append;
                }
                else
                {
                    document.getElementById('idBodyChambres').innerHTML = "<option>Pas de chambres pour ce modéle.</option>";
                }

                if(js_result[1][0] !=  0)
                {
                    for(var i = 0; i < js_result[1].length; i++ )
                    {
                        document.getElementById("codetarif"+js_result[1][i][0]).value = js_result[1][i][1];
                    }
                }
            }
        };
        xhr.open("POST","getChambresBtn.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xhr.send("idModele=" + idmodele);
    });
    function checkReservable() {
        var fin = $( "#dateFin" ).val().substring(6)+"-"+$( "#dateFin" ).val().substring(3,5)+"-"+$( "#dateFin" ).val().substring(0,2);
        var deb = $( "#dateDebut" ).val().substring(6)+"-"+$( "#dateDebut" ).val().substring(3,5)+"-"+$( "#dateDebut" ).val().substring(0,2);
        var chamb = $( "#chambr:checked").val();

        var donnees = "datein="+deb+"&dateout="+fin+"&chambre="+chamb;
        if(donnees == null)
        {
            return;
        }
        var xhr = getXhr();
        xhr.onreadystatechange = function()
        {
            if(xhr.readyState == 4 && xhr.status == 200)
            {
                var result = xhr.responseText;
                eval(result);
            }
        }
        xhr.open("POST","validerDate.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xhr.send(donnees);

    }
</script>