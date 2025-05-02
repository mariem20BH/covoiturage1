<?php
require_once __DIR__ . '/../Controller/TrajetC.php';

try {
    // Vérification des paramètres
    if (!isset($_GET['id'])) {
        throw new InvalidArgumentException('Paramètre ID manquant', 400);
    }

    // Validation de l'ID
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if ($id === false || $id < 1) {
        throw new InvalidArgumentException('ID invalide', 400);
    }

    $trajetC = new TrajetC();
    $result = $trajetC->DeleteTrajet($id);

    // Redirection vers la liste des trajets avec un message
    header('Location: ListeTrajet.php?delete=' . ($result ? 'success' : 'error'));
    exit;

} catch (Exception $e) {
    // En cas d'erreur, rediriger avec un message d'erreur
    header('Location: ListeTrajet.php?delete=error&message=' . urlencode($e->getMessage()));
    exit;
}