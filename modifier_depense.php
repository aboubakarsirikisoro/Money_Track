
<?php

require_once "connexion.php";

// Recuperer l'identifiant
$id = $_GET['id'];

// Recuperer la depense concernee
$requete = $connexion->prepare(
    "SELECT * FROM depenses WHERE id_depense = ?"
);

$requete->execute([$id]);

$depense = $requete->fetch(PDO::FETCH_ASSOC);

// Recuperer les categories
$requete_categories = $connexion->query(
    "SELECT * FROM categories"
);

$categories = $requete_categories->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une dépense</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Modifier une dépense</h1>

    <form action="traitement_modification.php" method="POST">

        <input type="hidden" name="id"
               value="<?php echo $depense['id_depense']; ?>">

        <label>Montant (FCFA)</label>
        <input type="number" name="montant"
               value="<?php echo $depense['montant']; ?>" required>

        <br><br>

        <label>Description</label>
        <textarea name="description"><?php echo htmlspecialchars($depense['description'] ?? ''); ?></textarea>

        <br><br>

        <label>Catégorie</label>

        <select name="id_categorie" required>

            <?php foreach ($categories as $categorie) { ?>

                <option value="<?php echo $categorie['id_categorie']; ?>"
                    <?php if ($categorie['id_categorie'] == $depense['id_categorie']) echo 'selected'; ?>>

                    <?php echo htmlspecialchars($categorie['nom']); ?>

                </option>

            <?php } ?>

        </select>

        <br><br>

        <label>Date</label>
        <input type="date" name="date_depense"
               value="<?php echo $depense['date_depense']; ?>" required>

        <br><br>

        <button type="submit">Enregistrer les modifications</button>

    </form>

</body>
</html>
