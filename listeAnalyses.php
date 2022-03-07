<!-- Affiche la liste de tous les événements analysés et permet de consulter un élément voulu -->
<?php
    include "bdd.php";
?>

<!DOCTYPE html> 
<html lang="fr">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" href="bootstrap.css" type="text/css" media="screen">
        <title>Consultation des événements analysés au CREX</title>
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="col-auto">
                <h1>Consultation des événements analysés au CREX</h1>
            </div>
            <div class="col-auto">
                <a href="accueil.php"><input type="submit" value="Retour"></a>
            </div>
        </div>
        <div>
        <div class="container-fluid">
            <table class="table table-striped table-sm mb-4">
                <thead>
                    <tr>
                        <th class="col-md-1">Date <input class="videB" type="submit" name="triDate" value="v"/></th>
                        <th class="col-md-1">Service <input class="videB" type="submit" name="triService" value="v"/></th>
                        <th class="col-md-2">Patient à risque <input class="videB" type="submit" name="triPatient" value="v"/></th>
                        <th class="col-md-2">Médicament à risque <input class="videB" type="submit" name="triMedicament" value="v"/></th>
                        <th class="col-md-3">Voie d'administration à risque <input class="videB" type="submit" name="triAdministration" value="v"/></th>
                        <th class="col-md-3">Description</th>
                        <th class="col-md-2">Consulter</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        // Récupération des événements déclarés à afficher dans le tableau
                        $sql = "SELECT numero, d.nom as departement, date_EM, patient_risque, medicament_risque, administration_risque, details, est_analyse FROM evenement e JOIN departement d ON e.departement=d.id WHERE  est_analyse=1";
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
                            // On transforme le bit en string 
                            if ($patient_risque===0){
                                $patient_risque = "Non";
                            } else {
                                $patient_risque = "Oui";
                            }
                            $medicament_risque = sqlsrv_get_field( $stmt, 4);
                            // On transforme le bit en string
                            if ($medicament_risque===0){
                                $medicament_risque = "Non";
                            } else {
                                $medicament_risque = "Oui";
                            }
                            $administration_risque = sqlsrv_get_field( $stmt, 5);
                            // On transforme le bit en string
                            if ($administration_risque===0){
                                $administration_risque = "Non";
                            } else {
                                $administration_risque = "Oui";
                            }
                            $details = sqlsrv_get_field( $stmt, 6);
                            $analyse = sqlsrv_get_field($stmt, 7);

                            echo '<tr>';
                            echo "<td>$date</td>";
                            echo "<td>$departement</td>";
                            echo "<td>$patient_risque</td>";
                            echo "<td>$medicament_risque</td>";
                            echo "<td>$administration_risque</td>";
                            echo "<td>$details</td>";
                            // Boutons permettant d'analyser un événement ou de le consulter
                            echo '<td><a href="consultationEManalyse.php?numero='.$numero.'&analyse='.$analyse.'"><input class="boutonthird" type="submit" value="Consulter"></td>';
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-auto">
                <a href="tableauBord.php"><input type="submit" value="Tableau de bord"></a>
        </div>
    </body>
</html>