<?php
include '../includes/db.php'; // Include your database connection

// Get the barangayId from the URL
$barangayId = isset($_GET['id']) ? $_GET['id'] : null;
$establishmentName = "Invalid barangay ID."; // Default message

if ($barangayId) {
  try {
    // Prepare and execute statement to retrieve the establishment information
    $stmt = $pdo->prepare("SELECT establishment FROM barangay_accounts WHERE barangayId = :barangay_id");
    $stmt->execute([':barangay_id' => $barangayId]);

    // Fetch the establishment data
    $barangay = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($barangay) {
      $establishmentName = htmlspecialchars($barangay['establishment']);
    } else {
      $establishmentName = "No establishment information found for this barangay.";
    }
  } catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $establishmentName = "An error occurred. Please try again later.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Majayjay Website</title>
  <!-- External CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Jaro:opsz@6..72&family=Poetsen+One&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,800">
  <link rel="stylesheet" href="../../resort/new-resort-ui.css">

  <style>
    body {
      overflow-x: hidden;
      position: relative;
      background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.5)), url('../../img/businessowner-img/majayjay falls.jpg');
      /* background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.5)), url('../../businessowner/businessmediacategory/<?php echo htmlspecialchars($business['Thumbnail']); ?>'); */
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      background-repeat: no-repeat;
    }

    .hr-1 {
      border-top: 1px solid #000;
      /* Adjust color and thickness as needed */
      width: 100%;
      /* Adjust width as needed */
    }


    .hr-2 {
      border-top: 1px solid #adb5bd;
      /* Adjust color and thickness as needed */
      width: 100%;
      /* Adjust width as needed */
    }

    .card {
      max-width: 550px;
      width: 100%;
    }
  </style>
</head>

<body>
  <main class="content">
    <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
      <div class="row d-flex justify-content-center">
        <div class=" col-12 d-flex justify-content-center">
          <form action="">
            <div class="card ">
              <div class="card-body">
                <div class="row g-2">
                  <div class="col-12 my-4 d-flex align-items-center justify-content-center">
                    <img src="../../img/general-img/majayjay-logo.webp" class="img-fluid" alt="" height="100px" width="100px">
                  </div>
                  <div class="col-l2 text-center">
                    <div class="text-center">
                      <h3 class="fw-bold">Welcome to (<?php echo htmlspecialchars($establishmentName); ?>
                        )!</h3>
                    </div>
                    <div class=" text-center" style="font-size: 15px;">
                      <p>Please fill up the form needed before proceeding to the location.</p>
                    </div>
                  </div>
                  <div class="col-12 mb-3 d-flex justify-content-center">
                    <div class="col-lg-5 col-7 me-3">
                      <div class="form-floating">
                        <input type="number" class="form-control shadow" id="floatingInput" placeholder=" " required>
                        <label for="floatingInput">Number of Attendees</label>
                      </div>
                    </div>

                    <div class="col-lg-2 col-4 d-flex justify-content-center align-items-center">
                      <button class="btn btn-success px-3">Add</button>
                    </div>
                  </div>


                  <div class="col-12 mt-4 d-flex justify-content-center">
                    <h4>Attendees' Information</h4>
                  </div>
                  <!-- additionalinfo -->
                  <div class="hr-2"></div>
                  <div class="col-12 mb-4 d-flex justify-content-center">
                    <div class="row g-2">
                      <p class="mb-0">Name of Attendee 1</p>
                      <div class="col-lg-5 col-12">
                        <input type="text" class="form-control shadow" id="exampleFormControlInput1" placeholder="ex. Juan Dela Cruz">
                      </div>
                      <div class="col-lg-7 col-md-6 col-12">
                        <div class="btn-group  mb-3">
                          <button id="sexButton" class="btn btn-light border dropdown-toggle shadow" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            Sex
                          </button>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="updateButtonText('sexButton', 'Male')">Male</a></li>
                            <li><a class="dropdown-item" href="#" onclick="updateButtonText('sexButton', 'Female')">Female</a></li>
                          </ul>
                        </div>

                        <div class="btn-group  mb-3">
                          <button id="locationButton" class="btn btn-light border dropdown-toggle shadow" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                            Location
                          </button>
                          <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="updateButtonText('locationButton', 'This City/Municipality')">This City/Municipality</a></li>
                            <li><a class="dropdown-item" href="#" onclick="updateButtonText('locationButton', 'Other City/Municipality')">Other City/Municipality</a></li>
                            <li><a class="dropdown-item" href="#" onclick="updateButtonText('locationButton', 'Other Province')">Other Province</a></li>
                            <li><a class="dropdown-item" href="#" onclick="updateButtonText('locationButton', 'Foreign Country')">Foreign Country</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-12 d-flex justify-content-center">
                    <button class="btn btn-success px-4">SUBMIT</button>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </main>


</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
<script src="../homepage/homepage.js"></script>


<script>
  function updateButtonText(buttonId, text) {
    const button = document.getElementById(buttonId);
    button.innerHTML = text;

    // Close the dropdown
    const dropdown = bootstrap.Dropdown.getInstance(button);
    dropdown.hide();
  }
</script>

</html>