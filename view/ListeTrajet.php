<?php
require_once 'C:/xampp/htdocs/webproj/controller/TrajetC.php';
$tc = new TrajetC();

// Récupérer les données statistiques
$statsAdresses = $tc->getStatistiqueAdressesDepart();
$statsPlaces = $tc->getStatistiquePlaces();
$statsPrix = $tc->getStatistiquePrix();

// Préparation des données pour les graphiques
$adresses = [];
$nombreParAdresse = [];
foreach ($statsAdresses as $stat) {
    $adresses[] = $stat['Adresse_Depart'];
    $nombreParAdresse[] = $stat['nombre'];
}

$placesOptions = [];
$nombreParPlaces = [];
foreach ($statsPlaces as $stat) {
    $placesOptions[] = $stat['Nombre_Places'] . ' places';
    $nombreParPlaces[] = $stat['nombre'];
}

$tranchesPrix = [];
$nombreParPrix = [];
foreach ($statsPrix as $stat) {
    $tranchesPrix[] = $stat['tranche_prix'];
    $nombreParPrix[] = $stat['nombre'];
}

// Initialiser le tableau des trajets
$listeTrajets = [];

// Vérifier si une recherche a été effectuée
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $searchTerm = trim($_GET['search']);
    $listeTrajets = $tc->rechercherTrajets($searchTerm);
} else {
    // Si aucune recherche, charger tous les trajets
    $listeTrajets = $tc->ListeTrajet();
}

$adresseOptions = [
  "Parking de l'aéroport",
  "Parking Tunis City",
  "Parking Municipal",
  "Centre Urbain Nord"
];

// Sorting Logic
$sortField = isset($_GET['sort']) ? $_GET['sort'] : '';
$sortOrder = isset($_GET['order']) ? $_GET['order'] : 'asc';

