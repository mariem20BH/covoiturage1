<?php
require_once 'C:/xampp/htdocs/webproj/config.php';
session_start();

// Initialisation
$errors = [];
$success = "";
$inscriptions = []; // Pour stocker les inscriptions existantes
$values = [
    'ID_Inscription' => '',
    'Adresse_Depart' => '',
    'Adresse_Arrivee' => '',
    'Nombre_Places' => '',
    'Prix' => '',
    'Distance' => '',
    'Duree' => ''
];

try {
    $pdo = config::getConnexion();
    // Récupérer toutes les inscriptions existantes
    $stmt = $pdo->query("SELECT ID FROM inscription");
    $inscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $errors['global'] = "Erreur de connexion à la base de données : " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nettoyage des champs
    $values = [
        'ID_Inscription' => trim($_POST['ID_Inscription'] ?? ''),
        'Adresse_Depart' => trim($_POST['Adresse_Depart'] ?? ''),
        'Adresse_Arrivee' => trim($_POST['Adresse_Arrivee'] ?? ''),
        'Nombre_Places' => trim($_POST['Nombre_Places'] ?? ''),
        'Prix' => trim($_POST['Prix'] ?? ''),
        'Distance' => trim($_POST['Distance'] ?? ''),
        'Duree' => trim($_POST['Duree'] ?? '')
    ];

    // Validation
    $requiredFields = [
        'Adresse_Depart' => "L'adresse de départ est obligatoire",
        'Adresse_Arrivee' => "L'adresse d'arrivée est obligatoire"
    ];

    foreach ($requiredFields as $field => $message) {
        if (empty($values[$field])) {
            $errors[$field] = $message;
        }
    }

    // Validation numérique
    $numericFields = [
        'Nombre_Places' => ['min' => 1, 'message' => "Nombre de places invalide (minimum 1)"],
        'Prix' => ['min' => 0, 'message' => "Prix invalide"],
        'Distance' => ['min' => 0.1, 'message' => "Distance invalide (minimum 0.1 km)"],
        'Duree' => ['min' => 1, 'message' => "Durée invalide (minimum 1 minute)"]
    ];

    foreach ($numericFields as $field => $options) {
        if (!is_numeric($values[$field]) || $values[$field] < $options['min']) {
            $errors[$field] = $options['message'];
        }
    }

    // Validation ID Inscription
    if (!empty($values['ID_Inscription'])) {
        try {
            // Vérifier l'existence de l'inscription
            $stmt = $pdo->prepare("SELECT ID FROM inscription WHERE ID = ?");
            $stmt->execute([$values['ID_Inscription']]);
            
            if ($stmt->rowCount() === 0) {
                $errors['ID_Inscription'] = "Aucune inscription trouvée avec cet ID";
            }
        } catch (PDOException $e) {
            $errors['global'] = "Erreur de vérification : " . $e->getMessage();
        }
    }

    // Si pas d'erreur, insertion
    if (empty($errors)) {
        try {
            $sql = "
                INSERT INTO trajet 
                (ID_Inscription, Adresse_Depart, Adresse_Arrivee, 
                 Nombre_Places, Prix, Distance, Duree)
                VALUES (:inscription, :depart, :arrivee, 
                        :places, :prix, :distance, :duree)
            ";
            $stmt = $pdo->prepare($sql);
            
            $params = [
                ':inscription' => !empty($values['ID_Inscription']) ? $values['ID_Inscription'] : null,
                ':depart' => $values['Adresse_Depart'],
                ':arrivee' => $values['Adresse_Arrivee'],
                ':places' => $values['Nombre_Places'],
                ':prix' => $values['Prix'],
                ':distance' => $values['Distance'],
                ':duree' => $values['Duree']
            ];

            $stmt->execute($params);

            $success = "Trajet créé avec succès !";
            // Réinitialisation des valeurs
            $values = array_fill_keys(array_keys($values), '');

        } catch (PDOException $e) {
            $errors['global'] = "Erreur base de données : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>EasyParki - Covoiturage</title>
    <meta name="description" content="Planifiez vos covoiturage en toute simplicité avec EasyParki">
    <meta name="keywords" content="trajet, inscription">

    <!-- Favicons -->
    <link href="assets/img/logoo.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #0d3f72;
            --primary-dark: #08284d;
            --secondary-color: #0a1d37;
            --accent-color: #3a5cb3;
            --light-color: #f8fafc;
            --dark-color: #2d3748;
            --text-color: #4a5568;
            --section-bg: #f5f7fa;
            --card-bg: #ffffff;
            --border-color: rgba(0,0,0,0.08);
            --gradient: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
        }

        /* Header & Navigation */
        .header {
            background: rgba(255, 255, 255, 0.98);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .sitename {
            font-family: Arial, sans-serif;
            font-weight: 700;
            color: var(--secondary-color);
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .navmenu ul li a {
            position: relative;
            color: var(--dark-color);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .navmenu ul li a:hover,
        .navmenu ul li a.active {
            color: var(--primary-color);
        }

        .navmenu ul li a:after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--gradient);
            transition: width 0.3s ease;
        }

        .navmenu ul li a:hover:after,
        .navmenu ul li a.active:after {
            width: 100%;
        }

        .btn-getstarted {
            background: var(--gradient);
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 50px;
            box-shadow: 0 5px 15px rgba(74, 166, 255, 0.4);
            transition: all 0.3s ease;
        }

        .btn-getstarted:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(74, 166, 255, 0.6);
        }

        /* Hero Section */
        .page-title {
            position: relative;
            padding: 180px 0 120px;
            background: linear-gradient(rgba(10, 29, 55, 0.85), rgba(10, 29, 55, 0.85)), url('assets/img/55.png') center/cover no-repeat;
            color: white;
            text-align: center;
        }

        .page-title h1 {
            font-family: Arial, sans-serif;
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            animation: fadeInDown 1s ease;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .page-title p {
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto 30px;
            animation: fadeInUp 1s ease;
            opacity: 0.9;
        }

        /* Form Styles */
        .form-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            background: white;
        }

        .form-title {
            color: #0d3f72;
            text-align: center;
            margin-bottom: 30px;
            font-weight: 700;
        }

        .form-label {
            font-weight: 600;
            color: #2d3748;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-control, .form-select {
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 8px 12px;
            transition: border-color 0.3s ease;
        }

        .form-control.is-invalid, .form-select.is-invalid {
            border: 1px solid #dc3545;
            background-image: none;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.85em;
            margin-top: 4px;
            display: none;
        }

        .error-message.show {
            display: block;
        }

        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
            padding: 10px 20px;
            font-weight: 600;
        }

        .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0a58ca;
        }

        .popup-success {
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            padding: 15px 25px;
            background: #d4edda;
            color: #155724;
            border-radius: 8px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            animation: fadeInOut 3s;
        }

        @keyframes fadeInOut {
            0% { opacity: 0; }
            15% { opacity: 1; }
            85% { opacity: 1; }
            100% { opacity: 0; }
        }

        /* Footer */
        .footer {
            background: var(--secondary-color);
            color: white;
            padding-top: 100px;
            position: relative;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 15px;
            background: var(--gradient);
        }

        .footer-links h4 {
            font-family: Arial, sans-serif;
            margin-bottom: 25px;
            position: relative;
            display: inline-block;
        }

        .footer-links h4::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 3px;
            background: var(--primary-color);
            border-radius: 3px;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 45px;
            height: 45px;
            background: rgba(249, 249, 249, 0.91);
            border-radius: 50%;
            margin-right: 10px;
            color: white;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: white;
            color: var(--primary-color);
            transform: translateY(-3px);
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-title h1 {
                font-size: 2.5rem;
            }

            .page-title p {
                font-size: 1rem;
            }
        }

        /* Dropdown styling */
        .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            min-width: 220px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.1);
            padding: 10px 0;
            opacity: 0;
            transform: translateY(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            border: none;
        }

        .nav-item.dropdown:hover .dropdown-menu {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        .dropdown-item {
            padding: 12px 25px;
            color: var(--secondary-color) !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background: rgba(13, 63, 114, 0.05);
            padding-left: 30px;
        }

        .dropdown-item i {
            color: var(--primary-color);
            font-size: 1.1em;
            width: 24px;
            text-align: center;
        }

        /* Floating Button */
        .floating-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 99;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--gradient);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 10px 25px rgba(13, 63, 114, 0.3);
            transition: all 0.3s ease;
            font-size: 1.5rem;
            text-decoration: none;
        }

        .floating-btn:hover {
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 15px 30px rgba(13, 63, 114, 0.4);
        }
    </style>
