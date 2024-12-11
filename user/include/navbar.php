<?php

if (isset($_GET['userID'])) {
  $_SESSION['user_id'] = $_GET['userID'];
}

?>
<nav class="navbar navbar-expand px-3 border-bottom">
  <button class="btn" id="sidebar-toggle" type="button">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-collapse navbar">
    <ul class="navbar-nav">
      <li>
        <a href="../../homepage/homepage.php<?php echo isset($_SESSION['user_id']) ? '?userID=' . urlencode($_SESSION['user_id']) : ''; ?>" class="btn btn-success me-2">Go to Homepage</a>
      </li>
      <li class="nav-item dropdown">
        <a href="#" data-bs-toggle="dropdown" class="nav-icon pe-md-0">
          <i class="fs-3 text-dark bi bi-gear-fill"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-end">
          <a href="#" class="dropdown-item">Logout</a>
        </div>
      </li>
    </ul>
  </div>
</nav>