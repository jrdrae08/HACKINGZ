<?php
include "../backends/admin/fetch_business_types.php";
session_start()
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" href="../css/registration.css">

    <style>
        .progress-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .progress-step {
            width: 20px;
            height: 20px;
            background-color: #d3d3d3;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 12px;
            color: #fff;
        }

        .progress-step-active {
            background-color: #28a745;
        }

        .progress {
            width: 100%;
            height: 5px;
            background-color: #d3d3d3;
            position: relative;
        }

        .progress-bar {
            height: 5px;
            background-color: #28a745;
            width: 0;
            transition: width 0.3s;
        }

        .btn[disabled] {
            pointer-events: none;
            opacity: 0.6;
        }

        .note-text {
            font-size: 12px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <main>
        <form id="registrationForm" method="POST" enctype="multipart/form-data" action="../backends/subadmin/businessregfunction.php">
            <div class="row d-flex justify-content-center">
                <div class=" col-lg-4 col-md-8 col-sm-11">
                    <div class="container">
                        <div class="card shadow" style="margin-top:70px;">
                            <div class="card-body">
                                <div class="d-flex justify-content-between my-2">
                                    <div class="code-link">
                                        <a href="../businessowner/enter-code.php" class="btn btn-secondary">Reapply</a>
                                    </div>
                                    <div>
                                        <a href="../homepage/homepage.php"><i class="bi bi-x-lg text-success btn-close"></i></a>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <img src="../img/general-img/majayjay-logo.webp" alt="" height="50" width="50">
                                    <h4 class="text-center">Business Registration</h4>
                                </div>

                                <!-- Notification Message -->
                                <?php if (isset($_SESSION['message'])) : ?>
                                    <div class="alert alert-<?php echo htmlspecialchars($_SESSION['type']); ?> alert-dismissible fade show" role="alert">
                                        <?php echo htmlspecialchars($_SESSION['message']); ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    <?php unset($_SESSION['message']); ?>
                                    <?php unset($_SESSION['type']); ?>
                                <?php endif; ?>

                                <!-- Progress bar -->
                                <div class="progress-container mx-5">
                                    <div class="progress-step progress-step-active" data-step="1">1</div>
                                    <div class="progress">
                                        <div class="progress-bar" id="progress-bar"></div>
                                    </div>
                                    <div class="progress-step" data-step="2">2</div>
                                </div>

                                <div id="section1" class="section active">
                                    <div class="row mx-3">
                                        <div class="col-lg-12">
                                            <h5 class="text-center">Step 1: Add Registrant Information</h5>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-floating my-2">
                                                <input type="text" class="form-control shadow" name="fname" id="fname" placeholder="" autocomplete="off" value="<?php echo isset($_SESSION['form_data']['fname']) ? htmlspecialchars($_SESSION['form_data']['fname']) : ''; ?>" required>
                                                <label>First Name</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="form-floating my-2">
                                                <input type="text" class="form-control shadow" name="lname" id="lname" placeholder="" autocomplete="off" value="<?php echo isset($_SESSION['form_data']['lname']) ? htmlspecialchars($_SESSION['form_data']['lname']) : ''; ?>" required>
                                                <label>Last Name</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-floating my-2">
                                                <input type="text" class="form-control shadow" name="mname" id="mname" placeholder="" autocomplete="off" value="<?php echo isset($_SESSION['form_data']['mname']) ? htmlspecialchars($_SESSION['form_data']['mname']) : ''; ?>">
                                                <label>Middle Name (Optional)</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-floating my-2">
                                                <input type="text" class="form-control shadow" name="contact" id="contactNumber" value="<?php echo isset($_SESSION['form_data']['contact']) ? htmlspecialchars($_SESSION['form_data']['contact']) : '+63'; ?>" placeholder="" autocomplete="off" required>
                                                <label>Contact Number</label>
                                            </div>
                                        </div>

                                        <div class="col-lg-12">
                                            <div class="form-floating mt-2">
                                                <input type="email" class="form-control shadow" name="email" id="email" placeholder="" autocomplete="off" value="<?php echo isset($_SESSION['form_data']['email']) ? htmlspecialchars($_SESSION['form_data']['email']) : ''; ?>" required>
                                                <label>Email Address</label>
                                            </div>
                                        </div>

                                        <div class="my-2">
                                            <p class="note-text text-secondary m-0">Business Permit (upload image)</p>
                                            <input type="file" class="form-control shadow m-0" name="permit" id="permit" accept=".jpeg, .png, .gif, .jpg, webp" placeholder="" required>
                                        </div>

                                        <div class="col-lg-12 mt-2">
                                            <div class="form-floating">
                                                <input type="date" class="form-control shadow" name="bexdate" id="exdate" required value="<?php echo isset($_SESSION['form_data']['bexdate']) ? htmlspecialchars($_SESSION['form_data']['bexdate']) : ''; ?>">
                                                <label for="exdate">Business Permit Expiration Date</label>
                                            </div>
                                        </div>

                                        <p class="note-text text-secondary m-0">Please make sure the date is the same as the date on business permit</p>


                                        <div class="col-lg-12 d-flex justify-content-end my-3">


                                            <div class="d-grid col-6">
                                                <button type="button" class="btn btn-success" id="nextButton" onclick="nextSection(2)" disabled>NEXT</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="section2" class="section">
                                    <div class="row mx-3">
                                        <div class="col-lg-12">
                                            <h5 class="text-center">Step 2: Add Business Information</h5>
                                            <div class="col-lg-12">
                                                <div class="form-floating my-3">
                                                    <select class="form-select shadow" id="floatingSelectGrid" name="btype" required>
                                                        <option value="" disabled selected>Select type of business</option>
                                                        <?php foreach ($businessTypes as $type) : ?>
                                                            <option value="<?= htmlspecialchars($type['BusinessTypeID']); ?>" <?= (isset($_SESSION['form_data']['btype']) && $_SESSION['form_data']['btype'] == $type['BusinessTypeID']) ? 'selected' : ''; ?>>
                                                                <?= htmlspecialchars($type['TypeName']); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                    <label for="floatingSelectGrid">Type of business</label>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control shadow" name="bname" placeholder="" autocomplete="off" value="<?php echo isset($_SESSION['form_data']['bname']) ? htmlspecialchars($_SESSION['form_data']['bname']) : ''; ?>" required>
                                                    <label>Business Name</label>
                                                </div>
                                            </div>


                                            <div class="col-lg-12">
                                                <div class="form-floating mt-3">
                                                    <input type="hidden" name="full_address" value="">
                                                    <input type="text" class="form-control shadow" name="street" placeholder="" autocomplete="off"
                                                        value="<?php echo isset($_SESSION['form_data']['street']) ? htmlspecialchars($_SESSION['form_data']['street']) : ''; ?>" required>
                                                    <label>Street</label>
                                                    <p class="note-text text-secondary m-0">(Ex. Street, Barangay, Municipality/City, Province)</p>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-floating mt-3">
                                                    <select class="form-select shadow" id="barangay" name="barangay" required>
                                                        <option value="" disabled selected>Select Barangay</option>
                                                    </select>
                                                    <input type="hidden" id="barangayname" name="barangayname" value="<?php echo isset($_SESSION['form_data']['barangay']) ? htmlspecialchars($_SESSION['form_data']['barangay']) : ''; ?>">
                                                    <label for="barangay">Barangay</label>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-floating mt-3">
                                                    <input type="text" class="form-control shadow" name="city" placeholder="" autocomplete="off" value="Majayjay" readonly>
                                                    <label>City</label>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-floating mt-3">
                                                    <input type="text" class="form-control shadow" name="province" placeholder="" autocomplete="off" value="Laguna" readonly>
                                                    <label>Province</label>
                                                </div>
                                            </div>



                                            <div class="col-lg-12">
                                                <div class="form-floating my-3">
                                                    <input type="email" class="form-control shadow" name="bemail" placeholder="" autocomplete="off" value="<?php echo isset($_SESSION['form_data']['bemail']) ? htmlspecialchars($_SESSION['form_data']['bemail']) : ''; ?>">
                                                    <label>Business Email Address(Optional)</label>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control shadow" name="bcontact" id="businessContactNumber" value="<?php echo isset($_SESSION['form_data']['bcontact']) ? htmlspecialchars($_SESSION['form_data']['bcontact']) : '+63'; ?>" placeholder="" autocomplete="off" required>
                                                    <label>Business Contact Number</label>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 mb-3">
                                                <div class="form-floating my-2">
                                                    <textarea class="form-control shadow" name="bdesc" placeholder="Leave a comment here" id="floatingTextarea" style="height: 100px" required><?php echo isset($_SESSION['form_data']['bdesc']) ? htmlspecialchars($_SESSION['form_data']['bdesc']) : ''; ?></textarea>
                                                    <label for="floatingTextarea">Business Descriptions</label>
                                                    <p class="note-text text-secondary m-0">(Maximum of 50 words)</p>
                                                    <div id="bdesc-word-count" class="text-end text-muted"></div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12 d-flex mb-3">
                                                <div class="d-grid col-6 mx-auto">
                                                    <button type="button" class="btn btn-secondary me-2" onclick="previousSection(1)">BACK</button>
                                                </div>
                                                <div class="d-grid col-6 mx-auto">
                                                    <button type="button" class="btn btn-success" id="registerButton" onclick="showConfirmationModal()" disabled>REGISTER</button>
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
        </form>
    </main>


    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmationModalLabel">Confirm Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure all the documents are correct?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" onclick="submitForm()">Confirm</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="../sweetalert2/jquery-3.7.1.min.js"></script>
    <script src="../sweetalert2/sweetalert2.all.min.js"></script>
    <script src="../js/businessowner.js"></script>

    <script>
        function nextSection(section) {
            document.querySelectorAll('.section').forEach(function(el) {
                el.classList.remove('active');
            });
            document.getElementById('section' + section).classList.add('active');
            updateProgressBar(section);
            validateFields();
        }

        function previousSection(section) {
            document.querySelectorAll('.section').forEach(function(el) {
                el.classList.remove('active');
            });
            document.getElementById('section' + section).classList.add('active');
            updateProgressBar(section);
            validateFields();
        }

        function updateProgressBar(section) {
            const progressBar = document.getElementById('progress-bar');
            const steps = document.querySelectorAll('.progress-step');
            steps.forEach((step, index) => {
                if (index < section) {
                    step.classList.add('progress-step-active');
                } else {
                    step.classList.remove('progress-step-active');
                }
            });
            progressBar.style.width = ((section - 1) / (steps.length - 1)) * 100 + '%';
        }

        function showConfirmationModal() {
            var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'), {
                keyboard: false
            });
            confirmationModal.show();
        }

        function submitForm() {
            document.getElementById('registrationForm').submit();
        }

        function handleContactInput(event) {
            let value = event.target.value;
            if (!value.startsWith('+63')) {
                value = '+63' + value.replace(/\D/g, '');
            } else {
                value = '+63' + value.slice(3).replace(/\D/g, '');
            }
            if (value.length > 13) {
                value = value.slice(0, 13);
            }
            event.target.value = value;
        }

        function validateFields() {
            const fname = document.getElementById('fname').value.trim();
            const lname = document.getElementById('lname').value.trim();
            const contact = document.getElementById('contactNumber').value.trim();
            const email = document.getElementById('email').value.trim();
            const permit = document.getElementById('permit').files.length;
            const bexdate = document.getElementById('exdate').value.trim();
            const btype = document.querySelector('[name="btype"]').value;
            const bname = document.querySelector('[name="bname"]').value.trim();
            const bemail = document.querySelector('[name="bemail"]').value.trim();
            const bcontact = document.getElementById('businessContactNumber').value.trim();
            const bdesc = document.querySelector('[name="bdesc"]').value.trim();

            const isValidEmail = email => {
                const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@(([^<>()[\]\\.,;:\s@"]+\.)+[^<>()[\]\\.,;:\s@"]{2,})$/i;
                return re.test(String(email).toLowerCase());
            }

            const section1Valid = fname && lname && contact.length === 13 && isValidEmail(email) && permit > 0 && bexdate;
            const section2Valid = btype && bname && bcontact.length === 13 && bdesc && (bemail === '' || isValidEmail(bemail));

            if (section1Valid) {
                document.getElementById('nextButton').removeAttribute('disabled');
            } else {
                document.getElementById('nextButton').setAttribute('disabled', 'true');
            }

            if (section2Valid) {
                document.getElementById('registerButton').removeAttribute('disabled');
            } else {
                document.getElementById('registerButton').setAttribute('disabled', 'true');
            }
        }

        document.getElementById('contactNumber').addEventListener('input', handleContactInput);
        document.getElementById('businessContactNumber').addEventListener('input', handleContactInput);
        document.querySelectorAll('#fname, #lname, #contactNumber, #email, #permit, #exdate, [name="btype"], [name="bname"], [name="bemail"], #businessContactNumber, [name="bdesc"]').forEach(element => {
            element.addEventListener('input', validateFields);
            element.addEventListener('change', validateFields);
        });

        document.addEventListener('DOMContentLoaded', validateFields);
    </script>

    <!-- script to populate barangay dropdown -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const barangaySelect = document.getElementById('barangay');
            const barangayNameInput = document.getElementById('barangayname');

            // Fetch barangays from the JSON file
            fetch('../../backends/subadmin/barangay-list.json')
                .then(response => response.json())
                .then(data => {
                    data.barangays.forEach(barangay => {
                        const option = document.createElement('option');
                        option.value = barangay.barangay_name;
                        option.textContent = barangay.barangay_name;
                        barangaySelect.appendChild(option);
                    });

                    // Set the selected barangay from the session
                    const selectedBarangay = "<?php echo isset($_SESSION['form_data']['barangay']) ? htmlspecialchars($_SESSION['form_data']['barangay']) : ''; ?>";
                    if (selectedBarangay) {
                        barangaySelect.value = selectedBarangay;
                        barangayNameInput.value = selectedBarangay;
                    }
                });

            // When a barangay is selected, store the value in the hidden input field
            barangaySelect.addEventListener('change', function() {
                barangayNameInput.value = this.value;
            });
        });
    </script>

    <script src="../wordcounter/jquery.word-and-character-counter.js"></script>
    <script>
        $(document).ready(function() {
            $('#floatingTextarea').counter({
                type: 'word',
                count: 'up',
                goal: 50,
                target: '#bdesc-word-count',
                text: true,
                translation: 'word left max',
                onGoal: function() {
                    $('#floatingTextarea').on('keydown', function(event) {
                        if (event.key !== 'Backspace' && event.key !== 'Delete') {
                            event.preventDefault();
                        }
                    });
                },
                onCountChange: function(currentCount) {
                    if (currentCount < 50) {
                        $('#floatingTextarea').off('keydown');
                    }
                }
            });
        });
    </script>

</body>

</html>