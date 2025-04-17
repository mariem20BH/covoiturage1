<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>covoiturage - Easyparki Bootstrap Template</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="assets/css/main.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Logis
  * Template URL: https://bootstrapmade.com/logis-bootstrap-logistics-website-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="covoiturage-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="index.html" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <h1 class="sitename">EasyParki</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="index.html">Home<br></a></li>
          <li><a href="covoiturage.php" class="active">Stationnement</a></li>
          <li><a href="services.php">Services</a></li>
          <li><a href="pricing.html">Vacances</a></li>
          <li><a href="pricing.html">Evenement</a></li>
          <li><a href="covoiturage.php">Covoiturage</a></li>
          <li><a href="cantact.html">Cantact</a></li>
          
        
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted" href="créeuncompte.php">créer un compte</a>

    </div>
  </header>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title dark-background" data-aos="fade" style="background-image: url(assets/img/page-title-bg.jpg);">
      <div class="container position-relative">
        <h1>Covoiturage</h1>
        <p>Share the journey, split the costs,and leave the solo driving in the reaview mirror.</p>
        <nav class="breadcrumbs">
          <ol>
            <li><a href="index.html">Home</a></li>
            <li class="current">Covoiturage</li>
          </ol>
        </nav>
      </div>
    </div><!-- End Page Title -->
    <!-- Section Covoiturage -->
  <
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 col-md-12">
        <!-- Formulaire d'ajout d'inscription -->
        






















   



       
       


       


 


        <?php
session_start();
require_once 'C:/xampp/htdocs/webproj/controller/InscriptionC.php';
require_once 'C:/xampp/htdocs/webproj/model/Inscription.php';
require_once 'C:/xampp/htdocs/webproj/config.php'; // connexion centralisée
$pdo = config::getConnexion();
if (isset($_POST['addInscription'])) {
  // Récupérer les données du formulaire
  $telephone = $_POST['Telephone'];  // C’est une string maintenant
  $categorie = $_POST['Categorie'];
  $dateReservation = $_POST['DateReservation'];
  $paiement = $_POST['Paiement'];

  // Validation de la donnée (format du téléphone)
  if (!preg_match('/^\d{8,15}$/', $telephone)) {
      header("Location: covoiturage.php?error=telephone_format");
      exit();
  }

  // Vérification si le téléphone existe déjà dans la base
  $stmt = $pdo->prepare("SELECT COUNT(*) FROM inscription WHERE Telephone = ?");
  $stmt->execute([$telephone]);
  $count = $stmt->fetchColumn();

  if ($count > 0) {
      header("Location: covoiturage.php?error=telephone_existe");
      exit();
  } else {
      // Si le téléphone n'existe pas, on crée une nouvelle inscription
      $inscription = new Inscription($telephone, $categorie, $dateReservation, $paiement);
      $inscriptionC = new InscriptionC();
      $lastID = $inscriptionC->ajouterInscriptionAvecRetourID($inscription);

      // Rediriger avec succès
      $_SESSION['last_insert_id'] = $lastID;
      header("Location: covoiturage.php?success=true");
      exit();
  }
}


// ▶ Suppression
if (isset($_POST['deleteInscription'])) {
    $id = $_POST['delete_id'];
    $inscriptionC = new InscriptionC();
    $inscriptionC->DeleteInscription($id);
    unset($_SESSION['last_insert_id']);
    header("Location: covoiturage.php?deleted=true");
    exit();
}
?>

