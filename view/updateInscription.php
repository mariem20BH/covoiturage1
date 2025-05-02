<?php
require_once 'C:/xampp/htdocs/webproj/controller/InscriptionC.php';
require_once 'C:/xampp/htdocs/webproj/model/Inscription.php';

// Initialiser les variables
$message = '';
$success = false;
$inscription = null;

// Vérifier si un ID a été passé
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $inscriptionC = new InscriptionC();
    $inscription = $inscriptionC->GetInscription($_GET['id']);
    
    if (!$inscription) {
        $message = "❌ Inscription non trouvée.";
    }
} else {
    $message = "❌ ID d'inscription non spécifié.";
}

// Traitement du formulaire de modification
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["id"]) &&
        isset($_POST["telephone"]) &&
        isset($_POST["categorie"]) &&
        isset($_POST["dateReservation"]) &&
        isset($_POST["paiement"])
    ) {
        try {
            // Validation des données
            if (strlen($_POST["telephone"]) < 8 || !is_numeric($_POST["telephone"])) {
                $message = "❌ Le numéro de téléphone doit contenir au moins 8 chiffres.";
            } elseif (empty($_POST["categorie"])) {
                $message = "❌ Veuillez sélectionner une catégorie.";
            } elseif (empty($_POST["dateReservation"])) {
                $message = "❌ Veuillez spécifier une date de réservation.";
            } elseif (empty($_POST["paiement"])) {
                $message = "❌ Veuillez sélectionner un mode de paiement.";
            } else {
                $inscriptionObj = new Inscription(
                    $_POST["telephone"],
                    $_POST["categorie"],
                    $_POST["dateReservation"],
                    $_POST["paiement"]
                );
                $inscriptionObj->setID($_POST["id"]);

                $ic = new InscriptionC();
                $ic->updateInscription($inscriptionObj);
                $message = "✅ Inscription modifiée avec succès.";
                $success = true;
                
                // Rediriger vers ListeInscription après un court délai
                header("Refresh: 2; URL=ListeInscription.php");
            }
        } catch (Exception $e) {
            $message = "❌ Erreur lors de la modification : " . $e->getMessage();
        }
    } else {
        $message = "❌ Veuillez remplir tous les champs.";
    }
}

