<?php
require_once 'C:/xampp/htdocs/webproj/config.php';
session_start();

// Initialisation
$errors = [];
$success = "";
$values = [
    'Telephone' => '',
    'Categorie' => '',
    'DateReservation' => '',
    'Paiement' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nettoyage des champs
    $telephone = isset($_POST['Telephone']) ? trim($_POST['Telephone']) : '';
    $categorie = isset($_POST['Categorie']) ? trim($_POST['Categorie']) : '';
    $dateReservation = isset($_POST['DateReservation']) ? trim($_POST['DateReservation']) : '';
    $paiement = isset($_POST['Paiement']) ? trim($_POST['Paiement']) : '';

    // Sauvegarde pour réaffichage en cas d’erreur
    $values['Telephone'] = $telephone;
    $values['Categorie'] = $categorie;
    $values['DateReservation'] = $dateReservation;
    $values['Paiement'] = $paiement;

    // Validation
    if (!preg_match('/^\d{8,}$/', $telephone)) {
        $errors['Telephone'] = "Le téléphone doit contenir au moins 8 chiffres.";
    }

    if (empty($categorie)) {
        $errors['Categorie'] = "Veuillez sélectionner une catégorie.";
    }

    if (empty($dateReservation)) {
        $errors['DateReservation'] = "Veuillez entrer une date de réservation.";
    }

    if (empty($paiement)) {
        $errors['Paiement'] = "Veuillez choisir un mode de paiement.";
    }

    // Si pas d'erreur, insertion
    if (empty($errors)) {
        try {
            $pdo = config::getConnexion();
            $stmt = $pdo->prepare("
                INSERT INTO inscription (Telephone, Categorie, DateReservation, Paiement)
                VALUES (:tel, :cat, :date, :pay)
            ");
            $stmt->execute([
                ':tel' => $telephone,
                ':cat' => $categorie,
                ':date' => $dateReservation,
                ':pay' => $paiement
            ]);

            $success = "Réservation créée avec succès!";
            $values = ['Telephone' => '', 'Categorie' => '', 'DateReservation' => '', 'Paiement' => ''];
        } catch (PDOException $e) {
            $errors['global'] = "Erreur base de données : " . $e->getMessage();
        }
    }
}
?><meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>EasyParki - Covoiturage</title>
  <meta name="description" content="Planifiez vos covoiturage en toute simplicité avec EasyParki">
  <meta name="keywords" content="trajet , inscription">

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
  --accent-color: #3a5cb3;        /* Bleu vif */
  --light-color: #f8fafc;         /* Fond très légèrement bleuté */
  --dark-color: #2d3748;          /* Texte foncé doux */
  --text-color: #4a5568;          /* Texte principal */
  --section-bg: #f5f7fa;          /* Arrière-plan des sections */
  --card-bg: #ffffff;             /* Fond des cartes */
  --border-color: rgba(0,0,0,0.08); /* Bordures subtiles */
  --gradient: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
}
    
    /* Header & Navigation */
    .header {
      background: rgba(255, 255, 255, 0.98);
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
      backdrop-filter: blur(10px);
    }
    
    .sitename {
  font-family: Arial, sans-serif; /* juste changer la police */
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
    
    /* About Section - Redesign */
    .about {
      padding: 100px 0;
      position: relative;
      overflow: hidden;
    }
    
    .about::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('assets/img/wave-bg.svg') center/cover no-repeat;
      opacity: 0.03;
      z-index: -1;
    }
    
    .about h3 {
      font-family: Arial, sans-serif;
      color: var(--secondary-color);
      font-size: 2.5rem;
      margin-bottom: 30px;
      position: relative;
      display: inline-block;
    }
    
    .about h3:after {
      content: '';
      position: absolute;
      bottom: -15px;
      left: 0;
      width: 100px;
      height: 4px;
      background: var(--gradient);
      border-radius: 2px;
    }
    
    .about .features-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
      margin-top: 50px;
    }
    
    .feature-card {
      background: white;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
      transition: all 0.4s ease;
      border: 1px solid rgba(0,0,0,0.03);
    }
    
    .feature-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }
    
    .feature-icon {
      width: 70px;
      height: 70px;
      background: rgba(13, 63, 114, 0.1);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
      color: var(--primary-color);
      font-size: 1.8rem;
    }
    
    .feature-card h4 {
      font-weight: 600;
      margin-bottom: 15px;
      color: var(--secondary-color);
    }
    
    /* Stats Section - Redesign */
    .stats {
      padding: 100px 0;
      background: var(--gradient);
      color: white;
      position: relative;
      overflow: hidden;
    }
    
    .stats::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('assets/img/dots-bg.png') center/cover no-repeat;
      opacity: 0.1;
    }
    
    .stats-item {
      padding: 40px 30px;
      border-radius: 15px;
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(5px);
      transition: all 0.4s ease;
      text-align: center;
      border: 1px solid rgba(255,255,255,0.1);
    }
    
    .stats-item:hover {
      transform: translateY(-10px);
      background: rgba(255, 255, 255, 0.15);
    }
    
    .stats-item span {
      font-size: 3rem;
      font-weight: 700;
      display: block;
      margin-bottom: 10px;
      background: linear-gradient(to right, #fff, #e0f1ff);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
    
    /* Testimonials - Redesign */
    .testimonials {
      padding: 120px 0;
      background: linear-gradient(135deg, #f8faff 0%, #f0f7ff 100%);
    }
    
    .testimonial-card {
      background: white;
      padding: 40px 30px;
      border-radius: 20px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
      transition: all 0.4s ease;
      height: 100%;
      position: relative;
      overflow: hidden;
      border: 1px solid rgba(0,0,0,0.03);
    }
    
    .testimonial-card::before {
      content: '"';
      position: absolute;
      top: 20px;
      right: 30px;
      font-size: 100px;
      font-family: 'Playfair Display', serif;
      color: rgba(13, 63, 114, 0.05);
      line-height: 1;
    }
    
    .testimonial-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 50px rgba(0, 0, 0, 0.1);
    }
    
    .testimonial-img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      object-fit: cover;
      border: 3px solid white;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }
    
    .stars {
      color: #ffc107;
      margin-bottom: 15px;
      font-size: 1.1rem;
    }
    
    /* CTA Section - Redesign */
    .cta-section {
      padding: 100px 0;
      background: url('assets/img/cta-bg.jpg') center/cover no-repeat;
      position: relative;
      text-align: center;
    }
    
    .cta-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(13, 63, 114, 0.9);
    }
    
    .cta-content {
      position: relative;
      z-index: 2;
    }
    
    .cta-btn {
      background: white;
      color: var(--primary-color);
      font-weight: 600;
      padding: 15px 40px;
      border-radius: 50px;
      transition: all 0.3s ease;
      display: inline-block;
      margin-top: 20px;
    }
    
    .cta-btn:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 30px rgba(255,255,255,0.3);
    }
    
    /* FAQ Section - Redesign */
    .faq-section {
      padding: 100px 0;
      background: #f9fbfe;
    }
    
    .faq-item {
      margin-bottom: 15px;
      border-radius: 12px;
      background: white;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.03);
      overflow: hidden;
      transition: all 0.3s ease;
      border: 1px solid rgba(0,0,0,0.03);
    }
    
    .faq-item:hover {
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }
    
    .faq-item h3 {
      padding: 20px 25px;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin: 0;
      font-size: 1.1rem;
      color: var(--secondary-color);
      font-weight: 500;
      transition: all 0.3s ease;
    }
    
    .faq-item:hover h3 {
      color: var(--primary-color);
    }
    
    .faq-item.active h3 {
      color: var(--primary-color);
    }
    
    .faq-content {
      padding: 0 25px;
      max-height: 0;
      overflow: hidden;
      transition: all 0.4s ease;
    }
    
    .faq-item.active .faq-content {
      padding: 0 25px 25px;
      max-height: 500px;
    }
    
    .faq-toggle {
      transition: transform 0.3s ease;
    }
    
    .faq-item.active .faq-toggle {
      transform: rotate(180deg);
    }
    
    /* Footer - Redesign */
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
      
      .about h3, .section-title h2 {
        font-size: 2rem;
      }
    }
    
    /* Section Title */
    .section-title {
      text-align: center;
      margin-bottom: 60px;
    }
    
    .section-title span {
      color: var(--primary-color);
      font-size: 1rem;
      font-weight: 600;
      letter-spacing: 1px;
      display: block;
      margin-bottom: 15px;
      text-transform: uppercase;
    }
    
    .section-title h2 {
      font-family: Arial, sans-serif;
      color: var(--secondary-color);
      font-size: 2.5rem;
      margin-bottom: 20px;
    }
    
    .section-title p {
      max-width: 700px;
      margin: 0 auto;
      color: #666;
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
    
    /* Floating Get Started Button */
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
    
    /* Destination Gallery */
    .destination-gallery {
      padding: 100px 0;
      background: #f9fbfe;
    }
    
    .destination-card {
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
      transition: all 0.4s ease;
      margin-bottom: 30px;
      position: relative;
    }
    
    .destination-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }
    
    .destination-img {
      height: 250px;
      object-fit: cover;
      width: 100%;
      transition: transform 0.5s ease;
    }
    
    .destination-card:hover .destination-img {
      transform: scale(1.05);
    }
    
    .destination-info {
      padding: 20px;
      background: white;
      position: relative;
    }
    
    .destination-info h4 {
      margin-bottom: 10px;
      color: var(--secondary-color);
    }
    
    .destination-info p {
      color: #666;
      margin-bottom: 15px;
    }
    
    .price-tag {
      position: absolute;
      top: -20px;
      right: 20px;
      background: var(--gradient);
      color: white;
      padding: 8px 15px;
      border-radius: 50px;
      font-weight: 600;
      box-shadow: 0 5px 15px rgba(13, 63, 114, 0.3);
    }
    
    /* How It Works */
    .how-it-works {
      padding: 100px 0;
      position: relative;
      overflow: hidden;
    }
    
    .how-it-works::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: url('assets/img/dots-pattern.png') center/cover no-repeat;
      opacity: 0.05;
      z-index: -1;
    }
    
    .step-card {
      background: white;
      border-radius: 15px;
      padding: 40px 30px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
      transition: all 0.4s ease;
      height: 100%;
      text-align: center;
      position: relative;
      border: 1px solid rgba(0,0,0,0.03);
    }
    
    .step-number {
      width: 60px;
      height: 60px;
      background: rgba(13, 63, 114, 0.1);
      color: var(--primary-color);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      font-weight: 700;
      margin: 0 auto 20px;
      transition: all 0.3s ease;
    }
    
    .step-card:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
    }
    
    .step-card:hover .step-number {
      background: var(--gradient);
      color: white;
      transform: scale(1.1);
    }
    
    /* Newsletter */
    .newsletter {
      padding: 80px 0;
      background: var(--gradient);
      color: white;
      text-align: center;
    }
    
    .newsletter-form {
      max-width: 600px;
      margin: 40px auto 0;
      display: flex;
      background: white;
      border-radius: 50px;
      overflow: hidden;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }
    
    .newsletter-input {
      flex: 1;
      border: none;
      padding: 15px 25px;
      outline: none;
      font-size: 1rem;
    }
    
    .newsletter-btn {
      background: var(--secondary-color);
      color: white;
      border: none;
      padding: 15px 30px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    
    .newsletter-btn:hover {
      background: #08172f;
    }
    /* Effet de carte amélioré */
.destination-card {
  background: var(--card-bg);
  border-radius: 16px;
  overflow: hidden;
  box-shadow: 0 15px 40px rgba(0,0,0,0.1);
  transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  position: relative;
}

.destination-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: var(--gradient);
  opacity: 0;
  transition: opacity 0.3s ease;
  z-index: 1;
}

