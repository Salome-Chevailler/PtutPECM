<!-- Affiche le formulaire d'analyse de l'événement et ajoute les éléments dans la base lors de la validation --> 
<?php
    include "bdd.php";

    // Récupération du numéro dans l'URL de l'événement choisi 
    $numero = trim($_GET['numero']);

    // On récupère les infos entrées lors de la déclaration
    $sql = "SELECT anonyme, e.nom, prenom, fonction, date_EM, d.nom as departement, est_neverevent, patient_risque, precisions_patient, medicament_risque, precisions_medicament, medicament_classe, administration_risque, administration_precisions, degre_realisation, etape_circuit, details, consequences FROM evenement e JOIN departement d ON e.departement=d.id WHERE e.numero='$numero'";
    $stmt = sqlsrv_query( $conn, $sql);
    if( $stmt === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_fetch( $stmt ) === false) {
        die( print_r( sqlsrv_errors(), true));
    }
    $anonyme = sqlsrv_get_field($stmt, 0);
    if ($anonyme === 0){
        $anonyme = "Non";
    } else {
        $anonyme = "Oui";
    }
    $nom = sqlsrv_get_field($stmt, 1);
    $prenom = sqlsrv_get_field($stmt, 2);
    $fonction = sqlsrv_get_field($stmt, 3);
    $date_EM = sqlsrv_get_field( $stmt, 4)->format('d/m/Y');
    $departement = sqlsrv_get_field($stmt, 5);
    $neverevent = sqlsrv_get_field($stmt, 6);
    $patient_risque = sqlsrv_get_field($stmt, 7);
    $precisions_patient = sqlsrv_get_field($stmt, 8);
    $medicament_risque = sqlsrv_get_field($stmt, 9);
    $precisions_medicament = sqlsrv_get_field($stmt, 10);
    $medicament_classe = sqlsrv_get_field($stmt, 11);
    $administration_risque = sqlsrv_get_field($stmt, 12);
    $administration_precisions = sqlsrv_get_field($stmt, 13);
    $degre = sqlsrv_get_field($stmt, 14);
    $etape = sqlsrv_get_field($stmt, 15);
    $details = sqlsrv_get_field($stmt, 16);
    $impact = sqlsrv_get_field($stmt, 17);

    if(isset($_POST['valider'])){
        // Récupération des données entrées dans le formulaire
        $date_analyse = $_POST['date'];
        $date_crex = $_POST['date2'];
        $details2 = $_POST['details2'];
        $consequences2 = $_POST['consequences2'];
        $justification = $_POST['justification'];
        $prem_actions = $_POST['prem_actions'];
        $medicament_risque2 = $_POST['medicament_risque2'];
        $precisions_medicament2 = $_POST['precisions_medicament2'];
        //$medicament_classe2 = $_POST['medicament_classe2'];
        $medicament_type = $_POST['medicament_type'];
        if (!empty($_POST['est_refrigere'])) {
            $est_refrigere = $_POST['est_refrigere'];
        } else {
            $est_refrigere = null;
        }
        if ($est_refrigere === "Réfrigéré"){
            $est_refrigere = 1;
        } else if ($est_refrigere === "Non réfrigéré"){
            $est_refrigere = 0;
        } else {
            $est_refrigere = null;
        }
        $patient_risque2 = $_POST['patient_risque2'];
        $precisions_patient2 = $_POST['precisions_patient2'];
        $administration_risque2 = $_POST['administration_risque2'];
        $administration_precisions2 = $_POST['administration_precisions2'];
        $neverevent2 = $_POST['neverevent2'];
        $degre2 = $_POST['degre_realisation'];
        $etape2 = $_POST['etape_circuit'];
        $gravite = $_POST['gravite'];
        $occurrence = $_POST['occurrence'];
        $maitrise = $_POST['maitrise'];
        $criticite = $_POST['criticite'];

        // Modification de l'événement à partir des données entrées dans le formulaire
        $updateEvenement="UPDATE evenement SET details='".$details2."',consequences='".$consequences2."',justification='".$justification."',prem_actions='".$prem_actions."',medicament_risque='".$medicament_risque2."',precisions_medicament='".$precisions_medicament2."',medicament_type='".$medicament_type."',patient_risque='".$patient_risque2."',precisions_patient='".$precisions_patient2."',administration_risque='".$administration_risque2."',administration_precisions='".$administration_precisions2."',est_neverevent='".$neverevent2."',degre_realisation='".$degre2."',etape_circuit='".$etape2."',est_analyse=1,est_refrigere='".$est_refrigere."' WHERE numero=".$numero."";
        $stmt=sqlsrv_query($conn,$updateEvenement);
        if( $stmt === false ) {
            die( print_r( sqlsrv_errors(), true));
        }

        // Création d'un rapport CREX
        $insertRapport="INSERT INTO rapportcrex(date_crex,date_analyse,evenement) VALUES (?,?,?)";
        $values=array($date_crex,$date_analyse,$numero);
        $stmt=sqlsrv_query($conn,$insertRapport,$values);
        if( $stmt === false ) {
            die( print_r( sqlsrv_errors(), true));
        } 

        // Création d'une cotation 
        $insertCotation="INSERT INTO cotation(gravite,occurrence,niveau_maitrise,criticite,evenement) VALUES (?,?,?,?,?)";
        $values=array($gravite,$occurrence,$maitrise,$criticite,$numero);
        $stmt=sqlsrv_query($conn,$insertCotation,$values);
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
        <title>Analyse des causes d'une erreur médicamenteuse</title>
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="header">
                <h1>Analyse des causes d'une erreur médicamenteuse</h1>
            </div>
            <div class="col-auto">
                <a href="listeEM.php"><input class="btn btn-outline-primary" type="submit" value="Retour"></a>
            </div>
        </div>
        <div class="container-fluid">
            <form method="POST" action="">
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
                <div class="md-auto">
                    <label for="anonyme">L'erreur médicamenteuse a été déclarée de manière anonyme : <?php echo $anonyme ?></label>
                </div>
                <?php if ($anonyme === "Non"){
                    echo '<div class="md-auto">';
                    echo '<label for="anonyme">Déclaration faite par : '.$nom.' '.$prenom.', '.$fonction.'</label>';
                    echo '</div>'; 
                }
                ?>
                <div class="description">
                    <div class="section1">
                        <h4>ETAPE 1 : Quel est le problème ? (Description de l'événement)</h4>
                    </div>
                    <div class="row mb-1">
                        <!-- Date de l'événement -->
                        <div class="col-3 md-auto">
                            <label for="date3">Date de l'événement : <?php echo $date_EM ?></label>
                        </div>
                        <!-- Service -->
                        <div class="col-3 md-auto">
                            <label for="service">Service : <?php echo $departement ?></label>
                        </div>
                    </div>
                    <!-- Que s'est-il passé ? -->
                    <div class="row mb-1">
                        <label class="col-md-auto" for="details2">Quoi ? Que s'est-il passé ?</label>
                        <textarea class="col-4" maxlength="1000" id="details2" name="details2" required><?php echo $details ?></textarea>
                    </div>
                    <!-- Quelles sont les conséquences ? -->
                    <div class="row mb-1">
                        <label class="col-md-auto" for="consequences2">Quel impact cela a-t-il eu ?</label>
                        <textarea class="col-4" maxlength="1000" id="consequences2" name="consequences2" required><?php echo $impact ?></textarea>
                    </div>
                    <!-- En quoi est-ce un problème ?-->
                    <div class="row mb-1">
                        <label class="col-md-auto" for="justification">En quoi est-ce un problème ?</label>
                        <textarea class="col-4" maxlength="1000" id="justification" name="justification" required></textarea>
                    </div>
                </div>
                <h5>Qu'a-t-il été fait dans un premier temps ? </h5>
                <!-- Premières actions -->
                <div class="row mb-1">
                    <label class="col-6" for="prem_actions">Décrire ici les premières actions mises en place à la découverte de l'événement</label>  
                </div>
                <textarea class="col-4" maxlength="1000" id="prem_actions" name="prem_actions" required></textarea>
                <div class="caracterisation">
                    <div class="section">
                        <h5>Caractériser l'erreur médicamenteuse (EM)</h5>
                    </div>
                    <!-- Médicament à risque -->
                    <div class="md-auto">
                        <label for="medicament_risque2">Est-ce un médicament à risque ?</label>
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
                            <label for="precisions_medicament2">Précisions sur le médicament :</label>
                            <input type="text" id="precisions_medicament2" name="precisions_medicament2" value="<?php echo $precisions_medicament ?>">
                    </div>
                    <!-- Classe du médicament --> 
                    <div class="md-auto">
                        <label for="medicament_classe2">Classe du médicament :</label>
                        <select name="medicament_classe2" size="1">
                        </select>
                    </div>
                    <div class="md-auto">
                        <label for="medicament">Elle concerne :</label>
                    </div>
                    <!-- Médicament -->
                    <div class="md-auto">
                        <input type="radio" id="medicament_type" name="medicament_type" value="Médicament" required>
                        <label for="Médicament">Un médicament, </label>
                        <label for="Qui est">qui est :</label>
                        <input type="radio" id="est_refrigere" name="est_refrigere" value="Réfrigéré">
                        <label for="Réfrigéré">Réfrigéré</label>
                        <input type="radio" id="est_refrigere" name="est_refrigere" value="Non réfrigéré">
                        <label for="Non réfrigéré">Non réfrigéré</label>
                    </div>
                    <!-- Stupéfiant -->
                    <div class="md-auto">
                        <input type="radio" id="medicament_type" name="medicament_type" value="Stupéfiant" required>
                        <label for="Stupéfiant">Un stupéfiant</label> 
                    </div>
                    <!-- Chimiothérapie -->
                    <div class="md-auto">
                        <input type="radio" id="medicament_type" name="medicament_type" value="Chimiothérapie" required>
                        <label for="Chimiothérapie">Une chimiothérapie, </label>
                        <label for="Qui est">qui est :</label> 
                        <input type="radio" id="est_refrigere" name="est_refrigere" value="Réfrigéré">
                        <label for="Réfrigéré">Réfrigérée</label>
                        <input type="radio" id="est_refrigere" name="est_refrigere" value="Non réfrigéré">
                        <label for="Non réfrigéré">Non réfrigérée</label>
                    </div>
                    <!-- Patient à risque -->
                    <div class="md-auto">
                        <label for="patient_risque">S'agit-il d'un patient à risque ?</label>
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
                        <label for="precisions_patient2">Précisions sur le patient :</label>
                        <input type="text" id="precisions_patient2" name="precisions_patient2" value="<?php echo $precisions_patient ?>">
                    </div>
                    <!-- Voie d'administration à risque -->
                    <div class="md-auto">
                        <label for="patient">S'agit-il d'une voie d'administration à risque ?</label>
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
                    <!-- Précisions -->
                    <div class="md-auto">
                        <label for="administration_precisions2">Précisions sur la voie d'administration :</label>
                        <input type="text" id="administration_precisions2" name="administration_precisions2" value="<?php echo $administration_precisions ?>">
                    </div>
                    <!-- Never event -->
                    <div class="md-auto">
                        <label for="neverevent2">Est-ce un never-event (NE) ?</label>
                        <?php 
                        if ($neverevent === "Oui"){
                            echo '<input type="radio" id="neverevent2" name="neverevent2" value="Oui" required checked="checked">';
                            echo '<label for="Oui">Oui</label>';
                            echo '<input type="radio" id="neverevent2" name="neverevent2" value="Non" required>';
                            echo '<label for="Non">Non</label>';
                            echo '<input type="radio" id="neverevent2" name="neverevent2" value="Je ne sais pas" required>';
                            echo '<label for="Je ne sais pas">Je ne sais pas</label>';
                        } else if ($neverevent === "Non"){
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
                    <!-- Types de never event-->
                    <div class="md-auto">
                        <label for="neverevent2">Si oui, précisez le(s)quel(s) :</label>
                        <input type="checkbox" id="n1" name="n1">
                        <label for="n1">NE1</label>
                        <input type="checkbox" id="n2" name="n2">
                        <label for="n2">NE2</label>
                        <input type="checkbox" id="n3" name="n3">
                        <label for="n3">NE3</label>
                        <input type="checkbox" id="n4" name="n4">
                        <label for="n4">NE4</label>
                        <input type="checkbox" id="n5" name="n5">
                        <label for="n5">NE5</label>
                        <input type="checkbox" id="n6" name="n6">
                        <label for="n6">NE6</label>
                        <input type="checkbox" id="n7" name="n7">
                        <label for="n7">NE7</label>
                        <input type="checkbox" id="n8" name="n8">
                        <label for="n8">NE8</label>
                        <input type="checkbox" id="n9" name="n9">
                        <label for="n9">NE9</label>
                        <input type="checkbox" id="n10" name="n10">
                        <label for="n10">NE10</label>
                        <input type="checkbox" id="n11" name="n11">
                        <label for="n11">NE11</label>
                        <input type="checkbox" id="n12" name="n12">
                        <label for="n12">NE12</label>
                    </div>
                    <!-- Degré de réalisation -->
                    <div class="md-auto">
                            <label for="degre">Degré de réalisation :</label>
                            <?php 
                            if ($degre === "EM a atteint le patient"){
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="EM a atteint le patient" required checked="checked">';
                                echo '<label for="EM a atteint le patient">EM a atteint le patient</label>';
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="EM a été interceptée" required>';
                                echo '<label for="EM a été interceptée">EM a été interceptée</label>';
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Evénement porteur de risque (EPR)" required>';
                                echo '<label for="Evénement porteur de risque (EPR)">Evénement porteur de risque (EPR)</label>';
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Je ne sais pas" required>';
                                echo '<label for="Jenesaispas">Je ne sais pas</label>'; 
                            } else if ($degre === "EM a été interceptée"){
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="EM a atteint le patient" required>';
                                echo '<label for="EM a atteint le patient">EM a atteint le patient</label>';
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="EM a été interceptée" required checked="checked">';
                                echo '<label for="EM a été interceptée">EM a été interceptée</label>';
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Evénement porteur de risque (EPR)" required>';
                                echo '<label for="Evénement porteur de risque (EPR)">Evénement porteur de risque (EPR)</label>';
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Je ne sais pas" required>';
                                echo '<label for="Jenesaispas">Je ne sais pas</label>'; 
                            } else if ($degre === "Evénement porteur de risque (EPR)"){
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
                            if ($etape === "Prescription"){
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
                            } else if ($etape === "Dispensation"){
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
                            } else if ($etape === "Transport"){
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
                            } else if ($etape === "Administration"){
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
                            } else if ($etape === "Suivi et réévaluation"){
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
                            } else if ($etape === "Je ne sais pas"){
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
                                echo '<input type="text" id="etape_circuit" name="autre" value="'.$etape.'">'; 
                            }
                            ?>                  
                    </div>

                    <!-- A VOIR AVEC RAFIKA POUR TROUVER UNE FORMULATION -->
                    <!-- Information du patient 
                    <div class="md-auto">
                        <input type="radio" id="etape_circuit" name="etape_circuit" value="Information du patient" required>
                        <label for="Information du patient">Information du patient</label> 
                    </div> -->

                </div>
                <!-- Cotation -->
                <div class="cotation">
                    <div class="section2">
                        <h5>Cotation de l'événement</h5>
                    </div>
                    <div class="md-auto">
                        <label for="gravite">Gravité :</label>
                        <select name="gravite" size="1" required>
                            <option></option>
                            <option>1 - Mineure</option>
                            <option>2 - Significative</option>
                            <option>3 - Majeure</option>
                            <option>4 - Critique</option>
                            <option>5 - Catastrophique</option>
                        </select>
                    </div>
                    <div class="md-auto">
                        <label for="occurrence">Occurrence :</label>
                        <select name="occurrence" size="1" required>
                            <option></option>
                            <option>1 - Très improbable</option>
                            <option>2 - Très peu probable</option>
                            <option>3 - Peu probable</option>
                            <option>4 - Possible/probable</option>
                            <option>5 - Très probable à certain</option>
                        </select>
                    </div>
                    <div class="md-auto">
                        <label for="maitrise">Niveau de maîtrise :</label>
                        <select name="maitrise" size="1" required>
                            <option></option>
                            <option>1 - Très bon</option>
                            <option>2 - Bon</option>
                            <option>3 - Moyen</option>
                            <option>4 - Faible</option>
                            <option>5 - Inexistant</option>
                        </select>
                    </div>
                    <div class="md-auto">
                        <label for="criticite">Criticité :</label>
                        <select name="criticite" size="1" required>
                            <option></option>
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
                <textarea class="col-4" maxlength="1000" id="dysfonctionnement" name="dysfonctionnement"></textarea>
                <!-- Facteurs -->
                <div class="causes">
                    <div class="section1">
                        <h4>ETAPE 3 : Pourquoi cela est-il arrivé ? (causes latentes systémiques)</h4>
                    </div>
                    <div class="md-auto">
                        <label for="facteur"><strong>L'erreur est-elle liée à des facteurs propres aux patients ?</strong></label>
                    </div>
                    <!-- PA1 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA1" name="PA1">
                        <label for="PA1">L'état de santé du patient est-il grave, complexe ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui">
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non">
                        <label for="Non">Non</label> 
                    </div>
                    <!-- PA2 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA2" name="PA2">
                        <label for="PA2">L'EI est-il survenu dans un contexte de prise en charge en urgence ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui">
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non">
                        <label for="Non">Non</label> 
                    </div>
                    <!-- PA3 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA3" name="PA3">
                        <label for="PA3">L'expression du patient ou la communication étaient-elles difficiles ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- PA4 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA4" name="PA4" >
                        <label for="PA4">La personnalité du patient est-elle particulière et peut-elle expliquer en partie le dysfonctionnement ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- PA5 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA5" name="PA5" >
                        <label for="PA5">Existe-t-il des facteurs sociaux particuliers susceptibles d'expliquer tout ou partie des dysfonctionnements ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui">
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- PA6 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Autre</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <div class="md-auto">
                        <label for="facteur2"><strong>L'erreur est-elle liée à des facteurs individuels ?</strong></label>
                    </div>
                    <!-- IN1 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IN1" name="IN1" >
                        <label for="IN1">Y a-t-il un défaut de qualification des personnes chargées du soin / de l'acte ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- IN2 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IN2" name="IN2" >
                        <label for="IN2">Y a-t-il un défaut de connaissances théoriques ou techniques des professionnels ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- IN3 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IN3" name="IN3" >
                        <label for="IN3">Y a-t-il un défaut d'aptitude, de compétence des professionnels chargés du soin / de l'acte ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- IN4 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IN4" name="IN4" >
                        <label for="IN4">Les professionnels chargés des soins étaient-ils en mauvaise disposition physique et mentale ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- IN5 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IN5" name="IN5" >
                        <label for="IN5">Y a-t-il eu une insuffisance d'échange d'information entre les professionnels de santé et le patient ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- IN6 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IN6" name="IN6" >
                        <label for="IN6">Y a-t-il eu une insuffisance d'échange d'information entre les professionnels de santé et la famille du patient ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- IN7 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IN7" name="IN7" >
                        <label for="IN7">A-t-on relevé un défaut de qualité de la relation avec le patient et sa famille ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- IN8 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IN8" name="IN8" >
                        <label for="IN8">Autre</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <div class="md-auto">
                        <label for="facteur3"><strong>L'erreur est-elle liée à des facteurs concernant l'équipe ?</strong></label>
                    </div>
                    <!-- EQ1 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">La composition de l'équipe chargée du soin était-elle mauvaise ou inadaptée ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- EQ2 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">A-t-on relevé un défaut de communication interne orale et/ou écrite au sein de l'équipe ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- EQ3 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">A-t-on relevé une collaboration insuffisante entre professionnels ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- EQ4 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6">
                        <label for="PA6">Existe-t-il des conflits ou une mauvaise ambiance au sein de l'équipe / un défaut de cohésion ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- EQ5 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">La supervision des responsables et des autres personnels a-t-elle été inadéquate ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- EQ6 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Y a-t-il un manque ou un défaut de recherche d'aide, d'avis, de collaboration ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- EQ7 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Autre</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <div class="md-auto">
                        <label for="facteur4"><strong>L'erreur est-elle liée à des tâches à accomplir ?</strong></label>
                    </div>
                    <!-- TA1 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Le(s) protocole(s) ou procédure(s) étaient-ils absents ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- TA2 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Le(s) protocole(s), procédure(s) étaient-ils inadaptés ou peu compréhensibles ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- TA3 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Le(s) protocole(s), procédure(s) étaient-ils indisponibles au moment de survenue de l'événement ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- TA4 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Le(s) protocole(s), procédure(s) étaient-ils inutilisables ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- TA5 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Le(s) protocole(s), procédure(s) étaient-ils insuffisamment diffusés et/ou connus ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- TA6 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Y a-t-il un retard dans la prestation ou la programmation des examens cliniques et paracliniques ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- TA7 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Y a-t-il eu défaut d'accessibilité, de disponibilité de l'information en temps voulu ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- TA8 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">La recherche d'information auprès d'un autre professionnel a-t-elle été difficile ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- TA9 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">La planification des tâches était-elle inadaptée ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- TA10 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Les soins/actes ne relevaient-ils pas du champ de compétence, d'activité du service ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- TA11 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Le(s) protocole(s), procédure(s) n'ont-ils pas été respectés ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- TA12 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Autre</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <div class="md-auto">
                        <label for="facteur5"><strong>L'erreur est-elle liée à des facteurs concernant l'environnement ?</strong></label>
                    </div>
                    <!-- CT1 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Les locaux ou le matériel utilisé étaient-ils inadaptés ou indisponibles ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- CT2 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Les fournitures ou équipements étaient-ils défectueux, mal entretenus ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- CT3 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Les fournitures ou équipements étaient-ils inexistants ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- CT4 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Les fournitures ou équipements ont-ils été mal utilisés ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- CT5 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Les supports d'information, les notices d'utilisation étaient-ils indisponibles ou inadaptés ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- CT6 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">La formation ou entraînement des professionnels étaient-ils inexistants, inadaptés, non réalisés ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- CT7 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Les conditions de travail étaient-elles inadaptées ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- CT8 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">La charge de travail était-elle importante au moment de l'événement ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- CT9 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Autre</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <div class="md-auto">
                        <label for="facteur6"><strong>L'erreur est-elle liée à des facteurs concernant l'organisation ?</strong></label>
                    </div>
                    <!-- OR1 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Y a-t-il eu un changement récent d'organisation interne ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- OR2 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Y a-t-il une limitation trop restrictive de la prise de décision des acteurs du terrain ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- OR3 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Les responsabilités et les tâches étaient-elles non ou mal définies ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- OR4 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Y a-t-il eu un défaut de coordination dans le servie ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- OR5 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Y a-t-il eu un défaut de coordination entre les services, les structurs ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- OR6 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Y a-t-il eu un défaut d'adaptation à une situation imprévue ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- OR7 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">La gestion des ressources humaines était-elle inadéquate ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- OR8 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">La procédure de sortie était-elle inadéquate ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- OR9 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Autre</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>


                    <div class="md-auto">
                        <label for="facteur7"><strong>L'erreur est-elle liée à des facteurs concernant le contexte institutionnel ?</strong></label>
                    </div>
                    <!-- IT1 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Les contraintes financières au niveau de l'établissement sont-elles à l'origine de l'événement ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- IT2 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Les ressources sanitaires sont-elles insuffisantes, inadaptées ou défectueuses ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- IT3 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Les échanges ou relations avec d'autres structures de soins sont-ils faibles ou difficiles ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- IT4 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Peut-on relever une absence de stratégie, politique/une absence de priorité/ou des stratégies contradictoires ou inadaptées ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- IT5 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">La sécurité et gestion des risques ne sont-elles pas perçues comme des objectifs importants ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- IT6 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">La culture du signalement des EI et de propositions de corrections est-elle inexistante ou défectueuse ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- IT7 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Le contexte social était-il difficile ?</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <!-- IT8 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Autre</label>
                        <input type="text" id="plus" name="plus" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                </div>
                <h4>ETAPE 4 : Qu'est-ce qui aurait pu empêcher la survenue de l'événement ? </h4>
                <!-- Est-ce que tout avait été mis en oeuvre pour éviter ce type d'EI ? -->
                <div class="md-auto">
                        <label for="prevention">Est-ce que tout avait été mis en oeuvre pour éviter ce type d'EI ?</label>
                        <input type="radio" id="prevention" name="prevention" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="prevention" name="prevention" value="Non" >
                        <label for="Non">Non</label> 
                </div>
                <!-- Défenses -->
                <div class="row mb-1">
                    <label class="col-6" for="action">Si non, quelles ont été les défenses manquantes ou non opérationnelles ?</label>  
                </div>
                <textarea class="col-4" maxlength="1000" id="defenses" name="defenses" ></textarea>
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
                            <td contenteditable="true">A compléter</td>
                            <td contenteditable="true">A compléter</td>
                            <td contenteditable="true">A compléter</td>
                            <td contenteditable="true">A compléter</td>
                            <td contenteditable="true">A compléter</td>
                            <td contenteditable="true">A compléter</td>
                        </tr>
                    </tbody>
                </table>
                <div class="md-auto">
                    <input class="btn btn-outline-primary" value="Ajouter une action">
                </div>
                <!-- Bouton de validation -->
                <div class="row justify-content-center">
                    <div class="valider"><a href="listeEM.php"><input class="btn btn-outline-primary" type="submit" value="Valider" name="valider"></a></div>
                </div>
            </form>
        </div>
    </body>
</html>