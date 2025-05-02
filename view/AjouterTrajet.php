<?php
require_once 'C:/xampp/htdocs/webproj/controller/TrajetC.php';
require_once 'C:/xampp/htdocs/webproj/model/Trajet.php';
require_once 'C:/xampp/htdocs/webproj/controller/InscriptionC.php';

$message = '';
$success = false;

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
            $inscriptionC = new InscriptionC();
            $inscriptionExist = $inscriptionC->GetInscription($_POST["ID_Inscription"]);

            if (!$inscriptionExist) {
                $message = "❌ L'ID d'inscription n'existe pas dans la base de données.";
            } elseif (strlen($_POST["AdresseArrivee"]) < 4) {
                $message = "❌ L'adresse d'arrivée doit contenir au moins 4 caractères.";
            } elseif (!is_numeric($_POST["Prix"]) || $_POST["Prix"] <= 0) {
                $message = "❌ Le prix doit être un nombre positif et en dinars.";
            } elseif (!is_numeric($_POST["NombrePlaces"]) || intval($_POST["NombrePlaces"]) <= 0) {
                $message = "❌ Le nombre de places doit être un entier positif.";
            } elseif (!is_numeric($_POST["Distance"]) || $_POST["Distance"] <= 0) {
                $message = "❌ La distance doit être un nombre positif.";
            } else {
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
                $message = "✅ Trajet ajouté avec succès.";
                $success = true;
                
                // Rediriger vers ListeTrajet après un court délai
                header("Refresh: 2; URL=ListeTrajet.php");
            }
        } catch (Exception $e) {
            $message = "❌ Erreur lors de l'ajout : " . $e->getMessage();
        }
    } else {
        $message = "❌ Veuillez remplir tous les champs.";
    }
}

