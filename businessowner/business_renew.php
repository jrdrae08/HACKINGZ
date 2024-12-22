<?php
require '../includes/db.php';
include "../backends/admin/fetch_business_types.php";
session_start();

$applicationID = $_GET['application_id'] ?? null;

if ($applicationID) {
  $stmt = $pdo->prepare("SELECT * FROM businessapplicationform WHERE ApplicationID = ?");
  $stmt->execute([$applicationID]);
  $application = $stmt->fetch(PDO::FETCH_ASSOC);

  $stmt = $pdo->prepare("SELECT bi.*, bt.TypeName AS BusinessType FROM businessinformationform bi JOIN businesstype bt ON bi.BusinessTypeID = bt.BusinessTypeID WHERE bi.ApplicationID = :applicationID");
  $stmt->bindParam(':applicationID', $applicationID, PDO::PARAM_INT);
  $stmt->execute();
  $businessInfo = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Business Renewal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <!-- Notyf connection -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="../css/registration.css">

  <style>
    .progress-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1rem;
    }

    .progress-step {
      width: 20px;
      height: 20px;
      background-color: #d3d3d3;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 12px;
      color: #fff;
    }

    .progress-step-active {
      background-color: #28a745;
    }

    .progress {
      width: 100%;
      height: 5px;
      background-color: #d3d3d3;
      position: relative;
    }

    .progress-bar {
      height: 5px;
      background-color: #28a745;
      width: 0;
      transition: width 0.3s;
    }

    .btn[disabled] {
      pointer-events: none;
      opacity: 0.6;
    }

    .note-text {
      font-size: 12px;
      font-weight: bold;
    }
  </style>
</head>

