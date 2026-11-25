
<?php

require_once "connexion.php";

// Total de toutes les depenses
$requete = $connexion->query(
    "SELECT SUM(montant) AS total FROM depenses"
);

$total = $requete->fetch(PDO::FETCH_ASSOC)['total'];

// Nombre de depenses
$requete = $connexion->query(
    "SELECT COUNT(*) AS nombre FROM depenses"
);

$nombre = $requete->fetch(PDO::FETCH_ASSOC)['nombre'];

// Depenses d'aujourd'hui
$requete = $connexion->query(
    "SELECT SUM(montant) AS total
     FROM depenses
     WHERE date_depense = CURDATE()"
);

$total_jour = $requete->fetch(PDO::FETCH_ASSOC)['total'];

// Depenses du mois
$requete = $connexion->query(
    "SELECT SUM(montant) AS total
     FROM depenses
     WHERE MONTH(date_depense) = MONTH(CURDATE())
     AND YEAR(date_depense) = YEAR(CURDATE())"
);

$total_mois = $requete->fetch(PDO::FETCH_ASSOC)['total'];


// Recuperer le budget du mois actuel
$requete = $connexion->query(
    "SELECT montant_budget FROM budgets
     WHERE mois = MONTH(CURDATE())
     AND annee = YEAR(CURDATE())"
);

$budget = $requete->fetch(PDO::FETCH_ASSOC);

// Verifier si un budget existe
if ($budget) {

    $montant_budget = $budget['montant_budget'];

} else {

    $montant_budget = 0;

}

// Calculer le montant restant
$reste_budget = $montant_budget - ($total_mois ?? 0);



// Recuperer les 5 dernieres depenses
$requete = $connexion->query(
    "SELECT depenses.*, categories.nom AS nom_categorie
     FROM depenses
     INNER JOIN categories
     ON depenses.id_categorie = categories.id_categorie
     ORDER BY depenses.id_depense DESC
     LIMIT 5"
);

$dernieres_depenses = $requete->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - MoneyTrack</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>MoneyTrack</h1>
    <h2>Tableau de bord</h2>

    <h3>Total des dépenses</h3>
    <p>
        <?php echo number_format($total ?? 0, 0, ',', ' '); ?> FCFA
    </p>

    <h3>Nombre de dépenses</h3>
    <p><?php echo $nombre; ?></p>

    <h3>Dépenses aujourd'hui</h3>
    <p>
        <?php echo number_format($total_jour ?? 0, 0, ',', ' '); ?> FCFA
    </p>

    <h3>Dépenses du mois</h3>


    <hr>

    <h2>Mon budget mensuel</h2>

    <p>
        Budget prévu :
        <?php echo number_format($montant_budget, 0, ',', ' '); ?> FCFA
    </p>

    <p>
        Dépenses du mois :
        <?php echo number_format($total_mois ?? 0, 0, ',', ' '); ?> FCFA
    </p>

    <p>
        Montant restant :
        <?php echo number_format($reste_budget, 0, ',', ' '); ?> FCFA
    </p>

    <a href="ajouter_budget.php">Modifier mon budget</a>


    <p>
        <?php echo number_format($total_mois ?? 0, 0, ',', ' '); ?> FCFA
    </p>

    <hr>

    <h2>Navigation</h2>

    <a href="ajouter_depense.php">Ajouter une dépense</a>

    <br><br>

    <a href="liste_depenses.php">Voir toutes les dépenses</a>


    <hr>

    <h2>Mes dernières dépenses</h2>

    <table border="1" cellpadding="10">

        <tr>
            <th>Montant</th>
            <th>Description</th>
            <th>Catégorie</th>
            <th>Date</th>
        </tr>

        <?php foreach ($dernieres_depenses as $depense) { ?>

            <tr>
                <td>
                    <?php echo htmlspecialchars($depense['montant']); ?> FCFA
                </td>

                <td>
                    <?php echo htmlspecialchars($depense['description'] ?? ''); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($depense['nom_categorie']); ?>
                </td>

                <td>
                    <?php echo htmlspecialchars($depense['date_depense']); ?>
                </td>
            </tr>

        <?php } ?>

</table>


</body>
</html>