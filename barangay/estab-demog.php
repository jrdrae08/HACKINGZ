<?php
include '../includes/db.php';

// Get the barangayId from the URL and validate it
$barangayId = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : null;
$establishmentName = "Invalid barangay ID.";

// Check if barangayId is valid
if ($barangayId) {
  try {
    // Prepare and execute statement to retrieve the establishment information
    $stmt = $pdo->prepare("SELECT establishment FROM barangay_accounts WHERE barangayId = :barangay_id");
    $stmt->execute([':barangay_id' => $barangayId]);

    // Fetch the establishment data
    $barangay = $stmt->fetch(PDO::FETCH_ASSOC);

    $establishmentName = $barangay ? htmlspecialchars($barangay['establishment']) : "No establishment information found for this barangay.";
  } catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $establishmentName = "An error occurred. Please try again later.";
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if ($barangayId === null) {
    echo "Invalid barangay ID.";
    exit;
  }

  $names = $_POST['name'] ?? [];
  $sexes = $_POST['sex'] ?? [];
  $locations = $_POST['location'] ?? [];

  // Initialize counters
  $totalnumAttendees = count($names);
  $totalmale = 0;
  $totalfemale = 0;
  $thisCity = 0;
  $otherCity = 0;
  $otherProvince = 0;
  $foreignCountry = 0;

  // Check that we have an equal number of names, sexes, and locations
  if ($totalnumAttendees === count($sexes) && $totalnumAttendees === count($locations)) {
    $concatenatedNames = [];
    $concatenatedSexes = [];
    $concatenatedLocations = [];

    foreach ($names as $index => $name) {
      $name = filter_var($name, FILTER_SANITIZE_STRING);
      $sex = filter_var($sexes[$index] ?? '', FILTER_SANITIZE_STRING);
      $location = filter_var($locations[$index] ?? '', FILTER_SANITIZE_STRING);

      // Ensure all fields are filled
      if (empty($name) || empty($sex) || empty($location)) {
        echo "All fields are required.";
        exit;
      }

      $concatenatedNames[] = $name;
      $concatenatedSexes[] = $sex;
      $concatenatedLocations[] = $location;

      // Count by sex
      if ($sex === 'Male') {
        $totalmale++;
      } elseif ($sex === 'Female') {
        $totalfemale++;
      }

      // Count by location
      switch ($location) {
        case 'This City/Municipality':
          $thisCity++;
          break;
        case 'Other City/Municipality':
          $otherCity++;
          break;
        case 'Other Province':
          $otherProvince++;
          break;
        case 'Foreign Country':
          $foreignCountry++;
          break;
      }
    }

    // Concatenate the arrays into strings
    $allNames = implode(', ', $concatenatedNames);
    $allSexes = implode(', ', $concatenatedSexes);
    $allLocations = implode(', ', $concatenatedLocations);

    try {
      // Insert demographic data into the database
      $stmt = $pdo->prepare("INSERT INTO demographics (barangayId, name, sex, location, created_at, totalnumAttendees, totalmale, totalfemale, thisCity, otherCity, otherProvince, foreignCountry) VALUES (:barangayId, :name, :sex, :location, NOW(), :totalnumAttendees, :totalmale, :totalfemale, :thisCity, :otherCity, :otherProvince, :foreignCountry)");
      $stmt->execute([
        ':barangayId' => $barangayId,
        ':name' => $allNames,
        ':sex' => $allSexes,
        ':location' => $allLocations,
        ':totalnumAttendees' => $totalnumAttendees,
        ':totalmale' => $totalmale,
        ':totalfemale' => $totalfemale,
        ':thisCity' => $thisCity,
        ':otherCity' => $otherCity,
        ':otherProvince' => $otherProvince,
        ':foreignCountry' => $foreignCountry
      ]);
    } catch (PDOException $e) {
      echo "Error: " . $e->getMessage();
    }

    // Wait for 5 seconds before redirecting
    sleep(5);
    header('Location: estab-demog.php?id=' . $barangayId);
  } else {
    echo "All fields are required for each attendee.";
  }
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Majayjay Website</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Jaro:opsz@6..72&family=Poetsen+One&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,800">
  <link rel="stylesheet" href="../../resort/new-resort-ui.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">
  <style>
    body {
      overflow-x: hidden;
      position: relative;
      background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.5)), url('../../img/businessowner-img/majayjay falls.jpg');
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      background-repeat: no-repeat;
    }

    .hr-1 {
      border-top: 1px solid #000;
      width: 100%;
    }

    .hr-2 {
      border-top: 1px solid #adb5bd;
      width: 100%;
    }

    .card {
      max-width: 550px;
      width: 100%;
    }

    .loading-spinner {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 1000;
    }
  </style>
</head>

