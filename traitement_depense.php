
<?php

require_once "connexion.php";

// Recuperer les informations du formulaire
$montant = $_POST['montant'] ?? '';
$description = $_POST['description'] ?? '';
$id_categorie = $_POST['id_categorie'] ?? '';
$date_depense = $_POST['date_depense'] ?? '';

// Verifier le montant
if (!is_numeric($montant) || $montant <= 0) {
    exit("Erreur : le montant doit etre superieur a zero.");
}

// Verifier la categorie
$verification = $connexion->prepare(
    "SELECT id_categorie FROM categories WHERE id_categorie = ?"
);

$verification->execute([$id_categorie]);

if (!$verification->fetch()) {
    exit("Erreur : categorie invalide.");
}

// Verifier la date
$date = DateTime::createFromFormat('Y-m-d', $date_depense);

if (!$date || $date->format('Y-m-d') !== $date_depense) {
    exit("Erreur : date invalide.");
}

// Enregistrer la depense
$requete = $connexion->prepare(
    "INSERT INTO depenses
    (montant, description, id_categorie, date_depense)
    VALUES (?, ?, ?, ?)"
);

$requete->execute([
    $montant,
    $description,
    $id_categorie,
    $date_depense
]);

header("Location: liste_depenses.php");
exit();

?>
