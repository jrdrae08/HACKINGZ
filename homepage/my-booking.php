<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking Information</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="../css/registration.css">
  <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500&display=swap');

    .dm-sans-text {
      font-family: "DM Sans", sans-serif;
      font-weight: 400;
      font-style: normal;
    }
  </style>
</head>

<body>
  <main class="vh-100 d-flex align-items-center justify-content-center">
    <section class="container">
      <div class="row d-flex justify-content-center align-items-center">
        <div class="col-lg-8 col-11 border rounded bg-light shadow p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h4 class="text-center dm-sans-text mb-0">My Bookings</h4>
            <a href="../homepage/homepage.php" class="btn-close" aria-label="Close"></a>
          </div>
          <hr>
          <div class="card mb-3">
            <div class="card-header bg-primary text-white">
              <h5 class="mb-0">Sunset Resort</h5>
            </div>
            <div class="card-body">
              <h6 class="card-title">Room Name: Ocean View Suite</h6>
              <p class="card-text dm-sans-text">
                <strong>Date and Time Booked:</strong> January 1, 2024, 10:00 AM<br>
                <strong>Date and Time Scheduled:</strong> January 10, 2024, 3:00 PM<br>
                <strong>Room Facilities:</strong> Pool, Wi-Fi, Air Conditioning, Gym Access<br>
                <strong>Room Features:</strong> King Bed, Balcony with Sea View, Mini Bar<br>
                <strong>Room Price:</strong> $250 per night<br>
                <strong>Number of Adults:</strong> 2<br>
                <strong>Number of Children:</strong> 1<br>
                <strong>Reference Number:</strong> 123456789
              </p>
              <!-- Cancel Booking Button -->
              <div class="text-center mt-3">
                <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#cancelModal">Cancel Booking</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

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


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../sweetalert2/jquery-3.7.1.min.js"></script>
  <script src="../sweetalert2/sweetalert2.all.min.js"></script>
  <script>
    document.getElementById("cancelForm").addEventListener("submit", function(event) {
      event.preventDefault(); // Prevent form submission to backend
      const reason = document.getElementById("cancelReason").value;

      Swal.fire({
        title: 'Are you sure?',
        text: "Do you really want to cancel your booking?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Cancel It'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: 'Cancelled!',
            text: 'Your booking has been cancelled.',
            icon: 'success'
          }).then(() => {
            // Reset the form and close the modal
            document.getElementById("cancelForm").reset();
            const modal = bootstrap.Modal.getInstance(document.getElementById('cancelModal'));
            modal.hide();
          });
        }
      });
    });
  </script>
</body>

</html>