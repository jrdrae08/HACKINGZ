<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Notyf library -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <link rel="stylesheet" href="../css/registration.css">
</head>

<body>
  <main>
    <form id="registrationForm" method="POST" enctype="multipart/form-data" action="../backends/user/user-regfunction.php">
      <div class="row d-flex justify-content-center">
        <div class="col-lg-4 col-md-8 col-sm-11">
          <div class="container">
            <div class="card shadow" style="margin-top:70px;">
              <div class="card-body">
                <div class="d-flex justify-content-end my-2">
                  <div>
                    <a href="../homepage/homepage.php"><i class="bi bi-x-lg text-success btn-close"></i></a>
                  </div>
                </div>

                <div class="text-center">
                  <img src="../img/general-img/majayjay-logo.webp" alt="" height="50" width="50">
                  <h4 class="text-center">User Registration</h4>
                </div>

                <!-- Progress bar -->
                <div class="progress-container mx-5">
                  <div class="progress-step progress-step-active" data-step="1">1</div>
                  <div class="progress">
                    <div class="progress-bar" id="progress-bar"></div>
                  </div>
                  <div class="progress-step" data-step="2">2</div>
                </div>

                <!-- Step 1: Registrant Information -->
                <div id="section1" class="section active">
                  <div class="row mx-3">
                    <div class="col-lg-12 mb-3">
                      <h5 class="text-center">Step 1: Add Personal Information</h5>
                    </div>

                    <!-- First Name -->
                    <div class="col-lg-6">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control shadow" name="fname" id="fname" required>
                        <label>First Name</label>
                      </div>
                    </div>

                    <!-- Last Name -->
                    <div class="col-lg-6">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control shadow" name="lname" id="lname" required>
                        <label>Last Name</label>
                      </div>
                    </div>

                    <!-- Email Address -->
                    <div class="col-lg-6">
                      <div class="form-floating mb-3">
                        <input type="email" name="u_email" id="u_email" class="form-control shadow" required>
                        <label>Email Address</label>
                      </div>
                    </div>

                    <!-- Contact Number -->
                    <div class="col-lg-6">
                      <div class="form-floating mb-3">
                        <input type="text" name="u_contact" id="u_contact" class="form-control shadow" required>
                        <label>Contact Number</label>
                      </div>
                    </div>

                    <!-- Full Address -->
                    <div class="col-lg-12">
                      <div class="form-floating mb-3">
                        <input type="text" name="u_address" id="u_address" class="form-control shadow" required>
                        <label>Full Address</label>
                        <span class="badge text-secondary">Ex. (Street, Barangay, Municipality/City, Province)</span>
                      </div>
                    </div>

                    <!-- Location Type -->
                    <div class="col-lg-12">
                      <div class="form-floating my-3">
                        <select class="form-select shadow" id="locationType" name="locationType" required>
                          <option value="" disabled selected>Select Location Type</option>
                          <option value="This City/Municipality">This City/Municipality</option>
                          <option value="Other City/Municipality">Other City/Municipality</option>
                          <option value="Other Province">Other Province</option>
                          <option value="Foreign Country">Foreign Country</option>
                        </select>
                        <label for="locationType">Location Type</label>
                      </div>
                    </div>

                    <!-- Sex -->
                    <div class="col-lg-12">
                      <div class="form-floating my-3">
                        <select class="form-select shadow" id="sex" name="sex" required>
                          <option value="" disabled selected>Select Sex</option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                        </select>
                        <label for="sex">Sex</label>
                      </div>
                    </div>

                    <div class="col-lg-12 d-flex justify-content-end mt-3">
                      <div class="d-grid col-6">
                        <button type="button" class="btn btn-success" id="nextButton" onclick="nextSection()" disabled>NEXT</button>
                      </div>
                    </div>
                    <div class="col-lg-12 text-center">
                      <hr>
                      <p>Already have an account? <a href="../login.php" class="btn btn-primary">LOG IN</a></p>
                    </div>
                  </div>
                </div>

                <!-- Step 2: Business Information -->
                <div id="section2" class="section">
                  <div class="row mx-3">
                    <div class="col-lg-12">
                      <h5 class="text-center">Step 2: Upload Valid ID</h5>
                    </div>

                    <!-- Dropdown for selecting valid ID type -->
                    <div class="col-lg-12 mb-3">
                      <label for="id_type" class="mb-1 d-block text-start">Select ID Type</label>
                      <select name="id_type" id="id_type" class="form-control shadow" required onchange="checkSection2Fields()">
                        <option value="" disabled selected>Select ID Type</option>
                        <option value="Passport">Passport</option>
                        <option value="Driver's License">Driver's License</option>
                        <option value="National ID">National ID</option>
                        <option value="Voter ID">Voter ID</option>
                        <option value="Social Security ID">Social Security ID</option>
                        <option value="Student ID">Student ID</option>
                        <option value="other">Other</option>
                      </select>
                    </div>

                    <!-- Other ID Type -->
                    <div class="col-lg-12 mb-3" id="other_id_type_container" style="display: none;">
                      <label for="other_id_type" class="mb-1 d-block text-start">Specify Other ID Type</label>
                      <input type="text" name="other_id_type" id="other_id_type" class="form-control shadow">
                    </div>

                    <!-- Front ID Upload -->
                    <div class="col-lg-12 mb-3">
                      <label for="front_id" class="mb-1 d-block text-start">Upload Front of Valid ID</label>
                      <input type="file" name="front_id" id="front_id" class="form-control shadow" accept="image/*" required onchange="checkSection2Fields()">
                    </div>

                    <!-- Back ID Upload -->
                    <div class="col-lg-12 mb-3">
                      <label for="back_id" class="mb-1 d-block text-start">Upload Back of Valid ID</label>
                      <input type="file" name="back_id" id="back_id" class="form-control shadow" accept="image/*">
                    </div>

                    <script>
                      function checkSection2Fields() {
                        const idType = document.getElementById('id_type').value;
                        const frontId = document.getElementById('front_id').files.length > 0;
                        const nextButton = document.getElementById('nextButton');
                        const submitButton = document.getElementById('submitButton');

                        if (idType && frontId) {
                          nextButton.disabled = false;
                          submitButton.disabled = false;
                        } else {
                          nextButton.disabled = true;
                          submitButton.disabled = true;
                        }
                      }
                    </script>

                    <div class="col-lg-12 d-flex mt-3">
                      <div class="d-grid col-6 mx-auto">
                        <button type="button" class="btn btn-secondary me-2" onclick="previousSection()">BACK</button>
                      </div>
                      <div class="d-grid col-6 mx-auto">
                        <button type="button" class="btn btn-success" id="submitButton" onclick="showConfirmationModal()" disabled>Register</button>
                      </div>
                    </div>
                    <div class="col-lg-12 text-center">
                      <hr>
                      <p>Already have an account? <a href="../login.php" class="btn btn-primary">LOG IN</a></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </form>
  </main>

  <!-- Confirmation Modal -->
  <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmationModalLabel">Confirm Submission</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to submit this form?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="confirmSubmitButton">Confirm</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function showConfirmationModal() {
      var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
      confirmationModal.show();
    }

    $(document).ready(function() {
      // Initialize notyf
      var notyf = new Notyf({
        duration: 3000,
        position: {
          x: 'right',
          y: 'top',
        }
      });

      $('#confirmSubmitButton').on('click', function() {
        var confirmationModal = bootstrap.Modal.getInstance(document.getElementById('confirmationModal'));
        confirmationModal.hide(); // Hide the modal
        $('#registrationForm').submit();
      });

      $('#registrationForm').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        var formData = new FormData(this);

        $.ajax({
          url: '../backends/user/user-regfunction.php',
          type: 'POST',
          data: formData,
          contentType: false,
          processData: false,
          success: function(response) {
            var res = JSON.parse(response);
            if (res.status === 'success') {
              notyf.success(res.message);
              setTimeout(function() {
                window.location.href = '../backends/user/success.php';
              }, 3000);
              session_unset();
              session_destroy();
            } else {
              notyf.error(res.message);
            }
          },
          error: function() {
            notyf.error('An error occurred while processing your request.');
          }
        });
      });
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- JavaScript for section navigation -->
  <script>
    document.getElementById('id_type').addEventListener('change', function() {
      if (this.value === 'other') {
        document.getElementById('other_id_type_container').style.display = 'block';
      } else {
        document.getElementById('other_id_type_container').style.display = 'none';
      }
    });

    function handleContactInput(event) {
      let value = event.target.value;
      if (!value.startsWith('+63')) {
        value = '+63' + value.replace(/\D/g, '');
      } else {
        value = '+63' + value.slice(3).replace(/\D/g, '');
      }
      if (value.length > 13) {
        value = value.slice(0, 13);
      }
      event.target.value = value;
    }

    function validateFields() {
      const fname = document.getElementById('fname').value.trim();
      const lname = document.getElementById('lname').value.trim();
      const u_contact = document.getElementById('u_contact').value.trim();
      const u_email = document.getElementById('u_email').value.trim();
      const u_address = document.getElementById('u_address').value.trim();
      const locationType = document.getElementById('locationType').value;
      const sex = document.getElementById('sex').value;
      const id_type = document.getElementById('id_type').value;
      const front_id = document.getElementById('front_id').files.length;

      const isValidEmail = email => {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@(([^<>()[\]\\.,;:\s@"]+\.)+[^<>()[\]\\.,;:\s@"]{2,})$/i;
        return re.test(String(email).toLowerCase());
      }

      const section1Valid = fname && lname && u_contact.length === 13 && isValidEmail(u_email) && u_address && locationType && sex;
      const section2Valid = id_type && front_id > 0;

      if (section1Valid) {
        document.getElementById('nextButton').removeAttribute('disabled');
      } else {
        document.getElementById('nextButton').setAttribute('disabled', 'true');
      }

      if (section2Valid) {
        document.getElementById('registerButton').removeAttribute('disabled');
      } else {
        document.getElementById('registerButton').setAttribute('disabled', 'true');
      }
    }

    document.getElementById('u_contact').addEventListener('input', handleContactInput);
    document.querySelectorAll('#fname, #lname, #u_contact, #u_email, #u_address, #locationType, #sex, #id_type, #front_id').forEach(element => {
      element.addEventListener('input', validateFields);
      element.addEventListener('change', validateFields);
    });

    document.addEventListener('DOMContentLoaded', function() {
      const formData = JSON.parse(sessionStorage.getItem('formData'));
      if (formData) {
        document.getElementById('fname').value = formData.fname;
        document.getElementById('lname').value = formData.lname;
        document.getElementById('u_email').value = formData.u_email;
        document.getElementById('u_contact').value = formData.u_contact;
        document.getElementById('u_address').value = formData.u_address;
        document.getElementById('locationType').value = formData.locationType;
        document.getElementById('sex').value = formData.sex;
        document.getElementById('id_type').value = formData.id_type;
        document.getElementById('other_id_type').value = formData.other_id_type;

        if (formData.id_type === 'other') {
          document.getElementById('other_id_type_container').style.display = 'block';
        }
      } else {
        document.getElementById('u_contact').value = '+63';
      }
      validateFields();
    });

    function nextSection() {
      saveFormData();
      document.getElementById("section1").classList.remove("active");
      document.getElementById("section2").classList.add("active");
      document.getElementById("progress-bar").style.width = "100%";
      updateProgressStep(2);
      validateFields();
    }

    function previousSection() {
      saveFormData();
      document.getElementById("section2").classList.remove("active");
      document.getElementById("section1").classList.add("active");
      document.getElementById("progress-bar").style.width = "50%";
      updateProgressStep(1);
      validateFields();
    }

    function updateProgressStep(step) {
      const steps = document.querySelectorAll(".progress-step");
      steps.forEach((s, index) => {
        s.classList.toggle("progress-step-active", index < step);
      });
    }

    function saveFormData() {
      const formData = {
        fname: document.getElementById('fname').value,
        lname: document.getElementById('lname').value,
        u_email: document.getElementById('u_email').value,
        u_contact: document.getElementById('u_contact').value,
        u_address: document.getElementById('u_address').value,
        locationType: document.getElementById('locationType').value,
        sex: document.getElementById('sex').value,
        id_type: document.getElementById('id_type').value,
        other_id_type: document.getElementById('other_id_type').value
      };
      sessionStorage.setItem('formData', JSON.stringify(formData));
    }

    function clearFormData() {
      sessionStorage.removeItem('formData');
      document.getElementById('registrationForm').reset();
      document.getElementById('other_id_type_container').style.display = 'none';
      document.getElementById("progress-bar").style.width = "50%";
      updateProgressStep(1);
      document.getElementById("section1").classList.add("active");
      document.getElementById("section2").classList.remove("active");
      validateFields();
      document.getElementById('u_contact').value = '+63';
    }

    // Clear form data if registration is successful
    <?php if (isset($_SESSION['message']) && $_SESSION['type'] === 'success') : ?>
      clearFormData();
    <?php endif; ?>
  </script>


  <style>
    .progress-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-top: 20px;
    }

    .progress {
      flex: 1;
      height: 4px;
      background-color: #e0e0e0;
      margin: 0 10px;
    }

    .progress-bar {
      height: 100%;
      width: 50%;
      background-color: #4caf50;
      transition: width 0.3s;
    }

    .progress-step {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background-color: #e0e0e0;
      display: flex;
      justify-content: center;
      align-items: center;
      font-weight: bold;
      color: #4caf50;
    }

    .progress-step-active {
      background-color: #4caf50;
      color: #fff;
    }

    .section {
      display: none;
    }

    .section.active {
      display: block;
    }
  </style>

</body>

</html>