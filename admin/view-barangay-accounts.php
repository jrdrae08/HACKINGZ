<?php
// view-barangay-accounts.php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}

// Include database connection
require '../includes/db.php';

// Fetch Barangay accounts from the database in descending order by created_at (date and time)
$query = "SELECT email, password, establishment, qr_code, created_at FROM barangay_accounts ORDER BY created_at DESC";
$result = $pdo->query($query);
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Barangay Accounts</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/admin.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <div class="wrapper">
    <?php include '../admin/includes/aside.php'; ?>
    <div class="main">
      <?php include '../admin/includes/navbar.php'; ?>
      <main class="content px-3 py-2">
        <div class="container-fluid ">
          <div class="row d-flex justify-content-center">
            <div class="col-10">
              <!-- Table Element -->
              <div class="d-flex justify-content-between">
                <a href="add-barangay-account.php" class="btn btn-success">Add Establishment</a>
                <a href="#" class="btn btn-danger">Archived</a>
              </div>

              <div class="card shadow border-0 mt-3">
                <div class="card-header">
                  <h4 class="card-title">
                    Barangay Accounts
                  </h4>
                </div>
                <div class="card-body">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">Created at</th>
                        <th scope="col">Username/Email</th>
                        <th scope="col">Establishment Name</th>
                        <th scope="col">QR Code</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if ($result->rowCount() > 0): ?>
                        <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
                          <tr>
                            <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['establishment']); ?></td>
                            <td>
                              <img src="<?php echo htmlspecialchars($row['qr_code']); ?>" alt="QR Code" class="img-fluid qr-code-img" data-bs-toggle="modal" data-bs-target="#qrModal" data-src="<?php echo htmlspecialchars($row['qr_code']); ?>">
                            </td>
                            <th>
                              <button class="btn btn-danger m-1"><i class="bi bi-x-lg"></i></button>
                            </th>
                          </tr>
                        <?php endwhile; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="4" class="text-center">No records found</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
    </main>
    <a href="#" class="theme-toggle">
      <i class="fa-regular fa-sun"></i>
      <i class="fa-regular fa-moon"></i>
    </a>
  </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="qrModalLabel">QR Code</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <img id="qrModalImage" src="" alt="QR Code" class="img-fluid">
        </div>
      </div>
    </div>
  </div>

  <style>
    .qr-code-img {
      max-width: 50px;
      height: auto;
      cursor: pointer;
    }
  </style>

  <script>
    $(document).ready(function() {
      $('.qr-code-img').on('click', function() {
        var src = $(this).data('src');
        $('#qrModalImage').attr('src', src);
      });
    });
  </script>

  <script src="../js/admin.js"></script>
</body>

</html>