<?php
session_start();
require_once '../includes/db.php';

// Check if the user is logged in
$isLoggedIn = isset($_SESSION['user_id']);
$userFullName = '';

if ($isLoggedIn) {
  // Fetch the user's full name from the database
  $stmt = $pdo->prepare("SELECT full_name FROM users WHERE userId = ?");
  $stmt->execute([$_SESSION['user_id']]);
  $userFullName = $stmt->fetchColumn();
}
?>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand ms-5 text-light" href="../homepage/homepage.php">
      <img src="../img/general-img/majayjay-logo.webp" alt="Majayjay Logo" height="50">
      <span class="cormorant-text">Majayjay, Laguna</span>
    </a>
    <button class="navbar-toggler shadow" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-lg-0">
        <li class="nav-item">
          <a class="nav-link text-light btn btn-nav shadow" href="#service">SERVICES</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-light btn btn-nav shadow" href="#about">ABOUT</a>
        </li>
        <?php if ($isLoggedIn): ?>
          <li class="nav-item dropdown">
            <button class="nav-link fs-5 btn-nav text-light shadow dropdown-toggle no-caret" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?= htmlspecialchars($userFullName) ?>
              <i class="bi bi-person-circle me-1"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
              <li><a class="dropdown-item" href="../user/profile.php">Profile</a></li>
              <li><a class="dropdown-item" href="../../logout.php">Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link text-light btn btn-nav shadow" href="../../login.php">SIGN IN</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>