$categorieOptions = ["Privé", "Public"];
$paiementOptions = ["Carte", "Espèces"];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="back/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="back/assets/img/easyparki.png">
  <title>EasyParki - Modifier une inscription</title>
  
  <!-- Fonts and icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <link href="back/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="back/assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  
  <!-- CSS Files -->
  <link id="pagestyle" href="back/assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
  
  <style>
    :root {
      --primary-dark: #0a1d37;
      --accent-blue: #4da6ff;
    }
    
    body {
      background-color: rgb(246, 248, 251) !important;
    }
    
    /* Améliorations des styles de formulaire */
    .form-container {
      background: white;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
      margin-top: 20px;
    }
    
    .form-control, .form-select {
      border: 1px solid #333 !important;
      border-radius: 5px !important;
      padding: 10px 15px !important;
      background-color: white !important;
      color: #333 !important;
      transition: all 0.3s ease !important;
    }
    
    .form-control:focus, .form-select:focus {
      border-color: #1e3c72 !important;
      box-shadow: 0 0 0 2px rgba(30, 60, 114, 0.25) !important;
    }
    
    .custom-title {
      color: rgb(10, 50, 107) !important;
      font-family: 'Inter', sans-serif;
      font-weight: 700;
    }
    
    .custom-subtitle {
      color: #000 !important;
      font-family: 'Inter', sans-serif;
      font-weight: 400;
    }

    .sidenav {
      background-color: var(--primary-dark) !important;
      position: fixed;
      left: 0 !important;
      top: 0;
      bottom: 0;
      margin-left: 0;
      transform: translateX(0);
      width: 250px;
    }
    
    .main-content {
      margin-left: 250px;
      transition: margin-left 0.3s ease;
    }
    
    .sidenav .nav-link,
    .sidenav .nav-link-text,
    .sidenav .navbar-brand span,
    .sidenav .material-symbols-rounded {
      color: white !important;
    }
    
    .bg-gradient-blue {
      background: linear-gradient(87deg, #1e3c72 0%, #2a5298 100%);
      color: white !important;
    }
    
    /* Style pour les messages d'erreur */
    .error-message {
      color: #dc3545;
      font-size: 0.85rem;
      margin-top: 5px;
      display: none;
    }
    
    .form-control.is-invalid, 
    .form-select.is-invalid {
      border-color: #dc3545 !important;
    }
    
    .form-control.is-valid, 
    .form-select.is-valid {
      border-color: #28a745 !important;
    }
    
    /* Message de succès global */
    .alert-success {
      background-color: #28a745;
      color: white;
      padding: 15px;
      border-radius: 5px;
      margin-bottom: 20px;
    }
    
    /* Style pour les sélecteurs et inputs classiques (non-HTML5) */
    select, input[type="text"], input[type="tel"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #333;
      border-radius: 5px;
      margin-bottom: 5px;
    }
    
    select:focus, input[type="text"]:focus, input[type="tel"]:focus {
      border-color: #1e3c72;
      box-shadow: 0 0 0 2px rgba(30, 60, 114, 0.25);
      outline: none;
    }
  </style>
</head>

<body class="g-sidenav-show bg-gray-100">
  <!-- Sidebar -->
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href="back/pages/tables.php">
        <img src="back/assets/img/easyparki.png" class="navbar-brand-img" width="50">
        <span class="ms-1 text-white">EasyParki</span>
      </a>
    </div>

    <hr class="horizontal light mt-0 mb-2">

    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <!-- Dashboard -->
        <li class="nav-item">
          <a class="nav-link text-white" href="back/pages/dashboard.html">
            <i class="material-symbols-rounded opacity-10">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>

        <!-- Stationnement -->
        <li class="nav-item">
          <a class="nav-link text-white" href="back/pages/tables.php">
            <i class="material-symbols-rounded opacity-10">local_parking</i>
            <span class="nav-link-text ms-1">Stationnement</span>
          </a>
        </li>

        <!-- Covoiturage -->
        <li class="nav-item">
          <a class="nav-link active bg-gradient-blue text-white" href="javascript:;">
            <i class="material-symbols-rounded opacity-10">directions_car</i>
            <span class="nav-link-text ms-1">Covoiturage</span>
          </a>
          <ul class="nav ms-4 ps-3">
            <li class="nav-item">
              <a href="AjouterTrajet.php" class="nav-link text-white">
                <i class="fas fa-plus-circle me-2"></i> Ajouter un trajet
              </a>
            </li>
            <li class="nav-item">
              <a href="ListeTrajet.php" class="nav-link text-white">
                <i class="fas fa-list me-2"></i> Liste des trajets
              </a>
            </li>
         
            <li class="nav-item">
              <a href="ListeInscription.php" class="nav-link text-white active bg-gradient-primary opacity-8">
                <i class="fas fa-clipboard-list me-2"></i> Liste des inscriptions
              </a>
            </li>
          </ul>
        </li>
        
        <!-- Vacances -->
        <li class="nav-item">
          <a class="nav-link text-white" href="back/pages/billing.html">
            <i class="material-symbols-rounded opacity-10">directions_bus</i>
            <span class="nav-link-text ms-1">Vacances</span>
          </a>
        </li>

        <!-- Service -->
        <li class="nav-item">
          <a class="nav-link text-white" href="back/pages/virtual-reality.html">
            <i class="material-symbols-rounded opacity-10">view_in_ar</i>
            <span class="nav-link-text ms-1">Service</span>
          </a>
        </li>

        <!-- Evenement -->
        <li class="nav-item">
          <a class="nav-link text-white" href="back/pages/rtl.html">
            <i class="material-symbols-rounded opacity-10">format_textdirection_r_to_l</i>
            <span class="nav-link-text ms-1">Événement</span>
          </a>
        </li>

        <!-- Notifications -->
        <li class="nav-item">
          <a class="nav-link text-white" href="back/pages/notifications.html">
            <i class="material-symbols-rounded opacity-10">notifications</i>
            <span class="nav-link-text ms-1">Notifications</span>
          </a>
        </li>

        <!-- Account Pages Title -->
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-8">Pages Compte</h6>
        </li>

        <!-- Profile -->
        <li class="nav-item">
          <a class="nav-link text-white" href="back/pages/profile.html">
            <i class="material-symbols-rounded opacity-10">person</i>
            <span class="nav-link-text ms-1">Profil</span>
          </a>
        </li>

        <!-- Sign In -->
        <li class="nav-item">
          <a class="nav-link text-white" href="back/pages/sign-in.html">
            <i class="material-symbols-rounded opacity-10">login</i>
            <span class="nav-link-text ms-1">Se connecter</span>
          </a>
        </li>

        <!-- Sign Up -->
        <li class="nav-item">
          <a class="nav-link text-white" href="back/pages/sign-up.html">
            <i class="material-symbols-rounded opacity-10">assignment</i>
            <span class="nav-link-text ms-1">S'inscrire</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- Footer Button -->
    <div class="sidenav-footer position-absolute w-100 bottom-0">
      <div class="mx-3">
        <a class="btn btn-outline-white mt-4 w-100" href="http://localhost/webproj/view/front/Logis/covoiturage.php">FrontOffice</a>
      </div>
    </div>
  </aside>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="card shadow-lg">
            <div class="card-header bg-white border-0 pb-0 text-center">
              <div class="mt-2">
                <h4 class="custom-title">Modifier une inscription</h4>
              </div>
            </div>
            
            <div class="card-body">
              <?php if ($inscription): ?>
              <form id="inscriptionForm" method="POST" class="form-container">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($inscription['ID']); ?>">
                
                <div class="mb-3">
                  <label for="telephone">Numéro de téléphone</label>
                  <input type="tel" id="telephone" name="telephone" value="<?php echo htmlspecialchars($inscription['Telephone']); ?>">
                  <small>Format: 8 chiffres minimum</small>
                  <div class="error-message" id="error-telephone"></div>
                </div>
                
                <div class="mb-3">
                  <label for="categorie">Catégorie</label>
                  <select name="categorie" id="categorie">
                    <option value="">-- Sélectionnez une catégorie --</option>
                    <?php foreach ($categorieOptions as $option): ?>
                      <option value="<?php echo htmlspecialchars($option); ?>" <?php echo ($option == $inscription['Categorie']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($option); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <div class="error-message" id="error-categorie"></div>
                </div>
                
                <div class="mb-3">
                  <label for="dateReservation">Date de réservation</label>
                  <input type="text" id="dateReservation" name="dateReservation" value="<?php echo htmlspecialchars($inscription['DateReservation']); ?>" placeholder="AAAA-MM-JJ">
                  <small>Format: AAAA-MM-JJ</small>
                  <div class="error-message" id="error-dateReservation"></div>
                </div>
                
                <div class="mb-3">
                  <label for="paiement">Mode de paiement</label>
                  <select name="paiement" id="paiement">
                    <option value="">-- Sélectionnez un mode de paiement --</option>
                    <?php foreach ($paiementOptions as $option): ?>
                      <option value="<?php echo htmlspecialchars($option); ?>" <?php echo ($option == $inscription['Paiement']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($option); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <div class="error-message" id="error-paiement"></div>
                </div>
                
                <?php if ($success): ?>
                <div class="alert alert-success mb-3">
                  <i class="fas fa-check-circle me-2"></i> <?php echo str_replace("✅ ", "", $message); ?>
                </div>
                <?php endif; ?>
                
                <div class="d-flex justify-content-between">
                  <a href="ListeInscription.php" class="btn btn-secondary">Annuler</a>
                  <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
              </form>
              <?php else: ?>
              <div class="alert alert-danger">
                <?php echo $message; ?>
                <div class="mt-3">
                  <a href="ListeInscription.php" class="btn btn-primary">Retour à la liste</a>
                </div>
              </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  
  <!-- Scripts -->
  <script src="back/assets/js/core/popper.min.js"></script>
  <script src="back/assets/js/core/bootstrap.min.js"></script>
  <script src="back/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="back/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="back/assets/js/material-dashboard.min.js"></script>
  
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const form = document.getElementById('inscriptionForm');
      
      // Fonction pour afficher un message d'erreur sous un champ
      function showError(fieldId, message) {
        const field = document.getElementById(fieldId);
        const errorElement = document.getElementById('error-' + fieldId);
        
        if (field && errorElement) {
          // Afficher le message d'erreur
          errorElement.textContent = message;
          errorElement.style.display = 'block';
          
          // Ajouter une classe d'invalidité au champ
          field.classList.add('is-invalid');
          field.classList.remove('is-valid');
        }
      }
      
      // Fonction pour masquer un message d'erreur
      function hideError(fieldId) {
        const field = document.getElementById(fieldId);
        const errorElement = document.getElementById('error-' + fieldId);
        
        if (field && errorElement) {
          // Masquer le message d'erreur
          errorElement.textContent = '';
          errorElement.style.display = 'none';
          
          // Retirer la classe d'invalidité du champ
          field.classList.remove('is-invalid');
          field.classList.add('is-valid');
        }
      }
      
      // Fonction pour valider un champ spécifique
      function validateField(fieldId) {
        const field = document.getElementById(fieldId);
        
        if (!field) return true; // Si le champ n'existe pas, on considère qu'il est valide
        
        const value = field.value.trim();
        
        // Validation selon le type de champ
        switch (fieldId) {
          case 'telephone':
            if (value === '') {
              showError(fieldId, 'Veuillez saisir un numéro de téléphone.');
              return false;
            } else if (isNaN(value)) {
              showError(fieldId, 'Le numéro de téléphone doit contenir uniquement des chiffres.');
              return false;
            } else if (value.length < 8) {
              showError(fieldId, 'Le numéro de téléphone doit contenir au moins 8 chiffres.');
              return false;
            }
            break;
            
          case 'categorie':
            if (value === '') {
              showError(fieldId, 'Veuillez sélectionner une catégorie.');
              return false;
            }
            break;
            
          case 'dateReservation':
            if (value === '') {
              showError(fieldId, 'Veuillez saisir une date de réservation.');
              return false;
            } else {
              const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
              if (!dateRegex.test(value)) {
                showError(fieldId, 'Le format de la date doit être AAAA-MM-JJ.');
                return false;
              }
            }
            break;
            
          case 'paiement':
            if (value === '') {
              showError(fieldId, 'Veuillez sélectionner un mode de paiement.');
              return false;
            }
            break;
        }
        
        // Si aucune erreur n'est détectée, masquer le message d'erreur
        hideError(fieldId);
        return true;
      }
      
      // Ajouter des écouteurs d'événements pour la validation en temps réel
      if (form) {
        const fields = ['telephone', 'categorie', 'dateReservation', 'paiement'];
        
        fields.forEach(fieldId => {
          const field = document.getElementById(fieldId);
          if (field) {
            field.addEventListener('change', function() {
              validateField(fieldId);
            });
            
            field.addEventListener('input', function() {
              // Masquer le message d'erreur pendant la saisie
              const errorElement = document.getElementById('error-' + fieldId);
              if (errorElement) {
                errorElement.style.display = 'none';
              }
            });
          }
        });
        
        // Valider le formulaire lors de la soumission
        form.addEventListener('submit', function(e) {
          let isValid = true;
          
          // Valider chaque champ
          fields.forEach(fieldId => {
            if (!validateField(fieldId)) {
              isValid = false;
            }
          });
          
          // Empêcher l'envoi du formulaire si la validation échoue
          if (!isValid) {
            e.preventDefault();
          }
        });
      }
      
      <?php if (!empty($message) && !$success): ?>
      // Afficher un message d'erreur du serveur si présent
      const errorMessage = "<?php echo str_replace("❌ ", "", $message); ?>";
      
      // Tenter de déterminer quel champ est concerné par l'erreur
      if (errorMessage.includes("numéro de téléphone")) {
        showError('telephone', errorMessage);
      } else if (errorMessage.includes("catégorie")) {
        showError('categorie', errorMessage);
      } else if (errorMessage.includes("date de réservation")) {
        showError('dateReservation', errorMessage);
      } else if (errorMessage.includes("mode de paiement")) {
        showError('paiement', errorMessage);
      }
      <?php endif; ?>
    });
  </script>
</body>
</html>
