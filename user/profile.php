<?php
session_start();

$userID = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if ($userID === null) {
  echo "User ID is not set.";
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Profile</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
  <!-- Notify Links -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="../user/user.css">
</head>

<body>
  <div class="wrapper">
    <?php include '../user/include/aside.php'; ?>

    <div class="main">
      <?php include '../user/include/navbar.php'; ?>

      <main class="content">
        <div class="container-fluid">
          <h3 class="text-dark">Profile</h3>
          <div class="row d-flex justify-content-center">
            <div class="col-lg-8 col-12">
              <div class="card border-0 shadow">
                <div class="card-body">
                  <form id="profileForm">
                    <div class="mb-3">
                      <label for="full_name" class="form-label">Full Name</label>
                      <input type="text" class="form-control" id="full_name" name="full_name" disabled>
                    </div>
                    <div class="mb-3">
                      <label for="u_email" class="form-label">Email</label>
                      <input type="email" class="form-control" id="u_email" name="u_email" disabled>
                    </div>
                    <div class="mb-3">
                      <label for="u_contact" class="form-label">Contact</label>
                      <input type="text" class="form-control" id="u_contact" name="u_contact" disabled>
                    </div>
                    <div class="mb-3">
                      <label for="u_address" class="form-label">Address</label>
                      <input type="text" class="form-control" id="u_address" name="u_address" disabled>
                    </div>
                    <div class="mb-3">
                      <label for="locationType" class="form-label">Location Type</label>
                      <input type="text" class="form-control" id="locationType" name="locationType" disabled>
                    </div>
                    <div class="mb-3">
                      <label for="sex" class="form-label">Sex</label>
                      <input type="text" class="form-control" id="sex" name="sex" disabled>
                    </div>
                    <div class="mb-3">
                      <label for="id_type" class="form-label">ID Type</label>
                      <input type="text" class="form-control" id="id_type" name="id_type" disabled>
                    </div>
                    <div class="mb-3">
                      <label for="front_id" class="form-label">Front ID</label>
                      <img id="front_id" class="img-fluid" alt="Front ID">
                    </div>
                    <div class="mb-3" id="back_id_container">
                      <label for="back_id" class="form-label">Back ID</label>
                      <img id="back_id" class="img-fluid" alt="Back ID">
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
      <footer class="footer">
        <!-- Footer content -->
      </footer>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      var userId = <?php echo json_encode($userID); ?>; // Get the user ID from the PHP session

      $.ajax({
        url: '../../backends/user/fetch_user.php',
        type: 'GET',
        data: {
          userId: userId
        },
        success: function(response) {
          var data = JSON.parse(response);
          if (data.status === 'success') {
            $('#full_name').val(data.data.full_name);
            $('#u_email').val(data.data.u_email);
            $('#u_contact').val(data.data.u_contact);
            $('#u_address').val(data.data.u_address);
            $('#locationType').val(data.data.locationType);
            $('#sex').val(data.data.sex);
            $('#id_type').val(data.data.id_type);
            $('#front_id').attr('src', data.data.front_id);

            if (data.data.back_id) {
              $('#back_id').attr('src', data.data.back_id);
            } else {
              $('#back_id_container').hide();
            }
          } else {
            alert(data.message);
          }
        },
        error: function() {
          alert('An error occurred while fetching the user data.');
        }
      });
    });
  </script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../user/user.js"></script>

</html>