<?php
// Messages d'alerte
if (isset($_GET['error'])) {
    switch ($_GET['error']) {
        case 'telephone_existe':
            echo "<script>alert('Ce numéro de téléphone est déjà utilisé.');</script>";
            break;
        case 'telephone_format':
            echo "<script>alert('Le numéro doit contenir au moins 8 chiffres.');</script>";
            break;
    }
}
if (isset($_GET['success']) && $_GET['success'] === 'true') {
    echo "<script>alert('Inscription ajoutée avec succès !');</script>";
}
if (isset($_GET['deleted']) && $_GET['deleted'] === 'true') {
    echo "<script>alert('Inscription supprimée avec succès.');</script>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscriptions Covoiturage</title>
    <style>
       /* Palette bleu nude */
:root {
    --nude-blue: #c8ddee;
    --deep-blue: #4a90e2;
    --light-blue: #ecf4fb;
    --accent-blue: #b0c9e8;
    --white: #ffffff;
    --shadow: rgba(0, 0, 0, 0.1);
}

/* Form Container */
.form-container {
    background: var(--light-blue);
    padding: 2rem;
    border-radius: 20px;
    box-shadow: 0 10px 25px var(--shadow);
    font-family: 'Segoe UI', sans-serif;
    transition: transform 0.3s ease;
}
.form-container:hover {
    transform: scale(1.01);
}

/* Form Title */
.form-container h4,
.form-container h2 {
    color: var(--deep-blue);
    margin-bottom: 1.5rem;
    font-weight: 600;
    text-align: center;
}

/* Group */
.form-group {
    margin-bottom: 1.2rem;
}

.form-group label {
    display: block;
    color: var(--deep-blue);
    margin-bottom: 0.4rem;
    font-weight: 500;
}

/* Inputs */
.form-group input,
.form-group select {
    width: 100%;
    padding: 0.50rem;
    border: 1px solid var(--accent-blue);
    border-radius: 10px;
    background-color: var(--white);
    font-size: 1rem;
    transition: border-color 0.3s ease;
}
.form-group input:focus,
.form-group select:focus {
    border-color: var(--deep-blue);
    outline: none;
    box-shadow: 0 0 5px var(--deep-blue);
}

/* Radio Buttons */
.form-row label {
    margin-right: 15px;
    color: #555;
    font-weight: 500;
}
.form-row input[type="radio"] {
    margin-right: 5px;
}

/* Button */
.btn-submit,
.btn-success,
.btn-primary {
    background: var(--deep-blue);
    color: var(--white);
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 30px;
    font-weight: bold;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.2s ease;
}
.btn-submit:hover,
.btn-success:hover,
.btn-primary:hover {
    background: #3a7ec4;
    transform: scale(1.05);
}

/* Alert */
.alert-success {
    background-color: #dff0d8;
    border: 1px solid #a1c99a;
    color: #3c763d;
    padding: 1rem;
    border-radius: 8px;
    margin-bottom: 1rem;
    text-align: center;
}

/* Icon labels */
.icon-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 500;
    color: var(--deep-blue);
    margin-bottom: 0.3rem;
}

/* Responsive Design */
@media (max-width: 768px) {
    .form-container {
        padding: 1rem;
    }
    .form-group input,
    .form-group select {
        font-size: 0.95rem;
    }
}

    </style>
</head>
<body>