.destination-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 25px 60px rgba(0,0,0,0.15);
}

.destination-card:hover::before {
  opacity: 0.03;
}

/* Animation du badge */
.card-badge {
  position: absolute;
  top: 20px;
  right: 20px;
  background: var(--gradient);
  color: white;
  padding: 6px 15px;
  border-radius: 50px;
  font-weight: 600;
  animation: pulse 2s infinite;
}

@keyframes pulse {
  0% { transform: scale(1); }
  50% { transform: scale(1.05); }
  100% { transform: scale(1); }
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
            <a href="transport public.html" class="active">covoiturage</a>
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
                 Accéder à mon inscrption
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

    <!-- Hero Section -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/55.png);">
      <div class="container position-relative">
        <h1>Covoiturages</h1>
        <p>Partez à l'aventure et vivez des souvenirs mémorables grâce à notre service.</p>
        
      </div>
    </div><!-- End Hero Section -->

   



  

   
 

 
  
<style>
  .testimonial-card {
    padding: 30px;
    border-radius: 16px;
    box-shadow: 0 15px 40px rgba(13, 63, 114, 0.1);
    transition: all 0.4s ease;
    height: 100%;
    position: relative;
    overflow: hidden;
  }

  .testimonial-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: var(--gradient);
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .testimonial-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(13, 63, 114, 0.2);
  }

  .testimonial-card:hover::before {
    opacity: 1;
  }

  .testimonial-header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
    position: relative;
  }

  .testimonial-img {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(255,255,255,0.3);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    margin-right: 15px;
  }

  .testimonial-author h3 {
    margin: 0;
    color: var(--secondary-color);
    font-size: 1.2rem;
  }

  .testimonial-author span {
    color: var(--accent-color);
    font-size: 0.8rem;
    font-weight: 500;
  }

  .quote-icon {
    position: absolute;
    right: 0;
    top: 0;
  }

  .stars {
    color: #FFC107;
    margin-bottom: 15px;
    font-size: 1.1rem;
  }

  .testimonial-text {
    font-style: italic;
    color: var(--text-color);
    line-height: 1.7;
    margin-bottom: 20px;
    position: relative;
    padding-left: 20px;
  }

  .testimonial-text::before {
    content: '"';
    position: absolute;
    left: 0;
    top: -10px;
    font-size: 3rem;
    color: var(--accent-color);
    opacity: 0.2;
    font-family: serif;
  }

  .testimonial-footer {
    display: flex;
    align-items: center;
    color: var(--text-color);
    font-size: 0.8rem;
    gap: 5px;
  }

  /* Animation des slides */
  .swiper-slide {
    opacity: 0.7;
    transition: opacity 0.3s ease, transform 0.3s ease;
    transform: scale(0.95);
  }

  .swiper-slide-active {
    opacity: 1;
    transform: scale(1);
  }
