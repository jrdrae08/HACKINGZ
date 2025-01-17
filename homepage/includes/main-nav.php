<?php
// session_start();
require_once '../includes/db.php';

if (isset($_GET['userID'])) {
  $_SESSION['user_id'] = $_GET['userID'];
}

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$userFullName = '';
$userID = $isLoggedIn ? $_SESSION['user_id'] : '';

if ($isLoggedIn) {
  // Fetch the user's full name from the database
  $stmt = $pdo->prepare("SELECT full_name FROM users WHERE userId = ?");
  $stmt->execute([$_SESSION['user_id']]);
  $userFullName = $stmt->fetchColumn();
}
?>

<style>
  /* Default navbar style (no blur) */
  .custom-navbar {
    background-color: rgba(0, 0, 0, 0.4);
  }

  /* Navbar style when scrolled (with blur) */
  .custom-navbar.scrolled {
    background-color: rgba(0, 0, 0, 0.5);
    /* Slightly darker when scrolled */
  }
</style>

<nav class="navbar navbar-expand-lg fixed-top custom-navbar border-0">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="../img/general-img/majayjay-logo.webp" alt="Majayjay Logo" height="50">
      <!-- <span class="dm-sans-text text-light">Majayjay, Laguna</span> -->
    </a>
    <button class="navbar-toggler bg-success-subtle shadow" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Offcanvas menu -->
    <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
      <div class="offcanvas-header">
        <img src="../img/general-img/majayjay-logo.webp" alt="Majayjay Logo" height="50">
        <span class="dm-sans-text text-dark ms-2">Majayjay, Laguna</span>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item me-3">
            <a class="nav-link dm-sans-text text-light btn btn-nav btn-success shadow" href="../homepage/homepage.php<?= $isLoggedIn ? '?userID=' . htmlspecialchars($userID) : '' ?>">Home</a>
          </li>
          <li class="nav-item me-3">
            <a class="nav-link dm-sans-text text-light btn btn-nav btn-success shadow" href="../Resort/page-0.php<?= $isLoggedIn ? '?userID=' . htmlspecialchars($userID) : '' ?>">Destinations</a>
          </li>
          <?php if (!$isLoggedIn): ?>
            <li class="nav-item me-3">
              <a class="nav-link dm-sans-text text-light btn btn-nav btn-success shadow" href="../businessowner/business-registration.php">Businesses</a>
            </li>
          <?php endif; ?>
          <li class="nav-item me-3">
            <a class="nav-link dm-sans-text text-light btn btn-nav btn-success shadow" href="#service<?= $isLoggedIn ? '?userID=' . htmlspecialchars($userID) : '' ?>">Services</a>
          </li>
          <li class="nav-item me-5">
            <a class="nav-link dm-sans-text text-light btn btn-nav btn-success shadow" href="#about<?= $isLoggedIn ? '?userID=' . htmlspecialchars($userID) : '' ?>">About</a>
          </li>
          <?php if ($isLoggedIn): ?>
            <li class="nav-item dropdown">
              <button class="nav-link dm-sans-text btn-nav text-light shadow dropdown-toggle no-caret" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person-circle me-1"></i>
                <?= htmlspecialchars($userFullName) ?>
              </button>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="../user/view-my-reservation.php<?php echo isset($userID) ? '?userID=' . htmlspecialchars($userID) : ''; ?>">My Reservation</a>
                <li><a class="dropdown-item" href="../../logoutuser.php">Logout</a></li>
              </ul>
            </li>
          <?php else: ?>
            <li class="nav-item">
              <a class="nav-link text-light btn btn-nav shadow" href="../../login.php">Sign In</a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
</nav>