<?php
session_start();
require_once '../includes/db.php';

// Check if the userID is set in the session
$userID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if ($userID === null) {
  echo "User ID is not set.";
  exit();
}

try {
  $stmt = $pdo->prepare("
        SELECT r.revID, r.datetime, b.BusinessName, ri.roomName, r.status
        FROM reservations r
        JOIN roominfotable ri ON r.roomID = ri.roomID
        JOIN businessinformationform b ON ri.BusinessInfoID = b.BusinessInfoID
        WHERE r.userID = :userID
        ORDER BY r.datetime DESC
    ");
  $stmt->execute(['userID' => $userID]);
  $reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  error_log($e->getMessage());
  echo "An error occurred while fetching reservations.";
  exit();
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View My Reservations</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../user/user.css">
</head>

<body>
  <div class="wrapper">
    <?php include '../user/include/aside.php'; ?>

    <div class="main">
      <?php include '../user/include/navbar.php'; ?>

      <!-- Manage Reservation -->
      <main class="content">
        <div class="container-fluid">
          <h3 class="text-dark">View Reservation</h3>
          <div class="row d-flex justify-content-center">
            <div class="col-lg-8 col-12">
              <div class="card border-0 shadow">
                <div class="card-header">
                  <h5>Your Reservations</h5>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">Time Booked</th>
                          <th scope="col">Destination Name</th>
                          <th scope="col">Room Name</th>
                          <th scope="col">Status</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if (!empty($reservations)): ?>
                          <?php foreach ($reservations as $reservation): ?>
                            <tr>
                              <td><?php echo date('h:i A m/d/Y', strtotime($reservation['datetime'])); ?></td>
                              <td><?php echo htmlspecialchars($reservation['BusinessName']); ?></td>
                              <td><?php echo htmlspecialchars($reservation['roomName']); ?></td>
                              <td><?php echo htmlspecialchars($reservation['status']); ?></td>
                              <td>
                                <button type="button" class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#viewroom" onclick="fetchReservationDetails(<?php echo $reservation['revID']; ?>)"><i class="bi bi-eye"></i></button>
                                <button class="btn btn-danger m-1" data-bs-toggle="modal" data-bs-target="#cancelModal"><i class="bi bi-x-lg"></i></button>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php else: ?>
                          <tr>
                            <td colspan="6">No reservations found.</td>
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

        <!-- Modal for Viewing Room Details -->
        <div class="modal fade" id="viewroom" tabindex="-1" aria-labelledby="viewroom1Label" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="viewroom1Label">More Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body" id="roomDetails">
                <div class="row">
                  <div class="col-md-6 col-12">
                    <h5>Booking Information</h5>
                    <p><strong>Destination:</strong> <span id="destination"></span></p>
                    <p><strong>Location:</strong> <span id="location"></span></p>
                    <p><strong>Room:</strong> <span id="roomName"></span></p>
                    <p><strong>Room Price:</strong> $<span id="roomPrice"></span> per night</p>
                    <p><strong>Status:</strong> <span id="status"></span></p>
                    <p><strong>Check-in Date:</strong> <span id="checkinDate"></span></p>
                    <p><strong>Check-in Time:</strong> <span id="checkinTime"></span></p>
                    <p><strong>Check-out Date:</strong> <span id="checkoutDate"></span></p>
                    <p><strong>Check-out Time:</strong> <span id="checkoutTime"></span></p>
                    <p><strong>Total Companions:</strong> <span id="totalCompanions"></span></p>
                    <hr>
                    <div class="d-flex justify-content-center">
                      <p>Want to view this room?<a href=" " data-bs-dismiss="modal"> Click here</a></p>
                    </div>
                  </div>
                  <div class="col-md-6 col-12" id="paymentInfo" style="display: none;">
                    <h5>Payment Information</h5>
                    <img id="proofOfPayment" src="../img/general-img/upload-image.png" class="img-fluid" alt="Proof of Payment">
                    <p class="text-center">Transaction Reference Number: <span id="gcashReference"></span></p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <script>
          function fetchReservationDetails(revID) {
            fetch(`../../backends/user/fetch_user_reservation_details.php?revID=${revID}`)
              .then(response => {
                if (!response.ok) {
                  throw new Error('Network response was not ok');
                }
                return response.json();
              })
              .then(data => {
                console.log(data); // Log the data to see what is being returned
                if (data.error) {
                  throw new Error(data.error);
                }

                // Format the checkin and departure dates
                const checkinDate = new Date(data.checkin).toLocaleDateString('en-US', {
                  year: 'numeric',
                  month: 'long',
                  day: 'numeric'
                });
                const departureDate = new Date(data.departure).toLocaleDateString('en-US', {
                  year: 'numeric',
                  month: 'long',
                  day: 'numeric'
                });

                // Format the check-in and check-out times
                const checkinTime = new Date(`1970-01-01T${data.timeStart}Z`).toLocaleTimeString('en-US', {
                  hour: 'numeric',
                  minute: 'numeric',
                  hour12: true
                });
                const checkoutTime = new Date(`1970-01-01T${data.timeEnd}Z`).toLocaleTimeString('en-US', {
                  hour: 'numeric',
                  minute: 'numeric',
                  hour12: true
                });

                // Populate the modal with the fetched data
                document.getElementById('destination').textContent = data.BusinessName;
                document.getElementById('location').textContent = data.BusinessAddress;
                document.getElementById('roomName').textContent = data.roomName;
                document.getElementById('roomPrice').textContent = data.roomPrice;
                document.getElementById('status').textContent = data.status;
                document.getElementById('checkinDate').textContent = checkinDate;
                document.getElementById('checkinTime').textContent = checkinTime;
                document.getElementById('checkoutDate').textContent = departureDate;
                document.getElementById('checkoutTime').textContent = checkoutTime;
                document.getElementById('totalCompanions').textContent = data.totalnumAttendees;

                // Populate the payment information
                const paymentInfo = document.getElementById('paymentInfo');
                if (data.proofOfPayment && data.gcashReference) {
                  document.getElementById('proofOfPayment').src = `../uploads/${data.proofOfPayment}`;
                  document.getElementById('gcashReference').textContent = data.gcashReference;
                  paymentInfo.style.display = 'block';
                } else {
                  paymentInfo.style.display = 'none';
                }
              })
              .catch(error => {
                console.error('Error fetching reservation details:', error);
                const roomDetails = document.getElementById('roomDetails');
                roomDetails.innerHTML = `<p class="text-danger">Error fetching reservation details: ${error.message}</p>`;
              });
          }
        </script>

        <!-- Cancel Booking Modal -->
        <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Cancel Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form id="cancelForm">
                  <div class="mb-3">
                    <label for="cancelReason" class="form-label">Reason for Cancellation</label>
                    <textarea class="form-control" id="cancelReason" rows="3" required></textarea>
                  </div>
                </form>

                <!-- Non-refundable Notice -->
                <p class="text-danger mt-3" style="font-size: 0.9em; text-align: center;">
                  <span class="fw-bold">Note:</span> Payment is not refundable upon cancellation.
                </p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="cancelForm" class="btn btn-danger" id="submitCancellation">Submit Cancellation</button>
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
        <?php include '../user/include/footer.php'; ?>
      </footer>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../user/user.js"></script>
</body>

</html>