<body>
  <div class="loading-spinner" id="loadingSpinner">
    <div class="spinner-border text-primary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>
  <main class="content">
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
      <div class="row d-flex justify-content-center">
        <div class="col-12 d-flex justify-content-center">
          <form id="barangayForm" action="" method="POST">
            <div class="card">
              <div class="card-body">
                <div class="row g-2">
                  <div class="col-12 my-4 d-flex align-items-center justify-content-center">
                    <img src="../../img/general-img/majayjay-logo.webp" class="img-fluid" alt="" height="100px" width="100px">
                  </div>
                  <div class="col-12 text-center">
                    <div class="text-center">
                      <h3 class="fw-bold">Welcome to (<?php echo htmlspecialchars($establishmentName); ?>)!</h3>
                    </div>
                    <div class="text-center" style="font-size: 15px;">
                      <p>Please fill up the form needed before proceeding to the location.</p>
                    </div>
                  </div>
                  <div class="col-12 mb-3 d-flex justify-content-center">
                    <div class="col-lg-5 col-7 me-3">
                      <div class="form-floating">
                        <input type="number" class="form-control shadow" id="numberOfAttendeesInput" placeholder=" " required>
                        <label for="numberOfAttendeesInput">Number of Attendees</label>
                      </div>
                    </div>
                    <div class="col-lg-2 col-4 d-flex justify-content-center align-items-center">
                      <button type="button" class="btn btn-success px-3" id="addAttendeesButton" disabled>Add</button>
                    </div>
                  </div>

                  <div class="col-12 mt-4 d-flex justify-content-center">
                    <h4>Attendees' Information</h4>
                  </div>
                  <div class="hr-2"></div>
                  <div id="attendeesInfoContainer" class="col-12 mb-4 d-flex justify-content-center flex-column">
                    <!-- Attendee fields will be appended here -->
                  </div>

                  <div class="col-12 d-flex justify-content-center">
                    <button type="button" class="btn btn-success px-4" id="submitButton" disabled>SUBMIT</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
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
          Are you sure you want to submit the form?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="confirmSubmitButton">Confirm</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
  <script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <script src="../homepage/homepage.js"></script>

  <script>
    function updateButtonText(buttonId, text) {
      const button = document.getElementById(buttonId);
      button.innerHTML = text;
    }

    document.getElementById('numberOfAttendeesInput').addEventListener('input', function() {
      const addAttendeesButton = document.getElementById('addAttendeesButton');
      addAttendeesButton.disabled = this.value <= 0;
    });

    document.getElementById('addAttendeesButton').addEventListener('click', function() {
      const numberOfAttendees = parseInt(document.getElementById('numberOfAttendeesInput').value, 10);
      const attendeesInfoContainer = document.getElementById('attendeesInfoContainer');

      // Clear previous attendee fields
      attendeesInfoContainer.innerHTML = '';

      // Generate attendee fields
      for (let i = 1; i <= numberOfAttendees; i++) {
        attendeesInfoContainer.insertAdjacentHTML('beforeend', `
      <div class="row g-2 mb-3">
        <p class="mb-0">Name of Attendee ${i}</p>
        <div class="col-lg-5 col-12">
          <input type="text" class="form-control shadow" name="name[]" placeholder="ex. Juan Dela Cruz" required>
        </div>
        <div class="col-lg-7 col-md-6 col-12">
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
    `);
      }

      attachInputListeners();
    });

    function attachInputListeners() {
      const names = document.querySelectorAll('input[name="name[]"]');
      const sexes = document.querySelectorAll('select[name="sex[]"]');
      const locations = document.querySelectorAll('select[name="location[]"]');
      const submitButton = document.getElementById('submitButton');

      names.forEach((name, index) => {
        name.addEventListener('input', checkFields);
        sexes[index].addEventListener('change', checkFields);
        locations[index].addEventListener('change', checkFields);
      });

      function checkFields() {
        let formIsValid = true;

        names.forEach((name, index) => {
          if (name.value.trim() === '' || sexes[index].value.trim() === '' || locations[index].value.trim() === '') {
            formIsValid = false;
          }
        });

        submitButton.disabled = !formIsValid;
      }
    }

    document.getElementById('submitButton').addEventListener('click', function() {
      if (validateForm()) {
        const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        confirmationModal.show();
      }
    });

    document.getElementById('confirmSubmitButton').addEventListener('click', function() {
      const notyf = new Notyf({
        duration: 5000,
        position: {
          x: 'right',
          y: 'top',
        },
        types: [{
            type: 'warning',
            background: '#FFD700',
            icon: {
              className: 'fas fa-exclamation-triangle',
              tagName: 'span',
              color: '#000'
            }
          },
          {
            type: 'danger',
            background: '#dc3545',
            icon: {
              className: 'fas fa-times-circle',
              tagName: 'span',
              color: '#fff'
            }
          },
          {
            type: 'success',
            background: '#28a745',
            icon: {
              className: 'fas fa-check-circle',
              tagName: 'span',
              color: '#fff'
            }
          }
        ]
      });

      notyf.open({
        type: 'success',
        message: 'Record submitted successfully, Thank you!'
      });

      document.getElementById('barangayForm').submit();
    });

    function validateForm() {
      const names = document.querySelectorAll('input[name="name[]"]');
      const sexes = document.querySelectorAll('select[name="sex[]"]');
      const locations = document.querySelectorAll('select[name="location[]"]');
      const notyf = new Notyf({
        duration: 5000,
        position: {
          x: 'right',
          y: 'top',
        },
        types: [{
            type: 'warning',
            background: '#FFD700',
            icon: {
              className: 'fas fa-exclamation-triangle',
              tagName: 'span',
              color: '#000'
            }
          },
          {
            type: 'danger',
            background: '#dc3545',
            icon: {
              className: 'fas fa-times-circle',
              tagName: 'span',
              color: '#fff'
            }
          },
          {
            type: 'success',
            background: '#28a745',
            icon: {
              className: 'fas fa-check-circle',
              tagName: 'span',
              color: '#fff'
            }
          }
        ]
      });

      let formIsValid = true;

      for (let i = 0; i < names.length; i++) {
        if (names[i].value.trim() === '') {
          notyf.open({
            type: 'warning',
            message: `Name is required for Attendee ${i + 1}.`
          });
          formIsValid = false;
        }

        if (sexes[i].value.trim() === '') {
          notyf.open({
            type: 'warning',
            message: `Sex is required for Attendee ${i + 1}.`
          });
          formIsValid = false;
        }

        if (locations[i].value.trim() === '') {
          notyf.open({
            type: 'warning',
            message: `Location is required for Attendee ${i + 1}.`
          });
          formIsValid = false;
        }
      }

      return formIsValid;
    }
  </script>
</body>

</html>