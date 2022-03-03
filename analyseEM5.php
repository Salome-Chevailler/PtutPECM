<!-- Affiche la cinquième page du formulaire d'analyse de l'événement et amène à la page 6 -->
<?php
    include "bdd.php";
?>

<!DOCTYPE html> 
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" href="bootstrap.css" type="text/css" media="screen">
        <title>Analyser un événement (5)</title>
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="col-auto">
                <h1>Analyser un événement</h1>
            </div>
            <div class="col-auto">
                <a href="analyseEM4.php"><input type="submit" value="Retour"></a>
            </div>
        </div>
        <div class="container-fluid">
            <h5>Récapitulatif des facteurs sélectionnés. Etaient-ils évitables ?</h5>
            <table class="table table-striped table-sm mb-4">
                <thead>
                    <tr>
                        <th>Facteurs</th>
                        <th>Evitable ?</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="row justify-content-center">
            <div class="suivant"><a href="analyseEM6.php"><input type="submit" value="Suivant"></a></div>
        </div>
    </body>
</html>