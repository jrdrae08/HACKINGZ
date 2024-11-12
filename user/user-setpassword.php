<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/login.css">
  <title>Change Password</title>
  <style>
    .fade-out {
      opacity: 0;
      transition: opacity 1s ease-out;
    }
  </style>
</head>

<body>
  <main>
    <div class="container d-flex justify-content-lg-center align-items-center" style="height: 100vh;">
      <div class="card text-center m-2" style="width: 750px;">
        <div class="card-body">
          <div class="row d-flex justify-content-around align-items-center">
            <div class="col-lg-5 d-flex justify-content-center align-items-center">
              <img src="../img/admin-img/majayjay-logo.webp" class="" alt="" height="200" width="200">
            </div>
            <div class="col-lg-6 mx-2">
              <h4 class="mt-2 mb-4">Setup your password</h4>
              <div class="form-floating mt-3">
                <input type="text" class="form-control shadow " id="userEmail" name="userEmail" autocomplete="off" required>
                <label for="userEmail">Email</label>
              </div>
              <?php if (!empty($message)) : ?>
                <div class="alert alert-<?= htmlspecialchars($message_type) ?> alert-dismissible fade show" role="alert">
                  <?= htmlspecialchars($message) ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>
              <form action="changepass.php" method="POST">
                <div class="form-floating my-3">
                  <input type="password" class="form-control shadow" id="floatingPassword" name="new_password" autocomplete="off" required>
                  <label for="floatingPassword">New Password</label>
                </div>
                <div class="form-floating mt-3">
                  <input type="password" class="form-control shadow " id="floatingConfirmPassword" name="confirm_password" autocomplete="off" required>
                  <label for="floatingConfirmPassword">Confirm Password</label>
                </div>
                <p class="text-secondary mt-2 mx-2" style="text-align:justify; font-size: 13px"> Password Should be at least 8 characters long and must contain at least one uppercase letter, one lowercase letter, one number, and one special character.
                </p>
                <div class="d-grid gap-1 my-3">
                  <button type="submit" class="btn btn-success">Confirm</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const alertBox = document.querySelector('.alert');
      if (alertBox) {
        setTimeout(() => {
          alertBox.classList.add('fade-out');
          setTimeout(() => {
            alertBox.style.display = 'none';
          }, 1000); // Match the CSS transition duration
        }, 5000); // Wait 5 seconds before starting the fade out
      }
    });
  </script>
</body>

</html>