<!-- Formulaire d'ajout -->
<div class="form-container mt-4">
    <h4>🏭 Inscription de Covoiturage</h4>

    <div class="container mt-4">
        <div class="card-header bg-primary text-white">Ajouter une inscription</div>
        <div class="card-body">
            <?php if (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
                <div class="alert alert-success">Ajout avec succès !</div>
            <?php endif; ?>

            <form action="covoiturage.php" method="POST">
                <div class="form-group">
                    <div class="icon-label">
                        <span>📞</span>
                        <label>Telephone <span style="color:red">*</span></label>
                    </div>
                    <input type="tel" name="Telephone" id="Telephone" pattern="[0-9]{8,}" title="Entrez au moins 8 chiffres" required>
                </div>

                <div class="form-group">
                    <div class="icon-label">
                        <span>🏷️</span>
                        <label>Categorie <span style="color:red">*</span></label>
                    </div>
                    <div class="form-row">
                        <label><input type="radio" name="Categorie" value="Privé" checked> Privé</label>
                        <label><input type="radio" name="Categorie" value="Public"> Public</label>
                    </div>
                </div>

                <div class="form-group">
                    <div class="icon-label">
                        <span>📅</span>
                        <label>DateReservation <span style="color:red">*</span></label>
                    </div>
                    <input type="datetime-local" name="DateReservation" required>
                </div>

                <div class="form-group">
                    <div class="icon-label">
                        <span>💳</span>
                        <label>Paiement <span style="color:red">*</span></label>
                    </div>
                    <div class="form-row">
                        <label><input type="radio" name="Paiement" value="Carte" checked> Carte</label>
                        <label><input type="radio" name="Paiement" value="Espece"> Espece</label>
                    </div>
                </div>

                <div class="form-group" style="display: flex; justify-content: space-between;">
                    <button type="submit" name="addInscription" class="btn btn-success">Ajouter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Suppression -->
<?php if (isset($_SESSION['last_insert_id'])): ?>
    <form method="post" style="margin-top: 20px;">
        <input type="hidden" name="delete_id" value="<?= $_SESSION['last_insert_id'] ?>">
        <button type="submit" name="deleteInscription" class="btn btn-danger">❌ Supprimer mon inscription</button>
    </form>
<?php endif; ?>

<!-- Recherche -->
<form method="GET" action="covoiturage.php" style="margin-top: 40px;">
    <h2 class="text-center text-primary mb-4">🔍 Rechercher votre inscription</h2>
    
    <!-- Champ de recherche -->
    <div class="form-group">
        <label for="searchTel">Numéro de téléphone</label>
        <input type="tel" name="searchTel" id="searchTel" class="form-control" required pattern="[0-9]{8,}" title="10 chiffres requis" placeholder="Entrez un numéro de téléphone">
    </div>
    
    <!-- Bouton de soumission -->
    <div class="form-group text-center">
        <button type="submit" class="btn btn-primary">Rechercher</button>
    </div>
</form>

<!-- Lien vers Bootstrap 4 -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">


<?php
// Affichage du formulaire de modification
if (isset($_GET['searchTel'])) {
    $searchTel = $_GET['searchTel'];

    $stmt = $pdo->prepare("SELECT * FROM inscription WHERE Telephone = ?");
    $stmt->execute([$searchTel]);
    $inscription = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($inscription) {
?>

<div class="container">
    <div class="form-container">
        <h2>✏️ Modifier votre inscription</h2>
        <form method="POST" action="covoiturage.php">
            <input type="hidden" name="id_inscription" value="<?= $inscription['ID'] ?>">

            <div class="form-group">
                <label for="Telephone">Telephone</label>
                <input type="tel" id="Telephone" name="Telephone"
                    value="<?= htmlspecialchars($inscription['Telephone']) ?>"
                    required pattern="[0-9]{8,}" placeholder="Entrez votre numéro de téléphone">
            </div>

            <div class="form-group">
                <label for="Categorie">Categorie</label>
                <select id="Categorie" name="Categorie" class="form-control" required>
                    <option value="Public" <?= ($inscription['Categorie'] === 'Public') ? 'selected' : '' ?>>🚍 Public</option>
                    <option value="Privé" <?= ($inscription['Categorie'] === 'Privé') ? 'selected' : '' ?>>🚗 Privé</option>
                </select>
            </div>
            <div class="form-group">
                <label for="DateReservation">DateRéservation</label>
                <input type="datetime-local" id="DateReservation" name="DateReservation"
                    value="<?= date('Y-m-d\TH:i', strtotime($inscription['DateReservation'])) ?>" required>
            </div>


            <div class="form-group">
                <label for="Paiement"> Paiement</label>
                <select id="Paiement" name="Paiement" class="form-control" required>
                    <option value="Carte" <?= ($inscription['Paiement'] === 'Carte') ? 'selected' : '' ?>>💳 Carte</option>
                    <option value="Espece" <?= ($inscription['Paiement'] === 'Espece') ? 'selected' : '' ?>>💵 Espèce</option>
                </select>
            </div>

            <button type="submit" name="submit_update" class="btn-submit">✅ Modifier</button>
        </form>
    </div>
</div>

<?php
    } else {
        echo "<p style='color:red;'>Aucune inscription trouvée avec ce numéro.</p>";
    }
}

// Traitement de la mise à jour
if (isset($_POST['submit_update'])) {
    $id = $_POST['id_inscription'];
    $telephone = $_POST['Telephone'];
    $categorie = $_POST['Categorie'];
    $paiement = $_POST['Paiement'];

    $check = $pdo->prepare("SELECT COUNT(*) FROM inscription WHERE Telephone = ?");
    $check->execute([$telephone]);
    if ($check->fetchColumn() > 0) {
        $update = $pdo->prepare("UPDATE inscription SET Telephone = ?, Categorie = ?, Paiement = ? WHERE ID = ?");
        $update->execute([$telephone, $categorie, $paiement, $id]);

        echo "<script>alert('Inscription mise à jour avec succès.'); window.location.href='covoiturage.php';</script>";
    } else {
        echo "<script>alert('Erreur : numéro de téléphone introuvable.');</script>";
    }
}
?>

</body>
</html>



 


        <!-- About Section -->
    <section id="Covoiturage" class="covoiturage section">

<div class="container">

        <div class="row gy-4">
          <!-- Colonne pour le texte -->
          <div class="col-lg-6 content order-lg-first order-last" data-aos="fade-up" data-aos-delay="100">
            <h3>Bienvenue !</h3>
            <p>
              Vivez une expérience unique avec notre programme de récompenses, restez informé grâce aux notifications, suivez vos trajets avec des statistiques, et profitez d’un support interactif. Planifiez facilement avec notre calendrier intelligent et laissez-vous guider par des suggestions personnalisées. Simple, fluide, et sur-mesure.
            </p>
            <ul>
              <li>
                <i class="bi bi-diagram-3"></i>
                <div>
                  <h5>Système de notifications</h5>
                  <p>Essentiel pour tenir les utilisateurs informés en temps réel des mises à jour sur leurs trajets, des changements de planning ou des alertes importantes.</p>
                </div>
              </li>
              <li>
                <i class="bi bi-fullscreen-exit"></i>
                <div>
                  <h5>Suggestions intelligentes de trajet</h5>
                  <p>Une fonctionnalité clé pour recommander des trajets optimisés en fonction des préférences des utilisateurs, de leur historique, et des conditions de circulation.</p>
                </div>
              </li>
              <li>
                <i class="bi bi-broadcast"></i>
                <div>
                  <h5>Système de notation et avis</h5>
                  <p>Crucial pour instaurer un climat de confiance entre conducteurs et passagers, permettant à chacun d’évaluer l’expérience et de garantir un service de qualité.</p>
                </div>
              </li>
            </ul>
          </div>
        
          <!-- Colonne pour l'image -->
          <div class="col-lg-6 position-relative align-self-start order-lg-last order-first" data-aos="fade-up" data-aos-delay="200">
            <img src="assets/img/covoiturage.jpg" class="img-fluid" alt="Image de covoiturage">
          </div>
        </div>
        

        </div>

      </div>

    </section><!-- /About Section -->

    
    <section id="FONC" class="fonc">
      <div class="container" data-aos="fade-up">
    
        <!-- Section Title -->
        <div class="section-title">
          <h2>Fonctionnalités</h2>
          <p>Un aperçu rapide des fonctionnalités principales de notre plateforme</p>
        </div>
    
        <!-- Images alignées horizontalement -->
        <div class="row text-center mb-4">
          <div class="col-md-4">
            <img src="assets/img/solde.png.jpg" alt="Solde" class="img-fluid mb-2" style="max-height: 100px;">
            <h5>Solde</h5>
          </div>
          <div class="col-md-4">
            <img src="assets/img/calendrier.png.jpg" alt="Calendrier" class="img-fluid mb-2" style="max-height: 100px;">
            <h5>Calendrier</h5>
          </div>
          <div class="col-md-4">
            <img src="assets/img/state.png.avif" alt="Statistiques" class="img-fluid mb-2" style="max-height: 100px;">
            <h5>Statistiques</h5>
          </div>
        </div>
    
        <!-- Liste de fonctionnalités -->
        <div class="row">
          <div class="col-md-12">
            <ul style="list-style-type: disc; padding-left: 20px;">
              <li>Programme de récompense pour les covoiturages</li>
              <li>Système de notification</li>
              <li>Génération d'un historique en PDF</li>
              <li>Statistiques</li>
              <li>Système de notification et avis</li>
              <li>Carte interactive</li>
              <li>Calendrier</li>
              <li>Suggestion intelligente de trajets</li>
            </ul>
          </div>
        </div>
    
      </div>
    </section>
    




    <!-- Team Section -->
    <section id="nos sponsors" class="sponsors section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <span>Nos sponsors<br></span>
        <h2>Nos sponsors</h2>
        <p>Nous remercions chaleureusement nos sponsors pour leur soutien précieux, contribuant activement au succès de notre projet.</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row">

          <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="100">
            <div class="member">
              <img src="assets/img/oreedoo.jpg" class="img-fluid" alt="">
              <div class="member-content">
                <h4>Ooredoo Tunisie</h4>
                
                <p>
                  Offrir des réductions sur les forfaits mobiles et promouvoir l'usage des données mobiles pour faciliter la connexion des utilisateurs.


                </p>
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="200">
            <div class="member">
              <img src="assets/img/biat.jpg" class="img-fluid" alt="">
              <div class="member-content">
                <h4>BIAT</h4>
                
                <p>
                  pourrait sponsoriser un service de covoiturage en proposant des solutions de paiement mobile, des prêts pour l'achat de véhicules et des avantages financiers pour les utilisateurs réguliers.
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

          <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up" data-aos-delay="300">
            <div class="member">
              <img src="assets/img/carefour.jpg" class="img-fluid" alt="">
              <div class="member-content">
                <h4>Carrefour Tunisie</h4>
                
                <p>
                  Fournir des promotions ou des bons d'achat pour encourager la participation des utilisateurs tout en boostant les ventes.

                </p>
                <div class="social">
                  <a href=""><i class="bi bi-twitter-x"></i></a>
                  <a href=""><i class="bi bi-facebook"></i></a>
                  <a href=""><i class="bi bi-instagram"></i></a>
                  <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
              </div>
            </div>
          </div><!-- End Team Member -->

        </div>

      </div>

    </section><!-- /Team Section -->

    <!-- Testimonials Section -->
    <section id="testimonials" class="testimonials section dark-background">

      <img src="assets/img/testimonials-bg.jpg" class="testimonials-bg" alt="">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
            {
              "loop": true,
              "speed": 600,
              "autoplay": {
                "delay": 5000
              },
              "slidesPerView": "auto",
              "pagination": {
                "el": ".swiper-pagination",
                "type": "bullets",
                "clickable": true
              }
            }
          </script>
          <div class="swiper-wrapper">

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-1.jpg" class="testimonial-img" alt="">
                <h3>Saul Goodman</h3>
                <h4>Ceo &amp; Founder</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Proin iaculis purus consequat sem cure digni ssim donec porttitora entum suscipit rhoncus. Accusantium quam, ultricies eget id, aliquam eget nibh et. Maecen aliquam, risus at semper.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                <h3>Sara Wilsson</h3>
                <h4>Designer</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Export tempor illum tamen malis malis eram quae irure esse labore quem cillum quid cillum eram malis quorum velit fore eram velit sunt aliqua noster fugiat irure amet legam anim culpa.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-3.jpg" class="testimonial-img" alt="">
                <h3>Jena Karlis</h3>
                <h4>Store Owner</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Enim nisi quem export duis labore cillum quae magna enim sint quorum nulla quem veniam duis minim tempor labore quem eram duis noster aute amet eram fore quis sint minim.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-4.jpg" class="testimonial-img" alt="">
                <h3>Matt Brandon</h3>
                <h4>Freelancer</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Fugiat enim eram quae cillum dolore dolor amet nulla culpa multos export minim fugiat minim velit minim dolor enim duis veniam ipsum anim magna sunt elit fore quem dolore labore illum veniam.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

            <div class="swiper-slide">
              <div class="testimonial-item">
                <img src="assets/img/testimonials/testimonials-5.jpg" class="testimonial-img" alt="">
                <h3>John Larson</h3>
                <h4>Entrepreneur</h4>
                <div class="stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p>
                  <i class="bi bi-quote quote-icon-left"></i>
                  <span>Quis quorum aliqua sint quem legam fore sunt eram irure aliqua veniam tempor noster veniam enim culpa labore duis sunt culpa nulla illum cillum fugiat legam esse veniam culpa fore nisi cillum quid.</span>
                  <i class="bi bi-quote quote-icon-right"></i>
                </p>
              </div>
            </div><!-- End testimonial item -->

          </div>
          <div class="swiper-pagination"></div>
        </div>

      </div>

    </section><!-- /Testimonials Section -->

    <!-- Faq Section -->
    <section id="faq" class="faq section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <span>Foire Aux Questions</span>
        <h2>Foire Aux Questions</h2>
        <p>Voici les réponses aux questions les plus courantes concernant notre service de covoiturage.</p>
      </div><!-- End Section Title -->
      
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-10">
            <div class="faq-container">
      
              <div class="faq-item faq-active" data-aos="fade-up" data-aos-delay="200">
                <i class="faq-icon bi bi-question-circle"></i>
                <h3>Comment puis-je réserver un trajet en covoiturage ?</h3>
                <div class="faq-content">
                  <p>Il vous suffit de rechercher un trajet via notre plateforme, de choisir une offre correspondant à vos critères, puis de cliquer sur "Réserver". Vous recevrez ensuite une confirmation par email ou notification.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->
      
              <div class="faq-item" data-aos="fade-up" data-aos-delay="300">
                <i class="faq-icon bi bi-question-circle"></i>
                <h3>Le service est-il payant pour les passagers ?</h3>
                <div class="faq-content">
                  <p>Oui, une participation aux frais est demandée selon le trajet choisi. Le montant est affiché avant la réservation, et le paiement se fait en ligne ou directement auprès du conducteur selon les préférences.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->
      
              <div class="faq-item" data-aos="fade-up" data-aos-delay="400">
                <i class="faq-icon bi bi-question-circle"></i>
                <h3>Puis-je annuler ma réservation ?</h3>
                <div class="faq-content">
                  <p>Oui, vous pouvez annuler votre réservation via votre espace utilisateur. Selon le délai, un remboursement partiel ou total peut être effectué.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->
      
              <div class="faq-item" data-aos="fade-up" data-aos-delay="500">
                <i class="faq-icon bi bi-question-circle"></i>
                <h3>Comment puis-je devenir conducteur ?</h3>
                <div class="faq-content">
                  <p>Pour proposer des trajets, vous devez créer un compte conducteur, ajouter votre véhicule et publier vos trajets. Notre équipe validera votre profil avant mise en ligne.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->
      
              <div class="faq-item" data-aos="fade-up" data-aos-delay="600">
                <i class="faq-icon bi bi-question-circle"></i>
                <h3>Les trajets sont-ils assurés ?</h3>
                <div class="faq-content">
                  <p>Oui, chaque conducteur doit avoir une assurance valide pour couvrir les passagers. Nous recommandons également à tous les utilisateurs de consulter nos conditions générales pour plus de détails.</p>
                </div>
                <i class="faq-toggle bi bi-chevron-right"></i>
              </div><!-- End Faq item-->
      
            </div>
          </div>
        </div>
      </div>
      

  </main>

  <footer id="footer" class="footer dark-background">

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-5 col-md-12 footer-about">
          <a href="index.html" class="logo d-flex align-items-center">
            <span class="sitename">EasyParki</span>
          </a>
          <p>Solution innovante de gestion de stationnement intelligent et de mobilité électrique. Rejoignez la révolution des déplacements urbains durables !</p>
          <div class="social-links d-flex mt-4">
            <a href="#"><i class="bi bi-twitter-x"></i></a>
            <a href="#"><i class="bi bi-car-front-fill"></i></a>
            <a href="#"><i class="bi bi-linkedin"></i></a>
            <a href="#"><i class="bi bi-chat-dots-fill"></i></a>
          </div>
        </div>
  
        <div class="col-lg-2 col-6 footer-links">
          <h4>Liens utiles</h4>
          <ul>
            <li><a href="index.html">Accueil</a></li>
            <li><a href="about.html">À propos</a></li>
            <li><a href="services.html">Services</a></li>
            <li><a href="pricing.html">Abonnements</a></li>
            <li><a href="cgv.html">CGU</a></li>
          </ul>
        </div>
  
        <div class="col-lg-2 col-6 footer-links">
          <h4>Nos Services</h4>
          <ul>
            <li><a href="#">Recherche de trajets</a></li>
            <li><a href="#">Réservation et paiement</a></li>
            <li><a href="#">Géolocalisation</a></li>
            
          </ul>
        </div>
  
        <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
          <h4>Nous contacter</h4>
          <p>15 Rue de l'Innovation</p>
          <p>75015 Paris, France</p>
          <p class="mt-4"><strong>Téléphone :</strong> <span>+33 1 84 20 36 00</span></p>
          <p><strong>Email :</strong> <span>contact@easyparki.fr</span></p>
          <p><i class="bi bi-clock"></i> Lun-Ven : 7h-21h</p>
        </div>
  
      </div>
    </div>
  
    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright</span> <strong class="px-1 sitename">EasyParki</strong> <span>Tous droits réservés</span></p>
      <div class="credits">
        Template créé par <a href="https://bootstrapmade.com/">BootstrapMade</a>
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
  
  </body>
  </html>
          