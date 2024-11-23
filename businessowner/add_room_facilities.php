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
                        <button id="addFeatureButton" class="btn btn-primary" type="button" onclick="showFeatureConfirmationModal()"><i class="bi bi-plus"></i> Add</button>
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

  <!-- Confirmation Modal For Adding Facilities -->

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

  <!-- Closing Adding Facilities -->


  <!-- Confirmation Modal for Adding Feature -->
  <div class="modal fade" id="confirmAddFeatureModal" tabindex="-1" aria-labelledby="confirmAddFeatureModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmAddFeatureModalLabel">Confirm Add Feature</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to add the feature "<span id="featureNameToAdd"></span>"?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="confirmAddFeature()">Confirm</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal for Feature -->
  <div class="modal fade" id="confirmDeleteFeatureModal" tabindex="-1" aria-labelledby="confirmDeleteFeatureModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="confirmDeleteFeatureModalLabel">Confirm Delete Feature</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this feature?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" onclick="confirmDeleteFeature()">Delete</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Closing Adding Features -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="../js/businessowner.js"></script>

  <!-- Adding facilities -->
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

      function fetchFacilities() {
        fetch('../../backends/subadmin/fetch_facilities.php')
          .then(response => response.json())
          .then(data => {
            if (data.status === 'success') {
              data.facilities.forEach(facility => {
                addFacilityToTable(facility.FacilityID, facility.FacilityName);
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
              addFacilityToTable(data.facilityID, facilityName);
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

      function addFacilityToTable(facilityID, facilityName) {
        const facilityTableBody = document.getElementById('facilityTableBody');
        const newRow = document.createElement('tr');
        newRow.id = `facilityRow${facilityID}`;
        newRow.innerHTML = `
      <td scope="row">${facilityName}</td>
      <td>
        <div class="d-flex align-items-center">
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

      fetchFacilities();
      window.showConfirmationModal = showConfirmationModal;
      window.confirmAddFacility = confirmAddFacility;
      window.showDeleteConfirmationModal = showDeleteConfirmationModal;
      window.confirmDeleteFacility = confirmDeleteFacility;
    });
  </script>

  <!-- Adding features -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const notyf = new Notyf({
        duration: 3000, // Adjust the duration as needed
        position: {
          x: 'right',
          y: 'top'
        }
      });

      let featureToDelete = null;

      function fetchFeatures() {
        fetch('../../backends/subadmin/fetch_roomfeatures.php')
          .then(response => response.json())
          .then(data => {
            if (data.status === 'success') {
              data.features.forEach(feature => {
                addFeatureToTable(feature.FeatureID, feature.FeatureName);
              });
            } else {
              notyf.error(data.message);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            notyf.error('An error occurred while fetching features');
          });
      }

      function showFeatureConfirmationModal() {
        const featureNameInput = document.getElementById('featureName');
        const featureName = featureNameInput.value.trim();

        // Validate the feature name before showing the modal
        if (!featureName) {
          notyf.error('Feature name cannot be empty');
          return;
        }

        // Set the feature name in the modal text
        document.getElementById('featureNameToAdd').textContent = featureName;

        // Show the confirmation modal
        const confirmModal = new bootstrap.Modal(document.getElementById('confirmAddFeatureModal'));
        confirmModal.show();
      }

      function confirmAddFeature() {
        const featureNameInput = document.getElementById('featureName');
        const featureName = featureNameInput.value.trim();

        fetch('../../backends/subadmin/add_roomfeature.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              featureName: featureName
            })
          })
          .then(response => response.json())
          .then(data => {
            // Hide the modal before showing the notification
            const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmAddFeatureModal'));
            confirmModal.hide();

            if (data.status === 'success') {
              notyf.success('Feature added successfully');
              featureNameInput.value = ''; // Clear the input field
              addFeatureToTable(data.featureID, featureName);
            } else {
              notyf.error(data.message);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            // Hide the modal before showing the error notification
            const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmAddFeatureModal'));
            confirmModal.hide();
            notyf.error('An error occurred while adding the feature');
          });
      }

      function addFeatureToTable(featureID, featureName) {
        const featureTableBody = document.getElementById('featureTableBody');
        const newRow = document.createElement('tr');
        newRow.id = `featureRow${featureID}`;
        newRow.innerHTML = `
        <td scope="row">${featureName}</td>
        <td>
          <div class="d-flex align-items-center">
            <button class="btn btn-danger" type="button" onclick="showDeleteFeatureConfirmationModal(${featureID})"><i class="bi bi-x"></i></button>
          </div>
        </td>
      `;
        featureTableBody.appendChild(newRow);
      }

      function showDeleteFeatureConfirmationModal(featureID) {
        featureToDelete = featureID;
        const confirmModal = new bootstrap.Modal(document.getElementById('confirmDeleteFeatureModal'));
        confirmModal.show();
      }

      function confirmDeleteFeature() {
        fetch('../../backends/subadmin/delete_roomfeature.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify({
              featureID: featureToDelete
            })
          })
          .then(response => response.json())
          .then(data => {
            // Hide the modal before showing the notification
            const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteFeatureModal'));
            confirmModal.hide();

            if (data.status === 'success') {
              notyf.success('Feature deleted successfully');
              removeFeatureFromTable(featureToDelete);
            } else {
              notyf.error(data.message);
            }
          })
          .catch(error => {
            console.error('Error:', error);
            // Hide the modal before showing the error notification
            const confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteFeatureModal'));
            confirmModal.hide();
            notyf.error('An error occurred while deleting the feature');
          });
      }

      function removeFeatureFromTable(featureID) {
        const featureRow = document.getElementById(`featureRow${featureID}`);
        if (featureRow) {
          featureRow.remove();
        }
      }

      fetchFeatures();
      window.showFeatureConfirmationModal = showFeatureConfirmationModal;
      window.confirmAddFeature = confirmAddFeature;
      window.showDeleteFeatureConfirmationModal = showDeleteFeatureConfirmationModal;
      window.confirmDeleteFeature = confirmDeleteFeature;
    });
  </script>

</body>

</html>