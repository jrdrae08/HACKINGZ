<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'businessowner') {
  header('Location: ../login.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sub-admin Dashboard</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <!-- Notyf connection -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <link rel="stylesheet" href="../css/businessowner.css">
</head>

<body>
  <div class="wrapper">

    <?php include '../businessowner/includes/aside.php'; ?>

    <div class="main">

      <?php include '../businessowner/includes/navbar.php'; ?>

      <main class="content px-3 py-2">
        <div class="container-fluid">
          <h3>Add Facilities and Features</h3>
          <div class="row mt-4 justify-content-center">
            <div class="col-lg-5">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title fw-bold"> Room Facilities</h4>
                  <div class="form-group mt-3 d-flex justify-content-center align-items-center">
                    <div class="row g-3 mx-0">
                      <div class="col-lg-8 col-md-6">
                        <input type="text" class="form-control shadow" placeholder="Enter facility name" id="facilityName">
                      </div>
                      <div class="col-lg-4 col-md-6">
                        <button id="addFacilityButton" class="btn btn-primary " type="button" onclick="showConfirmationModal()"><i class="bi bi-plus"></i> Add</button>
                      </div>
                    </div>
                  </div>

                  <div class="card shadow mx-2 mt-5">
                    <div class="card-body">
                      <h4 class="card-title fw-bold">Facility Lists</h4>
                      <div id="facilitiesContainer" class="mb-4">
                        <div class="facility-lists">
                          <div class="facility-items">
                            <table class="table align-items-center">
                              <thead>
                                <tr>
                                  <th scope="col">Facility Names</th>
                                  <th scope="col">Action</th>
                                </tr>
                              </thead>
                              <tbody id="facilityTableBody">
                                <!-- Dynamically added facilities will be displayed here -->
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-lg-5">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title fw-bold">Room Features</h4>
                  <div class="form-group mt-3 d-flex justify-content-center align-items-center">
                    <div class="row g-3 mx-0">
                      <div class="col-lg-8 col-md-6">
                        <input type="text" class="form-control shadow" placeholder="Enter feature name" id="featureName">
                      </div>
                      <div class="col-lg-4 col-md-6">
                        <button id="addFeatureButton" class="btn btn-primary " type="button" onclick="addFeature()"><i class="bi bi-plus"></i> Add</button>
                      </div>
                    </div>
                  </div>

                  <div class="card shadow mx-2 mt-5">
                    <div class="card-body">
                      <h4 class="card-title fw-bold">Feature Lists</h4>
                      <div id="featuresContainer" class="mb-4">
                        <!-- Dynamically added features will be displayed here -->
                        <div class="feature-lists">
                          <div class="feature-items">
                            <table class="table align-items-center">
                              <thead>
                                <tr>
                                  <th scope="col">Feature Names</th>
                                  <th scope="col">Action</th>
                                </tr>
                              </thead>
                              <tbody id="featureTableBody">
                                <!-- Dynamically added features will be displayed here -->
                              </tbody>
                            </table>
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
      </main>

      <a href="#" class="theme-toggle">
        <i class="fa-regular fa-sun"></i>
        <i class="fa-regular fa-moon"></i>
      </a>
      <footer class="footer">
        <?php include '../businessowner/includes/footer.php'; ?>
      </footer>
    </div>
  </div>

  <!-- Confirmation Modal -->
  <div class="modal fade" id="confirmAddFacilityModal" tabindex="-1" aria-labelledby="confirmAddFacilityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmAddFacilityModalLabel">Confirm Add Facility</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to add the facility "<span id="facilityNameToAdd"></span>"?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="confirmAddFacility()">Confirm</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="confirmDeleteFacilityModal" tabindex="-1" aria-labelledby="confirmDeleteFacilityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmDeleteFacilityModalLabel">Confirm Delete Facility</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this facility?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" onclick="confirmDeleteFacility()">Delete</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Toggle Confirmation Modal -->
  <div class="modal fade" id="confirmToggleFacilityModal" tabindex="-1" aria-labelledby="confirmToggleFacilityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmToggleFacilityModalLabel">Confirm Toggle Facility</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to change the status of this facility?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="confirmToggleFacility()">Confirm</button>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../js/businessowner.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const notyf = new Notyf({
        duration: 3000, // Adjust the duration as needed
        position: {
          x: 'right',
          y: 'top'
        }
      });

      let facilityToDelete = null;
      let facilityToToggle = null;
      let previousToggleState = null;

      function fetchFacilities() {
        fetch('../../backends/subadmin/fetch_facilities.php')
          .then(response => response.json())
          .then(data => {
            if (data.status === 'success') {
              data.facilities.forEach(facility => {
                addFacilityToTable(facility.FacilityID, facility.FacilityName, facility.IsEnable);
              });
            } else {
              notyf.error(data.message);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            notyf.error('An error occurred while fetching facilities');
          });
      }

      function showConfirmationModal() {
        const facilityNameInput = document.getElementById('facilityName');
        const facilityName = facilityNameInput.value.trim();

        // Validate the facility name before showing the modal
        if (!facilityName) {
          notyf.error('Facility name cannot be empty');
          return;
        }

        // Set the facility name in the modal text
        document.getElementById('facilityNameToAdd').textContent = facilityName;

        // Show the confirmation modal
        const confirmModal = new bootstrap.Modal(document.getElementById('confirmAddFacilityModal'));
        confirmModal.show();
      }

      function confirmAddFacility() {
        const facilityNameInput = document.getElementById('facilityName');
        const facilityName = facilityNameInput.value.trim();

        fetch('../../backends/subadmin/add_facility.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              facilityName: facilityName
            })
          })
          .then(response => response.json())
          .then(data => {
            // Hide the modal before showing the notification
            const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmAddFacilityModal'));
            confirmModal.hide();

            if (data.status === 'success') {
              notyf.success('Facility added successfully');
              facilityNameInput.value = ''; // Clear the input field
              addFacilityToTable(data.facilityID, facilityName, 0);
            } else {
              notyf.error(data.message);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            // Hide the modal before showing the error notification
            const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmAddFacilityModal'));
            confirmModal.hide();
            notyf.error('An error occurred while adding the facility');
          });
      }

      function addFacilityToTable(facilityID, facilityName, isEnable) {
        const facilityTableBody = document.getElementById('facilityTableBody');
        const newRow = document.createElement('tr');
        newRow.id = `facilityRow${facilityID}`;
        newRow.innerHTML = `
          <td scope="row">${facilityName}</td>
          <td>
            <div class="d-flex align-items-center">
              <div class="form-check form-switch me-2">
                <input class="form-check-input toggle-switch-lg" type="checkbox" id="facilityToggle${facilityID}" ${isEnable ? 'checked' : ''} onclick="showToggleConfirmationModal(${facilityID}, this)">
                <label class="form-check-label" for="facilityToggle${facilityID}">Enable</label>
              </div>
              <button class="btn btn-danger" type="button" onclick="showDeleteConfirmationModal(${facilityID})"><i class="bi bi-x"></i></button>
            </div>
          </td>
        `;
        facilityTableBody.appendChild(newRow);
      }

      function showDeleteConfirmationModal(facilityID) {
        facilityToDelete = facilityID;
        const confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteFacilityModal'));
        confirmModal.show();
      }

      function confirmDeleteFacility() {
        fetch('../../backends/subadmin/delete_facility.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              facilityID: facilityToDelete
            })
          })
          .then(response => response.json())
          .then(data => {
            // Hide the modal before showing the notification
            const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteFacilityModal'));
            confirmModal.hide();

            if (data.status === 'success') {
              notyf.success('Facility deleted successfully');
              removeFacilityFromTable(facilityToDelete);
            } else {
              notyf.error(data.message);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            // Hide the modal before showing the error notification
            const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteFacilityModal'));
            confirmModal.hide();
            notyf.error('An error occurred while deleting the facility');
          });
      }

      function removeFacilityFromTable(facilityID) {
        const facilityRow = document.getElementById(`facilityRow${facilityID}`);
        if (facilityRow) {
          facilityRow.remove();
        }
      }

      function showToggleConfirmationModal(facilityID, toggleElement) {
        facilityToToggle = facilityID;
        previousToggleState = toggleElement.checked;
        const confirmModal = new bootstrap.Modal(document.getElementById('confirmToggleFacilityModal'));
        confirmModal.show();
      }

      function confirmToggleFacility() {
        const toggleElement = document.getElementById(`facilityToggle${facilityToToggle}`);
        const isEnable = toggleElement.checked ? 1 : 0;

        fetch('../../backends/subadmin/update_facility_status.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              facilityID: facilityToToggle,
              isEnable: isEnable
            })
          })
          .then(response => response.json())
          .then(data => {
            // Hide the modal before showing the notification
            const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmToggleFacilityModal'));
            confirmModal.hide();

            if (data.status === 'success') {
              notyf.success('Facility status updated successfully');
            } else {
              notyf.error(data.message);
              toggleElement.checked = !isEnable; // Revert the toggle state
            }
          })
          .catch(error => {
            console.error('Error:', error);
            // Hide the modal before showing the error notification
            const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmToggleFacilityModal'));
            confirmModal.hide();
            notyf.error('An error occurred while updating the facility status');
            toggleElement.checked = !isEnable; // Revert the toggle state
          });
      }

      fetchFacilities();
      window.showConfirmationModal = showConfirmationModal;
      window.confirmAddFacility = confirmAddFacility;
      window.showDeleteConfirmationModal = showDeleteConfirmationModal;
      window.confirmDeleteFacility = confirmDeleteFacility;
      window.showToggleConfirmationModal = showToggleConfirmationModal;
      window.confirmToggleFacility = confirmToggleFacility;
    });
  </script>
</body>

</html>