// Récupérer les inscriptions pour la liste déroulante
$inscriptionC = new InscriptionC();
$inscriptions = $inscriptionC->ListeInscription();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="fr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="apple-touch-icon" sizes="76x76" href="back/assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="back/assets/img/easyparki.png">
  <title>EasyParki - Ajouter un trajet</title>
  
  <!-- Fonts and icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <link href="back/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="back/assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  
  <!-- CSS Files -->
  <link id="pagestyle" href="back/assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
  
  <style>
    /* Définition des couleurs dans des classes au lieu de variables CSS (non supportées par les vieux navigateurs) */
    .primary-dark-bg { background-color: #0a1d37; }
    .accent-blue-color { color: #4da6ff; }
    
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
    
    /* Style pour les sélecteurs et inputs classiques (non-HTML5) */
    select, input {
      width: 100%;
      padding: 10px 15px;
      border: 1px solid #333;
      border-radius: 5px;
      background-color: white;
      color: #333;
      margin-bottom: 5px;
      font-size: 14px;
    }
    
    select:focus, input:focus {
      border-color: #1e3c72;
      outline: none;
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
      background-color: #0a1d37 !important;
      position: fixed;
      left: 0 !important;
      top: 0;
      bottom: 0;
      margin-left: 0;
      width: 250px;
    }
    
    .main-content {
      margin-left: 250px;
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
    
    .is-invalid {
      border-color: #dc3545 !important;
    }
    
    .is-valid {
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
    
    /* Style supplémentaire pour le formulaire */
    .form-group {
      margin-bottom: 15px;
    }
    
    label {
      display: block;
      margin-bottom: 5px;
      font-weight: 500;
      color: #333;
    }
    
    small {
      font-size: 0.8rem;
      color: #6c757d;
    }
    
    /* Styles des boutons */
    .btn {
      padding: 8px 16px;
      border-radius: 5px;
      font-weight: 500;
    }
    
    .btn-primary {
      background-color: #1e3c72;
      border-color: #1e3c72;
      color: white;
    }
    
    .btn-primary:hover {
      background-color: #162c55;
      border-color: #162c55;
    }
    
    .btn-secondary {
      background-color: #6c757d;
      border-color: #6c757d;
      color: white;
    }
    
    .btn-secondary:hover {
      background-color: #5a6268;
      border-color: #5a6268;
    }
    
    /* Garantir la compatibilité avec les anciens navigateurs */
    .mb-3 { margin-bottom: 1rem; }
    .mt-2 { margin-top: 0.5rem; }
    .mt-4 { margin-top: 1.5rem; }
    .py-4 { padding-top: 1.5rem; padding-bottom: 1.5rem; }
    .ms-1 { margin-left: 0.25rem; }
    .ms-4 { margin-left: 1.5rem; }
    .ps-3 { padding-left: 1rem; }
    .me-2 { margin-right: 0.5rem; }
    .mt-3 { margin-top: 1rem; }
    .me-2 { margin-right: 0.5rem; }
    .px-4 { padding-left: 1.5rem; padding-right: 1.5rem; }
    .py-3 { padding-top: 1rem; padding-bottom: 1rem; }
    .d-flex { display: flex; }
    .justify-content-between { justify-content: space-between; }
    .text-center { text-align: center; }
    .text-white { color: white; }
    .opacity-8 { opacity: 0.8; }
    .opacity-5 { opacity: 0.5; }
    .opacity-10 { opacity: 1; }
    .w-100 { width: 100%; }
    .w-auto { width: auto; }
    .h-100 { height: 100%; }
    .border-0 { border: 0; }
    .text-xs { font-size: 0.75rem; }
  </style>
</head>

<body class="g-sidenav-show bg-gray-100">
  <!-- Sidebar -->
  <div class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start" id="sidenav-main">
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
        <!-- ... Les éléments du menu ... -->
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
              <a href="AjouterTrajet.php" class="nav-link text-white active bg-gradient-primary opacity-8">
                <i class="fas fa-plus-circle me-2"></i> Ajouter un trajet
              </a>
            </li>
            <li class="nav-item">
              <a href="ListeTrajet.php" class="nav-link text-white">
                <i class="fas fa-list me-2"></i> Liste des trajets
              </a>
            </li>
         
            <li class="nav-item">
              <a href="ListeInscription.php" class="nav-link text-white">
                <i class="fas fa-clipboard-list me-2"></i> Liste des inscriptions
              </a>
            </li>
          </ul>
        </li>
        <!-- ... Reste du menu inchangé ... -->
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
  </div>

  <div class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-lg-8 col-md-10 mx-auto">
          <div class="card shadow-lg">
            <div class="card-header bg-white border-0 pb-0 text-center">
              <div class="mt-2">
                <h4 class="custom-title">Ajouter un trajet</h4>
              </div>
            </div>
            
            <div class="card-body">
              <form id="trajetForm" method="POST" class="form-container">
                <div class="form-group mb-3">
                  <label for="ID_Inscription">ID Inscription</label>
                  <select id="ID_Inscription" name="ID_Inscription">
                    <option value="">-- Sélectionnez une inscription --</option>
                  <?php foreach ($inscriptions as $inscription): ?>
                    <option value="<?php echo htmlspecialchars($inscription['ID']); ?>">
                      <?php echo htmlspecialchars($inscription['ID']); ?>
                    </option>
                  <?php endforeach; ?>
                  </select>
                  <small>L'inscription à associer au trajet</small>
                  <div class="error-message" id="error-ID_Inscription"></div>
                </div>
                
                <div class="form-group mb-3">
                  <label for="AdresseDepart">Adresse de départ</label>
                  <select id="AdresseDepart" name="AdresseDepart">
                    <option value="">-- Sélectionnez une adresse --</option>
                    <option value="Parking de l'aéroport">Parking de l'aéroport</option>
                    <option value="Parking Tunis City">Parking Tunis City</option>
                    <option value="Parking Municipal">Parking Municipal</option>
                    <option value="Centre Urbain Nord">Centre Urbain Nord</option>
                  </select>
                  <div class="error-message" id="error-AdresseDepart"></div>
                </div>
                
                <div class="form-group mb-3">
                  <label for="AdresseArrivee">Adresse d'arrivée</label>
                  <input type="text" id="AdresseArrivee" name="AdresseArrivee">
                  <small>Minimum 4 caractères</small>
                  <div class="error-message" id="error-AdresseArrivee"></div>
                </div>
                
                <div class="row">
                  <div class="col-md-6 form-group mb-3">
                    <label for="NombrePlaces">Nombre de places</label>
                    <input type="text" id="NombrePlaces" name="NombrePlaces">
                    <div class="error-message" id="error-NombrePlaces"></div>
                  </div>
                  
                  <div class="col-md-6 form-group mb-3">
                    <label for="Prix">Prix (DT)</label>
                    <input type="text" id="Prix" name="Prix">
                    <div class="error-message" id="error-Prix"></div>
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-md-6 form-group mb-3">
                    <label for="Distance">Distance (km)</label>
                    <input type="text" id="Distance" name="Distance">
                    <div class="error-message" id="error-Distance"></div>
                  </div>
                  
                  <div class="col-md-6 form-group mb-3">
                    <label for="Duree">Durée (HH:MM:SS)</label>
                    <input type="text" id="Duree" name="Duree">
                    <small>Format: 00:30:00</small>
                    <div class="error-message" id="error-Duree"></div>
                  </div>
                </div>
                
                <?php if ($success): ?>
                <div class="alert alert-success mb-3">
                  <i class="fas fa-check-circle me-2"></i> <?php echo str_replace("✅ ", "", $message); ?>
                </div>
                <?php endif; ?>
                
                <div class="d-flex justify-content-between mt-4">
                  <a href="ListeTrajet.php" class="btn btn-secondary">Annuler</a>
                  <button type="submit" class="btn btn-primary">Enregistrer</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Scripts -->
  <script src="back/assets/js/core/popper.min.js"></script>
  <script src="back/assets/js/core/bootstrap.min.js"></script>
  <script src="back/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="back/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="back/assets/js/material-dashboard.min.js"></script>
  
  <script>
    /* Attendre que le document soit complètement chargé - fonctionnalité compatible avec les anciens navigateurs */
    function addEvent(obj, evt, fn) {
      if (obj.addEventListener) {
        obj.addEventListener(evt, fn, false);
      } else if (obj.attachEvent) {
        obj.attachEvent("on" + evt, fn);
      }
    }
    
    addEvent(window, "load", function() {
      var form = document.getElementById('trajetForm');
      
      // Fonction pour afficher un message d'erreur sous un champ
      function showError(fieldId, message) {
        var field = document.getElementById(fieldId);
        var errorElement = document.getElementById('error-' + fieldId);
        
        if (field && errorElement) {
          // Afficher le message d'erreur
          errorElement.innerHTML = message;
          errorElement.style.display = 'block';
          
          // Ajouter une classe d'invalidité au champ
          if (field.className.indexOf('is-invalid') === -1) {
            field.className += ' is-invalid';
          }
          
          // Supprimer la classe is-valid si elle existe
          field.className = field.className.replace(/\bis-valid\b/g, '');
        }
      }
      
      // Fonction pour masquer un message d'erreur
      function hideError(fieldId) {
        var field = document.getElementById(fieldId);
        var errorElement = document.getElementById('error-' + fieldId);
        
        if (field && errorElement) {
          // Masquer le message d'erreur
          errorElement.innerHTML = '';
          errorElement.style.display = 'none';
          
          // Retirer la classe d'invalidité du champ
          field.className = field.className.replace(/\bis-invalid\b/g, '');
          
          // Ajouter la classe is-valid
          if (field.className.indexOf('is-valid') === -1) {
            field.className += ' is-valid';
          }
        }
      }
      
      // Fonction pour valider un champ spécifique
      function validateField(fieldId) {
        var field = document.getElementById(fieldId);
        
        if (!field) return true; // Si le champ n'existe pas, on considère qu'il est valide
        
        var value = field.value.trim();
        
        // Validation selon le type de champ
        switch (fieldId) {
          case 'ID_Inscription':
            if (value === '') {
              showError(fieldId, 'Veuillez sélectionner une inscription.');
              return false;
            }
            break;
            
          case 'AdresseDepart':
            if (value === '') {
              showError(fieldId, 'Veuillez sélectionner une adresse de départ.');
              return false;
            }
            break;
            
          case 'AdresseArrivee':
            if (value === '') {
              showError(fieldId, 'Veuillez saisir une adresse d\'arrivée.');
              return false;
            } else if (value.length < 4) {
              showError(fieldId, 'L\'adresse d\'arrivée doit contenir au moins 4 caractères.');
              return false;
            }
            break;
            
          case 'NombrePlaces':
            if (value === '') {
              showError(fieldId, 'Veuillez saisir le nombre de places.');
              return false;
            } else if (isNaN(value)) {
              showError(fieldId, 'Le nombre de places doit être un nombre.');
              return false;
            } else if (parseFloat(value) < 1) {
              showError(fieldId, 'Le nombre de places doit être au moins 1.');
              return false;
            } else if (Math.floor(parseFloat(value)) != parseFloat(value)) {
              showError(fieldId, 'Le nombre de places doit être un nombre entier.');
              return false;
            }
            break;
            
          case 'Prix':
            if (value === '') {
              showError(fieldId, 'Veuillez saisir le prix.');
              return false;
            } else if (isNaN(value)) {
              showError(fieldId, 'Le prix doit être un nombre.');
              return false;
            } else if (parseFloat(value) <= 0) {
              showError(fieldId, 'Le prix doit être supérieur à 0.');
              return false;
            }
            break;
            
          case 'Distance':
            if (value === '') {
              showError(fieldId, 'Veuillez saisir la distance.');
              return false;
            } else if (isNaN(value)) {
              showError(fieldId, 'La distance doit être un nombre.');
              return false;
            } else if (parseFloat(value) <= 0) {
              showError(fieldId, 'La distance doit être supérieure à 0.');
              return false;
            }
            break;
            
          case 'Duree':
            if (value === '') {
              showError(fieldId, 'Veuillez saisir la durée.');
              return false;
            } else {
              var dureeRegex = /^([0-1][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/;
              if (!dureeRegex.test(value)) {
                showError(fieldId, 'Le format de la durée doit être HH:MM:SS.');
                return false;
              }
            }
            break;
        }
        
        // Si aucune erreur n'est détectée, masquer le message d'erreur
        hideError(fieldId);
        return true;
      }
      
      // Ajouter des écouteurs d'événements pour la validation en temps réel
      var fields = ['ID_Inscription', 'AdresseDepart', 'AdresseArrivee', 'NombrePlaces', 'Prix', 'Distance', 'Duree'];
      
      for (var i = 0; i < fields.length; i++) {
        var fieldId = fields[i];
        var field = document.getElementById(fieldId);
        
        if (field) {
          // Utilisation de fonctions anonymes avec closure pour capturer fieldId
          (function(currentFieldId) {
            addEvent(field, 'change', function() {
              validateField(currentFieldId);
            });
            
            addEvent(field, 'input', function() {
              // Masquer le message d'erreur pendant la saisie
              var errorElement = document.getElementById('error-' + currentFieldId);
              if (errorElement) {
                errorElement.style.display = 'none';
              }
            });
          })(fieldId);
        }
      }
      
      // Valider le formulaire lors de la soumission
      if (form) {
        addEvent(form, 'submit', function(e) {
          var isValid = true;
          
          // Valider chaque champ
          for (var i = 0; i < fields.length; i++) {
            if (!validateField(fields[i])) {
              isValid = false;
            }
          }
          
          // Empêcher l'envoi du formulaire si la validation échoue
          if (!isValid) {
            if (e.preventDefault) {
              e.preventDefault();
            } else {
              e.returnValue = false; // Pour IE
            }
          }
        });
      }
      
      <?php if (!empty($message) && !$success): ?>
      // Afficher un message d'erreur du serveur si présent
      var errorMessage = "<?php echo str_replace("❌ ", "", $message); ?>";
      
      // Tenter de déterminer quel champ est concerné par l'erreur
      if (errorMessage.indexOf("ID d'inscription") !== -1) {
        showError('ID_Inscription', errorMessage);
      } else if (errorMessage.indexOf("adresse d'arrivée") !== -1) {
        showError('AdresseArrivee', errorMessage);
      } else if (errorMessage.indexOf("prix") !== -1) {
        showError('Prix', errorMessage);
      } else if (errorMessage.indexOf("nombre de places") !== -1) {
        showError('NombrePlaces', errorMessage);
      } else if (errorMessage.indexOf("distance") !== -1) {
        showError('Distance', errorMessage);
      } else if (errorMessage.indexOf("durée") !== -1) {
        showError('Duree', errorMessage);
      }
      <?php endif; ?>
    });
  </script>
</body>
</html>