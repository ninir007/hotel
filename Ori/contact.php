<?php
session_start();
include ('header.html');
if(!isset($_SESSION['login']))
include ('nav_general.html');
elseif($_SESSION['login']=="membre")
include('nav_membr.html');
?>

<link rel='stylesheet' href='contact.css' type='text/css' />  
<form action="" method="post" class="elegant-aero">
    <h1>Contact
        <span>Veuillez remplir tout les champs.</span>
    </h1>
    <label>
        <span>Votre Nom :</span>
        <input id="name" type="text" name="name" placeholder="Votre Nom Complet" />
    </label>
    
    <label>
        <span>Votre Email :</span>
        <input id="email" type="email" name="email" placeholder="Adresse Email valide" />
    </label>
    
    <label>
        <span>Message :</span>
        <textarea id="message" name="message" placeholder="Votre Message pour nous"></textarea>
    </label> 
     <label>
        <span>Sujet :</span>
        <select class="form-control" name="selection">
        <option value=0 placeholder="choisir hein"> </option>
        <option value="Postuler">Demande d'Emploi</option>
        <option value="General Question">Question General</option>
        </select>
    </label>    
     <label>
        <span>&nbsp;</span> 
        <input type="button" class="button" value="Send" /> 
    </label>    
</form>


