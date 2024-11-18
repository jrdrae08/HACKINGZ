<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'businessowner') {
    header('Location: ../login.php');
    exit;
}
$formData = $_SESSION['form_data'] ?? [];
$errors = $_SESSION['errors'] ?? [];
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
                <div class="mb-3">
                    <h3>Manage Accommodation</h3>
                </div>
                <div class="container-fluid ">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-11">
                            <div class="card border-0 shadow">
                                <div class="card-header">
                                    <h4>Add Room</h4>
                                </div>
                                <div class="card-body">
                                    <form method="POST" action="../../backends/subadmin/save_room_info.php" enctype="multipart/form-data" onsubmit="return validateForm()">
                                        <input type="hidden" id="session-images" value='<?php echo json_encode($_SESSION['temp_images'] ?? []); ?>'>
                                        <div class="row d-flex justify-content-evenly">
                                            <h5 class="fw-bold mb-4">Room Information</h5>
                                            <div class="col-xl-5 col-lg-10 col-12">
                                                <div class="row d-flex justify-content-center align-items-center">
                                                    <div class="col-lg-5 col-md-6 col-sm-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="text" id="roomname" name="roomname" class="form-control shadow" placeholder="" required value="<?php echo htmlspecialchars($formData['roomname'] ?? ''); ?>">
                                                            <label for="roomname">Room name</label>
                                                            <span id="error-roomname" class="text-danger"><?php echo $errors['roomname'] ?? ''; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-6 col-sm-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="number" id="roomprice" name="roomprice" class="form-control shadow" placeholder="" required value="<?php echo htmlspecialchars($formData['roomprice'] ?? ''); ?>">
                                                            <label for="roomprice">Price</label>
                                                            <span id="error-roomprice" class="text-danger"><?php echo $errors['roomprice'] ?? ''; ?></span>
                                                            <span class="badge text-secondary"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-6 col-sm-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="number" id="adultmax" name="adultmax" class="form-control shadow" placeholder="" required value="<?php echo htmlspecialchars($formData['adultmax'] ?? ''); ?>">
                                                            <label for="adultmax">Adult (Max.)</label>
                                                            <span id="error-adultmax" class="text-danger"><?php echo $errors['adultmax'] ?? ''; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-5 col-md-6 col-sm-12">
                                                        <div class="form-floating mb-3">
                                                            <input type="number" id="childrenmax" name="childrenmax" class="form-control shadow" placeholder="" required value="<?php echo htmlspecialchars($formData['childrenmax'] ?? ''); ?>">
                                                            <label for="childrenmax">Children (Max.)</label>
                                                            <span id="error-childrenmax" class="text-danger"><?php echo $errors['childrenmax'] ?? ''; ?></span>
                                                        </div>
                                                    </div>
                                                    <hr>

                                                    <h5 class="fw-bold mb-3">Time Scheduling</h5>
                                                    <div class="col-lg-10">
                                                        <div class="row mb-3 d-flex justify-content-center">
                                                            <div class="col-lg-5 col-md-6 col-sm-12">
                                                                <div class="form-floating mb-3">
                                                                    <input type="time" class="form-control shadow" placeholder="">
                                                                    <label for="">Time Start</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-5 col-md-6 col-sm-12">
                                                                <div class="form-floating mb-3">
                                                                    <input type="time" class="form-control shadow" placeholder="">
                                                                    <label for="">Time End</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <!-- <div class="col-lg-10 mb-3">
                                                        <div class="form-floating">
                                                            <textarea id="roomdesc" name="roomdesc" class="form-control shadow" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px" required><?php echo htmlspecialchars($formData['roomdesc'] ?? ''); ?></textarea>
                                                            <label for="roomdesc">Room Descriptions</label>
                                                            <span id="error-roomdesc" class="text-danger"><?php echo $errors['roomdesc'] ?? ''; ?></span>
                                                            <div id="roomdesc-word-count" class="text-end text-muted"></div>
                                                        </div>
                                                    </div> -->

                                                    <!-- payment method -->
                                                    <div class="col-lg-10 col-10 text-center border bg-info-subtle rounded shadow py-2 mb-3">
                                                        <h5 class="fw-bold">Payment Options</h5>
                                                        <p>Do you want to add a down payment for this specific room?</p>
                                                        <div class="col-lg-12 d-flex justify-content-around align-items-center mb-2">
                                                            <div class="form-check form-switch form-check-reverse me-2">
                                                                <input class="form-check-input shadow" type="checkbox" id="flexSwitchCheckReverse">
                                                                <label class="form-check-label" for="flexSwitchCheckReverse">Payment Method (G-Cash)</label>
                                                            </div>
                                                            <div class="col-lg-5 d-flex justify-content-center" id="paymentField" style="display: none;">
                                                                <input type="number" class="form-control shadow" placeholder="Enter amount" disabled id="paymentAmount">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>
                                                    <!-- Hidden input field for payment number -->


                                                    <script>
                                                        document.addEventListener("DOMContentLoaded", function() {
                                                            const paymentField = document.getElementById("paymentField");
                                                            const switchCheckbox = document.getElementById("flexSwitchCheckReverse");
                                                            const paymentAmount = document.getElementById("paymentAmount");

                                                            // Add event listener for the checkbox
                                                            switchCheckbox.addEventListener("change", function() {
                                                                console.log("Checkbox is checked:", switchCheckbox.checked);

                                                                // Toggle visibility and enable/disable the input based on the checkbox state
                                                                if (switchCheckbox.checked) {
                                                                    paymentField.style.display = "block"; // Show the input field
                                                                    paymentAmount.disabled = false; // Enable the input field
                                                                } else {
                                                                    paymentField.style.display = "none"; // Hide the input field
                                                                    paymentAmount.disabled = true; // Disable the input field
                                                                }
                                                            });
                                                        });
                                                    </script>




                                                    <div class="col-lg-10 mb-3">
                                                        <h5 class="fw-bold">Facilities</h5>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="facilities1" value="Bedroom">
                                                            <label class="form-check-label">Bedroom</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="facilities2" value="Balcony">
                                                            <label class="form-check-label">Balcony</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="facilities3" value="Comfort Room">
                                                            <label class="form-check-label">Comfort Room</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="facilities4" value="Kitchen">
                                                            <label class="form-check-label">Kitchen</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-10 mb-3">
                                                        <h5 class="fw-bold">Features</h5>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="features1" value="Aircon">
                                                            <label class="form-check-label">Aircon</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="features2" value="Wi-Fi">
                                                            <label class="form-check-label">Wi-Fi</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="features3" value="Television">
                                                            <label class="form-check-label">TV</label>
                                                        </div>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="features4" value="Shower">
                                                            <label class="form-check-label">Shower</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="col-xl-6 col-lg-10 col-md-10 col-sm-12">
                                                <div class="row">
                                                    <div class="col-lg-12 d-flex align-items-center mb-3">
                                                        <i class="bi bi-plus-circle fs-3" id="add-image-icon"></i>
                                                        <span class="ms-2">Click this button to add images (maximum of 6)</span>
                                                    </div>
                                                    <?php for ($i = 1; $i <= 6; $i++): ?>
                                                        <div class="col-lg-4 col-md-4 col-sm-6 mb-3 text-center image-input-section"
                                                            style="display: <?php echo isset($images["image$i"]) ? 'block' : 'none'; ?>;">
                                                            <div class="d-flex flex-column align-items-center">
                                                                <input name="image<?php echo $i; ?>" type="file"
                                                                    id="room-image-input-<?php echo $i; ?>" style="display: none;"
                                                                    accept="image/*" onchange="uploadImage('room-image-input-<?php echo $i; ?>', 'room-image-<?php echo $i; ?>')" value="">
                                                                <label for="room-image-input-<?php echo $i; ?>" class="image-container mb-2" style="cursor: pointer;">
                                                                    <img src="<?php echo isset($images["image$i"]) ? htmlspecialchars($images["image$i"]) : '../img/general-img/upload-image.png'; ?>"
                                                                        class="rounded img-fluid shadow border" alt="Room Image"
                                                                        id="room-image-<?php echo $i; ?>" style="width: 100%; height: auto; max-width: 250px; max-height: 170px; object-fit: cover;">
                                                                </label>
                                                                <i class="bi bi-x-circle remove-image-icon"></i>
                                                            </div>
                                                        </div>
                                                    <?php endfor; ?>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" class="btn btn-success px-4 me-2" id="save-button" data-bs-toggle="modal" data-bs-target="#confirmationModal" disabled>SAVE</button>
                                            <a href="../businessowner/manage-rooms.php" class="btn btn-secondary">CANCEL</a>
                                        </div>
                                    </form>
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
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../js/businessowner.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const notyf = new Notyf({
                    duration: 30000,
                    position: {
                        x: 'right',
                        y: 'top'
                    }
                });

                <?php if (isset($_SESSION['success'])): ?>
                    console.log('Success message:', '<?php echo $_SESSION['success']; ?>');
                    notyf.success('<?php echo $_SESSION['success']; ?>');
                    <?php unset($_SESSION['success']); ?>
                <?php endif; ?>

                <?php if (isset($_SESSION['errors'])): ?>
                    <?php foreach ($errors as $error): ?>
                        console.log('Error message:', '<?php echo $error['message']; ?>');
                        notyf.error('<?php echo $error['message']; ?>');
                    <?php endforeach; ?>
                    <?php unset($_SESSION['errors']); ?>
                <?php endif; ?>

                const sessionImages = JSON.parse(document.getElementById('session-images').value);
                const imageInputSections = document.querySelectorAll('.image-input-section');
                imageInputSections.forEach((section, index) => {
                    if (sessionImages[`image${index + 1}`]) {
                        section.style.display = 'block';
                    }
                });

                document.getElementById('add-image-icon').addEventListener('click', () => {
                    const hiddenSections = Array.from(imageInputSections).filter(section => section.style.display === 'none');
                    if (hiddenSections.length > 0) {
                        hiddenSections[0].style.display = 'block';
                    }
                });

                document.querySelectorAll('.remove-image-icon').forEach((icon, index) => {
                    icon.addEventListener('click', () => {
                        const section = imageInputSections[index];
                        section.style.display = 'none';
                        section.querySelector('input[type="file"]').value = '';
                        section.querySelector('img').src = '../img/general-img/upload-image.png';
                    });
                });
            });
        </script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Check if there are errors or form data in session storage
                const errors = <?php echo json_encode($_SESSION['errors'] ?? []); ?>;
                const formData = <?php echo json_encode($_SESSION['form_data'] ?? []); ?>;

                // Function to set form values
                function setFormValues(data) {
                    for (const key in data) {
                        if (data.hasOwnProperty(key)) {
                            const element = document.getElementById(key);
                            if (element) {
                                element.value = data[key];
                            }
                        }
                    }
                }

                // Function to display error messages
                function displayErrors(errors) {
                    for (const error of errors) {
                        const field = error.field;
                        const message = error.message;
                        const errorElement = document.getElementById('error-' + field);
                        if (errorElement) {
                            errorElement.textContent = message;
                        }
                    }
                }

                // Set form values and display errors
                setFormValues(formData);
                displayErrors(errors);

                // Clear session storage after rendering the form
                <?php unset($_SESSION['errors']);
                unset($_SESSION['form_data']); ?>
            });
        </script>

        <script>
            function validateForm() {
                const imageInputs = [
                    document.getElementById('room-image-input-1'),
                    document.getElementById('room-image-input-2'),
                    document.getElementById('room-image-input-3'),
                    document.getElementById('room-image-input-4'),
                    document.getElementById('room-image-input-5'),
                    document.getElementById('room-image-input-6')
                ];

                const sessionImages = JSON.parse(document.getElementById('session-images').value);
                const isAnyImageSelected = imageInputs.some(input => input && input.files.length > 0) || Object.keys(sessionImages).length > 0;

                if (!isAnyImageSelected) {
                    const notyf = new Notyf({
                        duration: 30000,
                        position: {
                            x: 'right',
                            y: 'top'
                        }
                    });

                    notyf.error('Please upload at least one image.');
                    return false;
                }

                return true;
            }
        </script>

        <script>
            // Function to handle image preview
            function uploadImage(inputId, imgId) {
                const input = document.getElementById(inputId);
                const img = document.getElementById(imgId);

                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        img.src = e.target.result;
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Function to load images from session
            function loadImagesFromSession() {
                const sessionImages = <?php echo json_encode($_SESSION['temp_images'] ?? []); ?>;
                for (let i = 1; i <= 6; i++) {
                    const imgId = `room-image-${i}`;
                    const img = document.getElementById(imgId);
                    if (sessionImages[`image${i}`]) {
                        img.src = sessionImages[`image${i}`];
                    }
                }
            }

            // Load images on page load
            window.onload = loadImagesFromSession;
        </script>

        <!-- Confirmation Modal -->
        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmationModalLabel">Confirm Save</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to save the room details?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirmSaveBtn">Confirm</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const confirmSaveBtn = document.getElementById('confirmSaveBtn');
                const roomForm = document.querySelector('form');

                confirmSaveBtn.addEventListener('click', function() {
                    // Perform validation before form submission
                    if (validateForm()) {
                        roomForm.submit(); // Submit the form programmatically
                    }
                    // Close the modal (optional, if not automatically closed)
                    const modalElement = document.querySelector('#confirmationModal');
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    modalInstance.hide();
                });
            });
        </script>

        <script>
            //adding image and removing image
            document.addEventListener('DOMContentLoaded', function() {
                const addImageIcon = document.getElementById('add-image-icon');
                const imageInputSections = document.querySelectorAll('.image-input-section');
                const removeImageIcons = document.querySelectorAll('.remove-image-icon');

                let currentIndex = 0;

                addImageIcon.addEventListener('click', function() {
                    if (currentIndex < imageInputSections.length) {
                        imageInputSections[currentIndex].style.display = 'block';
                        currentIndex++;
                    }
                });

                removeImageIcons.forEach((icon, index) => {
                    icon.addEventListener('click', function() {
                        imageInputSections[index].style.display = 'none';
                        currentIndex--;
                    });
                });
            });
        </script>

        <script>
            //validation for form before submitting it
            document.addEventListener('DOMContentLoaded', function() {
                const saveButton = document.getElementById('save-button');
                const formFields = document.querySelectorAll('input[required], textarea[required]');
                const imageInputs = [
                    document.getElementById('room-image-input-1'),
                    document.getElementById('room-image-input-2'),
                    document.getElementById('room-image-input-3'),
                    document.getElementById('room-image-input-4'),
                    document.getElementById('room-image-input-5'),
                    document.getElementById('room-image-input-6')
                ];

                function validateForm() {
                    let allFieldsFilled = true;
                    formFields.forEach(field => {
                        if (!field.value.trim()) {
                            allFieldsFilled = false;
                        }
                    });

                    const isAnyImageSelected = imageInputs.some(input => input && input.files.length > 0);

                    if (allFieldsFilled && isAnyImageSelected) {
                        saveButton.removeAttribute('disabled');
                    } else {
                        saveButton.setAttribute('disabled', 'true');
                    }
                }

                formFields.forEach(field => {
                    field.addEventListener('input', validateForm);
                });

                imageInputs.forEach(input => {
                    input.addEventListener('change', validateForm);
                });

                validateForm(); // Initial validation check
            });
        </script>

        <script src="../wordcounter/jquery.word-and-character-counter.js"></script>
        <script>
            $(document).ready(function() {
                $('#roomdesc').counter({
                    type: 'word',
                    count: 'up',
                    goal: 50,
                    target: '#roomdesc-word-count',
                    text: true,
                    translation: 'word left max'
                });
            });
        </script>

</body>


</html>