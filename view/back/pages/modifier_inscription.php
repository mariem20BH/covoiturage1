<?php
require_once 'C:/xampp/htdocs/webproj/controller/InscriptionC.php';
require_once 'C:/xampp/htdocs/webproj/model/Inscription.php';

$inscriptionC = new InscriptionC();
$id = $_GET['id'];
$inscription = $inscriptionC->GetInscription($id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $telephone = $_POST['Telephone'];
    $categorie = $_POST['Categorie'];
    $dateReservation = $_POST['DateReservation'];
    $paiement = $_POST['Paiement'];

    $inscription = new Inscription($id, $telephone, $categorie, $dateReservation, $paiement);
    $inscriptionC->UpdateInscription($inscription);

    header('Location: tables.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Inscription</title>
    <link rel="stylesheet" href="../assets/css/material-dashboard.css?v=3.2.0">
</head>
<body>
    <h2>Modifier Inscription</h2>
    <form method="POST">
        <label>Téléphone:</label>
        <input type="text" name="Telephone" value="<?= htmlspecialchars($inscription['Telephone']) ?>" required>
        <label>Catégorie:</label>
        <select name="Categorie" required>
            <option value="Privé" <?= $inscription['Categorie'] == 'Privé' ? 'selected' : '' ?>>Privé</option>
            <option value="Public" <?= $inscription['Categorie'] == 'Public' ? 'selected' : '' ?>>Public</option>
        </select>
        <label>Date de Réservation:</label>
        <input type="datetime-local" name="DateReservation" value="<?= htmlspecialchars($inscription['DateReservation']) ?>" required>
        <label>Paiement:</label>
        <select name="Paiement" required>
            <option value="Oui" <?= $inscription['Paiement'] == 'Oui' ? 'selected' : '' ?>>Oui</option>
            <option value="Non" <?= $inscription['Paiement'] == 'Non' ? 'selected' : '' ?>>Non</option>
        </select>
        <button type="submit">Enregistrer</button>
    </form>
</body>
</html>