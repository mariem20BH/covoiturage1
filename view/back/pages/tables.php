<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="/projetweb/view/back/assets/img/easyparki.png">
  <title>EasyParki - Dashboard</title>
  <link rel="icon" type="image/png" href="../assets/img/easyparki.png">
  <title>EasyParki - Covoiturage</title>

  
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

  
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <a href="covoiturage.php" class="btn btn-primary">FrontOffice</a>
  <style>
    .nav-item .nav-link {
      transition: all 0.3s ease;
    }
    .nav-item .nav-link:hover {
      background-color: rgba(9, 32, 87, 0.1);
    }
    .collapse ul {
      background-color: rgba(22, 9, 73, 0.62);
      border-radius: 0 0 8px 8px;
    }
    :root {
      --primary-dark: #0a1d37;
      --accent-blue: #4da6ff;
      --dark-blue: #001f3f;
    }
    body {
      background-color: #f8f9fa !important;
      color: black !important;
    }
    .sidenav {
      background-color: var(--primary-dark) !important;
    }
    .sidenav .nav-link,
    .sidenav .nav-link-text,
    .sidenav .navbar-brand span,
    .sidenav .material-symbols-rounded {
      color: black !important;
    }
    .navbar-main {
      background-color: var(--dark-blue) !important;
      border-bottom: 2px solid var(--accent-blue) !important;
      color: black !important;
    }
    .bg-gradient-primary {
      background: linear-gradient(195deg, var(--accent-blue), #3a8df1) !important;
    }
    .btn-primary {
      background-color: var(--dark-blue) !important;
    }
    .badge.bg-success {
      background-color: var(--accent-blue) !important;
    }
    body.bg-dark {
      background-color: #121212 !important;
      color: #ffffff !important;
    }
    .bg-dark .form-control,
    .bg-dark .form-select {
      background-color: #1e1e1e;
      color: #ffffff;
      border-color: #333333;
    }
    .bg-dark .table {
      background-color: #1e1e1e;
      color: #ffffff;
    }
    .bg-dark .card {
      background-color: #1e1e1e;
      color: #ffffff;
    }
    .bg-dark .btn-primary {
      background-color: #4da6ff;
      border-color: #4da6ff;
    }
    .bg-dark .form-check-label {
      color: #ffffff;
    }
    .alert {
      animation: fadeIn 0.5s ease-in-out;
      color: black !important;
    }
    .alert-success {
      background-color: #28a745 !important; /* Explicitly set to green */
      border-color: #28a745 !important;
      color: white !important; /* White text for better contrast */
    }
    .alert-warning {
      background-color: #ffc107 !important; /* Keep warning yellow */
      border-color: #ffc107 !important;
      color: black !important;
    }
    .alert-danger {
      background-color: #dc3545 !important; /* Keep error red */
      border-color: #dc3545 !important;
      color: white !important;
    }
    .card-header.bg-primary {
      background-color: var(--dark-blue) !important;
      color: white !important;
    }
    .card-header.bg-primary h5 {
      color: black !important;
    }
    .form-check-label {
      color: black !important;
    }
    .table th,
    .table td {
      color: black !important;
    }
    .station-warning {
      color: red;
      font-size: 0.8em;
    }
    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    /* Custom button styles for Modifier and Supprimer */
    .btn-modifier {
      background-color: #28a745 !important;
      border: none;
      color: white !important;
      padding: 8px 16px;
      border-radius: 4px;
      font-size: 14px;
      font-weight: 500;
      transition: background-color 0.3s ease;
    }
    .btn-modifier:hover {
      background-color: #218838 !important;
    }
    .btn-supprimer {
      background-color: #dc3545 !important;
      border: none;
      color: white !important;
      padding: 8px 16px;
      border-radius: 4px;
      font-size: 14px;
      font-weight: 500;
      transition: background-color 0.3s ease;
    }
    .btn-supprimer:hover {
      background-color: #c82333 !important;
    }
  </style>
</head>
<body class="g-sidenav-show bg-gray-100">

<style>
    .search-section {
        margin-bottom: 20px;
        padding: 15px;
        background-color: #f3faff;
        border-radius: 10px;
        width: fit-content;
    }
    .error-message {
        color: red;
        font-weight: bold;
        margin-top: 10px;
        display: none;
        transition: opacity 0.5s;
    }
</style>

<div class="search-section">
    <form method="GET" action="tables.php">
        <label for="idRecherche">🔍 Entrer l'ID :</label>
        <input type="number" name="idRecherche" id="idRecherche" required>

        <select name="typeRecherche">
            <option value="inscription">Inscription</option>
            <option value="trajet">Trajet</option>
        </select>

        <button type="submit" name="btnRecherche">Rechercher</button>
    </form>

    <div id="error" class="error-message">❌ Aucune donnée trouvée avec cet ID.</div>
</div>
<?php
include '../controller/InscriptionC.php';
include '../controller/TrajetC.php';

if (isset($_GET['btnRecherche']) && isset($_GET['idRecherche']) && isset($_GET['typeRecherche'])) {
    $id = intval($_GET['idRecherche']);
    $type = $_GET['typeRecherche'];

    if ($type == "inscription") {
        $inscriptionC = new InscriptionC();
        $result = $inscriptionC->rechercherInscriptionParID($id);
        if ($result) {
            echo "<h4>Résultat de l'inscription (ID : $id)</h4>";
            echo "<table border='1' cellpadding='8'><tr>
                    <th>ID</th><th>Téléphone</th><th>Catégorie</th><th>Date Réservation</th><th>Paiement</th>
                  </tr><tr>";
            echo "<td>".$result['ID']."</td>";
            echo "<td>".$result['Telephone']."</td>";
            echo "<td>".$result['Categorie']."</td>";
            echo "<td>".$result['DateReservation']."</td>";
            echo "<td>".$result['Paiement']."</td>";
            echo "</tr></table>";
        } else {
            echo "<script>document.getElementById('error').style.display = 'block';
                          setTimeout(() => document.getElementById('error').style.display = 'none', 4000);
                  </script>";
        }
    }

    if ($type == "trajet") {
        $trajetC = new TrajetC();
        $result = $trajetC->rechercherTrajetParID($id);
        if ($result) {
            echo "<h4>Résultat du trajet (ID : $id)</h4>";
            echo "<table border='1' cellpadding='8'><tr>
                    <th>ID</th><th>Adresse Départ</th><th>Adresse Arrivée</th><th>Date</th><th>Heure</th>
                  </tr><tr>";
            echo "<td>".$result['ID']."</td>";
            echo "<td>".$result['AdresseDepart']."</td>";
            echo "<td>".$result['AdresseArrivee']."</td>";
            echo "<td>".$result['Date']."</td>";
            echo "<td>".$result['Heure']."</td>";
            echo "</tr></table>";
        } else {
            echo "<script>document.getElementById('error').style.display = 'block';
                          setTimeout(() => document.getElementById('error').style.display = 'none', 4000);
                  </script>";
        }
    }
}
?>


<?php

require_once 'C:/xampp/htdocs/webproj/controller/TrajetC.php';
$tC = new TrajetC();

// Traitement de la suppression
if (isset($_POST['supprimerTrajet']) && isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    $tC->DeleteTrajet($id);
    header("Location: tables.php"); // Redirection pour éviter la resoumission
    exit();
}

// Récupération des trajets (pour l'affichage)
$listeTrajets = $tC->ListeTrajet();
?>


<?php
require_once 'C:/xampp/htdocs/webproj/config.php';
require_once 'C:/xampp/htdocs/webproj/controller/InscriptionC.php';
require_once 'C:/xampp/htdocs/webproj/model/Inscription.php';

$inscriptionC = new InscriptionC();

$id = '';
$telephone = '';
$categorie = '';
$dateReservation = '';
$paiement = '';

$message = '';
if (isset($_POST['addInscription'])) {
  
  $telephone = $_POST['Telephone'];
  $categorie = $_POST['Categorie'];
  $dateReservation = $_POST['DateReservation'];
  $paiement = $_POST['Paiement'];

  
  if (filter_var($telephone, FILTER_VALIDATE_INT)) {
      
      $inscription = new Inscription(null, $telephone, $categorie, $dateReservation, $paiement);

      
      $inscriptionC->AjouterInscription($inscription);

      $message = "✅ Inscription ajoutée avec succès.";
  } else {
      $message = "❌ Le numéro de téléphone doit contenir uniquement des chiffres.";
  }
}





if (isset($_POST['updateInscription'])) {
  
  if (!empty($_POST['ID']) && isset($_POST['Telephone'], $_POST['Categorie'], $_POST['DateReservation'], $_POST['Paiement'])) {
      $id = (int)$_POST['ID'];
      $telephone = (int)$_POST['Telephone'];
      $categorie = $_POST['Categorie'];
      $dateReservation = $_POST['DateReservation'];
      $paiement = $_POST['Paiement'];
      
      
      error_log("Updating inscription $id with: Telephone=$telephone, Categorie=$categorie, DateReservation=$dateReservation, Paiement=$paiement");
      
      if ($inscriptionC->updateInscription($id, $telephone, $categorie, $dateReservation, $paiement)) {
          $message = "✅ Inscription mise à jour avec succès!";
      } else {
          $message = "❌ Erreur lors de la mise à jour";
      }
  } else {
      $message = "❌ Tous les champs sont requis pour la mise à jour";
  }
  
  
  $inscriptions = $inscriptionC->ListeInscription();
}


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deleteInscription'])) {
      $idToDelete = $_POST['IDToDelete'];
      if (!empty($idToDelete) && is_numeric($idToDelete)) {
          $inscriptionExistante = $inscriptionC->GetInscription($idToDelete);
          if ($inscriptionExistante) {
              $inscriptionC->DeleteInscription($idToDelete);
              $message = "✅ Inscription avec l'ID $idToDelete supprimée avec succès.";
          } else {
              $message = "❌ Aucune inscription trouvée avec l'ID $idToDelete.";
          }
      } else {
          $message = '❌ Entrez un ID valide pour supprimer.';
      }
  }

  $inscriptions = $inscriptionC->ListeInscription();
  ?>





