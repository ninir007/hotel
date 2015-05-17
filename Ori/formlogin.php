<?php
session_start();
include ('header.html');
include ('nav_general.html');
?>	

 <link href="signin.css" rel="stylesheet">	


 <div class="container">

      <form class="form-signin" role="form" action="validerLogin.php" method=post>
      	
          <h1 class="form-signin-heading">Connexion</h1>
          <input type="text" id="login" name="login" class="form-control" placeholder="Login" required autofocus>
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <button class="btn btn-primary btn-block" type="submit">Envoyer</button>
      </form>

</div> 
<div class="alert alert-error hide">
	<h4 class="alert-heading">Erreur !
	<br/>
	Vous devez entrer au moins 4 caractures  pour le login! 
	</h4>
</div>

<script>
	$( "form" ).submit(function( event ) {
 
		if($("#login").val().length < 4){
				$("#login").addClass("error");
				$("div.alert").show("slow").delay(9000).hide("slow");
				return false;
			}

		});


 
</script>


