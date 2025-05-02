<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/easyparki.png">
  <title>EasyParki - Dashboard</title>
  
  <!-- Fonts and icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <link href="assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
  <style>
   :root {
      --primary-dark: #0f172a;
      --accent-blue: #3b82f6;
      --accent-pink: #ec4899;
      --gradient-primary: linear-gradient(135deg, var(--accent-blue), var(--accent-pink));
    }

    
    body {
      background-color: #f8f9fa !important;
    }

    /* Sidebar submenu styling */
    .sidenav .nav-item.has-submenu {
      position: relative;
    }
    
    .sidenav .submenu {
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
    
    .sidenav .nav-item.has-submenu:hover .submenu {
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
    
    .sidenav {
      background-color: var(--primary-dark) !important;
    }
    
    .sidenav .nav-link,
    .sidenav .nav-link-text,
    .sidenav .navbar-brand span,
    .sidenav .material-symbols-rounded {
      color: white !important;
    }
    
    .navbar-main {
      background-color: var(--primary-dark) !important;
      border-bottom: 2px solid var(--accent-blue) !important;
    }
    
    .form-container {
      background: white;
      border-radius: 12px;
      padding: 25px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
      margin-bottom: 30px;
    }
    
    .table-responsive {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.05);
      padding: 15px;
    }
    
    #transport-tab {
      border: 2px solid var(--accent-blue);
      border-radius: 8px;
      margin-right: 10px;
      padding: 8px 20px;
      background-color: rgba(77, 166, 255, 0.1);
      transition: all 0.3s ease;
    }
    
    #transport-tab.active {
      background-color: var(--accent-blue) !important;
      color: white !important;
    }
    
    #transport-tab:hover:not(.active) {
      background-color: rgba(77, 166, 255, 0.2);
    }
    
    .bg-gradient-primary {
      background: linear-gradient(195deg, var(--accent-blue), #3a8df1) !important;
    }
    
    .btn-primary {
      background-color: var(--accent-blue) !important;
    }
    
    .badge.bg-success {
      background-color: var(--accent-blue) !important;
    }
    .bg-rose {
      background-color: var(--accent-blue) !important;
      color: white !important;
    }

    /* Stats Cards */
    .stats-card {
      border-radius: 16px;
      padding: 20px;
      margin-bottom: 24px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      height: 100%;
      position: relative;
      overflow: hidden;
    }

    .stats-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 12px 20px rgba(0, 0, 0, 0.12);
    }

    .stats-card .card-icon {
      width: 60px;
      height: 60px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      margin-bottom: 15px;
    }

    .stats-card .card-title {
      font-size: 14px;
      color: #6c757d;
      margin-bottom: 8px;
      font-weight: 600;
    }

    .stats-card .card-value {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 10px;
      color: #343a40;
    }

    .stats-card .card-change {
      display: flex;
      align-items: center;
      font-size: 13px;
      font-weight: 500;
    }

    .stats-card .card-change.up {
      color: #28a745;
    }

    .stats-card .card-change.down {
      color: #dc3545;
    }

    .stats-card .chart-container {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      height: 80px;
    }

    /* Notifications Card */
    .notifications-card {
      border-radius: 16px;
      padding: 20px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.08);
      height: 100%;
    }

    .notifications-card .card-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .notifications-card .card-title {
      font-size: 18px;
      font-weight: 700;
      color: #343a40;
      margin: 0;
    }

    .notifications-card .badge {
      background-color: var(--accent-blue) !important;
    }

    .notification-item {
      display: flex;
      padding: 12px 0;
      border-bottom: 1px solid #f1f1f1;
      align-items: flex-start;
    }

    .notification-item:last-child {
      border-bottom: none;
    }

    .notification-item .icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
      flex-shrink: 0;
    }

    .notification-item .content {
      flex-grow: 1;
    }

    .notification-item .title {
      font-weight: 600;
      margin-bottom: 4px;
      color: #343a40;
    }

    .notification-item .time {
      font-size: 12px;
      color: #6c757d;
    }

    /* Grid Layout */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 24px;
      margin-top: 24px;
    }

    @media (max-width: 992px) {
      .stats-grid {
        grid-template-columns: repeat(2, 1fr);
      }
    }

    @media (max-width: 768px) {
      .stats-grid {
        grid-template-columns: 1fr;
      }
    }
    .bg-gradient-blue {
  background: linear-gradient(87deg, #1e3c72 0%, #2a5298 100%);
  color: white !important;
}

  </style>
</head>

<body class="g-sidenav-show bg-gray-100">
  <!-- Sidebar -->
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 fixed-start" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href="tables.html">
        <img src="../assets/img/easyparki.png" class="navbar-brand-img" width="50">
        <span class="ms-1 text-white">EasyParki</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" href="../pages/dashboard.html">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../pages/billing.html">
            <i class="material-symbols-rounded opacity-5">receipt_long</i>
            <span class="nav-link-text ms-1">Stationnement</span>
          </a>
        </li>
        <!-- Vacances Menu with Submenu -->
        <li class="nav-item has-submenu">
        <a class="nav-link active bg-gradient-blue text-white" href="javascript:;">
  <i class="material-symbols-rounded opacity-5">directions_bus</i>
  <span class="nav-link-text ms-1">Vacances</span>
</a>

          <div class="submenu">
            <a href="addHotel.php" class="submenu-item">
              <i class="fas fa-hotel"></i>
              Ajouter un Hotel
            </a>
            <a href="addplanVacance.php" class="submenu-item">
              <i class="fas fa-calendar-plus"></i>
              Ajouter un plan de Vacances
            </a>
            <a href="listHotels.php" class="submenu-item">
              <i class="fas fa-list"></i>
              Liste des Hotels
            </a>
            <a href="listplanVacance.php" class="submenu-item">
              <i class="fas fa-clipboard-list"></i>
              Liste des Plans de Vacances
            </a>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/billing.html">
            <i class="material-symbols-rounded opacity-5">receipt_long</i>
            <span class="nav-link-text ms-1">Covoiturage</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/virtual-reality.html">
            <i class="material-symbols-rounded opacity-5">view_in_ar</i>
            <span class="nav-link-text ms-1">Service</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/rtl.html">
            <i class="material-symbols-rounded opacity-5">format_textdirection_r_to_l</i>
            <span class="nav-link-text ms-1">Evenement</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/notifications.html">
            <i class="material-symbols-rounded opacity-5">notifications</i>
            <span class="nav-link-text ms-1">Notifications</span>
          </a>
        </li>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-white font-weight-bolder opacity-5">Account pages</h6>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/profile.html">
            <i class="material-symbols-rounded opacity-5">person</i>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/sign-in.html">
            <i class="material-symbols-rounded opacity-5">login</i>
            <span class="nav-link-text ms-1">Sign In</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-dark" href="../pages/sign-up.html">
            <i class="material-symbols-rounded opacity-5">assignment</i>
            <span class="nav-link-text ms-1">Sign Up</span>
          </a>
        </li>
      </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0">
      <div class="mx-3">
        <a class="btn btn-outline-white mt-4 w-100" href="http://localhost/webproj/view/front/Logis/about.php">FrontOffice</a>
      </div>
    </div>
  </aside>

  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" id="navbarBlur">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-white active">Vacances</li>
          </ol>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <label class="form-label">Rechercher...</label>
              <input type="text" class="form-control">
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Stats Cards -->
    <div class="container-fluid py-4">
      <div class="stats-grid">
        <?php
        require $_SERVER['DOCUMENT_ROOT'] . '/webproj/config.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/webproj/model/Hotel.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/webproj/controller/HotelC.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/webproj/model/PlanVacance.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/webproj/controller/PlanVacanceC.php';

        // Initialize controllers
        $hotelController = new HotelC();
        $planController = new PlanVacanceC();

        // Get counts from database
        $hotelCount = count($hotelController->listHotels()); // Compte les hôtels
        $planCount = count($planController->listPlans()); 

        // Calculate percentage changes (you would need to implement these methods)
        $hotelChange = calculateHotelChange(); // Implement this function
        $planChange = calculatePlanChange();   // Implement this function

        // Get recent activities
        $recentActivities = getRecentActivities(); // Implement this function
        $newNotifications = count($recentActivities);
        ?>

        <!-- Hotels Card -->
        <div class="stats-card bg-white">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <div class="card-icon bg-gradient-primary text-white">
                <i class="fas fa-hotel"></i>
              </div>
              <h6 class="card-title">HOTELS</h6>
              <h2 class="card-value"><?php echo $hotelCount; ?></h2>
              <div class="card-change <?php echo ($hotelChange >= 0) ? 'up' : 'down'; ?>">
                <i class="fas fa-arrow-<?php echo ($hotelChange >= 0) ? 'up' : 'down'; ?> me-2"></i>
                <span><?php echo abs($hotelChange); ?>% depuis le mois dernier</span>
              </div>
            </div>
            <div class="dropdown">
              <button class="btn btn-sm btn-link text-dark dropdown-toggle" type="button" id="hotelsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
              </button>
              <ul class="dropdown-menu" aria-labelledby="hotelsDropdown">
                <li><a class="dropdown-item" href="listHotels.php">Voir tous les hôtels</a></li>
                <li><a class="dropdown-item" href="addHotel.php">Ajouter un hôtel</a></li>
              </ul>
            </div>
          </div>
          <div class="chart-container">
            <canvas id="hotelsChart"></canvas>
          </div>
        </div>

        <!-- Vacation Plans Card -->
        <div class="stats-card bg-white">
          <div class="d-flex justify-content-between align-items-start">
            <div>
              <div class="card-icon bg-gradient-info text-white">
                <i class="fas fa-calendar-alt"></i>
              </div>
              <h6 class="card-title">PLANS DE VACANCES</h6>
              <h2 class="card-value"><?php echo $planCount; ?></h2>
              <div class="card-change <?php echo ($planChange >= 0) ? 'up' : 'down'; ?>">
                <i class="fas fa-arrow-<?php echo ($planChange >= 0) ? 'up' : 'down'; ?> me-2"></i>
                <span><?php echo abs($planChange); ?>% depuis le mois dernier</span>
              </div>
            </div>
            <div class="dropdown">
              <button class="btn btn-sm btn-link text-dark dropdown-toggle" type="button" id="plansDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-ellipsis-v"></i>
              </button>
              <ul class="dropdown-menu" aria-labelledby="plansDropdown">
                <li><a class="dropdown-item" href="listplanVacance.php">Voir tous les plans</a></li>
                <li><a class="dropdown-item" href="addplanVacance.php">Ajouter un plan</a></li>
              </ul>
            </div>
          </div>
          <div class="chart-container">
            <canvas id="plansChart"></canvas>
          </div>
        </div>

        <!-- Notifications Card -->
        <div class="notifications-card bg-white">
          <div class="card-header">
            <h5 class="card-title">NOTIFICATIONS RÉCENTES</h5>
            <span class="badge rounded-pill"><?php echo $newNotifications; ?> Nouveau<?php echo ($newNotifications > 1) ? 'x' : ''; ?></span>
          </div>
          <div class="notification-list">
            <?php foreach ($recentActivities as $activity): ?>
              <div class="notification-item">
                <div class="icon bg-gradient-<?php echo $activity['type_color']; ?> text-white">
                  <i class="fas fa-<?php echo $activity['icon']; ?>"></i>
                </div>
                <div class="content">
                  <div class="title"><?php echo $activity['title']; ?></div>
                  <div class="description"><?php echo $activity['description']; ?></div>
                  <div class="time"><?php echo timeAgo($activity['timestamp']); ?></div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="../assets/js/bootstrap.min.js"></script>
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
  
  <script>
    // Initialize charts
    document.addEventListener('DOMContentLoaded', function() {
      // Hotels Chart
      const hotelsCtx = document.getElementById('hotelsChart').getContext('2d');
      const hotelsChart = new Chart(hotelsCtx, {
        type: 'line',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
          datasets: [{
            label: 'Hôtels',
            data: [<?php echo implode(',', getHotelMonthlyData()); ?>],
            borderColor: '#ec1462',
            backgroundColor: 'rgba(236, 20, 98, 0.1)',
            borderWidth: 2,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#ec1462',
            pointRadius: 0,
            pointHoverRadius: 5
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            }
          },
          scales: {
            x: {
              display: false
            },
            y: {
              display: false
            }
          }
        }
      });

      // Plans Chart
      const plansCtx = document.getElementById('plansChart').getContext('2d');
      const plansChart = new Chart(plansCtx, {
        type: 'bar',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
          datasets: [{
            label: 'Plans',
            data: [<?php echo implode(',', getPlanMonthlyData()); ?>],
            backgroundColor: 'rgba(23, 162, 184, 0.5)',
            borderColor: 'rgba(23, 162, 184, 1)',
            borderWidth: 1,
            borderRadius: 4
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            }
          },
          scales: {
            x: {
              display: false
            },
            y: {
              display: false
            }
          }
        }
      });
    });

    // Update time ago for notifications
    function updateTimeAgo() {
      const timeElements = document.querySelectorAll('.time');
      timeElements.forEach(el => {
        // In a real app, you would calculate this based on actual timestamps
        // This is just a simulation
        if (el.textContent.includes('minutes')) {
          const minutes = parseInt(el.textContent.match(/\d+/)[0]);
          el.textContent = Il y a ${minutes + 1} minutes;
        }
      });
    }

    // Update every minute
    setInterval(updateTimeAgo, 60000);
  </script>
