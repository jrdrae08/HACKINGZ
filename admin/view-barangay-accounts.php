<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}

// // Include database connection
// require '../includes/db_connect.php';

// // Fetch Barangay accounts from the database
// $query = "SELECT email, password, establishment FROM barangay_accounts";
// $result = mysqli_query($conn, $query);
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
  <link rel="stylesheet" href="../css/admin.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>

<body>
  <div class="wrapper">
    <?php include '../admin/includes/aside.php'; ?>
    <div class="main">
      <?php include '../admin/includes/navbar.php'; ?>
      <main class="content px-3 py-2">
        <div class="container-fluid">
          <h1>Barangay Accounts</h1>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Email</th>
                <th>Password</th>
                <th>Establishment</th>
                <th>QR Code</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td><?php echo htmlspecialchars($row['email']); ?></td>
                  <td><?php echo htmlspecialchars($row['password']); ?></td>
                  <td><?php echo htmlspecialchars($row['establishment']); ?></td>
                  <td>
                    <div id="qr_<?php echo $row['email']; ?>"></div>
                  </td>
                </tr>
                <script>
                  new QRCode(document.getElementById("qr_<?php echo $row['email']; ?>"), {
                    text: "Email: <?php echo $row['email']; ?>\nPassword: <?php echo $row['password']; ?>\nEstablishment: <?php echo $row['establishment']; ?>",
                    width: 128,
                    height: 128,
                    colorDark: "#000000",
                    colorLight: "#ffffff",
                    correctLevel: QRCode.CorrectLevel.H
                  });
                </script>
              <?php endwhile; ?>
            </tbody>
          </table>
        </div>
      </main>
    </div>
  </div>
  <script src="../js/admin.js"></script>
</body>

</html>