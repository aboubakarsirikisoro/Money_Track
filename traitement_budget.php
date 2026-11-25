
<?php

require_once "connexion.php";

// Recuperer les informations du formulaire
$montant_budget = $_POST['montant_budget'] ?? '';
$mois = $_POST['mois'] ?? '';
$annee = $_POST['annee'] ?? '';

// Verifier le montant
if (!is_numeric($montant_budget) || $montant_budget <= 0) {
    exit("Erreur : montant du budget invalide.");
}

// Verifier le mois
if (!filter_var($mois, FILTER_VALIDATE_INT) || $mois < 1 || $mois > 12) {
    exit("Erreur : mois invalide.");
}

// Verifier l'annee
if (!filter_var($annee, FILTER_VALIDATE_INT) || $annee < 2026) {
    exit("Erreur : annee invalide.");
}

// Chercher si un budget existe deja
$verification = $connexion->prepare(
    "SELECT id_budget FROM budgets WHERE mois = ? AND annee = ?"
);

$verification->execute([$mois, $annee]);

$budget_existant = $verification->fetch(PDO::FETCH_ASSOC);

// Si le budget existe, le modifier
if ($budget_existant) {

    $requete = $connexion->prepare(
        "UPDATE budgets SET montant_budget = ? WHERE id_budget = ?"
    );

    $requete->execute([
        $montant_budget,
        $budget_existant['id_budget']
    ]);

} else {

    // Sinon, enregistrer un nouveau budget
    $requete = $connexion->prepare(
        "INSERT INTO budgets (montant_budget, mois, annee)
         VALUES (?, ?, ?)"
    );

    $requete->execute([
        $montant_budget,
        $mois,
        $annee
    ]);

}

// Retourner au tableau de bord
header("Location: dashboard.php");
exit();

?>