if (!empty($sortField)) {
    usort($listeTrajets, function($a, $b) use ($sortField, $sortOrder) {
        if (!isset($a[$sortField]) || !isset($b[$sortField])) {
            return 0;
        }
        
        $valueA = $a[$sortField];
        $valueB = $b[$sortField];
        
        // Handling date comparison
        if ($sortField == 'date') {
            $valueA = strtotime($valueA);
            $valueB = strtotime($valueB);
        }
        
        if ($sortOrder == 'asc') {
            return $valueA <=> $valueB;
        } else {
            return $valueB <=> $valueA;
        }
    });
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/easyparki.png">
  <title>EasyParki - Liste des Trajets</title>
  
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
      background-color:rgb(246, 248, 251) !important;
    }
    .nav-item.has-submenu {
      position: relative;
    }
    
    .submenu {
      position: absolute;
      left: 0;
      top: 100%;
      min-width: 220px;
      background: var(--primary-dark);
      border-radius: 8px;
      padding: 10px 0;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s ease;
      transform: translateY(-10px);
      z-index: 1000;
      box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    }
    
    .nav-item.has-submenu:hover .submenu {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }
    
    .submenu-item {
      padding: 12px 20px;
      color: white !important;
      text-decoration: none;
      display: flex;
      align-items: center;
      transition: all 0.2s ease;
    }
    
    .submenu-item:hover {
      background: rgba(255,255,255,0.1);
      padding-left: 25px;
    }
    
    .submenu-item i {
      margin-right: 12px;
      font-size: 18px;
    }

    .form-container {
      background: white;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
      margin: 30px auto;
      max-width: 600px;
    }
    
    
    .nav-item.has-submenu:hover .submenu {
      opacity: 1;
      visibility: visible;
      transform: translateY(0);
    }
    
    .submenu-item {
      padding: 12px 20px;
      color: white !important;
      text-decoration: none;
      display: flex;
      align-items: center;
      transition: all 0.2s ease;
    }
    
    .submenu-item:hover {
      background: rgba(255,255,255,0.1);
      padding-left: 25px;
    }
    
    .submenu-item i {
      margin-right: 12px;
      font-size: 18px;
    }

    .form-container {
      background: white;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
      margin: 30px auto;
      max-width: 600px;
    }
    
    .sidenav {
      background-color: var(--primary-dark) !important;
      position: fixed;
      left: 0 !important;
      top: 0;
      bottom: 0;
      margin-left: 0;
      transform: translateX(0);
      width: 250px; /* Ajustez la largeur selon vos besoins */
    }
    
    .main-content {
      margin-left: 250px; /* Doit correspondre à la largeur du sidebar */
      transition: margin-left 0.3s ease;
    }
    
    .error-message {
      color: red;
      margin-bottom: 15px;
    }

    
    .custom-table {
      background: white;
      border-radius: 12px;
      overflow: hidden;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
    }
    
    .custom-table th {
      background-color: var(--accent-blue) !important;
      color: white !important;
      padding: 1rem;
    }
    
    .custom-table td {
      vertical-align: middle;
      padding: 1rem;
    }

    .bg-gradient-primary {
        background: linear-gradient(195deg, #EC407A 0%, #D81B60 100%);
        border: none;
    }

    .bg-gradient-primary:hover {
        background: linear-gradient(195deg, #D81B60 0%, #EC407A 100%);
    }
    .bg-gradient-blue {
  background: linear-gradient(87deg, #1e3c72 0%, #2a5298 100%);
  color: white !important;
}

    /* PDF Export Button Styles */
    .pdf-export-btn {
        background: linear-gradient(45deg, #4a00e0, #8e2de2);
        border: none;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        box-shadow: 0 4px 15px rgba(74, 0, 224, 0.4);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        padding: 12px 24px;
    }
    
    .pdf-export-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(74, 0, 224, 0.6);
    }
    
    .pdf-export-btn .btn-content {
        position: relative;
        z-index: 1;
    }
    
    .pdf-export-btn .btn-effect {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.2);
        transform: translateX(-100%) skewX(-15deg);
        transition: all 0.6s ease;
    }
    
    .pdf-export-btn:hover .btn-effect {
        transform: translateX(0) skewX(-15deg);
    }
    
    /* Sort Button Styles */
    .sort-btn {
        background: linear-gradient(45deg, #00b09b, #96c93d);
        border: none;
        border-radius: 50px;
        color: white;
        font-weight: 600;
        letter-spacing: 1px;
        text-transform: uppercase;
        box-shadow: 0 4px 15px rgba(0, 176, 155, 0.4);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease;
        padding: 12px 24px;
        margin-right: 10px;
    }
    
    .sort-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 176, 155, 0.6);
    }
    
    .sort-btn .btn-content {
        position: relative;
        z-index: 1;
    }
    
    .sort-btn .btn-effect {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255,255,255,0.2);
        transform: translateX(-100%) skewX(-15deg);
        transition: all 0.6s ease;
    }
    
    .sort-btn:hover .btn-effect {
        transform: translateX(0) skewX(-15deg);
    }
    .custom-title {
    color:rgb(10, 50, 107) !important;
    font-family: 'Inter', sans-serif;
    font-weight: 700;
}

