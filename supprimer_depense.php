
<?php

require_once "connexion.php";

// Recuperer l'identifiant
$id = $_POST['id'] ?? '';

// Verifier que l'identifiant est valide
if (!filter_var($id, FILTER_VALIDATE_INT) || $id <= 0) {
    exit("Erreur : identifiant invalide.");
}

// Verifier si la depense existe
$verification = $connexion->prepare(
    "SELECT id_depense FROM depenses WHERE id_depense = ?"
);

$verification->execute([$id]);

if (!$verification->fetch()) {
    exit("Erreur : depense introuvable.");
}

// Supprimer la depense
$requete = $connexion->prepare(
    "DELETE FROM depenses WHERE id_depense = ?"
);

$requete->execute([$id]);

header("Location: liste_depenses.php");
exit();

?>
