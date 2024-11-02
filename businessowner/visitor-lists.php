<?php
//visitor-lists.php
session_start();
include '../includes/db.php';

// Ensure the user is logged in and has the correct role
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'businessowner') {
  header('Location: ../login.php');
  exit;
}

// Use the barangayId stored in the session
$barangayId = $_SESSION['user_id'];

try {
  // Prepare and execute statement to retrieve the demographic information
  $stmt = $pdo->prepare("SELECT demogId, created_at, totalnumAttendees, name, sex, location FROM demographics WHERE barangayId = :barangay_id");
  $stmt->execute([':barangay_id' => $barangayId]);

  // Fetch all demographic data
  $demographics = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (!$demographics) {
    // echo "No demographic information found for this barangay.";
  }
} catch (PDOException $e) {
  error_log("Database error: " . $e->getMessage());
  echo "An error occurred. Please try again later.";
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
  <!-- DataTables CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
</head>

<body>
  <div class="wrapper">
    <!-- aside nav -->
    <?php include '../businessowner/includes/aside.php'; ?>
    <div class="main">
      <!-- navbar -->
      <?php include '../businessowner/includes/navbar.php'; ?>
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
                  <table id="demographicsTable" class="table table-striped">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Date and Time</th>
                        <th scope="col">Number of Visitors</th>
                        <th scope="col">Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      foreach ($demographics as $demog):
                      ?>
                        <tr>
                          <th scope="row"><?php echo htmlspecialchars($demog['demogId']); ?></th>
                          <td>
                            <?php
                            $datetime = new DateTime($demog['created_at']);
                            echo htmlspecialchars($datetime->format('m/d/Y h:iA'));
                            ?>
                          </td>
                          <td><?php echo htmlspecialchars($demog['totalnumAttendees']); ?></td>
                          <td>
                            <button class="btn btn-primary m-1 view-info-btn" data-bs-toggle="modal" data-id="<?php echo htmlspecialchars($demog['demogId']); ?>">
                              <i class="bi bi-eye"></i>
                            </button>
                          </td>
                        </tr>
                      <?php
                      endforeach;
                      ?>
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
                <ul id="demographics-details">
                  <!-- Content will be injected by JavaScript -->
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
                  <tbody id="modal-body-content">
                    <!-- Content will be injected by JavaScript -->
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
  <!-- Include jQuery for simplicity -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- DataTables JS -->
  <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script>
    $(document).ready(function() {
      $('#demographicsTable').DataTable({
        "columnDefs": [{
            "orderable": false,
            "targets": 3
          } // Disable sorting on the Actions column
        ],
        "pageLength": 10,
        "lengthMenu": [10, 25, 50, 75, 100],
        "paging": <?php echo count($demographics) > 10 ? 'true' : 'false'; ?>,
        "searching": false // Disable the search functionality
      });

      $('.view-info-btn').on('click', function() {
        var demogId = $(this).data('id');
        console.log('Button clicked, demogId:', demogId);

        // Clear previous modal content
        $('#demographics-details').html('');
        $('#modal-body-content').html('');

        $.ajax({
          url: '../../backends/barangay/fetch_demographics.php',
          type: 'POST',
          data: {
            demogId: demogId
          },
          success: function(response) {
            console.log('AJAX response:', response);
            var res = JSON.parse(response);
            $('#demographics-details').html(res.details);
            $('#modal-body-content').html(res.table);
            $('#viewaccountinfo').modal('show');
          },
          error: function(xhr, status, error) {
            console.error('AJAX error:', status, error);
          }
        });
      });
    });
  </script>
  <style>
    /* Minimalist but formal design for the modal */
    .modal-content {
      border-radius: 10px;
      border: none;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .modal-header {
      border-bottom: none;
      padding-bottom: 0;
    }

    .modal-title {
      font-size: 1.5rem;
      font-weight: bold;
    }

    .modal-body {
      padding-top: 0;
    }

    .modal-body p {
      margin-bottom: 1rem;
    }

    .modal-body ul {
      list-style-type: none;
      padding: 0;
    }

    .modal-body ul li {
      padding: 0.5rem 0;
      border-bottom: 1px solid #e9ecef;
    }

    .modal-body table {
      width: 100%;
      margin-top: 1rem;
    }

    .modal-body table th,
    .modal-body table td {
      padding: 0.75rem;
      text-align: left;
    }

    .modal-body table th {
      background-color: #f8f9fa;
      font-weight: bold;
    }

    .modal-body table tr:nth-child(even) {
      background-color: #f8f9fa;
    }

    .btn-close {
      background: none;
      border: none;
      font-size: 1.25rem;
    }

    .btn-close:hover {
      color: #dc3545;
    }
  </style>
</body>

</html>