</style>
    </section><!-- End Testimonials Section -->

 
   

<style>
  /* Style pour la nouvelle section inspiration + newsletter */
  .inspiration-section {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 20px 50px rgba(0,0,0,0.1);
    margin: 80px auto;
    max-width: 1400px;
  }
  
  .inspiration-col, .newsletter-col {
    min-height: 500px;
    position: relative;
  }
  
  .inspiration-col {
    background-size: cover;
    background-position: center;
  }
  
  .inspiration-overlay {
    background: linear-gradient(135deg, rgba(13,63,114,0.85) 0%, rgba(10,29,55,0.😎 100%);
    padding: 60px;
    height: 100%;
    color: white;
  }
  
  .inspiration-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    margin: 30px 0;
  }
  
  .inspiration-card {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(5px);
    padding: 25px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.15);
    transition: all 0.3s ease;
  }
  
  .inspiration-card:hover {
    transform: translateY(-5px);
    background: rgba(255,255,255,0.15);
  }
  
  .inspiration-card i {
    font-size: 2rem;
    color: var(--accent-color);
    margin-bottom: 15px;
    display: block;
  }
  
  .newsletter-wrapper {
    padding: 60px;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }
  
  .newsletter-header {
    text-align: center;
    margin-bottom: 40px;
    color: white;
  }
  
  .newsletter-icon {
    font-size: 3rem;
    color: var(--accent-color);
    margin-bottom: 20px;
  }
  
  .modern-newsletter-form {
    max-width: 500px;
    margin: 0 auto;
    width: 100%;
  }
  
  .input-group {
    display: flex;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    border-radius: 50px;
    overflow: hidden;
  }
  
  .form-control {
    padding: 15px 25px;
    border: none;
    background: rgba(255,255,255,0.9);
  }
  
  .btn-primary {
    background: var(--accent-color);
    border: none;
    padding: 15px 30px;
    white-space: nowrap;
  }
  
  .form-footer {
    margin-top: 15px;
    color: rgba(255,255,255,0.8);
    font-size: 0.8rem;
  }
  
  .trust-badges {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 30px;
  }
  
  .badge-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: rgba(255,255,255,0.8);
    font-size: 0.9rem;
  }
  
  /* Style pour le nouveau CTA immersif */
  .immersion-cta {
    position: relative;
    height: 600px;
    border-radius: 16px;
    overflow: hidden;
    margin: 80px auto;
    max-width: 1400px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.2);
  }
  
  .cta-video-wrapper {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
  }
  
  .cta-video-wrapper video {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  
  .cta-video-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(13,63,114,0.7) 0%, rgba(10,29,55,0.6) 100%);
  }
  
  .cta-content-wrapper {
    position: relative;
    height: 100%;
    display: flex;
    align-items: center;
  }
  
  .cta-content {
    text-align: center;
    color: white;
    max-width: 800px;
    margin: 0 auto;
  }
  
  .cta-subtitle {
    font-size: 1.2rem;
    margin-bottom: 30px;
    opacity: 0.9;
  }
  
  .cta-buttons {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-bottom: 40px;
  }
  
  .cta-features {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin-top: 20px;
  }
  
  .feature-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 1.1rem;
  }
  
  @media (max-width: 992px) {
    .inspiration-section .row {
      flex-direction: column;
    }
    
    .inspiration-col, .newsletter-col {
      min-height: auto;
      padding: 60px 30px;
    }
    
    .cta-buttons {
      flex-direction: column;
      gap: 15px;
    }
    
    .immersion-cta {
      height: auto;
      padding: 100px 0;
    }
  }
