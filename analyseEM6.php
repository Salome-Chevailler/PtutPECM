<!-- Affiche la sixième page du formulaire d'analyse de l'événement et enregistre les données dans la base après validation -->
<?php
    include "bdd.php";
?>

<!DOCTYPE html> 
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" href="bootstrap.css" type="text/css" media="screen">
        <title>Analyser un événement (6)</title>
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="col-auto">
                <h1>Analyser un événement</h1>
            </div>
            <div class="col-auto">
                <a href="analyseEM5.php"><input type="submit" value="Retour"></a>
            </div>
        </div>
        <div class="container-fluid">
            <h5>Quelles sont les actions correctives et préventives ? </h5>
            <div class="action1">
                <h6>Action 1</h6>
                <div class="md-auto">
                    <label for="cause">Cause latente :</label>
                    <input type="text" id="cause" name="cause">
                </div>
                <div class="md-auto">
                    <label for="correction">Action corrective :</label>
                    <input class="col-3" type="text" id="correction" name="correction">
                </div>
                <div class="md-auto">
                    <label for="effet">Effet attendu :</label>
                    <input class="col-3" type="text" id="effet" name="effet">
                </div>
                <div class="md-auto">
                    <label for="prevue">Echéance prévue :</label>
                    <input type="text" id="prevue" name="prevue">
                </div>
                <div class="md-auto">
                    <label for="effective">Echéance effective :</label>
                    <input type="text" id="effective" name="effective">
                </div>
                <div class="md-auto">
                    <label for="pilotes">Pilotes :</label>
                    <input type="text" id="pilotes" name="pilotes">
                    <input type="submit" value="Ajouter un pilote">
                </div>
            </div>
            <div class="md-auto">
                <input type="submit" value="Ajouter une action">
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="valider"><a href="listeEM.php"><input type="submit" value="Valider"></a></div>
        </div>
    </body>
</html>