
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Définir mon budget</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Définir mon budget mensuel</h1>

    <form action="traitement_budget.php" method="POST">

        <label>Montant du budget (FCFA)</label>
        <input type="number" name="montant_budget"
               min="1" required>

        <br><br>

        <label>Mois</label>
        <select name="mois" required>
            <option value="">Choisir un mois</option>
            <option value="1">Janvier</option>
            <option value="2">Février</option>
            <option value="3">Mars</option>
            <option value="4">Avril</option>
            <option value="5">Mai</option>
            <option value="6">Juin</option>
            <option value="7">Juillet</option>
            <option value="8">Août</option>
            <option value="9">Septembre</option>
            <option value="10">Octobre</option>
            <option value="11">Novembre</option>
            <option value="12">Décembre</option>
        </select>

        <br><br>

        <label>Année</label>
        <input type="number" name="annee"
               min="2026" value="2026" required>

        <br><br>

        <button type="submit">Enregistrer mon budget</button>

    </form>

    <br>

    <a href="dashboard.php">Retour au tableau de bord</a>

</body>
</html>
