<!-- Affiche le formulaire d'analyse de l'événement et ajoute les éléments dans la base lors de la validation --> 
<?php
    include "bdd.php";

    // Récupération du numéro dans l'URL de l'événement choisi 
    $numero = trim($_GET['numero']);

    // On récupère les infos entrées lors de la déclaration
    $sql = "SELECT anonyme, e.nom, prenom, fonction, date_EM, d.nom as departement, est_neverevent, patient_risque, precisions_patient, medicament_risque, precisions_medicament, medicament_classe, administration_risque, administration_precisions, degre_realisation, etape_circuit, details, consequences, categorie_patient, categorie_administration FROM evenement e JOIN departement d ON e.departement=d.id WHERE e.numero='$numero'";
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
    $categorie_patient = sqlsrv_get_field($stmt, 18);
    $categorie_administration = sqlsrv_get_field($stmt, 19);

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
        if (isset($_POST['medicament_classe'])){
            $medicament_classe2 = $_POST['medicament_classe'];
        } else {
            $medicament_classe2 = "";
        }
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
        if ($_POST['etape_circuit']==="Autre"){
            $etape2 = $_POST['autre'];
        }
        $gravite = $_POST['gravite'];
        $occurrence = $_POST['occurrence'];
        $maitrise = $_POST['maitrise'];
        $criticite = $_POST['criticite'];
        $defaillance = $_POST['defaillance'];
        if (isset($_POST['categorie_patient'])){
            $categorie_patient2 = $_POST['categorie_patient'];
        } else {
            $categorie_patient2 = "";
        }
        if (isset($_POST['categorie_administration'])){
            $categorie_administration2 = $_POST['categorie_administration'];
        } else {
            $categorie_administration2 = "";
        }

        // Modification de l'événement à partir des données entrées dans le formulaire
        $updateEvenement="UPDATE evenement SET details='".$details2."',consequences='".$consequences2."',justification='".$justification."',prem_actions='".$prem_actions."',medicament_risque='".$medicament_risque2."',precisions_medicament='".$precisions_medicament2."',medicament_type='".$medicament_type."',patient_risque='".$patient_risque2."',precisions_patient='".$precisions_patient2."',administration_risque='".$administration_risque2."',est_analyse=1,est_refrigere='".$est_refrigere."',administration_precisions='".$administration_precisions2."',est_neverevent='".$neverevent2."',degre_realisation='".$degre2."',etape_circuit='".$etape2."',defaillance='".$defaillance."',medicament_classe='".$medicament_classe2."',categorie_patient='".$categorie_patient2."',categorie_administration='".$categorie_administration2."' WHERE numero=".$numero."";
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
                    <!-- Classe du médicament --> 
                    <div class="md-auto">
                        <label for="medicament_classe">Catégorie du médicament à risque :</label>
                    <?php
                        if ($medicament_classe==="1"){
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="1" checked="checked">';
                            echo '<label for="1">1</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="2"  >';
                            echo '<label for="2">2</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="3"  >';
                            echo '<label for="3">3</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="4"  >';
                            echo '<label for="4">4</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="5"  >';
                            echo '<label for="5">5</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="6"  >';
                            echo '<label for="6">6</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="7"  >';
                            echo '<label for="7">7</label>';
                        } else if ($medicament_classe==="2"){
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="1"  >';
                            echo '<label for="1">1</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="2"   checked="checked">';
                            echo '<label for="2">2</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="3"  >';
                            echo '<label for="3">3</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="4"  >';
                            echo '<label for="4">4</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="5"  >';
                            echo '<label for="5">5</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="6"  >';
                            echo '<label for="6">6</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="7"  >';
                            echo '<label for="7">7</label>';
                        } else if ($medicament_classe==="3"){
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="1"  >';
                            echo '<label for="1">1</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="2"  >';
                            echo '<label for="2">2</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="3"   checked="checked">';
                            echo '<label for="3">3</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="4"  >';
                            echo '<label for="4">4</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="5"  >';
                            echo '<label for="5">5</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="6"  >';
                            echo '<label for="6">6</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="7"  >';
                            echo '<label for="7">7</label>';
                        } else if ($medicament_classe==="4"){
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="1"  >';
                            echo '<label for="1">1</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="2"  >';
                            echo '<label for="2">2</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="3"  >';
                            echo '<label for="3">3</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="4"   checked="checked">';
                            echo '<label for="4">4</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="5"  >';
                            echo '<label for="5">5</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="6"  >';
                            echo '<label for="6">6</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="7"  >';
                            echo '<label for="7">7</label>';
                        } else if ($medicament_classe==="5"){
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="1"  >';
                            echo '<label for="1">1</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="2"  >';
                            echo '<label for="2">2</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="3"  >';
                            echo '<label for="3">3</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="4"   >';
                            echo '<label for="4">4</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="5"   checked="checked">';
                            echo '<label for="5">5</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="6"  >';
                            echo '<label for="6">6</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="7"  >';
                            echo '<label for="7">7</label>';
                        } else if ($medicament_classe==="6"){
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="1"  >';
                            echo '<label for="1">1</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="2"  >';
                            echo '<label for="2">2</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="3"  >';
                            echo '<label for="3">3</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="4"   >';
                            echo '<label for="4">4</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="5"  >';
                            echo '<label for="5">5</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="6"   checked="checked">';
                            echo '<label for="6">6</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="7"  >';
                            echo '<label for="7">7</label>';
                        } else if ($medicament_classe==="7") {
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="1"  >';
                            echo '<label for="1">1</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="2"  >';
                            echo '<label for="2">2</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="3"  >';
                            echo '<label for="3">3</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="4"   >';
                            echo '<label for="4">4</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="5"  >';
                            echo '<label for="5">5</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="6"  >';
                            echo '<label for="6">6</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="7"   checked="checked">';
                            echo '<label for="7">7</label>';
                        } else {
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="1"  >';
                            echo '<label for="1">1</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="2"  >';
                            echo '<label for="2">2</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="3"  >';
                            echo '<label for="3">3</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="4"   >';
                            echo '<label for="4">4</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="5"  >';
                            echo '<label for="5">5</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="6"  >';
                            echo '<label for="6">6</label>';
                            echo '<input type="radio" id="medicament_classe" name="medicament_classe" value="7">';
                            echo '<label for="7">7</label>';
                        }
                    ?>
                    </div>
                    <!-- Nom du médicament -->
                        <div class="md-auto">
                        <label for="precisions_medicament2">Nom du médicament :</label>
                        <input type="text" id="precisions_medicament2" name="precisions_medicament2" value="<?php echo $precisions_medicament ?>" autocomplete="off">
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
                    <!-- Catégorie du patient à risque --> 
                    <div class="md-auto">
                        <label for="categorie_patient">Catégorie du patient à risque :</label>
                    <?php
                        if ($categorie_patient==="1"){
                            echo '<input type="radio" id="categorie_patient" name="categorie_patient" value="1" checked="checked">';
                            echo '<label for="1">1</label>';
                            echo '<input type="radio" id="categorie_patient" name="categorie_patient" value="2">';
                            echo '<label for="2">2</label>';
                            echo '<input type="radio" id="categorie_patient" name="categorie_patient" value="3">';
                            echo '<label for="3">3</label>';
                            echo '<input type="radio" id="categorie_patient" name="categorie_patient" value="4">';
                            echo '<label for="4">4</label>';
                        } else if ($categorie_patient==="2"){
                            echo '<input type="radio" id="categorie_patient" name="categorie_patient" value="1">';
                            echo '<label for="1">1</label>';
                            echo '<input type="radio" id="categorie_patient" name="categorie_patient" value="2" checked="checked">';
                            echo '<label for="2">2</label>';
                            echo '<input type="radio" id="categorie_patient" name="categorie_patient" value="3">';
                            echo '<label for="3">3</label>';
                            echo '<input type="radio" id="categorie_patient" name="categorie_patient" value="4">';
                            echo '<label for="4">4</label>';
                        } else if ($categorie_patient==="3"){
                            echo '<input type="radio" id="categorie_patient" name="categorie_patient" value="1">';
                            echo '<label for="1">1</label>';
                            echo '<input type="radio" id="categorie_patient" name="categorie_patient" value="2">';
                            echo '<label for="2">2</label>';
                            echo '<input type="radio" id="categorie_patient" name="categorie_patient" value="3" checked="checked">';
                            echo '<label for="3">3</label>';
                            echo '<input type="radio" id="categorie_patient" name="categorie_patient" value="4">';
                            echo '<label for="4">4</label>';
                        } else if ($categorie_patient==="4"){
                            echo '<input type="radio" id="categorie_patient" name="categorie_patient" value="1">';
                            echo '<label for="1">1</label>';
                            echo '<input type="radio" id="categorie_patient" name="categorie_patient" value="2">';
                            echo '<label for="2">2</label>';
                            echo '<input type="radio" id="categorie_patient" name="categorie_patient" value="3">';
                            echo '<label for="3">3</label>';
                            echo '<input type="radio" id="categorie_patient" name="categorie_patient" value="4" checked="checked">';
                            echo '<label for="4">4</label>';
                        } else {
                            echo '<input type="radio" id="categorie_patient" name="categorie_patient" value="1">';
                            echo '<label for="1">1</label>';
                            echo '<input type="radio" id="categorie_patient" name="categorie_patient" value="2">';
                            echo '<label for="2">2</label>';
                            echo '<input type="radio" id="categorie_patient" name="categorie_patient" value="3">';
                            echo '<label for="3">3</label>';
                            echo '<input type="radio" id="categorie_patient" name="categorie_patient" value="4">';
                            echo '<label for="4">4</label>';
                        }
                    ?>
                    </div>
                    <!-- Précisions sur le patient -->
                    <div class="md-auto">
                        <label for="precisions_patient2">Commentaires sur l'état du patient :</label>
                        <input type="text" id="precisions_patient2" name="precisions_patient2" value="<?php echo $precisions_patient ?>" autocomplete="off">
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
                    <!-- Catégorie du patient à risque --> 
                    <div class="md-auto">
                        <label for="categorie_administration">Catégorie de la voie d'administration à risque :</label>
                    <?php
                        if ($categorie_administration==="1"){
                            echo '<input type="radio" id="categorie_administration" name="categorie_administration" value="1" checked="checked">';
                            echo '<label for="1">1</label>';
                            echo '<input type="radio" id="categorie_administration" name="categorie_administration" value="2">';
                            echo '<label for="2">2</label>';
                            echo '<input type="radio" id="categorie_administration" name="categorie_administration" value="3">';
                            echo '<label for="3">3</label>';
                        } else if ($categorie_administration==="2"){
                            echo '<input type="radio" id="categorie_administration" name="categorie_administration" value="1">';
                            echo '<label for="1">1</label>';
                            echo '<input type="radio" id="categorie_administration" name="categorie_administration" value="2" checked="checked">';
                            echo '<label for="2">2</label>';
                            echo '<input type="radio" id="categorie_administration" name="categorie_administration" value="3">';
                            echo '<label for="3">3</label>';
                        } else if ($categorie_administration==="3"){
                            echo '<input type="radio" id="categorie_administration" name="categorie_administration" value="1">';
                            echo '<label for="1">1</label>';
                            echo '<input type="radio" id="categorie_administration" name="categorie_administration" value="2">';
                            echo '<label for="2">2</label>';
                            echo '<input type="radio" id="categorie_administration" name="categorie_administration" value="3" checked="checked">';
                            echo '<label for="3">3</label>';
                        } else {
                            echo '<input type="radio" id="categorie_administration" name="categorie_administration" value="1">';
                            echo '<label for="1">1</label>';
                            echo '<input type="radio" id="categorie_administration" name="categorie_administration" value="2">';
                            echo '<label for="2">2</label>';
                            echo '<input type="radio" id="categorie_administration" name="categorie_administration" value="3">';
                            echo '<label for="3">3</label>';
                        }
                    ?>
                    </div>
                    <!-- Précisions -->
                    <div class="md-auto">
                        <label for="administration_precisions2">Nom de la voie d'administration :</label>
                        <input type="text" id="administration_precisions2" name="administration_precisions2" value="<?php echo $administration_precisions ?>" autocomplete="off">
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
                            if ($degre === "Erreur médicamenteuse a atteint le patient"){
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Erreur médicamenteuse a atteint le patient" required checked="checked">';
                                echo '<label for="Erreur médicamenteuse a atteint le patient">Erreur médicamenteuse a atteint le patient</label>';
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Erreur médicamenteuse a été interceptée" required>';
                                echo '<label for="Erreur médicamenteuse a été interceptée">Erreur médicamenteuse a été interceptée</label>';
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Evénement porteur de risque (EPR)" required>';
                                echo '<label for="Evénement porteur de risque (EPR)">Evénement porteur de risque (EPR)</label>';
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Je ne sais pas" required>';
                                echo '<label for="Jenesaispas">Je ne sais pas</label>'; 
                            } else if ($degre === "Erreur médicamenteuse a été interceptée"){
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Erreur médicamenteuse a atteint le patient" required>';
                                echo '<label for="Erreur médicamenteuse a atteint le patient">Erreur médicamenteuse a atteint le patient</label>';
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Erreur médicamenteuse a été interceptée" required checked="checked">';
                                echo '<label for="Erreur médicamenteuse a été interceptée">Erreur médicamenteuse a été interceptée</label>';
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Evénement porteur de risque (EPR)" required>';
                                echo '<label for="Evénement porteur de risque (EPR)">Evénement porteur de risque (EPR)</label>';
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Je ne sais pas" required>';
                                echo '<label for="Jenesaispas">Je ne sais pas</label>'; 
                            } else if ($degre === "Evénement porteur de risque (EPR)"){
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Erreur médicamenteuse a atteint le patient" required>';
                                echo '<label for="Erreur médicamenteuse a atteint le patient">Erreur médicamenteuse a atteint le patient</label>';
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Erreur médicamenteuse a été interceptée" required>';
                                echo '<label for="Erreur médicamenteuse a été interceptée">Erreur médicamenteuse a été interceptée</label>';
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Evénement porteur de risque (EPR)" required checked="checked">';
                                echo '<label for="Evénement porteur de risque (EPR)">Evénement porteur de risque (EPR)</label>';
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Je ne sais pas" required>';
                                echo '<label for="Jenesaispas">Je ne sais pas</label>'; 
                            } else {
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Erreur médicamenteuse a atteint le patient" required>';
                                echo '<label for="Erreur médicamenteuse a atteint le patient">Erreur médicamenteuse a atteint le patient</label>';
                                echo '<input type="radio" id="degre_realisation" name="degre_realisation" value="Erreur médicamenteuse a été interceptée" required>';
                                echo '<label for="Erreur médicamenteuse a été interceptée">Erreur médicamenteuse a été interceptée</label>';
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
                                echo '<input type="text" id="etape_circuit" name="autre" autocomplete="off">';  
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
                                echo '<input type="text" id="etape_circuit" name="autre" autocomplete="off">'; 
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
                                echo '<input type="text" id="etape_circuit" name="autre" autocomplete="off">'; 
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
                                echo '<input type="text" id="etape_circuit" name="autre" autocomplete="off">';
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
                                echo '<input type="text" id="etape_circuit" name="autre" autocomplete="off">'; 
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
                                echo '<input type="text" id="etape_circuit" name="autre" autocomplete="off">'; 
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
                                echo '<input type="text" id="etape_circuit" name="autre" value="'.$etape.'" autocomplete="off">'; 
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
                        <a class="col-6" href="cotation.pdf" target="_blank">Cliquez pour consulter l'échelle de cotation des événements indésirables</a>
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
                <textarea class="col-4" maxlength="1000" id="defaillance" name="defaillance" required></textarea>
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
                        <input type="text" id="plus" name="plus1" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable1" name="evitable1" value="Oui">
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable1" name="evitable1" value="Non">
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['PA1'])){
                        if (isset($_POST['plus1'])){
                            $precisions1 = $_POST['plus1'];
                        } else {
                            $precisions1 = "";
                        }
                        if (isset($_POST['evitable1'])){
                            $evitable1 = $_POST['evitable1'];
                        } else {
                            $evitable1 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable1,'PA1',$precisions1,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- PA2 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA2" name="PA2">
                        <label for="PA2">L'EI est-il survenu dans un contexte de prise en charge en urgence ?</label>
                        <input type="text" id="plus" name="plus2" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable2" value="Oui">
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable2" value="Non">
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['PA2'])){
                        if (isset($_POST['plus2'])){
                            $precisions2 = $_POST['plus2'];
                        } else {
                            $precisions2 = "";
                        }
                        if (isset($_POST['evitable2'])){
                            $evitable2 = $_POST['evitable2'];
                        } else {
                            $evitable2 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable2,'PA2',$precisions2,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- PA3 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA3" name="PA3">
                        <label for="PA3">L'expression du patient ou la communication étaient-elles difficiles ?</label>
                        <input type="text" id="plus" name="plus3" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable3" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable3" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['PA3'])){
                        if (isset($_POST['plus3'])){
                            $precisions3 = $_POST['plus3'];
                        } else {
                            $precisions3 = "";
                        }
                        if (isset($_POST['evitable3'])){
                            $evitable3 = $_POST['evitable3'];
                        } else {
                            $evitable3 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable3,'PA3',$precisions3,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- PA4 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA4" name="PA4" >
                        <label for="PA4">La personnalité du patient est-elle particulière et peut-elle expliquer en partie le dysfonctionnement ?</label>
                        <input type="text" id="plus" name="plus4" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable4" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable4" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['PA4'])){
                        if (isset($_POST['plus4'])){
                            $precisions4 = $_POST['plus4'];
                        } else {
                            $precisions4 = "";
                        }
                        if (isset($_POST['evitable4'])){
                            $evitable4 = $_POST['evitable4'];
                        } else {
                            $evitable4 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable4,'PA4',$precisions4,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- PA5 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA5" name="PA5" >
                        <label for="PA5">Existe-t-il des facteurs sociaux particuliers susceptibles d'expliquer tout ou partie des dysfonctionnements ?</label>
                        <input type="text" id="plus" name="plus5" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable5" value="Oui">
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable5" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['PA5'])){
                        if (isset($_POST['plus5'])){
                            $precisions5 = $_POST['plus5'];
                        } else {
                            $precisions5 = "";
                        }
                        if (isset($_POST['evitable5'])){
                            $evitable5 = $_POST['evitable5'];
                        } else {
                            $evitable5 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable5,'PA5',$precisions5,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- PA6 -->
                    <div class="md-auto">
                        <input type="checkbox" id="PA6" name="PA6" >
                        <label for="PA6">Autre</label>
                        <input type="text" id="plus" name="plus6" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable6" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable6" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <div class="md-auto">
                        <label for="facteur2"><strong>L'erreur est-elle liée à des facteurs individuels ?</strong></label>
                    </div>
                    <?php 
                    if (isset($_POST['PA6'])){
                        if (isset($_POST['plus6'])){
                            $precisions6 = $_POST['plus6'];
                        } else {
                            $precisions6 = "";
                        }
                        if (isset($_POST['evitable6'])){
                            $evitable6 = $_POST['evitable6'];
                        } else {
                            $evitable6 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable6,'PA6',$precisions6,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- IN1 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IN1" name="IN1" >
                        <label for="IN1">Y a-t-il un défaut de qualification des personnes chargées du soin / de l'acte ?</label>
                        <input type="text" id="plus" name="plus7" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable7" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable7" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['IN1'])){
                        if (isset($_POST['plus7'])){
                            $precisions7 = $_POST['plus7'];
                        } else {
                            $precisions7 = "";
                        }
                        if (isset($_POST['evitable7'])){
                            $evitable7 = $_POST['evitable7'];
                        } else {
                            $evitable7 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable7,'IN1',$precisions7,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- IN2 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IN2" name="IN2" >
                        <label for="IN2">Y a-t-il un défaut de connaissances théoriques ou techniques des professionnels ?</label>
                        <input type="text" id="plus" name="plus8" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable8" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable8" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['IN2'])){
                        if (isset($_POST['plus8'])){
                            $precisions8 = $_POST['plus8'];
                        } else {
                            $precisions8 = "";
                        }
                        if (isset($_POST['evitable8'])){
                            $evitable8 = $_POST['evitable8'];
                        } else {
                            $evitable8 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable8,'IN2',$precisions8,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- IN3 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IN3" name="IN3" >
                        <label for="IN3">Y a-t-il un défaut d'aptitude, de compétence des professionnels chargés du soin / de l'acte ?</label>
                        <input type="text" id="plus" name="plus9" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable9" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable9" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['IN3'])){
                        if (isset($_POST['plus9'])){
                            $precisions9 = $_POST['plus9'];
                        } else {
                            $precisions9 = "";
                        }
                        if (isset($_POST['evitable9'])){
                            $evitable9 = $_POST['evitable9'];
                        } else {
                            $evitable9 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable9,'IN3',$precisions9,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- IN4 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IN4" name="IN4" >
                        <label for="IN4">Les professionnels chargés des soins étaient-ils en mauvaise disposition physique et mentale ?</label>
                        <input type="text" id="plus" name="plus10" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable10" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable10" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['IN4'])){
                        if (isset($_POST['plus10'])){
                            $precisions10 = $_POST['plus10'];
                        } else {
                            $precisions10 = "";
                        }
                        if (isset($_POST['evitable10'])){
                            $evitable10 = $_POST['evitable10'];
                        } else {
                            $evitable10 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable10,'IN4',$precisions10,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- IN5 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IN5" name="IN5" >
                        <label for="IN5">Y a-t-il eu une insuffisance d'échange d'information entre les professionnels de santé et le patient ?</label>
                        <input type="text" id="plus" name="plus11" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable11" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable11" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['IN5'])){
                        if (isset($_POST['plus11'])){
                            $precisions11 = $_POST['plus11'];
                        } else {
                            $precisions11 = "";
                        }
                        if (isset($_POST['evitable11'])){
                            $evitable11 = $_POST['evitable11'];
                        } else {
                            $evitable11 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable11,'IN5',$precisions11,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- IN6 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IN6" name="IN6" >
                        <label for="IN6">Y a-t-il eu une insuffisance d'échange d'information entre les professionnels de santé et la famille du patient ?</label>
                        <input type="text" id="plus" name="plus12" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable12" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable12" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['IN6'])){
                        if (isset($_POST['plus12'])){
                            $precisions12 = $_POST['plus12'];
                        } else {
                            $precisions12 = "";
                        }
                        if (isset($_POST['evitable12'])){
                            $evitable12 = $_POST['evitable12'];
                        } else {
                            $evitable12 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable12,'IN6',$precisions12,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- IN7 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IN7" name="IN7" >
                        <label for="IN7">A-t-on relevé un défaut de qualité de la relation avec le patient et sa famille ?</label>
                        <input type="text" id="plus" name="plus13" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable13" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable13" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['IN7'])){
                        if (isset($_POST['plus13'])){
                            $precisions13 = $_POST['plus13'];
                        } else {
                            $precisions13 = "";
                        }
                        if (isset($_POST['evitable13'])){
                            $evitable13 = $_POST['evitable13'];
                        } else {
                            $evitable13 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable13,'IN7',$precisions13,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- IN8 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IN8" name="IN8" >
                        <label for="IN8">Autre</label>
                        <input type="text" id="plus" name="plus14" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable14" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable14" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['IN8'])){
                        if (isset($_POST['plus14'])){
                            $precisions14 = $_POST['plus14'];
                        } else {
                            $precisions14 = "";
                        }
                        if (isset($_POST['evitable14'])){
                            $evitable14 = $_POST['evitable14'];
                        } else {
                            $evitable14 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable14,'IN8',$precisions14,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <div class="md-auto">
                        <label for="facteur3"><strong>L'erreur est-elle liée à des facteurs concernant l'équipe ?</strong></label>
                    </div>
                    <!-- EQ1 -->
                    <div class="md-auto">
                        <input type="checkbox" id="EQ1" name="EQ1" >
                        <label for="PA6">La composition de l'équipe chargée du soin était-elle mauvaise ou inadaptée ?</label>
                        <input type="text" id="plus" name="plus15" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable15" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable15" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['EQ1'])){
                        if (isset($_POST['plus15'])){
                            $precisions15 = $_POST['plus15'];
                        } else {
                            $precisions15 = "";
                        }
                        if (isset($_POST['evitable15'])){
                            $evitable15 = $_POST['evitable15'];
                        } else {
                            $evitable15 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable15,'EQ1',$precisions15,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- EQ2 -->
                    <div class="md-auto">
                        <input type="checkbox" id="EQ2" name="EQ2" >
                        <label for="PA6">A-t-on relevé un défaut de communication interne orale et/ou écrite au sein de l'équipe ?</label>
                        <input type="text" id="plus" name="plus16" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable16" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable16" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['EQ2'])){
                        if (isset($_POST['plus16'])){
                            $precisions16 = $_POST['plus16'];
                        } else {
                            $precisions16 = "";
                        }
                        if (isset($_POST['evitable16'])){
                            $evitable16 = $_POST['evitable16'];
                        } else {
                            $evitable16 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable16,'EQ2',$precisions16,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- EQ3 -->
                    <div class="md-auto">
                        <input type="checkbox" id="EQ3" name="EQ3" >
                        <label for="PA6">A-t-on relevé une collaboration insuffisante entre professionnels ?</label>
                        <input type="text" id="plus" name="plus17" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable17" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable17" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['EQ3'])){
                        if (isset($_POST['plus17'])){
                            $precisions17 = $_POST['plus17'];
                        } else {
                            $precisions17 = "";
                        }
                        if (isset($_POST['evitable17'])){
                            $evitable17 = $_POST['evitable17'];
                        } else {
                            $evitable17 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable17,'EQ3',$precisions17,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- EQ4 -->
                    <div class="md-auto">
                        <input type="checkbox" id="EQ4" name="EQ4">
                        <label for="PA6">Existe-t-il des conflits ou une mauvaise ambiance au sein de l'équipe / un défaut de cohésion ?</label>
                        <input type="text" id="plus" name="plus18" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable18" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable18" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['EQ4'])){
                        if (isset($_POST['plus18'])){
                            $precisions18 = $_POST['plus18'];
                        } else {
                            $precisions18 = "";
                        }
                        if (isset($_POST['evitable18'])){
                            $evitable18 = $_POST['evitable18'];
                        } else {
                            $evitable18 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable18,'EQ4',$precisions18,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- EQ5 -->
                    <div class="md-auto">
                        <input type="checkbox" id="EQ5" name="EQ5" >
                        <label for="PA6">La supervision des responsables et des autres personnels a-t-elle été inadéquate ?</label>
                        <input type="text" id="plus" name="plus19" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable19" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable19" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['EQ5'])){
                        if (isset($_POST['plus19'])){
                            $precisions19 = $_POST['plus19'];
                        } else {
                            $precisions19 = "";
                        }
                        if (isset($_POST['evitable19'])){
                            $evitable19 = $_POST['evitable19'];
                        } else {
                            $evitable19 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable19,'EQ5',$precisions19,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- EQ6 -->
                    <div class="md-auto">
                        <input type="checkbox" id="EQ6" name="EQ6" >
                        <label for="PA6">Y a-t-il un manque ou un défaut de recherche d'aide, d'avis, de collaboration ?</label>
                        <input type="text" id="plus" name="plus20" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable20" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable20" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['EQ6'])){
                        if (isset($_POST['plus20'])){
                            $precisions20 = $_POST['plus20'];
                        } else {
                            $precisions20 = "";
                        }
                        if (isset($_POST['evitable20'])){
                            $evitable20 = $_POST['evitable20'];
                        } else {
                            $evitable20 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable20,'EQ6',$precisions20,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- EQ7 -->
                    <div class="md-auto">
                        <input type="checkbox" id="EQ7" name="EQ7" >
                        <label for="PA6">Autre</label>
                        <input type="text" id="plus" name="plus21" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable21" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable21" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['EQ7'])){
                        if (isset($_POST['plus21'])){
                            $precisions21 = $_POST['plus21'];
                        } else {
                            $precisions21 = "";
                        }
                        if (isset($_POST['evitable21'])){
                            $evitable21 = $_POST['evitable21'];
                        } else {
                            $evitable21 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable21,'EQ7',$precisions21,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <div class="md-auto">
                        <label for="facteur4"><strong>L'erreur est-elle liée à des tâches à accomplir ?</strong></label>
                    </div>
                    <!-- TA1 -->
                    <div class="md-auto">
                        <input type="checkbox" id="TA1" name="TA1" >
                        <label for="PA6">Le(s) protocole(s) ou procédure(s) étaient-ils absents ?</label>
                        <input type="text" id="plus" name="plus22" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable22" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable22" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['TA1'])){
                        if (isset($_POST['plus22'])){
                            $precisions22 = $_POST['plus22'];
                        } else {
                            $precisions22 = "";
                        }
                        if (isset($_POST['evitable22'])){
                            $evitable22 = $_POST['evitable22'];
                        } else {
                            $evitable22 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable22,'TA1',$precisions22,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- TA2 -->
                    <div class="md-auto">
                        <input type="checkbox" id="TA2" name="TA2" >
                        <label for="PA6">Le(s) protocole(s), procédure(s) étaient-ils inadaptés ou peu compréhensibles ?</label>
                        <input type="text" id="plus" name="plus23" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable23" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable23" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['TA2'])){
                        if (isset($_POST['plus23'])){
                            $precisions23 = $_POST['plus23'];
                        } else {
                            $precisions23 = "";
                        }
                        if (isset($_POST['evitable23'])){
                            $evitable23 = $_POST['evitable23'];
                        } else {
                            $evitable23 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable23,'TA2',$precisions23,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- TA3 -->
                    <div class="md-auto">
                        <input type="checkbox" id="TA3" name="TA3" >
                        <label for="PA6">Le(s) protocole(s), procédure(s) étaient-ils indisponibles au moment de survenue de l'événement ?</label>
                        <input type="text" id="plus" name="plus24" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable24" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable24" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['TA3'])){
                        if (isset($_POST['plus24'])){
                            $precisions24 = $_POST['plus24'];
                        } else {
                            $precisions24 = "";
                        }
                        if (isset($_POST['evitable24'])){
                            $evitable24 = $_POST['evitable24'];
                        } else {
                            $evitable24 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable24,'TA3',$precisions24,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- TA4 -->
                    <div class="md-auto">
                        <input type="checkbox" id="TA4" name="TA4" >
                        <label for="PA6">Le(s) protocole(s), procédure(s) étaient-ils inutilisables ?</label>
                        <input type="text" id="plus" name="plus25" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable25" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable25" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['TA4'])){
                        if (isset($_POST['plus25'])){
                            $precisions25 = $_POST['plus25'];
                        } else {
                            $precisions25 = "";
                        }
                        if (isset($_POST['evitable25'])){
                            $evitable25 = $_POST['evitable25'];
                        } else {
                            $evitable25 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable25,'TA4',$precisions25,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- TA5 -->
                    <div class="md-auto">
                        <input type="checkbox" id="TA5" name="TA5" >
                        <label for="PA6">Le(s) protocole(s), procédure(s) étaient-ils insuffisamment diffusés et/ou connus ?</label>
                        <input type="text" id="plus" name="plus26" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable26" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable26" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['TA5'])){
                        if (isset($_POST['plus26'])){
                            $precisions26 = $_POST['plus26'];
                        } else {
                            $precisions26 = "";
                        }
                        if (isset($_POST['evitable26'])){
                            $evitable26 = $_POST['evitable26'];
                        } else {
                            $evitable26 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable26,'TA5',$precisions26,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- TA6 -->
                    <div class="md-auto">
                        <input type="checkbox" id="TA6" name="TA6" >
                        <label for="PA6">Y a-t-il un retard dans la prestation ou la programmation des examens cliniques et paracliniques ?</label>
                        <input type="text" id="plus" name="plus27" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable27" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable27" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['TA6'])){
                        if (isset($_POST['plus27'])){
                            $precisions27 = $_POST['plus27'];
                        } else {
                            $precisions27 = "";
                        }
                        if (isset($_POST['evitable27'])){
                            $evitable27 = $_POST['evitable27'];
                        } else {
                            $evitable27 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable27,'TA6',$precisions27,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- TA7 -->
                    <div class="md-auto">
                        <input type="checkbox" id="TA7" name="TA7" >
                        <label for="PA6">Y a-t-il eu défaut d'accessibilité, de disponibilité de l'information en temps voulu ?</label>
                        <input type="text" id="plus" name="plus28" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable28" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable28" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['TA7'])){
                        if (isset($_POST['plus28'])){
                            $precisions28 = $_POST['plus28'];
                        } else {
                            $precisions28 = "";
                        }
                        if (isset($_POST['evitable28'])){
                            $evitable28 = $_POST['evitable28'];
                        } else {
                            $evitable28 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable28,'TA7',$precisions28,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- TA8 -->
                    <div class="md-auto">
                        <input type="checkbox" id="TA8" name="TA8" >
                        <label for="PA6">La recherche d'information auprès d'un autre professionnel a-t-elle été difficile ?</label>
                        <input type="text" id="plus" name="plus29" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable29" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable29" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['TA8'])){
                        if (isset($_POST['plus29'])){
                            $precisions29 = $_POST['plus29'];
                        } else {
                            $precisions29 = "";
                        }
                        if (isset($_POST['evitable29'])){
                            $evitable29 = $_POST['evitable29'];
                        } else {
                            $evitable29 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable29,'TA8',$precisions29,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- TA9 -->
                    <div class="md-auto">
                        <input type="checkbox" id="TA9" name="TA9" >
                        <label for="PA6">La planification des tâches était-elle inadaptée ?</label>
                        <input type="text" id="plus" name="plus30" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable30" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable30" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['TA9'])){
                        if (isset($_POST['plus30'])){
                            $precisions30 = $_POST['plus30'];
                        } else {
                            $precisions30 = "";
                        }
                        if (isset($_POST['evitable30'])){
                            $evitable30 = $_POST['evitable30'];
                        } else {
                            $evitable30 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable30,'TA9',$precisions30,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- TA10 -->
                    <div class="md-auto">
                        <input type="checkbox" id="TA10" name="TA10" >
                        <label for="PA6">Les soins/actes ne relevaient-ils pas du champ de compétence, d'activité du service ?</label>
                        <input type="text" id="plus" name="plus31" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable31" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable31" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['TA10'])){
                        if (isset($_POST['plus31'])){
                            $precisions31 = $_POST['plus31'];
                        } else {
                            $precisions31 = "";
                        }
                        if (isset($_POST['evitable31'])){
                            $evitable31 = $_POST['evitable31'];
                        } else {
                            $evitable31 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable31,'TA10',$precisions31,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- TA11 -->
                    <div class="md-auto">
                        <input type="checkbox" id="TA11" name="TA11" >
                        <label for="PA6">Le(s) protocole(s), procédure(s) n'ont-ils pas été respectés ?</label>
                        <input type="text" id="plus" name="plus32" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable32" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable32" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['TA11'])){
                        if (isset($_POST['plus32'])){
                            $precisions32 = $_POST['plus32'];
                        } else {
                            $precisions32 = "";
                        }
                        if (isset($_POST['evitable32'])){
                            $evitable32 = $_POST['evitable32'];
                        } else {
                            $evitable32 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable32,'TA11',$precisions32,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- TA12 -->
                    <div class="md-auto">
                        <input type="checkbox" id="TA12" name="TA12" >
                        <label for="PA6">Autre</label>
                        <input type="text" id="plus" name="plus33" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable33" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable33" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['TA12'])){
                        if (isset($_POST['plus33'])){
                            $precisions33 = $_POST['plus33'];
                        } else {
                            $precisions33 = "";
                        }
                        if (isset($_POST['evitable33'])){
                            $evitable33 = $_POST['evitable33'];
                        } else {
                            $evitable33 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable33,'TA12',$precisions33,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <div class="md-auto">
                        <label for="facteur5"><strong>L'erreur est-elle liée à des facteurs concernant l'environnement ?</strong></label>
                    </div>
                    <!-- CT1 -->
                    <div class="md-auto">
                        <input type="checkbox" id="CT1" name="CT1" >
                        <label for="PA6">Les locaux ou le matériel utilisé étaient-ils inadaptés ou indisponibles ?</label>
                        <input type="text" id="plus" name="plus34" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable34" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable34" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['CT1'])){
                        if (isset($_POST['plus34'])){
                            $precisions34 = $_POST['plus34'];
                        } else {
                            $precisions34 = "";
                        }
                        if (isset($_POST['evitable34'])){
                            $evitable34 = $_POST['evitable34'];
                        } else {
                            $evitable34 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable34,'CT1',$precisions34,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- CT2 -->
                    <div class="md-auto">
                        <input type="checkbox" id="CT2" name="CT2" >
                        <label for="PA6">Les fournitures ou équipements étaient-ils défectueux, mal entretenus ?</label>
                        <input type="text" id="plus" name="plus35" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable35" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable35" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['CT2'])){
                        if (isset($_POST['plus35'])){
                            $precisions35 = $_POST['plus35'];
                        } else {
                            $precisions35 = "";
                        }
                        if (isset($_POST['evitable35'])){
                            $evitable35 = $_POST['evitable35'];
                        } else {
                            $evitable35 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable35,'CT2',$precisions35,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- CT3 -->
                    <div class="md-auto">
                        <input type="checkbox" id="CT3" name="CT3" >
                        <label for="PA6">Les fournitures ou équipements étaient-ils inexistants ?</label>
                        <input type="text" id="plus" name="plus36" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable36" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable36" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['CT3'])){
                        if (isset($_POST['plus36'])){
                            $precisions36 = $_POST['plus36'];
                        } else {
                            $precisions36 = "";
                        }
                        if (isset($_POST['evitable36'])){
                            $evitable36 = $_POST['evitable36'];
                        } else {
                            $evitable36 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable36,'CT3',$precisions36,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- CT4 -->
                    <div class="md-auto">
                        <input type="checkbox" id="CT4" name="CT4" >
                        <label for="PA6">Les fournitures ou équipements ont-ils été mal utilisés ?</label>
                        <input type="text" id="plus" name="plus37" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable37" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable37" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['CT4'])){
                        if (isset($_POST['plus37'])){
                            $precisions37 = $_POST['plus37'];
                        } else {
                            $precisions37 = "";
                        }
                        if (isset($_POST['evitable37'])){
                            $evitable37 = $_POST['evitable37'];
                        } else {
                            $evitable37 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable37,'CT4',$precisions37,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- CT5 -->
                    <div class="md-auto">
                        <input type="checkbox" id="CT5" name="CT5" >
                        <label for="PA6">Les supports d'information, les notices d'utilisation étaient-ils indisponibles ou inadaptés ?</label>
                        <input type="text" id="plus" name="plus38" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable38" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable38" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['CT5'])){
                        if (isset($_POST['plus38'])){
                            $precisions38 = $_POST['plus38'];
                        } else {
                            $precisions38 = "";
                        }
                        if (isset($_POST['evitable38'])){
                            $evitable38 = $_POST['evitable38'];
                        } else {
                            $evitable38 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable38,'CT5',$precisions38,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- CT6 -->
                    <div class="md-auto">
                        <input type="checkbox" id="CT6" name="CT6" >
                        <label for="PA6">La formation ou entraînement des professionnels étaient-ils inexistants, inadaptés, non réalisés ?</label>
                        <input type="text" id="plus" name="plus39" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable39" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable39" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['CT6'])){
                        if (isset($_POST['plus39'])){
                            $precisions39 = $_POST['plus39'];
                        } else {
                            $precisions39 = "";
                        }
                        if (isset($_POST['evitable39'])){
                            $evitable39 = $_POST['evitable39'];
                        } else {
                            $evitable39 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable39,'CT6',$precisions39,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- CT7 -->
                    <div class="md-auto">
                        <input type="checkbox" id="CT7" name="CT7" >
                        <label for="PA6">Les conditions de travail étaient-elles inadaptées ?</label>
                        <input type="text" id="plus" name="plus40" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable40" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable40" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['CT7'])){
                        if (isset($_POST['plus40'])){
                            $precisions40 = $_POST['plus40'];
                        } else {
                            $precisions40 = "";
                        }
                        if (isset($_POST['evitable40'])){
                            $evitable40 = $_POST['evitable40'];
                        } else {
                            $evitable40 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable40,'CT7',$precisions40,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- CT8 -->
                    <div class="md-auto">
                        <input type="checkbox" id="CT8" name="CT8" >
                        <label for="PA6">La charge de travail était-elle importante au moment de l'événement ?</label>
                        <input type="text" id="plus" name="plus41" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable41" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable41" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['CT8'])){
                        if (isset($_POST['plus41'])){
                            $precisions41 = $_POST['plus41'];
                        } else {
                            $precisions41 = "";
                        }
                        if (isset($_POST['evitable41'])){
                            $evitable41 = $_POST['evitable41'];
                        } else {
                            $evitable41 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable41,'CT8',$precisions41,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- CT9 -->
                    <div class="md-auto">
                        <input type="checkbox" id="CT9" name="CT9" >
                        <label for="PA6">Autre</label>
                        <input type="text" id="plus" name="plus42" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable42" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable42" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['CT9'])){
                        if (isset($_POST['plus42'])){
                            $precisions42 = $_POST['plus42'];
                        } else {
                            $precisions42 = "";
                        }
                        if (isset($_POST['evitable42'])){
                            $evitable42 = $_POST['evitable42'];
                        } else {
                            $evitable42 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable42,'CT9',$precisions42,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <div class="md-auto">
                        <label for="facteur6"><strong>L'erreur est-elle liée à des facteurs concernant l'organisation ?</strong></label>
                    </div>
                    <!-- OR1 -->
                    <div class="md-auto">
                        <input type="checkbox" id="OR1" name="OR1" >
                        <label for="PA6">Y a-t-il eu un changement récent d'organisation interne ?</label>
                        <input type="text" id="plus" name="plus43" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable43" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable43" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['OR1'])){
                        if (isset($_POST['plus43'])){
                            $precisions43 = $_POST['plus43'];
                        } else {
                            $precisions43 = "";
                        }
                        if (isset($_POST['evitable43'])){
                            $evitable43 = $_POST['evitable43'];
                        } else {
                            $evitable43 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable43,'OR1',$precisions43,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- OR2 -->
                    <div class="md-auto">
                        <input type="checkbox" id="OR2" name="OR2" >
                        <label for="PA6">Y a-t-il une limitation trop restrictive de la prise de décision des acteurs du terrain ?</label>
                        <input type="text" id="plus" name="plus44" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable44" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable44" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['OR2'])){
                        if (isset($_POST['plus44'])){
                            $precisions44 = $_POST['plus44'];
                        } else {
                            $precisions44 = "";
                        }
                        if (isset($_POST['evitable44'])){
                            $evitable44 = $_POST['evitable44'];
                        } else {
                            $evitable44 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable44,'OR2',$precisions44,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- OR3 -->
                    <div class="md-auto">
                        <input type="checkbox" id="OR3" name="OR3" >
                        <label for="PA6">Les responsabilités et les tâches étaient-elles non ou mal définies ?</label>
                        <input type="text" id="plus" name="plus45" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable45" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable45" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['OR3'])){
                        if (isset($_POST['plus45'])){
                            $precisions45 = $_POST['plus45'];
                        } else {
                            $precisions45 = "";
                        }
                        if (isset($_POST['evitable45'])){
                            $evitable45 = $_POST['evitable45'];
                        } else {
                            $evitable45 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable45,'OR3',$precisions45,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- OR4 -->
                    <div class="md-auto">
                        <input type="checkbox" id="OR4" name="OR4" >
                        <label for="PA6">Y a-t-il eu un défaut de coordination dans le servie ?</label>
                        <input type="text" id="plus" name="plus46" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable46" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable46" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['OR4'])){
                        if (isset($_POST['plus46'])){
                            $precisions46 = $_POST['plus46'];
                        } else {
                            $precisions46 = "";
                        }
                        if (isset($_POST['evitable46'])){
                            $evitable46 = $_POST['evitable46'];
                        } else {
                            $evitable46 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable46,'OR4',$precisions46,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- OR5 -->
                    <div class="md-auto">
                        <input type="checkbox" id="OR5" name="OR5" >
                        <label for="PA6">Y a-t-il eu un défaut de coordination entre les services, les structurs ?</label>
                        <input type="text" id="plus" name="plus47" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable47" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable47" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['OR5'])){
                        if (isset($_POST['plus47'])){
                            $precisions47 = $_POST['plus47'];
                        } else {
                            $precisions47 = "";
                        }
                        if (isset($_POST['evitable47'])){
                            $evitable47 = $_POST['evitable47'];
                        } else {
                            $evitable47 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable47,'OR5',$precisions47,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- OR6 -->
                    <div class="md-auto">
                        <input type="checkbox" id="OR6" name="OR6" >
                        <label for="PA6">Y a-t-il eu un défaut d'adaptation à une situation imprévue ?</label>
                        <input type="text" id="plus" name="plus48" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable48" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable48" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['OR6'])){
                        if (isset($_POST['plus48'])){
                            $precisions48 = $_POST['plus48'];
                        } else {
                            $precisions48 = "";
                        }
                        if (isset($_POST['evitable48'])){
                            $evitable48 = $_POST['evitable48'];
                        } else {
                            $evitable48 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable48,'OR6',$precisions48,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- OR7 -->
                    <div class="md-auto">
                        <input type="checkbox" id="OR7" name="OR7" >
                        <label for="PA6">La gestion des ressources humaines était-elle inadéquate ?</label>
                        <input type="text" id="plus" name="plus49" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable49" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable49" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['OR7'])){
                        if (isset($_POST['plus49'])){
                            $precisions49 = $_POST['plus49'];
                        } else {
                            $precisions49 = "";
                        }
                        if (isset($_POST['evitable49'])){
                            $evitable49 = $_POST['evitable49'];
                        } else {
                            $evitable49 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable49,'OR7',$precisions49,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- OR8 -->
                    <div class="md-auto">
                        <input type="checkbox" id="OR8" name="OR8" >
                        <label for="PA6">La procédure de sortie était-elle inadéquate ?</label>
                        <input type="text" id="plus" name="plus50" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable50" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable50" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['OR8'])){
                        if (isset($_POST['plus50'])){
                            $precisions50 = $_POST['plus50'];
                        } else {
                            $precisions50 = "";
                        }
                        if (isset($_POST['evitable50'])){
                            $evitable50 = $_POST['evitable50'];
                        } else {
                            $evitable50 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable50,'OR8',$precisions50,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- OR9 -->
                    <div class="md-auto">
                        <input type="checkbox" id="OR9" name="OR9" >
                        <label for="PA6">Autre</label>
                        <input type="text" id="plus" name="plus51" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable51" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable51" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['OR9'])){
                        if (isset($_POST['plus51'])){
                            $precisions51 = $_POST['plus51'];
                        } else {
                            $precisions51 = "";
                        }
                        if (isset($_POST['evitable51'])){
                            $evitable51 = $_POST['evitable51'];
                        } else {
                            $evitable51 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable51,'OR9',$precisions51,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <div class="md-auto">
                        <label for="facteur7"><strong>L'erreur est-elle liée à des facteurs concernant le contexte institutionnel ?</strong></label>
                    </div>
                    <!-- IT1 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IT1" name="IT1" >
                        <label for="PA6">Les contraintes financières au niveau de l'établissement sont-elles à l'origine de l'événement ?</label>
                        <input type="text" id="plus" name="plus52" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable52" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable52" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['IT1'])){
                        if (isset($_POST['plus52'])){
                            $precisions52 = $_POST['plus52'];
                        } else {
                            $precisions52 = "";
                        }
                        if (isset($_POST['evitable52'])){
                            $evitable52 = $_POST['evitable52'];
                        } else {
                            $evitable52 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable52,'IT1',$precisions52,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- IT2 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IT2" name="IT2" >
                        <label for="PA6">Les ressources sanitaires sont-elles insuffisantes, inadaptées ou défectueuses ?</label>
                        <input type="text" id="plus" name="plus53" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable53" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable53" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['IT2'])){
                        if (isset($_POST['plus53'])){
                            $precisions53 = $_POST['plus53'];
                        } else {
                            $precisions53 = "";
                        }
                        if (isset($_POST['evitable53'])){
                            $evitable53 = $_POST['evitable53'];
                        } else {
                            $evitable53 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable53,'IT2',$precisions53,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- IT3 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IT3" name="IT3" >
                        <label for="PA6">Les échanges ou relations avec d'autres structures de soins sont-ils faibles ou difficiles ?</label>
                        <input type="text" id="plus" name="plus54" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable54" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable54" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['IT3'])){
                        if (isset($_POST['plus54'])){
                            $precisions54 = $_POST['plus54'];
                        } else {
                            $precisions54 = "";
                        }
                        if (isset($_POST['evitable54'])){
                            $evitable54 = $_POST['evitable54'];
                        } else {
                            $evitable54 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable54,'IT3',$precisions54,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- IT4 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IT4" name="IT4" >
                        <label for="PA6">Peut-on relever une absence de stratégie, politique/une absence de priorité/ou des stratégies contradictoires ou inadaptées ?</label>
                        <input type="text" id="plus" name="plus55" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable55" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable55" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['IT4'])){
                        if (isset($_POST['plus55'])){
                            $precisions55 = $_POST['plus55'];
                        } else {
                            $precisions55 = "";
                        }
                        if (isset($_POST['evitable55'])){
                            $evitable55 = $_POST['evitable55'];
                        } else {
                            $evitable55 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable55,'IT4',$precisions55,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- IT5 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IT5" name="IT5" >
                        <label for="PA6">La sécurité et gestion des risques ne sont-elles pas perçues comme des objectifs importants ?</label>
                        <input type="text" id="plus" name="plus56" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable56" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable56" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['IT5'])){
                        if (isset($_POST['plus56'])){
                            $precisions56 = $_POST['plus56'];
                        } else {
                            $precisions56 = "";
                        }
                        if (isset($_POST['evitable56'])){
                            $evitable56 = $_POST['evitable56'];
                        } else {
                            $evitable56 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable56,'IT5',$precisions56,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- IT6 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IT6" name="IT6" >
                        <label for="PA6">La culture du signalement des EI et de propositions de corrections est-elle inexistante ou défectueuse ?</label>
                        <input type="text" id="plus" name="plus57" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable57" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable57" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['IT6'])){
                        if (isset($_POST['plus57'])){
                            $precisions57 = $_POST['plus57'];
                        } else {
                            $precisions57 = "";
                        }
                        if (isset($_POST['evitable57'])){
                            $evitable57 = $_POST['evitable57'];
                        } else {
                            $evitable57 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable57,'IT6',$precisions57,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- IT7 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IT7" name="IT7" >
                        <label for="PA6">Le contexte social était-il difficile ?</label>
                        <input type="text" id="plus" name="plus58" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable58" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable58" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['IT7'])){
                        if (isset($_POST['plus58'])){
                            $precisions58 = $_POST['plus58'];
                        } else {
                            $precisions58 = "";
                        }
                        if (isset($_POST['evitable58'])){
                            $evitable58 = $_POST['evitable58'];
                        } else {
                            $evitable58 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable58,'IT7',$precisions58,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
                    <!-- IT8 -->
                    <div class="md-auto">
                        <input type="checkbox" id="IT8" name="IT8" >
                        <label for="PA6">Autre</label>
                        <input type="text" id="plus" name="plus59" size=50>
                        <label for="evitable">Cela était-il évitable ?</label>
                        <input type="radio" id="evitable" name="evitable59" value="Oui" >
                        <label for="Oui">Oui</label>
                        <input type="radio" id="evitable" name="evitable59" value="Non" >
                        <label for="Non">Non</label> 
                    </div>
                    <?php 
                    if (isset($_POST['IT8'])){
                        if (isset($_POST['plus59'])){
                            $precisions59 = $_POST['plus59'];
                        } else {
                            $precisions59 = "";
                        }
                        if (isset($_POST['evitable59'])){
                            $evitable59 = $_POST['evitable59'];
                        } else {
                            $evitable59 = "";
                        }
                        $insertFacteur="INSERT INTO facteur(previsible,libelle,precisions_facteur,evenement) VALUES (?,?,?,?)";
                        $values=array($evitable59,'IT8',$precisions59,$numero);
                        $stmt=sqlsrv_query($conn,$insertFacteur,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    ?>
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
                            <th>Action préventive</th>
                            <th>Action corrective</th>
                            <th>Effet attendu</th>
                            <th>Pilotes</th>
                            <th>Echéance prévue</th>
                            <th>Echéance effective</th>
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