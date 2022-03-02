<!-- Affiche la quatrième page du formulaire d'analyse de l'événement et amène à la page 5 -->
<?php
    include "bdd.php";
?>

<!DOCTYPE html> 
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" href="bootstrap.css" type="text/css" media="screen">
        <title>Analyser un événement (4)</title>
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="col-auto">
                <h1>Analyser un événement</h1>
            </div>
            <div class="col-auto">
                <a href="analyseEM3.php"><input type="submit" value="Retour"></a>
            </div>
        </div>
        <div class="container-fluid">
            <h5>Quels sont les dysfonctionnements, les erreurs ? </h5>
            <div class="row mb-1">
                <label class="col-6" for="action">Défaillances actives ou immédiates ou défauts de soin</label>  
            </div>
            <!-- Dysfonctionnements -->
            <textarea class="col-4" maxlength="1000" id="dysfonctionnement" name="dysfonctionnement" required></textarea>
            <!-- Facteurs -->
            <div class="causes">
                <div class="section1">
                    <h5>Pourquoi cela est-il arrivé ? (causes latentes systémiques)</h5>
                </div>
                <div class="md-auto">
                    <label for="facteur">L'erreur est-elle liée à des facteurs propres aux patients ?</label>
                    <select class="md-auto" name="facteur" size="1">
                    <?php
                        // Requête SQL pour remplir le select avec les facteurs propres aux patients
                        $facteurPatient="SELECT libelle FROM facteur WHERE categorie='Patient'";
                        $params = array();
                        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                        $stmt = sqlsrv_query($conn, $facteurPatient, $params, $options);
                        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            echo "<option>",utf8_encode(implode("",$row)),"</option>";
                        }
                    ?>
                    <option>Autre</option>
                    </select>
                </div>
                <div class="md-auto">
                    <label for="facteur2">L'erreur est-elle liée à des facteurs individuels ?</label>
                    <select class="md-auto" name="facteur2" size="1">
                    <?php
                        // Requête SQL pour remplir le select avec les facteurs individuels
                        $facteurIndividuel="SELECT libelle FROM facteur WHERE categorie='Individuel'";
                        $params = array();
                        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                        $stmt = sqlsrv_query($conn, $facteurIndividuel, $params, $options);
                        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            echo "<option>",utf8_encode(implode("",$row)),"</option>";
                        }
                    ?>
                    <option>Autre</option>
                    </select>
                </div>
                <div class="md-auto">
                    <label for="facteur3">L'erreur est-elle liée à des facteurs concernant l'équipe ?</label>
                    <select class="md-auto" name="facteur3" size="1">
                    <?php
                        // Requête SQL pour remplir le select avec les facteurs concernant l'équipe
                        $facteurEquipe="SELECT libelle FROM facteur WHERE categorie='Equipe'";
                        $params = array();
                        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                        $stmt = sqlsrv_query($conn, $facteurEquipe, $params, $options);
                        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            echo "<option>",utf8_encode(implode("",$row)),"</option>";
                        }
                    ?>
                    <option>Autre</option>
                    </select>
                </div>
                <div class="md-auto">
                    <label for="facteur4">L'erreur est-elle liée à des tâches à accomplir ?</label>
                    <select class="md-auto" name="facteur4" size="1">
                    <?php
                        // Requête SQL pour remplir le select avec les facteurs liés aux tâches à accomplir
                        $facteurTache="SELECT libelle FROM facteur WHERE categorie='Tache'";
                        $params = array();
                        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                        $stmt = sqlsrv_query($conn, $facteurTache, $params, $options);
                        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            echo "<option>",utf8_encode(implode("",$row)),"</option>";
                        }
                    ?>
                    <option>Autre</option>
                    </select>
                </div>
                <div class="md-auto">
                    <label for="facteur5">L'erreur est-elle liée à des facteurs concernant l'environnement ?</label>
                    <select class="md-auto" name="facteur5" size="1">
                    <?php
                        // Requête SQL pour remplir le select avec les facteurs environnementaux
                        $facteurEnvironnemental="SELECT libelle FROM facteur WHERE categorie='Environnemental'";
                        $params = array();
                        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                        $stmt = sqlsrv_query($conn, $facteurEnvironnemental, $params, $options);
                        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            echo "<option>",utf8_encode(implode("",$row)),"</option>";
                        }
                    ?>
                    <option>Autre</option>
                    </select>
                </div>
                <div class="md-auto">
                    <label for="facteur6">L'erreur est-elle liée à des facteurs concernant l'organisation ?</label>
                    <select class="md-auto" name="facteur6" size="1">
                    <?php
                        // Requête SQL pour remplir le select avec les facteurs organisationnels
                        $facteurOrganisationnel="SELECT libelle FROM facteur WHERE categorie='Organisationnel'";
                        $params = array();
                        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                        $stmt = sqlsrv_query($conn, $facteurOrganisationnel, $params, $options);
                        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            echo "<option>",utf8_encode(implode("",$row)),"</option>";
                        }
                    ?>
                    <option>Autre</option>
                    </select>
                </div>
                <div class="md-auto">
                    <label for="facteur7">L'erreur est-elle liée à des facteurs concernant le contexte institutionnel ?</label>
                    <select class="md-auto" name="facteur7" size="1">
                    <?php
                        // Requête SQL pour remplir le select avec les facteurs institutionnels
                        $facteurInstitutionnel="SELECT libelle FROM facteur WHERE categorie='Institutionnel'";
                        $params = array();
                        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                        $stmt = sqlsrv_query($conn, $facteurInstitutionnel, $params, $options);
                        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            echo "<option>",utf8_encode(implode("",$row)),"</option>";
                        }
                    ?>
                    <option>Autre</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="suivant"><a href="analyseEM5.php"><input type="submit" value="Suivant"></a></div>
        </div>
    </body>
</html>