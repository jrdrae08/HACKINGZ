<aside id="sidebar" class="js-sidebar">
  <!-- Content For Sidebar -->
  <div class="h-100">
    <div class="sidebar-logo text-center">
      <img src="../img/admin-img/majayjay-logo.webp" alt="logo" height="150px" width="150px">
    </div>
    <ul class="sidebar-nav">
      <li class="sidebar-header">
        Tourist Elements
      </li>
      <li class="sidebar-item">
                <a href="../user/profile.php<?php echo isset($_SESSION['user_id']) ? '?userID=' . urlencode($_SESSION['user_id']) : ''; ?>" class="sidebar-link">
                <i class="bi bi-person-square pe-2"></i>
                    Profile
                </a>
            </li>
      <li class="sidebar-item">
        <a href="../user/view-my-reservation.php" class="sidebar-link">
          <i class="bi bi-bookmarks-fill pe-2"></i>
          View your Reservation
        </a>
      </li>
    </ul>
  </div>
</aside>