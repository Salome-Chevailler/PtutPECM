<!-- Affiche la troisième page du formulaire d'analyse de l'événement et amène à la page 4 -->
<?php
    include "bdd.php";
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
                    <select class="md-auto" name="degre" size="1">
                    <?php
                        // Requête SQL pour remplir le select avec les degrés de réalisation de la base
                        $rechercheDegre="SELECT nom FROM degrerealisation ORDER BY nom";
                        $params = array();
                        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                        $stmt = sqlsrv_query($conn, $rechercheDegre, $params, $options);
                        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            echo "<option>",utf8_encode(implode("",$row)),"</option>";
                        }
                    ?>
                    </select>
                </div>
                <div class="md-auto">
                    <label for="etape">Etape de survenue dans le circuit médicament :</label>
                    <select class="md-auto" name="etape" size="1">
                    <?php
                        // Requête SQL pour remplir le select avec les étapes de survenue de la base
                        $rechercheEtape="SELECT nom FROM etapecircuit ORDER BY nom";
                        $params = array();
                        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                        $stmt = sqlsrv_query($conn, $rechercheEtape, $params, $options);
                        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            echo "<option>",utf8_encode(implode("",$row)),"</option>";
                        }
                    ?>
                    </select>
                </div>
            </div>
            <div class="cotation">
                <div class="section2">
                    <h5>Cotation de l'événement</h5>
                </div>
                <div class="md-auto">
                    <label for="gravite">Gravité :</label>
                    <select name="gravite" size="1">
                        <option>1 - Mineure</option>
                        <option>2 - Significative</option>
                        <option>3 - Majeure</option>
                        <option>4 - Critique</option>
                        <option>5 - Catastrophique</option>
                    </select>
                </div>
                <div class="md-auto">
                    <label for="occurrence">Occurrence :</label>
                    <select name="occurrence" size="1">
                        <option>1 - Très improbable</option>
                        <option>2 - Très peu probable</option>
                        <option>3 - Peu probable</option>
                        <option>4 - Possible/probable</option>
                        <option>5 - Très probable à certain</option>
                    </select>
                </div>
                <div class="md-auto">
                    <label for="maitrise">Niveau de maîtrise :</label>
                    <select name="maitrise" size="1">
                        <option>1 - Très bon</option>
                        <option>2 - Bon</option>
                        <option>3 - Moyen</option>
                        <option>4 - Faible</option>
                        <option>5 - Inexistant</option>
                    </select>
                </div>
                <div class="md-auto">
                    <label for="criticite">Criticité :</label>
                    <select name="criticite" size="1">
                        <option>1 à 14 - Risque acceptable</option>
                        <option>15 à 44 - Risque acceptable sous contrôle</option>
                        <option>45 à 125 - Risque inacceptable</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="suivant"><a href="analyseEM4.php"><input type="submit" value="Suivant"></a></div>
        </div>
    </body>
</html>