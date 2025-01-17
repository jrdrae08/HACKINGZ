<?php
//gcash-payment.php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'businessowner') {
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
  <title>Sub-admin Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <!-- Notyf connection -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <link rel="stylesheet" href="../css/businessowner.css">
</head>

<body>
  <div class="wrapper">

    <?php include '../businessowner/includes/aside.php'; ?>

    <div class="main">

      <?php include '../businessowner/includes/navbar.php'; ?>

      <main class="content">
        <div class="container-fluid">
          <div class="mb-3">
            <h3>Settings</h3>
          </div>
          <div class="row d-flex justify-content-center">
            <div class="col-lg-8 col-12">
              <div class="card shadow">
                <div class="card-header">
                  <h4 class="card-title">Set-up Business Payment Method</h4>
                  <button type="button" class="btn btn-warning px-4" onclick="showEditConfirmationModal()">Edit</button>
                </div>
                <form id="gcashForm" enctype="multipart/form-data">
                  <input type="hidden" name="isUpdate" id="isUpdate" value="0">
                  <div class="card-body">
                    <div class="row d-flex justify-content-center">
                      <div class="col-lg-6 col-9 text-center">
                        <h5 class="">G-Cash QR Code</h5>
                        <input name="qrimage1" type="file" id="qr-image-input-1" style="display: none;" accept="image/*" onchange="uploadImage('qr-image-input-1', 'qr-image-1')">
                        <label for="qr-image-input-1" class="image-container">
                          <img src="../img/general-img/insert.png" class="rounded img-fluid shadow border" alt="QR Image 1" id="qr-image-1" width="300" height="300">
                        </label>
                      </div>
                      <div class="col-lg-5 col-9 my-3">
                        <div class="row">
                          <div class="col-12">
                            <p class="">Enter your registered G-Cash Number</p>
                            <div class="form-floating mb-3">
                              <input type="number" name="gcashnum" class="form-control shadow" placeholder=" " required>
                              <label>G-Cash Number</label>
                            </div>
                          </div>
                          <div class="col-12">
                            <p class="">Enter the Account Name</p>
                            <div class="form-floating mb-3">
                              <input type="text" name="gcashname" class="form-control shadow" placeholder=" " required>
                              <label>G-Cash Account Name</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col-lg-12 hstack">
                        <button type="button" class="btn btn-success ms-auto px-4 me-2" id="saveButton" onclick="showConfirmationModal()">SAVE</button>
                        <a href="./dashboard.php" class="btn btn-secondary">CANCEL</a>
                      </div>
                    </div>
                  </div>
                </form>
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
        <?php include '../businessowner/includes/footer.php'; ?>
      </footer>
    </div>
  </div>

  <!-- Confirmation Modal -->
  <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmationModalLabel">Confirm Information</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure all the information is correct?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="confirmSubmit">Confirm</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Edit Confirmation Modal -->
  <div class="modal fade" id="editConfirmationModal" tabindex="-1" aria-labelledby="editConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editConfirmationModalLabel">Confirm Edit</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p>Are you sure you want to edit this information?</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="confirmEdit">Confirm</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../js/businessowner.js"></script>

  <script>
    function uploadImage(inputId, imgId) {
      var input = document.getElementById(inputId);
      var img = document.getElementById(imgId);
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          img.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
      }
    }

    function showConfirmationModal() {
      $('#confirmationModal').modal('show');
    }

    function showEditConfirmationModal() {
      $('#editConfirmationModal').modal('show');
    }

    $(document).ready(function() {
      const notyf = new Notyf({
        duration: 3000,
        position: {
          x: 'right',
          y: 'top'
        }
      });

      // Fetch existing data
      $.ajax({
        url: '../backends/subadmin/fetch-gcashinfo.php',
        type: 'GET',
        success: function(response) {
          var res = JSON.parse(response);
          if (res.data) {
            $('input[name="gcashnum"]').val(res.data.bgcashnum).prop('readonly', true);
            $('input[name="gcashname"]').val(res.data.bgcashname).prop('readonly', true);
            $('#qr-image-1').attr('src', res.data.bgcashQrImage);
            $('input[name="qrimage1"]').prop('disabled', true);
            $('#saveButton').prop('disabled', true); // Disable the SAVE button if a record exists
            $('#isUpdate').val('1'); // Indicate that this is an update
          }
        },
        error: function() {
          notyf.error('An error occurred while fetching the existing data.');
        }
      });

      $('#confirmSubmit').on('click', function() {
        var formData = new FormData($('#gcashForm')[0]);

        $.ajax({
          url: '../backends/subadmin/add-gcashinfo.php',
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
            var res = JSON.parse(response);
            if (res.message_type === 'success') {
              notyf.success(res.message);
            } else {
              notyf.error(res.message);
            }
            $('#confirmationModal').modal('hide');
          },
          error: function() {
            notyf.error('An error occurred while processing your request.');
            $('#confirmationModal').modal('hide');
          }
        });
      });

      $('#confirmEdit').on('click', function() {
        $('input[name="gcashnum"]').prop('readonly', false);
        $('input[name="gcashname"]').prop('readonly', false);
        $('input[name="qrimage1"]').prop('disabled', false);
        $('#saveButton').prop('disabled', false);
        $('#editConfirmationModal').modal('hide');
      });

      $('#saveButton').on('click', function() {
        showConfirmationModal();
      });
    });
  </script>
</body>

</html>