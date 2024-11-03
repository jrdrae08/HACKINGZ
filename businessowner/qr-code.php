<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'businessowner') {
  header('Location: ../login.php');
  exit;
}
if (!isset($_SESSION['user_id'])) {
  echo "Unauthorized";
  exit;
}

include '../includes/db.php'; // Database connection

try {
  // Fetch the QR code path from the database based on the user's AccountID
  $stmt = $pdo->prepare("SELECT qr_code FROM account WHERE AccountID = :accountID");
  $stmt->execute([':accountID' => $_SESSION['user_id']]);
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  $qrCodePath = $result && !empty($result['qr_code']) ? '../businessowner/qrCode/' . htmlspecialchars($result['qr_code']) : '../businessowner/qrCode/default.png';

  // Echo the AccountID and QR code path for debugging purposes
  echo "AccountID: " . htmlspecialchars($_SESSION['user_id']) . "<br>";
  echo "QR Code Path: " . htmlspecialchars($qrCodePath) . "<br>";
} catch (PDOException $e) {
  $qrCodePath = '../businessowner/qrCode/default.png';
  echo "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/admin.css">

  <style>

  </style>
</head>

<body>
  <div class="wrapper">

    <!-- aside nav -->
    <?php include '../businessowner/includes/aside.php'; ?>

    <div class="main">

      <!-- navbar -->
      <?php include '../businessowner/includes/navbar.php'; ?>

      <main class="content">
        <div class="container-fluid">
          <div class="row d-flex justify-content-center align-items-center">
            <div class="col-5">
              <div class="card">
                <div class="card-header">
                  <h5 class="card-title">Generated Quick Response Code</h5>
                </div>
                <div class="card-body text-center">
                  <p>Here is the generated QR code of your establishment. The visitors will scan this and fill up the form in order to add their demographics to the database.</p>
                  <div>
                    <img class="img-fluid" src="<?php echo $qrCodePath; ?>" alt="QR Code">
                  </div>
                  <div>
                    <a href="<?php echo $qrCodePath; ?>" download="QRCode.png" class="btn btn-secondary">Download</a>
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
      <footer class="footer">
        <div class="container-fluid">
          <div class="row text-muted">
            <div class="col-6 text-start">
              <p class="mb-0">
                <a href="#" class="text-muted">
                  <strong>HaKingz</strong>
                </a>
              </p>
            </div>
            <div class="col-6 text-end">
              <ul class="list-inline">
                <li class="list-inline-item">
                  <a href="#" class="text-muted">Contact</a>
                </li>
                <li class="list-inline-item">
                  <a href="#" class="text-muted">About Us</a>
                </li>
                <li class="list-inline-item">
                  <a href="#" class="text-muted">Terms</a>
                </li>
                <li class="list-inline-item">
                  <a href="#" class="text-muted">Booking</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../js/admin.js"></script>
</body>

</html>