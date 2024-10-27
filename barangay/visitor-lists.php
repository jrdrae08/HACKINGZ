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
  <link rel="stylesheet" href="../css/admin.css">

  <style>

  </style>
</head>

<body>
  <div class="wrapper">

    <!-- aside nav -->
    <?php include '../barangay/includes/aside.php'; ?>

    <div class="main">

      <!-- navbar -->
      <?php include '../barangay/includes/navbar.php'; ?>

      <main class="content px-3 py-2">
        <div class="container-fluid">
          <div class="row d-flex justify-content-center">
            <div class="col-8">
              <div class="mb-3 mt-5">
                <h4>Information Table</h4>
              </div>
              <!-- Table Element -->
              <div class="card shadow border-0 mt-3">
                <div class="card-header">
                  <h4 class="card-title">
                    Tourist Lists
                  </h4>
                </div>
                <div class="card-body">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Date and Time</th>
                        <th scope="col">Number of Visitors</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th scope="row">1</th>
                        <td>10-01-24 02:32PM</td>
                        <td>23</td>
                        <td>
                          <button class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#viewaccountinfo"><i class="bi bi-eye"></i></button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- view tourist info modal -->
        <div class="modal fade" id="viewaccountinfo" tabindex="-1" aria-labelledby="viewaccountinfo" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered ">
            <div class="modal-content">
              <div class="modal-header">
                <h2 class="modal-title fs-5" id="exampleModalLabel">Tourist Information</h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <p class="mt-2 fs-6 fw-bold text-center">Tourists Information</p>
                <ul>
                  <li>Total Number of Attendees: </li>

                  <li>Total Male: </li>
                  <li>Total Female: </li>
                  <li class="mt-4">Locations</li>
                  <li>This City/Municipality:</li>
                  <li>Other City/Municipality:</li>
                  <li>Other Province:</li>
                  <li>Foreign Country:</li>
                </ul>
                <p class="mt-2 fs-6 fw-bold text-center">Information Table</p>
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">Name</th>
                      <th scope="col">Sex</th>
                      <th scope="col">Location</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>John Rev Baliton</td>
                      <td>Male</td>
                      <td>Other City/Municipality</td>
                    </tr>
                  </tbody>
                </table>

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