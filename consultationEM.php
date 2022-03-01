<!-- Contient les requêtes récupérant les données de l'événement choisi et affiche les données -->
<?php
    //include "bdd.php";
?>

<!DOCTYPE html> 
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" href="bootstrap.css" type="text/css" media="screen">
        <title>Consulter événement analysé au CREX</title>
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="col-auto">
                <h1>Consulter événement analysé au CREX</h1>
            </div>
            <div class="col-auto">
                <a href="listeEM.php"><input type="submit" value="Retour"></a>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mb-1">
                <label class="col-6" for="Numero"><strong>Numéro fiche de recueil : </strong></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="DateAnalyse"><strong>Date de l'analyse : </strong></label>
                <label class="col-6" for="DateModif"><strong>Date de la dernière modification : </strong></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="DateEM"><strong>Date de l'événement : </strong></label>
                <label class="col-6" for="Service"><strong>Service : </strong></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Description"><strong>Description : </strong></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="PremierTemps"><strong>Qu'a-t-il été fait dans un premier temps ? </strong></label>
            </div>
            <div class="md-auto">
                <h4>Caractérisation de l'erreur médicamenteuse</h4>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Administration"><strong>Voie d'administration à risque : </strong></label>
                <label class="col-6" for="Precisions"><strong>Précisions : </strong></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Patient"><strong>Patient à risque : </strong></label>
                <label class="col-6" for="Medicament"><strong>Médicament à risque : </strong></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Type"><strong>L'erreur médicamenteuse concerne : </strong></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Neverevent"><strong>Est-ce un never-event (NE) ? </strong></label>
                <label class="col-6" for="NE"><strong>Le(s)quel(s) ? </strong></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Degre"><strong>Degré de réalisation : </strong></label>
                <label class="col-6" for="Etape"><strong>Etape de survenue dans le circuit médicament : </strong></label>
            </div>
            <div class="md-auto">
                <h4>Cotation de l'événement</h4>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Gravite"><strong>Gravité : </strong></label>
                <label class="col-6" for="Occurrence"><strong>Occurrence : </strong></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Niveau"><strong>Niveau de maîtrise : </strong></label>
                <label class="col-6" for="Criticite"><strong>Criticité : </strong></label>
            </div>
            <div class="md-auto">
                <h4>Causes latentes systémiques</h4>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Dysfonctionnement"><strong>Quels sont les dysfonctionnements, les erreurs ? </strong></label>
                <label class="col-6" for="Facteurs"><strong>Pourquoi cela est-il arrivé ? </strong></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Actions"><strong>Quelles sont les actions correctives et préventives ? </strong></label>
            </div>
        </div>        
    </body>
</html>