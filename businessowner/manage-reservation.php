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
                                                        <!-- Data will be populated here by JavaScript -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- view modal -->
                                        <div class="modal fade" id="viewroom" tabindex="-1" aria-labelledby="viewroomLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="viewroomLabel">Reservation Details</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Reservation details will be populated here by JavaScript -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <script>
                                            // Define notyf globally
                                            const notyf = new Notyf({
                                                duration: 3000,
                                                position: {
                                                    x: 'right',
                                                    y: 'top'
                                                }
                                            });

                                            document.addEventListener('DOMContentLoaded', function() {
                                                fetchReservations();
                                            });

                                            function fetchReservations() {
                                                fetch('../../backends/subadmin/fetch_new_reservations.php')
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        if (data.status === 'success') {
                                                            const reservations = data.data;
                                                            const tbody = document.getElementById('new-reservations');
                                                            tbody.innerHTML = '';

                                                            reservations.forEach(reservation => {
                                                                const tr = document.createElement('tr');
                                                                tr.innerHTML = `
                            <td>${formatDateTime(reservation.datetime)}</td>
                            <td>${reservation.roomName}</td>
                            <td>${reservation.fullname}</td>
                            <th>
                                <button class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#viewroom" onclick="fetchReservationDetails(${reservation.revID})"><i class="bi bi-eye"></i></button>
                                <button class="btn btn-success m-1" onclick="showConfirmationModal(${reservation.revID})"><i class="bi bi-check-lg"></i></button>
                                <button class="btn btn-danger m-1"><i class="bi bi-x-lg"></i></button>
                            </th>
                        `;
                                                                tbody.appendChild(tr);
                                                            });
                                                        } else {
                                                            console.error(data.message);
                                                        }
                                                    })
                                                    .catch(error => console.error('Error fetching reservations:', error));
                                            }

                                            function fetchReservationDetails(revID) {
                                                console.log(`Fetching details for reservation ID: ${revID}`);
                                                fetch(`../../backends/subadmin/fetch_reservation_details.php?revID=${revID}`)
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        console.log(data); // Log the response data
                                                        if (data.status === 'success') {
                                                            const reservation = data.data;
                                                            document.querySelector('#viewroom .modal-body').innerHTML = `
                        <p class="mt-2 fs-6 fw-bold text-center">Customer Profile</p>
                        <ul>
                            <li>Customer Name: ${reservation.fullname}</li>
                            <li>Contact Number: ${reservation.regnum}</li>
                            <li>Email: ${reservation.regemail}</li>
                            <li>Address: ${reservation.regadd}</li>
                        </ul>
                        <p class="mt-2 fs-6 fw-bold text-center">Reservation Information</p>
                        <ul>
                            <li>Room name: ${reservation.roomName}</li>
                            <li>Check In: ${reservation.checkin}</li>
                            <li>Check Out: ${reservation.departure}</li>
                        </ul>
                        <div class="row">
                            <div class="col-md-12 mb-2 text-center">
                                <p>Total visitors: ${parseInt(reservation.numadult, 10) + parseInt(reservation.numchild, 10)}</p>
                            </div>
                            <div class="row text-center">
                                <div class="col-md-6 mb-2">
                                    <p>Males: ${reservation.nummale}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p>Females: ${reservation.numfemale}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p>Adults: ${reservation.numadult}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p>Children: ${reservation.numchild}</p>
                                </div>
                            </div>
                        </div>
                    `;
                                                        } else {
                                                            console.error(data.message);
                                                        }
                                                    })
                                                    .catch(error => console.error('Error fetching reservation details:', error));
                                            }

                                            function showConfirmationModal(revID) {
                                                const confirmButton = document.getElementById('confirmButton');
                                                confirmButton.onclick = function() {
                                                    updateReservationStatus(revID, 'Accepted');
                                                };
                                                const confirmationModal = new bootstrap.Modal(document.getElementById('reservationConfirmationModal'));
                                                confirmationModal.show();
                                            }

                                            function updateReservationStatus(revID, status) {
                                                fetch(`../../backends/subadmin/update_reservation_status.php`, {
                                                        method: 'POST',
                                                        headers: {
                                                            'Content-Type': 'application/json'
                                                        },
                                                        body: JSON.stringify({
                                                            revID,
                                                            status
                                                        })
                                                    })
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        if (data.status === 'success') {
                                                            console.log(data.status);
                                                            const confirmationModal = bootstrap.Modal.getInstance(document.getElementById('reservationConfirmationModal'));
                                                            notyf.success('Reservation status updated successfully.');
                                                            confirmationModal.hide();
                                                            setTimeout(() => {
                                                                location.reload(); // Refresh the page
                                                            }, 1000);
                                                        } else {
                                                            console.error(data.message);
                                                            notyf.error('Failed to update reservation status.');
                                                        }
                                                    })
                                                    .catch(error => {
                                                        console.error('Error updating reservation status:', error);
                                                        notyf.error('An error occurred while updating reservation status.');
                                                    });
                                            }

                                            function formatDateTime(datetime) {
                                                const date = new Date(datetime);
                                                const options = {
                                                    hour: '2-digit',
                                                    minute: '2-digit',
                                                    hour12: true
                                                };
                                                const time = date.toLocaleTimeString('en-US', options);
                                                const formattedDate = `${time} ${date.getMonth() + 1}/${date.getDate()}/${date.getFullYear().toString().slice(-2)}`;
                                                return formattedDate;
                                            }
                                        </script>
                                        <!-- Confirmation Modal -->
                                        <div class="modal fade" id="reservationConfirmationModal" tabindex="-1" aria-labelledby="reservationConfirmationModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="reservationConfirmationModalLabel">Confirm Reservation</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to accept this reservation?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="button" class="btn btn-success" id="confirmButton">Confirm</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Confirmation Modal -->

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
                                        <script>
                                            document.addEventListener('DOMContentLoaded', function() {
                                                fetchUpcomingReservations();
                                            });

                                            function fetchUpcomingReservations() {
                                                fetch('../../backends/subadmin/fetch_upcoming_reservations.php')
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        if (data.status === 'success') {
                                                            const reservations = data.data;
                                                            const tbody = document.getElementById('upcoming-reservations');
                                                            tbody.innerHTML = '';

                                                            reservations.forEach(reservation => {
                                                                const tr = document.createElement('tr');
                                                                tr.innerHTML = `
                            <td>${formatDateTime(reservation.datetime)}</td>
                            <td>${reservation.roomName}</td>
                            <td>${reservation.fullname}</td>
                            <th>
                                <button class="btn btn-primary m-1" data-bs-toggle="modal" data-bs-target="#viewroom" onclick="fetchReservationDetails(${reservation.revID})"><i class="bi bi-eye"></i></button>
                                <button class="btn btn-success m-1"><i class="bi bi-check-lg"></i></button>
                                <button class="btn btn-danger m-1"><i class="bi bi-x-lg"></i></button>
                            </th>
                        `;
                                                                tbody.appendChild(tr);
                                                            });
                                                        } else {
                                                            console.error(data.message);
                                                        }
                                                    })
                                                    .catch(error => console.error('Error fetching reservations:', error));
                                            }

                                            function fetchReservationDetails(revID) {
                                                console.log(`Fetching details for reservation ID: ${revID}`);
                                                fetch(`../../backends/subadmin/fetch_reservation_details.php?revID=${revID}`)
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        console.log(data); // Log the response data
                                                        if (data.status === 'success') {
                                                            const reservation = data.data;
                                                            document.querySelector('#viewroom .modal-body').innerHTML = `
                        <p class="mt-2 fs-6 fw-bold text-center">Customer Profile</p>
                        <ul>
                            <li>Customer Name: ${reservation.fullname}</li>
                            <li>Contact Number: ${reservation.regnum}</li>
                            <li>Email: ${reservation.regemail}</li>
                            <li>Address: ${reservation.regadd}</li>
                        </ul>
                        <p class="mt-2 fs-6 fw-bold text-center">Reservation Information</p>
                        <ul>
                            <li>Room name: ${reservation.roomName}</li>
                            <li>Check In: ${reservation.checkin}</li>
                            <li>Check Out: ${reservation.departure}</li>
                        </ul>
                        <div class="row">
                            <div class="col-md-12 mb-2 text-center">
                                <p>Total visitors: ${parseInt(reservation.numadult, 10) + parseInt(reservation.numchild, 10)}</p>
                            </div>
                            <div class="row text-center">
                                <div class="col-md-6 mb-2">
                                    <p>Males: ${reservation.nummale}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p>Females: ${reservation.numfemale}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p>Adults: ${reservation.numadult}</p>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <p>Children: ${reservation.numchild}</p>
                                </div>
                            </div>
                        </div>
                    `;
                                                        } else {
                                                            console.error(data.message);
                                                        }
                                                    })
                                                    .catch(error => console.error('Error fetching reservation details:', error));
                                            }
                                        </script>

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