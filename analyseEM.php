<!-- Affiche le formulaire d'analyse de l'événement et ajoute les éléments dans la base lors de la validation --> 
<?php
    include "bdd.php";
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
            <div class="md-auto">
                <label for="anonyme">L'erreur médicamenteuse a été déclarée de manière anonyme : </label>
                <input type="radio" id="anonyme" name="anonyme" value="Oui" required>
                <label for="Oui">Oui</label>
                <input type="radio" id="anonyme" name="anonyme" value="Non" required>
                <label for="Non">Non</label>
            </div>
            <div class="md-auto">
                <label for="anonyme">Si non, elle a été déclarée par : </label>
                <label for="nom">Nom : <?php  ?></label>
                <label for="prenom">Prénom : <?php  ?></label>
                <label for="fonction">Fonction : <?php  ?></label>
            </div> 
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
            <div class="description">
                <div class="section1">
                    <h4>ETAPE 1 : Quel est le problème ? (Description de l'événement)</h4>
                </div>
                <!-- Que s'est-il passé ? -->
                <div class="row mb-1">
                    <label class="col-md-auto" for="quoi">Quoi ? Que s'est-il passé ?</label>
                    <textarea class="col-4" maxlength="1000" id="quoi" name="quoi" required></textarea>
                </div>
                <!-- Quelles sont les conséquences ? -->
                <div class="row mb-1">
                    <label class="col-md-auto" for="consequences">Quel impact cela a-t-il eu ?</label>
                    <textarea class="col-4" maxlength="1000" id="consequences" name="consequences" required></textarea>
                </div>
                <!-- En quoi est-ce un problème ?-->
                <div class="row mb-1">
                    <label class="col-md-auto" for="quoi">En quoi est-ce un problème ?</label>
                    <textarea class="col-4" maxlength="1000" id="probleme" name="probleme" required></textarea>
                </div>
                <div class="row mb-1">
                    <!-- Date de l'événement -->
                    <div class="col-3 md-auto">
                        <label for="date3">Quand ?</label>
                        <input type="date" id="date3" name="date3" required>
                    </div>
                    <!-- Service -->
                    <div class="col-3 md-auto">
                        <label for="service">Service :</label>
                        <select class="col-7" name="service" size="1">
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
            </div>
            <h5>Qu'a-t-il été fait dans un premier temps ? </h5>
            <div class="row mb-1">
                <label class="col-6" for="action">Décrire ici les premières actions mises en place à la découverte de l'événement</label>  
            </div>
            <!-- Premières actions -->
            <textarea class="col-4" maxlength="1000" id="action" name="action" required></textarea>
            <div class="caracterisation">
                <div class="section">
                    <h5>Caractériser l'erreur médicamenteuse (EM)</h5>
                </div>
                <!-- Médicament à risque -->
                <div class="md-auto">
                    <label for="medicament">Est-ce un médicament à risque ?</label>
                    <input type="radio" id="medicament" name="medicament" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="medicament" name="medicament" value="Non" required>
                    <label for="Non">Non</label> 
                    <input type="radio" id="medicament" name="medicament" value="Je ne sais pas" required>
                    <label for="Je ne sais pas">Je ne sais pas</label> 
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
                <div class="md-auto">
                    <label for="medicament">Elle concerne :</label>
                </div>
                <!-- Médicament -->
                <div class="md-auto">
                    <input type="radio" id="type" name="type" value="medicament" required>
                    <label for="Un medicament">Un médicament, </label>
                    <label for="Qui est">qui est :</label>
                    <input type="radio" id="refrigere" name="refrigere" value="refrigere" required>
                    <label for="refrigere">Réfrigéré</label>
                    <input type="radio" id="refrigere" name="refrigere" value="nonrefrigere" required>
                    <label for="nonrefrigere">Non réfrigéré</label>
                </div>
                <!-- Stupéfiant -->
                <div class="md-auto">
                    <input type="radio" id="type" name="type" value="stupefiant" required>
                    <label for="Un stupefiant">Un stupéfiant</label> 
                </div>
                <!-- Chimiothérapie -->
                <div class="md-auto">
                    <input type="radio" id="type" name="type" value="chimio" required>
                    <label for="Une chimiotherapie">Une chimiothérapie, </label>
                    <label for="Qui est">qui est :</label> 
                    <input type="radio" id="refrigere2" name="refrigere2" value="refrigere" required>
                    <label for="refrigere">Réfrigérée</label>
                    <input type="radio" id="refrigere2" name="refrigere2" value="nonrefrigere" required>
                    <label for="nonrefrigere">Non réfrigérée</label>
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
                <!-- Voie d'administration à risque -->
                <div class="md-auto">
                    <label for="patient">S'agit-il d'une voie d'administration à risque ?</label>
                    <input type="radio" id="admin" name="admin" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="admin" name="admin" value="Non" required>
                    <label for="Non">Non</label> 
                    <input type="radio" id="admin" name="admin" value="Je ne sais pas" required>
                    <label for="Je ne sais pas">Je ne sais pas</label> 
                </div>
                <!-- Précisions -->
                <div class="md-auto">
                        <label for="precisions">Précisions sur la voie d'administration :</label>
                        <input type="text" id="precisions" name="precisions">
                    </div>
                <!-- Never event -->
                <div class="md-auto">
                    <label for="neverevent">Est-ce un never-event (NE) ?</label>
                    <input type="radio" id="neverevent" name="neverevent" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="neverevent" name="neverevent" value="Non" required>
                    <label for="Non">Non</label>
                    <input type="radio" id="neverevent" name="neverevent" value="Je ne sais pas" required>
                    <label for="Je ne sais pas">Je ne sais pas</label>  
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

            </div>
            <!-- Cotation -->
            <div class="cotation">
                <div class="section2">
                    <h5>Cotation de l'événement</h5>
                </div>
                <div class="md-auto">
                    <label for="gravite">Gravité :</label>
                    <select name="gravite" size="1">
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
                    <select name="occurrence" size="1">
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
                    <select name="maitrise" size="1">
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
                    <select name="criticite" size="1">
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
            <textarea class="col-4" maxlength="1000" id="dysfonctionnement" name="dysfonctionnement" required></textarea>
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
                    <input type="checkbox" id="PA1" name="PA1" required>
                    <label for="PA1">L'état de santé du patient est-il grave, complexe ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- PA2 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA2" name="PA2" required>
                    <label for="PA2">L'EI est-il survenu dans un contexte de prise en charge en urgence ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- PA3 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA3" name="PA3" required>
                    <label for="PA3">L'expression du patient ou la communication étaient-elles difficiles ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- PA4 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA4" name="PA4" required>
                    <label for="PA4">La personnalité du patient est-elle particulière et peut-elle expliquer en partie le dysfonctionnement ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- PA5 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA5" name="PA5" required>
                    <label for="PA5">Existe-t-il des facteurs sociaux particuliers susceptibles d'expliquer tout ou partie des dysfonctionnements ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- PA6 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Autre</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <div class="md-auto">
                    <label for="facteur2"><strong>L'erreur est-elle liée à des facteurs individuels ?</strong></label>
                </div>
                <!-- IN1 -->
                <div class="md-auto">
                    <input type="checkbox" id="IN1" name="IN1" required>
                    <label for="IN1">Y a-t-il un défaut de qualification des personnes chargées du soin / de l'acte ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- IN2 -->
                <div class="md-auto">
                    <input type="checkbox" id="IN2" name="IN2" required>
                    <label for="IN2">Y a-t-il un défaut de connaissances théoriques ou techniques des professionnels ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- IN3 -->
                <div class="md-auto">
                    <input type="checkbox" id="IN3" name="IN3" required>
                    <label for="IN3">Y a-t-il un défaut d'aptitude, de compétence des professionnels chargés du soin / de l'acte ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- IN4 -->
                <div class="md-auto">
                    <input type="checkbox" id="IN4" name="IN4" required>
                    <label for="IN4">Les professionnels chargés des soins étaient-ils en mauvaise disposition physique et mentale ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- IN5 -->
                <div class="md-auto">
                    <input type="checkbox" id="IN5" name="IN5" required>
                    <label for="IN5">Y a-t-il eu une insuffisance d'échange d'information entre les professionnels de santé et le patient ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- IN6 -->
                <div class="md-auto">
                    <input type="checkbox" id="IN6" name="IN6" required>
                    <label for="IN6">Y a-t-il eu une insuffisance d'échange d'information entre les professionnels de santé et la famille du patient ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- IN7 -->
                <div class="md-auto">
                    <input type="checkbox" id="IN7" name="IN7" required>
                    <label for="IN7">A-t-on relevé un défaut de qualité de la relation avec le patient et sa famille ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                 <!-- IN8 -->
                 <div class="md-auto">
                    <input type="checkbox" id="IN8" name="IN8" required>
                    <label for="IN8">Autre</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <div class="md-auto">
                    <label for="facteur3"><strong>L'erreur est-elle liée à des facteurs concernant l'équipe ?</strong></label>
                </div>
                 <!-- EQ1 -->
                 <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">La composition de l'équipe chargée du soin était-elle mauvaise ou inadaptée ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                 <!-- EQ2 -->
                 <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">A-t-on relevé un défaut de communication interne orale et/ou écrite au sein de l'équipe ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                 <!-- EQ3 -->
                 <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">A-t-on relevé une collaboration insuffisante entre professionnels ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                 <!-- EQ4 -->
                 <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Existe-t-il des conflits ou une mauvaise ambiance au sein de l'équipe / un défaut de cohésion ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                 <!-- EQ5 -->
                 <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">La supervision des responsables et des autres personnels a-t-elle été inadéquate ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                 <!-- EQ6 -->
                 <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Y a-t-il un manque ou un défaut de recherche d'aide, d'avis, de collaboration ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                 <!-- EQ7 -->
                 <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Autre</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <div class="md-auto">
                    <label for="facteur4"><strong>L'erreur est-elle liée à des tâches à accomplir ?</strong></label>
                </div>
                 <!-- TA1 -->
                 <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Le(s) protocole(s) ou procédure(s) étaient-ils absents ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                 <!-- TA2 -->
                 <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Le(s) protocole(s), procédure(s) étaient-ils inadaptés ou peu compréhensibles ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                 <!-- TA3 -->
                 <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Le(s) protocole(s), procédure(s) étaient-ils indisponibles au moment de survenue de l'événement ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                 <!-- TA4 -->
                 <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Le(s) protocole(s), procédure(s) étaient-ils inutilisables ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                 <!-- TA5 -->
                 <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Le(s) protocole(s), procédure(s) étaient-ils insuffisamment diffusés et/ou connus ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                 <!-- TA6 -->
                 <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Y a-t-il un retard dans la prestation ou la programmation des examens cliniques et paracliniques ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                 <!-- TA7 -->
                 <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Y a-t-il eu défaut d'accessibilité, de disponibilité de l'information en temps voulu ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                 <!-- TA8 -->
                 <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">La recherche d'information auprès d'un autre professionnel a-t-elle été difficile ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                 <!-- TA9 -->
                 <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">La planification des tâches était-elle inadaptée ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                 <!-- TA10 -->
                 <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Les soins/actes ne relevaient-ils pas du champ de compétence, d'activité du service ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                 <!-- TA11 -->
                 <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Le(s) protocole(s), procédure(s) n'ont-ils pas été respectés ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- TA12 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Autre</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <div class="md-auto">
                    <label for="facteur5"><strong>L'erreur est-elle liée à des facteurs concernant l'environnement ?</strong></label>
                </div>
                <!-- CT1 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Les locaux ou le matériel utilisé étaient-ils inadaptés ou indisponibles ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- CT2 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Les fournitures ou équipements étaient-ils défectueux, mal entretenus ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- CT3 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Les fournitures ou équipements étaient-ils inexistants ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- CT4 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Les fournitures ou équipements ont-ils été mal utilisés ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- CT5 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Les supports d'information, les notices d'utilisation étaient-ils indisponibles ou inadaptés ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- CT6 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">La formation ou entraînement des professionnels étaient-ils inexistants, inadaptés, non réalisés ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- CT7 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Les conditions de travail étaient-elles inadaptées ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- CT8 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">La charge de travail était-elle importante au moment de l'événement ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- CT9 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Autre</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <div class="md-auto">
                    <label for="facteur6"><strong>L'erreur est-elle liée à des facteurs concernant l'organisation ?</strong></label>
                </div>
                <!-- OR1 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Y a-t-il eu un changement récent d'organisation interne ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- OR2 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Y a-t-il une limitation trop restrictive de la prise de décision des acteurs du terrain ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- OR3 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Les responsabilités et les tâches étaient-elles non ou mal définies ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- OR4 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Y a-t-il eu un défaut de coordination dans le servie ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- OR5 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Y a-t-il eu un défaut de coordination entre les services, les structurs ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- OR6 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Y a-t-il eu un défaut d'adaptation à une situation imprévue ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- OR7 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">La gestion des ressources humaines était-elle inadéquate ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- OR8 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">La procédure de sortie était-elle inadéquate ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- OR9 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Autre</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>


                <div class="md-auto">
                    <label for="facteur7"><strong>L'erreur est-elle liée à des facteurs concernant le contexte institutionnel ?</strong></label>
                </div>
                <!-- IT1 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Les contraintes financières au niveau de l'établissement sont-elles à l'origine de l'événement ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- IT2 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Les ressources sanitaires sont-elles insuffisantes, inadaptées ou défectueuses ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- IT3 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Les échanges ou relations avec d'autres structures de soins sont-ils faibles ou difficiles ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- IT4 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Peut-on relever une absence de stratégie, politique/une absence de priorité/ou des stratégies contradictoires ou inadaptées ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- IT5 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">La sécurité et gestion des risques ne sont-elles pas perçues comme des objectifs importants ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- IT6 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">La culture du signalement des EI et de propositions de corrections est-elle inexistante ou défectueuse ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- IT7 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Le contexte social était-il difficile ?</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
                <!-- IT8 -->
                <div class="md-auto">
                    <input type="checkbox" id="PA6" name="PA6" required>
                    <label for="PA6">Autre</label>
                    <input type="text" id="plus" name="plus" size=50>
                    <label for="evitable">Cela était-il évitable ?</label>
                    <input type="radio" id="evitable" name="evitable" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="evitable" name="evitable" value="Non" required>
                    <label for="Non">Non</label> 
                </div>
            </div>
            <h4>ETAPE 4 : Qu'est-ce qui aurait pu empêcher la survenue de l'événement ? </h4>
            <!-- Est-ce que tout avait été mis en oeuvre pour éviter ce type d'EI ? -->
            <div class="md-auto">
                    <label for="prevention">Est-ce que tout avait été mis en oeuvre pour éviter ce type d'EI ?</label>
                    <input type="radio" id="prevention" name="prevention" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="prevention" name="prevention" value="Non" required>
                    <label for="Non">Non</label> 
            </div>
            <!-- Défenses -->
            <div class="row mb-1">
                <label class="col-6" for="action">Si non, quelles ont été les défenses manquantes ou non opérationnelles ?</label>  
            </div>
            <textarea class="col-4" maxlength="1000" id="defenses" name="defenses" required></textarea>
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
                <input class="btn btn-outline-primary" type="submit" value="Ajouter une action">
            </div>
            <!-- Bouton de validation -->
            <div class="row justify-content-center">
                <div class="valider"><a href="listeEM.php"><input class="btn btn-outline-primary" type="submit" value="Valider"></a></div>
            </div>
        </div>
    </body>
</html>