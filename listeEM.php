<!-- Affiche la liste de tous les événements déclarés, permet de passer à l'analyse d'un événement ou de consulter un élément voulu -->
<?php
    include "bdd.php";
?>

<!DOCTYPE html> 
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link rel="icon" type="image/png" href="iconeCHIC.png">
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" href="bootstrap.css" type="text/css" media="screen">
        <title>Consultation des erreurs médicamenteuses déclarées</title>
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="header">
                <h1>Consultation des erreurs médicamenteuses déclarées</h1>
            </div>
            <div class="col-auto">
                <a href="accueil.php"><input class="btn btn-outline-primary" type="submit" value="Retour"></a>
            </div>
        </div>
        <div>
        <!-- Formulaire pour le filtrage des événements -->
            <form method="POST">
                <div class="md-auto">
                    <!-- Filtrage par date -->
                    <br>
                    <label class="col-auto ml-2" for="date">Choisir une période : du</label>
                    <input class="col-auto nom mr-2" type="date" name="dateDebut">
                    <label class="col-auto mr-2">au</label>
                    <input class="col-auto nom mr-3" type="date" name="dateFin">
                    <label class="col-auto mr-2">et/ou un service : </label>
                    <!-- Filtrage par service -->
                    <select name="tri_departement" size="1">
                        <option></option>
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
                    <!-- Bouton lançant la recherche -->        
                    <input class="btn btn-outline-primary" type="submit" name="Rechercher" value="Rechercher">   
                </div>   
                <div class="md-auto">
                    <br>
                    <label class="col-auto ml-2"><strong>Filtrer les événements déclarés avec plus de précision :</strong></label>
                </div>
                <div class="md-auto">
                    <!-- Filtrage par médicament à risque -->
                    <label class="col-auto ml-2">Médicament à risque : </label>
                    <input type="checkbox" id="tri_medicament_risque" name="tri_medicament_risque">Oui</input>
                </div>
                <div class="md-auto">
                    <!-- Filtrage par classe de médicament -->
                    <label class="col-auto ml-2">Classe du médicament : </label>
                    <select name="tri_classe" size="1">
                    </select>
                </div>
                <div class="md-auto">
                    <!-- Filtrage par degré -->
                    <label class="col-auto ml-2">Degré de réalisation : </label>
                    <select name="tri_degre" size="1">
                        <option></option>
                        <option>EM a atteint le patient</option>
                        <option>EM a été interceptée</option>
                        <option>Evénement porteur de risque (EPR)</option>
                    </select>
                </div>
                <div class="md-auto">
                    <!-- Filtrage par étape -->
                    <label class="col-auto ml-2">Etape de survenue dans le circuit médicament : </label>
                    <select name="tri_etape" size="1">
                        <option></option>
                        <option>Prescription</option>
                        <option>Dispensation</option>
                        <option>Transport</option>
                        <option>Administration</option>
                        <option>Suivi et réévaluation</option>
                    </select>
                </div>
                <div class="md-auto">
                    <!-- Filtrage par never event -->
                    <label class="col-auto ml-2">Never event : </label>
                    <input type="checkbox" id="tri_neverevent" name="tri_neverevent">Oui</input>
                </div>
                <div class="col-2">
                     <!-- Bouton lançant la recherche -->        
                     <input class="btn btn-outline-primary" type="submit" name="Rechercher" value="Rechercher">
                </div>
            </form>
        </div>
        <div class="container-fluid">
            <table class="table table-striped table-sm mb-4">
                <thead>
                    <tr>
                        <th class="col-md-1">Numéro</th>
                        <th class="col-md-1">Date</th>
                        <th class="col-md-1">Service </th>
                        <th class="col-md-1">Etape</th>
                        <th class="col-md-1">Degré</th>
                        <th class="col-md-2">Médicament à risque</th>
                        <th class="col-md-2">Classe du médicament</th>
                        <th class="col-md-1">Never-event</th>
                        <th class="col-md-2">Description</th>
                        <th class="col-md-2">Conséquences</th>
                        <th class="col-md-2">Consulter/Analyser</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Récupération des événements déclarés à afficher dans le tableau
                        $sql = "SELECT numero, d.nom as departement, date_EM, patient_risque, medicament_risque, administration_risque, details, est_analyse, consequences, est_neverevent, numero, etape_circuit, degre_realisation, medicament_classe FROM evenement e JOIN departement d ON e.departement=d.id WHERE est_analyse=0 OR est_analyse=''";
                        $params = array();
                        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
                        $stmt = sqlsrv_query( $conn, $sql, $params, $options);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                        $row_count = sqlsrv_num_rows( $stmt );
                        if ($row_count === false){
                            echo "Error in retrieveing row count.";
                        }
                        // Pour chaque événement, on met ses données dans une variable, qu'on vient afficher dans la case du tableau associée   
                        for ($i=0; $i<$row_count; $i++){
                            if( sqlsrv_fetch( $stmt ) === false) {
                                die( print_r( sqlsrv_errors(), true));
                            }
                            $numero = sqlsrv_get_field( $stmt, 0);
                            $_SESSION['numero']=$numero;
                            $departement = sqlsrv_get_field( $stmt, 1);
                            $date = sqlsrv_get_field( $stmt, 2)->format('d/m/Y');
                            $patient_risque = sqlsrv_get_field( $stmt, 3);
                            $medicament_risque = sqlsrv_get_field( $stmt, 4);
                            $administration_risque = sqlsrv_get_field( $stmt, 5);
                            $details = sqlsrv_get_field( $stmt, 6);
                            $analyse = sqlsrv_get_field($stmt, 7);
                            $consequences = sqlsrv_get_field($stmt, 8);
                            $neverevent = sqlsrv_get_field($stmt, 9);
                            $numero = sqlsrv_get_field($stmt, 10);
                            $etape = sqlsrv_get_field($stmt, 11);
                            $degre = sqlsrv_get_field($stmt, 12);
                            $medicament_classe = sqlsrv_get_field($stmt, 13);

                            echo '<tr>';
                            echo "<td>$numero</td>";
                            echo "<td>$date</td>";
                            echo "<td>$departement</td>";
                            echo "<td>$etape</td>";
                            echo "<td>$degre</td>";
                            echo "<td>$medicament_risque</td>";
                            echo "<td>$medicament_classe</td>";
                            echo "<td>$neverevent</td>";
                            echo "<td>$details</td>";
                            echo "<td>$consequences</td>";
                            // Boutons permettant d'analyser un événement ou de le consulter
                            echo '<td><a href="analyseEM.php?numero='.$numero.'"><input class="btn btn-outline-primary" type="submit" value="Analyser"><a href="consultationEM.php?numero='.$numero.'&analyse='.$analyse.'"><input class="btn btn-outline-primary" type="submit" value="Consulter"></td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- <div class="col-auto">
                <a href="tableauPriorisation.php"><input class="btn btn-outline-primary" type="submit" value="Tableau de bord"></a>
        </div>-->
    </body>
</html>