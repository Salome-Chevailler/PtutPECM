<!-- Contient les requêtes récupérant les données de l'événement choisi et affiche les données -->
<?php
    include "bdd.php";

    // Récupération du numéro dans l'URL de l'événement choisi 
    $numero = trim($_GET['numero']);
    $analyse = trim($_GET['analyse']);

    // On récupère les infos correspondantes
    $sql = "SELECT date_EM, d.nom as departement, details, administration_risque, administration_precisions, patient_risque, medicament_risque, est_neverevent, date_declaration, d.risque, consequences, precisions_patient, precisions_medicament, degre_realisation, etape_circuit, anonyme, e.nom, prenom, fonction, medicament_classe, justification, prem_actions, medicament_type, est_refrigere FROM evenement e JOIN departement d ON e.departement=d.id WHERE e.numero='$numero'";
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
    $precisions_patient = sqlsrv_get_field($stmt, 11);
    $precisions_medicament = sqlsrv_get_field($stmt, 12);
    $degre_realisation = sqlsrv_get_field($stmt, 13);
    $etape_circuit = sqlsrv_get_field($stmt, 14);
    $anonyme = sqlsrv_get_field($stmt, 15);
    // On convertit le bit en chaîne de caractères
    if ($anonyme==0){
        $anonyme = "Non";
    } else {
        $anonyme = "Oui";
    }
    $nom = sqlsrv_get_field($stmt, 16);
    $prenom = sqlsrv_get_field($stmt, 17);
    $fonction = sqlsrv_get_field($stmt, 18);
    $medicament_classe = sqlsrv_get_field($stmt, 19);
    /*$date_analyse = sqlsrv_get_field( $stmt, 15)->format('d/m/Y');
    $date_crex = sqlsrv_get_field( $stmt, 16)->format('d/m/Y');*/
    $justification = sqlsrv_get_field($stmt, 20);
    $prem_actions = sqlsrv_get_field($stmt, 21);
    $medicament_type = sqlsrv_get_field($stmt, 22);
    $est_refrigere = sqlsrv_get_field($stmt, 23);
    if ($est_refrigere === 1){
        $est_refrigere = "Oui";
    } else {
        $est_refrigere = "Non";
    }

    // On récupère les dates d'analyse et de CREX
    $sql2 = "SELECT date_analyse, date_crex FROM rapportcrex WHERE evenement=$numero";
    $stmt2 = sqlsrv_query( $conn, $sql2);
    if( $stmt2 === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_fetch( $stmt2 ) === false) {
        die( print_r( sqlsrv_errors(), true));
    }
    $date_analyse = sqlsrv_get_field($stmt2, 0);
    $date_crex = sqlsrv_get_field($stmt2, 1);

    // On récupère les infos de cotation
    $sql2 = "SELECT gravite, occurrence, niveau_maitrise, criticite FROM cotation WHERE evenement=$numero";
    $stmt2 = sqlsrv_query( $conn, $sql2);
    if( $stmt2 === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_fetch( $stmt2 ) === false) {
        die( print_r( sqlsrv_errors(), true));
    }
    $gravite = sqlsrv_get_field($stmt2, 0);
    $occurrence = sqlsrv_get_field($stmt2, 1);
    $niveau_maitrise = sqlsrv_get_field($stmt2, 2);
    $criticite = sqlsrv_get_field($stmt2, 3);


    if(isset($_POST['modifEvenement'])){
        // Récupération des données entrées dans le formulaire
        $est_neverevent2 = $_POST['neverevent2'];
        $patient_risque2 = $_POST['patient_risque2'];
        $precisions_patient2 = $_POST['precisions_patient2'];
        $medicament_risque2 = $_POST['medicament_risque2'];
        $precisions_medicament2 = $_POST['precisions_medicament2'];
        //$medicament_classe2 = $_POST['medicament_classe2'];
        $administration_risque2 = $_POST['administration_risque2'];
        $administration_precisions2 = $_POST['administration_precisions2'];
        $degre_realisation2 = $_POST['degre_realisation'];
        $etape_circuit2 = $_POST['etape_circuit'];
        $details2 = $_POST['details2'];
        $consequences2 = $_POST['consequences2'];
        $justification2 = $_POST['justification2'];
        $prem_actions2 = $_POST['prem_actions2'];
        $medicament_type2 = $_POST['medicament_type2'];
        $est_refrigere2 = $_POST['est_refrigere2'];
        if ($est_refrigere2 === "Oui"){
            $est_refrigere2 = 1;
        } else {
            $est_refrigere2 = 0;
        }

        // Modification de l'événement à partir des données entrées dans le formulaire
        // NE PAS OUBLIER DE RAJOUTER MEDICAMENT_CLASSE
        $updateEvenement="UPDATE evenement SET est_neverevent='".$est_neverevent2."',patient_risque='".$patient_risque2."',precisions_patient='".$precisions_patient2."',medicament_risque='".$medicament_risque2."',precisions_medicament='".$precisions_medicament2."',administration_risque='".$administration_risque2."',administration_precisions='".$administration_precisions2."',degre_realisation='".$degre_realisation2."',etape_circuit='".$etape_circuit2."',details='".$details2."',consequences='".$consequences2."',justification='".$justification2."',prem_actions='".$prem_actions2."',medicament_type='".$medicament_type2."',est_refrigere='".$est_refrigere2."' WHERE numero=".$numero."";
        $stmt=sqlsrv_query($conn,$updateEvenement);
        if( $stmt === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
    }
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
            <form method="POST" action="">
                <div class="row mb-1">
                    <label class="col-6" for="DateAnalyse"><strong>Date de l'analyse : </strong><?php echo $date_analyse ?></label>
                    <label class="col-6" for="DateCrex"><strong>Présenté au CREX du : </strong><?php echo $date_crex ?></label>
                </div>
                <!-- Personne déclarante -->
                <div class="row mb-1">
                    <label class="col-6" for="anonyme"><strong>Déclaration anonyme : </strong><?php echo $anonyme; ?></label>
                    <?php if ($anonyme === "Non"){
                        echo '<label class="col-6" for="personne"><strong>Déclaration faite par : </strong>'.$nom." ".$prenom.", ".$fonction.'</label>';
                    }
                    ?>
                </div>
                <!-- Dates -->
                <div class="row mb-1">
                    <label class="col-6" for="DateEM"><strong>Date de l'événement : </strong><?php echo $date_EM; ?></label>
                    <label class="col-6" for="date_declaration"><strong>Date de la déclaration : </strong><?php echo $date_declaration ?></label>
                </div>
                <!-- Service -->
                <div class="row mb-1">
                    <label class="col-6" for="Service"><strong>Service : </strong><?php echo $departement ?></label>
                    <label class="col-6" for="departement_risque"><strong>Service à risque : </strong><?php echo $departement_risque ?></label>
                </div>
                <!-- Description -->
                <div class="row mb-1">
                    <label class="col-md-auto" for="details2"><strong>Description :</strong></label>
                    <textarea class="col-4" maxlength="1000" id="details2" name="details2" required><?php echo $details ?></textarea>
                </div>
                <!-- Impact -->
                <div class="row mb-1">
                    <label class="col-md-auto" for="consequences2"><strong>Impact :</strong></label>
                    <textarea class="col-4" maxlength="1000" id="consequences2" name="consequences2" required><?php echo $consequences ?></textarea>
                </div>
                <!-- Justification -->
                <div class="row mb-1">
                    <label class="col-md-auto" for="justification2"><strong>En quoi est-ce un problème ?</strong></label>
                    <textarea class="col-4" maxlength="1000" id="justification2" name="justification2" required><?php echo $justification ?></textarea>
                </div>
                <!-- Premier temps -->
                <div class="row mb-1">
                    <label class="col-md-auto" for="prem_actions2"><strong>Premières actions mises en place :</strong></label>
                    <textarea class="col-4" maxlength="1000" id="prem_actions2" name="prem_actions2" required><?php echo $prem_actions ?></textarea>
                </div>
                <div class="md-auto">
                    <h4>Caractérisation de l'erreur médicamenteuse</h4>
                </div>
                <!-- Voie d'administration à risque -->
                <div class="md-auto">
                    <label for="Administration"><strong>Voie d'administration à risque : </strong></label>
                    <?php
                        if ($administration_risque === "Oui"){
                            echo '<input type="radio" id="administration_risque2" name="administration_risque2" value="Oui" required checked="checked">';
                            echo '<label for="Oui">Oui</label>';
                            echo '<input type="radio" id="administration_risque2" name="administration_risque2" value="Non" required>';
                            echo '<label for="Non">Non</label>';
                            echo '<input type="radio" id="administration_risque2" name="administration_risque2" value="Je ne sais pas" required>';
                            echo '<label for="Je ne sais pas">Je ne sais pas</label>';
                        } else if ($administration_risque === "Non"){
                            echo '<input type="radio" id="administration_risque2" name="administration_risque2" value="Oui" required>';
                            echo '<label for="Oui">Oui</label>';
                            echo '<input type="radio" id="administration_risque2" name="administration_risque2" value="Non" required checked="checked">';
                            echo '<label for="Non">Non</label>';
                            echo '<input type="radio" id="administration_risque2" name="administration_risque2" value="Je ne sais pas" required>';
                            echo '<label for="Je ne sais pas">Je ne sais pas</label>';
                        } else {
                            echo '<input type="radio" id="administration_risque2" name="administration_risque2" value="Oui" required>';
                            echo '<label for="Oui">Oui</label>';
                            echo '<input type="radio" id="administration_risque2" name="administration_risque2" value="Non" required>';
                            echo '<label for="Non">Non</label>';
                            echo '<input type="radio" id="administration_risque2" name="administration_risque2" value="Je ne sais pas" required checked="checked">';
                            echo '<label for="Je ne sais pas">Je ne sais pas</label>';
                        }
                    ?>
                </div>
                <!-- Précisions sur la voie d'administration -->
                <div class="md-auto">
                    <label for="Precisions"><strong>Précisions sur la voie d'administration : </strong></label>
                    <input type="text" id="administration_precisions2" name="administration_precisions2" value="<?php echo $administration_precisions ?>">
                </div>
                <!-- Patient à risque -->
                <div class="md-auto">
                    <label for="Patient"><strong>Patient à risque : </strong></label>
                    <?php 
                        if ($patient_risque === "Oui"){
                            echo '<input type="radio" id="patient_risque2" name="patient_risque2" value="Oui" required checked="checked">';
                            echo '<label for="Oui">Oui</label>';
                            echo '<input type="radio" id="patient_risque2" name="patient_risque2" value="Non" required>';
                            echo '<label for="Non">Non</label>';
                            echo '<input type="radio" id="patient_risque2" name="patient_risque2" value="Je ne sais pas" required>';
                            echo '<label for="Je ne sais pas">Je ne sais pas</label>';
                        } else if ($patient_risque === "Non"){
                            echo '<input type="radio" id="patient_risque2" name="patient_risque2" value="Oui" required>';
                            echo '<label for="Oui">Oui</label>';
                            echo '<input type="radio" id="patient_risque2" name="patient_risque2" value="Non" required checked="checked">';
                            echo '<label for="Non">Non</label>';
                            echo '<input type="radio" id="patient_risque2" name="patient_risque2" value="Je ne sais pas" required>';
                            echo '<label for="Je ne sais pas">Je ne sais pas</label>';
                        } else {
                            echo '<input type="radio" id="patient_risque2" name="patient_risque2" value="Oui" required>';
                            echo '<label for="Oui">Oui</label>';
                            echo '<input type="radio" id="patient_risque2" name="patient_risque2" value="Non" required>';
                            echo '<label for="Non">Non</label>';
                            echo '<input type="radio" id="patient_risque2" name="patient_risque2" value="Je ne sais pas" required checked="checked">';
                            echo '<label for="Je ne sais pas">Je ne sais pas</label>';
                        }
                    ?>
                </div>
                <!-- Précisions sur le patient -->
                <div class="md-auto">
                    <label for="precisions_patient"><strong>Précisions sur le patient : </strong></label>
                    <input type="text" id="precisions_patient2" name="precisions_patient2" value="<?php echo $precisions_patient ?>">
                </div>
                <!-- Médicament à risque -->
                <div class="md-auto">
                    <label for="Medicament"><strong>Médicament à risque : </strong></label>
                    <?php
                        if ($medicament_risque === "Oui"){
                            echo '<input type="radio" id="medicament_risque2" name="medicament_risque2" value="Oui" required checked="checked">';
                            echo '<label for="Oui">Oui</label>';
                            echo '<input type="radio" id="medicament_risque2" name="medicament_risque2" value="Non" required>';
                            echo '<label for="Non">Non</label>';
                            echo '<input type="radio" id="medicament_risque2" name="medicament_risque2" value="Je ne sais pas" required>';
                            echo '<label for="Je ne sais pas">Je ne sais pas</label>';
                        } else if ($medicament_risque === "Non"){
                            echo '<input type="radio" id="medicament_risque2" name="medicament_risque2" value="Oui" required>';
                            echo '<label for="Oui">Oui</label>';
                            echo '<input type="radio" id="medicament_risque2" name="medicament_risque2" value="Non" required checked="checked">';
                            echo '<label for="Non">Non</label>';
                            echo '<input type="radio" id="medicament_risque2" name="medicament_risque2" value="Je ne sais pas" required>';
                            echo '<label for="Je ne sais pas">Je ne sais pas</label>';
                        } else {
                            echo '<input type="radio" id="medicament_risque2" name="medicament_risque2" value="Oui" required>';
                            echo '<label for="Oui">Oui</label>';
                            echo '<input type="radio" id="medicament_risque2" name="medicament_risque2" value="Non" required>';
                            echo '<label for="Non">Non</label>';
                            echo '<input type="radio" id="medicament_risque2" name="medicament_risque2" value="Je ne sais pas" required checked="checked">';
                            echo '<label for="Je ne sais pas">Je ne sais pas</label>';
                        }
                    ?>
                </div>
                <!-- Précisions sur le médicament -->
                <div class="md-auto">
                    <label for="precisions_medicament"><strong>Précisions sur le médicament : </strong></label>
                    <input type="text" id="precisions_medicament2" name="precisions_medicament2" value="<?php echo $precisions_medicament ?>">
                </div>
                <!-- A faire quand on aura la liste des classes de médicament -->
                <div class="md-auto">
                    <label for="medicament_classe2"><strong>Classe du médicament : </strong><?php echo $medicament_classe ?></label>
                </div>
                <!-- Type de médicament -->
                <div class="md-auto">
                    <label for="medicament_type"><strong>Type du médicament : </strong></label>
                    <?php
                        if ($medicament_type === "Médicament"){
                            echo '<input type="radio" id="medicament_type2" name="medicament_type2" value="Médicament" required checked="checked">';
                            echo '<label for="Médicament">Médicament</label>';
                            echo '<input type="radio" id="medicament_type2" name="medicament_type2" value="Stupéfiant" required>';
                            echo '<label for="Stupéfiant">Stupéfiant</label>';
                            echo '<input type="radio" id="medicament_type2" name="medicament_type2" value="Chimiothérapie" required>';
                            echo '<label for="Chimiothérapie">Chimiothérapie</label>';
                        } else if ($medicament_type === "Stupéfiant"){
                            echo '<input type="radio" id="medicament_type2" name="medicament_type2" value="Médicament" required>';
                            echo '<label for="Médicament">Médicament</label>';
                            echo '<input type="radio" id="medicament_type2" name="medicament_type2" value="Stupéfiant" required checked="checked">';
                            echo '<label for="Stupéfiant">Stupéfiant</label>';
                            echo '<input type="radio" id="medicament_type2" name="medicament_type2" value="Chimiothérapie" required>';
                            echo '<label for="Chimiothérapie">Chimiothérapie</label>';
                        } else {
                            echo '<input type="radio" id="medicament_type2" name="medicament_type2" value="Médicament" required>';
                            echo '<label for="Médicament">Médicament</label>';
                            echo '<input type="radio" id="medicament_type2" name="medicament_type2" value="Stupéfiant" required>';
                            echo '<label for="Stupéfiant">Stupéfiant</label>';
                            echo '<input type="radio" id="medicament_type2" name="medicament_type2" value="Chimiothérapie" required checked="checked">';
                            echo '<label for="Chimiothérapie">Chimiothérapie</label>';
                        }
                    ?>
                </div>
                <!-- Réfrigéré -->
                <div class="md-auto">
                    <label for="est_refrigere"><strong>Réfrigéré : </strong></label>
                    <?php
                        if ($est_refrigere === "Oui"){
                            echo '<input type="radio" id="est_refrigere2" name="est_refrigere2" value="Oui" required checked="checked">';
                            echo '<label for="Oui">Oui</label>';
                            echo '<input type="radio" id="est_refrigere2" name="est_refrigere2" value="Non" required>';
                            echo '<label for="Non">Non</label>';
                        } else{
                            echo '<input type="radio" id="est_refrigere2" name="est_refrigere2" value="Oui" required>';
                            echo '<label for="Oui">Oui</label>';
                            echo '<input type="radio" id="est_refrigere2" name="est_refrigere2" value="Non" required checked="checked">';
                            echo '<label for="Non">Non</label>';
                        }
                    ?>
                </div>
                <!-- Never event -->
                <div class="md-auto">
                    <label for="neverevent2">Est-ce un never-event (NE) ?</label>
                    <?php 
                    if ($est_neverevent === "Oui"){
                        echo '<input type="radio" id="neverevent2" name="neverevent2" value="Oui" required checked="checked">';
                        echo '<label for="Oui">Oui</label>';
                        echo '<input type="radio" id="neverevent2" name="neverevent2" value="Non" required>';
                        echo '<label for="Non">Non</label>';
                        echo '<input type="radio" id="neverevent2" name="neverevent2" value="Je ne sais pas" required>';
                        echo '<label for="Je ne sais pas">Je ne sais pas</label>';
                    } else if ($est_neverevent === "Non"){
                        echo '<input type="radio" id="neverevent2" name="neverevent2" value="Oui" required>';
                        echo '<label for="Oui">Oui</label>';
                        echo '<input type="radio" id="neverevent2" name="neverevent2" value="Non" required checked="checked">';
                        echo '<label for="Non">Non</label>';
                        echo '<input type="radio" id="neverevent2" name="neverevent2" value="Je ne sais pas" required>';
                        echo '<label for="Je ne sais pas">Je ne sais pas</label>';
                    } else {
                        echo '<input type="radio" id="neverevent2" name="neverevent2" value="Oui" required>';
                        echo '<label for="Oui">Oui</label>';
                        echo '<input type="radio" id="neverevent2" name="neverevent2" value="Non" required>';
                        echo '<label for="Non">Non</label>';
                        echo '<input type="radio" id="neverevent2" name="neverevent2" value="Je ne sais pas" required checked="checked">';
                        echo '<label for="Je ne sais pas">Je ne sais pas</label>';
                    }
                    ?>
                </div>
                <!-- A FAIRE -->
                <div class="row mb-1">
                    <label class="col-6" for="NE"><strong>Le(s)quel(s) ? </strong><?php ?></label>
                </div>
                <!-- Degré de réalisation -->
                <div class="md-auto">
                    <label for="degre">Degré de réalisation :</label>
                    <?php 
                    if ($degre_realisation === "EM a atteint le patient"){
                        echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="EM a atteint le patient" required checked="checked">';
                        echo '<label for="EM a atteint le patient">EM a atteint le patient</label>';
                        echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="EM a été interceptée" required>';
                        echo '<label for="EM a été interceptée">EM a été interceptée</label>';
                        echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Evénement porteur de risque (EPR)" required>';
                        echo '<label for="Evénement porteur de risque (EPR)">Evénement porteur de risque (EPR)</label>';
                        echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Je ne sais pas" required>';
                        echo '<label for="Jenesaispas">Je ne sais pas</label>'; 
                    } else if ($degre_realisation === "EM a été interceptée"){
                        echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="EM a atteint le patient" required>';
                        echo '<label for="EM a atteint le patient">EM a atteint le patient</label>';
                        echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="EM a été interceptée" required checked="checked">';
                        echo '<label for="EM a été interceptée">EM a été interceptée</label>';
                        echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Evénement porteur de risque (EPR)" required>';
                        echo '<label for="Evénement porteur de risque (EPR)">Evénement porteur de risque (EPR)</label>';
                        echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Je ne sais pas" required>';
                        echo '<label for="Jenesaispas">Je ne sais pas</label>'; 
                    } else if ($degre_realisation === "Evénement porteur de risque (EPR)"){
                        echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="EM a atteint le patient" required>';
                        echo '<label for="EM a atteint le patient">EM a atteint le patient</label>';
                        echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="EM a été interceptée" required>';
                        echo '<label for="EM a été interceptée">EM a été interceptée</label>';
                        echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Evénement porteur de risque (EPR)" required checked="checked">';
                        echo '<label for="Evénement porteur de risque (EPR)">Evénement porteur de risque (EPR)</label>';
                        echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Je ne sais pas" required>';
                        echo '<label for="Jenesaispas">Je ne sais pas</label>'; 
                    } else {
                        echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="EM a atteint le patient" required>';
                        echo '<label for="EM a atteint le patient">EM a atteint le patient</label>';
                        echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="EM a été interceptée" required>';
                        echo '<label for="EM a été interceptée">EM a été interceptée</label>';
                        echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Evénement porteur de risque (EPR)" required>';
                        echo '<label for="Evénement porteur de risque (EPR)">Evénement porteur de risque (EPR)</label>';
                        echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Je ne sais pas" required checked="checked">';
                        echo '<label for="Jenesaispas">Je ne sais pas</label>'; 
                    }
                    ?>  
                    </div>
                    <!-- Etape de survenue dans le circuit médicament -->
                    <div class="md-auto">
                        <label for="etape">Etape de survenue dans le circuit médicament :</label>
                        <?php 
                        if ($etape_circuit === "Prescription"){
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Prescription" required checked="checked">';
                            echo '<label for="Prescription">Prescription</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Dispensation" required>';
                            echo '<label for="Dispensation">Dispensation</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Transport" required>';
                            echo '<label for="Transport">Transport</label>';  
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Administration" required>';
                            echo '<label for="Administration">Administration</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Suivi et réévaluation" required>';
                            echo '<label for="Suivi et réévaluation">Suivi et réévaluation</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Je ne sais pas" required>';
                            echo '<label for="Jenesaispas">Je ne sais pas</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Autre" required>';
                            echo '<label for="Autre">Autre</label>';  
                            echo '<input type="text" id="etape_circuit" name="autre">';  
                        } else if ($etape_circuit === "Dispensation"){
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Prescription" required>';
                            echo '<label for="Prescription">Prescription</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Dispensation" required checked="checked">';
                            echo '<label for="Dispensation">Dispensation</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Transport" required>';
                            echo '<label for="Transport">Transport</label>';  
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Administration" required>';
                            echo '<label for="Administration">Administration</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Suivi et réévaluation" required>';
                            echo '<label for="Suivi et réévaluation">Suivi et réévaluation</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Je ne sais pas" required>';
                            echo '<label for="Jenesaispas">Je ne sais pas</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Autre" required>';
                            echo '<label for="Autre">Autre</label>';  
                            echo '<input type="text" id="etape_circuit" name="autre">'; 
                        } else if ($etape_circuit === "Transport"){
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Prescription" required>';
                            echo '<label for="Prescription">Prescription</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Dispensation" required>';
                            echo '<label for="Dispensation">Dispensation</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Transport" required checked="checked">';
                            echo '<label for="Transport">Transport</label>';  
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Administration" required>';
                            echo '<label for="Administration">Administration</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Suivi et réévaluation" required>';
                            echo '<label for="Suivi et réévaluation">Suivi et réévaluation</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Je ne sais pas" required>';
                            echo '<label for="Jenesaispas">Je ne sais pas</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Autre" required>';
                            echo '<label for="Autre">Autre</label>';  
                            echo '<input type="text" id="etape_circuit" name="autre">'; 
                        } else if ($etape_circuit === "Administration"){
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Prescription" required>';
                            echo '<label for="Prescription">Prescription</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Dispensation" required>';
                            echo '<label for="Dispensation">Dispensation</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Transport" required>';
                            echo '<label for="Transport">Transport</label>';  
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Administration" required checked="checked">';
                            echo '<label for="Administration">Administration</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Suivi et réévaluation" required>';
                            echo '<label for="Suivi et réévaluation">Suivi et réévaluation</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Je ne sais pas" required>';
                            echo '<label for="Jenesaispas">Je ne sais pas</label>';
                            echo '<input type="radio" id="autre" name="etape_circuit" value="etape_circuit" required>';
                            echo '<label for="Autre">Autre</label>';  
                            echo '<input type="text" id="etape_circuit" name="autre">';
                        } else if ($etape_circuit === "Suivi et réévaluation"){
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Prescription" required>';
                            echo '<label for="Prescription">Prescription</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Dispensation" required>';
                            echo '<label for="Dispensation">Dispensation</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Transport" required>';
                            echo '<label for="Transport">Transport</label>';  
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Administration" required>';
                            echo '<label for="Administration">Administration</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Suivi et réévaluation" required checked="checked">';
                            echo '<label for="Suivi et réévaluation">Suivi et réévaluation</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Je ne sais pas" required>';
                            echo '<label for="Jenesaispas">Je ne sais pas</label>';
                            echo '<input type="radio" id="autre" name="etape_circuit" value="etape_circuit" required>';
                            echo '<label for="Autre">Autre</label>';  
                            echo '<input type="text" id="etape_circuit" name="autre">'; 
                        } else if ($etape_circuit === "Je ne sais pas"){
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Prescription" required>';
                            echo '<label for="Prescription">Prescription</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Dispensation" required>';
                            echo '<label for="Dispensation">Dispensation</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Transport" required>';
                            echo '<label for="Transport">Transport</label>';  
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Administration" required>';
                            echo '<label for="Administration">Administration</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Suivi et réévaluation" required>';
                            echo '<label for="Suivi et réévaluation">Suivi et réévaluation</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Je ne sais pas" required checked="checked">';
                            echo '<label for="Jenesaispas">Je ne sais pas</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Autre" required>';
                            echo '<label for="Autre">Autre</label>';  
                            echo '<input type="text" id="etape_circuit" name="autre">'; 
                        } else {
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Prescription" required>';
                            echo '<label for="Prescription">Prescription</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Dispensation" required>';
                            echo '<label for="Dispensation">Dispensation</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Transport" required>';
                            echo '<label for="Transport">Transport</label>';  
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Administration" required>';
                            echo '<label for="Administration">Administration</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Suivi et réévaluation" required>';
                            echo '<label for="Suivi et réévaluation">Suivi et réévaluation</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Je ne sais pas" required>';
                            echo '<label for="Jenesaispas">Je ne sais pas</label>';
                            echo '<input type="radio" id="etape_circuit" name="etape_circuit" value="Autre" required checked="checked">';
                            echo '<label for="Autre">Autre</label>';  
                            echo '<input type="text" id="etape_circuit" name="autre" value="'.$etape_circuit.'">'; 
                        }
                        ?>                  
                    </div>
                <div class="md-auto">
                    <h4>Cotation de l'événement</h4>
                </div>
                <div class="row mb-1">
                    <label class="col-6" for="Gravite"><strong>Gravité : </strong><?php echo $gravite ?></label>
                    <label class="col-6" for="Occurrence"><strong>Occurrence : </strong><?php echo $occurrence ?></label>
                </div>
                <div class="row mb-1">
                    <label class="col-6" for="Niveau"><strong>Niveau de maîtrise : </strong><?php echo $niveau_maitrise ?></label>
                    <label class="col-6" for="Criticite"><strong>Criticité : </strong><?php echo $criticite ?></label>
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
                <!-- Bouton de validation -->
                <div class="row justify-content-center">
                    <div class="ajouter"><input class="btn btn-outline-primary" type="submit" value="Modifier l'événement" name="modifEvenement"></div>
                </div>
            </form>
        </div>        
    </body>
</html>