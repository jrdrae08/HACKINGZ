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
    <title>New Reservation</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <!-- Notify Links -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="../css/businessowner.css">
    <style>
        /* Hide the dropdown arrow */
        #notification-icon::after {
            display: none;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <?php include '../businessowner/includes/aside.php'; ?>

        <div class="main">
            <?php include '../businessowner/includes/navbar.php'; ?>

            <!-- Manage Reservation -->
            <main class="content py-2">
                <div class="container-fluid">
                    <h3>Manage Customer Reservations</h3>
                    <div class="row d-flex justify-content-center mt-5">
                        <div class="col-lg-10 col-12">
                            <div class="card border-0 shadow">
                                <div class="card-header">
                                    <div class="row d-flex justify-content-center align-items-center">
                                        <div class="col-lg-8 col-sm-12 mb-2 ">
                                            <ul class="nav nav-pills d-flex justify-content-center" id="pills-tab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link pills btn me-2 mb-2 active" id="pills-new-tab" data-bs-toggle="pill" data-bs-target="#pills-new" type="button" role="tab" aria-controls="pills-home" aria-selected="true">NEW</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link pills btn me-2 mb-2" id="pills-upcoming-tab" data-bs-toggle="pill" data-bs-target="#pills-upcoming" type="button" role="tab" aria-controls="pills-home" aria-selected="false">UPCOMING</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link pills btn me-2 mb-2" id="pills-ongoing-tab" data-bs-toggle="pill" data-bs-target="#pills-ongoing" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">ONGOING</button>
                                                </li>

                                                <!-- <div class="vertical-line"></div> -->
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link pills btn me-2 mb-2" id="pills-archive-tab" data-bs-toggle="pill" data-bs-target="#pills-archive" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">ARCHIVE</button>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link pills btn me-2 mb-2" id="pills-cancel-tab" data-bs-toggle="pill" data-bs-target="#pills-cancel" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">CANCELED</button>
                                                </li>
                                            </ul>
                                        </div>

                                        <div class="col-lg-1 col-sm-12 d-flex justify-content-center align-items-center">
                                            <!-- Bell Icon with Dropdown -->
                                            <div class="dropdown">
                                                <i class="bi bi-bell-fill text-warning fs-3 dropdown-toggle" id="notification-icon" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false"></i>
                                                <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="notification-icon">
                                                    <li><a class="dropdown-item" href="#">Booking cancellation</a></li>
                                                </ul>
                                            </div>
                                        </div>



                                        <div class="col-lg-3 col-sm-12">
                                            <form class="d-flex" role="search">
                                                <input class="form-control shadow me-2" type="search" placeholder="Search" aria-label="Search">
                                                <button class="btn btn-outline-success" type="submit">Search</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <!-- New -->
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-new" role="tabpanel" aria-labelledby="pills-new-tab" tabindex="0">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="reservationsTable">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Time Booked</th>
                                                            <th scope="col">Room Name</th>
                                                            <th scope="col">Customer Name</th>
                                                            <th scope="col">Action</th>
                                                            <th scope="col">Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="new-reservations">
                                                        <!-- Reservations will be dynamically added here -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="viewroom" tabindex="-1" aria-labelledby="viewroomLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="viewroomLabel">Reservation Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p><strong>Name:</strong> <span id="modal-name"></span></p>
                                                        <p><strong>Address:</strong> <span id="modal-address"></span></p>
                                                        <p><strong>Contact Number:</strong> <span id="modal-contact"></span></p>
                                                        <p><strong>Type of ID:</strong> <span id="modal-id-type"></span></p>
                                                        <p><strong>ID Front:</strong> <img id="modal-front-id" src="" alt="Front ID" style="width: 100%;"></p>
                                                        <p id="back-id-container"><strong>ID Back:</strong> <img id="modal-back-id" src="" alt="Back ID" style="width: 100%;"></p>
                                                        <hr>
                                                        <h5>User Demographics</h5>
                                                        <p><strong>Total Number of Attendees:</strong> <span id="modal-total-attendees"></span></p>
                                                        <p><strong>Total Male:</strong> <span id="modal-total-male"></span></p>
                                                        <p><strong>Total Female:</strong> <span id="modal-total-female"></span></p>
                                                        <p><strong>This City/Municipality:</strong> <span id="modal-this-city"></span></p>
                                                        <p><strong>Other City/Municipality:</strong> <span id="modal-other-city"></span></p>
                                                        <p><strong>Other Province:</strong> <span id="modal-other-province"></span></p>
                                                        <p><strong>Foreign Country:</strong> <span id="modal-foreign-country"></span></p>
                                                        <p class="text-center fw-bold">Information Table</p>
                                                        <table class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col">Name</th>
                                                                    <th>Sex</th>
                                                                    <th>Location</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="infoTableBody">
                                                                <!-- Attendees will be dynamically added here -->
                                                            </tbody>
                                                        </table>
                                                        <p><strong>Proof of Payment</strong> <img id="modal-proofof-payment" src="" alt="Proof of Payment" style="width: 100%;"></p>
                                                        <p><strong>Reference Number:</strong> <span id="modal-reference-number"></span></p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Confirmation Modal for Approval -->
                                        <div class="modal fade" id="confirmationModalApprove" tabindex="-1" aria-labelledby="confirmationModalApproveLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="confirmationModalApproveLabel">Confirm Approval</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to approve this reservation?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-success" id="confirmApprove">Approve</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Confirmation Modal for Rejection -->
                                        <div class="modal fade" id="confirmationModalReject" tabindex="-1" aria-labelledby="confirmationModalRejectLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="confirmationModalRejectLabel">Confirm Rejection</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p id="confirmationMessageReject">Are you sure you want to reject this reservation?</p>
                                                        <div id="rejectReasons">
                                                            <div>
                                                                <input type="checkbox" id="checkbox1" name="checkbox1">
                                                                <label for="checkbox1">Payment is invalid</label>
                                                            </div>
                                                            <div>
                                                                <input type="checkbox" id="checkbox2" name="checkbox2">
                                                                <label for="checkbox2">Fake Identity Card</label>
                                                            </div>
                                                            <div>
                                                                <input type="checkbox" id="checkbox3" name="checkbox3">
                                                                <label for="checkbox3">Others</label>
                                                            </div>
                                                            <div id="otherReasonDiv" style="display: none;">
                                                                <textarea id="otherReasonText" placeholder="Please specify the reason" style="width: 100%; height: 100px;"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-danger" id="confirmReject" disabled>Reject</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            $(document).ready(function() {
                                                const notyf = new Notyf({
                                                    duration: 5000,
                                                    position: {
                                                        x: 'right',
                                                        y: 'top'
                                                    }
                                                });

                                                let revID, status;

                                                // Event listener for accept reservation buttons using event delegation
                                                $(document).on('click', '.accept-reservation', function() {
                                                    revID = $(this).data('revid');
                                                    status = $(this).data('status');
                                                    $('#confirmationModalApprove').modal('show');
                                                });

                                                // Event listener for confirm approve button in the modal
                                                $('#confirmApprove').on('click', function() {
                                                    $.ajax({
                                                        url: '../../backends/subadmin/update_reservation_status.php',
                                                        method: 'POST',
                                                        contentType: 'application/json',
                                                        data: JSON.stringify({
                                                            revID: revID,
                                                            status: status
                                                        }),
                                                        dataType: 'json',
                                                        success: function(response) {
                                                            if (response.status === 'success') {
                                                                fetchNewReservations(); // Refresh the reservations list
                                                                $('#confirmationModalApprove').modal('hide');
                                                                notyf.success('Reservation approved successfully!');
                                                            } else {
                                                                notyf.error(response.message);
                                                            }
                                                        },
                                                        error: function() {
                                                            notyf.error('An error occurred while updating the reservation status.');
                                                        }
                                                    });
                                                });

                                                // Event listener for reject reservation buttons using event delegation
                                                $(document).on('click', '.cancel-reservation', function() {
                                                    revID = $(this).data('revid');
                                                    status = $(this).data('status');
                                                    $('#confirmationModalReject').modal('show');
                                                    checkRejectButtonState();
                                                });

                                                // Event listener for confirm reject button in the modal
                                                $('#confirmReject').on('click', function() {
                                                    let reasons = [];
                                                    $('#rejectReasons input:checked').each(function() {
                                                        if ($(this).attr('id') !== 'checkbox3') {
                                                            reasons.push($(this).next('label').text());
                                                        }
                                                    });
                                                    if ($('#checkbox3').is(':checked')) {
                                                        reasons.push($('#otherReasonText').val());
                                                    }

                                                    $.ajax({
                                                        url: '../../backends/subadmin/update_reservation_status.php',
                                                        method: 'POST',
                                                        contentType: 'application/json',
                                                        data: JSON.stringify({
                                                            revID: revID,
                                                            status: status,
                                                            reasons: reasons
                                                        }),
                                                        dataType: 'json',
                                                        success: function(response) {
                                                            if (response.status === 'success') {
                                                                fetchNewReservations(); // Refresh the reservations list
                                                                $('#confirmationModalReject').modal('hide');
                                                                notyf.success('Reservation rejected successfully!');
                                                            } else {
                                                                notyf.error(response.message);
                                                            }
                                                        },
                                                        error: function() {
                                                            notyf.error('An error occurred while updating the reservation status.');
                                                        }
                                                    });
                                                });

                                                // Show/hide other reason text area
                                                $('#checkbox3').on('change', function() {
                                                    if ($(this).is(':checked')) {
                                                        $('#otherReasonDiv').show();
                                                    } else {
                                                        $('#otherReasonDiv').hide();
                                                    }
                                                    checkRejectButtonState();
                                                });

                                                // Enable/disable the reject button based on checkbox states
                                                $('#rejectReasons input[type="checkbox"]').on('change', function() {
                                                    checkRejectButtonState();
                                                });

                                                function checkRejectButtonState() {
                                                    if ($('#rejectReasons input[type="checkbox"]:checked').length > 0) {
                                                        $('#confirmReject').prop('disabled', false);
                                                    } else {
                                                        $('#confirmReject').prop('disabled', true);
                                                    }
                                                }

                                                function fetchNewReservations() {
                                                    $.ajax({
                                                        url: '../../backends/subadmin/fetch_new_reservations.php', // Update the path as needed
                                                        method: 'GET',
                                                        dataType: 'json',
                                                        success: function(response) {
                                                            if (response.status === 'success') {
                                                                let reservations = response.data;
                                                                let tbody = $('#new-reservations');
                                                                tbody.empty(); // Clear existing rows

                                                                reservations.forEach(function(reservation) {
                                                                    let timeBooked = new Date(reservation.timeBooked);
                                                                    let formattedTimeBooked = timeBooked.toLocaleString('en-US', {
                                                                        hour: 'numeric',
                                                                        minute: 'numeric',
                                                                        hour12: true
                                                                    }) + ' ' + timeBooked.toLocaleString('en-US', {
                                                                        month: 'long',
                                                                        day: 'numeric',
                                                                        year: 'numeric'
                                                                    });

                                                                    let row = `
                                    <tr>
                                        <td>${formattedTimeBooked}</td>
                                        <td>${reservation.roomName}</td>
                                        <td>${reservation.customerName}</td>
                                        <td>
                                            <button class="btn btn-primary m-1 view-details" data-bs-toggle="modal" data-bs-target="#viewroom"
                                                data-name="${reservation.customerName}"
                                                data-address="${reservation.address}"
                                                data-contact="${reservation.contactNumber}"
                                                data-id-type="${reservation.id_type}"
                                                data-front-id="${reservation.front_id}"
                                                data-back-id="${reservation.back_id}"
                                                data-total-attendees="${reservation.totalnumAttendees}"
                                                data-total-male="${reservation.totalmale}"
                                                data-total-female="${reservation.totalfemale}"
                                                data-this-city="${reservation.thisCity}"
                                                data-other-city="${reservation.otherCity}"
                                                data-other-province="${reservation.otherProvince}"
                                                data-foreign-country="${reservation.foreignCountry}"
                                                data-attendee-names="${reservation.attendeeNames}"
                                                data-attendee-sexes="${reservation.attendeeSexes}"
                                                data-attendee-locations="${reservation.attendeeLocations}"
                                                data-proof-of-payment="${reservation.proofOfPayment}"
                                                data-reference-number="${reservation.gcashReference}"
                                            ><i class="bi bi-eye"></i></button>
                                            <button class="btn btn-success m-1 accept-reservation" data-revid="${reservation.revID}" data-status="Accepted"><i class="bi bi-check-lg"></i></button>
                                            <button class="btn btn-danger m-1 cancel-reservation" data-revid="${reservation.revID}" data-status="Rejected"><i class="bi bi-x-lg"></i></button>
                                        </td>
                                        <td>New</td>
                                    </tr>
                                `;
                                                                    tbody.append(row);
                                                                });

                                                                // Initialize DataTable
                                                                $('#reservationsTable').DataTable();

                                                                // Add event listener for view details buttons
                                                                $('.view-details').on('click', function() {
                                                                    $('#modal-name').text($(this).data('name'));
                                                                    $('#modal-address').text($(this).data('address'));
                                                                    $('#modal-contact').text($(this).data('contact'));
                                                                    $('#modal-id-type').text($(this).data('id-type'));
                                                                    $('#modal-front-id').attr('src', $(this).data('front-id'));

                                                                    let backId = $(this).data('back-id');
                                                                    if (backId) {
                                                                        $('#modal-back-id').attr('src', backId).parent().show();
                                                                    } else {
                                                                        $('#modal-back-id').parent().hide();
                                                                    }

                                                                    // Set user demographics
                                                                    $('#modal-total-attendees').text($(this).data('total-attendees'));
                                                                    $('#modal-total-male').text($(this).data('total-male'));
                                                                    $('#modal-total-female').text($(this).data('total-female'));
                                                                    $('#modal-this-city').text($(this).data('this-city'));
                                                                    $('#modal-other-city').text($(this).data('other-city'));
                                                                    $('#modal-other-province').text($(this).data('other-province'));
                                                                    $('#modal-foreign-country').text($(this).data('foreign-country'));

                                                                    // Populate the information table
                                                                    let attendeeNames = $(this).data('attendee-names').split(',');
                                                                    let attendeeSexes = $(this).data('attendee-sexes').split(',');
                                                                    let attendeeLocations = $(this).data('attendee-locations').split(',');

                                                                    let infoTableBody = $('#viewroom tbody');
                                                                    infoTableBody.empty(); // Clear existing rows

                                                                    for (let i = 0; i < attendeeNames.length; i++) {
                                                                        let row = `
                                        <tr>
                                            <td>${attendeeNames[i]}</td>
                                            <td>${attendeeSexes[i]}</td>
                                            <td>${attendeeLocations[i]}</td>
                                        </tr>
                                    `;
                                                                        infoTableBody.append(row);
                                                                    }

                                                                    // Set proof of payment and reference number
                                                                    let proofOfPayment = $(this).data('proof-of-payment');
                                                                    let referenceNumber = $(this).data('reference-number');

                                                                    if (proofOfPayment) {
                                                                        $('#modal-proofof-payment').attr('src', proofOfPayment).parent().show();
                                                                    } else {
                                                                        $('#modal-proofof-payment').parent().hide();
                                                                    }

                                                                    if (referenceNumber) {
                                                                        $('#modal-reference-number').text(referenceNumber).parent().show();
                                                                    } else {
                                                                        $('#modal-reference-number').parent().hide();
                                                                    }
                                                                });
                                                            } else {
                                                                $('#new-reservations').html('<tr><td colspan="5">No reservations found.</td></tr>');
                                                            }
                                                        },
                                                        error: function() {
                                                            $('#new-reservations').html('<tr><td colspan="5">An error occurred while fetching reservations.</td></tr>');
                                                        }
                                                    });
                                                }

                                                // Fetch new reservations on page load
                                                fetchNewReservations();
                                            });
                                        </script>


                                        <!-- upcoming -->
                                        <div class="tab-pane fade" id="pills-upcoming" role="tabpanel" aria-labelledby="pills-upcoming-tab" tabindex="0">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="upcomingReservationsTable">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Time Booked</th>
                                                            <th scope="col">Room Name</th>
                                                            <th scope="col">Customer Name</th>
                                                            <th scope="col">Action</th>
                                                            <th scope="col">Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="upcoming-reservations">
                                                        <!-- Data will be populated here by JavaScript -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <script>
                                            $(document).ready(function() {
                                                const notyf = new Notyf({
                                                    duration: 5000,
                                                    position: {
                                                        x: 'right',
                                                        y: 'top'
                                                    }
                                                });

                                                let revIDToApprove;
                                                let attendeeData = {
                                                    name: [],
                                                    sex: [],
                                                    location: []
                                                };

                                                // Disable the Approve button initially
                                                $('#confirmOngoing').prop('disabled', true);

                                                // Event listener for accept reservation buttons using event delegation
                                                $(document).on('click', '.upcoming-reservation', function() {
                                                    revIDToApprove = $(this).data('revid');
                                                    const totalAttendees = $(this).data('total-attendees');
                                                    const isUpcoming = $(this).data('is-upcoming');
                                                    const attendeeNames = $(this).data('attendee-names') ? $(this).data('attendee-names').split(',').map(name => name.trim()) : [];
                                                    const attendeeSexes = $(this).data('attendee-sexes') ? $(this).data('attendee-sexes').split(',').map(sex => sex.trim()) : [];
                                                    const attendeeLocations = $(this).data('attendee-locations') ? $(this).data('attendee-locations').split(',').map(location => location.trim()) : [];

                                                    attendeeData = {
                                                        name: attendeeNames,
                                                        sex: attendeeSexes,
                                                        location: attendeeLocations
                                                    };

                                                    if (isUpcoming) {
                                                        generateAttendeeFormFields(totalAttendees, attendeeNames, attendeeSexes, attendeeLocations);
                                                        $('#confirmationUpcomingModal').modal('show');
                                                    } else {
                                                        $('#confirmationModalApprove').modal('show');
                                                    }
                                                });

                                                // Function to generate attendee form fields
                                                function generateAttendeeFormFields(totalAttendees, attendeeNames = [], attendeeSexes = [], attendeeLocations = []) {
                                                    const container = $('#attendeeInfoContainer');
                                                    container.empty(); // Clear existing fields

                                                    for (let i = 1; i <= totalAttendees; i++) {
                                                        const name = attendeeNames[i - 1] || '';
                                                        const sex = attendeeSexes[i - 1] || '';
                                                        const location = attendeeLocations[i - 1] || '';

                                                        const attendeeFields = `
                    <div class="attendee-container">
                        <div class="row mb-3 attendee-row" data-attendee-index="${i}">
                            <p class="mb-0 dm-sans-text">Name of Attendee ${i}</p>
                            <div class="col-xl-5 col-12">
                                <input type="text" class="form-control shadow mb-2" name="name[]" placeholder="ex. Juan Dela Cruz" value="${name}" required>
                            </div>
                            <div class="col-xl-5 col-12">
                                <div class="row g-2">
                                    <div class="col-xl-12 col-6">
                                        <select name="sex[]" class="form-select shadow" required>
                                            <option value="">Select Sex</option>
                                            <option value="Male" ${sex === 'Male' ? 'selected' : ''}>Male</option>
                                            <option value="Female" ${sex === 'Female' ? 'selected' : ''}>Female</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-12 col-6">
                                        <select name="location[]" class="form-select shadow" required>
                                            <option value="">Select Location</option>
                                            <option value="This City/Municipality" ${location === 'This City/Municipality' ? 'selected' : ''}>This City/Municipality</option>
                                            <option value="Other City/Municipality" ${location === 'Other City/Municipality' ? 'selected' : ''}>Other City/Municipality</option>
                                            <option value="Other Province" ${location === 'Other Province' ? 'selected' : ''}>Other Province</option>
                                            <option value="Foreign Country" ${location === 'Foreign Country' ? 'selected' : ''}>Foreign Country</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2 mt-3">
                                <button type="button" class="btn btn-danger m-1 delete-attendee"><i class="bi bi-x-lg"></i></button>
                            </div>
                        </div>
                        <hr class="mt-2">
                    </div>
                `;
                                                        container.append(attendeeFields);
                                                    }

                                                    // Add event listeners to the new fields
                                                    addFieldEventListeners();

                                                    // Check if all fields have values to enable the Approve button
                                                    checkAttendeeFields();
                                                }

                                                // Event listener for delete attendee button
                                                $(document).on('click', '.delete-attendee', function() {
                                                    const attendeeContainer = $(this).closest('.attendee-container');
                                                    const attendeeIndex = attendeeContainer.find('.attendee-row').data('attendee-index') - 1; // Convert to zero-based index
                                                    attendeeContainer.remove();

                                                    // Remove the attendee from the attendeeData object
                                                    attendeeData.name.splice(attendeeIndex, 1);
                                                    attendeeData.sex.splice(attendeeIndex, 1);
                                                    attendeeData.location.splice(attendeeIndex, 1);

                                                    // Check if all fields have values to enable the Approve button
                                                    checkAttendeeFields();
                                                });

                                                // Event listener for adding new attendee
                                                $('#addAttendee').on('click', function() {
                                                    const container = $('#attendeeInfoContainer');
                                                    const newIndex = container.children('.attendee-container').length + 1;

                                                    const newAttendeeFields = `
                <div class="attendee-container">
                    <div class="row mb-3 attendee-row" data-attendee-index="${newIndex}">
                        <p class="mb-0 dm-sans-text">Name of Attendee ${newIndex}</p>
                        <div class="col-xl-5 col-12">
                            <input type="text" class="form-control shadow mb-2" name="name[]" placeholder="ex. Juan Dela Cruz" required>
                        </div>
                        <div class="col-xl-5 col-12">
                            <div class="row g-2">
                                <div class="col-xl-12 col-6">
                                    <select name="sex[]" class="form-select shadow" required>
                                        <option value="">Select Sex</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                                <div class="col-xl-12 col-6">
                                    <select name="location[]" class="form-select shadow" required>
                                        <option value="">Select Location</option>
                                        <option value="This City/Municipality">This City/Municipality</option>
                                        <option value="Other City/Municipality">Other City/Municipality</option>
                                        <option value="Other Province">Other Province</option>
                                        <option value="Foreign Country">Foreign Country</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 mt-3">
                            <button type="button" class="btn btn-danger m-1 delete-attendee"><i class="bi bi-x-lg"></i></button>
                        </div>
                    </div>
                    <hr class="mt-2">
                </div>
            `;
                                                    container.append(newAttendeeFields);

                                                    // Add event listeners to the new fields
                                                    addFieldEventListeners();

                                                    // Check if all fields have values to enable the Approve button
                                                    checkAttendeeFields();
                                                });

                                                // Function to add event listeners to the attendee fields
                                                function addFieldEventListeners() {
                                                    $('#attendeeInfoContainer input[name="name[]"], #attendeeInfoContainer select[name="sex[]"], #attendeeInfoContainer select[name="location[]"]').on('input change', function() {
                                                        checkAttendeeFields();
                                                    });
                                                }

                                                // Function to check if all attendee fields have values
                                                function checkAttendeeFields() {
                                                    let allFieldsFilled = true;
                                                    $('#attendeeInfoContainer .attendee-container').each(function() {
                                                        const name = $(this).find('input[name="name[]"]').val();
                                                        const sex = $(this).find('select[name="sex[]"]').val();
                                                        const location = $(this).find('select[name="location[]"]').val();

                                                        if (!name || !sex || !location) {
                                                            allFieldsFilled = false;
                                                            return false; // Exit the loop
                                                        }
                                                    });

                                                    $('#confirmOngoing').prop('disabled', !allFieldsFilled);
                                                }

                                                // Event listener for the form submission in the upcoming modal
                                                $('#confirmOngoing').on('click', function() {
                                                    const formData = $('#approveForm').serializeArray();
                                                    const updatedAttendeeData = {
                                                        name: [],
                                                        sex: [],
                                                        location: []
                                                    };

                                                    formData.forEach(field => {
                                                        const fieldName = field.name.replace('[]', ''); // Remove the '[]' from the field name
                                                        if (!updatedAttendeeData[fieldName]) {
                                                            updatedAttendeeData[fieldName] = [];
                                                        }
                                                        updatedAttendeeData[fieldName].push(field.value);
                                                    });

                                                    $.ajax({
                                                        url: '../../backends/subadmin/update_userdemogreserve.php', // Update the path as needed
                                                        method: 'POST',
                                                        contentType: 'application/json',
                                                        data: JSON.stringify({
                                                            revID: revIDToApprove,
                                                            attendeeData: updatedAttendeeData
                                                        }),
                                                        dataType: 'json',
                                                        success: function(response) {
                                                            if (response.status === 'success') {
                                                                fetchUpcomingReservations(); // Refresh the reservations list
                                                                $('#confirmationUpcomingModal').modal('hide');
                                                                notyf.success('Reservation approved successfully!');
                                                            } else {
                                                                notyf.error(response.message);
                                                            }
                                                        },
                                                        error: function() {
                                                            notyf.error('An error occurred while approving the reservation.');
                                                        }
                                                    });
                                                });

                                                function fetchUpcomingReservations() {
                                                    $.ajax({
                                                        url: '../../backends/subadmin/fetch_upcoming_reservations.php', // Update the path as needed
                                                        method: 'GET',
                                                        dataType: 'json',
                                                        success: function(response) {
                                                            if (response.status === 'success') {
                                                                let reservations = response.data;
                                                                let tbody = $('#upcoming-reservations');
                                                                tbody.empty(); // Clear existing rows

                                                                reservations.forEach(function(reservation) {
                                                                    let timeBooked = new Date(reservation.timeBooked);
                                                                    let formattedTimeBooked = timeBooked.toLocaleString('en-US', {
                                                                        hour: 'numeric',
                                                                        minute: 'numeric',
                                                                        hour12: true
                                                                    }) + ' ' + timeBooked.toLocaleString('en-US', {
                                                                        month: 'long',
                                                                        day: 'numeric',
                                                                        year: 'numeric'
                                                                    });

                                                                    let row = `
                                <tr>
                                    <td>${formattedTimeBooked}</td>
                                    <td>${reservation.roomName}</td>
                                    <td>${reservation.customerName}</td>
                                    <td>
                                        <button class="btn btn-primary m-1 view-details" data-bs-toggle="modal" data-bs-target="#viewroom"
                                            data-name="${reservation.customerName}"
                                            data-address="${reservation.address}"
                                            data-contact="${reservation.contactNumber}"
                                            data-id-type="${reservation.id_type}"
                                            data-front-id="${reservation.front_id}"
                                            data-back-id="${reservation.back_id}"
                                            data-total-attendees="${reservation.totalnumAttendees}"
                                            data-total-male="${reservation.totalmale}"
                                            data-total-female="${reservation.totalfemale}"
                                            data-this-city="${reservation.thisCity}"
                                            data-other-city="${reservation.otherCity}"
                                            data-other-province="${reservation.otherProvince}"
                                            data-foreign-country="${reservation.foreignCountry}"
                                            data-attendee-names="${reservation.attendeeNames}"
                                            data-attendee-sexes="${reservation.attendeeSexes}"
                                            data-attendee-locations="${reservation.attendeeLocations}"
                                            data-proof-of-payment="${reservation.proofOfPayment}"
                                            data-reference-number="${reservation.gcashReference}"
                                        ><i class="bi bi-eye"></i></button>
                                        <button class="btn btn-success m-1 upcoming-reservation" data-revid="${reservation.revID}" data-total-attendees="${reservation.totalnumAttendees}" data-is-upcoming="true" data-attendee-names="${reservation.attendeeNames}" data-attendee-sexes="${reservation.attendeeSexes}" data-attendee-locations="${reservation.attendeeLocations}"><i class="bi bi-check-lg"></i></button>
                                    </td>
                                    <td>Accepted</td>
                                </tr>
                            `;
                                                                    tbody.append(row);
                                                                });

                                                                // Initialize DataTable
                                                                $('#upcomingReservationsTable').DataTable();

                                                                // Add event listener for view details buttons
                                                                $('.view-details').on('click', function() {
                                                                    $('#modal-name').text($(this).data('name'));
                                                                    $('#modal-address').text($(this).data('address'));
                                                                    $('#modal-contact').text($(this).data('contact'));
                                                                    $('#modal-id-type').text($(this).data('id-type'));
                                                                    $('#modal-front-id').attr('src', $(this).data('front-id'));

                                                                    let backId = $(this).data('back-id');
                                                                    if (backId) {
                                                                        $('#modal-back-id').attr('src', backId).parent().show();
                                                                    } else {
                                                                        $('#modal-back-id').parent().hide();
                                                                    }

                                                                    // Set user demographics
                                                                    $('#modal-total-attendees').text($(this).data('total-attendees'));
                                                                    $('#modal-total-male').text($(this).data('total-male'));
                                                                    $('#modal-total-female').text($(this).data('total-female'));
                                                                    $('#modal-this-city').text($(this).data('this-city'));
                                                                    $('#modal-other-city').text($(this).data('other-city'));
                                                                    $('#modal-other-province').text($(this).data('other-province'));
                                                                    $('#modal-foreign-country').text($(this).data('foreign-country'));

                                                                    // Populate the information table
                                                                    let attendeeNames = $(this).data('attendee-names').split(',').map(name => name.trim());
                                                                    let attendeeSexes = $(this).data('attendee-sexes').split(',').map(sex => sex.trim());
                                                                    let attendeeLocations = $(this).data('attendee-locations').split(',').map(location => location.trim());

                                                                    let infoTableBody = $('#viewroom tbody');
                                                                    infoTableBody.empty(); // Clear existing rows

                                                                    for (let i = 0; i < attendeeNames.length; i++) {
                                                                        let row = `
                                    <tr>
                                        <td>${attendeeNames[i]}</td>
                                        <td>${attendeeSexes[i]}</td>
                                        <td>${attendeeLocations[i]}</td>
                                    </tr>
                                `;
                                                                        infoTableBody.append(row);
                                                                    }

                                                                    // Set proof of payment and reference number
                                                                    let proofOfPayment = $(this).data('proof-of-payment');
                                                                    let referenceNumber = $(this).data('reference-number');

                                                                    if (proofOfPayment) {
                                                                        $('#modal-proofof-payment').attr('src', proofOfPayment).parent().show();
                                                                    } else {
                                                                        $('#modal-proofof-payment').parent().hide();
                                                                    }

                                                                    if (referenceNumber) {
                                                                        $('#modal-reference-number').text(referenceNumber).parent().show();
                                                                    } else {
                                                                        $('#modal-reference-number').parent().hide();
                                                                    }
                                                                });
                                                            } else {
                                                                $('#upcoming-reservations').html('<tr><td colspan="5">No upcoming reservations found.</td></tr>');
                                                            }
                                                        },
                                                        error: function() {
                                                            $('#upcoming-reservations').html('<tr><td colspan="5">An error occurred while fetching upcoming reservations.</td></tr>');
                                                        }
                                                    });
                                                }

                                                // Fetch upcoming reservations on page load
                                                fetchUpcomingReservations();
                                            });
                                        </script>

                                        <!-- Confirmation Modal for Approval -->
                                        <div class="modal fade" id="confirmationUpcomingModal" tabindex="-1" aria-labelledby="confirmationUpcomingModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="confirmationUpcomingModalLabel">Confirm Approval</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Please check the companions if they are all present here.
                                                        <form id="approveForm" class="mt-3">
                                                            <div id="attendeeInfoContainer"></div>
                                                            <button type="button" class="btn btn-primary" id="addAttendee"><i class="bi bi-plus-lg"></i> Add Attendee</button>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-success" id="confirmOngoing">Approve</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Ongoing -->
                                        <div class="tab-pane fade" id="pills-ongoing" role="tabpanel" aria-labelledby="pills-ongoing-tab" tabindex="0">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="ongoingReservationsTable">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Room Name</th>
                                                            <th scope="col">Time In</th>
                                                            <th scope="col">Time Out</th>
                                                            <th scope="col">Action</th>
                                                            <th scope="col">Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="ongoing-reservations">
                                                        <!-- Data will be populated here by JavaScript -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!-- Confirmation Modal -->
                                        <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="confirmationModalLabel">Confirm Action</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to mark this reservation as complete?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-success" id="confirmComplete">Yes, Complete</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            $(document).ready(function() {
                                                const notyf = new Notyf({
                                                    duration: 5000,
                                                    position: {
                                                        x: 'right',
                                                        y: 'top'
                                                    }
                                                });

                                                function fetchOngoingReservations() {
                                                    $.ajax({
                                                        url: '../../backends/subadmin/fetch_ongoing_reservations.php', // Update the path as needed
                                                        method: 'GET',
                                                        dataType: 'json',
                                                        success: function(response) {
                                                            if (response.status === 'success') {
                                                                let reservations = response.ongoing;
                                                                let tbody = $('#ongoing-reservations');
                                                                tbody.empty(); // Clear existing rows

                                                                reservations.forEach(function(reservation) {
                                                                    let checkin = new Date(reservation.checkin);
                                                                    let formattedCheckin = checkin.toLocaleString('en-US', {
                                                                        hour: 'numeric',
                                                                        minute: 'numeric',
                                                                        hour12: true
                                                                    }) + ' ' + checkin.toLocaleString('en-US', {
                                                                        month: 'long',
                                                                        day: 'numeric',
                                                                        year: 'numeric'
                                                                    });

                                                                    let departure = new Date(reservation.departure);
                                                                    let formattedDeparture = departure.toLocaleString('en-US', {
                                                                        hour: 'numeric',
                                                                        minute: 'numeric',
                                                                        hour12: true
                                                                    }) + ' ' + departure.toLocaleString('en-US', {
                                                                        month: 'long',
                                                                        day: 'numeric',
                                                                        year: 'numeric'
                                                                    });

                                                                    let row = `
                                <tr>
                                    <td>${reservation.roomName}</td>
                                    <td>${formattedCheckin}</td>
                                    <td>${formattedDeparture}</td>
                                    <td>
                                        <button class="btn btn-primary m-1 view-details" data-bs-toggle="modal" data-bs-target="#viewroom"
                                            data-name="${reservation.customerName}"
                                            data-address="${reservation.address}"
                                            data-contact="${reservation.contactNumber}"
                                            data-id-type="${reservation.id_type}"
                                            data-front-id="${reservation.front_id}"
                                            data-back-id="${reservation.back_id}"
                                            data-total-attendees="${reservation.totalnumAttendees}"
                                            data-total-male="${reservation.totalmale}"
                                            data-total-female="${reservation.totalfemale}"
                                            data-this-city="${reservation.thisCity}"
                                            data-other-city="${reservation.otherCity}"
                                            data-other-province="${reservation.otherProvince}"
                                            data-foreign-country="${reservation.foreignCountry}"
                                            data-attendee-names="${reservation.attendeeNames}"
                                            data-attendee-sexes="${reservation.attendeeSexes}"
                                            data-attendee-locations="${reservation.attendeeLocations}"
                                            data-proof-of-payment="${reservation.proofOfPayment}"
                                            data-reference-number="${reservation.gcashReference}"
                                        ><i class="bi bi-eye"></i></button>
                                        <button class="btn btn-success m-1 ongoing-reservation" data-revid="${reservation.revID}" data-total-attendees="${reservation.totalnumAttendees}" data-attendee-names="${reservation.attendeeNames}" data-attendee-sexes="${reservation.attendeeSexes}" data-attendee-locations="${reservation.attendeeLocations}"><i class="bi bi-check-lg"></i></button>
                                    </td>
                                    <td>${reservation.status}</td>
                                </tr>
                            `;
                                                                    tbody.append(row);
                                                                });

                                                                // Initialize DataTable
                                                                $('#ongoingReservationsTable').DataTable();

                                                                // Add event listener for view details buttons
                                                                $('.view-details').on('click', function() {
                                                                    $('#modal-name').text($(this).data('name'));
                                                                    $('#modal-address').text($(this).data('address'));
                                                                    $('#modal-contact').text($(this).data('contact'));
                                                                    $('#modal-id-type').text($(this).data('id-type'));
                                                                    $('#modal-front-id').attr('src', $(this).data('front-id'));

                                                                    let backId = $(this).data('back-id');
                                                                    if (backId) {
                                                                        $('#modal-back-id').attr('src', backId).parent().show();
                                                                    } else {
                                                                        $('#modal-back-id').parent().hide();
                                                                    }

                                                                    // Set user demographics
                                                                    $('#modal-total-attendees').text($(this).data('total-attendees'));
                                                                    $('#modal-total-male').text($(this).data('total-male'));
                                                                    $('#modal-total-female').text($(this).data('total-female'));
                                                                    $('#modal-this-city').text($(this).data('this-city'));
                                                                    $('#modal-other-city').text($(this).data('other-city'));
                                                                    $('#modal-other-province').text($(this).data('other-province'));
                                                                    $('#modal-foreign-country').text($(this).data('foreign-country'));

                                                                    // Populate the information table
                                                                    let attendeeNames = $(this).data('attendee-names').split(',').map(name => name.trim());
                                                                    let attendeeSexes = $(this).data('attendee-sexes').split(',').map(sex => sex.trim());
                                                                    let attendeeLocations = $(this).data('attendee-locations').split(',').map(location => location.trim());

                                                                    let infoTableBody = $('#viewroom tbody');
                                                                    infoTableBody.empty(); // Clear existing rows

                                                                    for (let i = 0; i < attendeeNames.length; i++) {
                                                                        let row = `
                                    <tr>
                                        <td>${attendeeNames[i]}</td>
                                        <td>${attendeeSexes[i]}</td>
                                        <td>${attendeeLocations[i]}</td>
                                    </tr>
                                `;
                                                                        infoTableBody.append(row);
                                                                    }

                                                                    // Set proof of payment and reference number
                                                                    let proofOfPayment = $(this).data('proof-of-payment');
                                                                    let referenceNumber = $(this).data('reference-number');

                                                                    if (proofOfPayment) {
                                                                        $('#modal-proofof-payment').attr('src', proofOfPayment).parent().show();
                                                                    } else {
                                                                        $('#modal-proofof-payment').parent().hide();
                                                                    }

                                                                    if (referenceNumber) {
                                                                        $('#modal-reference-number').text(referenceNumber).parent().show();
                                                                    } else {
                                                                        $('#modal-reference-number').parent().hide();
                                                                    }
                                                                });

                                                                // Add event listener for ongoing-reservation buttons
                                                                $('.ongoing-reservation').on('click', function() {
                                                                    let revID = $(this).data('revid');
                                                                    $('#confirmationModal').data('revid', revID).modal('show');
                                                                });

                                                                // Confirm complete action
                                                                $('#confirmComplete').on('click', function() {
                                                                    let revID = $('#confirmationModal').data('revid');
                                                                    $.ajax({
                                                                        url: '../../backends/subadmin/reservationdone.php', // Update the path as needed
                                                                        method: 'POST',
                                                                        contentType: 'application/json',
                                                                        data: JSON.stringify({
                                                                            revID: revID
                                                                        }),
                                                                        dataType: 'json',
                                                                        success: function(response) {
                                                                            if (response.status === 'success') {
                                                                                fetchOngoingReservations(); // Refresh the list
                                                                                $('#confirmationModal').modal('hide');
                                                                                notyf.success('Reservation status updated to Complete.');
                                                                            } else {
                                                                                notyf.error(response.message);
                                                                            }
                                                                        },
                                                                        error: function() {
                                                                            notyf.error('An error occurred while updating the reservation status.');
                                                                            $('#confirmationModal').modal('hide');
                                                                        }
                                                                    });
                                                                });
                                                            } else {
                                                                $('#ongoing-reservations').html('<tr><td colspan="5">No ongoing reservations found.</td></tr>');
                                                            }
                                                        },
                                                        error: function() {
                                                            $('#ongoing-reservations').html('<tr><td colspan="5">An error occurred while fetching ongoing reservations.</td></tr>');
                                                        }
                                                    });
                                                }

                                                // Fetch ongoing reservations on page load
                                                fetchOngoingReservations();
                                            });
                                        </script>



                                        <!-- archived -->
                                        <div class="tab-pane fade" id="pills-archive" role="tabpanel" aria-labelledby="pills-archive-tab" tabindex="0">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="archivedReservationsTable">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Room Name</th>
                                                            <th scope="col">Time Booked</th>
                                                            <th scope="col">Time In</th>
                                                            <th scope="col">Time Out</th>
                                                            <th scope="col">Customer Name</th>
                                                            <th scope="col">Action</th>
                                                            <th scope="col">Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="archived-reservations">
                                                        <!-- Data will be populated here by JavaScript -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <script>
                                            function fetchArchivedReservations() {
                                                $.ajax({
                                                    url: '../../backends/subadmin/fetch_archived_reservations.php', // Update the path as needed
                                                    method: 'GET',
                                                    dataType: 'json',
                                                    success: function(response) {
                                                        if (response.status === 'success') {
                                                            let reservations = response.archived;
                                                            let tbody = $('#archived-reservations');
                                                            tbody.empty(); // Clear existing rows

                                                            reservations.forEach(function(reservation) {
                                                                let timeBooked = new Date(reservation.timeBooked);
                                                                let formattedTimeBooked = timeBooked.toLocaleString('en-US', {
                                                                    hour: 'numeric',
                                                                    minute: 'numeric',
                                                                    hour12: true
                                                                }) + ' ' + timeBooked.toLocaleString('en-US', {
                                                                    month: 'long',
                                                                    day: 'numeric',
                                                                    year: 'numeric'
                                                                });

                                                                let checkin = new Date(reservation.checkin);
                                                                let formattedCheckin = checkin.toLocaleString('en-US', {
                                                                    hour: 'numeric',
                                                                    minute: 'numeric',
                                                                    hour12: true
                                                                }) + ' ' + checkin.toLocaleString('en-US', {
                                                                    month: 'long',
                                                                    day: 'numeric',
                                                                    year: 'numeric'
                                                                });

                                                                let departure = new Date(reservation.departure);
                                                                let formattedDeparture = departure.toLocaleString('en-US', {
                                                                    hour: 'numeric',
                                                                    minute: 'numeric',
                                                                    hour12: true
                                                                }) + ' ' + departure.toLocaleString('en-US', {
                                                                    month: 'long',
                                                                    day: 'numeric',
                                                                    year: 'numeric'
                                                                });

                                                                let row = `
                            <tr>
                                <td>${reservation.roomName}</td>
                                <td>${formattedTimeBooked}</td>
                                <td>${formattedCheckin}</td>
                                <td>${formattedDeparture}</td>
                                <td>${reservation.customerName}</td>
                                <td>
                                    <button class="btn btn-primary m-1 view-details" data-bs-toggle="modal" data-bs-target="#viewroom"
                                        data-name="${reservation.customerName}"
                                        data-address="${reservation.address}"
                                        data-contact="${reservation.contactNumber}"
                                        data-id-type="${reservation.id_type}"
                                        data-front-id="${reservation.front_id}"
                                        data-back-id="${reservation.back_id}"
                                        data-total-attendees="${reservation.totalnumAttendees}"
                                        data-total-male="${reservation.totalmale}"
                                        data-total-female="${reservation.totalfemale}"
                                        data-this-city="${reservation.thisCity}"
                                        data-other-city="${reservation.otherCity}"
                                        data-other-province="${reservation.otherProvince}"
                                        data-foreign-country="${reservation.foreignCountry}"
                                        data-attendee-names="${reservation.attendeeNames}"
                                        data-attendee-sexes="${reservation.attendeeSexes}"
                                        data-attendee-locations="${reservation.attendeeLocations}"
                                        data-proof-of-payment="${reservation.proofOfPayment}"
                                        data-reference-number="${reservation.gcashReference}"
                                    ><i class="bi bi-eye"></i></button>
                                </td>
                                <td>${reservation.status}</td>
                            </tr>
                        `;
                                                                tbody.append(row);
                                                            });

                                                            // Initialize DataTable
                                                            $('#archivedReservationsTable').DataTable();

                                                            // Add event listener for view details buttons
                                                            $('.view-details').on('click', function() {
                                                                $('#modal-name').text($(this).data('name'));
                                                                $('#modal-address').text($(this).data('address'));
                                                                $('#modal-contact').text($(this).data('contact'));
                                                                $('#modal-id-type').text($(this).data('id-type'));
                                                                $('#modal-front-id').attr('src', $(this).data('front-id'));

                                                                let backId = $(this).data('back-id');
                                                                if (backId) {
                                                                    $('#modal-back-id').attr('src', backId).parent().show();
                                                                } else {
                                                                    $('#modal-back-id').parent().hide();
                                                                }

                                                                // Set user demographics
                                                                $('#modal-total-attendees').text($(this).data('total-attendees'));
                                                                $('#modal-total-male').text($(this).data('total-male'));
                                                                $('#modal-total-female').text($(this).data('total-female'));
                                                                $('#modal-this-city').text($(this).data('this-city'));
                                                                $('#modal-other-city').text($(this).data('other-city'));
                                                                $('#modal-other-province').text($(this).data('other-province'));
                                                                $('#modal-foreign-country').text($(this).data('foreign-country'));

                                                                // Populate the information table
                                                                let attendeeNames = $(this).data('attendee-names').split(',');
                                                                let attendeeSexes = $(this).data('attendee-sexes').split(',');
                                                                let attendeeLocations = $(this).data('attendee-locations').split(',');

                                                                let infoTableBody = $('#viewroom tbody');
                                                                infoTableBody.empty(); // Clear existing rows

                                                                for (let i = 0; i < attendeeNames.length; i++) {
                                                                    let row = `
                                <tr>
                                    <td>${attendeeNames[i]}</td>
                                    <td>${attendeeSexes[i]}</td>
                                    <td>${attendeeLocations[i]}</td>
                                </tr>
                            `;
                                                                    infoTableBody.append(row);
                                                                }

                                                                // Set proof of payment and reference number
                                                                let proofOfPayment = $(this).data('proof-of-payment');
                                                                let referenceNumber = $(this).data('reference-number');

                                                                if (proofOfPayment) {
                                                                    $('#modal-proofof-payment').attr('src', proofOfPayment).parent().show();
                                                                } else {
                                                                    $('#modal-proofof-payment').parent().hide();
                                                                }

                                                                if (referenceNumber) {
                                                                    $('#modal-reference-number').text(referenceNumber).parent().show();
                                                                } else {
                                                                    $('#modal-reference-number').parent().hide();
                                                                }
                                                            });
                                                        } else {
                                                            $('#archived-reservations').html('<tr><td colspan="7">No archived reservations found.</td></tr>');
                                                        }
                                                    },
                                                    error: function() {
                                                        $('#archived-reservations').html('<tr><td colspan="7">An error occurred while fetching archived reservations.</td></tr>');
                                                    }
                                                });
                                            }

                                            // Fetch archived reservations on page load
                                            fetchArchivedReservations();
                                        </script>


                                        <!-- cancel -->
                                        <div class="tab-pane fade" id="pills-cancel" role="tabpanel" aria-labelledby="pills-cancel-tab" tabindex="0">
                                            <div class="table-responsive">
                                                <table class="table table-striped" id="canceledReservationsTable">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Time Booked</th>
                                                            <th scope="col">Room Name</th>
                                                            <th scope="col">Customer Name</th>
                                                            <th scope="col">Reason</th>
                                                            <th scope="col">Action</th>
                                                            <th scope="col">Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="canceled-reservations">
                                                        <!-- Canceled reservations will be populated here by JavaScript -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <script>
                                            $(document).ready(function() {
                                                function fetchCanceledReservations() {
                                                    $.ajax({
                                                        url: '../../backends/subadmin/fetch_canceled_reservations.php', // Update the path as needed
                                                        method: 'GET',
                                                        dataType: 'json',
                                                        success: function(response) {
                                                            if (response.status === 'success') {
                                                                let reservations = response.data;
                                                                let tbody = $('#canceled-reservations');
                                                                tbody.empty(); // Clear existing rows

                                                                if (reservations.length === 0) {
                                                                    tbody.html('<tr><td colspan="7">No cancel reservations found.</td></tr>');
                                                                } else {
                                                                    reservations.forEach(function(reservation) {
                                                                        let timeBooked = new Date(reservation.timeBooked);
                                                                        let formattedTimeBooked = timeBooked.toLocaleString('en-US', {
                                                                            hour: 'numeric',
                                                                            minute: 'numeric',
                                                                            hour12: true
                                                                        }) + ' ' + timeBooked.toLocaleString('en-US', {
                                                                            month: 'long',
                                                                            day: 'numeric',
                                                                            year: 'numeric'
                                                                        });

                                                                        let row = `
                                <tr>
                                    <td>${formattedTimeBooked}</td>
                                    <td>${reservation.roomName}</td>
                                    <td>${reservation.customerName}</td>
                                    <td>${reservation.reasonCancel}</td>
                                    <td>
                                        <button class="btn btn-primary m-1 view-details" data-bs-toggle="modal" data-bs-target="#viewroom"
                                            data-name="${reservation.customerName}"
                                            data-address="${reservation.address}"
                                            data-contact="${reservation.contactNumber}"
                                            data-id-type="${reservation.id_type}"
                                            data-front-id="${reservation.front_id}"
                                            data-back-id="${reservation.back_id}"
                                            data-total-attendees="${reservation.totalnumAttendees}"
                                            data-total-male="${reservation.totalmale}"
                                            data-total-female="${reservation.totalfemale}"
                                            data-this-city="${reservation.thisCity}"
                                            data-other-city="${reservation.otherCity}"
                                            data-other-province="${reservation.otherProvince}"
                                            data-foreign-country="${reservation.foreignCountry}"
                                            data-attendee-names="${reservation.attendeeNames}"
                                            data-attendee-sexes="${reservation.attendeeSexes}"
                                            data-attendee-locations="${reservation.attendeeLocations}"
                                            data-proof-of-payment="${reservation.proofOfPayment}"
                                            data-reference-number="${reservation.gcashReference}"
                                        ><i class="bi bi-eye"></i></button>
                                    </td>
                                    <td>${reservation.status}</td>
                                </tr>
                            `;
                                                                        tbody.append(row);
                                                                    });

                                                                    // Initialize DataTable
                                                                    $('#canceledReservationsTable').DataTable();

                                                                    // Add event listener for view details buttons
                                                                    $('.view-details').on('click', function() {
                                                                        $('#modal-name').text($(this).data('name'));
                                                                        $('#modal-address').text($(this).data('address'));
                                                                        $('#modal-contact').text($(this).data('contact'));
                                                                        $('#modal-id-type').text($(this).data('id-type'));
                                                                        $('#modal-front-id').attr('src', $(this).data('front-id'));

                                                                        let backId = $(this).data('back-id');
                                                                        if (backId) {
                                                                            $('#modal-back-id').attr('src', backId).parent().show();
                                                                        } else {
                                                                            $('#modal-back-id').parent().hide();
                                                                        }

                                                                        // Set user demographics
                                                                        $('#modal-total-attendees').text($(this).data('total-attendees'));
                                                                        $('#modal-total-male').text($(this).data('total-male'));
                                                                        $('#modal-total-female').text($(this).data('total-female'));
                                                                        $('#modal-this-city').text($(this).data('this-city'));
                                                                        $('#modal-other-city').text($(this).data('other-city'));
                                                                        $('#modal-other-province').text($(this).data('other-province'));
                                                                        $('#modal-foreign-country').text($(this).data('foreign-country'));

                                                                        // Populate the information table
                                                                        let attendeeNames = $(this).data('attendee-names').split(',');
                                                                        let attendeeSexes = $(this).data('attendee-sexes').split(',');
                                                                        let attendeeLocations = $(this).data('attendee-locations').split(',');

                                                                        let infoTableBody = $('#viewroom tbody');
                                                                        infoTableBody.empty(); // Clear existing rows

                                                                        for (let i = 0; i < attendeeNames.length; i++) {
                                                                            let row = `
                                    <tr>
                                        <td>${attendeeNames[i]}</td>
                                        <td>${attendeeSexes[i]}</td>
                                        <td>${attendeeLocations[i]}</td>
                                    </tr>
                                `;
                                                                            infoTableBody.append(row);
                                                                        }

                                                                        // Set proof of payment and reference number
                                                                        let proofOfPayment = $(this).data('proof-of-payment');
                                                                        let referenceNumber = $(this).data('reference-number');

                                                                        if (proofOfPayment) {
                                                                            $('#modal-proofof-payment').attr('src', proofOfPayment).parent().show();
                                                                        } else {
                                                                            $('#modal-proofof-payment').parent().hide();
                                                                        }

                                                                        if (referenceNumber) {
                                                                            $('#modal-reference-number').text(referenceNumber).parent().show();
                                                                        } else {
                                                                            $('#modal-reference-number').parent().hide();
                                                                        }
                                                                    });
                                                                }
                                                            } else {
                                                                $('#canceled-reservations').html('<tr><td colspan="7">No cancel reservations found.</td></tr>');
                                                            }
                                                        },
                                                        error: function() {
                                                            console.error('An error occurred while fetching canceled reservations.');
                                                        }
                                                    });
                                                }

                                                // Fetch canceled reservations on page load
                                                fetchCanceledReservations();
                                            });
                                        </script>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/businessowner.js"></script>
</body>

</html>