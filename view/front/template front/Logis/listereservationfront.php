<?php
require_once 'C:/xampp/htdocs/webproj/config.php';
session_start();

$error_message = '';
$pdo = config::getConnexion();

// Traitement des mises à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['update_reservation'])) {
            $id_inscription = filter_input(INPUT_POST, 'id_inscription', FILTER_VALIDATE_INT);
            $telephone = filter_input(INPUT_POST, 'telephone', FILTER_SANITIZE_STRING);
            $categorie = filter_input(INPUT_POST, 'Categorie', FILTER_SANITIZE_STRING);
            $date_reservation = filter_input(INPUT_POST, 'date_reservation', FILTER_SANITIZE_STRING);
            $paiement = filter_input(INPUT_POST, 'Paiement', FILTER_SANITIZE_STRING);

            if (!$id_inscription || !$telephone || !$categorie || !$date_reservation || !$paiement) {
                throw new Exception("Tous les champs de la réservation sont requis.");
            }

            if (!preg_match("/^\d{8,}$/", $telephone)) {
                throw new Exception("Le numéro de téléphone doit contenir au moins 8 chiffres.");
            }

            if (!in_array($categorie, ['Public', 'Prive'])) {
                throw new Exception("Catégorie invalide.");
            }

            if (!in_array($paiement, ['Carte', 'Espèce'])) {
                throw new Exception("Mode de paiement invalide.");
            }

            $sql = "UPDATE inscription SET 
                    Telephone = :telephone, 
                    Categorie = :categorie, 
                    DateReservation = :date_reservation, 
                    Paiement = :paiement 
                    WHERE ID = :id_inscription";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':telephone' => $telephone,
                ':categorie' => $categorie,
                ':date_reservation' => $date_reservation,
                ':paiement' => $paiement,
                ':id_inscription' => $id_inscription
            ]);

            header("Location: listereservationfront.php");
            exit();
        }

        if (isset($_POST['update_trajet'])) {
            $id_trajet = filter_input(INPUT_POST, 'id_trajet', FILTER_VALIDATE_INT);
            $id_inscription = filter_input(INPUT_POST, 'id_inscription', FILTER_VALIDATE_INT);
            $adresse_depart = filter_input(INPUT_POST, 'adresse_depart', FILTER_SANITIZE_STRING) ?: null;
            $adresse_arrivee = filter_input(INPUT_POST, 'adresse_arrivee', FILTER_SANITIZE_STRING) ?: null;
            $nombre_places = filter_input(INPUT_POST, 'nombre_places', FILTER_VALIDATE_INT) ?: null;
            $prix = filter_input(INPUT_POST, 'prix', FILTER_VALIDATE_FLOAT) ?: null;
            $distance = filter_input(INPUT_POST, 'distance', FILTER_VALIDATE_FLOAT) ?: null;
            $duree = filter_input(INPUT_POST, 'duree', FILTER_SANITIZE_STRING) ?: null;

            if (!$id_trajet || !$id_inscription || !$adresse_depart || !$adresse_arrivee || !$nombre_places || !$prix || !$distance || !$duree) {
                throw new Exception("Tous les champs du trajet sont requis.");
            }

            if (strlen($adresse_arrivee) < 4) {
                throw new Exception("L'adresse d'arrivée doit contenir au moins 4 caractères.");
            }

            if ($nombre_places <= 0) {
                throw new Exception("Le nombre de places doit être positif.");
            }

            if ($prix <= 0) {
                throw new Exception("Le prix doit être positif.");
            }

            if ($distance <= 0) {
                throw new Exception("La distance doit être positive.");
            }

            if (!preg_match("/^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/", $duree)) {
                throw new Exception("La durée doit être au format HH:MM:SS.");
            }

            $sql = "UPDATE trajet SET 
                    Adresse_Depart = :adresse_depart, 
                    Adresse_Arrivee = :adresse_arrivee, 
                    Nombre_Places = :nombre_places, 
                    Prix = :prix, 
                    Distance = :distance, 
                    Duree = :duree 
                    WHERE ID_Trajet = :id_trajet AND ID_Inscription = :id_inscription";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':adresse_depart' => $adresse_depart,
                ':adresse_arrivee' => $adresse_arrivee,
                ':nombre_places' => $nombre_places,
                ':prix' => $prix,
                ':distance' => $distance,
                ':duree' => $duree,
                ':id_trajet' => $id_trajet,
                ':id_inscription' => $id_inscription
            ]);

            header("Location: listereservationfront.php");
            exit();
        }
    } catch (Exception $e) {
        $error_message = "Erreur : " . $e->getMessage();
    }
}

