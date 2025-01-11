<?php
session_start();
$formData = $_SESSION['form_data'] ?? [];
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

    <!-- Notyf CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">
    <link rel="stylesheet" href="../css/businessowner.css">

    <style>
        .image-container {
            position: relative;
            width: 100%;
            padding-bottom: 100%;
            /* Maintain aspect ratio */
            overflow: hidden;
        }

        .image-container img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include '../businessowner/includes/aside.php'; ?>
        <div class="main">
            <?php include '../businessowner/includes/navbar.php'; ?>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h3>Manage Webpage Content</h3>
                    </div>
                    <form action="../../backends/subadmin/businessmediacategory.php" method="POST" enctype="multipart/form-data">
                        <div class="row d-flex justify-content-center align-items-center">

                            <!-- 
        =======================================================
                          Front Card Contents
        =======================================================
        -->
                            <div class="col-lg-9 col-md-10 col-sm-12">
                                <div class="card shadow">
                                    <div class="card-header d-flex justify-content-between">
                                        <h5 class="card-title">Front Card Content</h5>
                                        <button type="button" class="btn btn-warning shadow px-3" id="editButton">Edit</button>
                                    </div>
                                    <div class="card-body">
                                        <p class="note-text">This content will appear in the Destination Category section of the website.</p>
                                        <div class="row m-4 d-flex justify-content-evenly align-items-center">
                                            <div class="col-lg-4 col-md-6 col-sm-8 text-center">
                                                <p>Thumbnail Image (2x2)</p>
                                                <input name="thumbnail-image-1" type="file" id="thumbnail-image-input-1" style="display: none;" accept="image/jpeg, image/jpg, image/png, image/webp" onchange="uploadImage('thumbnail-image-input-1', 'thumbnail-image-1')">
                                                <label for="thumbnail-image-input-1" class="image-container">
                                                    <img src="<?php echo isset($formData['thumbnail-image-1']) ? '../../businessowner/businessmediacategory/tempUpload/' . $formData['thumbnail-image-1'] : '../img/general-img/insert.png'; ?>" class="rounded img-fluid shadow border" alt="Thumbnail Image" id="thumbnail-image-1" height="200" width="200">
                                                </label>
                                            </div>
                                            <div class="col-lg-6 col-md-8">
                                                <div class="row">
                                                    <div class="col-lg-12 mt-4">
                                                        <h5 class="fw-bold fs-6">Quotation</h5>
                                                        <div class="form-floating">
                                                            <textarea name="quotation" class="form-control shadow" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" required><?php echo isset($formData['quotation']) ? htmlspecialchars($formData['quotation']) : ''; ?></textarea>
                                                            <label for="floatingTextarea2">Simple Persuasive Sentences</label>
                                                            <p class="note-text text-secondary ms-2">(ex. "Come and visit this beautiful place!") <span id="quotation-word-count" class="text-end text-muted"></span></p>
                                                        </div>
                                                    </div>
                                                    <div class="container mt-5">
                                                        <div class="col-lg-12">
                                                            <h5 class="fw-bold fs-6">Features</h5>
                                                            <form id="featureForm">
                                                                <div class="col-lg-12 d-flex">
                                                                    <div class="hstack gap-3">
                                                                        <input class="form-control me-auto shadow" type="text" placeholder="Add features" aria-label="Add features" id="featureInput">
                                                                        <button type="button" class="btn btn-success" onclick="openAddConfirmationModal()">Add</button>
                                                                        <button id="deleteButton" class="btn btn-danger" type="button" onclick="handleDeleteClick()" disabled>Delete</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <div class="col-lg-12 mt-3" id="featuresContainer">
                                                                <!-- Features will be dynamically added here -->
                                                            </div>
                                                        </div>
                                                    </div
                                                        <!-- Existing confirmation modal -->
                                                    <div id="featureConfirmationModal" class="modal fade" tabindex="-1" aria-labelledby="featureConfirmationModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="featureConfirmationModalLabel">Confirm Feature Status</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p id="featureConfirmationMessage">Are you sure you want to change the status of this feature?</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="button" class="btn btn-primary" id="confirmFeatureButton">Confirm</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <!-- Reusable Confirmation Modal -->
                                                    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body" id="confirmationModalBody">
                                                                    <!-- The action-specific message will be injected here -->
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="button" class="btn btn-primary" id="confirmationModalButton">Confirm</button>
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

                            <!-- 
        =======================================================
                        Business Images Contents 
        =======================================================
        -->
                            <div class="col-lg-9 col-md-10 col-sm-12">
                                <div class="card shadow">
                                    <div class="card-header d-flex justify-content-between">
                                        <h5 class="card-title">Business Images</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="note-text">These images will appear when they visit your page.</p>
                                        <div class="row m-4">
                                            <?php for ($i = 1; $i <= 6; $i++): ?>
                                                <div class="col-lg-4 col-md-6 mb-3 text-center">
                                                    <p>Image <?php echo $i; ?></p>
                                                    <input name="business-image-<?php echo $i; ?>" type="file" id="business-image-input-<?php echo $i; ?>" style="display: none;" accept="image/jpeg, image/jpg, image/png, image/webp" onchange="uploadImage('business-image-input-<?php echo $i; ?>', 'business-image-<?php echo $i; ?>')">
                                                    <label for="business-image-input-<?php echo $i; ?>" class="image-container">
                                                        <img src="<?php echo isset($formData['business-image-' . $i]) ? '../../businessowner/businessmediacategory/tempUpload/' . $formData['business-image-' . $i] : '../img/general-img/insert.png'; ?>" class="rounded img-fluid shadow border" alt="Business Image <?php echo $i; ?>" id="business-image-<?php echo $i; ?>">
                                                    </label>
                                                </div>
                                            <?php endfor; ?>
                                            <div class="col-lg-12 hstack mt-3">
                                                <button type="submit" class="btn btn-success me-2 ms-auto" disabled>Save Changes</button>
                                                <button type="reset" class="btn btn-secondary" disabled>Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </form>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Notyf JS -->
        <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
        <script src="../js/businessowner.js"></script>
