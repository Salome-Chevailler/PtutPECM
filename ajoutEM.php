<!-- Affiche le formulaire de déclaration d'un événement et enregistre l'événement dans la base de données après validation -->
<?php
    include "bdd.php";
?>

<!DOCTYPE html> 
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" href="bootstrap.css" type="text/css" media="screen">
        <title>Déclarer un événement</title>
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="col-auto">
                <h1>Déclarer un événement</h1>
            </div>
            <div class="col-auto">
                <a href="accueil.php"><input type="submit" value="Retour"></a>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mb-1">
                <!-- Service -->
                <div class="col-2 md-auto">
                    <label for="service">Service :</label>
				    <select class="col-7" name="service" size="1"></select>
                </div>
                <!-- Numéro fiche -->
                <div class="col-3 md-auto">
                    <label for="num">N° fiche de recueil :</label>
                    <input class="col-2" type="number" id="num" name="num" required>
                </div>
            </div>
            <!-- Date de l'événement -->
            <div class="row mb-1">
                <label class="col-md-auto" for="date">Date de l'événement : </label>
                <input type="date" id="date" name="date" required>
            </div>
            <!-- Description -->
            <div class="row mb-1"> 	
                <label class="col-md-auto" for="description">Description de l'événement et de ses conséquences : </label>
                <textarea class="col-4" maxlength="1000" id="description" name="description" required></textarea>
            </div>
            <!-- Never event -->
            <div class="md-auto">
                <label for="neverevent">Est-ce un never-event (NE) ?</label>
                <input type="radio" id="neverevent" name="neverevent" value="Oui" required>
                <label for="Oui">Oui</label>
                <input type="radio" id="neverevent" name="neverevent" value="Non" required>
                <label for="Non">Non</label> 
                <input type="radio" id="neverevent" name="neverevent" value="Jenesaispas" required>
                <label for="Jenesaispas">Je ne sais pas</label>       
            </div>
            <div class="row mb-1">
                <!-- Patient à risque -->
                <div class="col-2 md-auto">
                    <input type="checkbox" id="patient" name="patient" required>
                    <label for="patient">Patient à risque</label>
                </div>
                <!-- Médicament à risque -->
                <div class="col-2 md-auto">
                    <input type="checkbox" id="medicament" name="medicament" required>
                    <label for="medicament">Médicament à risque</label>
                </div>
            </div>
            <div class="row mb-1">
                <!-- Voie d'administration risquée -->
                <div class="col-2 md-auto">
                    <input type="checkbox" id="administration" name="administration" required>
                    <label for="administration">Voie d'administration risquée</label>
                </div>
                <!-- Précisions -->
                <div class="col-3 md-auto">
                    <label for="precisions">Précisions :</label>
                    <input type="text" id="precisions" name="precisions">
                </div>
            </div>
            <!-- Bouton d'ajout -->
            <div class="row justify-content-center">
                <div class="ajouter"><a href="listeEM.php"><input type="submit" value="Ajouter l'événement"></a></div>
            </div>
        </div>
    </body>
</html>
