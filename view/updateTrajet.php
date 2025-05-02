<?php
require_once '../model/Trajet.php';
require_once '../controller/TrajetC.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $json = file_get_contents("php://input");
    $data = json_decode($json, true);

    if (!$data || !isset($data['ID_Trajet'])) {
        echo json_encode(['success' => false, 'error' => 'Données manquantes']);
        exit;
    }

    $trajetC = new TrajetC();

    $trajet = new Trajet(
        $data['Adresse_Depart'],
        $data['Adresse_Arrivee'],
        $data['Nombre_Places'],
        $data['Prix'],
        $data['Distance'],
        $data['Duree'],
        null  // si tu as ID_Inscription ou autre
    );
    $trajet->setID_Trajet($data['ID_Trajet']);

    try {
        $trajetC->updateTrajet($trajet);
        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