</style>
<style>
        .invalid-feedback {
            display: block;
            font-size: 0.9em;
        }

        .popup-success {
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            padding: 20px 30px;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            font-size: 1.2em;
            text-align: center;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            display: none;
            animation: fadeInOut 5s ease-in-out forwards;
        }

        @keyframes fadeInOut {
            0% { opacity: 0; }
            10% { opacity: 1; display: block; }
            90% { opacity: 1; }
            100% { opacity: 0; display: none; }
        }
    </style>
<div class="container py-5">
    <h1 class="mb-4">Réserver un Covoiturage</h1>

    <?php if (!empty($success)) : ?>
        <div class="popup-success" id="successPopup"><?= $success ?></div>
    <?php endif; ?>

    <?php if (!empty($errors['global'])) : ?>
        <div class="alert alert-danger"><?= $errors['global'] ?></div>
    <?php endif; ?>

    <form method="POST">
        <!-- Téléphone -->
        <div class="mb-3">
            <label class="form-label">Téléphone</label>
            <input type="text" name="Telephone" class="form-control <?= isset($errors['Telephone']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($values['Telephone']) ?>">
            <?php if (isset($errors['Telephone'])): ?>
                <div class="invalid-feedback"><?= $errors['Telephone'] ?></div>
            <?php endif; ?>
        </div>

        <!-- Catégorie -->
        <div class="mb-3">
            <label class="form-label">Catégorie</label>
            <select name="Categorie" class="form-select <?= isset($errors['Categorie']) ? 'is-invalid' : '' ?>">
                <option value="">-- Choisir --</option>
                <option value="Privé" <?= $values['Categorie'] == 'Privé' ? 'selected' : '' ?>>Privé</option>
                <option value="Public" <?= $values['Categorie'] == 'Public' ? 'selected' : '' ?>>Public</option>
            </select>
            <?php if (isset($errors['Categorie'])): ?>
                <div class="invalid-feedback"><?= $errors['Categorie'] ?></div>
            <?php endif; ?>
        </div>

        <!-- Date de Réservation -->
        <div class="mb-3">
            <label class="form-label">Date de Réservation</label>
            <input type="datetime-local" name="DateReservation" class="form-control <?= isset($errors['DateReservation']) ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars($values['DateReservation']) ?>">
            <?php if (isset($errors['DateReservation'])): ?>
                <div class="invalid-feedback"><?= $errors['DateReservation'] ?></div>
            <?php endif; ?>
        </div>

        <!-- Paiement -->
        <div class="mb-3">
            <label class="form-label">Mode de Paiement</label>
            <select name="Paiement" class="form-select <?= isset($errors['Paiement']) ? 'is-invalid' : '' ?>">
                <option value="">-- Choisir --</option>
                <option value="Carte" <?= $values['Paiement'] == 'Carte' ? 'selected' : '' ?>>Carte</option>
                <option value="Espece" <?= $values['Paiement'] == 'Espece' ? 'selected' : '' ?>>Espèce</option>
            </select>
            <?php if (isset($errors['Paiement'])): ?>
                <div class="invalid-feedback"><?= $errors['Paiement'] ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary w-100">Confirmer la réservation</button>
    </form>
