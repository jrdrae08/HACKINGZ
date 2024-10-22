<!DOCTYPE html>

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
      background-color: #f3f4f6;
      border-radius: 12px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      border: none;
    }

    .card-header {
      background-color: #1E5128;
      color: white;
      border-top-left-radius: 12px;
      border-top-right-radius: 12px;
      padding: 1rem;
      font-size: 1.25rem;
      font-weight: 500;
      text-align: center;
    }

    .card-body {
      padding: 2rem;
    }

    .form-label {
      font-size: 0.95rem;
      font-weight: 500;
      color: #333;
      /* Set label color to dark gray for visibility */
    }

    .form-control {
      background-color: #ffffff;
      /* Set default background color to white */
      color: #333;
      /* Set text color to dark gray for input */
      border-radius: 8px;
      padding: 0.75rem;
      border: 1px solid #e0e0e0;
    }

    .form-control:focus {
      background-color: #ffffff;
      /* Keep the background white on focus */
      border-color: #1E5128;
      /* Change border color on focus */
      box-shadow: 0 0 0.25rem rgba(30, 81, 40, 0.25);
      /* Optional: add a shadow on focus */
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

    .mb-3 {
      margin-bottom: 1.5rem;
    }

    .d-grid {
      margin-top: 2rem;
    }

    /* Placeholder for dynamically added fields */
    #fullNamePlaceholders .form-control {
      margin-bottom: 1rem;
    }

    .input-group {
      display: flex;
      align-items: center;
    }

    .input-group input {
      flex: 1;
    }

    /* Hide form fields initially */
    .additional-fields {
      display: none;
    }

    input[type="number"].form-control {
      background-color: #ffffff !important;
      /* Set default background color for number inputs */
      color: #333;
      /* Set text color to dark gray for number inputs */
    }
  </style>
</head>

<body>
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            Get the Barangay Establisment 
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