</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch media data from the backend
        fetch('../../backends/subadmin/fetch_media.php')
            .then(response => response.json())
            .then(data => {
                console.log('Fetched data:', data); // Log data for debugging

                if (data.error) {
                    console.error('Error from backend:', data.error);
                    return;
                }

                // Populate the thumbnail image
                const thumbnailImg = document.getElementById('thumbnail-image-1');
                thumbnailImg.src = data.Thumbnail ? `../../businessowner/businessmediacategory/${data.Thumbnail}` : '../img/general-img/insert.png';

                // Populate the quotation
                const textarea = document.getElementById('floatingTextarea2');
                textarea.value = data.Quotation || '';

                // Populate business images
                const imageFields = [
                    'business-image-1',
                    'business-image-2',
                    'business-image-3',
                    'business-image-4',
                    'business-image-5',
                    'business-image-6'
                ];

                imageFields.forEach((field, index) => {
                    const imgElement = document.getElementById(field);
                    const imageKey = `Image${index + 1}`;
                    imgElement.src = data[imageKey] ? `../../businessowner/businessmediacategory/${data[imageKey]}` : '../img/general-img/insert.png';
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to show the confirmation modal with dynamic content
        function showConfirmationModal(actionType) {
            let modalBody = '';
            let confirmButtonText = 'Confirm';
            let confirmButtonAction = null;

            switch (actionType) {
                case 'edit':
                    modalBody = 'Are you sure you want to enable editing?';
                    confirmButtonAction = () => {
                        // Enable form fields
                        setFormDisabled(false);
                        // Disable the "Edit" button itself to prevent re-click
                        document.querySelector('.btn-warning').setAttribute('disabled', true);
                        // Enable the "Save Changes" and "Cancel" buttons
                        document.querySelector('button[type="submit"]').disabled = false;
                        document.querySelector('button[type="reset"]').disabled = false;
                    };
                    break;

                case 'saveChanges':
                    modalBody = 'Are you sure you want to save the changes?';
                    confirmButtonText = 'Save';
                    confirmButtonAction = () => {
                        // Submit the form
                        document.querySelector('form').submit();
                    };
                    break;

                case 'delete':
                    modalBody = 'Are you sure you want to delete this item?';
                    confirmButtonAction = () => {
                        // Handle delete action
                    };
                    break;

                default:
                    modalBody = 'Are you sure you want to perform this action?';
                    confirmButtonAction = () => {
                        // Default action or no action
                    };
                    break;
            }

            // Set modal body text and button action
            document.getElementById('confirmationModalBody').textContent = modalBody;
            const confirmButton = document.getElementById('confirmationModalButton');
            confirmButton.textContent = confirmButtonText;
            confirmButton.onclick = function() {
                if (confirmButtonAction) {
                    confirmButtonAction();
                }
                // Hide the modal after action is taken
                const myModal = bootstrap.Modal.getInstance(document.getElementById('confirmationModal'));
                if (myModal) {
                    myModal.hide();
                }
            };

            // Show the modal
            const myModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            myModal.show();
        }

        // Event listener for "Save Changes" button
        document.querySelector('button[type="submit"]').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent default form submission
            showConfirmationModal('saveChanges'); // Show save changes confirmation modal
        });

        // Event listener for "Edit" button
        document.getElementById('editButton').addEventListener('click', function() {
            showConfirmationModal('edit'); // Show edit confirmation modal
        });

        // Function to enable or disable form fields
        function setFormDisabled(disabled) {
            const formElements = document.querySelectorAll('input, textarea, select');
            formElements.forEach(element => {
                element.disabled = disabled;
            });
        }
    });
