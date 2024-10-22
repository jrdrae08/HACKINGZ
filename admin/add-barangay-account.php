<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('Location: ../login.php');
  exit;
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
          <form id="barangayForm" class="needs-validation" novalidate>
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
            <div class="mb-3">
              <label for="brgyQR" class="form-label">Barangay QR Code</label>
              <div id="brgyQR" class="mb-2"></div>
              <button type="button" class="btn btn-primary" id="generateQR">Generate QR Code</button>
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

      // Ensure at least one character from each set
      password += lowercase[Math.floor(Math.random() * lowercase.length)];
      password += uppercase[Math.floor(Math.random() * uppercase.length)];
      password += numbers[Math.floor(Math.random() * numbers.length)];
      password += specialCharacters[Math.floor(Math.random() * specialCharacters.length)];

      // Fill the rest of the password length with random characters
      for (let i = password.length; i < length; i++) {
        password += allChars[Math.floor(Math.random() * allChars.length)];
      }

      // Shuffle the password to ensure randomness
      password = password.split('').sort(() => 0.5 - Math.random()).join('');

      return password;
    }

    document.getElementById('generateQR').addEventListener('click', function() {
      let brgyEmail = document.getElementById('brgyEmail').value;
      let brgyPassword = document.getElementById('brgyPassword').value;
      let brgyEstablishment = document.getElementById('brgyEstablishment').value;
      let qrData = `Email: ${brgyEmail}\nPassword: ${brgyPassword}\nEstablishment: ${brgyEstablishment}`;

      new QRCode(document.getElementById('brgyQR'), {
        text: qrData,
        width: 128,
        height: 128,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
      });
    });

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
  </script>
</body>

</html>