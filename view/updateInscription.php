<?php
require_once '../../controller/InscriptionC.php';
require_once '../../model/Inscription.php';

// Vérification si le formulaire de modification est soumis
if (isset($_POST['modifier'])) {
    // Récupérer les données envoyées depuis le formulaire
    $id = $_POST['ID'];
    $telephone = $_POST['Telephone'];
    $categorie = $_POST['Categorie'];
    $date_reservation = $_POST['DateReservation'];
    $paiement = $_POST['Paiement'];

    // Instancier l'objet Inscription
    $inscription = new Inscription($telephone, $categorie, $date_reservation, $paiement);
    $inscription->setID($id);

    // Vérification si le numéro de téléphone existe déjà pour un autre utilisateur
    $inscriptionC = new InscriptionC();
    $existingInscription = $inscriptionC->getInscriptionByTelephone($telephone);

    if ($existingInscription && $existingInscription['ID_Primaire'] != $id) {
        // Si le numéro de téléphone existe déjà pour un autre utilisateur, afficher un message d'erreur
        echo "<p style='color: red;'>Le numéro de téléphone est déjà utilisé par un autre utilisateur.</p>";
    } else {
        // Sinon, procéder à la mise à jour de l'inscription
        $inscriptionC->updateInscription($inscription);

        // Rediriger vers la liste des inscriptions après la mise à jour
        header("Location: listeInscription.php");
        exit;
    }
}
?>
