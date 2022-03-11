<!-- Contient les requêtes récupérant les données de l'événement choisi et affiche les données -->
<?php
    include "bdd.php";

    // Récupération du numéro dans l'URL de l'événement choisi 
    $numero = trim($_GET['numero']);
    $analyse = trim($_GET['analyse']);
    
    // On récupère les infos correspondantes
    $sql = "SELECT date_EM, date_declaration, d.nom as departement, details, consequences, personne_concernee, administration_risque, est_neverevent, justification, administration_precisions, patient_risque, medicament_risque, precisions_patient, medicament_type, est_refrigere, prevention, degre_realisation, etape_circuit, d.risque  FROM evenement e JOIN departement d ON e.departement=d.id WHERE e.numero='$numero'";
    $stmt = sqlsrv_query( $conn, $sql);
    if( $stmt === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_fetch( $stmt ) === false) {
        die( print_r( sqlsrv_errors(), true));
    }
    $date_EM = sqlsrv_get_field($stmt, 0)->format('d/m/Y');
    $date_declaration = sqlsrv_get_field($stmt, 1)->format('d/m/Y');
    $departement = sqlsrv_get_field($stmt, 2);
    $details = sqlsrv_get_field($stmt, 3);
    $consequences = sqlsrv_get_field($stmt, 4);
    $personne_concernee = sqlsrv_get_field($stmt, 5);
    $administration_risque = sqlsrv_get_field($stmt, 6);
    $est_neverevent = sqlsrv_get_field($stmt, 7);
    $justification = sqlsrv_get_field($stmt, 8);
    $administration_precisions = sqlsrv_get_field($stmt, 9);
    $patient_risque = sqlsrv_get_field($stmt, 10);
    $medicament_risque = sqlsrv_get_field($stmt, 11);
    $precisions_patient = sqlsrv_get_field($stmt, 12);
    $medicament_type = sqlsrv_get_field($stmt, 13);
    $refrigere = sqlsrv_get_field($stmt, 14);
    if ($refrigere==1){
        $refrigere="Oui";
    }else {
        $refrigere="Non";
    }
    $prevention = sqlsrv_get_field($stmt, 15);
    $degre = sqlsrv_get_field($stmt, 16);
    $etape = sqlsrv_get_field($stmt, 17);
    $departement_risque = sqlsrv_get_field($stmt, 18);
    if ($departement_risque==1){
        $departement_risque="Oui";
    }else {
        $departement_risque="Non";
    }

    $sql = "SELECT gravite, occurrence, niveau_maitrise, criticite FROM cotation c JOIN evenement e ON c.evenement=e.numero WHERE e.numero='$numero'";
    $stmt = sqlsrv_query( $conn, $sql);
    if( $stmt === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_fetch( $stmt ) === false) {
        die( print_r( sqlsrv_errors(), true));
    }
    $gravite = sqlsrv_get_field($stmt, 0);
    $occurrence = sqlsrv_get_field($stmt, 1);
    $niveau = sqlsrv_get_field($stmt, 2);
    $criticite = sqlsrv_get_field($stmt, 3);

    $sql = "SELECT date_crex, date_analyse FROM rapportcrex r JOIN evenement e ON r.evenement=e.numero WHERE e.numero='$numero'";
    $stmt = sqlsrv_query( $conn, $sql);
    if( $stmt === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_fetch( $stmt ) === false) {
        die( print_r( sqlsrv_errors(), true));
    }
    $date_crex = sqlsrv_get_field($stmt, 0)->format('d/m/Y');
    $date_analyse = sqlsrv_get_field($stmt, 1)->format('d/m/Y');

    $sql = "SELECT nom FROM neverevent n JOIN refevenement r ON n.numero=r.num_neverevent JOIN evenement e ON e.numero=r.num_evenement WHERE e.numero='$numero'";
    $params = array();
    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
    $stmt = sqlsrv_query( $conn, $sql, $params, $options);
    if( $stmt === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_fetch( $stmt ) === false) {
        die( print_r( sqlsrv_errors(), true));
    }
    $neverevent = sqlsrv_get_field($stmt,0);
    // A FINIR
    /* $row_count = sqlsrv_num_rows( $stmt );
    if ($row_count === false){
        echo "Error in retrieveing row count.";
    }
    for ($i=0; $i<$row_count; $i++){
        if( sqlsrv_fetch( $stmt ) === false) {
            die( print_r( sqlsrv_errors(), true));
        }
        $neverevent = sqlsrv_get_field($stmt,0);
    }
    echo $neverevent;*/
?>

<!DOCTYPE html> 
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="iconeCHIC.png">
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" href="bootstrap.css" type="text/css" media="screen">
        <title>Consultation d'une erreur médicamenteuse analysée au CREX</title>
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="header">
                <h1>Consultation d'une erreur médicamenteuse analysée au CREX</h1>
            </div>
            <div class="col-auto">
                <a href="listeAnalyses.php"><input class="btn btn-outline-primary" type="submit" value="Retour"></a>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row mb-1">
                <label class="col-6" for="DateAnalyse"><strong>Date de l'analyse : </strong><?php echo $date_analyse ?></label>
                <label class="col-6" for="DateCrex"><strong>Présenté au CREX du : </strong><?php echo $date_crex ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="DateEM"><strong>Date de l'événement : </strong><?php echo $date_EM; ?></label>
                <label class="col-6" for="DateDecla"><strong>Date de la déclaration : </strong><?php echo $date_declaration ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Service"><strong>Service : </strong><?php echo $departement ?></label>
                <label class="col-6" for="departement_risque"><strong>Service à risque : </strong><?php echo $departement_risque ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Description"><strong>Description : </strong><?php echo $details ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Consequences"><strong>Conséquences : </strong><?php echo $consequences ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Qui"><strong>Qui est concerné ? </strong><?php echo $personne_concernee ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Justification"><strong>En quoi est-ce un problème ? </strong><?php echo $justification ?></label>
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
                <label class="col-6" for="Precisions"><strong>Précisions sur le patient : </strong><?php echo $precisions_patient  ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Medicament"><strong>Médicament à risque : </strong><?php echo $medicament_risque ?></label>
                <label class="col-6" for="Precisions"><strong>Précisions sur le médicament : </strong><?php ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Type"><strong>L'erreur médicamenteuse concerne : </strong><?php echo $medicament_type ?></label>
                <label class="col-6" for="Refrigere"><strong>Réfrigéré : </strong><?php echo $refrigere ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Neverevent"><strong>Est-ce un never-event (NE) ? </strong><?php echo $est_neverevent ?></label>
                <label class="col-6" for="NE"><strong>Le(s)quel(s) ? </strong><?php echo $neverevent ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Degre"><strong>Degré de réalisation : </strong><?php echo $degre ?></label>
                <label class="col-6" for="Etape"><strong>Etape de survenue dans le circuit médicament : </strong><?php echo $etape ?></label>
            </div>
            <div class="md-auto">
                <h4>Cotation de l'événement</h4>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Gravite"><strong>Gravité : </strong><?php echo $gravite ?></label>
                <label class="col-6" for="Occurrence"><strong>Occurrence : </strong><?php echo utf8_encode($occurrence) ?></label>
            </div>
            <div class="row mb-1">
                <label class="col-6" for="Niveau"><strong>Niveau de maîtrise : </strong><?php echo $niveau ?></label>
                <label class="col-6" for="Criticite"><strong>Criticité : </strong><?php echo utf8_encode($criticite) ?></label>
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