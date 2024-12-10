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
                                                <table class="table table-striped">
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
                                        <script>
                                            $(document).ready(function() {
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
                                    <button class="btn btn-success m-1"><i class="bi bi-check-lg"></i></button>
                                    <button class="btn btn-danger m-1"><i class="bi bi-close-lg"></i></button>
                                </td>
                                <td>New</td>
                            </tr>
                        `;
                                                                    tbody.append(row);
                                                                });

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
                                                <table class="table table-striped">
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


                                        <!-- Ongoing -->
                                        <div class="tab-pane fade" id="pills-ongoing" role="tabpanel" aria-labelledby="pills-ongoing-tab" tabindex="0">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Room Name</th>
                                                            <th scope="col">Time In</th>
                                                            <th scope="col">Time Out</th>
                                                            <th scope="col">Customer Name</th>
                                                            <th scope="col">Action</th>
                                                            <th scope="col">Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Room 5</td>
                                                            <td>01:00PM 11/26/24</td>
                                                            <td>01:00PM 11/28/24</td>
                                                            <td>John Angel Manalo</td>
                                                            <th>

                                                                <button class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#viewroom"><i class="bi bi-eye"></i></button>
                                                                <button class="btn btn-success m-1"><i class="bi bi-check-lg"></i></button>
                                                            </th>
                                                            <td>New</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- archived -->
                                        <div class="tab-pane fade" id="pills-archive" role="tabpanel" aria-labelledby="pills-archive-tab" tabindex="0">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Time Booked</th>
                                                            <th scope="col">Room Name</th>
                                                            <th scope="col">Customer Name</th>
                                                            <th scope="col">Action</th>
                                                            <th scope="col">Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>11:23AM 11/23/24</td>
                                                            <td>Room 5</td>
                                                            <td>John Angel Manalo</td>
                                                            <th>
                                                                <button class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#viewroom"><i class="bi bi-eye"></i></button>
                                                                <button class="btn btn-danger m-1"><i class="bi bi-x-lg"></i></button>
                                                            </th>
                                                            <td>New</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- cancel -->
                                        <div class="tab-pane fade" id="pills-cancel" role="tabpanel" aria-labelledby="pills-cancel-tab" tabindex="0">
                                            <div class="table-responsive">
                                                <table class="table table-striped">
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
                                                    <tbody>
                                                        <tr>

                                                            <td>11:23AM 11/23/24</td>
                                                            <td>Room 5</td>
                                                            <td>John Angel Manalo</td>
                                                            <td>emergency</td>
                                                            <th>
                                                                <button class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#viewroom"><i class="bi bi-eye"></i></button>
                                                                <button class="btn btn-danger m-1"><i class="bi bi-x-lg"></i></button>
                                                            </th>
                                                            <td>New</td>
                                                        </tr>
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