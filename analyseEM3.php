<!-- Affiche la troisième page du formulaire d'analyse de l'événement et amène à la page 4 -->
<?php
    //include "bdd.php";
?>

<!DOCTYPE html> 
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" href="bootstrap.css" type="text/css" media="screen">
        <title>Analyser un événement (3)</title>
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="col-auto">
                <h1>Analyser un événement</h1>
            </div>
            <div class="col-auto">
                <a href="analyseEM2.php"><input type="submit" value="Retour"></a>
            </div>
        </div>
        <div class="container-fluid">
            <div class="caracterisation">
                <div class="section1">
                    <h5>Caractériser l'erreur médicamenteuse (EM)</h5>
                </div>
                <div class="md-auto">
                    <label for="degre">Degré de réalisation :</label>
                    <select class="col-2" name="degre" size="1"></select>
                </div>
                <div class="md-auto">
                    <label for="etape">Etape de survenue dans le circuit médicament :</label>
                    <select class="col-2" name="etape" size="1"></select>
                </div>
            </div>
            <div class="cotation">
                <div class="section2">
                    <h5>Cotation de l'événement</h5>
                </div>
                <div class="md-auto">
                    <label for="gravite">Gravité :</label>
                    <select name="gravite" size="1"></select>
                </div>
                <div class="md-auto">
                    <label for="occurrence">Occurrence :</label>
                    <select name="occurrence" size="1"></select>
                </div>
                <div class="md-auto">
                    <label for="maitrise">Niveau de maîtrise :</label>
                    <select name="maitrise" size="1"></select>
                </div>
                <div class="md-auto">
                    <label for="criticite">Criticité :</label>
                    <select name="criticite" size="1"></select>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="suivant"><a href="analyseEM4.php"><input type="submit" value="Suivant"></a></div>
        </div>
    </body>
</html>