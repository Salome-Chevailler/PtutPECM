<!-- Affiche la première page du formulaire d'analyse de l'événement et donne accès à la page d'analyse suivante --> 
<?php
    //include "bdd.php";
?>

<!DOCTYPE html> 
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" href="bootstrap.css" type="text/css" media="screen">
        <title>Analyser un événement (1)</title>
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="col-auto">
                <h1>Analyser un événement</h1>
            </div>
            <div class="col-auto">
                <a href="listeEM.php"><input type="submit" value="Retour"></a>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mb-1">
                <!-- Numéro analyse -->
                <div class="col-3 md-auto">
                    <label for="num">Analyse systémique n° : </label>
                    <input class="col-2" type="number" id="num" name="num" required>
                </div>
            </div>
            <div class="row mb-1">
                <!-- Date de l'analyse -->
                <div class="col-3 md-auto">
                    <label for="date">Date de l'analyse : </label>
                    <input type="date" id="date" name="date" required>
                </div>
                <!-- Date CREX -->
                <div class="col-3 md-auto">
                    <label for="date2">Présenté au CREX du : </label>
                    <input type="date" id="date2" name="date2" required>
                </div>
            </div>
            <div class="description">
                <div class="section1">
                    <h5>Quel est le problème ? (Description de l'événement)</h5>
                </div>
                <!-- Que s'est-il passé ? -->
                <div class="row mb-1">
                    <label class="col-md-auto" for="quoi">Quoi ? Que s'est-il passé ? Qui est concerné ?</label>
                    <textarea class="col-4" maxlength="1000" id="quoi" name="quoi" required></textarea>
                </div>
                <!-- En quoi est-ce un problème ?-->
                <div class="row mb-1">
                    <label class="col-md-auto" for="quoi">En quoi est-ce un problème ?</label>
                    <textarea class="col-4" maxlength="1000" id="probleme" name="probleme" required></textarea>
                </div>
                <div class="row mb-1">
                    <!-- Date de l'événement -->
                    <div class="col-3 md-auto">
                        <label for="date3">Quand ?</label>
                        <input type="date" id="date3" name="date3" required>
                    </div>
                    <!-- Service -->
                    <div class="col-3 md-auto">
                        <label for="service">Service :</label>
                        <select class="col-7" name="service" size="1"></select>
                    </div>
                </div>
            </div>
            <!-- Bouton suivant -->
            <div class="row justify-content-center">
                <div class="suivant"><a href="analyseEM2.php"><input type="submit" value="Suivant"></a></div>
            </div>
        </div>
    </body>
</html>