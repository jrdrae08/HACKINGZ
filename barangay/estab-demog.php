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

<!--estab-demog.php -->
<!DOCTYPE html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Minimalist Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
</head>

<body>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <?php echo htmlspecialchars($establishmentName); ?>
            <div class="card-body">
              <form id="attendeesForm" onsubmit="return validateForm()">
                <!-- Number of Attendees Input -->
                <div class="mb-3">
                  <label for="numAttendees" class="form-label">Number of Attendees</label>
                  <div class="input-group">
                    <input type="number" class="form-control" id="numAttendees" name="numAttendees" required>
                    <button type="button" class="btn btn-success ms-2" onclick="showAdditionalFields()">Add</button>
                  </div>
                </div>

                <!-- Hidden additional fields -->
                <div class="additional-fields" id="additionalFields">
                  <div id="fullNamePlaceholders"></div>

                  <div class="mb-3">
                    <label for="numFemale" class="form-label">Number of Females</label>
                    <input type="number" class="form-control" id="numFemale" name="numFemale" required oninput="validateNumberInput(this)">
                  </div>
                  <div class="mb-3">
                    <label for="numMale" class="form-label">Number of Males</label>
                    <input type="number" class="form-control" id="numMale" name="numMale" required oninput="validateNumberInput(this)">
                  </div>
                  <div class="mb-3">
                    <label for="thisCity" class="form-label">This City/Municipality</label>
                    <input type="number" class="form-control" id="thisCity" name="thisCity" required oninput="validateTextInput(this)">
                  </div>
                  <div class="mb-3">
                    <label for="otherCity" class="form-label">Other City/Municipality</label>
                    <input type="number" class="form-control" id="otherCity" name="otherCity" required oninput="validateTextInput(this)">
                  </div>
                  <div class="mb-3">
                    <label for="otherProvince" class="form-label">Other Province</label>
                    <input type="number" class="form-control" id="otherProvince" name="otherProvince" required oninput="validateTextInput(this)">
                  </div>
                  <div class="mb-3">
                    <label for="foreignCountry" class="form-label">Foreign Country</label>
                    <input type="number" class="form-control" id="foreignCountry" name="foreignCountry" required oninput="validateTextInput(this)">
                  </div>
                  <div class="d-grid">
                    <button type="submit" class="btn btn-success">Submit</button>
                  </div>
                </div> <!-- End of hidden fields -->
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
      function showAdditionalFields() {
        const numAttendees = document.getElementById('numAttendees').value;
        const additionalFields = document.getElementById('additionalFields');
        const fullNamePlaceholders = document.getElementById('fullNamePlaceholders');
        fullNamePlaceholders.innerHTML = ''; // Clear previous placeholders

        if (numAttendees > 0) {
          // Show the hidden fields
          additionalFields.style.display = 'block';

          // Generate full name fields based on the number of attendees
          for (let i = 0; i < numAttendees; i++) {
            const div = document.createElement('div');
            div.className = 'mb-3';
            const label = document.createElement('label');
            label.className = 'form-label';
            label.innerText = `Full Name of Attendee ${i + 1}`;
            const input = document.createElement('input');
            input.type = 'text';
            input.className = 'form-control';
            input.name = `fullName${i + 1}`;
            input.required = true;
            div.appendChild(label);
            div.appendChild(input);
            fullNamePlaceholders.appendChild(div);
          }
        } else {
          // Hide additional fields if the number of attendees is 0 or less
          additionalFields.style.display = 'none';
        }
      }

      function validateNumberInput(input) {
        input.value = input.value.replace(/[^0-9]/g, '');
      }

      function validateTextInput(input) {
        input.value = input.value.replace(/[^a-zA-Z\s]/g, '');
      }

      function validateForm() {
        const numFemale = document.getElementById('numFemale').value;
        const numMale = document.getElementById('numMale').value;

        if (!/^\d+$/.test(numFemale) || !/^\d+$/.test(numMale)) {
          alert('Number of Females and Males must be valid numbers.');
          return false;
        }

        return true;
      }
    </script>
</body>

</html>