</head>

<body class="vacation-page">
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">
            <a href="about.php" class="logo d-flex align-items-center me-auto">
                <h1 class="sitename">EasyParki</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="index.html">Accueil</a></li>
                    <li><a href="Stationnement.html">Stationnement</a></li>
                    <li class="dropdown">
                        <a href="transport public.html" class="active">Covoiturage</a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="listTrajetfront.php" class="dropdown-item">
                                    <i class="bi bi-building"></i>
                                    Voir Les Trajets
                                </a>
                            </li>
                            <li>
                                <a href="addreservationfront.php" class="dropdown-item">
                                    <i class="bi bi-calendar-plus"></i>
                                    Planifier reservations
                                </a>
                            </li>
                            <li>
                                <a href="listplansVacancefront.php" class="dropdown-item">
                                    <i class="bi bi-list-task"></i>
                                    Accéder à mon inscription
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li><a href="Covoiturage.html">Vacance</a></li>
                    <li><a href="Recharge.html">Service</a></li>
                    <li><a href="Evenement.html">Événement</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="btn-getstarted" href="get-a-quote.html">Créer un compte</a>
        </div>
    </header>

    <main class="main">
        <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/55.png);">
            <div class="container position-relative">
                <h1>Covoiturages</h1>
                <p>Partez à l'aventure et vivez des souvenirs mémorables grâce à notre service.</p>
            </div>
        </div>

        <div class="form-container">
            <h1 class="form-title">Créer un Nouveau Trajet</h1>

            <?php if (!empty($success)) : ?>
                <div class="popup-success"><?= $success ?></div>
            <?php endif; ?>

            <?php if (!empty($errors['global'])) : ?>
                <div class="alert alert-danger"><?= $errors['global'] ?></div>
            <?php endif; ?>

            <form method="POST" id="trajetForm" novalidate>
                <!-- Adresse Départ -->
                <div class="form-group">
                    <label class="form-label">Adresse de départ *</label>
                    <input type="text" name="Adresse_Depart" id="Adresse_Depart" 
                           class="form-control <?= isset($errors['Adresse_Depart']) ? 'is-invalid' : '' ?>" 
                           value="<?= htmlspecialchars($values['Adresse_Depart']) ?>"
                           placeholder="Ex: 123 Rue de Paris, Tunis">
                    <div class="error-message" id="error-Adresse_Depart">
                        <?= isset($errors['Adresse_Depart']) ? $errors['Adresse_Depart'] : '' ?>
                    </div>
                </div>

                <!-- Adresse Arrivée -->
                <div class="form-group">
                    <label class="form-label">Adresse d'arrivée *</label>
                    <input type="text" name="Adresse_Arrivee" id="Adresse_Arrivee" 
                           class="form-control <?= isset($errors['Adresse_Arrivee']) ? 'is-invalid' : '' ?>" 
                           value="<?= htmlspecialchars($values['Adresse_Arrivee']) ?>"
                           placeholder="Ex: 456 Avenue Habib Bourguiba, Sousse">
                    <div class="error-message" id="error-Adresse_Arrivee">
                        <?= isset($errors['Adresse_Arrivee']) ? $errors['Adresse_Arrivee'] : '' ?>
                    </div>
                </div>

                <!-- ID Inscription -->
                <div class="form-group">
                    <label class="form-label">Associer à une inscription (optionnel)</label>
                    <select name="ID_Inscription" id="ID_Inscription" 
                            class="form-select <?= isset($errors['ID_Inscription']) ? 'is-invalid' : '' ?>">
                        <option value="">-- Sélectionnez une inscription --</option>
                        <?php foreach ($inscriptions as $inscription): ?>
                            <option value="<?= $inscription['ID'] ?>" 
                                    <?= ($inscription['ID'] == $values['ID_Inscription']) ? 'selected' : '' ?>>
                                Inscription #<?= $inscription['ID'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="error-message" id="error-ID_Inscription">
                        <?= isset($errors['ID_Inscription']) ? $errors['ID_Inscription'] : '' ?>
                    </div>
                </div>

                <!-- Nombre de places -->
                <div class="form-group">
                    <label class="form-label">Nombre de places *</label>
                    <input type="number" min="1" name="Nombre_Places" id="Nombre_Places" 
                           class="form-control <?= isset($errors['Nombre_Places']) ? 'is-invalid' : '' ?>" 
                           value="<?= htmlspecialchars($values['Nombre_Places']) ?>">
                    <div class="error-message" id="error-Nombre_Places">
                        <?= isset($errors['Nombre_Places']) ? $errors['Nombre_Places'] : '' ?>
                    </div>
                </div>

                <!-- Prix -->
                <div class="form-group">
                    <label class="form-label">Prix (DT) *</label>
                    <input type="number" step="0.01" min="0" name="Prix" id="Prix" 
                           class="form-control <?= isset($errors['Prix']) ? 'is-invalid' : '' ?>" 
                           value="<?= htmlspecialchars($values['Prix']) ?>">
                    <div class="error-message" id="error-Prix">
                        <?= isset($errors['Prix']) ? $errors['Prix'] : '' ?>
                    </div>
                </div>

                <!-- Distance -->
                <div class="form-group">
                    <label class="form-label">Distance (km) *</label>
                    <input type="number" step="0.1" min="0.1" name="Distance" id="Distance" 
                           class="form-control <?= isset($errors['Distance']) ? 'is-invalid' : '' ?>" 
                           value="<?= htmlspecialchars($values['Distance']) ?>">
                    <div class="error-message" id="error-Distance">
                        <?= isset($errors['Distance']) ? $errors['Distance'] : '' ?>
                    </div>
                </div>

                <!-- Durée -->
                <div class="form-group">
                    <label class="form-label">Durée (minutes) *</label>
                    <input type="number" min="1" name="Duree" id="Duree" 
                           class="form-control <?= isset($errors['Duree']) ? 'is-invalid' : '' ?>" 
                           value="<?= htmlspecialchars($values['Duree']) ?>">
                    <div class="error-message" id="error-Duree">
                        <?= isset($errors['Duree']) ? $errors['Duree'] : '' ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 py-2">
                    Confirmer la réservation
                </button>
            </form>
        </div>
    </main>

    <footer id="footer" class="footer">
        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-5 col-md-12 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">EasyParki</span>
                    </a>
                    <p>EasyParki est une plateforme intelligente et centralisée qui facilite la mobilité urbaine durable en offrant des solutions intégrées pour le stationnement, le covoiturage, les transports publics, la recharge électrique et la gestion d'événements.</p>
                    <div class="social-links d-flex mt-4">
                        <a href=""><i class="bi bi-twitter"></i></a>
                        <a href=""><i class="bi bi-facebook"></i></a>
                        <a href=""><i class="bi bi-instagram"></i></a>
                        <a href=""><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-6 footer-links">
                    <h4>Liens utiles</h4>
                    <ul>
                        <li><a href="index.html">Accueil</a></li>
                        <li><a href="about.php">À propos de nous</a></li>
                        <li><a href="services.html">Nos services</a></li>
                        <li><a href="terms.html">Conditions d'utilisation</a></li>
                        <li><a href="privacy.html">Politique de confidentialité</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-6 footer-links">
                    <h4>Nos services</h4>
                    <ul>
                        <li><a href="Stationnement.html">Stationnement</a></li>
                        <li><a href="transport public.html">Vacances</a></li>
                        <li><a href="Covoiturage.html">Covoiturage</a></li>
                        <li><a href="Recharge.html">Recharges électriques</a></li>
                        <li><a href="Evenement.html">Événements</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                    <h4>Contactez-nous</h4>
                    <p>18, rue de l'Usine <br>
                        ZI Aéroport Charguia II 2035 Ariana<br>
                        Tunisie</p>
                    <p class="mt-4"><strong>Téléphone :</strong> <span>+216 50 084 004</span></p>
                    <p><strong>Email :</strong> <span>contact@easyparki.com</span></p>
                </div>
            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">EasyParki</strong> <span>Tous droits réservés</span></p>
            <div class="credits">
                Designé par <a href="#">Asteria</a>
            </div>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Floating Button -->
    <a href="addplanVacancefront.php" class="floating-btn" data-aos="fade-up" data-aos-delay="300" title="Commencer à planifier">
        <i class="bi bi-calendar-plus"></i>
    </a>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('trajetForm');
            
            // Validation rules
            const validationRules = [
                {
                    id: 'Adresse_Depart',
                    validate: value => value.trim() !== '',
                    message: "L'adresse de départ est obligatoire"
                },
                {
                    id: 'Adresse_Arrivee',
                    validate: value => value.trim() !== '',
                    message: "L'adresse d'arrivée est obligatoire"
                },
                {
                    id: 'Nombre_Places',
                    validate: value => value !== '' && !isNaN(value) && parseInt(value) >= 1,
                    message: "Nombre de places invalide (minimum 1)"
                },
                {
                    id: 'Prix',
                    validate: value => value !== '' && !isNaN(value) && parseFloat(value) >= 0,
                    message: "Prix invalide"
                },
                {
                    id: 'Distance',
                    validate: value => value !== '' && !isNaN(value) && parseFloat(value) >= 0.1,
                    message: "Distance invalide (minimum 0.1 km)"
                },
                {
                    id: 'Duree',
                    validate: value => value !== '' && !isNaN(value) && parseInt(value) >= 1,
                    message: "Durée invalide (minimum 1 minute)"
                }
            ];

            // Function to show error message
            function showError(inputId, message) {
                const errorMessage = document.getElementById(`error-${inputId}`);
                const input = document.getElementById(inputId);
                
                if (errorMessage && input) {
                    errorMessage.textContent = message;
                    errorMessage.classList.add('show');
                    input.classList.add('is-invalid');
                }
            }

            // Function to clear all errors
            function clearErrors() {
                validationRules.forEach(rule => {
                    const errorMessage = document.getElementById(`error-${rule.id}`);
                    const input = document.getElementById(rule.id);
                    if (errorMessage && input) {
                        errorMessage.classList.remove('show');
                        errorMessage.textContent = '';
                        input.classList.remove('is-invalid');
                    }
                });
            }

            // Form submission handler
            form.addEventListener('submit', function (event) {
                let isValid = true;
                clearErrors();

                validationRules.forEach(rule => {
                    const input = document.getElementById(rule.id);
                    if (input && !rule.validate(input.value)) {
                        showError(rule.id, rule.message);
                        isValid = false;
                    }
                });

                if (!isValid) {
                    event.preventDefault();
                }
            });

            // Real-time validation on input
            validationRules.forEach(rule => {
                const input = document.getElementById(rule.id);
                if (input) {
                    input.addEventListener('input', function () {
                        const errorMessage = document.getElementById(`error-${rule.id}`);
                        if (!rule.validate(input.value)) {
                            showError(rule.id, rule.message);
                        } else {
                            errorMessage.classList.remove('show');
                            errorMessage.textContent = '';
                            input.classList.remove('is-invalid');
                        }
                    });
                }
            });

            // Handle success popup
            const popup = document.querySelector('.popup-success');
            if (popup) {
                setTimeout(() => popup.remove(), 3000);
            }

            // Initialize AOS animation
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true,
                offset: 100
            });

            // Initialize PureCounter
            new PureCounter();
        });
    </script>
</body>
</html>