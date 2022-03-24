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
        <link rel="stylesheet" href="style.css" type="text/css" media="screen">
        
    </head>
    <header class="header">
    <div class="logo-box">
            <span class="logo">logo</span>
        </div>
        <div class="text-title">
            <h1 class="main-title">
                <span class="heading-primary-main">Outil de déclaration et d'analyse des erreurs médicamenteuses</span>
                <span class="heading-secondary"></span>
            </h1>
        </div>
    </header>
    <body>
        
        <div class="buttonsHomePage">
               <button class="buttonHomePage" type="submit" onclick="location.href='ajoutEM.html'" value="Déclarer un événement">
                       Déclarer un événement<img class="favicon" src="pen_line.png"/></button>
        </div>
<div class="buttonsHomePage">
    <button class="buttonHomePage" type="submit" onclick="location.href='listeEM.html'" value="Consulter les erreurs médicamenteuses déclarées">Consulter les erreurs
        médicamenteuses
        déclarées <img class="favicon" src="open-book.png"/>
    </button>
</div>
            <div class="buttonsHomePage">
                <button class="buttonHomePage" type="submit" onclick="location.href='listeAnalyses.html'" value="Consulter les erreurs médicamenteuses analysées">
                    Consulter les erreurs médicamenteuses analysées<img id="loupe" class="favicon" src="analyze.png"/>
                </button>
            </div>

    </body>
</html>