// Récupération des données
$sql = "SELECT i.ID, i.Telephone, i.Categorie, i.DateReservation, i.Paiement, 
               t.ID_Trajet, t.Adresse_Depart, t.Adresse_Arrivee, t.Nombre_Places, 
               t.Prix, t.Distance, t.Duree 
        FROM inscription i 
        LEFT JOIN trajet t ON i.ID = t.ID_Inscription 
        ORDER BY i.ID";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$reservations = [];
foreach ($results as $row) {
    $id = $row['ID'];
    if (!isset($reservations[$id])) {
        $reservations[$id] = [
            'id_inscription' => $id,
            'telephone' => $row['Telephone'],
            'categorie' => $row['Categorie'],
            'date_reservation' => $row['DateReservation'],
            'paiement' => $row['Paiement'],
            'trajets' => []
        ];
    }
    if ($row['ID_Trajet']) {
        $reservations[$id]['trajets'][] = [
            'id_trajet' => $row['ID_Trajet'],
            'adresse_depart' => $row['Adresse_Depart'],
            'adresse_arrivee' => $row['Adresse_Arrivee'],
            'nombre_places' => $row['Nombre_Places'],
            'prix' => $row['Prix'],
            'distance' => $row['Distance'],
            'duree' => $row['Duree']
        ];
    }
}

