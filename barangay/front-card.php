<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'barangay') {
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
    <title>Barangay Dashboard</title>
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
        <?php include '../barangay/includes/aside.php'; ?>
        <div class="main">
            <?php include '../barangay/includes/navbar.php'; ?>
            <main class="content px-3 py-2">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h3>Manage Webpage Content</h3>
                    </div>
                    <form action="../../backends/barangay/fallscatergory.php" method="POST" enctype="multipart/form-data">
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
                                                <input name="thumbnail-image-1" type="file" id="thumbnail-image-input-1" style="display: none;" accept="image/jpeg, image/jpg, image/png" onchange="uploadImage('thumbnail-image-input-1', 'thumbnail-image-1')" disabled>
                                                <label for="thumbnail-image-input-1" class="image-container">
                                                    <img src="../img/general-img/insert.png" class="rounded img-fluid shadow border" alt="Thumbnail Image" id="thumbnail-image-1" height="200" width="200">
                                                </label>
                                            </div>
                                            <div class="col-lg-6 col-md-8">
                                                <div class="row">
                                                    <div class="col-lg-12 mt-4">
                                                        <h5 class="fw-bold fs-6">Quotation</h5>
                                                        <div class="form-floating">
                                                            <textarea name="quotation" class="form-control shadow" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" disabled></textarea>
                                                            <label for="floatingTextarea2">Simple Persuasive Sentences</label>
                                                            <p class="note-text text-secondary ms-2">(ex. "Come and visit this beautiful place!") (Maximum of 30 words)</p>
                                                        </div>
                                                    </div>
                                                    <div class="container mt-5">
                                                        <div class="col-lg-12">
                                                            <h5 class="fw-bold fs-6">Highlights</h5>
                                                            <form id="highlightForm">
                                                                <div class="col-lg-12 d-flex">
                                                                    <div class="hstack gap-3">
                                                                        <input class="form-control me-auto shadow" type="text" placeholder="Add highlights" aria-label="Add highlights" id="highlightInput">
                                                                        <button type="button" class="btn btn-success" onclick="openAddHighlightConfirmationModal()">Add</button>
                                                                        <button id="deleteButton" class="btn btn-danger" type="button" onclick="handleDeleteClick()" disabled>Delete</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            <div class="col-lg-12 mt-3" id="highlightsContainer">
                                                                <!-- Highlights will be dynamically added here -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- Confirmation Modal -->
                                                    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="confirmationModalLabel"></h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body" id="confirmationModalBody"></div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="button" class="btn btn-primary" id="confirmationModalButton">Confirm</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Highlight Confirmation Modal -->
                                                    <div class="modal fade" id="highlightConfirmationModal" tabindex="-1" aria-labelledby="highlightConfirmationModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="highlightConfirmationModalLabel">Confirm Highlight Status</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <p id="highlightConfirmationMessage">Are you sure you want to change the status of this highlight?</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                                    <button type="button" class="btn btn-primary" id="confirmHighlightButton">Confirm</button>
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
                                            <div class="col-lg-4 col-md-6 mb-3 text-center">
                                                <p>Image 1</p>
                                                <input name="business-image-1" type="file" id="business-image-input-1" style="display: none;" accept="image/jpeg, image/jpg, image/png" onchange="uploadImage('business-image-input-1', 'business-image-1')" disabled>
                                                <label for="business-image-input-1" class="image-container">
                                                    <img src="../img/general-img/insert.png" class="rounded img-fluid shadow border" alt="Business Image 1" id="business-image-1">
                                                </label>
                                            </div>

                                            <div class="col-lg-4 col-md-6 mb-3 text-center">
                                                <p>Image 2</p>
                                                <input name="business-image-2" type="file" id="business-image-input-2" style="display: none;" accept="image/jpeg, image/jpg, image/png" onchange="uploadImage('business-image-input-2', 'business-image-2')" disabled>
                                                <label for="business-image-input-2" class="image-container">
                                                    <img src="../img/general-img/insert.png" class="rounded img-fluid shadow border" alt="Business Image 2" id="business-image-2">
                                                </label>
                                            </div>

                                            <div class="col-lg-4 col-md-6 mb-3 text-center">
                                                <p>Image 3</p>
                                                <input name="business-image-3" type="file" id="business-image-input-3" style="display: none;" accept="image/jpeg, image/jpg, image/png" onchange="uploadImage('business-image-input-3', 'business-image-3')" disabled>
                                                <label for="business-image-input-3" class="image-container">
                                                    <img src="../img/general-img/insert.png" class="rounded img-fluid shadow border" alt="Business Image 3" id="business-image-3">
                                                </label>
                                            </div>

                                            <div class="col-lg-4 col-md-6 mb-3 text-center">
                                                <p>Image 4</p>
                                                <input name="business-image-4" type="file" id="business-image-input-4" style="display: none;" accept="image/jpeg, image/jpg, image/png" onchange="uploadImage('business-image-input-4', 'business-image-4')" disabled>
                                                <label for="business-image-input-4" class="image-container">
                                                    <img src="../img/general-img/insert.png" class="rounded img-fluid shadow border" alt="Business Image 4" id="business-image-4">
                                                </label>
                                            </div>

                                            <div class="col-lg-4 col-md-6 mb-3 text-center">
                                                <p>Image 5</p>
                                                <input name="business-image-5" type="file" id="business-image-input-5" style="display: none;" accept="image/jpeg, image/jpg, image/png" onchange="uploadImage('business-image-input-5', 'business-image-5')" disabled>
                                                <label for="business-image-input-5" class="image-container">
                                                    <img src="../img/general-img/insert.png" class="rounded img-fluid shadow border" alt="Business Image 5" id="business-image-5">
                                                </label>
                                            </div>

                                            <div class="col-lg-4 col-md-6 mb-3 text-center">
                                                <p>Image 6</p>
                                                <input name="business-image-6" type="file" id="business-image-input-6" style="display: none;" accept="image/jpeg, image/jpg, image/png" onchange="uploadImage('business-image-input-6', 'business-image-6')" disabled>
                                                <label for="business-image-input-6" class="image-container">
                                                    <img src="../img/general-img/insert.png" class="rounded img-fluid shadow border" alt="Business Image 6" id="business-image-6">
                                                </label>
                                            </div>
                                        </div>
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
        fetch('../../backends/barangay/fetch_media.php')
            .then(response => response.json())
            .then(data => {
                console.log('Fetched data:', data); // Log data for debugging

                if (data.error) {
                    console.error('Error from backend:', data.error);
                    return;
                }

                // Populate the thumbnail image
                const thumbnailImg = document.getElementById('thumbnail-image-1');
                thumbnailImg.src = data.Thumbnail ? `../../barangay/fallsCategory/${data.Thumbnail}` : '../img/general-img/insert.png';

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
                    imgElement.src = data[imageKey] ? `../../barangay/fallsCategory/${data[imageKey]}` : '../img/general-img/insert.png';
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

        fetchHighlights();
    });

    // Function to convert text to Sentence Case
    function toSentenceCase(str) {
        return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
    }

    function openAddHighlightConfirmationModal() {
        let highlights = document.getElementById('highlightInput').value.trim();

        // Convert the highlight name to Sentence Case
        highlights = toSentenceCase(highlights);

        if (highlights === "") {
            notyf.error("Please enter a highlight name.");
            return;
        }

        if (highlights.length > 100) {
            notyf.error("Highlight name cannot exceed 100 characters.");
            return;
        }

        openConfirmationModal('Add Highlight', `Are you sure you want to add the highlight: "${highlights}"?`, () => {
            performAddHighlight(highlights);
        });
    }

    function performAddHighlight(highlights) {
        fetch('../../backends/barangay/add_highlights.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    highlights
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    fetchHighlights();
                    document.getElementById('highlightInput').value = ''; // Clear the input field
                    notyf.success(data.message);
                } else {
                    notyf.error(data.message);
                }
            });
    }

    function fetchHighlights() {
        fetch('../../backends/barangay/fetch_highlights.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Fetched highlights:', data); // Debugging statement
                const container = document.getElementById('highlightsContainer');
                container.innerHTML = ''; // Clear existing highlights

                if (data.status === 'success') {
                    if (data.highlights.length === 0) {
                        container.innerHTML = '<p>No highlights found.</p>';
                        return;
                    }

                    data.highlights.forEach(highlight => {
                        console.log('Highlight:', highlight); // Debugging statement
                        const div = document.createElement('div');
                        div.className = 'form-check form-check-inline';
                        div.innerHTML = `
                        <input class="form-check-input" type="checkbox" id="highlight${highlight.HighlightID}" value="${highlight.HighlightID}" ${highlight.IsActive == 1 ? 'checked' : ''} onchange="onCheckboxChange(${highlight.HighlightID}, this)">
                        <label class="form-check-label" for="highlight${highlight.HighlightID}">${highlight.HighlightName}</label>
                    `;
                        container.appendChild(div);
                    });

                    toggleDeleteButton();
                } else {
                    container.innerHTML = `<p>${data.message}</p>`;
                    notyf.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error fetching highlights:', error);
                notyf.error('Error fetching highlights');
            });
    }

    function handleDeleteClick() {
        const selectedHighlights = document.querySelectorAll('.form-check-input:checked');

        if (selectedHighlights.length === 0) {
            notyf.error('Please select at least one highlight to delete.');
            return;
        }

        openConfirmationModal('Delete Highlights', 'Are you sure you want to delete the selected highlights?', deleteSelectedHighlights);
    }

    function deleteSelectedHighlights() {
        const selectedHighlights = document.querySelectorAll('.form-check-input:checked');
        const highlightIDs = Array.from(selectedHighlights).map(checkbox => checkbox.value);

        console.log('Selected highlights for deletion:', highlightIDs); // Debugging statement

        highlightIDs.forEach(highlightID => {
            fetch('../../backends/barangay/delete_highlights.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        highlightID
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Delete response:', data); // Debugging statement
                    if (data.status === 'success') {
                        fetchHighlights();
                        notyf.success(data.message);
                    } else {
                        notyf.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error deleting highlight:', error); // Debugging statement
                    notyf.error('Error deleting highlight');
                });
        });
    }

    let currentHighlightID;
    let currentCheckedStatus;
    let targetCheckbox;

    function onCheckboxChange(highlightID, checkbox) {
        // Show the confirmation dialog
        showHighlightConfirmationDialog(highlightID, checkbox.checked, checkbox);
    }

    function showHighlightConfirmationDialog(highlightID, isChecked, checkbox) {
        currentHighlightID = highlightID;
        currentCheckedStatus = isChecked;
        targetCheckbox = checkbox;

        const confirmationMessage = isChecked ?
            'Are you sure you want to make this highlight visible?' :
            'Are you sure you want to hide this highlight?';

        document.getElementById('highlightConfirmationMessage').textContent = confirmationMessage;

        // Show the existing modal
        const highlightModal = new bootstrap.Modal(document.getElementById('highlightConfirmationModal'));
        highlightModal.show();
    }

    function updateHighlightStatus(highlightID, isChecked) {
        return fetch('../../backends/barangay/update_highlights.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    highlightID: highlightID,
                    isActive: isChecked ? 1 : 0 // Send 1 if checked, 0 if unchecked
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    notyf.success(data.message);
                    fetchHighlights(); // Refresh highlights to reflect the updated status
                    return true; // Indicate success
                } else {
                    notyf.error(data.message);
                    return false; // Indicate failure
                }
            })
            .catch(error => {
                console.error('Error updating highlight status:', error);
                return false; // Indicate failure
            });
    }

    document.getElementById('confirmHighlightButton').addEventListener('click', () => {
        updateHighlightStatus(currentHighlightID, currentCheckedStatus)
            .then(success => {
                if (success) {
                    // Close the modal if the update was successful
                    const highlightModal = bootstrap.Modal.getInstance(document.getElementById('highlightConfirmationModal'));
                    highlightModal.hide();
                }
            });
    });

    // Ensure to handle the case when the modal is closed without confirmation
    document.getElementById('highlightConfirmationModal').addEventListener('hidden.bs.modal', () => {
        // Revert the checkbox state if the modal is closed without confirmation
        if (targetCheckbox) {
            targetCheckbox.checked = !currentCheckedStatus;
        }
    });

    function toggleDeleteButton() {
        const selectedHighlights = document.querySelectorAll('.form-check-input:checked');
        const deleteButton = document.getElementById('deleteButton');
        deleteButton.disabled = selectedHighlights.length === 0;
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