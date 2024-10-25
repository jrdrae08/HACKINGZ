<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('Content-Type: application/json');
  echo json_encode(['error' => 'Unauthorized']);
  exit;
}

include '../includes/db.php'; // Include your database connection
require '../vendor/autoload.php'; // Include Composer autoload

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $brgyEmail = filter_var($_POST['brgyEmail'], FILTER_SANITIZE_EMAIL);
  $brgyPassword = password_hash($_POST['brgyPassword'], PASSWORD_DEFAULT); // Hash password for security
  $brgyEstablishment = filter_var($_POST['brgyEstablishment'], FILTER_SANITIZE_STRING);

  try {
    // Prepare to insert into database using PDO
    $stmt = $pdo->prepare("INSERT INTO barangay_accounts (email, password, establishment) VALUES (:email, :password, :establishment)");

    // Execute the statement with the provided values
    $stmt->execute([
      ':email' => $brgyEmail,
      ':password' => $brgyPassword,
      ':establishment' => $brgyEstablishment
    ]);

    // Get the last inserted ID
    $lastInsertId = $pdo->lastInsertId();

    // Generate QR code
    $qrData = "https://dd4d-136-158-66-65.ngrok-free.app/../barangay/estab-demog.php?id={$lastInsertId}";
    $qrCode = new QrCode($qrData);
    $writer = new PngWriter();
    $qrCodeImage = $writer->write($qrCode)->getString();

    // Save the QR code image to the server
    $qrCodeFileName = uniqid() . '.png';
    $qrCodeFilePath = 'qrCode/' . $qrCodeFileName;
    file_put_contents($qrCodeFilePath, $qrCodeImage);

    // Update the database with the QR code path
    $updateStmt = $pdo->prepare("UPDATE barangay_accounts SET qr_code = :qr_code WHERE barangayId = :barangayId");
    $updateStmt->execute([
      ':qr_code' => $qrCodeFilePath,
      ':barangayId' => $lastInsertId
    ]);

    // Return the barangayId and QR code path as JSON
    header('Content-Type: application/json');
    echo json_encode(['barangayId' => $lastInsertId, 'qrCodePath' => $qrCodeFilePath]);
    exit;
  } catch (PDOException $e) {
    header('Content-Type: application/json');
    echo json_encode(['error' => $e->getMessage()]);
  }
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <link rel="stylesheet" href="../css/admin.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>

<body>
  <div class="wrapper">
    <?php include '../admin/includes/aside.php'; ?>
    <div class="main">
      <?php include '../admin/includes/navbar.php'; ?>
      <main class="content px-3 py-2">
        <div class="container-fluid">
          <h1 class="mb-4">Generate Barangay Account</h1>
          <form id="barangayForm" class="needs-validation" novalidate method="POST">
            <div class="mb-3">
              <label for="brgyEmail" class="form-label">Barangay Email</label>
              <input type="email" class="form-control" id="brgyEmail" name="brgyEmail" required>
            </div>
            <div class="mb-3">
              <label for="brgyPassword" class="form-label">Barangay Password</label>
              <div class="input-group">
                <input type="password" class="form-control" id="brgyPassword" name="brgyPassword" required>
                <button type="button" class="btn btn-secondary" id="generatePassword">Generate Password</button>
                <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                  <i class="bi bi-eye" id="togglePasswordIcon"></i>
                </button>
              </div>
            </div>
            <div class="mb-3">
              <label for="brgyEstablishment" class="form-label">Barangay Establishment</label>
              <input type="text" class="form-control" id="brgyEstablishment" name="brgyEstablishment" required>
            </div>
            <input type="hidden" id="qrData" name="qrData">
            <input type="hidden" id="qrCodeImage" name="qrCodeImage">
            <div class="mb-3">
              <label for="brgyQR" class="form-label">Barangay QR Code</label>
              <div id="brgyQR" class="mb-2"></div>
            </div>
            <div class="d-flex justify-content-between mt-4">
              <button type="submit" class="btn btn-success">Submit</button>
              <a href="view-barangay-accounts.php" class="btn btn-info">View Accounts List</a>
            </div>
          </form>
        </div>
      </main>
      <a href="#" class="theme-toggle">
        <i class="fa-regular fa-sun"></i>
        <i class="fa-regular fa-moon"></i>
      </a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../js/admin.js"></script>
  <script>
    function generatePassword(length) {
      const lowercase = "abcdefghijklmnopqrstuvwxyz";
      const uppercase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
      const numbers = "0123456789";
      const specialCharacters = "!@#$%^&*()_+[]{}|;:,.<>?";

      const allChars = lowercase + uppercase + numbers + specialCharacters;
      let password = "";

      password += lowercase[Math.floor(Math.random() * lowercase.length)];
      password += uppercase[Math.floor(Math.random() * uppercase.length)];
      password += numbers[Math.floor(Math.random() * numbers.length)];
      password += specialCharacters[Math.floor(Math.random() * specialCharacters.length)];

      for (let i = password.length; i < length; i++) {
        password += allChars[Math.floor(Math.random() * allChars.length)];
      }

      password = password.split('').sort(() => 0.5 - Math.random()).join('');

      return password;
    }

    document.getElementById('generatePassword').addEventListener('click', function() {
      let password = generatePassword(8);
      document.getElementById('brgyPassword').value = password;
    });

    document.getElementById('togglePassword').addEventListener('click', function() {
      const passwordField = document.getElementById('brgyPassword');
      const passwordIcon = document.getElementById('togglePasswordIcon');
      const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordField.setAttribute('type', type);
      passwordIcon.classList.toggle('bi-eye');
      passwordIcon.classList.toggle('bi-eye-slash');
    });

    document.getElementById('barangayForm').addEventListener('submit', function(event) {
      event.preventDefault();

      let formData = new FormData(document.getElementById('barangayForm'));

      fetch('add-barangay-account.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.error) {
            console.error('Error:', data.error);
            return;
          }

          let qrCodePath = data.qrCodePath;
          let qrCodeImage = new Image();
          qrCodeImage.src = qrCodePath;
          document.getElementById('brgyQR').appendChild(qrCodeImage);

          // Add hidden input for barangayId
          let barangayIdInput = document.createElement('input');
          barangayIdInput.type = 'hidden';
          barangayIdInput.name = 'barangayId';
          barangayIdInput.value = data.barangayId;
          document.getElementById('barangayForm').appendChild(barangayIdInput);

          document.getElementById('barangayForm').submit();
        })
        .catch(error => console.error('Error:', error));
    });
  </script>
</body>

</html>