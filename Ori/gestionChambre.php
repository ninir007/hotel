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
?>

<h1 class="page-header">Chambres</h1>
<div class="table-responsive">
    <table class="table table-striped table-bordered ">
        <thead style="text-align: center;">
        <tr style="background-color: rgba(41, 16, 0, 0.54);text-align: center">
            <th style="text-align: center">Numéro</th>
            <th style="text-align: center">Id Modéle</th>
            <th style="text-align: center">Etage</th>
            <th style="text-align: center">Lit bébé</th>
            <th style="text-align: center">#</th>
        </tr>
        </thead>
        <tbody style="text-align: center;">
        <?php
            $ChambreManager = new ChambreManager();
            $lesChambres = $ChambreManager->getList();
            $lesNumeros_js = array();
            $i = 0;
            foreach($lesChambres as $chambre)
            {
                $lesNumeros_js[$i] = strtoupper($chambre->getNumero());
                $i++;
                echo "<tr>\n";
                echo "<td>".$chambre->getNumero()."</td>\n";
                echo "<td>".$chambre->getId_Modele()."</td>\n";
                echo "<td>".$chambre->getEtage()."</td>\n";
                echo "<td>";
                if($chambre->getLitbebe() == 1)
                {
                    echo "<span class=\"glyphicon glyphicon-ok\"></span>";
                }
                else
                {
                    echo "<span class=\"glyphicon glyphicon-remove\"></span>";
                }
                "</td>\n";
                echo "<td><button type=\"button\" title=\"Modifier\" onclick=\"modifierChambre('".$chambre->getNumero()."')\" class=\"btn btn-xs btn-default\"><span class=\"glyphicon glyphicon-pencil\"></span></button></td>";
                echo "</tr>\n";
            }
            echo  "</tbody>\n</table>\n</div>\n";
            $js_array = json_encode($lesNumeros_js);
            //die($js_array);
        ?>

        <div hidden class="col-xs-12" id="modification">
            <h2 class="sub-header"><span class="text-muted">Modification</span></h2>
            <form class="form-inline" role="form" action=javascript:modifChambreAJAX() method=POST>
                <div class="form-group" id="groupnumero_modif">
                    <label class="sr-only" for="numeromodif">Numéro chambre</label>
                    <input disabled type="text" class="form-control" id="numeromodif" placeholder="Numéro chambre" required>
                </div>
                <div class="form-group" id="groupmodele_modif">
                    <label class="sr-only" for="modelemodif">Modele</label>
                    <select class="form-control" id="modelemodif">
                        <?php
                        $modeleManager = new ModeleManager();
                        $lesModeles = $modeleManager->getListObj();
                        foreach($lesModeles as $modele)
                        {
                            echo "<option value=".$modele->getId_Modele()." >Modéle ".$modele->getId_Modele()."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group" id="groupetage_modif">
                    <label class="sr-only" for="etagemodif">Etage</label>
                    <input class="form-control" type="number" min=0 id="etagemodif" placeholder="Etage" required>
                </div>
                <div class="form-group" id="grouplitbebe_modif">
                    <label class="sr-only" for="litbebemodif">Lit bébé</label>
                    <select class="form-control" id="litbebemodif" required>
                        <option value=0>Lit bébé : non</option>
                        <option value=1>Lit bébé : oui</option>
                    </select>
                </div>
                <button class="btn btn-md btn-default center" type="submit">Valider</button>
            </form>
        </div>

        <div class="col-xs-12">
            <h2 class="sub-header"><span class="text-muted">Ajout nouvelle chambre</span></h2>
            <form class="form-inline" role="form" action="javascript:insertChambreAJAX()" method=POST>
                <div class="form-group" id="groupnumero">
                    <label class="sr-only" for="numeroajout">Numéro chambre</label>
                    <input type="text" class="form-control" id="numeroajout" placeholder="Numéro chambre" required>
                </div>
                <div class="form-group" id="groupmodele">
                    <label class="sr-only" for="modeleajout">Modele</label>
                    <select class="form-control" id="modeleajout">
                        <?php
                        foreach($lesModeles as $modele)
                        {
                            echo "<option value=".$modele->getId_Modele()." >Modéle ".$modele->getId_Modele()."</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group" id="groupetage">
                    <label class="sr-only" for="etageajout">Etage</label>
                    <input class="form-control" type="number" min=0 id="etageajout" placeholder="Etage" required>
                </div>
                <div class="form-group" id="grouplitbebe">
                    <label class="sr-only" for="litbebeajout">Lit bébé</label>
                    <select class="form-control" id="litbebeajout" required>
                        <option value=0>Lit bébé : non</option>
                        <option value=1>Lit bébé : oui</option>
                    </select>
                </div>
                <button class="btn btn-md btn-default center" type="submit">Valider</button>
            </form>
        </div>

        <script>

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

            var numero_chambres = <?php echo $js_array ?>;
            function testDonneesAjout()
            {
                var user_numero = $("#numeroajout").val().toUpperCase();
                var user_modele = $("#modeleajout").val();
                var user_etage = $("#etageajout").val();
                var user_litbebe = $("#litbebeajout").val();
                $(".has-error").removeClass("has-error");
                if(user_numero.length <= 1 || user_numero.length > 4 ||  user_numero.match(/[^a-zA-Z0-9]/) != null || user_numero.match(/[0-9]/) == null)
                {
                    $("#groupnumero").addClass("has-error");
                    return true;
                }
                for(var i = 0; i < numero_chambres.length; i++)
                {
                    if( numero_chambres[i].localeCompare(user_numero) == 0 )
                    {
                        $("#groupnumero").addClass("has-error");
                        alert("Numéro de chambre déjà utilisé !");
                        return true;
                    }
                }
                return "type=ins&numero="+user_numero+"&idmodele="+user_modele+"&etage="+user_etage+"&litbebe="+user_litbebe;
            }

            function insertChambreAJAX()
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
                xhr.open("POST","ajoutChambre.php",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
                xhr.send(donnees);
            }

            function modifChambreAJAX()
            {
                var numero = $("#numeromodif").val();
                var modele = $("#modelemodif").val();
                var etage = $("#etagemodif").val();
                var litbebe = $("#litbebemodif").val();
                var donnees = "type=mod&numero="+numero+"&idmodele="+modele+"&etage="+etage+"&litbebe="+litbebe;
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
                xhr.open("POST","ajoutChambre.php",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
                xhr.send(donnees);
            }

            function modifierChambre(numero)
            {
                $(".danger").removeClass("danger");
                $("#numeromodif").val(numero);
                $('td:first-child').each( function(){
                    if(numero == $(this).text())
                    {
                        $(this).parent().addClass("danger");
                        $(this).siblings().each(function(index){
                            if(index>2)
                                return false;
                            if(index==0)
                            {
                                $("#modelemodif").val($(this).text());
                            }
                            if(index==1)
                            {
                                $("#etagemodif").val($(this).text());
                            }
                            if(index==2)
                            {
                                if($(this).html() == "<span class=\"glyphicon glyphicon-remove\"></span>")
                                {
                                    $("#litbebemodif").val(0);
                                }
                                else
                                {
                                    $("#litbebemodif").val(1);
                                }
                            }
                        });
                    }
                });
                $("#modification").show();
            }

            </script>