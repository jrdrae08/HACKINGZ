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
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Minimalist Form</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
  <style>
    body {
      background-color: #f3f4f6;
      color: #333;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
      background-color: #ffffff;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      border: none;
      overflow: hidden;
    }

    .card-header {
      background-color: #1E5128;
      color: white;
      padding: 1.25rem;
      font-size: 1.25rem;
      font-weight: 600;
      text-align: center;
    }

    .card-body {
      padding: 2rem;
    }

    .form-label {
      font-size: 1rem;
      font-weight: 500;
      color: #333;
    }

    .form-control {
      background-color: #f9fafb;
      color: #333;
      border-radius: 8px;
      padding: 0.75rem;
      border: 1px solid #e0e0e0;
      transition: all 0.2s ease-in-out;
    }

    .form-control:focus {
      background-color: #ffffff;
      border-color: #1E5128;
      box-shadow: 0 0 0.25rem rgba(30, 81, 40, 0.25);
    }

    .btn-success {
      background-color: #1E5128;
      border-color: #1E5128;
      border-radius: 8px;
      padding: 0.75rem;
      font-size: 1rem;
      font-weight: 500;
      transition: background-color 0.3s ease;
    }

    .btn-success:hover {
      background-color: #4E9F3D;
      border-color: #4E9F3D;
    }

    .additional-fields {
      display: none;
      margin-top: 1.5rem;
    }

    .input-group {
      display: flex;
      align-items: center;
    }

    .input-group input {
      flex: 1;
    }

    .full-name-input {
      margin-bottom: 1rem;
    }
  </style>
</head>

<body>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <?php echo htmlspecialchars($establishmentName); ?>
          </div>
          <div class="card-body">
            <form id="attendeesForm" onsubmit="return validateForm()">
              <div class="mb-3">
                <label for="numAttendees" class="form-label">Number of Attendees</label>
                <div class="input-group">
                  <input type="number" class="form-control" id="numAttendees" name="numAttendees" required>
                  <button type="button" class="btn btn-success ms-2" onclick="showAdditionalFields()">Add</button>
                </div>
              </div>

              <div class="additional-fields" id="additionalFields">
                <div id="fullNamePlaceholders"></div>

                <div class="mb-3">
                  <label for="numFemale" class="form-label">Number of Females</label>
                  <input type="number" class="form-control" id="numFemale" name="numFemale" required>
                </div>

                <div class="mb-3">
                  <label for="numMale" class="form-label">Number of Males</label>
                  <input type="number" class="form-control" id="numMale" name="numMale" required>
                </div>

                <div class="mb-3">
                  <label for="thisCity" class="form-label">This City/Municipality</label>
                  <input type="text" class="form-control" id="thisCity" name="thisCity" required>
                </div>

                <div class="mb-3">
                  <label for="otherCity" class="form-label">Other City/Municipality</label>
                  <input type="text" class="form-control" id="otherCity" name="otherCity" required>
                </div>

                <div class="mb-3">
                  <label for="otherProvince" class="form-label">Other Province</label>
                  <input type="text" class="form-control" id="otherProvince" name="otherProvince" required>
                </div>

                <div class="mb-3">
                  <label for="foreignCountry" class="form-label">Foreign Country</label>
                  <input type="text" class="form-control" id="foreignCountry" name="foreignCountry" required>
                </div>

                <div class="d-grid mt-4">
                  <button type="submit" class="btn btn-success">Submit</button>
                </div>
              </div>
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
      fullNamePlaceholders.innerHTML = '';

      if (numAttendees > 0) {
        additionalFields.style.display = 'block';
        for (let i = 0; i < numAttendees; i++) {
          const div = document.createElement('div');
          div.className = 'full-name-input';
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
        additionalFields.style.display = 'none';
      }
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