.custom-subtitle {
    color: #000 !important;
    font-family: 'Inter', sans-serif;
    font-weight: 400;
}
    /* Button container */
    .button-container {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
        flex-wrap: wrap;
    }
    
    /* Animation for sorting */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .table-row-animate {
        animation: fadeIn 0.5s ease forwards;
    }
    
    /* Rotate icon when sorting */
    .rotate-icon {
        animation: rotate 0.5s ease;
    }
    
    @keyframes rotate {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    html, body {
  height: 100%;
}

.g-sidenav-show {
  min-height: 100vh;
}

.custom-popup {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  background: #28a745;
  color: white;
  padding: 20px 40px;
  border-radius: 8px;
  box-shadow: 0 4px 15px rgba(0,0,0,0.2);
  display: none;
  z-index: 9999;
  min-width: 300px;
  text-align: center;
}

.popup-content {
  position: relative;
}

.popup-progress {
  position: absolute;
  bottom: 0;
  left: 0;
  height: 3px;
  width: 100%;
  background: rgba(255,255,255,0.3);
  animation: progress 3s linear forwards;
}

@keyframes progress {
  from { width: 100%; }
  to { width: 0%; }
}

.popup-message {
  font-size: 1.1rem;
  font-weight: 500;
}
.popup-actions {
    display: none;
    justify-content: center;
    gap: 15px;
    margin-top: 20px;
}

.custom-popup {
    transition: all 0.3s ease;
}

/* Dans votre section style */
input.form-control-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    line-height: 1.5;
    border: 1px solid #dee2e6;
    border-radius: 0.2rem;
    max-width: 150px;
}

.btn-sm i {
    margin-right: 0.3rem;
}

.input-editable, .select-editable {
    width: 95%;
    transition: all 0.3s;
}

.is-invalid {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.25);
}

.is-valid {
    border-color: #28a745 !important;
    box-shadow: 0 0 0 2px rgba(40, 167, 69, 0.25);
}

.field-feedback {
    font-size: 0.75rem;
    position: absolute;
    bottom: -20px;
    left: 0;
}

.select-editable {
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg...");
    background-repeat: no-repeat;
    background-position: right 0.5rem center;
    background-size: 1em;
}
.input-editable, .select-editable {
    transition: all 0.3s;
    max-width: 200px;
}

.select-editable {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    width: 100%;
    max-width: 200px;
}

. input-editable {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    width: 100%;
    max-width: 100px;
}
    /* Styles pour les conteneurs de graphiques */
    .stats-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
      margin: 20px 0;
      gap: 20px;
    }
    
    .chart-wrapper {
      background: white;
      padding: 15px;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
      max-width: 350px;
      width: 100%;
    }
    
    .chart-title {
      text-align: center;
      margin-bottom: 15px;
      font-weight: 600;
      color: #0a1d37;
    }
    
    .canvas-container {
      position: relative;
      height: 250px;
    }

    /* Styles des boutons standardisés */
    .btn-blue {
      background: #1e88e5;
      color: white;
      border: none;
      border-radius: 4px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      transition: all 0.3s;
    }
    
    .btn-blue:hover {
      background: #1565c0;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      transform: translateY(-2px);
      color: white;
    }
    
    .btn-red {
      background: #e53935;
      color: white;
      border: none;
      border-radius: 4px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      transition: all 0.3s;
    }
    
    .btn-red:hover {
      background: #c62828;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      transform: translateY(-2px);
      color: white;
    }
    
    .btn-green {
      background: #43a047;
      color: white;
      border: none;
      border-radius: 4px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
      transition: all 0.3s;
    }
    
    .btn-green:hover {
      background: #2e7d32;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
      transform: translateY(-2px);
      color: white;
    }
  </style>
</head>

