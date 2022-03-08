<!-- Affiche le formulaire de déclaration d'un événement et enregistre l'événement dans la base de données après validation -->
<?php
    include "bdd.php";

    // Récupération des données entrées dans le formulaire
    $date_declaration = isset($_POST['date_declaration']) ? $_POST['date_declaration'] : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $depart=isset($_POST['departement']) ? utf8_decode($_POST['departement']) : 'Urgences';
    $queryDepartement = "SELECT id FROM departement WHERE nom='$depart'";
    $stmt = sqlsrv_query($conn, $queryDepartement);
    sqlsrv_fetch($stmt);
    $departement = sqlsrv_get_field($stmt, 0);
    $details = isset($_POST['details']) ? $_POST['details'] : '';
    $consequences = isset($_POST['consequences']) ? $_POST['consequences'] : '';
    $personne_concernee = isset($_POST['personne_concernee']) ? $_POST['personne_concernee'] : '';
    $est_neverevent = isset($_POST['est_neverevent']) ? $_POST['est_neverevent'] : '';
    $patient_risque = isset($_POST['patient_risque']) ? $_POST['patient_risque'] : '';
    $precisions_patient = isset($_POST['precisions_patient']) ? $_POST['precisions_patient'] : '';
    $medicament_risque = isset($_POST['medicament_risque']) ? $_POST['medicament_risque'] : '';
    $precisions_medicament = isset($_POST['precisions_medicament']) ? $_POST['precisions_medicament'] : '';
    $administration_risque = isset($_POST['administration_risque']) ? $_POST['administration_risque'] : '';
    $precisions = isset($_POST['precisions']) ? $_POST['precisions'] : '';
    $degre = isset($_POST['degre_realisation']) ? $_POST['degre_realisation'] : '';
    $etape = isset($_POST['etape_circuit']) ? $_POST['etape_circuit'] : '';

    // Création d'un nouvel événement dans la base à partir des données entrées dans le formulaire
    $insertEvenement="INSERT INTO evenement(date_declaration,date_em,details,est_neverevent,patient_risque,departement,medicament_risque,administration_risque,administration_precisions,consequences,personne_concernee,precisions_patient,precisions_medicament,degre_realisation,etape_circuit,est_analyse) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $values=array($date_declaration,$date,$details,$est_neverevent,$patient_risque,$departement,$medicament_risque,$administration_risque,$precisions,$consequences,$personne_concernee,$precisions_patient,$precisions_medicament,$degre,$etape,0);
    $stmt=sqlsrv_query($conn,$insertEvenement,$values);
    if( $stmt === false ) {
        die( print_r( sqlsrv_errors(), true));
    }

?>


