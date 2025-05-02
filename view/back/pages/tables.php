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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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
      /* Désactiver la barre de défilement */
      overflow-y: auto;
      scrollbar-width: none; /* Pour Firefox */
      -ms-overflow-style: none; /* Pour Internet Explorer et Edge */
    }
    /* Pour Chrome, Safari et Opera */
    .sidenav::-webkit-scrollbar {
      display: none;
      width: 0;
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
      color: white !important; 
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

<a href="covoiturage.php" class="btn btn-primary m-3">FrontOffice</a>

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
  </style>

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
              <a href="../../AjouterTrajet.php" class="nav-link text-white active bg-gradient-primary opacity-8">
                <i class="fas fa-plus-circle me-2"></i> Ajouter un trajet
              </a>
            </li>
            <li class="nav-item">
              <a href="../../ListeTrajet.php" class="nav-link text-white">
                <i class="fas fa-list me-2"></i> Liste des trajets
              </a>
            </li>
         
            <li class="nav-item">
              <a href="../../ListeInscription.php" class="nav-link text-white">
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

</body>

</html>