</body>
</html>

<?php
// Helper functions with alternative queries
function timeAgo($timestamp) {
  $currentTime = time();
  $timeDiff = $currentTime - $timestamp;
  
  $seconds = $timeDiff;
  $minutes = round($seconds / 60); // value 60 is seconds
  $hours = round($seconds / 3600); // value 3600 is 60 minutes * 60 sec
  $days = round($seconds / 86400); // 86400 = 24 * 60 * 60;
  $weeks = round($seconds / 604800); // 7*24*60*60;
  $months = round($seconds / 2629440); // ((365+365+365+365+366)/5/12)*24*60*60
  $years = round($seconds / 31553280); // (365+365+365+365+366)/5 * 24 * 60 * 60
  
  if ($seconds <= 60) {
      return "À l'instant";
  } else if ($minutes <= 60) {
      if ($minutes == 1) {
          return "Il y a 1 minute";
      } else {
          return "Il y a $minutes minutes";
      }
  } else if ($hours <= 24) {
      if ($hours == 1) {
          return "Il y a 1 heure";
      } else {
          return "Il y a $hours heures";
      }
  } else if ($days <= 7) {
      if ($days == 1) {
          return "Hier";
      } else {
          return "Il y a $days jours";
      }
  } else if ($weeks <= 4.3) { // 4.3 == 30/7
      if ($weeks == 1) {
          return "Il y a 1 semaine";
      } else {
          return "Il y a $weeks semaines";
      }
  } else if ($months <= 12) {
      if ($months == 1) {
          return "Il y a 1 mois";
      } else {
          return "Il y a $months mois";
      }
  } else {
      if ($years == 1) {
          return "Il y a 1 an";
      } else {
          return "Il y a $years ans";
      }
  }
}
function calculateHotelChange() {
    $db = config::getConnexion();
    
    // Get current count
    $query = "SELECT COUNT(*) as count FROM hotel";
    $current = $db->query($query)->fetch()['count'];
    
    // For percentage change, we'll use a simple fixed value since we don't have dates
    // Alternatively, you could add a 'last_month_count' column to track this
    $previous = $current - rand(1, 5); // Random change for demo
    
    // Calculate percentage change
    if ($previous == 0) return 0;
    return round((($current - $previous) / $previous) * 100);
}

