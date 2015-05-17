<?php
include ('header.html');
include ('nav_general.html');
?>

<div class="container">
 


<h1>Formulaire d'inscription</h1>  
<p>Utiliser la tabulation pour naviguer d'un champs à l'autre.</p>  
<form class="form-signin" role=form action="validerInscrp.php" method=post>  
<ul>  
<li><label for="userid">Login:</label></li>  
<li><input type="text" name=login required pattern=".{4,}" title="4 caractéres minimum" autofocus size="12" /></li>  
<li><label for="passid">Password:</label></li>  
<li><input type="password" name=password id="password" required size="12" /></li>  
<li><label for="username">Nom:</label></li>  
<li><input type="text" name=nom required size="24" /></li> 
<li><label for="userfname">Prenom:</label></li>  
<li><input type="text" name=prenom required size="24" /></li> 
<li><label for="address">Adresse:</label></li>  
<li><input type="text" name=adress required size="50" /></li>  
<li><label for="zipcode">Code postal:</label></li>  
<li><input type="text" name=postal required pattern=".{4,}" required size="12" /></li>
<li><label for="loca">Localité:</label></li>  
<li><input type="text" name=loc /></li>
<li><input type="submit" /></li>  
</ul>  
</form>  
 
</div>

<link rel='stylesheet' href='js-form-validation.css' type='text/css' > 