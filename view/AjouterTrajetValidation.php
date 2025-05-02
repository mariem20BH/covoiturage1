<?php
require_once 'C:/xampp/htdocs/webproj/controller/TrajetC.php';
require_once 'C:/xampp/htdocs/webproj/model/Trajet.php';
require_once 'C:/xampp/htdocs/webproj/controller/InscriptionC.php';

// Configuration de l'en-tête pour le retour JSON
header('Content-Type: application/json');

// Initialisation de la réponse
$response = [
    'success' => false,
    'message' => ''
];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["ID_Inscription"]) &&
        isset($_POST["AdresseDepart"]) &&
        isset($_POST["AdresseArrivee"]) &&
        isset($_POST["NombrePlaces"]) &&
        isset($_POST["Prix"]) &&
        isset($_POST["Distance"]) &&
        isset($_POST["Duree"])
    ) {
        try {
            // Validation côté serveur
            $inscriptionC = new InscriptionC();
            $inscriptionExist = $inscriptionC->GetInscription($_POST["ID_Inscription"]);

            if (!$inscriptionExist) {
                $response['message'] = "L'ID d'inscription n'existe pas dans la base de données.";
            } elseif (strlen($_POST["AdresseArrivee"]) < 4) {
                $response['message'] = "L'adresse d'arrivée doit contenir au moins 4 caractères.";
            } elseif (!is_numeric($_POST["Prix"]) || $_POST["Prix"] <= 0) {
                $response['message'] = "Le prix doit être un nombre positif et en dinars.";
            } elseif (!is_numeric($_POST["NombrePlaces"]) || intval($_POST["NombrePlaces"]) <= 0) {
                $response['message'] = "Le nombre de places doit être un entier positif.";
            } elseif (!is_numeric($_POST["Distance"]) || $_POST["Distance"] <= 0) {
                $response['message'] = "La distance doit être un nombre positif.";
            } else {
                // Tout est valide, création du trajet
                $trajet = new Trajet(
                    $_POST["ID_Inscription"],
                    $_POST["AdresseDepart"],
                    $_POST["AdresseArrivee"],
                    $_POST["NombrePlaces"],
                    $_POST["Prix"],
                    $_POST["Distance"],
                    $_POST["Duree"]
                );

                $tc = new TrajetC();
                $tc->AjouterTrajet($trajet);
                
                $response['success'] = true;
                $response['message'] = "Trajet ajouté avec succès.";
            }
        } catch (Exception $e) {
            $response['message'] = "Erreur lors de l'ajout : " . $e->getMessage();
        }
    } else {
        $response['message'] = "Veuillez remplir tous les champs.";
    }
} else {
    $response['message'] = "Méthode non autorisée.";
}

// Envoi de la réponse au format JSON
echo json_encode($response);