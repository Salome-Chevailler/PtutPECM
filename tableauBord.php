<!-- Contient les requêtes SQL obtenant les données à afficher et les fonctions créant les graphiques et permet d'appliquer des filtres -->
<?php
    include "bdd.php";
?>

<!DOCTYPE html> 
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" href="bootstrap.css" type="text/css" media="screen">
        <title>Tableau de bord</title>
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="col-auto">
                <h1>Tableau de bord des événements analysés</h1>
            </div>
            <div class="col-auto">
                <a href="accueil.php"><input type="submit" value="Retour"></a>
            </div>
        </div>
    </body>
</html>
