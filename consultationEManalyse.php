<!-- Contient les requêtes récupérant les données de l'événement choisi et affiche les données -->
<?php
    include "bdd.php";

    // Récupération du numéro dans l'URL de l'événement choisi 
    $numero = trim($_GET['numero']);
    $analyse = trim($_GET['analyse']);
    
    // On récupère les infos correspondantes
    $sql = "SELECT date_EM, d.nom as departement, details, administration_risque, administration_precisions, patient_risque, medicament_risque, est_neverevent FROM evenement e JOIN departement d ON e.departement=d.id WHERE e.numero='$numero'";
    $stmt = sqlsrv_query( $conn, $sql);
    if( $stmt === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_fetch( $stmt ) === false) {
        die( print_r( sqlsrv_errors(), true));
    }
    //$date_EM = sqlsrv_get_field( $stmt, 0)->format('d/m/Y');
    $departement = sqlsrv_get_field($stmt, 1);
    $details = sqlsrv_get_field($stmt, 2);
    $administration_risque = sqlsrv_get_field($stmt, 3);
    // On transforme le bit en string
    if ($administration_risque===0){
        $administration_risque = "Non";
    } else {
        $administration_risque = "Oui";
    }
    $administration_precisions = sqlsrv_get_field($stmt, 4);
    $patient_risque = sqlsrv_get_field($stmt, 5);
    // On transforme le bit en string
    if ($patient_risque===0){
        $patient_risque = "Non";
    } else {
        $patient_risque = "Oui";
    }
    $medicament_risque = sqlsrv_get_field($stmt, 6);
    // On transforme le bit en string
    if ($medicament_risque===0){
        $medicament_risque = "Non";
    } 
    else {
        $medicament_risque = "Oui";
    }
    $est_neverevent = sqlsrv_get_field($stmt, 7);
?>

<!DOCTYPE html> 
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="iconeCHIC.png">
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" href="bootstrap.css" type="text/css" media="screen">
        <title>Consultation d'un événement analysé au CREX</title>
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="header">
                <h1>Consultation d'un événement analysé au CREX</h1>
            </div>
            <div class="col-auto">
                <a href="listeAnalyses.php"><input class="btn btn-outline-primary" type="submit" value="Retour"></a>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mb-1">
                <label class="col-6" for="DateAnalyse"><strong>Date de l'analyse : </strong></label>
                <label class="col-6" for="DateCrex"><strong>Présenté au CREX du : </strong></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="DateEM"><strong>Date de l'événement : </strong><?php //echo $date_EM; ?></label>
                <label class="col-6" for="DateDecla"><strong>Date de la déclaration : </strong><?php ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Service"><strong>Service : </strong><?php echo $departement ?></label>
                <label class="col-6" for="departement_risque"><strong>Service à risque : </strong><?php  ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Description"><strong>Description : </strong><?php echo $details ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Consequences"><strong>Conséquences : </strong><?php  ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Qui"><strong>Qui est concerné ? </strong></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Justification"><strong>En quoi est-ce un problème ? </strong></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Action"><strong>Qu'a-t-il été fait dans un premier temps ? </strong><?php  ?></label>
            </div>
            <div class="md-auto">
                <h4>Caractérisation de l'erreur médicamenteuse</h4>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Administration"><strong>Voie d'administration à risque : </strong><?php echo $administration_risque ?></label>
                <label class="col-6" for="Precisions"><strong>Précisions sur la voie d'administration : </strong><?php echo $administration_precisions ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Patient"><strong>Patient à risque : </strong><?php echo $patient_risque ?></label>
                <label class="col-6" for="Precisions"><strong>Précisions sur le patient : </strong><?php   ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Medicament"><strong>Médicament à risque : </strong><?php echo $medicament_risque ?></label>
                <label class="col-6" for="Precisions"><strong>Précisions sur le médicament : </strong><?php  ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Type"><strong>L'erreur médicamenteuse concerne : </strong><?php  ?></label>
                <label class="col-6" for="Refrigere"><strong>Réfrigéré : </strong><?php   ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Neverevent"><strong>Est-ce un never-event (NE) ? </strong><?php echo $est_neverevent ?></label>
                <label class="col-6" for="NE"><strong>Le(s)quel(s) ? </strong></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Degre"><strong>Degré de réalisation : </strong></label>
                <label class="col-6" for="Etape"><strong>Etape de survenue dans le circuit médicament : </strong></label>
            </div>
            <div class="md-auto">
                <h4>Cotation de l'événement</h4>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Gravite"><strong>Gravité : </strong></label>
                <label class="col-6" for="Occurrence"><strong>Occurrence : </strong></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Niveau"><strong>Niveau de maîtrise : </strong></label>
                <label class="col-6" for="Criticite"><strong>Criticité : </strong></label>
            </div>
            <div class="md-auto">
                <h4>Causes latentes systémiques</h4>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Dysfonctionnement"><strong>Quels sont les dysfonctionnements, les erreurs ? </strong></label>
                <label class="col-6" for="Facteurs"><strong>Pourquoi cela est-il arrivé ? </strong></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Prevention"><strong>Est-ce que tout avait été mis en oeuvre pour éviter ce type d'EI ? </strong></label>
                <label class="col-6" for="Defenses"><strong>Si non, quelles ont été les défenses manquantes ou non opérationnelles ? </strong></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Actions"><strong>Quelles sont les actions correctives et préventives ? </strong></label>
            </div>
        </div>        
    </body>
</html>