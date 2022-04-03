<!-- Permet d'accéder à la déclaration d'un événement, à la liste de tous les événements ou au tableau de bord -->
<?php
    include "bdd.php";
?>

<!DOCTYPE html> 
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Accueil</title>
        <link rel="icon" type="image/png" href="iconeCHIC.png">
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" href="bootstrap.css" type="text/css" media="screen">
        <link rel="stylesheet" href="style.css" type="text/css" media="screen">
        
    </head>
    <body>
        
        <div class="header" style="height: 100px"><!--<img src=logoCHIC.png/>--><h1>Outil de déclaration et d'analyse des erreurs médicamenteuses</h1></div>
        <div class="container-fluid">
            <div class="row justify-content-center">
                <p>Tout professionnel de l'établissement peut déclarer une erreur médicamenteuse</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-4 text-center" style="height: 50px"><a href="ajoutEM.php"><input class="btn btn-outline-primary" type="submit" value="Je déclare"></a></div>
            </div>
            <br>
            <br>
            <br>
            <div class="row justify-content-center">
                <p>Ne pas utiliser, ces accès sont réservés aux professionnels habilités</p>
            </div>
            <div class="row justify-content-center">
                <div class="col-4 text-center" style="height: 50px"><a href="listeEM.php"><input class="btn btn-outline-primary" type="submit" value="Consulter les erreurs médicamenteuses déclarées"></a></div>
            </div>
            <div class="row justify-content-center">
                <div class="col-4 text-center"><a href="listeAnalyses.php"><input class="btn btn-outline-primary" type="submit" value="Consulter les erreurs médicamenteuses analysées"></a></div>
            </div>

        </div>
    </body>
</html>