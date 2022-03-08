<!-- Contient les requêtes récupérant les données de l'événement choisi et affiche les données -->
<?php
    include "bdd.php";

    // Récupération du numéro dans l'URL de l'événement choisi 
    $numero = trim($_GET['numero']);
    $analyse = trim($_GET['analyse']);
    
    // On récupère les infos correspondantes
    // RAJOUTER DEGRE ET ETAPE
    $sql = "SELECT date_EM, d.nom as departement, details, administration_risque, administration_precisions, patient_risque, medicament_risque, est_neverevent, date_declaration, d.risque, consequences, personne_concernee, precisions_patient, precisions_medicament FROM evenement e JOIN departement d ON e.departement=d.id WHERE e.numero='$numero'";
    $stmt = sqlsrv_query( $conn, $sql);
    if( $stmt === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_fetch( $stmt ) === false) {
        die( print_r( sqlsrv_errors(), true));
    }
    $date_EM = sqlsrv_get_field( $stmt, 0)->format('d/m/Y');
    $departement = sqlsrv_get_field($stmt, 1);
    $details = sqlsrv_get_field($stmt, 2);
    $administration_risque = sqlsrv_get_field($stmt, 3);
    $administration_precisions = sqlsrv_get_field($stmt, 4);
    $patient_risque = sqlsrv_get_field($stmt, 5);
    $medicament_risque = sqlsrv_get_field($stmt, 6);
    $est_neverevent = sqlsrv_get_field($stmt, 7);
    $date_declaration = sqlsrv_get_field($stmt, 8)->format('d/m/Y');
    $departement_risque = sqlsrv_get_field($stmt, 9);
    // On convertit le bit en chaîne de caractères
    if ($departement_risque==0){
        $departement_risque = "Non";
    } else {
        $departement_risque = "Oui";
    }
    $consequences = sqlsrv_get_field($stmt, 10);
    $personne_concernee = sqlsrv_get_field($stmt, 11);
    $precisions_patient = sqlsrv_get_field($stmt, 12);
    $precisions_medicament = sqlsrv_get_field($stmt, 13);
?>

<!DOCTYPE html> 
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" href="bootstrap.css" type="text/css" media="screen">
        <title>Consultation d'un événement déclaré</title>
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="col-auto">
                <h1>Consultation d'un événement déclaré</h1>
            </div>
            <div class="col-auto">
                <a href="listeEM.php"><input type="submit" value="Retour"></a>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mb-1">
                <label class="col-6" for="DateEM"><strong>Date de l'événement : </strong><?php echo $date_EM; ?></label>
                <label class="col-6" for="date_declaration"><strong>Date de la déclaration : </strong><?php echo $date_declaration ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Service"><strong>Service : </strong><?php echo $departement ?></label>
                <label class="col-6" for="departement_risque"><strong>Service à risque : </strong><?php echo $departement_risque ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Description"><strong>Description : </strong><?php echo $details ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Remarques"><strong>Conséquences : </strong><?php echo $consequences ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Qui"><strong>Qui est concerné ? </strong><?php echo $personne_concernee ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Patient"><strong>Patient à risque : </strong><?php echo $patient_risque ?></label>
                <label class="col-6" for="precisions_patient"><strong>Précisions sur le patient : </strong><?php echo $precisions_patient ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Medicament"><strong>Médicament à risque : </strong><?php echo $medicament_risque ?></label>
                <label class="col-6" for="precisions_medicament"><strong>Précisions sur le médicament : </strong><?php echo $precisions_medicament ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Administration"><strong>Voie d'administration à risque : </strong><?php echo $administration_risque ?></label>
                <label class="col-6" for="Precisions"><strong>Précisions sur la voie d'administration : </strong><?php echo $administration_precisions ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Neverevent"><strong>Est-ce un never-event (NE) ? </strong><?php echo $est_neverevent ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Degre"><strong>Degré de réalisation : </strong></label>
                <label class="col-6" for="Etape"><strong>Etape de survenue dans le circuit médicament : </strong></label>
            </div>
        </div>        
    </body>
</html>