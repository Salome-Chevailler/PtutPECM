<!-- Affiche la quatrième page du formulaire d'analyse de l'événement et amène à la page 5 -->
<?php
    include "bdd.php";
?>

<!DOCTYPE html> 
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="bootstrap.min.css" type="text/css" media="screen">
		<link rel="stylesheet" href="bootstrap.css" type="text/css" media="screen">
        <title>Analyser un événement (4)</title>
    </head>
    <body>
        <div class="row justify-content-center">
            <div class="col-auto">
                <h1>Analyser un événement</h1>
            </div>
            <div class="col-auto">
                <a href="analyseEM3.php"><input type="submit" value="Retour"></a>
            </div>
        </div>
        <div class="container-fluid">
            <h5>Quels sont les dysfonctionnements, les erreurs ? </h5>
            <div class="row mb-1">
                <label class="col-6" for="action">Défaillances actives ou immédiates ou défauts de soin</label>  
            </div>
            <!-- Dysfonctionnements -->
            <textarea class="col-4" maxlength="1000" id="dysfonctionnement" name="dysfonctionnement" required></textarea>
            <!-- Facteurs -->
            <div class="causes">
                <div class="section1">
                    <h5>Pourquoi cela est-il arrivé ? (causes latentes systémiques)</h5>
                </div>
                <div class="md-auto">
                    <label for="facteur">L'erreur est-elle liée à des facteurs propres aux patients ?</label>
                    <select class="col-2" name="facteur" size="1"></select>
                </div>
                <div class="md-auto">
                    <label for="facteur2">L'erreur est-elle liée à des facteurs individuels ?</label>
                    <select class="col-2" name="facteur2" size="1"></select>
                </div>
                <div class="md-auto">
                    <label for="facteur3">L'erreur est-elle liée à des facteurs concernant l'équipe ?</label>
                    <select class="col-2" name="facteur3" size="1"></select>
                </div>
                <div class="md-auto">
                    <label for="facteur4">L'erreur est-elle liée à des tâches à accomplir ?</label>
                    <select class="col-2" name="facteur4" size="1"></select>
                </div>
                <div class="md-auto">
                    <label for="facteur5">L'erreur est-elle liée à des facteurs concernant l'environnement ?</label>
                    <select class="col-2" name="facteur5" size="1"></select>
                </div>
                <div class="md-auto">
                    <label for="facteur6">L'erreur est-elle liée à des facteurs concernant l'organisation ?</label>
                    <select class="col-2" name="facteur6" size="1"></select>
                </div>
                <div class="md-auto">
                    <label for="facteur7">L'erreur est-elle liée à des facteurs concernant le contexte institutionnel ?</label>
                    <select class="col-2" name="facteur7" size="1"></select>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="suivant"><a href="analyseEM5.php"><input type="submit" value="Suivant"></a></div>
        </div>
    </body>
</html>