<body class="g-sidenav-show bg-gray-49">
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
              <a href="ListeTrajet.php" class="nav-link text-white active bg-gradient-primary opacity-8">
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
        <a class="btn btn-outline-white mt-4 w-100" href="http://localhost/ProjetWeb/View/FrontOffice/Logis/covoiturage.php">FrontOffice</a>
      </div>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <div class="container-fluid py-4">
        <div class="card shadow-lg">
            <div class="card-header bg-white border-0 pb-0 text-center"> <!-- Ajout de text-center -->
                <div style="display: flex; justify-content: center; align-items: center; height: 6vh;">
                    <h4 class="custom-title">Liste des Trajets</h4>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6 offset-md-3">
                        <?php if (!empty($searchMessage)): ?>
                            <div class="alert alert-info mb-3">
                                <?= $searchMessage ?>
                            </div>
                        <?php endif; ?>
                        <form method="GET" action="ListeTrajet.php" class="mb-4">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Rechercher un trajet..." 
                                       name="search" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                                <button class="btn btn-primary" type="submit">
                                    <i class="fas fa-search me-1"></i> Rechercher
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card-body px-0 pt-3">
                <div class="table-responsive p-3">
                    <table class="table table-hover align-middle mb-0" id="trajetsTable">
                        <thead>
                            <tr class="bg-light">
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID Inscription</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Adresse Départ</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Adresse Arrivée</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Places</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Prix (DT)</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Distance</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Durée</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($listeTrajets as $trajet): ?>
                            <tr data-id="<?= htmlspecialchars($trajet['ID_Trajet']) ?>">
                                <td class="ps-4">
                                    <span class="text-xs font-weight-bold"><?= htmlspecialchars($trajet['ID_Trajet']) ?></span>
                                </td>
                                <td class="ps-4">
                                    <span class="text-xs font-weight-bold"><?= htmlspecialchars($trajet['ID_Inscription']) ?></span>
                                </td>
                                <td>
                                    <span class="text-xs font-weight-normal display-mode">
                                        <?= htmlspecialchars($trajet['Adresse_Depart']) ?>
                                    </span>
                                    <select class="form-select edit-mode" data-field="Adresse_Depart" style="display: none;">
                                        <?php foreach ($adresseOptions as $option): ?>
                                            <option value="<?= htmlspecialchars($option) ?>" <?= $option === $trajet['Adresse_Depart'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($option) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td>
                                    <span class="text-xs font-weight-normal display-mode"><?= htmlspecialchars($trajet['Adresse_Arrivee']) ?></span>
                                    <input type="text" class="form-control edit-mode" data-field="Adresse_Arrivee" 
                                           value="<?= htmlspecialchars($trajet['Adresse_Arrivee']) ?>" style="display: none;">
                                </td>
                                <td>
                                    <span class="badge bg-primary rounded-pill display-mode">
                                        <?= htmlspecialchars($trajet['Nombre_Places']) ?>
                                    </span>
                                    <input type="number" class="form-control edit-mode" data-field="Nombre_Places" 
                                           value="<?= $trajet['Nombre_Places'] ?>" style="display: none; width: 70px;" min="1">
                                </td>
                                <td>
                                    <span class="text-xs font-weight-bold display-mode"><?= htmlspecialchars($trajet['Prix']) ?> DT</span>
                                    <input type="number" step="0.01" class="form-control edit-mode" data-field="Prix" 
                                           value="<?= $trajet['Prix'] ?>" style="display: none; width: 90px;" min="0.01">
                                </td>
                                <td>
                                    <span class="text-xs font-weight-bold display-mode <?= $trajet['Distance'] > 0 ? 'text-success' : 'text-danger' ?>">
                                        <?= htmlspecialchars($trajet['Distance']) ?> km
                                    </span>
                                    <input type="number" class="form-control edit-mode" data-field="Distance" 
                                           value="<?= $trajet['Distance'] ?>" style="display: none; width: 90px;" min="0">
                                </td>
                                <td>
                                    <span class="text-xs font-weight-bold display-mode"><?= htmlspecialchars($trajet['Duree']) ?></span>
                                    <input type="text" class="form-control edit-mode" data-field="Duree" 
                                           value="<?= $trajet['Duree'] ?>" style="display: none; width: 120px;">
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="ModifierTrajet.php?id=<?= $trajet['ID_Trajet'] ?>" 
                                                class="btn btn-blue btn-sm">
                                            <i class="fas fa-edit"></i> Modifier
                                        </a>
                                        <button onclick="confirmDelete(<?= $trajet['ID_Trajet'] ?>)" 
                                                class="btn btn-red btn-sm btn-delete">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </div>
                                </td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Section statistiques avec graphiques -->
            <div class="stats-container px-4 py-4">
                <div class="chart-wrapper">
                    <div class="chart-title">Répartition par adresse de départ</div>
                    <div class="canvas-container">
                        <canvas id="adressesChart"></canvas>
                    </div>
                </div>
                <div class="chart-wrapper">
                    <div class="chart-title">Répartition par nombre de places</div>
                    <div class="canvas-container">
                        <canvas id="placesChart"></canvas>
                    </div>
                </div>
                <div class="chart-wrapper">
                    <div class="chart-title">Répartition par tranche de prix</div>
                    <div class="canvas-container">
                        <canvas id="prixChart"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="card-footer bg-white border-0 pt-4 pb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <a href="?sort=Nombre_Places" class="btn btn-sm" style="border: 1px solid #0056b3; color: #0056b3; border-radius: 4px; padding: 6px 12px; margin-right: 10px;">
                            <i class="fas fa-sort-numeric-down me-1" id="sortIcon"></i> Trier par Places
                        </a>
                        <a href="javascript:void(0);" onclick="exportToPDF()" class="btn btn-sm" style="border: 1px solid #6c757d; color: #6c757d; border-radius: 4px; padding: 6px 12px;">
                            <i class="fas fa-file-pdf me-1"></i> Exporter en PDF
                        </a>
                    </div>
                    <div>
                        <a href="AjouterTrajet.php" class="btn btn-green btn-sm">
                            <i class="fas fa-plus me-1"></i> Ajouter un trajet
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="customPopup" class="custom-popup">
        <div class="popup-content">
            <span class="popup-message"></span>
            <div class="popup-actions">
                <button id="popupConfirm" class="btn btn-sm" style="margin-right: 10px; background: #28a745; color: white;">Oui</button>
                <button id="popupCancel" class="btn btn-sm" style="background: #dc3545; color: white;">Non</button>
            </div>
            <div class="popup-progress"></div>
        </div>
    </div>
</main>

<!-- Scripts -->
  <script src="back/assets/js/core/popper.min.js"></script>
  <script src="back/assets/js/core/bootstrap.min.js"></script>
  <script src="back/assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="back/assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="back/assets/js/material-dashboard.min.js"></script>
  <!-- Ajout de la bibliothèque Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
  <script>
    // Auto-hide alert
    document.addEventListener('DOMContentLoaded', function() {
      setTimeout(function() {
        const alert = document.querySelector('.alert-floating');
        if (alert) {
          const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
          bsAlert.close();
        }
      }, 5000);
    });
    
    // Fonction d'édition de trajet
    function toggleEditMode(trajetId) {
      const row = document.querySelector(`tr[data-id="${trajetId}"]`);
      const displayModes = row.querySelectorAll('.display-mode');
      const editModes = row.querySelectorAll('.edit-mode');
      
      // Vérifier si on est en mode édition
      const isEditing = row.getAttribute('data-editing') === 'true';
      
      if (isEditing) {
        // Sauvegarder les modifications
        // Ici vous pourriez ajouter une requête AJAX pour enregistrer les modifications
        row.setAttribute('data-editing', 'false');
        row.querySelector('.btn-edit').innerHTML = '<i class="fas fa-edit"></i> Modifier';
        
        // Mise à jour de l'affichage
        editModes.forEach(function(editMode, index) {
          displayModes[index].textContent = editMode.value;
          editMode.style.display = 'none';
          displayModes[index].style.display = '';
        });
        
        showPopup("Trajet modifié avec succès!", "success");
      } else {
        // Passer en mode édition
        row.setAttribute('data-editing', 'true');
        row.querySelector('.btn-edit').innerHTML = '<i class="fas fa-save"></i> Enregistrer';
        
        // Afficher les champs d'édition
        displayModes.forEach(function(displayMode, index) {
          displayMode.style.display = 'none';
          editModes[index].style.display = '';
        });
      }
    }
    
    // Fonction de suppression directe sans confirmation
    function confirmDelete(trajetId) {
      window.location.href = `DeleteTrajet.php?id=${trajetId}`;
    }
    
    // Fonction pour exporter en PDF
    function exportToPDF() {
      window.location.href = '../utils/export_trajets_pdf.php';
    }
    
    // Afficher une popup
    function showPopup(message, type) {
      const popup = document.getElementById('customPopup');
      popup.style.background = type === 'success' ? '#28a745' : '#dc3545';
      popup.querySelector('.popup-message').textContent = message;
      popup.style.display = 'block';
      
      setTimeout(() => {
        popup.style.display = 'none';
      }, 3000);
    }

    // Initialisation des graphiques
    document.addEventListener('DOMContentLoaded', function() {
      // Définition des couleurs attrayantes pour les graphiques
      const colors = [
        'rgba(54, 162, 235, 0.8)',
        'rgba(255, 99, 132, 0.8)',
        'rgba(255, 206, 86, 0.8)',
        'rgba(75, 192, 192, 0.8)',
        'rgba(153, 102, 255, 0.8)',
        'rgba(255, 159, 64, 0.8)',
        'rgba(199, 199, 199, 0.8)',
        'rgba(83, 102, 255, 0.8)',
        'rgba(40, 159, 64, 0.8)',
        'rgba(210, 99, 132, 0.8)'
      ];
      
      // Configuration du graphique des adresses de départ
      if (document.getElementById('adressesChart')) {
        const ctxAdresses = document.getElementById('adressesChart').getContext('2d');
        new Chart(ctxAdresses, {
          type: 'doughnut',
          data: {
            labels: <?= json_encode($adresses) ?>,
            datasets: [{
              data: <?= json_encode($nombreParAdresse) ?>,
              backgroundColor: colors.slice(0, <?= count($adresses) ?>),
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'right',
                labels: {
                  boxWidth: 12,
                  padding: 15,
                  font: {
                    size: 10
                  }
                }
              },
              tooltip: {
                callbacks: {
                  label: function(context) {
                    const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                    const percent = Math.round((context.raw / total) * 100);
                    return context.label + ': ' + context.raw + ' (' + percent + '%)';
                  }
                }
              }
            }
          }
        });
      }
      
      // Configuration du graphique des places
      if (document.getElementById('placesChart')) {
        const ctxPlaces = document.getElementById('placesChart').getContext('2d');
        new Chart(ctxPlaces, {
          type: 'pie',
          data: {
            labels: <?= json_encode($placesOptions) ?>,
            datasets: [{
              data: <?= json_encode($nombreParPlaces) ?>,
              backgroundColor: colors.slice(0, <?= count($placesOptions) ?>),
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                position: 'right',
                labels: {
                  boxWidth: 12,
                  padding: 15
                }
              },
              tooltip: {
                callbacks: {
                  label: function(context) {
                    const total = context.dataset.data.reduce((acc, val) => acc + val, 0);
                    const percent = Math.round((context.raw / total) * 100);
                    return context.label + ': ' + context.raw + ' (' + percent + '%)';
                  }
                }
              }
            }
          }
        });
      }
      
      // Configuration du graphique des prix
      if (document.getElementById('prixChart')) {
        const ctxPrix = document.getElementById('prixChart').getContext('2d');
        new Chart(ctxPrix, {
          type: 'bar',
          data: {
            labels: <?= json_encode($tranchesPrix) ?>,
            datasets: [{
              label: 'Nombre de trajets',
              data: <?= json_encode($nombreParPrix) ?>,
              backgroundColor: 'rgba(75, 192, 192, 0.5)',
              borderColor: 'rgba(75, 192, 192, 1)',
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
              y: {
                beginAtZero: true,
                ticks: {
                  precision: 0
                }
              }
            }
          }
        });
      }
    });
  </script>
</body>
</html>