// Récupération des inscriptions pour le dropdown
$inscriptions_sql = "SELECT ID, Telephone, Categorie FROM inscription";
$inscriptions_stmt = $pdo->prepare($inscriptions_sql);
$inscriptions_stmt->execute();
$inscriptions = $inscriptions_stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyParki - Gestion des Réservations</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        :root {
            --primary: #0d3f72;
            --secondary: #3a5cb3;
            --accent: #ef476f;
            --light: #f8fafc;
            --dark: #0a1d37;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--light);
            margin: 0;
            padding: 0;
            min-height: 100vh;
        }

        .container {
            max-width: 1400px;
            margin: 50px auto;
            padding: 0 30px;
        }

        .page-title {
            text-align: center;
            color: var(--dark);
            font-size: 2.8rem;
            margin-bottom: 60px;
            position: relative;
            font-weight: 700;
        }

        .page-title::after {
            content: '';
            width: 100px;
            height: 4px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .reservations-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 40px;
        }

        .reservation-card {
            background: white;
            border-radius: 25px;
            padding: 35px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0,0,0,0.03);
        }

        .reservation-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.12);
        }

        .card-icon {
            width: 90px;
            height: 90px;
            background: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            font-size: 2.2rem;
            color: white;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
        }

        .reservation-card:hover .card-icon {
            transform: rotate(15deg) scale(1.1);
        }

        .card-title {
            font-weight: 700;
            font-size: 1.6rem;
            margin-bottom: 20px;
            color: var(--dark);
            text-align: center;
        }

        .card-detail {
            color: #4a5568;
            margin-bottom: 15px;
            font-size: 1rem;
            line-height: 1.7;
            text-align: center;
        }

        .edit-btn {
            display: block;
            width: fit-content;
            margin: 25px auto 0;
            background: var(--primary);
            color: white;
            padding: 15px 45px;
            border-radius: 50px;
            border: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(13, 63, 114, 0.3);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .edit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(120deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: all 0.6s ease;
        }

        .edit-btn:hover::before {
            left: 100%;
        }

        .edit-btn:hover {
            background: var(--secondary);
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(13, 63, 114, 0.5);
        }

        .trajet-card {
            margin-top: 25px;
            padding: 25px;
            background: #f8fafc;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
            border: 1px solid rgba(0,0,0,0.03);
            position: relative;
        }

        .trajet-card p {
            margin: 5px 0;
        }

        .edit-trajet-btn {
            display: inline-block;
            margin-top: 10px;
            background: var(--primary);
            color: white;
            padding: 8px 20px;
            border-radius: 50px;
            border: none;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(13, 63, 114, 0.2);
            cursor: pointer;
        }

        .edit-trajet-btn:hover {
            background: var(--secondary);
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(13, 63, 114, 0.4);
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.6);
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal.active {
            opacity: 1;
            display: flex;
        }

        .modal-content {
            background: white;
            padding: 40px;
            border-radius: 20px;
            width: 70%;
            max-width: 900px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            transform: scale(0);
            transition: all 0.3s ease;
            overflow-y: auto;
            max-height: 70vh;
        }

        .modal.active .modal-content {
            transform: scale(1);
        }

        .close {
            position: absolute;
            top: 15px;
            right: 20px;
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: #000;
        }

        .modal-content h3 {
            margin-top: 0;
            color: var(--dark);
            text-align: center;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: var(--dark);
        }

        .form-control {
            width: 100%;
            padding: 12px 20px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .form-control:focus {
            border-color: var(--secondary);
            box-shadow: 0 0 0 3px rgba(58,92,179,0.1);
            outline: none;
        }

        .error-message {
            color: var(--accent);
            font-size: 0.85rem;
            margin-top: 5px;
            display: none;
        }

        .success-message {
            color: #28a745;
            font-size: 0.85rem;
            margin-top: 5px;
            display: none;
            padding-left: 25px;
            position: relative;
        }

        .success-message::before {
            content: "✓";
            position: absolute;
            left: 0;
            top: 0;
        }

        .is-invalid {
            border-color: var(--accent) !important;
            box-shadow: 0 0 0 2px rgba(239,71,111,0.25);
        }

        .is-valid {
            border-color: #28a745 !important;
            box-shadow: 0 0 0 2px rgba(40,167,69,0.25);
        }

        .submit-btn {
            display: block;
            width: fit-content;
            margin: 25px auto 0;
            background: var(--primary);
            color: white;
            padding: 15px 45px;
            border-radius: 50px;
            border: none;
            font-weight: 600;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(13, 63, 114, 0.3);
            cursor: pointer;
        }

        .submit-btn:hover {
            background: var(--secondary);
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(13, 63, 114, 0.5);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="page-title">Gestion des Réservations</h1>
        <?php if ($error_message): ?>
            <div class="error-message" style="display: block; text-align: center;"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <div class="reservations-grid">
            <?php foreach ($reservations as $reservation): ?>
                <div class="reservation-card">
                    <div class="card-icon"><i class="fas fa-calendar-alt"></i></div>
                    <h3 class="card-title">Réservation #<?php echo htmlspecialchars($reservation['id_inscription']); ?></h3>
                    <p class="card-detail"><strong>Téléphone:</strong> <?php echo htmlspecialchars($reservation['telephone'] ?? 'N/A'); ?></p>
                    <p class="card-detail"><strong>Catégorie:</strong> <?php echo htmlspecialchars($reservation['categorie'] ?? 'N/A'); ?></p>
                    <p class="card-detail"><strong>Date:</strong> <?php echo htmlspecialchars($reservation['date_reservation']); ?></p>
                    <p class="card-detail"><strong>Paiement:</strong> <?php echo htmlspecialchars($reservation['paiement']); ?></p>
                    
                    <h4 class="card-title" style="font-size: 1.3rem; margin-top: 25px;">Trajets Associés</h4>
                    <?php if (!empty($reservation['trajets'])): ?>
                        <?php foreach ($reservation['trajets'] as $trajet): ?>
                            <div class="trajet-card">
                                <p><strong>Départ:</strong> <?php echo htmlspecialchars($trajet['adresse_depart'] ?? 'N/A'); ?></p>
                                <p><strong>Arrivée:</strong> <?php echo htmlspecialchars($trajet['adresse_arrivee'] ?? 'N/A'); ?></p>
                                <p><strong>Places:</strong> <?php echo htmlspecialchars($trajet['nombre_places'] ?? 'N/A'); ?></p>
                                <p><strong>Prix:</strong> <?php echo htmlspecialchars($trajet['prix'] ?? 'N/A'); ?> DT</p>
                                <p><strong>Distance:</strong> <?php echo htmlspecialchars($trajet['distance'] ?? 'N/A'); ?> km</p>
                                <p><strong>Durée:</strong> <?php echo htmlspecialchars($trajet['duree'] ?? 'N/A'); ?></p>
                                <button class="edit-trajet-btn" 
                                        data-trajet='<?php echo htmlspecialchars(json_encode($trajet, JSON_HEX_APOS), ENT_QUOTES); ?>' 
                                        data-id-inscription="<?php echo htmlspecialchars($reservation['id_inscription']); ?>">
                                    Modifier
                                </button>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="card-detail">Aucun trajet associé</p>
                    <?php endif; ?>
                    <button class="edit-btn" 
                            data-reservation='<?php echo htmlspecialchars(json_encode($reservation, JSON_HEX_APOS), ENT_QUOTES); ?>'>
                        Modifier
                    </button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modal for Reservation -->
    <div class="modal" id="editModal">
        <div class="modal-content">
            <span class="close">×</span>
            <h3>Modifier la Réservation</h3>
            <form id="inscriptionForm" method="POST" novalidate>
                <input type="hidden" name="update_reservation" value="1">
                <input type="hidden" id="id_inscription" name="id_inscription">
                <div class="form-group">
                    <label for="telephone">Téléphone</label>
                    <input type="text" id="telephone" name="telephone" class="form-control">
                    <div class="error-message" id="error-telephone"></div>
                    <div class="success-message" id="success-telephone">Validé</div>
                    <small>Format: 8 chiffres minimum</small>
                </div>
                <div class="form-group">
                    <label for="Categorie">Catégorie</label>
                    <select name="Categorie" id="Categorie" class="form-control">
                        <option value="">-- Sélectionnez --</option>
                        <option value="Public">Public</option>
                        <option value="Prive">Privé</option>
                    </select>
                    <div class="error-message" id="error-categorie"></div>
                    <div class="success-message" id="success-categorie">Validé</div>
                </div>
                <div class="form-group">
                    <label for="date_reservation">Date</label>
                    <input type="date" id="date_reservation" name="date_reservation" class="form-control">
                    <div class="error-message" id="error-date_reservation"></div>
                    <div class="success-message" id="success-date_reservation">Validé</div>
                </div>
                <div class="form-group">
                    <label for="Paiement">Paiement</label>
                    <select name="Paiement" id="Paiement" class="form-control">
                        <option value="">-- Sélectionnez --</option>
                        <option value="Carte">Carte</option>
                        <option value="Espèce">Espèce</option>
                    </select>
                    <div class="error-message" id="error-Paiement"></div>
                    <div class="success-message" id="success-Paiement">Validé</div>
                </div>
                <button type="submit" class="submit-btn">Enregistrer</button>
            </form>
        </div>
    </div>

    <!-- Modal for Trajet -->
    <div class="modal" id="editTrajetModal">
        <div class="modal-content">
            <span class="close">×</span>
            <h3>Modifier le Trajet</h3>
            <form id="trajetForm" method="POST" novalidate>
                <input type="hidden" name="update_trajet" value="1">
                <input type="hidden" id="id_trajet" name="id_trajet">
                <div class="form-group">
                    <label for="id_inscription">ID Inscription</label>
                    <select name="id_inscription" id="id_inscription" class="form-control">
                        <option value="">-- Sélectionnez --</option>
                        <?php foreach ($inscriptions as $inscription): ?>
                            <option value="<?php echo htmlspecialchars($inscription['ID']); ?>">
                                <?php echo htmlspecialchars($inscription['ID'] . ' - ' . $inscription['Telephone'] . ' (' . $inscription['Categorie'] . ')'); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="error-message" id="error-id_inscription"></div>
                    <div class="success-message" id="success-id_inscription">Validé</div>
                </div>
                <div class="form-group">
                    <label for="adresse_depart">Adresse de départ</label>
                    <select name="adresse_depart" id="adresse_depart" class="form-control">
                        <option value="">-- Sélectionnez --</option>
                        <option value="Parking de l'aéroport">Parking de l'aéroport</option>
                        <option value="Parking Tunis City">Parking Tunis City</option>
                        <option value="Parking Municipal">Parking Municipal</option>
                        <option value="Centre Urbain Nord">Centre Urbain Nord</option>
                    </select>
                    <div class="error-message" id="error-adresse_depart"></div>
                    <div class="success-message" id="success-adresse_depart">Validé</div>
                </div>
                <div class="form-group">
                    <label for="adresse_arrivee">Adresse d'arrivée</label>
                    <input type="text" id="adresse_arrivee" name="adresse_arrivee" class="form-control">
                    <div class="error-message" id="error-adresse_arrivee"></div>
                    <div class="success-message" id="success-adresse_arrivee">Validé</div>
                    <small>Minimum 4 caractères</small>
                </div>
                <div class="form-group">
                    <label for="nombre_places">Nombre de places</label>
                    <input type="number" id="nombre_places" name="nombre_places" class="form-control" min="1">
                    <div class="error-message" id="error-nombre_places"></div>
                    <div class="success-message" id="success-nombre_places">Validé</div>
                </div>
                <div class="form-group">
                    <label for="prix">Prix (DT)</label>
                    <input type="number" id="prix" name="prix" class="form-control" step="0.01" min="0.01">
                    <div class="error-message" id="error-prix"></div>
                    <div class="success-message" id="success-prix">Validé</div>
                </div>
                <div class="form-group">
                    <label for="distance">Distance (km)</label>
                    <input type="number" id="distance" name="distance" class="form-control" step="0.01" min="0.01">
                    <div class="error-message" id="error-distance"></div>
                    <div class="success-message" id="success-distance">Validé</div>
                </div>
                <div class="form-group">
                    <label for="duree">Durée (HH:MM:SS)</label>
                    <input type="text" id="duree" name="duree" class="form-control" placeholder="HH:MM:SS">
                    <div class="error-message" id="error-duree"></div>
                    <div class="success-message" id="success-duree">Validé</div>
                </div>
                <button type="submit" class="submit-btn">Enregistrer</button>
            </form>
        </div>
    </div>

    <script>
        // Fonctions de base
        function showError(fieldId, message) {
            const field = document.getElementById(fieldId);
            const errorElement = document.getElementById('error-' + fieldId);
            
            if (field && errorElement) {
                errorElement.textContent = message;
                errorElement.style.display = 'block';
                field.classList.add('is-invalid');
                field.classList.remove('is-valid');
            }
        }

        function showSuccess(fieldId) {
            const field = document.getElementById(fieldId);
            const successElement = document.getElementById('success-' + fieldId);
            
            if (field && successElement) {
                successElement.style.display = 'block';
                field.classList.add('is-valid');
                field.classList.remove('is-invalid');
            }
        }

        function hideError(fieldId) {
            const field = document.getElementById(fieldId);
            const errorElement = document.getElementById('error-' + fieldId);
            
            if (field && errorElement) {
                errorElement.textContent = '';
                errorElement.style.display = 'none';
                field.classList.remove('is-invalid');
            }
        }

        // Validation spécifique aux champs
        function validateField(fieldId) {
            const field = document.getElementById(fieldId);
            if (!field) return true;

            const value = field.value.trim();
            let isValid = true;

            switch (fieldId) {
                // Inscription Form
                case 'telephone':
                    isValid = /^\d{8,}$/.test(value);
                    if (!isValid) showError(fieldId, '8 chiffres minimum');
                    break;
                case 'Categorie':
                    isValid = value !== '';
                    if (!isValid) showError(fieldId, 'Sélectionnez une catégorie');
                    break;
                case 'date_reservation':
                    isValid = value !== '';
                    if (!isValid) showError(fieldId, 'Date requise');
                    break;
                case 'Paiement':
                    isValid = value !== '';
                    if (!isValid) showError(fieldId, 'Sélectionnez un mode de paiement');
                    break;
                // Trajet Form
                case 'id_inscription':
                    isValid = value !== '';
                    if (!isValid) showError(fieldId, 'Sélectionnez une inscription');
                    break;
                case 'adresse_depart':
                    isValid = value !== '';
                    if (!isValid) showError(fieldId, 'Sélectionnez une adresse');
                    break;
                case 'adresse_arrivee':
                    isValid = value.length >= 4;
                    if (!isValid) showError(fieldId, '4 caractères minimum');
                    break;
                case 'nombre_places':
                    isValid = value !== '' && !isNaN(value) && parseInt(value) > 0;
                    if (!isValid) showError(fieldId, 'Nombre entier positif requis');
                    break;
                case 'prix':
                    isValid = value !== '' && !isNaN(value) && parseFloat(value) > 0;
                    if (!isValid) showError(fieldId, 'Prix positif requis');
                    break;
                case 'distance':
                    isValid = value !== '' && !isNaN(value) && parseFloat(value) > 0;
                    if (!isValid) showError(fieldId, 'Distance positive requise');
                    break;
                case 'duree':
                    isValid = /^([01]\d|2[0-3]):([0-5]\d):([0-5]\d)$/.test(value);
                    if (!isValid) showError(fieldId, 'Format HH:MM:SS requis');
                    break;
            }

            if (isValid) {
                hideError(fieldId);
                showSuccess(fieldId);
            }
            return isValid;
        }

        // Initialisation de la validation
        function setupValidation(formId, fields) {
            const form = document.getElementById(formId);
            if (!form) return;

            fields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.addEventListener('input', () => validateField(fieldId));
                    field.addEventListener('change', () => validateField(fieldId));
                }
            });

            form.addEventListener('submit', (e) => {
                let formIsValid = true;
                fields.forEach(fieldId => {
                    if (!validateField(fieldId)) formIsValid = false;
                });
                if (!formIsValid) e.preventDefault();
            });
        }

        // Gestion des modals
        function handleEditReservation(e) {
            try {
                const btn = e.target.closest('.edit-btn');
                const reservation = JSON.parse(btn.dataset.reservation);
                
                // Remplissage du formulaire
                document.getElementById('id_inscription').value = reservation.id_inscription;
                document.getElementById('telephone').value = reservation.telephone || '';
                document.getElementById('Categorie').value = reservation.categorie || '';
                document.getElementById('date_reservation').value = reservation.date_reservation || '';
                document.getElementById('Paiement').value = reservation.paiement || '';
                
                // Affichage du modal
                document.getElementById('editModal').classList.add('active');
            } catch (error) {
                console.error('Erreur lors du traitement de la réservation:', error);
                alert("Une erreur est survenue lors du chargement des données");
            }
        }

        function handleEditTrajet(e) {
            try {
                const btn = e.target.closest('.edit-trajet-btn');
                const trajet = JSON.parse(btn.dataset.trajet);
                const idInscription = btn.dataset.idInscription;

                // Remplissage du formulaire
                document.getElementById('id_trajet').value = trajet.id_trajet;
                document.getElementById('id_inscription').value = idInscription;
                document.getElementById('adresse_depart').value = trajet.adresse_depart || '';
                document.getElementById('adresse_arrivee').value = trajet.adresse_arrivee || '';
                document.getElementById('nombre_places').value = trajet.nombre_places || '';
                document.getElementById('prix').value = trajet.prix || '';
                document.getElementById('distance').value = trajet.distance || '';
                document.getElementById('duree').value = trajet.duree || '';
                
                // Affichage du modal
                document.getElementById('editTrajetModal').classList.add('active');
            } catch (error) {
                console.error('Erreur lors du traitement du trajet:', error);
                alert("Une erreur est survenue lors du chargement des données");
            }
        }

        // Initialisation
        document.addEventListener('DOMContentLoaded', () => {
            // Gestion des clics
            document.body.addEventListener('click', (e) => {
                if (e.target.closest('.edit-btn')) handleEditReservation(e);
                if (e.target.closest('.edit-trajet-btn')) handleEditTrajet(e);
            });

            // Fermeture des modals
            document.querySelectorAll('.modal .close').forEach(closeBtn => {
                closeBtn.addEventListener('click', () => {
                    closeBtn.closest('.modal').classList.remove('active');
                });
            });

            // Fermeture au clic en dehors
            document.querySelectorAll('.modal').forEach(modal => {
                modal.addEventListener('click', (e) => {
                    if (e.target === modal) {
                        modal.classList.remove('active');
                    }
                });
            });

            // Validation pour les formulaires
            setupValidation('inscriptionForm', [
                'telephone',
                'Categorie',
                'date_reservation',
                'Paiement'
            ]);

            setupValidation('trajetForm', [
                'id_inscription',
                'adresse_depart',
                'adresse_arrivee',
                'nombre_places',
                'prix',
                'distance',
                'duree'
            ]);
        });
    </script>
</body>
</html>