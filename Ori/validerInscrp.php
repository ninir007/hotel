
<?php
	spl_autoload_register();
	//print_r($_POST);
if($_POST['login']==-'admin')
{
    include('header.html');
    include('nav_consulter.html');
    echo "<div class='container' style='text-align: center'><h1 >inscription refusé, veuillez choisir un autre login !!</h1></div>";
}
else {
    $client = new clientManager();
    $result = $client->ajouterClient($_POST['nom'], $_POST['prenom'], $_POST['adress'], $_POST['postal'], $_POST['loc'], $_POST['login'], $_POST['password']);
    if ($result[0] == -2) {
        include('header.html');
        include('nav_consulter.html');
        echo "<div class='container' style='text-align: center'><h1 >inscription refusé, veuillez choisir un autre login !!</h1></div>";
    } else {
        if ($result[0] == -1) {

            include('header.html');
            include('nav_consulter.html');
            echo "<h1>inscription refusé, vous êtes deja inscrit !!</h1>";
        } else {
            include('header.html');
            include('nav_general.html');
            echo "<h1>inscription réussi, vous pouvez reserver !!</h1>";
        }


    }
}
?>