<?php if (!empty($message)): ?>
    <script type="text/javascript">
        alert("<?php echo $message; ?>");
    </script>
<?php endif; ?>

  <?php if (!empty($message)): ?>
      <div class="alert alert-success" role="alert">
          <?= htmlspecialchars($message) ?>
      </div>
  <?php endif; ?>


 
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start" id="sidenav-main">
  <div class="sidenav-header">
    <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
    <a class="navbar-brand px-4 py-3 m-0" href="#">
      <img src="../assets/img/easyparki.png" class="navbar-brand-img" width="50">
      <span class="ms-1 text-white">EasyParki</span>
    </a>
  </div>
  <hr class="horizontal light mt-0 mb-2">
  <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <?php
        $currentPage = basename($_SERVER['PHP_SELF']); // ex: covoiturage.php
        function isActive($file) {
          global $currentPage;
          return $currentPage === $file ? 'active bg-gradient-primary text-white' : '';
        }
      ?>

      <li class="nav-item">
        <a class="nav-link <?= isActive('dashboard.php') ?>" href="dashboard.php">
          <i class="material-symbols-rounded opacity-5">dashboard</i>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= isActive('tables.php') ?>" href="tables.php">
          <i class="material-symbols-rounded opacity-5">electric_car</i>
          <span class="nav-link-text ms-1">covoiturage</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= isActive('transport.php') ?>" href="transport.php">
          <i class="material-symbols-rounded opacity-5">directions_bus</i>
          <span class="nav-link-text ms-1">Transport Public</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= isActive('covoiturage.php') ?>" href="covoiturage.php">
          <i class="material-symbols-rounded opacity-5">carpool</i>
          <span class="nav-link-text ms-1">Covoiturage</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= isActive('recharge.php') ?>" href="recharge.php">
          <i class="material-symbols-rounded opacity-5">electric_car</i>
          <span class="nav-link-text ms-1">Recharge électrique</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= isActive('evenement.php') ?>" href="evenement.php">
          <i class="material-symbols-rounded opacity-5">event</i>
          <span class="nav-link-text ms-1">Evenement</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= isActive('notifications.php') ?>" href="notifications.php">
          <i class="material-symbols-rounded opacity-5">notifications</i>
          <span class="nav-link-text ms-1">Notifications</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= isActive('services.php') ?>" href="services.php">
          <i class="material-symbols-rounded opacity-5">build</i>
          <span class="nav-link-text ms-1">Services</span>
        </a>
      </li>

      <li class="nav-item mt-3">
        <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">Pages Compte</h6>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= isActive('profile.php') ?>" href="profile.php">
          <i class="material-symbols-rounded opacity-5">person</i>
          <span class="nav-link-text ms-1">Profil</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= isActive('sign-in.php') ?>" href="sign-in.php">
          <i class="material-symbols-rounded opacity-5">login</i>
          <span class="nav-link-text ms-1">Connexion</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= isActive('sign-up.php') ?>" href="sign-up.php">
          <i class="material-symbols-rounded opacity-5">assignment</i>
          <span class="nav-link-text ms-1">Inscription</span>
        </a>
      </li>
    </ul>
  </div>
  <div class="sidenav-footer position-absolute w-100 bottom-0">
    <div class="mx-3">
      <a class="btn btn-outline-white mt-4 w-100" href="#">FrontOffice</a>
    </div>
  </div>
