
<?php

$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "moneytrack_db";

try {

    $connexion = new PDO(
        "mysql:host=$serveur;dbname=$base_de_donnees;charset=utf8mb4",
        $utilisateur,
        $mot_de_passe
    );

    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    

} catch (PDOException $erreur) {

    
}

?>