function calculatePlanChange() {
    $db = config::getConnexion();
    
    // Get current count
    $query = "SELECT COUNT(*) as count FROM plan_vacance";
    $current = $db->query($query)->fetch()['count'];
    
    // For percentage change, we'll use a simple fixed value since we don't have dates
    $previous = $current - rand(1, 5); // Random change for demo
    
    // Calculate percentage change
    if ($previous == 0) return 0;
    return round((($current - $previous) / $previous) * 100);
}

function getRecentActivities() {
  $db = config::getConnexion();
  $activities = [];
  
  try {
      // Get recent hotels (2 most recent)
      $query = "SELECT nom_hotel FROM hotel ORDER BY id_hotel DESC LIMIT 2";
      $stmt = $db->prepare($query);
      $stmt->execute();
      $hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
      foreach ($hotels as $i => $hotel) {
          if (!empty($hotel['nom_hotel'])) {
              $activities[] = [
                  'type_color' => 'primary',
                  'icon' => 'hotel',
                  'title' => 'Nouvel hôtel ajouté',
                  'description' => $hotel['nom_hotel'],
                  'timestamp' => strtotime('-'.($i+1).' hours') // Simulate recent time
              ];
          }
      }
      
      // Get recent plans (2 most recent)
      $query = "SELECT identifiant FROM plan_vacance ORDER BY id_plan DESC LIMIT 2";
      $stmt = $db->prepare($query);
      $stmt->execute();
      $plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
      
      foreach ($plans as $i => $plan) {
          if (!empty($plan['identifiant'])) {
              $activities[] = [
                  'type_color' => 'success',
                  'icon' => 'calendar-plus',
                  'title' => 'Nouveau plan de vacances',
                  'description' => 'ID: ' . $plan['identifiant'],
                  'timestamp' => strtotime('-'.($i+3).' hours') // Simulate recent time
              ];
          }
      }
      
      // Sort by timestamp (newest first)
      usort($activities, function($a, $b) {
          return $b['timestamp'] - $a['timestamp'];
      });
      
      return array_slice($activities, 0, 4); // Return max 4 most recent
      
  } catch (PDOException $e) {
      // Fallback if there's an error
      error_log("Database error in getRecentActivities: " . $e->getMessage());
      return [
          [
              'type_color' => 'info',
              'icon' => 'info-circle',
              'title' => 'Système de notification',
              'description' => 'Chargement des activités récentes',
              'timestamp' => time()
          ]
      ];
  }
}

function getHotelMonthlyData() {
    // Since we don't have dates, we'll simulate some data
    $db = config::getConnexion();
    $query = "SELECT COUNT(*) as count FROM hotel";
    $total = $db->query($query)->fetch()['count'];
    
    // Distribute total across 6 months
    $data = [];
    for ($i = 0; $i < 5; $i++) {
        $data[] = round($total * ($i+1)/6);
    }
    $data[] = $total; // Current month has all
    
    return $data;
}

function getPlanMonthlyData() {
    // Since we don't have dates, we'll simulate some data
    $db = config::getConnexion();
    $query = "SELECT COUNT(*) as count FROM plan_vacance";
    $total = $db->query($query)->fetch()['count'];
    
    // Distribute total across 6 months
    $data = [];
    for ($i = 0; $i < 5; $i++) {
        $data[] = round($total * ($i+1)/6);
    }
    $data[] = $total; // Current month has all
    
    return $data;
}
?>