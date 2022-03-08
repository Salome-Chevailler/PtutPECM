<!-- Affiche le formulaire d'analyse de l'événement et ajoute les éléments dans la base lors de la validation --> 
<?php
    include "bdd.php";
?>

<!DOCTYPE html> 
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" href="bootstrap.css" type="text/css" media="screen">
        <title>Analyse des causes d'une erreur médicamenteuse</title>
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="col-auto">
                <h1>Analyse des causes d'une erreur médicamenteuse</h1>
            </div>
            <div class="col-auto">
                <a href="listeEM.php"><input type="submit" value="Retour"></a>
            </div>
        </div>
        <div class="container-fluid">
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
                    <h4>ETAPE 1 : Quel est le problème ? (Description de l'événement)</h4>
                </div>
                <!-- Que s'est-il passé ? -->
                <div class="row mb-1">
                    <label class="col-md-auto" for="quoi">Quoi ? Que s'est-il passé ?</label>
                    <textarea class="col-4" maxlength="1000" id="quoi" name="quoi" required></textarea>
                </div>
                <!-- Qui est concerné ? -->
                <div class="row mb-1">
                    <label class="col-md-auto" for="quoi">Qui est concerné ?</label>
                    <input class="col-3" maxlength="100" id="quoi" name="qui" required></textarea>
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
                        <select class="col-7" name="service" size="1">
                        <?php
                        // Requête SQL pour remplir le select avec les départements de la base
                        $rechercheDepartement="SELECT nom FROM departement ORDER BY nom";
                        $params = array();
                        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                        $stmt = sqlsrv_query($conn, $rechercheDepartement, $params, $options);
                        while($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                            echo "<option>",utf8_encode(implode("",$row)),"</option>";
                        }
                        ?>
                        </select>
                    </div>
                </div>
            </div>
            <h5>Qu'a-t-il été fait dans un premier temps ? </h5>
            <div class="row mb-1">
                <label class="col-6" for="action">Décrire ici les premières actions mises en place à la découverte de l'événement</label>  
            </div>
            <!-- Premières actions -->
            <textarea class="col-4" maxlength="1000" id="action" name="action" required></textarea>
            <div class="caracterisation">
                <div class="section">
                    <h5>Caractériser l'erreur médicamenteuse (EM)</h5>
                </div>
                <!-- Médicament à risque -->
                <div class="md-auto">
                    <label for="medicament">Est-ce un médicament à risque ?</label>
                    <input type="radio" id="medicament" name="medicament" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="medicament" name="medicament" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <div class="md-auto">
                    <label for="medicament">Elle concerne :</label>
                </div>
                <!-- Médicament -->
                <div class="md-auto">
                    <input type="radio" id="type" name="type" value="medicament" required>
                    <label for="Un medicament">Un médicament, </label>
                    <label for="Qui est">qui est :</label>
                    <input type="radio" id="refrigere" name="refrigere" value="refrigere" required>
                    <label for="refrigere">Réfrigéré</label>
                    <input type="radio" id="refrigere" name="refrigere" value="nonrefrigere" required>
                    <label for="nonrefrigere">Non réfrigéré</label>
                </div>
                <!-- Stupéfiant -->
                <div class="md-auto">
                    <input type="radio" id="type" name="type" value="stupefiant" required>
                    <label for="Un stupefiant">Un stupéfiant</label> 
                </div>
                <!-- Chimiothérapie -->
                <div class="md-auto">
                    <input type="radio" id="type" name="type" value="chimio" required>
                    <label for="Une chimiotherapie">Une chimiothérapie, </label>
                    <label for="Qui est">qui est :</label> 
                    <input type="radio" id="refrigere2" name="refrigere2" value="refrigere" required>
                    <label for="refrigere">Réfrigérée</label>
                    <input type="radio" id="refrigere2" name="refrigere2" value="nonrefrigere" required>
                    <label for="nonrefrigere">Non réfrigérée</label>
                </div>
                <!-- Never event -->
                <div class="md-auto">
                    <label for="neverevent">Est-ce un never-event (NE) ?</label>
                    <input type="radio" id="neverevent" name="neverevent" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="neverevent" name="neverevent" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- Types de never event-->
                <div class="md-auto">
                    <label for="neverevent2">Si oui, précisez le(s)quel(s) :</label>
                    <input type="checkbox" id="n1" name="n1" required>
                    <label for="n1">NE1</label>
                    <input type="checkbox" id="n2" name="n2" required>
                    <label for="n2">NE2</label>
                    <input type="checkbox" id="n3" name="n3" required>
                    <label for="n3">NE3</label>
                    <input type="checkbox" id="n4" name="n4" required>
                    <label for="n4">NE4</label>
                    <input type="checkbox" id="n5" name="n5" required>
                    <label for="n5">NE5</label>
                    <input type="checkbox" id="n6" name="n6" required>
                    <label for="n6">NE6</label>
                    <input type="checkbox" id="n7" name="n7" required>
                    <label for="n7">NE7</label>
                    <input type="checkbox" id="n8" name="n8" required>
                    <label for="n8">NE8</label>
                    <input type="checkbox" id="n9" name="n9" required>
                    <label for="n9">NE9</label>
                    <input type="checkbox" id="n10" name="n10" required>
                    <label for="n10">NE10</label>
                    <input type="checkbox" id="n11" name="n11" required>
                    <label for="n11">NE11</label>
                    <input type="checkbox" id="n12" name="n12" required>
                    <label for="n12">NE12</label>
                </div>
                <!-- Degré de réalisation -->
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
                <!-- Etape de survenue dans le circuit médicament -->
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
            <!-- Cotation -->
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
            <h4>ETAPE 2 : Quels sont les dysfonctionnements, les erreurs ? </h4>
            <!-- Dysfonctionnements -->
            <div class="row mb-1">
                <label class="col-6" for="action">Défaillances actives ou immédiates ou défauts de soin</label>  
            </div>
            <textarea class="col-4" maxlength="1000" id="dysfonctionnement" name="dysfonctionnement" required></textarea>
            <!-- Facteurs -->
            <div class="causes">
                <div class="section1">
                    <h4>ETAPE 3 : Pourquoi cela est-il arrivé ? (causes latentes systémiques)</h4>
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
            <h4>ETAPE 4 : Qu'est-ce qui aurait pu empêcher la survenue de l'événement ? </h4>
            <!-- Est-ce que tout avait été mis en oeuvre pour éviter ce type d'EI ? -->
            <div class="md-auto">
                    <label for="prevention">Est-ce que tout avait été mis en oeuvre pour éviter ce type d'EI ?</label>
                    <input type="radio" id="prevention" name="prevention" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="prevention" name="prevention" value="Non" required>
                    <label for="Non">Non</label> 
            </div>
            <!-- Défenses -->
            <div class="row mb-1">
                <label class="col-6" for="action">Si non, quelles ont été les défenses manquantes ou non opérationnelles ?</label>  
            </div>
            <textarea class="col-4" maxlength="1000" id="defenses" name="defenses" required></textarea>
            <h4>ETAPE 5 : Quelles sont les actions correctives et préventives ? </h4>
            <table class="table table-striped table-sm mb-4">
                <thead>
                    <tr>
                        <th>Cause latente</th>
                        <th>Action corrective</th>
                        <th>Effet attendu</th>
                        <th>Echéance prévue</th>
                        <th>Echéance effective</th>
                        <th>Pilotes</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td contenteditable="true">Exemple</td>
                        <td contenteditable="true">Exemple</td>
                        <td contenteditable="true">Exemple</td>
                        <td contenteditable="true">Exemple</td>
                        <td contenteditable="true">Exemple</td>
                        <td contenteditable="true">Exemple</td>
                    </tr>
                </tbody>
            </table>
            <div class="md-auto">
                <input type="submit" value="Ajouter une action">
            </div>
            <!-- Bouton de validation -->
            <div class="row justify-content-center">
                <div class="valider"><a href="listeEM.php"><input type="submit" value="Valider"></a></div>
            </div>
        </div>
    </body>
</html>