<body>
  <main>
    <form id="renewPermit" method="POST" enctype="multipart/form-data">
      <div class="row d-flex justify-content-center">
        <div class=" col-lg-4 col-md-8 col-sm-11">
          <div class="container">
            <div class="card shadow" style="margin-top:70px;">
              <div class="card-body">
                <div class="text-center">
                  <img src="../img/general-img/majayjay-logo.webp" alt="" height="50" width="50">
                  <h4 class="text-center">Business Registration Renewal</h4>
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

                <!-- Progress bar -->
                <div class="progress-container mx-5">
                  <div class="progress-step progress-step-active" data-step="1">1</div>
                  <div class="progress">
                    <div class="progress-bar" id="progress-bar"></div>
                  </div>
                  <div class="progress-step" data-step="2">2</div>
                </div>

                <div id="section1" class="section active">
                  <div class="row mx-3">
                    <div class="col-lg-12">
                      <h5 class="text-center">Step 1: Registrant Information</h5>
                    </div>

                    <div class="col-lg-6">
                      <div class="form-floating my-2">
                        <input type="text" class="form-control shadow" name="fname" id="fname" placeholder="" autocomplete="off" value="<?php echo htmlspecialchars($application['RegistrantFirstName'] ?? ''); ?>" required disabled>
                        <label>First Name</label>
                      </div>
                    </div>

                    <div class="col-lg-6">
                      <div class="form-floating my-2">
                        <input type="text" class="form-control shadow" name="lname" id="lname" placeholder="" autocomplete="off" value="<?php echo htmlspecialchars($application['RegistrantLastName'] ?? ''); ?>" required disabled>
                        <label>Last Name</label>
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="form-floating my-2">
                        <input type="text" class="form-control shadow" name="mname" id="mname" placeholder="" autocomplete="off" value="<?php echo htmlspecialchars($application['RegistrantMiddleName'] ?? ''); ?>" disabled>
                        <label>Middle Name (Optional)</label>
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="form-floating my-2">
                        <input type="text" class="form-control shadow" name="contact" id="contactNumber" placeholder="" autocomplete="off" value="<?php echo htmlspecialchars($application['ContactNumber'] ?? ''); ?>" required disabled>
                        <label>Contact Number</label>
                      </div>
                    </div>

                    <div class="col-lg-12">
                      <div class="form-floating mt-2">
                        <input type="email" class="form-control shadow" name="email" id="email" placeholder="" autocomplete="off" value="<?php echo htmlspecialchars($application['Email'] ?? ''); ?>" required disabled>
                        <label>Email Address</label>
                      </div>
                    </div>

                    <div class="col-lg-12 mt-2">
                      <div class="form-floating">
                        <input type="file" class="form-control shadow" name="businessPermitImage" id="businessPermitImage" accept="image/jpeg, image/jpg, image/png, image/gif" required>
                        <label for="businessPermitImage">Business Permit Image</label>
                      </div>
                    </div>

                    <div class="col-lg-12 mt-2">
                      <div class="form-floating">
                        <input type="date" class="form-control shadow" name="bexdate" id="exdate" required>
                        <label for="exdate">Business Permit Expiration Date</label>
                      </div>
                    </div>

                    <p class="note-text text-secondary m-0">Please make sure the date is the same as the date on business permit</p>

                    <div class="col-lg-12 d-flex justify-content-end my-3">
                      <div class="d-grid col-6">
                        <button type="button" class="btn btn-success" id="nextButton" onclick="nextSection(2)">NEXT</button>
                      </div>
                    </div>
                  </div>
                </div>

                <div id="section2" class="section">
                  <div class="row mx-3">
                    <div class="col-lg-12">
                      <div class="col-lg-12">
                        <h5 class="text-center">Step 2: Business Information</h5>
                        <div class="col-lg-12">
                          <div class="form-floating my-3">
                            <input type="text" class="form-control shadow" id="btype" name="btype" value="<?php echo htmlspecialchars($businessInfo['BusinessType'] ?? ''); ?>" readonly disabled>
                            <label for="btype">Type of business</label>
                          </div>
                        </div>

                        <div class="col-lg-12">
                          <div class="form-floating my-3">
                            <input type="text" class="form-control shadow" name="bname" id="bname" placeholder="" autocomplete="off" value="<?php echo htmlspecialchars($businessInfo['BusinessName'] ?? ''); ?>" required disabled>
                            <label>Business Name</label>
                          </div>
                        </div>

                        <div class="col-lg-12">
                          <div class="form-floating mt-3">
                            <input type="text" class="form-control shadow" name="badd" id="badd" placeholder="" autocomplete="off" value="<?php echo htmlspecialchars($businessInfo['BusinessAddress'] ?? ''); ?>" required disabled>
                            <label>Business Address</label>
                            <p class="note-text text-secondary m-0">(Ex. Street, Baranggay, Municipality/City, Province)</p>
                          </div>
                        </div>

                        <div class="col-lg-12">
                          <div class="form-floating my-3">
                            <input type="email" class="form-control shadow" name="bemail" id="bemail" placeholder="" autocomplete="off" value="<?php echo htmlspecialchars($businessInfo['BusinessEmail'] ?? ''); ?>" disabled>
                            <label>Business Email Address(Optional)</label>
                          </div>
                        </div>

                        <div class="col-lg-12">
                          <div class="form-floating my-3">
                            <input type="text" class="form-control shadow" id="bc" placeholder="" autocomplete="off" value="<?php echo htmlspecialchars($businessInfo['BusinessContactNumber'] ?? ''); ?>" disabled>
                            <label>Business Contact Number</label>
                          </div>
                        </div>

                        <div class="col-lg-12 mb-3">
                          <div class="form-floating my-2">
                            <textarea class="form-control shadow" name="bdesc" placeholder="Leave a comment here" id="floatingTextarea" style="height: 100px" required disabled><?php echo htmlspecialchars($businessInfo['BusinessDescription'] ?? ''); ?></textarea>
                            <label for="floatingTextarea">Business Descriptions</label>
                            <p class="note-text text-secondary m-0">(Maximum of 50 words)</p>
                          </div>
                        </div>

                        <div class="col-lg-12 d-flex mb-3">
                          <div class="d-grid col-6 mx-auto">
                            <button type="button" class="btn btn-secondary me-2" onclick="previousSection(1)">BACK</button>
                          </div>

                          <div class="d-grid col-6 mx-auto">
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#confirmUpdateModal">UPDATE</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>
        </div>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../js/businessowner.js"></script>

    <script>
      function nextSection(section) {
        document.querySelectorAll('.section').forEach(function(el) {
          el.classList.remove('active');
        });
        document.getElementById('section' + section).classList.add('active');
        updateProgressBar(section);
      }

      function previousSection(section) {
        document.querySelectorAll('.section').forEach(function(el) {
          el.classList.remove('active');
        });
        document.getElementById('section' + section).classList.add('active');
        updateProgressBar(section);
      }

      function updateProgressBar(section) {
        const progressBar = document.getElementById('progress-bar');
        const steps = document.querySelectorAll('.progress-step');
        steps.forEach((step, index) => {
          if (index < section) {
            step.classList.add('progress-step-active');
          } else {
            step.classList.remove('progress-step-active');
          }
        });
        progressBar.style.width = ((section - 1) / (steps.length - 1)) * 100 + '%';
      }
    </script>
  </main>
</body>