<!-- Affiche la liste de tous les événements, permet de passer à l'analyse d'un événement ou de consulter un élément voulu -->
<?php
    include "bdd.php";
?>

<!DOCTYPE html> 
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" href="bootstrap.css" type="text/css" media="screen">
        <title>Recueil des événements</title>
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="col-auto">
                <h1>Recueil des événements</h1>
            </div>
            <div class="col-auto">
                <a href="accueil.php"><input type="submit" value="Retour"></a>
            </div>
        </div>
        <div class="container-fluid">
            <table class="table table-striped table-sm mb-4">
                <thead>
                    <tr>
                    <form method="POST">
                        <th class="col-md-1">Numéro <input class="videB" type="submit" name="triNumero" value="v"/></th>
                        <th class="col-md-1">Date <input class="videB" type="submit" name="triDate" value="v"/></th>
                        <th class="col-md-1">Service <input class="videB" type="submit" name="triService" value="v"/></th>
                        <th class="col-md-2">Patient à risque <input class="videB" type="submit" name="triPatient" value="v"/></th>
                        <th class="col-md-2">Médicament à risque <input class="videB" type="submit" name="triMedicament" value="v"/></th>
                        <th class="col-md-3">Voie d'administration à risque <input class="videB" type="submit" name="triAdministration" value="v"/></th>
                        <th class="col-md-3">Description</th>
                        <th class="col-md-2">Consulter/Analyser</th>
                    </form>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </body>
</html>