</aside>


  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
   
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <h6 class="font-weight-bolder mb-0">Dashboard</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <label class="form-label">Rechercher...</label>
              <input type="text" class="form-control">
            </div>
          </div>
          <ul class="navbar-nav justify-content-end">
            <li class="nav-item d-flex align-items-center">
              <a href="../pages/profile.html" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Profil</span>
              </a>
            </li>
            <li class="nav-item px-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0">
                <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
              </a>
            </li>
            <li class="nav-item dropdown pe-2 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-bell cursor-pointer"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end px-2 py-3 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" href="javascript:;">
                    <div class="d-flex py-1">
                      <div class="my-auto">
                        <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3">
                      </div>
                      <div class="d-flex flex-column justify-content-center">
                        <h6 class="text-sm font-weight-normal mb-1">
                          <span class="font-weight-bold">Nouvelle notification</span>
                        </h6>
                        <p class="text-xs text-secondary mb-0">
                          <i class="fa fa-clock me-1"></i>
                          il y a 13 minutes
                        </p>
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>

   



    <?php
require_once 'C:/xampp/htdocs/webproj/controller/TrajetC.php';
require_once 'C:/xampp/htdocs/webproj/model/Trajet.php';
require_once 'C:/xampp/htdocs/webproj/config.php';

$msg = "";
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
        $pdo = Config::getConnexion();
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM inscription WHERE ID = ?");
        $stmt->execute([$_POST["ID_Inscription"]]);
        $inscriptionExist = $stmt->fetchColumn();

        if ($inscriptionExist == 0) {
            $msg = "Erreur : L'ID d'inscription n'existe pas dans la base de données.";
        } elseif (strlen($_POST["AdresseArrivee"]) < 4) {
            $msg = "Erreur : L'adresse d'arrivée doit contenir au moins 4 caractères.";
        } elseif (!is_numeric($_POST["Prix"]) || $_POST["Prix"] <= 0) {
            $msg = "Erreur : Le prix doit être un nombre positif et en dinars.";
        } 
        // ✅ Vérification du nombre de places
        elseif (!is_numeric($_POST["NombrePlaces"]) || intval($_POST["NombrePlaces"]) <= 0) {
            $msg = "Erreur : Le nombre de places doit être un entier positif.";
        }
        elseif (!is_numeric($_POST["Distance"]) || $_POST["Distance"] <= 0) {
            $msg = "Erreur : La distance doit être un nombre positif.";
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

            $pc = new TrajetC();
            $pc->AjouterTrajet($trajet);
            $msg = "Trajet ajouté avec succès ✅";
        }
    } else {
        $msg = "Veuillez remplir tous les champs.";
    }
}


