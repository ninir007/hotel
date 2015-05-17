<?php
spl_autoload_register();
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include ('header.html');
include ('nav_admin.html');
?>		
<div class="row-fluid">
 <div class="span10 offset1">
    <form class="form-inline well" action="ajouterDates.php" method="post">
        <label for ="">Date début</label>
        <input type="text" id="dateDebut" name=dateDebut class="date">
        <label for ="">Date fin</label>
        <input type="text" id="dateFin" name=dateFin class="date">
        <label for ="">Nombre de lits bébé</label>
        <input type="text" id="nBebe" name=nBebe maxsize="1">
        <label for ="">Saison</label>
        <select id="laSaison" name=laSaison>
          <option value=0> </option>
            <?php
             $tarifMana = new tarifManager();
             $lesSAISONS=$tarifMana->getSais();
                        
             
              foreach($lesSAISONS as $sais)
              {
           
                 ?>
                 
                    <option value=<?php echo $sais->getCodeTarif() ?>><?php echo $sais->getCouleur();?></option>
                  <?php
                  }

                  ?>
        </select>   




         <input type="submit" >
        <span id="madr"></span>

    </form>
 </div>
</div>
<script src="./bootstrap/js/jquery-ui.js"></script>
 <script type="text/javascript">
 $(document).ready(function () {
     
 var date = new Date(); 

           
$( ".date" ).datepicker({
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
minDate: new Date(date.getFullYear(),date.getMonth(), date.getDate()+1)
});
});  
$( "form" ).submit(function( event ) {
    
  
   if($( "input:first" ).val()==="" ||$( "#dateFin" ).val()==="")
   {
   $( "span" ).text( "Pas valide!" ).show().fadeOut( 2000 );
   
   event.preventDefault();
    }
    else
    {
  
      $( "#dateFin" ).val($( "#dateFin" ).val().substring(6)+"-"+$( "#dateFin" ).val().substring(3,5)+"-"+$( "#dateFin" ).val().substring(0,2));      
      $( "#dateDebut" ).val($( "#dateDebut" ).val().substring(6)+"-"+$( "#dateDebut" ).val().substring(3,5)+"-"+$( "#dateDebut" ).val().substring(0,2));


      if($( "#dateFin" ).val() < $( "#dateDebut" ).val())
      {
        $( "span" ).text( "Date non valide!" ).show().fadeOut( 2000 );
   
        event.preventDefault();
      }

    }

  
});
</script>
</body>
</html>
