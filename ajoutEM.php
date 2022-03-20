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
    $est_neverevent = isset($_POST['est_neverevent']) ? $_POST['est_neverevent'] : '';
    $patient_risque = isset($_POST['patient_risque']) ? $_POST['patient_risque'] : '';
    $precisions_patient = isset($_POST['precisions_patient']) ? $_POST['precisions_patient'] : '';
    $medicament_risque = isset($_POST['medicament_risque']) ? $_POST['medicament_risque'] : '';
    $precisions_medicament = isset($_POST['precisions_medicament']) ? $_POST['precisions_medicament'] : '';
    $administration_risque = isset($_POST['administration_risque']) ? $_POST['administration_risque'] : '';
    $precisions = isset($_POST['precisions']) ? $_POST['precisions'] : '';
    $degre = isset($_POST['degre_realisation']) ? $_POST['degre_realisation'] : '';
    $etape = isset($_POST['etape_circuit']) ? $_POST['etape_circuit'] : '';
    $anonyme = isset($_POST['anonyme']) ? $_POST['anonyme'] : '';
    $nom = isset($_POST['nom']) ? $_POST['nom'] : '';
    $prenom = isset($_POST['prenom']) ? $_POST['prenom'] : '';
    $fonction = isset($_POST['fonction']) ? $_POST['fonction'] : '';
    $medicament_classe = isset($_POST['medicament_classe']) ? $_POST['medicament_classe'] : '';

    // Création d'un nouvel événement dans la base à partir des données entrées dans le formulaire
    $insertEvenement="INSERT INTO evenement(date_declaration,date_em,details,est_neverevent,patient_risque,departement,medicament_risque,administration_risque,administration_precisions,consequences,precisions_patient,precisions_medicament,degre_realisation,etape_circuit,est_analyse,anonyme,nom,prenom,fonction,medicament_classe) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    $values=array($date_declaration,$date,$details,$est_neverevent,$patient_risque,$departement,$medicament_risque,$administration_risque,$precisions,$consequences,$precisions_patient,$precisions_medicament,$degre,$etape,0,$anonyme,$nom,$prenom,$fonction,$medicament_classe);
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
        <title>Déclarer une erreur médicamenteuse</title>
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="header">
                <h1>Déclarer une erreur médicamenteuse</h1>
                <p>Ne sont pas concernés les événements indésirables consécutifs à la prise d'un médicament, ceci relevant de la pharmacovigilance</p>
            </div>
            <div class="col-auto">
                <a href="accueil.php"><input class="btn btn-outline-primary" type="submit" value="Retour"></a>
            </div>
        </div>
        <div class="container-fluid">
            <form method="POST" action="">
                <!-- Identité de la personne qui déclare -->
                <div class="md-auto">
                    <p>Vous pouvez déclarer de manière anonyme ou renseigner votre identité :<p>
                    <label for="anonyme">Déclarer de manière anonyme : </label>
                    <input type="radio" id="anonyme" name="anonyme" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="anonyme" name="anonyme" value="Non" required>
                    <label for="Non">Non</label>
                </div>
                <div class="md-auto">
                    <label for="anonyme">Si non : </label>
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom">
                    <label for="fonction">Fonction :</label>
                    <input type="text" id="fonction" name="fonction">
                </div>
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
                    </div>
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
                <!-- Types de never event-->
                <div class="md-auto">
                    <label for="neverevent2">Si oui, précisez le(s)quel(s) :</label>
                    <input type="checkbox" id="n1" name="n1" required>
                    <label for="n1">NE1</label>
                    <input type="checkbox" id="n2" name="n2" required>
                    <label for="n2">NE2</label>
                    <input type="checkbox" id="n3" name="n3" required>
                    <label for="n3">NE3</label>
                    <input type="checkbox" id="n4" name="n4" required>
                    <label for="n4">NE4</label>
                    <input type="checkbox" id="n5" name="n5" required>
                    <label for="n5">NE5</label>
                    <input type="checkbox" id="n6" name="n6" required>
                    <label for="n6">NE6</label>
                    <input type="checkbox" id="n7" name="n7" required>
                    <label for="n7">NE7</label>
                    <input type="checkbox" id="n8" name="n8" required>
                    <label for="n8">NE8</label>
                    <input type="checkbox" id="n9" name="n9" required>
                    <label for="n9">NE9</label>
                    <input type="checkbox" id="n10" name="n10" required>
                    <label for="n10">NE10</label>
                    <input type="checkbox" id="n11" name="n11" required>
                    <label for="n11">NE11</label>
                    <input type="checkbox" id="n12" name="n12" required>
                    <label for="n12">NE12</label>
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
                <!-- Classe du médicament --> 
                <div class="md-auto">
                    <label for="medicament_classe">Classe du médicament :</label>
                    <select name="medicament_classe" size="1">
                    </select>
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
                        <input type="radio" id="degre_realisation" name="degre_realisation" value="EM a atteint le patient" required>
                        <label for="EM a atteint le patient">EM a atteint le patient</label>
                        <input type="radio" id="degre_realisation" name="degre_realisation" value="EM a été interceptée" required>
                        <label for="EM a été interceptée">EM a été interceptée</label> 
                        <input type="radio" id="degre_realisation" name="degre_realisation" value="Evénement porteur de risque (EPR)" required>
                        <label for="Evénement porteur de risque (EPR)">Evénement porteur de risque (EPR)</label> 
                        <input type="radio" id="degre_realisation" name="degre_realisation" value="Je ne sais pas" required>
                        <label for="Jenesaispas">Je ne sais pas</label>  
                </div>
                <!-- Etape de survenue dans le circuit médicament -->
                <div class="md-auto">
                        <label for="etape">Etape de survenue dans le circuit médicament :</label>
                        <div class="md-auto">
                        <label for="etape">* Si vous ne savez pas, merci d'être plus précis dans la description</label>
                        </div>
                        <input type="radio" id="etape_circuit" name="etape_circuit" value="Prescription" required>
                        <label for="Prescription">Prescription</label>
                        <input type="radio" id="etape_circuit" name="etape_circuit" value="Dispensation" required>
                        <label for="Dispensation">Dispensation</label> 
                        <input type="radio" id="etape_circuit" name="etape_circuit" value="Transport" required>
                        <label for="Transport">Transport</label>  
                        <input type="radio" id="etape_circuit" name="etape_circuit" value="Administration" required>
                        <label for="Administration">Administration</label>
                        <input type="radio" id="etape_circuit" name="etape_circuit" value="Je ne sais pas" required>
                        <label for="Jenesaispas">Je ne sais pas</label>
                        <input type="radio" id="autre" name="autre" value="Autre" required>
                        <label for="Autre">Autre</label>  
                        <input type="text" id="etape_circuit" name="autre">                       
                </div>

                <!-- A VOIR AVEC RAFIKA POUR TROUVER UNE FORMULATION -->
                <!-- Information du patient 
                <div class="md-auto">
                    <input type="radio" id="etape_circuit" name="etape_circuit" value="Information du patient" required>
                    <label for="Information du patient">Information du patient</label> 
                </div> -->

                <!-- Description -->
                <div class="row mb-1"> 	
                    <label class="col-md-auto" for="details">Description de l'événement : </label>
                    <textarea class="col-4" maxlength="1000" id="details" name="details" required></textarea>
                </div>
                <!-- Conséquences -->
                <div class="row mb-1"> 	
                    <label class="col-md-auto" for="consequences">Quel impact cela a-t-il eu ? </label>
                    <textarea class="col-4" maxlength="1000" id="consequences" name="consequences" required></textarea>
                </div>
                <!-- Bouton de validation -->
                <div class="row justify-content-center">
                    <div class="ajouter"><p>Attention, toute validation est définitive</p><input class="btn btn-outline-primary" type="submit" value="Valider la déclaration" name="nouvelEvenement"></div>
                </div>   
            </form>
        </div>
    </body>
</html>

