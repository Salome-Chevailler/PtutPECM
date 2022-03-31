<!-- Affiche le formulaire de déclaration d'un événement et enregistre l'événement dans la base de données après validation -->
<?php
    include "bdd.php";

    // On récupère le nombre d'événements dans la base
    $sql = "SELECT count(*) FROM evenement";
    $stmt = sqlsrv_query( $conn, $sql);
    if( $stmt === false ) {
        die( print_r( sqlsrv_errors(), true));
    }
    if( sqlsrv_fetch( $stmt ) === false) {
        die( print_r( sqlsrv_errors(), true));
    }
    $count = sqlsrv_get_field($stmt, 0);

    // On crée le numéro de l'événement en fonction du nombre total d'événements dans la base
    if ($count === 0){
        $numero = 1;
    } else {
        $sql = "SELECT MAX(numero) FROM evenement";
        $stmt = sqlsrv_query( $conn, $sql);
        if( $stmt === false ) {
            die( print_r( sqlsrv_errors(), true));
        }
        if( sqlsrv_fetch( $stmt ) === false) {
            die( print_r( sqlsrv_errors(), true));
        }
        $max = sqlsrv_get_field($stmt, 0);
        $numero = $max + 1;
    }

    if(isset($_POST['nouvelEvenement'])){
        // Récupération des données entrées dans le formulaire
        $date_declaration = $_POST['date_declaration'];
        $date = $_POST['date'];
        $depart=utf8_decode($_POST['departement']);
        $queryDepartement = "SELECT id FROM departement WHERE nom='$depart'";
        $stmt = sqlsrv_query($conn, $queryDepartement);
        sqlsrv_fetch($stmt);
        $departement = sqlsrv_get_field($stmt, 0);
        $details = $_POST['details'];
        $consequences = $_POST['consequences'];
        $est_neverevent = $_POST['est_neverevent'];
        $patient_risque = $_POST['patient_risque'];
        $precisions_patient = $_POST['precisions_patient'];
        $medicament_risque = $_POST['medicament_risque'];
        $precisions_medicament = $_POST['precisions_medicament'];
        $administration_risque = $_POST['administration_risque'];
        $precisions = $_POST['precisions'];
        $degre = $_POST['degre_realisation'];
        if ($_POST['etape_circuit']==="Autre"){
            $etape = $_POST['autre2'];
        } else {
            $etape = $_POST['etape_circuit'];
        }
        $anonyme = $_POST['anonyme'];
        if ($anonyme==='Oui'){
            $anonyme=1;
        }else {
            $anonyme=0;
        }
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $fonction = $_POST['fonction'];
        if (isset($_POST['medicament_classe'])){
            $medicament_classe = $_POST['medicament_classe'];
        } else {
            $medicament_classe = "";
        }
        if (isset($_POST['categorie_patient'])){
            $categorie_patient = $_POST['categorie_patient'];
        } else {
            $categorie_patient = "";
        }
        if (isset($_POST['categorie_administration'])){
            $categorie_administration = $_POST['categorie_administration'];
        } else {
            $categorie_administration = "";
        }
        

        // Création d'un nouvel événement dans la base à partir des données entrées dans le formulaire
        $insertEvenement="INSERT INTO evenement(date_declaration,date_em,details,est_neverevent,patient_risque,departement,medicament_risque,administration_risque,administration_precisions,consequences,precisions_patient,precisions_medicament,degre_realisation,etape_circuit,est_analyse,anonyme,nom,prenom,fonction,medicament_classe,numero,categorie_patient,categorie_administration) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
        $values=array($date_declaration,$date,$details,$est_neverevent,$patient_risque,$departement,$medicament_risque,$administration_risque,$precisions,$consequences,$precisions_patient,$precisions_medicament,$degre,$etape,0,$anonyme,$nom,$prenom,$fonction,$medicament_classe,$numero,$categorie_patient,$categorie_administration);
        $stmt=sqlsrv_query($conn,$insertEvenement,$values);
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
                    <input type="text" id="nom" name="nom" autocomplete="off">
                    <label for="prenom">Prénom :</label>
                    <input type="text" id="prenom" name="prenom" autocomplete="off">
                    <label for="fonction">Fonction :</label>
                    <input type="text" id="fonction" name="fonction" autocomplete="off">
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
                    <a href="neverevents.pdf" target="_blank">Cliquez pour afficher la liste des 12 never-events</a>    
                </div>
                <!-- Types de never event-->
                <div class="md-auto">
                    <label for="neverevent2">Si oui, précisez le(s)quel(s) :</label>
                    <input type="checkbox" id="1" name="1">
                    <label for="1">NE1</label>
                    <input type="checkbox" id="2" name="2">
                    <label for="2">NE2</label>
                    <input type="checkbox" id="3" name="3">
                    <label for="3">NE3</label>
                    <input type="checkbox" id="4" name="4">
                    <label for="4">NE4</label>
                    <input type="checkbox" id="5" name="5">
                    <label for="5">NE5</label>
                    <input type="checkbox" id="6" name="6">
                    <label for="6">NE6</label>
                    <input type="checkbox" id="7" name="7">
                    <label for="7">NE7</label>
                    <input type="checkbox" id="8" name="8">
                    <label for="8">NE8</label>
                    <input type="checkbox" id="9" name="9">
                    <label for="9">NE9</label>
                    <input type="checkbox" id="10" name="10">
                    <label for="10">NE10</label>
                    <input type="checkbox" id="11" name="11">
                    <label for="11">NE11</label>
                    <input type="checkbox" id="12" name="12">
                    <label for="12">NE12</label>

                    <?php 
                    if (isset($_POST['1'])){
                       $insertRef="INSERT INTO refevenement(num_evenement,num_neverevent) VALUES (?,?)";
                        $values=array($numero,1);
                        $stmt=sqlsrv_query($conn,$insertRef,$values);
                        if( $stmt === false ) {
                            die( print_r( sqlsrv_errors(), true));
                        }
                    }
                    if (isset($_POST['2'])){
                        $insertRef="INSERT INTO refevenement(num_evenement,num_neverevent) VALUES (?,?)";
                         $values=array($numero,2);
                         $stmt=sqlsrv_query($conn,$insertRef,$values);
                         if( $stmt === false ) {
                             die( print_r( sqlsrv_errors(), true));
                         }
                     }
                     if (isset($_POST['3'])){
                        $insertRef="INSERT INTO refevenement(num_evenement,num_neverevent) VALUES (?,?)";
                         $values=array($numero,3);
                         $stmt=sqlsrv_query($conn,$insertRef,$values);
                         if( $stmt === false ) {
                             die( print_r( sqlsrv_errors(), true));
                         }
                     }
                     if (isset($_POST['4'])){
                        $insertRef="INSERT INTO refevenement(num_evenement,num_neverevent) VALUES (?,?)";
                         $values=array($numero,4);
                         $stmt=sqlsrv_query($conn,$insertRef,$values);
                         if( $stmt === false ) {
                             die( print_r( sqlsrv_errors(), true));
                         }
                     }
                     if (isset($_POST['5'])){
                        $insertRef="INSERT INTO refevenement(num_evenement,num_neverevent) VALUES (?,?)";
                         $values=array($numero,5);
                         $stmt=sqlsrv_query($conn,$insertRef,$values);
                         if( $stmt === false ) {
                             die( print_r( sqlsrv_errors(), true));
                         }
                     }
                     if (isset($_POST['6'])){
                        $insertRef="INSERT INTO refevenement(num_evenement,num_neverevent) VALUES (?,?)";
                         $values=array($numero,6);
                         $stmt=sqlsrv_query($conn,$insertRef,$values);
                         if( $stmt === false ) {
                             die( print_r( sqlsrv_errors(), true));
                         }
                     }
                     if (isset($_POST['7'])){
                        $insertRef="INSERT INTO refevenement(num_evenement,num_neverevent) VALUES (?,?)";
                         $values=array($numero,7);
                         $stmt=sqlsrv_query($conn,$insertRef,$values);
                         if( $stmt === false ) {
                             die( print_r( sqlsrv_errors(), true));
                         }
                     }
                     if (isset($_POST['8'])){
                        $insertRef="INSERT INTO refevenement(num_evenement,num_neverevent) VALUES (?,?)";
                         $values=array($numero,8);
                         $stmt=sqlsrv_query($conn,$insertRef,$values);
                         if( $stmt === false ) {
                             die( print_r( sqlsrv_errors(), true));
                         }
                     }
                     if (isset($_POST['9'])){
                        $insertRef="INSERT INTO refevenement(num_evenement,num_neverevent) VALUES (?,?)";
                         $values=array($numero,9);
                         $stmt=sqlsrv_query($conn,$insertRef,$values);
                         if( $stmt === false ) {
                             die( print_r( sqlsrv_errors(), true));
                         }
                     }
                     if (isset($_POST['10'])){
                        $insertRef="INSERT INTO refevenement(num_evenement,num_neverevent) VALUES (?,?)";
                         $values=array($numero,10);
                         $stmt=sqlsrv_query($conn,$insertRef,$values);
                         if( $stmt === false ) {
                             die( print_r( sqlsrv_errors(), true));
                         }
                     }
                     if (isset($_POST['11'])){
                        $insertRef="INSERT INTO refevenement(num_evenement,num_neverevent) VALUES (?,?)";
                         $values=array($numero,11);
                         $stmt=sqlsrv_query($conn,$insertRef,$values);
                         if( $stmt === false ) {
                             die( print_r( sqlsrv_errors(), true));
                         }
                     }
                     if (isset($_POST['12'])){
                        $insertRef="INSERT INTO refevenement(num_evenement,num_neverevent) VALUES (?,?)";
                         $values=array($numero,12);
                         $stmt=sqlsrv_query($conn,$insertRef,$values);
                         if( $stmt === false ) {
                             die( print_r( sqlsrv_errors(), true));
                         }
                     }

                    ?>
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
                    <a href="patients_risque.pdf" target="_blank">Cliquez pour consulter les patients à risque</a> 
                </div>
                <!-- Catégorie du patient à risque -->
                <div class="md-auto">
                    <label for="categorie_patient">Si oui, précisez la catégorie :</label>
                    <input type="radio" id="categorie_patient" name="categorie_patient" value="1">
                    <label for="1">1</label>
                    <input type="radio" id="categorie_patient" name="categorie_patient" value="2">
                    <label for="2">2</label> 
                    <input type="radio" id="categorie_patient" name="categorie_patient" value="3">
                    <label for="3">3</label>
                    <input type="radio" id="categorie_patient" name="categorie_patient" value="4">
                    <label for="4">4</label>
                </div>
                <!-- Précisions sur le patient -->
                <div class="md-auto">
                    <label for="precisions_patient">Commentaires sur l'état du patient :</label>
                    <input type="text" id="precisions_patient" name="precisions_patient" autocomplete="off">
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
                    <a href="medicaments_risque.pdf" target="_blank">Cliquez pour consulter les médicaments à risque</a>  
                </div>
                <!-- Classe du médicament --> 
                <div class="md-auto">
                    <label for="medicament_classe">Si oui, précisez la catégorie :</label>
                    <input type="radio" id="medicament_classe" name="medicament_classe" value="1">
                    <label for="1">1</label>
                    <input type="radio" id="medicament_classe" name="medicament_classe" value="2">
                    <label for="2">2</label>
                    <input type="radio" id="medicament_classe" name="medicament_classe" value="3" >
                    <label for="3">3</label>
                    <input type="radio" id="medicament_classe" name="medicament_classe" value="4" >
                    <label for="4">4</label>
                    <input type="radio" id="medicament_classe" name="medicament_classe" value="5">
                    <label for="5">5</label>
                    <input type="radio" id="medicament_classe" name="medicament_classe" value="6">
                    <label for="6">6</label>
                    <input type="radio" id="medicament_classe" name="medicament_classe" value="7">
                    <label for="7">7</label>
                </div>
                <!-- Nom du médicament -->
                <div class="md-auto">
                    <label for="precisions_medicament">Nom du médicament :</label>
                    <input type="text" id="precisions_medicament" name="precisions_medicament" autocomplete="off" required>
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
                        <a href="administration_risque.pdf" target="_blank">Cliquez pour consulter les voies d'administration à risque</a>  
                    </div>
                    <!-- Catégorie de la voie d'administration à risque -->
                    <div class="md-auto">
                        <label for="categorie_administration">Si oui, précisez la catégorie :</label>
                        <input type="radio" id="categorie_administration" name="categorie_administration" value="1">
                        <label for="1">1</label>
                        <input type="radio" id="categorie_administration" name="categorie_administration" value="2">
                        <label for="2">2</label> 
                        <input type="radio" id="categorie_administration" name="categorie_administration" value="3">
                        <label for="3">3</label>
                    </div>    
                    <!-- Précisions -->
                    <div class="md-auto">
                        <label for="precisions">Commentaires sur la voie d'administration :</label>
                        <input type="text" id="precisions" name="precisions" autocomplete="off">
                    </div>
                </div>
                <!-- Degré de réalisation -->
                <div class="md-auto">
                        <label for="degre">Degré de réalisation :</label>
                        <input type="radio" id="degre_realisation" name="degre_realisation" value="Erreur médicamenteuse a atteint le patient" required>
                        <label for="Erreur médicamenteuse a atteint le patient">Erreur médicamenteuse a atteint le patient</label>
                        <input type="radio" id="degre_realisation" name="degre_realisation" value="Erreur médicamenteuse a été interceptée" required>
                        <label for="Erreur médicamenteuse a été interceptée">Erreur médicamenteuse a été interceptée</label> 
                        <input type="radio" id="degre_realisation" name="degre_realisation" value="Evénement porteur de risque (EPR)" required>
                        <label for="Evénement porteur de risque (EPR)">Evénement porteur de risque (EPR)</label> 
                        <input type="radio" id="degre_realisation" name="degre_realisation" value="Je ne sais pas" required>
                        <label for="Jenesaispas">Je ne sais pas</label>  
                        <a href="degres.pdf" target="_blank">Cliquez pour avoir des précisions</a> 
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
                        <input type="radio" id="etape_circuit" name="etape_circuit" value="Suivi et réévaluation" required>
                        <label for="Suivi et réévaluation">Suivi et réévaluation</label>
                        <input type="radio" id="etape_circuit" name="etape_circuit" value="Je ne sais pas" required>
                        <label for="Jenesaispas">Je ne sais pas</label>
                        <input type="radio" id="etape_circuit" name="etape_circuit" value="Autre" required>
                        <label for="Autre">Autre</label>  
                        <input type="text" id="etape_circuit" name="autre2" autocomplete="off">   
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

