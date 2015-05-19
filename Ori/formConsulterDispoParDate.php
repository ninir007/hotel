<?php
session_start();
spl_autoload_register();
require_once('header.html');
	 	
		if(!isset($_SESSION['login']))
		include ('nav_general.html');
		elseif($_SESSION['login']=="admin")
		include('nav_admin.html');
		elseif($_SESSION['login']=="membre")
		include('nav_membr.html');
?>


 <link href="signin.css" rel="stylesheet">
<br>
<br>
<br>


<div class="container marketing">
<div class="col-md-9" role="main">
    <div class="panel panel-default" style="background-color: rgba(41, 16, 0, 0.54)">
        <div class="panel-heading text-center" style="background-color: rgba(41, 16, 0, 0.54); color:#B6B6B6">Vérifier Disponibilé</div>
			<form class="form-signin" role="form" action="listeChambresDispo.php" method=post>


				Dates:


			<?php
			$calendrierManager=new calendrierManager();
			$lesJours=$calendrierManager->getList();

			?>
			  	<select class="form-control" name=laDate id="lesdates"  onChange=go()>
					<option value=0> </option>
						<?php
						foreach($lesJours as $jour)
						{
			           
						?>
			        		<option value= <?php echo $jour->getDateJ()?>> <?php echo $jour->getDateJ();?></option>
						<?php
							
						}

						?>
			    </select>


				Chambres disponibles



			   <select class="form-control" name=chambresDispo id="listeChambresDispo"></select>
				

			</form>
</div>
</div>
</div>


</body>
</html>
