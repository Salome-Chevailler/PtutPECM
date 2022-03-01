<!-- Affiche la deuxième page du formulaire d'analyse de l'événement et amène à la page 3 -->
<?php
    include "bdd.php";
?>

<!DOCTYPE html> 
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" href="bootstrap.css" type="text/css" media="screen">
        <title>Analyser un événement (2)</title>
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="col-auto">
                <h1>Analyser un événement</h1>
            </div>
            <div class="col-auto">
                <a href="analyseEM.php"><input type="submit" value="Retour"></a>
            </div>
        </div>
        <div class="container-fluid">
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
                <!-- Never event -->
                <div class="md-auto">
                    <label for="neverevent">Est-ce un never-event (NE) ?</label>
                    <input type="radio" id="neverevent" name="neverevent" value="Oui" required>
                    <label for="Oui">Oui</label>
                    <input type="radio" id="neverevent" name="neverevent" value="Non" required>
                    <label for="Non">Non</label> 
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
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="suivant"><a href="analyseEM3.php"><input type="submit" value="Suivant"></a></div>
        </div>
    </body>
</html>