<!DOCTYPE html> 
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="icon" type="image/png" href="iconeCHIC.png">
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" href="bootstrap.css" type="text/css" media="screen">
        <title>Déclarer un événement</title>
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="header">
                <h1>Déclarer un événement</h1>
            </div>
            <div class="col-auto">
                <a href="accueil.php"><input class="btn btn-outline-primary" type="submit" value="Retour"></a>
            </div>
        </div>
        <div class="container-fluid">
            <form method="POST" action="">
                <!-- Date de la déclaration -->
                <div class="md-auto">
                        <label for="date_declaration">Date de la déclaration : </label>
                        <input type="date" id="date_declaration" name="date_declaration" required>
                </div>
                <div class="md-auto">
                    <!-- Date de l'événement -->
                    <div class="md-auto">
                        <label for="date">Date de l'événement : </label>
                        <input type="date" id="date" name="date" required>
                    </div>
                    <!-- Service -->
                    <div class="md-auto">
                        <label for="departement">Service :</label>
                        <select name="departement" size="1">
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
                <!-- Qui est concerné ? -->
                <div class="md-auto">
                    <label for="personne_concernee">Qui est concerné ?</label>
                    <input class="col-3" maxlength="100" id="personne_concernee" name="personne_concernee" required></textarea>
                </div>
                <!-- Never event -->
                <div class="md-auto">
                    <label for="est_neverevent">S'agit-il d'un never-event (NE) ?</label>
                    <input type="radio" id="est_neverevent" name="est_neverevent" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="est_neverevent" name="est_neverevent" value="Non" required>
                    <label for="Non">Non</label> 
                    <input type="radio" id="est_neverevent" name="est_neverevent" value="Je ne sais pas" required>
                    <label for="Jenesaispas">Je ne sais pas</label>       
                </div>
                <!-- Patient à risque -->
                <div class="md-auto">
                    <label for="patient_risque">S'agit-il d'un patient à risque ?</label>
                    <input type="radio" id="patient_risque" name="patient_risque" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="patient_risque" name="patient_risque" value="Non" required>
                    <label for="Non">Non</label> 
                    <input type="radio" id="patient_risque" name="patient_risque" value="Je ne sais pas" required>
                    <label for="Jenesaispas">Je ne sais pas</label>       
                </div>
                <!-- Précisions sur le patient -->
                <div class="md-auto">
                    <label for="precisions_patient">Précisions sur le patient :</label>
                    <input type="text" id="precisions_patient" name="precisions_patient">
                </div>
                <!-- Médicament à risque -->
                <div class="md-auto">
                    <label for="medicament_risque">S'agit-il d'un médicament à risque ?</label>
                    <input type="radio" id="medicament_risque" name="medicament_risque" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="medicament_risque" name="medicament_risque" value="Non" required>
                    <label for="Non">Non</label> 
                    <input type="radio" id="medicament_risque" name="medicament_risque" value="Je ne sais pas" required>
                    <label for="Jenesaispas">Je ne sais pas</label>       
                </div>
                <!-- Précisions sur le médicament -->
                <div class="md-auto">
                        <label for="precisions_medicament">Précisions sur le médicament :</label>
                        <input type="text" id="precisions_medicament" name="precisions_medicament">
                </div>
                <!-- Voie d'administration à risque -->
                <div class="md-auto">
                    <div class="md-auto">
                        <label for="administration_risque">S'agit-il d'une voie d'administration à risque ?</label>
                        <input type="radio" id="administration_risque" name="administration_risque" value="Oui" required>
                        <label for="Oui">Oui</label>
                        <input type="radio" id="administration_risque" name="administration_risque" value="Non" required>
                        <label for="Non">Non</label> 
                        <input type="radio" id="administration_risque" name="administration_risque" value="Je ne sais pas" required>
                        <label for="Jenesaispas">Je ne sais pas</label>   
                    </div>    
                    <!-- Précisions -->
                    <div class="md-auto">
                        <label for="precisions">Précisions sur la voie d'administration :</label>
                        <input type="text" id="precisions" name="precisions">
                    </div>
                </div>
                <!-- Degré de réalisation -->
                <div class="md-auto">
                        <label for="degre">Degré de réalisation :</label>
                        <input type="radio" id="degre_realisation" name="degre_realisation" value="EM avérée et identifiée après atteinte du patient" required>
                        <label for="EM avérée et identifiée après atteinte du patient">EM avérée et identifiée après atteinte du patient</label>
                        <input type="radio" id="degre_realisation" name="degre_realisation" value="EM avérée et interceptée avant atteinte du patient" required>
                        <label for="EM avérée et interceptée avant atteinte du patient">EM avérée et interceptée avant atteinte du patient</label> 
                        <input type="radio" id="degre_realisation" name="degre_realisation" value="EM potentielle" required>
                        <label for="EM potentielle">EM potentielle</label> 
                        <input type="radio" id="degre_realisation" name="degre_realisation" value="Je ne sais pas" required>
                        <label for="Jenesaispas">Je ne sais pas</label>  
                </div>
                <!-- Etape de survenue dans le circuit médicament -->
                <div class="md-auto">
                        <label for="etape">Etape de survenue dans le circuit médicament :</label>
                        <input type="radio" id="etape_circuit" name="etape_circuit" value="Administration" required>
                        <label for="Administration">Administration</label>
                        <input type="radio" id="etape_circuit" name="etape_circuit" value="Dispensation" required>
                        <label for="Dispensation">Dispensation</label> 
                        <input type="radio" id="etape_circuit" name="etape_circuit" value="Information du patient" required>
                        <label for="Information du patient">Information du patient</label> 
                        <input type="radio" id="etape_circuit" name="etape_circuit" value="Prescription" required>
                        <label for="Prescription">Prescription</label>
                        <input type="radio" id="etape_circuit" name="etape_circuit" value="Transport" required>
                        <label for="Transport">Transport</label>  
                        <input type="radio" id="etape_circuit" name="etape_circuit" value="Je ne sais pas" required>
                        <label for="Jenesaispas">Je ne sais pas</label>  
                </div>
                <!-- Description -->
                <div class="row mb-1"> 	
                    <label class="col-md-auto" for="details">Description de l'événement : </label>
                    <textarea class="col-4" maxlength="1000" id="details" name="details" required></textarea>
                </div>
                <!-- Conséquences -->
                <div class="row mb-1"> 	
                    <label class="col-md-auto" for="consequences">Quelles sont les conséquences de l'événement ? </label>
                    <textarea class="col-4" maxlength="1000" id="consequences" name="consequences" required></textarea>
                </div>
               
            
            <!-- Bouton d'ajout -->
            <div class="row justify-content-center">
                <div class="ajouter"><input class="btn btn-outline-primary" type="submit" value="Ajouter l'événement" name="nouvelEvenement"></div>
            </div>   
            </form>
        </div>
    </body>
</html>

