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
$modeleleManager=new ModeleManager();
$lesModeles= $modeleleManager->getListObj();
$tarifManager=new TarifManager();
$lesTarifs= $tarifManager->getSais();
?>


<h1 class="page-header">Modifier les prix des chambres en fonction des saisons/modéle</h1>
<div class="col-xs-12 col-lg-5">
    <div class="panel panel-default" style="background-color: rgba(41, 16, 0, 0.54)">
        <!-- Default panel contents -->
        <div class="panel-heading text-center" style="background-color: rgba(41, 16, 0, 0.54); color:#B6B6B6">Liste modéles</div>
        <div class="panel-body">
            <p>Cliquez sur un numéro de modéle pour en modifier le prix.</p>
        </div>
        <!-- Table -->
        <div class="table-responsive" style="overflow-x: auto;">
            <table class="table">
                <thead>
                <tr>
                    <th>Num. Modéle</th>
                    <th>Bain(s)</th>
                    <th>Douche(s)</th>
                    <th>WC</th>
                    <th>Nbre. lit 1 personne</th>
                    <th>Nbre. lit 2 personnes</th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($lesModeles as $modele)
                {
                    echo "<tr id = \"modele".$modele->getId_Modele()."\">\n";
                    echo "<td>";
                    echo "<input type=\"button\" onclick=\"consulterChambres(".$modele->getId_Modele().");\" title=\"Cliquez pour modifier les tarifs !\" value=\"".$modele->getId_Modele()."\">";
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
                    echo "</tr>\n";
                }
                echo  "</tbody>\n</table>\n</div>\n</div></div>\n";
                ?>
                <div class="col-xs-12 col-lg-2">
                    <div class="panel panel-default ">
                        <div class="panel-heading text-center">Chambres séléctionnées</div>
                        <div class="table-responsive">
                            <table class="table">
                                <tbody id="idBodyChambres">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-lg-5">
                    <div class="panel panel-default" style="background-color: rgba(41, 16, 0, 0.54)">
                        <div class="panel-heading text-center" style="background-color: rgba(41, 16, 0, 0.54); color:#B6B6B6">Tarifs des saisons</div>
                        <form id="modifTarifs" class="form-horizontal" role="form" action=javascript:modifierTarif(<?php echo count($lesTarifs) ?>) method=POST>
                            <?php
                            foreach($lesTarifs as $tarif)
                            {
                                echo "<div class=\"form-group ";
                                echo "form-".strtolower($tarif->getCouleur());
                                echo "\">\n<label class=\"col-xs-10 col-lg-2 control-label\">".strtoupper($tarif->getCouleur())."</label>";
                                echo "<div class=\"col-xs-10 col-lg-10\">\n";
                                echo "<input disabled class=\"form-control\" min=0 type=\"number\" id=\"codetarif".$tarif->getCodeTarif()."\" name=\"codetarif".$tarif->getCodeTarif()."\" required>\n";
                                echo "<span class=\"\"></span>\n</div>\n</div>";
                            }
                            ?>
                            <button disabled class="btn btn-lg btn-default btn-block center" id="bouton" type="submit">Valider</button>
                        </form>
                    </div>
                    <div class="label-danger" id="loading" hidden><h5 style="text-align: center">LOADING...</h5></div>
                </div>
                <div class="col-xs-12" id="erreurs">
                </div>
                <style>
                    .selected{
                        background-color: rgba(41, 16, 0, 0.34);
                    }
                </style>
<script language="Javascript">
    //Fonction nécessaire : ne rien modifier ici...
    $(document).ready(function()
    {
        $("#idBodyChambres").html("<tr><td>Cliquez sur un modéle.</td></tr>");
    });

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


    function getFormData(nbreTarifs)
    {
        str = "idModele="+$("tbody>tr.selected td>input").val()+"&";
        for(var i = 0 ; i < nbreTarifs ; i++)
        {

            var valeur = 0;
            if($("div.form-group input:eq("+i+")").val() != "")
                valeur = $("div.form-group input:eq("+i+")").val();
            str = str.concat(
                $("div.form-group input:eq("+i+")").attr('id')+"=",
                valeur+"&"
            );
        }
        return str;
    }

    var fewSeconds = 2;

    function modifierTarif(nbreTarifs)
    {
        var donnees = getFormData(nbreTarifs);
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
                document.getElementById("erreurs").innerHTML=result;
                var btn = $('#bouton');
                btn.attr('disabled',true);
                $('#loading').show();
                setTimeout(function(){
                    btn.removeAttr('disabled'); $('#loading').hide();
                }, fewSeconds*1000);
            }
        }
        xhr.open("POST","modifPrix.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xhr.send(donnees);
    }

    function consulterChambres(idModele)
    {
        if (idModele=="")
        {
            document.getElementById("idBodyChambres").innerHTML="";
            return;
        }
        $("div.form-group input").val("");
        $("tr").removeClass("selected");
        $("#modele"+idModele).addClass("selected");
        var xhr = getXhr();

        xhr.onreadystatechange = function()
        {
            if(xhr.readyState == 4 && xhr.status == 200)
            {
                $("div.form-group input, #bouton").removeAttr('disabled');
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
                    document.getElementById('idBodyChambres').innerHTML = "<tr><td>Pas de chambres pour ce modéle.</td></tr>";
                }

                if(js_result[1][0] !=  0)
                {
                    for(var i = 0; i < js_result[1].length; i++ )
                    {
                        document.getElementById("codetarif"+js_result[1][i][0]).value = js_result[1][i][1];
                    }
                }
            }
        }
        xhr.open("POST","getListChambres.php",true);
        xhr.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        xhr.send("idModele=" + idModele);
    }
</script>

