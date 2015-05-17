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

<h1 class="page-header">Modéles</h1>
<div class="table-responsive">
    <table class="table table-striped table-bordered">
        <thead>
        <tr style="background-color: rgba(41, 16, 0, 0.54);">
            <th style="text-align: center">Num. Modéle</th>
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
                echo "<tr id=modele".$modele->getId_Modele()." style='text-align: center'>\n";
                echo "<td>";
                echo $modele->getId_Modele();
                echo "</td>\n";
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
                echo "<td><button type=\"button\" title=\"Modifier\" onclick=\"modifierModele('".$modele->getId_Modele()."')\" class=\"btn btn-xs btn-default\"><span class=\"glyphicon glyphicon-pencil\"></span></button></td>";
                echo "</tr>\n";
            }
            echo  "</tbody>\n</table>\n</div>\n";
        ?>

        <div hidden class="col-xs-12" id="modification">
            <h2 class="sub-header"><span class="text-muted">Modification</span></h2>
            <form class="form-inline" role="form" action=javascript:modifModeleAJAX() method=POST>
                <div class="form-group" id="groupmodele">
                    <label class="sr-only" for="idmodelemodif">Id Modéle</label>
                    <input disabled type="text" class="form-control" id="idmodelemodif" placeholder="AUTOMATIQUE" required>
                </div>
                <div class="form-group">
                    <label class="sr-only" for="bainmodif">Bain</label>
                    <select class="form-control" id="bainmodif">
                        <option value=0>Bain : non</option>
                        <option value=1>Bain : oui</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="sr-only" for="douchemodif">Douche</label>
                    <select class="form-control" id="douchemodif">
                        <option value=0>Douche : non</option>
                        <option value=1>Douche : oui</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="sr-only" for="wcmodif">Douche</label>
                    <select class="form-control" id="wcmodif">
                        <option value=0>WC : non</option>
                        <option value=1>WC : oui</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="sr-only" for="lit1pmodif">Nbre lit 1 personne</label>
                    <input class="form-control" type="number" min=0 id="lit1pmodif" placeholder="Nbre lit 1 personne" required>
                </div>
                <div class="form-group" id="grouplit2p">
                    <label class="sr-only" for="lit2pmodif">Nbre lit 2 personne</label>
                    <input class="form-control" type="number" min=0 id="lit2pmodif" placeholder="Nbre lit 2 personne" required>
                </div>
                <button class="btn btn-md btn-default center" type="submit">Valider</button>
            </form>
        </div>

        <div class="col-xs-12">
            <h2 class="sub-header"><span class="text-muted">Ajout nouveau modéle</span></h2>
            <form class="form-inline" role="form" action=javascript:insertModeleAJAX() method=POST>
                <div class="form-group" id="groupmodele">
                    <label class="sr-only" for="idmodeleajout">Id Modéle</label>
                    <input disabled type="text" class="form-control" id="idmodeleajout" placeholder="AUTOMATIQUE" required>
                </div>
                <div class="form-group" id="groupbain">
                    <label class="sr-only" for="bainajout">Bain</label>
                    <select class="form-control" id="bainajout">
                        <option value=0>Bain : non</option>
                        <option value=1>Bain : oui</option>
                    </select>
                </div>
                <div class="form-group" id="groupdouche">
                    <label class="sr-only" for="doucheajout">Douche</label>
                    <select class="form-control" id="doucheajout">
                        <option value=0>Douche : non</option>
                        <option value=1>Douche : oui</option>
                    </select>
                </div>
                <div class="form-group" id="groupwc">
                    <label class="sr-only" for="wcajout">Douche</label>
                    <select class="form-control" id="wcajout">
                        <option value=0>WC : non</option>
                        <option value=1>WC : oui</option>
                    </select>
                </div>
                <div class="form-group" id="grouplit1p">
                    <label class="sr-only" for="lit1pajout">Nbre lit 1 personne</label>
                    <input class="form-control" type="number" min=0 id="lit1pajout" placeholder="Nbre lit 1 personne" required>
                </div>
                <div class="form-group" id="grouplit2p">
                    <label class="sr-only" for="lit1pajout">Nbre lit 2 personne</label>
                    <input class="form-control" type="number" min=0 id="lit2pajout" placeholder="Nbre lit 2 personne" required>
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

            function insertModeleAJAX()
            {
                var donnees = "type=ins&bain="+$("#bainajout").val()+"&douche="+$("#doucheajout").val()+"&wc="+$("#wcajout").val()+"&lit1p="+$("#lit1pajout").val()+"&lit2p="+$("#lit2pajout").val();

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
                xhr.open("POST","ajoutModele.php",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
                xhr.send(donnees);
            }

            function modifModeleAJAX()
            {
                var idmodele = $("#idmodelemodif").val();
                var bain = $("#bainmodif").val();
                var douche = $("#douchemodif").val();
                var wc = $("#wcmodif").val();
                var lit1p = $("#lit1pmodif").val();
                var lit2p = $("#lit2pmodif").val();
                var donnees = "type=mod&idmodele="+idmodele+"&bain="+bain+"&douche="+douche+"&wc="+wc+"&lit1p="+lit1p+"&lit2p="+lit2p;
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
                xhr.open("POST","ajoutModele.php",true);
                xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
                xhr.send(donnees);
            }

            function modifierModele(numero)
            {
                $(".danger").removeClass("danger");
                $("#idmodelemodif").val(numero);
                $('td:first-child').each( function(){
                    if(numero == $(this).text())
                    {
                        $(this).parent().addClass("danger");
                        $(this).siblings().each(function(index){
                            if(index>4)
                                return false;
                            if(index==0)
                            {
                                if($(this).html() == "<span class=\"glyphicon glyphicon-remove\"></span>")
                                {
                                    $("#bainmodif").val(0);
                                }
                                else
                                {
                                    $("#bainmodif").val(1);
                                }
                            }
                            if(index==1)
                            {
                                if($(this).html() == "<span class=\"glyphicon glyphicon-remove\"></span>")
                                {
                                    $("#douchemodif").val(0);
                                }
                                else
                                {
                                    $("#douchemodif").val(1);
                                }
                            }
                            if(index==2)
                            {
                                if($(this).html() == "<span class=\"glyphicon glyphicon-remove\"></span>")
                                {
                                    $("#wcmodif").val(0);
                                }
                                else
                                {
                                    $("#wcmodif").val(1);
                                }
                            }
                            if(index==3)
                            {
                                $("#lit1pmodif").val($(this).text());
                            }
                            if(index==4)
                            {
                                $("#lit2pmodif").val($(this).text());
                            }
                        });
                    }
                });
                $("#modification").show();
            }

        </script>