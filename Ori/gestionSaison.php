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




$tarifsManager = new TarifManager();
$lesTarifs = $tarifsManager->getSais();

$couleurs = array();
$i = 0;
foreach($lesTarifs as $tarif)
{
    $couleurs[$i]=strtoupper($tarif->getCouleur());
    $i++;
}
$js_array = json_encode($couleurs);
//die(print_r($js_array,true));
?>
<h1 class="page-header">Saisons </h1>
<h2 class="sub-header"><span class="text-muted">Modification</span></h2>
<div class="col-xs-12 col-lg-6">
    <div class="panel panel-default">
        <!-- Default panel contents -->
        <div class="panel-heading text-center" style="background-color: rgba(41, 16, 0, 0.74); color:#B6B6B6">Liste tarifs</div>
        <!-- Table -->
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="table">
                <thead>
                <tr>
                    <th>Code tarif</th>
                    <th>Couleur</th>
                    <th>Prix lit bébé</th>
                    <th>#</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($lesTarifs as $tarif)
                {
                    echo "<tr id = \"codetarif".$tarif->getCodeTarif()."\">\n";
                    echo "<td>";
                    echo "<button type=\"button\" onclick=\"modifierTarif(".$tarif->getCodeTarif().")\" >".$tarif->getCodeTarif()."</button>";
                    echo "</td>\n";
                    echo "<td>".strtoupper($tarif->getCouleur())."</td>";
                    echo "<td>".$tarif->getPrixLitBebe()."</td>\n";
                    echo "<td><button type=\"button\" title=\"Modifier\" onclick=\"modifierTarif(".$tarif->getCodeTarif().")\" class=\"btn btn-xs btn-default\"><span class=\"glyphicon glyphicon-pencil\"></span></button></td>";
                    echo "</tr>\n";
                }
                echo  "</tbody>\n</table>\n</div>\n</div></div>\n";

                ?>
                <div class="col-xs-12 col-lg-6">
                    <div hidden id="modification" class="panel panel-default">
                        <div class="panel-heading text-center" style="background-color: rgba(41, 16, 0, 0.74); color:#B6B6B6">Modification</div>
                        <form id="modifTarifs" class="form-horizontal" role="form" action="" method=POST>
                            <div class="form-group">
                                <label class="col-xs-12 col-lg-3 control-label">Code Tarif</label>
                                <div class="col-xs-12 col-lg-9">
                                    <input disabled="" class="form-control" min="0" type="number" id="codetarif" name="codetarif" required>
                                    <span class=""></span>
                                </div>
                            </div>
                            <div class="form-group" id="groupcouleurmodif">
                                <label class="col-xs-12 col-lg-3 control-label">Couleur</label>
                                <div class="col-xs-12 col-lg-9">
                                    <input class="form-control" min="0" type="text" id="couleurtarif" name="couleurtarif" required>
                                    <span class=""></span>
                                </div>
                            </div>
                            <div class="form-group" id="groupbebemodif">
                                <label class="col-xs-12 col-lg-3 control-label">Prix lit bébé</label>
                                <div class="col-xs-12 col-lg-9">
                                    <input class="form-control" min=0 type="text" id="prixbebe" name="prixbebe" required>
                                    <span class=""></span>
                                </div>
                            </div>
                            <a class="btn btn-lg btn-default btn-block center" onclick=javascript:modifierTarifAJAX() id="bouton" type="submit">Valider</a>
                        </form>
                    </div>
                </div>

                <div class="col-xs-12">
                    <h2 class="sub-header"><span class="text-muted">Ajout nouveau tarif</span></h2>
                    <form class="form-inline" role="form" action="" method=POST>
                        <div class="form-group">
                            <label class="sr-only" for="codetarifajout">Code Tarif</label>
                            <input disabled type="number" class="form-control" id="codetarifajout" placeholder="AUTOMATIQUE">
                        </div>
                        <div class="form-group" id="groupcouleur">
                            <label class="sr-only" for="couleurajout">Couleur</label>
                            <input class="form-control" type="text" id="couleurtarifajout" placeholder="Couleur" required>
                        </div>
                        <div class="form-group" id="groupbebe">
                            <label class="sr-only" for="prixbebeajout">Prix lit bébé</label>
                            <input type="number" min=0 class="form-control" id="prixbebeajout" placeholder="Prix lit bébé" required>
                        </div>
                        <a class="btn btn-md btn-default center" onclick=javascript:insertTarifAJAX() type="submit">Valider</a>
                    </form>
                </div>



                <script type="text/javascript">

                    function getXhr()
                    {
                        var xhr = null;

                        if(window.XMLHttpRequest) // Firefox et autres
                            xhr = new XMLHttpRequest();
                        else if(window.ActiveXObject)
                        { // Internet Explorer
                            try
                            {
                                xhr = new ActiveXObject("Msxml2.XMLHTTP");
                            } catch (e) {
                                xhr = new ActiveXObject("Microsoft.XMLHTTP");
                            }
                        }
                        else
                        { // XMLHttpRequest non supporté par le navigateur
                            alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
                            xhr = false;
                        }

                        return xhr;
                    }

                    function modifierTarif(codetarif)
                    {
                        if(codetarif == null)
                        {
                            return;
                        }
                        $(".has-error").removeClass("has-error");
                        var x = "#codetarif"+codetarif;
                        $("tr").removeClass("selected");
                        $(x).addClass("selected");
                        $("#modification").show();
                        $("#codetarif").val(codetarif);
                        $("#couleurtarif").val($(x+" td:nth-child(2)").text());
                        $("#prixbebe").val($(x+" td:nth-child(3)").text());
                    }

                    <?php
                    echo "var couleurs = ".$js_array.";\n";
                    ?>

                    function testDonneesModif()
                    {
                        var usercolor = $("#couleurtarif").val().toUpperCase();
                        var userprix = $("#prixbebe").val();
                        $(".has-error").removeClass("has-error");
                        if(usercolor.length < 1 ||  usercolor.match(/[^a-zA-Z]/) != null)
                        {
                            $("#groupcouleurmodif").addClass("has-error");
                            return true;
                        }
                        var x = "#codetarif"+$("#codetarif").val();
                        if($(x+" td:nth-child(2)").text() != usercolor)
                        {
                            for(var i = 0; i < couleurs.length; i++)
                            {
                                if(usercolor == couleurs[i])
                                {
                                    alert("Couleur déjà utilisé !");
                                    $("#groupcouleurmodif").addClass("has-error");
                                    return true;
                                }
                            }
                        }
                        if(userprix.length < 1 || userprix.match(/[^0-9]/) != null)
                        {
                            $("#groupbebemodif").addClass("has-error");
                            return true;
                        }
                        return "type=0&codetarif="+$("#codetarif").val()+"&couleur="+usercolor+"&prixbebe="+$("#prixbebe").val();
                    }

                    function modifierTarifAJAX()
                    {
                        var donnees = testDonneesModif();
                        if(donnees == true)
                        {
                            return;
                        }
                        var xhr = getXhr();
                        xhr.onreadystatechange = function()
                        {
                            if(xhr.readyState == 4 && xhr.status == 200)
                            {
                                var result = xhr.responseText;
                                if(result == 1)
                                {
                                    location.reload();
                                }
                                else
                                {
                                    alert(result);
                                }
                            }
                        }
                        xhr.open("POST","modifTarif.php",true);
                        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
                        xhr.send(donnees);
                    }

                    function testDonneesAjout()
                    {
                        var usercolor = $("#couleurtarifajout").val().toUpperCase();
                        var userprix = $("#prixbebeajout").val();
                        $(".has-error").removeClass("has-error");
                        if(usercolor.length < 1 ||  usercolor.match(/[^a-zA-Z]/) != null)
                        {
                            $("#groupcouleur").addClass("has-error");
                            return true;
                        }
                        if(userprix.length < 1 || userprix.match(/[^0-9]/) != null)
                        {
                            $("#groupbebe").addClass("has-error");
                            return true;
                        }
                        for(var i = 0; i < couleurs.length; i++)
                        {
                            if(usercolor == couleurs[i])
                            {
                                $("#groupcouleur").addClass("has-error");
                                alert("Couleur déjà utilisé !");
                                return true;
                            }
                        }
                        return "type=1&couleur="+usercolor+"&prixbebe="+$("#prixbebeajout").val();
                    }

                    function insertTarifAJAX()
                    {
                        var donnees = testDonneesAjout();
                        if(donnees == true)
                        {
                            return;
                        }
                        var xhr = getXhr();
                        xhr.onreadystatechange = function()
                        {
                            if(xhr.readyState == 4 && xhr.status == 200)
                            {
                                var result = xhr.responseText;
                                if(result == 1)
                                {
                                    location.reload();
                                }
                                else
                                {
                                    alert(result);
                                }
                            }
                        }
                        xhr.open("POST","modifTarif.php",true);
                        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
                        xhr.send(donnees);
                    }




                </script>
