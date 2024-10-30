<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  echo json_encode(['error' => 'Unauthorized']);
  exit;
}

include '../includes/db.php'; // Include your database connection
require '../vendor/autoload.php'; // Include Composer autoload

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $brgyEmail = filter_var($_POST['brgyEmail'], FILTER_SANITIZE_EMAIL);
  $brgyPassword = $_POST['brgyPassword'];
  $brgyEstablishment = filter_var($_POST['brgyEstablishment'], FILTER_SANITIZE_STRING);

  // Validate input fields
  if (empty($brgyEmail) || empty($brgyPassword) || empty($brgyEstablishment)) {
    echo json_encode(['error' => 'All fields are required']);
    exit;
  }

  if (!filter_var($brgyEmail, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['error' => 'Invalid email format']);
    exit;
  }

  $brgyPassword = password_hash($brgyPassword, PASSWORD_DEFAULT); // Hash password for security

  try {
    // Check if email already exists
    $checkEmailStmt = $pdo->prepare("SELECT COUNT(*) FROM barangay_accounts WHERE email = :email");
    $checkEmailStmt->execute([':email' => $brgyEmail]);
    $emailCount = $checkEmailStmt->fetchColumn();

    if ($emailCount > 0) {
      echo json_encode(['error' => 'Email already exists']);
      exit;
    }

    // Check if establishment already exists
    $checkEstablishmentStmt = $pdo->prepare("SELECT COUNT(*) FROM barangay_accounts WHERE establishment = :establishment");
    $checkEstablishmentStmt->execute([':establishment' => $brgyEstablishment]);
    $establishmentCount = $checkEstablishmentStmt->fetchColumn();

    if ($establishmentCount > 0) {
      echo json_encode(['error' => 'Establishment already exists']);
      exit;
    }

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
    $qrData = "https://7b70-136-158-66-65.ngrok-free.app/../barangay/estab-demog.php?id={$lastInsertId}";
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

    // Return success response
    echo json_encode(['success' => 'Account created successfully']);
    exit;
  } catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit;
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
</head>

