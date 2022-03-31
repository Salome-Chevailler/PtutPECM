<!-- Contient les requêtes récupérant les données de l'événement choisi et affiche les données -->
<?php
    include "bdd.php";

    // Récupération du numéro dans l'URL de l'événement choisi 
    $numero = trim($_GET['numero']);
    $analyse = trim($_GET['analyse']);

    // On récupère les infos correspondantes
    $sql = "SELECT date_EM, d.nom as departement, details, administration_risque, administration_precisions, patient_risque, medicament_risque, est_neverevent, date_declaration, d.risque, consequences, precisions_patient, precisions_medicament, degre_realisation, etape_circuit, anonyme, e.nom, prenom, fonction, medicament_classe, justification, prem_actions, medicament_type, est_refrigere, categorie_patient, categorie_administration FROM evenement e JOIN departement d ON e.departement=d.id WHERE e.numero='$numero'";
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
    $justification = sqlsrv_get_field($stmt, 20);
    $prem_actions = sqlsrv_get_field($stmt, 21);
    $medicament_type = sqlsrv_get_field($stmt, 22);
    $est_refrigere = sqlsrv_get_field($stmt, 23);
    if ($est_refrigere === 1){
        $est_refrigere = "Oui";
    } else {
        $est_refrigere = "Non";
    }
    $categorie_patient = sqlsrv_get_field($stmt, 24);
    $categorie_administration = sqlsrv_get_field($stmt, 25);

    // On récupère les dates d'analyse et de CREX
    $sql2 = "SELECT date_analyse, date_crex FROM rapportcrex WHERE evenement=$numero";
    $stmt2 = sqlsrv_query( $conn, $sql2);
    if( $stmt2 === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_fetch( $stmt2 ) === false) {
        die( print_r( sqlsrv_errors(), true));
    }
    $date_analyse = sqlsrv_get_field($stmt2, 0)->format('d/m/Y');
    $date_crex = sqlsrv_get_field($stmt2, 1)->format('d/m/Y');

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

    // On récupère les facteurs
    $sql3 = "SELECT previsible, libelle, precisions_facteur FROM facteur WHERE evenement=$numero";
    $stmt3 = sqlsrv_query( $conn, $sql3);
    if( $stmt3 === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_fetch( $stmt3 ) === false) {
        die( print_r( sqlsrv_errors(), true));
    }
    $previsible = sqlsrv_get_field($stmt2, 0);
    $libelle = sqlsrv_get_field($stmt2, 1);
    $precisions_facteur = sqlsrv_get_field($stmt2, 2);
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
            <!-- Description et impact -->
            <div class="row mb-1">
                <label class="col-6" for="details"><strong>Description : </strong><?php echo $details ?></label>
                <label class="col-6" for="consequences"><strong>Impact : </strong><?php echo $consequences ?></label>
            </div>
            <!-- Justification -->
            <div class="row mb-1">
                <label class="col-6" for="justification"><strong>En quoi est-ce un problème ? </strong><?php echo $justification ?></label>
                <label class="col-6" for="prem_actions"><strong>Premières actions mises en place : </strong><?php echo $prem_actions ?></label>
            </div>
            <div class="md-auto">
                <h4>Caractérisation de l'erreur médicamenteuse</h4>
            </div>
            <!-- Voie d'administration à risque -->
            <div class="row mb-1">
                <label class="col-6" for="administration_risque"><strong>S'agit-il d'une voie d'administration à risque ? </strong><?php echo $administration_risque ?></label>
                <label class="col-6" for="administration_precisions"><strong>Commentaires : </strong><?php echo $administration_precisions ?></label>
            </div>
            <!-- Catégorie de la voie d'administration -->
            <div class="row mb-1">
                <label class="col-6" for="categorie_administration"><strong>Catégorie de la voie d'administration à risque : </strong><?php echo $categorie_administration ?></label>
                <a class="col-6" href="administration_risque.pdf" target="_blank">Cliquez pour consulter les voies d'administration à risque</a> 
            </div>
            <!-- Patient à risque -->
            <div class="row mb-1">
                <label class="col-6" for="patient_risque"><strong>S'agit-il d'un patient à risque ? </strong><?php echo $patient_risque ?></label>
                <label class="col-6" for="precisions_patient"><strong>Commentaires : </strong><?php echo $precisions_patient ?></label>
            </div>
            <!-- Catégorie du patient -->
                <div class="row mb-1">
                <label class="col-6" for="categorie_patient"><strong>Catégorie du patient à risque : </strong><?php echo $categorie_patient ?></label>
                <a class="col-6" href="patients_risque.pdf" target="_blank">Cliquez pour consulter les patients à risque</a> 
            </div>
            <!-- Médicament à risque -->
            <div class="row mb-1">
                <label class="col-6" for="medicament_risque"><strong>S'agit-il d'un médicament à risque ? </strong><?php echo $medicament_risque ?></label>
                <label class="col-6" for="precisions"><strong>Nom du médicament : </strong><?php echo $precisions_medicament ?></label>
            </div>
            <!-- Classe du médicament -->
            <div class="row mb-1">
                <label class="col-6" for="medicament_classe"><strong>Catégorie du médicament à risque : </strong><?php echo $medicament_classe ?></label>
                <a class="col-6" href="medicaments_risque.pdf" target="_blank">Cliquez pour consulter les médicaments à risque</a> 
            </div>
            <!-- Type de médicament -->
            <div class="row mb-1">
                <label class="col-6" for="medicament_type"><strong>Type du médicament : </strong><?php echo $medicament_type ?></label>
                <label class="col-6" for="precisions"><strong>Réfrigéré : </strong><?php echo $est_refrigere ?></label>
            </div>
            <!-- Never-event -->
            <div class="row mb-1">
                <label class="col-6" for="neverevent"><strong>Est-ce un never-event ? </strong><?php echo $est_neverevent ?></label>
                <label class="col-6" for="neverevent"><strong>Le(s)quel(s) : </strong><?php ?></label>
            </div>
            <!-- Degré de réalisation et étape -->
            <div class="row mb-1">
                <label class="col-6" for="degre"><strong>Degré de réalisation : </strong><?php echo $degre_realisation ?></label>
                <label class="col-6" for="etape"><strong>Etape de survenue dans le circuit médicament : </strong><?php echo $etape_circuit ?></label>
            </div>
            <div class="md-auto">
                <h4>Cotation de l'événement</h4>
            </div>
            <!-- Gravité et occurrence -->
            <div class="row mb-1">
                <label class="col-6" for="gravite"><strong>Gravité : </strong><?php echo $gravite ?></label>
                <label class="col-6" for="occurrence"><strong>Occurrence : </strong><?php echo $occurrence ?></label>
            </div>
            <!-- Niveau de maîtrise et criticité -->
            <div class="row mb-1">
                <label class="col-6" for="maitrise"><strong>Niveau de maîtrise : </strong><?php echo $niveau_maitrise ?></label>
                <label class="col-6" for="occurrence"><strong>Criticité : </strong><?php echo $criticite ?></label>
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
        </div>        
    </body>
</html>