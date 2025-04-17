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

  <!-- Fonts and icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <a href="covoiturage.php" class="btn btn-primary">FrontOffice</a>
  <style>

:root {
  --primary-dark: #f06292; /* Rose doux pour l'arrière-plan */
  --accent-pink: #f8bbd0; /* Rose clair pour accent */
  --dark-pink: #d81b60; /* Rose foncé pour une touche élégante */
  --light-pink: #f8bbd0; /* Rose très clair */
  --bg-pink: #fce4ec; /* Rose très doux pour fond */
  --dashboard-bg: #f1f8e9; /* Fond du dashboard (rose léger avec nuance de rose) */
  --rose-main: #f8d7da; /* Rose principal */
  --rose-accent: #f06292; /* Rose accentué */
  --text-dark: #880e4f; /* Texte en rose foncé */
  --button-bg: #f48fb1; /* Couleur de fond pour les boutons */
}

body {
  background-color: var(--bg-pink) !important; /* Fond de la page en rose doux */
  color: var(--text-dark) !important;  /* Texte en rose foncé */
}

.sidenav, .navbar-main {
  background-color: var(--primary-dark) !important; /* Fond du sidenav et navbar en rose foncé */
}

.sidenav .nav-link, .navbar-main .nav-link {
  color: white !important; /* Texte blanc dans la sidebar et navbar */
}

.table {
  width: 100%;
  margin-bottom: 20px;
  background-color: #ffffff;  /* Fond blanc pour la table */
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.table th,
.table td {
  color: var(--text-dark) !important; /* Texte en rose foncé dans la table */
  padding: 12px;
  text-align: center;
  font-size: 16px;
}

.table th {
  background-color: var(--primary-dark); /* En-têtes en rose foncé */
  color: white;  /* Texte blanc pour les en-têtes */
  font-weight: bold;
}

.table td {
  background-color: var(--accent-pink); /* Cellules avec fond rose clair */
}

.table tr:nth-child(even) td {
  background-color: var(--light-pink); /* Cellules paires avec fond rose plus clair */
}

.table tr:nth-child(odd) td {
  background-color: var(--bg-pink); /* Cellules impaires avec fond rose très doux */
}

.table tr:hover {
  background-color: var(--rose-accent); /* Survol avec un rose accentué */
  color: white;  /* Texte en blanc lors du survol */
}

.table .btn {
  background-color: var(--rose-main); /* Boutons dans la table avec un rose doux */
  border: none;
  color: white;
  padding: 8px 16px;
  border-radius: 5px;
  text-align: center;
}

.table .btn:hover {
  background-color: var(--rose-accent); /* Changement au survol du bouton */
}

.table .btn:focus {
  outline: none;
}

.card {
  background-color: #ffffff;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  padding: 20px;
  margin-bottom: 30px;
}

.card-header.bg-primary {
  background-color: var(--rose-accent) !important;
  color: white !important; /* Texte blanc dans les en-têtes des cartes */
}

.card-header.bg-primary h5 {
  color: white !important; /* Texte de l'en-tête en blanc */
}

.bg-dark {
  background-color: var(--bg-pink);
  color: var(--text-dark);
}

.bg-dark .form-control,
.bg-dark .form-select {
  background-color: #ffffff;
  color: var(--text-dark);
  border-color: var(--primary-dark);
}

.bg-dark .table {
  background-color: #ffffff;
  color: var(--text-dark);
}

.bg-dark .card {
  background-color: var(--bg-pink);
  color: var(--text-dark);
}

.bg-dark .btn-primary {
  background-color: var(--rose-accent);
  border-color: var(--rose-accent);
}

.bg-dark .form-check-label {
  color: var(--text-dark);
}


  </style>
</head>
<body class="g-sidenav-show bg-gray-100">



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
  // Récupérer les données du formulaire
  $telephone = $_POST['Telephone'];
  $categorie = $_POST['Categorie'];
  $dateReservation = $_POST['DateReservation'];
  $paiement = $_POST['Paiement'];

  // Vérifier que le téléphone est un entier valide
  if (filter_var($telephone, FILTER_VALIDATE_INT)) {
      // Créer l'objet Inscription
      $inscription = new Inscription(null, $telephone, $categorie, $dateReservation, $paiement);

      // Ajouter l'inscription via le contrôleur
      $inscriptionC->AjouterInscription($inscription);

      $message = "✅ Inscription ajoutée avec succès.";
  } else {
      $message = "❌ Le numéro de téléphone doit contenir uniquement des chiffres.";
  }
}





if (isset($_POST['updateInscription'])) {
  // Verify all required fields are present
  if (!empty($_POST['ID']) && isset($_POST['Telephone'], $_POST['Categorie'], $_POST['DateReservation'], $_POST['Paiement'])) {
      $id = (int)$_POST['ID'];
      $telephone = (int)$_POST['Telephone'];
      $categorie = $_POST['Categorie'];
      $dateReservation = $_POST['DateReservation'];
      $paiement = $_POST['Paiement'];
      
      // Debug output (remove after testing)
      error_log("Updating inscription $id with: Telephone=$telephone, Categorie=$categorie, DateReservation=$dateReservation, Paiement=$paiement");
      
      if ($inscriptionC->updateInscription($id, $telephone, $categorie, $dateReservation, $paiement)) {
          $message = "✅ Inscription mise à jour avec succès!";
      } else {
          $message = "❌ Erreur lors de la mise à jour";
      }
  } else {
      $message = "❌ Tous les champs sont requis pour la mise à jour";
  }
  
  // Refresh the data
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




<!-- Affichage du message d'erreur ou de succès -->
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


 <!-- Sidebar -->
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
          <span class="nav-link-text ms-1">Service</span>
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
    <!-- Navbar -->
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

    <!-- Contenu principal -->
    <div class="container-fluid py-4">
      <!-- Section Services -->
      <div class="row">
        <div class="col-12">
          <!-- Statistiques -->
          <?php
require_once '../../../controller/InscriptionC.php';
$inscriptionC = new InscriptionC();

// Suppression si nécessaire
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


        
        