<body>
  <div class="wrapper">
    <?php include '../admin/includes/aside.php'; ?>
    <div class="main">
      <?php include '../admin/includes/navbar.php'; ?>
      <main class="content mt-5 px-3 py-2">
        <div class="container-fluid d-flex justify-content-center align-items-center">
          <div class="row d-flex justify-content-center">
            <div class="col-lg-8 col-12">
              <div class="card shadow">
                <div class="card-header">
                  <h4 class="card-title">Generate Barangay Account</h4>
                </div>
                <div class="card-body">
                  <form id="barangayForm" class="needs-validation" novalidate method="POST">

                    <div class="row g-2 d-flex justify-content-center">
                      <!-- Email/Username Section -->
                      <div class="col-12 d-flex justify-content-center">
                        <div class="col-lg-6 col-12">
                          <label for="brgyEmail" class="form-label">Email/Username</label>
                          <input type="email" class="form-control shadow" id="brgyEmail" name="brgyEmail" required>
                        </div>
                      </div>

                      <!-- Barangay Password Section -->
                      <div class="col-12 d-flex justify-content-center">
                        <div class="col-lg-6 col-12">
                          <label for="brgyPassword" class="form-label">Password</label>
                          <div class="d-flex justify-content-center">
                            <div class="col-8 mx-2">
                              <div class="input-group">
                                <input type="password" class="form-control shadow" id="brgyPassword" name="brgyPassword" required>
                                <button type="button" class="btn btn-outline-secondary" id="togglePassword">
                                  <i class="bi bi-eye" id="togglePasswordIcon"></i>
                                </button>
                              </div>
                            </div>
                            <div class="col-4 d-grid">
                              <button type="button" class="btn btn-secondary" id="generatePassword">Generate</button>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-12 d-flex justify-content-center">
                        <div class="col-lg-6 col-12">
                          <label for="brgyEstablishment" class="form-label">Barangay Establishment Name</label>
                          <input type="text" class="form-control  shadow" id="brgyEstablishment" name="brgyEstablishment" required>
                        </div>
                      </div>

                      <div class="col-12 mb-4 d-flex justify-content-center">
                        <div class="col-lg-6 col-12 d-flex justify-content-between mt-4">
                          <button type="submit" class="btn btn-success" id="submitBtn" disabled>Submit</button>
                          <a href="view-barangay-accounts.php" class="btn btn-info">View Accounts List</a>
                        </div>
                      </div>
                    </div>
                  </form>
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

  <!-- Confirmation Modal -->
  <div class="modal fade" id="addbrgyConfirmationModal" tabindex="-1" aria-labelledby="addbrgyConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addbrgyConfirmationModalLabel">Confirm Submission</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to submit the form?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="confirmSubmit">Confirm</button>
        </div>
      </div>
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
      checkFormValidity();
    });

    document.getElementById('togglePassword').addEventListener('click', function() {
      const passwordField = document.getElementById('brgyPassword');
      const passwordIcon = document.getElementById('togglePasswordIcon');
      const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordField.setAttribute('type', type);
      passwordIcon.classList.toggle('bi-eye');
      passwordIcon.classList.toggle('bi-eye-slash');
    });

    document.getElementById('brgyEmail').addEventListener('input', checkFormValidity);
    document.getElementById('brgyPassword').addEventListener('input', checkFormValidity);
    document.getElementById('brgyEstablishment').addEventListener('input', checkFormValidity);

    function checkFormValidity() {
      const brgyEmail = document.getElementById('brgyEmail').value;
      const brgyPassword = document.getElementById('brgyPassword').value;
      const brgyEstablishment = document.getElementById('brgyEstablishment').value;
      const submitBtn = document.getElementById('submitBtn');

      if (brgyEmail && brgyPassword && brgyEstablishment && validateEmail(brgyEmail)) {
        submitBtn.disabled = false;
      } else {
        submitBtn.disabled = true;
      }
    }

    function validateEmail(email) {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(email);
    }

    document.getElementById('submitBtn').addEventListener('click', function(event) {
      event.preventDefault();
      const confirmationModal = new bootstrap.Modal(document.getElementById('addbrgyConfirmationModal'));
      confirmationModal.show();
    });

    document.getElementById('confirmSubmit').addEventListener('click', function() {
      const formData = new FormData(document.getElementById('barangayForm'));
      const notyf = new Notyf({
        duration: 5000,
        position: {
          x: 'right',
          y: 'top',
        },
        types: [{
            type: 'warning',
            background: '#FFD700',
            icon: {
              className: 'fas fa-exclamation-triangle',
              tagName: 'span',
              color: '#000'
            }
          },
          {
            type: 'danger',
            background: '#dc3545',
            icon: {
              className: 'fas fa-times-circle',
              tagName: 'span',
              color: '#fff'
            }
          },
          {
            type: 'success',
            background: '#28a745',
            icon: {
              className: 'fas fa-check-circle',
              tagName: 'span',
              color: '#fff'
            }
          }
        ]
      });

      fetch('add-barangay-account.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.error) {
            notyf.error(data.error);
          } else {
            notyf.success(data.success);
            setTimeout(() => {
              window.location.href = 'add-barangay-account.php';
            }, 2000); // Redirect after 2 seconds
          }
        })
        .catch(error => {
          notyf.error('An error occurred. Please try again.');
        });

      const confirmationModal = bootstrap.Modal.getInstance(document.getElementById('addbrgyConfirmationModal'));
      confirmationModal.hide();
    });

    document.getElementById('barangayForm').addEventListener('submit', function(event) {
      event.preventDefault();
      const confirmationModal = new bootstrap.Modal(document.getElementById('addbrgyConfirmationModal'));
      confirmationModal.show();
    });
  </script>
</body>

</html>