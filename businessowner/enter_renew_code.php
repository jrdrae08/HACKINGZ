<?php
include "../backends/admin/fetch_business_types.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Business Renewal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <!-- Notyf connection -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <link rel="stylesheet" href="../css/registration.css">
</head>

<body>
  <main>
    <div class="row d-flex justify-content-center">
      <div class=" col-lg-4 col-md-8 col-sm-11">
        <div class="container">
          <div class="card shadow" style="margin-top:70px;">
            <div class="card-body">
              <div class="d-flex justify-content-end my-2">
                <div>
                  <a href="../businessowner/business-registration.php"><i class="bi bi-x-lg text-success btn-close"></i></a>
                </div>
              </div>
              <form id="permitForm" method="POST" action="../../backends/subadmin/renewal_function.php">
                <div class="text-center mb-3">
                  <img src="../img/general-img/majayjay-logo.webp" alt="" height="50" width="50">
                  <h4 class="text-center">Business Renewal</h4>
                </div>

                <div class="d-flex justify-content-center">
                  <p class="fw-bold text-secondary  mx-5">Please enter your reference number to renew your business permit.</p>
                </div>

                <div class="row mx-4 d-flex justify-content-center align-items-center mb-3">
                  <div class="col-lg-8">
                    <div class="form-floating">
                      <input type="text" class="form-control shadow" name="refNum" id="refNum" placeholder="" autocomplete="off" required>
                      <label>Reference Number</label>
                    </div>
                  </div>
                  <div class="col-lg-4">
                    <div class="permit-button d-grid">
                      <button type="submit" class="btn btn-success">Check</button>
                    </div>
                  </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  </main>
  
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const notyf = new Notyf({
        duration: 3000, // Adjust the duration as needed
        position: {
          x: 'right',
          y: 'top'
        }
      });

      const form = document.getElementById('permitForm');
      form.addEventListener('submit', async (event) => {
        event.preventDefault();

        const formData = new FormData(form);
        const response = await fetch(form.action, {
          method: 'POST',
          body: formData
        });

        const result = await response.json();

        if (result.status === 'success') {
          notyf.success(result.message);

          // Store the fetched data and applicationID in session storage
          sessionStorage.setItem('formData', JSON.stringify(result.data));
          sessionStorage.setItem('applicationID', result.applicationID);
          sessionStorage.setItem('refNum', formData.get('refNum'));

          // Log the applicationID to the console for verification
          console.log('Stored ApplicationID:', result.applicationID);
          console.log('Stored RefNum:', formData.get('refNum'));

          setTimeout(() => {
            window.location.href = result.redirect;
          }, 3000); // Adjust the delay as needed
        } else {
          notyf.error(result.message);
        }
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <script src="../js/businessowner.js"></script>

</body>

</html>