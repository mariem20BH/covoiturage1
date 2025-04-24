<?php
require_once '../../controller/TrajetC.php';
require_once '../../model/Trajet.php';


// Vérifier si les données du formulaire sont soumises
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ID_Trajet'])) {

    // Récupérer les données soumises par le formulaire
    $id = $_POST['ID_Inscription'];
    $adresseDepart = $_POST['Adresse_Depart'];
    $adresseArrivee = $_POST['Adresse_Arrivee'];
    $nombrePlaces = $_POST['Nombre_Places'];
    $prix = $_POST['Prix'];
    $distance = $_POST['Distance'];
    $duree = $_POST['Duree'];

    // Créer une instance du contrôleur
    $trajetController = new TrajetC();
    
    // Mettre à jour le trajet
    if ($trajetController->updateTrajet($id, $adresseDepart, $adresseArrivee, $nombrePlaces, $prix, $distance, $duree)) {
        // Rediriger vers la page des trajets après mise à jour
        header("Location: tables.php?msg=Trajet mis à jour avec succès");
        exit();
    } else {
        echo "Erreur lors de la mise à jour du trajet.";
    }
}
?>