$tc = new TrajetC();
$listeTrajets = $tc->ListeTrajet();
?>


<?php
require_once 'C:/xampp/htdocs/webproj/controller/TrajetC.php';
$trajetC = new TrajetC();

if (isset($_POST['modifierTrajet'])) {
    $trajetC->updateTrajet([
        'ID_Trajet' => $_POST['ID_Trajet'],
        'Adresse_Arrivee' => $_POST['AdresseArrivee'],
        'Nombre_Places' => $_POST['NombrePlaces'],
        'Prix' => $_POST['Prix'],
        'Distance' => $_POST['Distance'],
        'Duree' => $_POST['Duree']
    ]);

    // Recharge la page pour voir les nouvelles valeurs
    echo "<script>window.location.href='tables.php';</script>";
    exit();
}
?>
<?php

require_once 'C:/xampp/htdocs/webproj/controller/TrajetC.php';
$tC = new TrajetC();

// Traitement de la suppression
if (isset($_POST['supprimerTrajet']) && isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    $trajetC->DeleteTrajet($id);
    header("Location: tables.php?deleted=1");
    // Redirection pour éviter la resoumission
    exit();
}

// Récupération des trajets (pour l'affichage)
$listeTrajets = $tC->ListeTrajet();
?> 






<?php if (isset($_GET['deleted']) && $_GET['deleted'] == 1): ?>
    <div id="message-suppression" style="
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: #007bff;
        color: #4b0082;
        padding: 10px 20px;
        border-radius: 8px;
        font-size: 16px;
        font-family: sans-serif;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        gap: 10px;
        z-index: 9999;
    ">
        Trajet supprimé avec succès
        <span style="
            background-color: #00e676;
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 14px;
        ">✅</span>
    </div>

    <script>
        setTimeout(function () {
            var message = document.getElementById("message-suppression");
            if (message) {
                message.style.transition = "opacity 1s ease";
                message.style.opacity = 0;
                setTimeout(function () {
                    message.remove();
                }, 1000);
            }
        }, 4000);
    </script>
