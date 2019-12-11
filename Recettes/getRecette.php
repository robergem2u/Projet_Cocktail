<?php
include("../ConnexionBD/connexion.php");

$sql = "SELECT DISTINCT nomRecette FROM liaison WHERE ";

$listeIng = $_GET['ing'];
$sql .= $listeIng;

$recette = $bdd->prepare($sql);
$recette->execute();
$ingredients = $bdd->prepare("SELECT nomIngredient FROM liaison WHERE nomRecette = :recette");

while ($donnees = $recette->fetch()) {
    echo $donnees['nomRecette']."\n";
    $ingredients->bindParam(":recette", $donnees['nomRecette']);
    $ingredients->execute();
    while($ing = $ingredients->fetch()){
        print_r($ing['nomIngredient']);
        echo "\n";
    }
    echo "_";
}
$recette->closeCursor(); // Termine le traitement de la requête
