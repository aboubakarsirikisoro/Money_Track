
<?php

require_once "connexion.php";

// Recuperer les informations du formulaire
$id = $_POST['id'] ?? '';
$montant = $_POST['montant'] ?? '';
$description = $_POST['description'] ?? '';
$id_categorie = $_POST['id_categorie'] ?? '';
$date_depense = $_POST['date_depense'] ?? '';

// Verifier le montant
if (!is_numeric($montant) || $montant <= 0) {
    exit("Erreur : montant invalide.");
}

// Verifier si la depense existe
$verification = $connexion->prepare(
    "SELECT id_depense FROM depenses WHERE id_depense = ?"
);

$verification->execute([$id]);

if (!$verification->fetch()) {
    exit("Erreur : depense introuvable.");
}

// Verifier la date
$date = DateTime::createFromFormat('Y-m-d', $date_depense);

if (!$date || $date->format('Y-m-d') !== $date_depense) {
    exit("Erreur : date invalide.");
}

// Modifier la depense
$requete = $connexion->prepare(
    "UPDATE depenses
     SET montant = ?, description = ?,
         id_categorie = ?, date_depense = ?
     WHERE id_depense = ?"
);

$requete->execute([
    $montant,
    $description,
    $id_categorie,
    $date_depense,
    $id
]);

header("Location: liste_depenses.php");
exit();

?>