<?php endif; ?>










<div class="card p-4">
    <h4>Ajouter un nouveau trajet</h4>
    <?php if ($msg != ""): ?>
        <p id="msg" style="color: blue;"><?= htmlspecialchars($msg) ?></p>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label>ID_Inscription</label>
            <input type="text" name="ID_Inscription" class="form-control">
        </div>
        <div class="mb-3">
            <label for="AdresseDepart">Adresse Depart :</label>
            <select name="AdresseDepart" id="AdresseDepart">
                <option value="">-- Sélectionnez une adresse --</option>
                <option value="Parking de l'aéroport">Parking de l'aéroport</option>
                <option value="Parking Tunis City">Parking Tunis City</option>
                <option value="Parking Municipal">Parking Municipal</option>
                <option value="Centre Urbain Nord">Centre Urbain Nord</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Adresse Arrivée</label>
            <input type="text" name="AdresseArrivee" class="form-control">
        </div>
        <div class="mb-3">
            <label>Nombre de places</label>
            <input type="text" name="NombrePlaces" class="form-control">
        </div>
        <div class="mb-3">
            <label>Prix (Dinars)</label>
            <input type="text" name="Prix" class="form-control">
        </div>
        <div class="mb-3">
            <label>Distance (km)</label>
            <input type="text" name="Distance" class="form-control">
        </div>
        <div class="mb-3">
            <label>Duree (HH:MM:SS)</label>
            <input type="text" name="Duree" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Ajouter</button>
    </form>
</div>


<div class="card p-4" style="flex: 1;">
    <h4>Liste des trajets</h4>
    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Inscription</th>
                <th>Départ</th>
                <th>Arrivée</th>
                <th>Places</th>
                <th>Prix (DT)</th>
                <th>Distance (km)</th>
                <th>Durée</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
<?php foreach ($listeTrajets as $trajet): ?>
    <tr>
        <!-- Formulaire de modification -->
        <form method="POST">
            <input type="hidden" name="ID_Trajet" value="<?= $trajet['ID_Trajet'] ?>">
            <td><?= $trajet['ID_Trajet'] ?></td>
            <td><?= $trajet['ID_Inscription'] ?></td>
            <td>
    <select name="AdresseDepart" class="form-select">
        <option value="">-- Sélectionnez une adresse --</option>
        <option value="Parking de l'aéroport" <?= $trajet['Adresse_Depart'] == "Parking de l'aéroport" ? 'selected' : '' ?>>Parking de l'aéroport</option>
        <option value="Parking Tunis City" <?= $trajet['Adresse_Depart'] == "Parking Tunis City" ? 'selected' : '' ?>>Parking Tunis City</option>
        <option value="Parking Municipal" <?= $trajet['Adresse_Depart'] == "Parking Municipal" ? 'selected' : '' ?>>Parking Municipal</option>
        <option value="Centre Urbain Nord" <?= $trajet['Adresse_Depart'] == "Centre Urbain Nord" ? 'selected' : '' ?>>Centre Urbain Nord</option>
    </select>
