<?php
require_once __DIR__ . '/../Controller/TrajetC.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_trajet'])) {
    $id = intval($_POST['id_trajet']);

    $trajetC = new TrajetC();
    $trajetC->DeleteTrajet($id);

    header("Location: covoiturage.php?success=suppressed");
    exit;
}
?>
