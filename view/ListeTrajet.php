<?php
require_once 'C:/xampp/htdocs/webproj/controller/TrajetC.php';

$tc = new TrajetC();
$listeTrajets = $tc->ListeTrajet();
$message = '';
<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <div class="alert alert-success text-center" id="successMsg">
        ✅ Trajet ajouté avec succès !
    </div>
    <script>
        // Masquer le message après 4 secondes
        setTimeout(() => {
            document.getElementById('successMsg').style.display = 'none';
        }, 4000);
    </script>
    <?php endif; ?>
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des trajets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
            background-color: #f5f7fa;
        }
        .table-container {
            max-width: 1000px;
            margin: auto;
        }
        .table thead {
            background-color: #007BFF;
            color: white;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
        h2 {
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="table-container">
    <h2>Liste des trajets enregistrés</h2>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Inscription</th>
                <th>Départ</th>
                <th>Arrivée</th>
                <th>Places</th>
                <th>Prix (DT)</th>
                <th>Distance (km)</th>
                <th>Durée</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($listeTrajets)) : ?>
                <?php foreach ($listeTrajets as $trajet): ?>
                    <tr>
                        <td><?= htmlspecialchars($trajet['ID']) ?></td>
                        <td><?= htmlspecialchars($trajet['ID_Inscription']) ?></td>
                        <td><?= htmlspecialchars($trajet['AdresseDepart']) ?></td>
                        <td><?= htmlspecialchars($trajet['AdresseArrivee']) ?></td>
                        <td><?= htmlspecialchars($trajet['NombrePlaces']) ?></td>
                        <td><?= htmlspecialchars($trajet['Prix']) ?></td>
                        <td><?= htmlspecialchars($trajet['Distance']) ?></td>
                        <td><?= htmlspecialchars($trajet['Duree']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="8" class="text-center">Aucun trajet trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>
