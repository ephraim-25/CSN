<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="../css/style1.css" />
  <!-- Boxicons CDN Link -->
  <link href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css" rel="stylesheet" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
  <div class="sidebar">
    <div class="logo-details">
      <i class="bx bxl-c-plus-plus"></i>
      <img src="../images/csn-menu.png" alt=""><span class="logo_name">ACHECCIR</span>
    </div>
    <ul class="nav-links">
      <li>
        <a href="../pages/dashboard.php" class="active">
          <i class="bx bx-grid-alt"></i>
          <span class="links_name">DASHBOARD</span>
        </a>
      </li>
      <li>
        <a href="../pages/chercheurs.php">
          <i class="bx bx-box"></i>
          <span class="links_name">CHERCHEURS</span>
        </a>
      </li>
      <li>
        <a href="../pages/membres.php">
          <i class="bx bx-list-ul"></i>
          <span class="links_name">MEMBRES</span>
        </a>
      </li>
      <li>
        <a href="../pages/centres.php">
          <i class="bx bx-pie-chart-alt-2"></i>
          <span class="links_name">CENTRES/INSTITUTS</span>
        </a>
      </li>
      <li>
        <a href="../pages/utilisateurs.php">
          <i class="bx bx-user"></i>
          <span class="links_name">UTILISATEURS</span>
        </a>
      </li>
      <li class="log_out">
        <a href="../pages/seDeconnecter.php">
          <i class="bx bx-log-out"></i>
          <span class="links_name">Déconnexion</span>
        </a>
      </li>
    </ul>
  </div>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class="bx bx-menu sidebarBtn"></i>
        <span class="dashboard">DASHBOARD</span>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Recherche..." />
        <i class="bx bx-search"></i>
      </div>
      <div class="profile-details">
        <ul class="nav navbar-nav navbar-right">
          <section class="home-section">

            <li>
              <a href="../pages/editerUtilisateur.php echo $_SESSION['utilisateur']['id']; ?>">
                <span class="glyphicon glyphicon-user"></span>
                <!--<?php echo $_SESSION['utilisateur']['login']; ?>-->
              </a>
            </li>
            <li>
              <a href="../pages/SeDeconnecter.php">
                <span class="glyphicon glyphicon-log-out"></span>
                Se Deconnecter
              </a>
            </li>
        </ul>
      </div>
    </nav>

    <div class="home-content">
      <div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            <div class="box-topic">CHERCHEUR</div>
            <div class="number">1741</div>
            <div class="indicator">
              <i class="bx bx-up-arrow-alt"></i>
              <span class="text">Depuis hier</span>
            </div>
          </div>
          <i class="bx bx-cart-alt cart"></i>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">CENTRES/INSTITUTS</div>
            <div class="number">26</div>
            <div class="indicator">
              <i class="bx bx-up-arrow-alt"></i>
              <span class="text">Depuis hier</span>
            </div>
          </div>
          <i class="bx bxs-cart-add cart two"></i>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">MEMBRES</div>
            <div class="number">38</div>
            <div class="indicator">
              <i class="bx bx-up-arrow-alt"></i>
              <span class="text">Depuis hier</span>
            </div>
          </div>
          <i class="bx bx-cart cart three"></i>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">GESTION</div>
            <div class="number">1741</div>
            <div class="indicator">
              <i class="bx bx-down-arrow-alt down"></i>
              <span class="text">Aujourd'hui</span>
            </div>
          </div>
          <i class="bx bxs-cart-download cart four"></i>
        </div>
      </div>
  </section>

  <script>
    let sidebar = document.querySelector(".sidebar");
    let sidebarBtn = document.querySelector(".sidebarBtn");
    sidebarBtn.onclick = function() {
      sidebar.classList.toggle("active");
      if (sidebar.classList.contains("active")) {
        sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
      } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
    };
  </script>
</body>

</html>