</div>

<script>
    window.addEventListener('DOMContentLoaded', function () {
        const popup = document.getElementById('successPopup');
        if (popup) {
            popup.style.display = 'block';
            setTimeout(() => {
                popup.style.display = 'none';
            }, 4000); // 4 secondes
        }
    });
</script>
  <!-- Floating Button -->
  <a href="addplanVacancefront.php" class="floating-btn" data-aos="fade-up" data-aos-delay="300" title="Commencer à planifier">
    <i class="bi bi-calendar-plus"></i>
  </a>

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

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Main JS File -->
  <script src="assets/js/main.js"></script>

  <script>
    // FAQ Toggle
    document.querySelectorAll('.faq-item h3').forEach(question => {
      question.addEventListener('click', () => {
        const item = question.parentElement;
        const content = question.nextElementSibling;
        const icon = question.querySelector('.faq-toggle');
        
        item.classList.toggle('active');
        
        if (item.classList.contains('active')) {
          content.style.maxHeight = content.scrollHeight + 'px';
          icon.classList.replace('bi-chevron-down', 'bi-chevron-up');
        } else {
          content.style.maxHeight = '0';
          icon.classList.replace('bi-chevron-up', 'bi-chevron-down');
        }
        
        // Close other open items
        document.querySelectorAll('.faq-item').forEach(otherItem => {
          if (otherItem !== item && otherItem.classList.contains('active')) {
            otherItem.classList.remove('active');
            otherItem.querySelector('.faq-content').style.maxHeight = '0';
            otherItem.querySelector('.faq-toggle').classList.replace('bi-chevron-up', 'bi-chevron-down');
          }
        });
      });
    });
    
    // Initialize AOS animation
    AOS.init({
      duration: 800,
      easing: 'ease-in-out',
      once: true,
      offset: 100
    });
    
    // Initialize PureCounter
    new PureCounter();
    
    // Initialize Swiper
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.init-swiper').forEach(swiperEl => {
        const config = JSON.parse(swiperEl.querySelector('.swiper-config').textContent);
        new Swiper(swiperEl, config);
      });
    });
  </script>

</body>


    