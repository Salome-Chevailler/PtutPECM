<!-- Permet d'accéder à la déclaration d'un événement, à la liste de tous les événements ou au tableau de bord -->
<?php
    //include "bdd.php";
?>

<!DOCTYPE html> 
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Accueil</title>
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" href="bootstrap.css" type="text/css" media="screen">
        <link rel="stylesheet" href="style.css" type="text/css" media="screen">
    </head>
    <body>
        
        <div class="header" style="height: 100px"><h1>Erreurs médicamenteuses</h1></div>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-4 text-center" style="height: 50px"><a href="listeEM.php"><input class="btn btn-outline-primary" type="submit" value="Consulter les événements"></a></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-4 text-center" style="height: 50px"><a href="ajoutEM.php"><input class="btn btn-outline-primary" type="submit" value="Déclarer un événement"></a></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-4 text-center"><a href="tableauBord.php"><input class="btn btn-outline-primary" type="submit" value="Tableau de bord"></a></div>
            </div>
            
        </div>
    </body>
</html>