</script>






<script>
    // Initialize Notyf
    const notyf = new Notyf({
        duration: 30000,
        position: {
            x: 'right', // `left` or `right`
            y: 'top' // `top` or `bottom`
        }
    });
    document.addEventListener('DOMContentLoaded', (event) => {
        <?php if (isset($_SESSION['success'])): ?>
            notyf.success('<?php echo $_SESSION['success']; ?>');
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            notyf.error('<?php echo $_SESSION['error']; ?>');
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>
    });

    document.addEventListener('DOMContentLoaded', (event) => {
        fetchFeatures();
    });

    // Function to convert text to Sentence Case
    function toSentenceCase(str) {
        return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
    }

    function openAddConfirmationModal() {
        let featureName = document.getElementById('featureInput').value.trim();

        // Convert the feature name to Sentence Case
        featureName = toSentenceCase(featureName);

        if (featureName === "") {
            notyf.error("Please enter a feature name.");
            return;
        }

        if (featureName.length > 100) {
            notyf.error("Feature name cannot exceed 100 characters.");
            return;
        }

        openConfirmationModal('Add Feature', `Are you sure you want to add the feature: "${featureName}"?`, () => {
            performAddFeature(featureName);
        });
    }


    function performAddFeature(featureName) {
        fetch('../../backends/subadmin/add_feature.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    featureName
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    fetchFeatures();
                    document.getElementById('featureInput').value = ''; // Clear the input field
                    notyf.success(data.message);
                } else {
                    notyf.error(data.message);
                }
            });
    }

    function handleDeleteClick() {
        const selectedFeatures = document.querySelectorAll('.form-check-input:checked');

        if (selectedFeatures.length === 0) {
            notyf.error('Please select at least one feature to delete.');
            return;
        }

        openConfirmationModal('Delete Features', 'Are you sure you want to delete the selected features?', deleteSelectedFeatures);
    }

    function deleteSelectedFeatures() {
        const selectedFeatures = document.querySelectorAll('.form-check-input:checked');
        const featureIDs = Array.from(selectedFeatures).map(checkbox => checkbox.value);

        featureIDs.forEach(featureID => {
            fetch('../../backends/subadmin/delete_feature.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        featureID
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        fetchFeatures();
                        notyf.success(data.message);
                    } else {
                        notyf.error(data.message);
                    }
                });
        });
    }

    let currentFeatureID;
    let currentCheckedStatus;
    let targetCheckbox;

    document.addEventListener('DOMContentLoaded', (event) => {
        fetchFeatures();
    });

    function fetchFeatures() {
        fetch('../../backends/subadmin/fetch_features.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(features => {
                const featuresContainer = document.getElementById('featuresContainer');
                featuresContainer.innerHTML = '';

                if (features.length === 0) {
                    featuresContainer.innerHTML = '<p>No features found.</p>';
                    return;
                }

                features.forEach(feature => {
                    const featureDiv = document.createElement('div');
                    featureDiv.className = 'form-check form-check-inline';
                    featureDiv.innerHTML = `
                <input class="form-check-input" type="checkbox" id="feature${feature.FeatureID}" value="${feature.FeatureID}" ${feature.IsActive == 1 ? 'checked' : ''} onchange="onCheckboxChange(${feature.FeatureID}, this)">
                <label class="form-check-label" for="feature${feature.FeatureID}">${feature.FeatureName}</label>
            `;
                    featuresContainer.appendChild(featureDiv);
                });

                toggleDeleteButton();
            })
            .catch(error => {
                console.error('Error fetching features:', error);
            });
    }

    function onCheckboxChange(featureID, checkbox) {
        // Show the confirmation dialog
        showFeatureConfirmationDialog(featureID, checkbox.checked, checkbox);
    }

    function showFeatureConfirmationDialog(featureID, isChecked, checkbox) {
        currentFeatureID = featureID;
        currentCheckedStatus = isChecked;
        targetCheckbox = checkbox;

        const confirmationMessage = isChecked ?
            'Are you sure you want to make this feature visible?' :
            'Are you sure you want to hide this feature?';

        document.getElementById('featureConfirmationMessage').textContent = confirmationMessage;

        // Show the existing modal
        const featureModal = new bootstrap.Modal(document.getElementById('featureConfirmationModal'));
        featureModal.show();
    }

    function updateFeatureStatus(featureID, isChecked) {
        return fetch('../../backends/subadmin/update_features_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    featureID: featureID,
                    isActive: isChecked ? 1 : 0 // Send 1 if checked, 0 if unchecked
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    notyf.success(data.message);
                    fetchFeatures(); // Refresh features to reflect the updated status
                    return true; // Indicate success
                } else {
                    notyf.error(data.message);
                    return false; // Indicate failure
                }
            })
            .catch(error => {
                console.error('Error updating feature status:', error);
                return false; // Indicate failure
            });
    }

    document.getElementById('confirmFeatureButton').addEventListener('click', () => {
        updateFeatureStatus(currentFeatureID, currentCheckedStatus)
            .then(success => {
                if (success) {
                    // Close the modal if the update was successful
                    const featureModal = bootstrap.Modal.getInstance(document.getElementById('featureConfirmationModal'));
                    featureModal.hide();
                }
            });
    });

    // Ensure to handle the case when the modal is closed without confirmation
    document.getElementById('featureConfirmationModal').addEventListener('hidden.bs.modal', () => {
        // Revert the checkbox state if the modal is closed without confirmation
        if (targetCheckbox) {
            targetCheckbox.checked = !currentCheckedStatus;
        }
    });

    function toggleDeleteButton() {
        const selectedFeatures = document.querySelectorAll('.form-check-input:checked');
        const deleteButton = document.getElementById('deleteButton');
        deleteButton.disabled = selectedFeatures.length === 0;
    }

    function openConfirmationModal(title, message, onConfirm) {
        const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        document.getElementById('confirmationModalLabel').innerText = title;
        document.getElementById('confirmationModalBody').innerText = message;

        const confirmationButton = document.getElementById('confirmationModalButton');
        confirmationButton.onclick = function() {
            onConfirm();
            confirmationModal.hide();
        };

        confirmationModal.show();
    }
</script>

<script src="../wordcounter/jquery.word-and-character-counter.js"></script>

<script>
    $(document).ready(function() {
        $('#floatingTextarea2').counter({
            type: 'word',
            count: 'up',
            goal: 30,
            target: '#quotation-word-count',
            text: true,
            translation: 'word left max',
            onGoal: function() {
                $('#floatingTextarea2').on('keydown', function(event) {
                    const words = $(this).val().split(/\s+/).filter(word => word.length > 0);
                    if (words.length >= 30 && event.key !== 'Backspace' && event.key !== 'Delete') {
                        event.preventDefault();
                    }
                });
            },
            onCountChange: function(currentCount) {
                if (currentCount < 30) {
                    $('#floatingTextarea2').off('keydown');
                }
            }
        });
    });
</script>
<script>
    function uploadImage(inputId, imageId) {
        const input = document.getElementById(inputId);
        const image = document.getElementById(imageId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                image.src = e.target.result;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</html>