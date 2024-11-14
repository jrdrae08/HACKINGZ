<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking Information</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/registration.css">
</head>

<body>
  <main>
    <form id="registrationForm" method="POST" enctype="multipart/form-data" action="../backends/subadmin/businessregfunction.php">
      <div class="row d-flex justify-content-center">
        <div class="col-xl-4 col-lg-5 col-md-8 col-sm-11">
          <div class="container">
            <div class="card shadow" style="margin-top:70px;">
              <div class="card-body ">
                <div class="text-center">
                  <h4 class="text-center">Your Reservation</h4>
                </div>

                <!-- Notification Message -->
                <?php if (isset($_SESSION['message'])) : ?>
                  <div class="alert alert-<?php echo htmlspecialchars($_SESSION['type']); ?> alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_SESSION['message']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  <?php unset($_SESSION['message']); ?>
                  <?php unset($_SESSION['type']); ?>
                <?php endif; ?>

                <div class="progress-container mx-5">
                  <!-- Step markers -->
                  <div class="progress-step progress-step-active" data-step="1">1</div>
                  <div class="progress-step" data-step="2">2</div>
                  <div class="progress-step" data-step="3">3</div>

                  <!-- Single Progress Bar -->
                  <div class="progress">
                    <div class="progress-bar" id="progress-bar"></div>
                  </div>
                </div>


                <!-- Step 1: Registrant Information -->
                <div id="section1" class="section active">
                  <div class="row mx-2 mt-5 d-flex justify-content-center">
                    <div class="col-lg-12 mb-3">
                      <h5 class="text-center">Step 1: Personal Information</h5>
                    </div>

                    <!-- Form fields here -->
                    <div class="col-lg-10">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control shadow" name="fullname" placeholder=" " required>
                        <label for="" class="dm-sans-text">Full Name</label>
                      </div>
                    </div>
                    <div class="col-lg-10">
                      <div class="form-floating mb-3">
                        <input type="text" class="form-control shadow" name="regadd" placeholder=" " required>
                        <label for="" class="dm-sans-text">Address</label>
                      </div>
                    </div>
                    <div class="col-lg-10">
                      <div class="form-floating mb-3">
                        <input type="email" name="u_email" class="form-control shadow" required>
                        <label>Email Address</label>
                      </div>
                    </div>
                    <div class="col-lg-10">
                      <div class="form-floating mb-3">
                        <input type="number" name="u_contact" class="form-control shadow" required>
                        <label>Contact Number</label>
                      </div>
                    </div>

                    <div class="col-lg-12 d-flex justify-content-end my-3">
                      <div class="d-grid col-6">
                        <button type="button" class="btn btn-success" id="nextButton" onclick="nextSection()">NEXT</button>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Step 2: Business Information -->
                <div id="section2" class="section">
                  <div class="row mx-3 mt-5">
                    <div class="col-lg-12">
                      <h5 class="text-center">Step 2: Demographics</h5>
                    </div>

                    <!-- Dropdown for selecting valid ID type -->
                    <div class="col-lg-12 my-3">


                      <div class="row d-flex justify-content-center">

                        <div class="col-6">
                          <div class="form-floating mb-3">
                            <input type="number" name="" class="form-control shadow" placeholder="" required>
                            <label>Total Adults</label>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-floating mb-3">
                            <input type="number" name="" class="form-control shadow" placeholder="" required>
                            <label>Total Children</label>
                          </div>
                        </div>
                        <div class="col-6 text-center">
                          <button class="btn btn-primary">Generate Form</button>
                        </div>
                      </div>
                    </div>
                    <hr>
                    <div class="col-lg-12 mb-3">
                      <div class="row g-2 mb-3">
                        <p class="mb-0">Name of Attendee ${i}</p>
                        <div class="col-lg-7 col-12">
                          <input type="text" class="form-control shadow" name="name[]" placeholder="ex. Juan Dela Cruz" required>
                        </div>
                        <div class="col-lg-5 col-md-6 col-12">
                          <select name="sex[]" class="form-select shadow" required>
                            <option value="">Select Sex</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                          </select>
                          <select name="location[]" class="form-select shadow mt-2" required>
                            <option value="">Select Location</option>
                            <option value="This City/Municipality">This City/Municipality</option>
                            <option value="Other City/Municipality">Other City/Municipality</option>
                            <option value="Other Province">Other Province</option>
                            <option value="Foreign Country">Foreign Country</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="col-lg-12 d-flex my-3">
                      <div class="d-grid col-6 mx-auto">
                        <button type="button" class="btn btn-secondary me-2" onclick="previousSection()">BACK</button>
                      </div>
                      <div class="d-grid col-6">
                        <button type="button" class="btn btn-success" id="nextButton" onclick="nextSection()">NEXT</button>
                      </div>

                    </div>
                  </div>
                </div>

                <!-- Step 3 : Payment -->
                <div id="section3" class="section">
                  <div class="row mx-3 mt-5">
                    <div class="col-lg-12">
                      <h5 class="text-center">Step 3: Payment Information</h5>
                    </div>

                    <!-- Front ID Upload -->
                    <div class="col-lg-12 text-center mb-3">
                      <div>
                        <p>Please scan the GCash QR Code of the Resort and send a total amount of 1500 for the down payment.</p>
                      </div>
                      <div>
                        <img src="../admin/qrCode/6720cf31a65d8.png" class="img-fluid" alt="" height="30">
                      </div>

                    </div>

                    <!-- Back ID Upload -->
                    <div class="col-lg-12 mb-3">
                      <label for="back_id" class="mb-1 d-block text-start">Proof of Payment</label>
                      <input type="file" name="back_id" id="back_id" class="form-control shadow" accept="image/*" required>
                    </div>
                    <div class="col-lg-12 mb-3">
                      <div class="form-floating mb-3">
                        <input type="type" name="" class="form-control shadow" placeholder="" required>
                        <label>G-Cash Reference Number</label>
                      </div>
                    </div>

                    <div class="col-lg-12 d-flex my-3">
                      <div class="d-grid col-6 mx-auto">
                        <button type="button" class="btn btn-secondary me-2" onclick="previousSection()">BACK</button>
                      </div>
                      <div class="d-grid col-6 mx-auto">
                        <button type="submit" class="btn btn-success" id="registerButton">BOOK NOW</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- <div class="col-xl-5">

                </div> -->
      </div>
    </form>
  </main>

  <!-- JavaScript for section navigation -->
  <script>
    let currentStep = 1;

    function nextSection() {
      if (currentStep === 1) {
        document.getElementById("section1").classList.remove("active");
        document.getElementById("section2").classList.add("active");
        document.getElementById("progress-bar").style.width = "50%"; // 50% for step 2
        updateProgressStep(2);
        currentStep++;
      } else if (currentStep === 2) {
        document.getElementById("section2").classList.remove("active");
        document.getElementById("section3").classList.add("active");
        document.getElementById("progress-bar").style.width = "100%"; // 100% for step 3
        updateProgressStep(3);
        currentStep++;
      }
    }

    function previousSection() {
      if (currentStep === 2) {
        document.getElementById("section2").classList.remove("active");
        document.getElementById("section1").classList.add("active");
        document.getElementById("progress-bar").style.width = "0%"; // 0% for step 1
        updateProgressStep(1);
        currentStep--;
      } else if (currentStep === 3) {
        document.getElementById("section3").classList.remove("active");
        document.getElementById("section2").classList.add("active");
        document.getElementById("progress-bar").style.width = "50%"; // 50% for step 2
        updateProgressStep(2);
        currentStep--;
      }
    }

    function updateProgressStep(step) {
      const steps = document.querySelectorAll(".progress-step");
      steps.forEach((s, index) => {
        s.classList.toggle("progress-step-active", index < step);
      });
    }
  </script>

  <style>
    .progress-container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-top: 20px;
      position: relative;
    }

    .progress {
      position: absolute;
      top: 50%;
      left: 0;
      right: 0;
      height: 4px;
      background-color: #e0e0e0;
      z-index: 1;
    }

    .progress-bar {
      height: 100%;
      background-color: #4caf50;
      width: 0;
      /* Start at 0%, will be controlled in JavaScript */
      transition: width 0.4s ease;
      z-index: 2;
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
      z-index: 3;
    }

    .progress-step-active {
      background-color: #4caf50;
      color: #fff;
    }
  </style>



  <script src="../sweetalert2/jquery-3.7.1.min.js"></script>
  <script src="../sweetalert2/sweetalert2.all.min.js"></script>
</body>

</html>