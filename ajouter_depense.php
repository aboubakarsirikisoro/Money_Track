
<?php

require_once "connexion.php";

$requete = $connexion->query("SELECT * FROM categories");

$categories = $requete->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une dépense - MoneyTrack</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Ajouter une dépense</h1>

    <form action="traitement_depense.php" method="POST">

        <label>Montant (FCFA)</label>
        <input type="number" name="montant" min="1" required>

        <br><br>

        <label>Description</label>
        <textarea name="description"></textarea>

        <br><br>

        <label>Catégorie</label>

        <select name="id_categorie" required>

            <option value="">Choisir une catégorie</option>

            <?php foreach ($categories as $categorie) { ?>

                <option value="<?php echo $categorie['id_categorie']; ?>">
                    <?php echo htmlspecialchars($categorie['nom']); ?>
                </option>

            <?php } ?>

        </select>

        <br><br>

        <label>Date</label>
        <input type="date" name="date_depense" required>

        <br><br>

        <button type="submit">Enregistrer la dépense</button>

    </form>

    <br>

    <a href="dashboard.php">Retour au tableau de bord</a>

</body>
</html>
