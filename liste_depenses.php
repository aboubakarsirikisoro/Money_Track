

<?php

require_once "connexion.php";

// Recuperer les filtres
$recherche = $_GET['recherche'] ?? '';
$categorie = $_GET['categorie'] ?? '';
$date_debut = $_GET['date_debut'] ?? '';
$date_fin = $_GET['date_fin'] ?? '';

// Recuperer toutes les categories
$requete_categories = $connexion->query(
    "SELECT * FROM categories"
);

$categories = $requete_categories->fetchAll(PDO::FETCH_ASSOC);

// Construire la requete des depenses
$sql = "SELECT depenses.*, categories.nom AS nom_categorie
        FROM depenses
        INNER JOIN categories
        ON depenses.id_categorie = categories.id_categorie
        WHERE depenses.description LIKE ?";

$parametres = ["%$recherche%"];

if ($categorie != '') {

    $sql .= " AND depenses.id_categorie = ?";
    $parametres[] = $categorie;

}


if ($date_debut != '') {

    $sql .= " AND depenses.date_depense >= ?";
    $parametres[] = $date_debut;

}

if ($date_fin != '') {

    $sql .= " AND depenses.date_depense <= ?";
    $parametres[] = $date_fin;

}


$sql .= " ORDER BY depenses.date_depense DESC";

$requete = $connexion->prepare($sql);
$requete->execute($parametres);

$depenses = $requete->fetchAll(PDO::FETCH_ASSOC);



?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des dépenses - MoneyTrack</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Mes dépenses</h1>


    <form method="GET" action="liste_depenses.php">

        <label>Rechercher une dépense :</label>

        <input type="text" name="recherche"
            placeholder="Exemple : Achat de fournitures"
            value="<?php echo htmlspecialchars($recherche); ?>">

        <br><br>

        <label>Filtrer par catégorie :</label>

        <select name="categorie">

            <option value="">Toutes les catégories</option>

            <?php foreach ($categories as $cat) { ?>

                <option value="<?php echo $cat['id_categorie']; ?>"
                    <?php if ($categorie == $cat['id_categorie']) echo 'selected'; ?>>

                    <?php echo htmlspecialchars($cat['nom']); ?>

                </option>

            <?php } ?>

        </select>


        <br><br>

        <label>Date de début :</label>

        <input type="date" name="date_debut"
            value="<?php echo htmlspecialchars($date_debut); ?>">

        <br><br>

        <label>Date de fin :</label>

        <input type="date" name="date_fin"
            value="<?php echo htmlspecialchars($date_fin); ?>">


        <br><br>

        <button type="submit">Rechercher</button>

        <a href="liste_depenses.php">Réinitialiser</a>

    </form>

    <br>


    <th>Actions</th>

    <table border="1" cellpadding="10">

        <tr>
            <th>Montant</th>
            <th>Description</th>
            <th>Catégorie</th>
            <th>Date</th>
        </tr>

        <?php foreach ($depenses as $depense) { ?>

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

                <td>
                    <a href="modifier_depense.php?id=<?php echo $depense['id_depense']; ?>">
                        Modifier
                    </a>

                    |

                    
                <form action="supprimer_depense.php" method="POST"
                    onsubmit="return confirm('Voulez-vous vraiment supprimer cette depense ?');">

                    <input type="hidden" name="id"
                        value="<?php echo $depense['id_depense']; ?>">

                    <button type="submit">Supprimer</button>

                </form>

                </td>
            </tr>

        <?php } ?>

    </table>

</body>
</html>