</td>
            <td><input type="text" name="AdresseArrivee" value="<?= htmlspecialchars($trajet['Adresse_Arrivee']) ?>" class="form-control" /></td>
            <td><input type="number" name="NombrePlaces" value="<?= htmlspecialchars($trajet['Nombre_Places']) ?>" class="form-control" style="width: 70px;" /></td>
            <td><input type="text" name="Prix" value="<?= htmlspecialchars($trajet['Prix']) ?>" class="form-control" style="width: 80px;" /></td>
            <td><input type="text" name="Distance" value="<?= htmlspecialchars($trajet['Distance']) ?>" class="form-control" style="width: 80px;" /></td>
            <td><input type="text" name="Duree" value="<?= htmlspecialchars($trajet['Duree']) ?>" class="form-control" style="width: 100px;" /></td>
            <td>
                <button type="submit" name="modifierTrajet" class="btn btn-warning btn-sm">Modifier</button>
        </form>

        <!-- Formulaire de suppression (séparé) -->
        <form method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet ?');" style="display:inline;">
            <input type="hidden" name="delete_id" value="<?= $trajet['ID_Trajet'] ?>">
            <button type="submit" name="supprimerTrajet" class="btn btn-sm btn-outline-danger">Supprimer</button>
        </form>
            </td>
    </tr>
<?php endforeach; ?>
</tbody>

    </table>
</div>



<!-- Style du message -->
<style>
#msg {
    position: fixed;
    top: 20px;
    right: 20px;
    background-color: #007bff;
    color: white;
    padding: 15px 25px;
    border-radius: 8px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    z-index: 1000;
    font-family: 'Segoe UI', sans-serif;
    font-size: 15px;
    display: none;
}
</style>

<!-- Script pour faire disparaître le message après 4 secondes -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    var msg = document.getElementById("msg");
    if (msg) {
        msg.style.display = "block"; // Afficher le message
        setTimeout(function() {
            msg.style.display = "none"; // Cacher le message après 4 secondes
        }, 4000);
    }
});
</script>


    <div class="container-fluid py-4">
      
      <div class="row">
        <div class="col-12">
          
          <?php
require_once '../../../controller/InscriptionC.php';
$inscriptionC = new InscriptionC();


if (isset($_POST['delete_id'])) {
  $inscriptionC->deleteInscription($_POST['delete_id']);
  echo "<script>window.location.href='tables.php';</script>";
  exit;
}

$liste = $inscriptionC->listeInscription();
?>

<div class="card shadow-sm border-0 mb-4">
  <div class="card-header bg-white py-3">
    <h5 class="mb-1 text-dark fw-bold">📋 Liste des Inscriptions</h5>
    <small class="text-muted">Toutes les inscriptions enregistrées dans le système</small>
  </div>

  <div class="card-body table-responsive">
    <table class="table table-hover align-middle text-center">
      <thead class="table-light">
        <tr>
          <th>ID</th>
          <th>Telephone</th>
          <th>Categorie</th>
          <th>DateReservation</th>
          <th>Paiement</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($liste)) : ?>
          <?php foreach ($liste as $inscription) : ?>
            <tr>
              <td class="fw-bold text-secondary"><?= htmlspecialchars($inscription['ID']) ?></td>
              <td><?= htmlspecialchars($inscription['Telephone']) ?></td>
              <td>
                <span class="badge rounded-pill 
                    <?= $inscription['Categorie'] == 'Privé' ? 'bg-success' : 'bg-info' ?>">
                  <?= htmlspecialchars($inscription['Categorie']) ?>
                </span>
              </td>
              <td>
                <span class="text-nowrap">
                  <?= date('d/m/Y H:i', strtotime($inscription['DateReservation'])) ?>
                </span>
              </td>
              <td>
                <span class="badge rounded-pill 
                    <?= $inscription['Paiement'] == 'Carte' ? 'bg-primary' : 'bg-warning text-dark' ?>">
                  <?= htmlspecialchars($inscription['Paiement']) ?>
                </span>
              </td>
              <td>
                <form method="post" onsubmit="return confirm('Supprimer cette inscription ?');" style="display:inline;">
                  <input type="hidden" name="delete_id" value="<?= $inscription['ID'] ?>">
                  <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>


        

</form>
</body>
</html>


        
        