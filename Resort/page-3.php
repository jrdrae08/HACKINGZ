<?php
// page-3.php
include '../includes/db.php';

// Get the roomID and businessInfoID from the URL, defaulting to 1 if not set
$businessInfoID = isset($_GET['businessInfoID']) ? (int) $_GET['businessInfoID'] : 1;
$roomID = isset($_GET['roomID']) ? (int) $_GET['roomID'] : 1;

try {
    // Query to fetch room information based on roomID
    $stmt = $pdo->prepare("
        SELECT roomID, roomName, roomPrice, adultMax, ChildrenMax, RoomDescriptions, image1, image2, image3, image4, image5, image6, BusinessInfoID
        FROM roominfotable
        WHERE roomID = :roomID
    ");
    $stmt->execute(['roomID' => $roomID]);
    $room = $stmt->fetch(PDO::FETCH_ASSOC);

    // Query to fetch business information based on BusinessInfoID
    $stmt = $pdo->prepare("
        SELECT BusinessName, BusinessAddress, BusinessEmail, BusinessContactNumber
        FROM businessinformationform
        WHERE BusinessInfoID = :businessInfoID
    ");
    $stmt->execute(['businessInfoID' => $room['BusinessInfoID']]);
    $businessInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    // Query to fetch rooms based on businessInfoID and filter out the room with the specific roomID
    $stmt = $pdo->prepare("
        SELECT roomID, roomName, roomPrice, RoomDescriptions, image1
        FROM roominfotable
        WHERE BusinessInfoID = :businessInfoID AND roomID != :roomID
    ");
    $stmt->execute(['businessInfoID' => $businessInfoID, 'roomID' => $roomID]);
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Majayjay Website</title>
    <!-- External CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Jaro:opsz@6..72&family=Poetsen+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,800">
    <link rel="stylesheet" href="../../resort/new-resort-ui.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
    <!-- External JS -->

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>

    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
    <link rel="stylesheet" href="../../resort/new-resort-ui.css">
    <style>
        body {
            overflow-x: hidden;
            position: relative;
            /* width: 100%;
            height: 100vh; */
            background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.5)), url('../../businessowner/businessmediacategory/<?php echo htmlspecialchars($room['image1']); ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        .booked {
            background-color: green !important;
            color: white !important;
        }

        /* Progress Bar Custom Style */
        .progress {
            height: 20px;
            background-color: #f0f0f0;
            border-radius: 15px;
            overflow: hidden;
        }

        .progress-bar {
            font-size: 14px;
            font-weight: bold;
            line-height: 30px;
            background-color: var(--bs-success);
            color: #fff;
            transition: width 0.5s ease;
        }

        .progress-bar span {
            display: inline-block;
            width: 100%;
            text-align: center;
        }

        /* Style for the overlay */
        .image-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1050;
        }

        /* Style for the enlarged image */
        .image-overlay img {
            max-width: 95%;
            /* Make image responsive */
            max-height: 95%;
            /* Ensure image does not exceed the viewport */
            object-fit: contain;
            /* Ensure aspect ratio is maintained */
        }

        /* Media Query for Small Devices (Mobile) */
        @media (max-width: 576px) {
            .image-overlay img {
                max-width: 100%;
                /* Full width on small devices */
                max-height: 90%;
                /* Slightly smaller on small screens */
            }
        }

        /* Media Query for Medium Devices (Tablets) */
        @media (max-width: 768px) {
            .image-overlay img {
                max-width: 90%;
                /* Adjust image size on tablets */
                max-height: 90%;
            }
        }

        /* Media Query for Larger Screens */
        @media (min-width: 992px) {
            .image-overlay img {
                max-width: 80%;
                /* Slightly larger image on larger screens */
                max-height: 80%;
            }
        }
    </style>
</head>

<body>
    <main class="content">
        <?php include '../homepage/includes/main-nav.php'; ?>

        <section class="first-page" id="first-page">
            <div class="container-fluid">
                <div class="row page-nav-select d-flex justify-content-between align-items-center">
                    <div class="col-2 py-3 d-flex justify-content-center align-items-center">
                        <a href="../../resort/page-1.php?businessInfoID=<?php echo urlencode($businessInfoID); ?><?php echo isset($_SESSION['user_id']) ? '&userID=' . urlencode($_SESSION['user_id']) : ''; ?>">
                            <i class="bi bi-arrow-left-circle fw-bold text-light fs-1 text-shadow-light"></i>
                        </a>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-10 py-3 align-items-center">
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-4 col-md-6 col-5 d-flex justify-content-center mb-3">
                                <a href="../../resort/page-2.php?businessInfoID=<?php echo urlencode($businessInfoID); ?><?php echo isset($_SESSION['user_id']) ? '&userID=' . urlencode($_SESSION['user_id']) : ''; ?>" class="page-nav active text-light rounded-0 cormorant-text fw-bold text-shadow-light">Accommodations</a>
                            </div>
                            <div class="col-lg-2 col-md-6 col-5 d-flex justify-content-center mb-3">
                                <a href="" class="page-nav text-light rounded-0 cormorant-text fw-bold text-shadow-light">Events</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="first-page-title pb-5">
                    <div class="row  d-flex justify-content-center">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <h1 class="page-title text-light text-center cormorant-text fw-bold "><?php echo htmlspecialchars($room['roomName']); ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-light rounded-top rounded-top-3" id="destination-information">
            <div class="container-fluid">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-10 col-lg-11 col-12 py-3">
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg- col-md-9 col-12">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="../../resort/page-0.php">Destinations</a></li>
                                        <li class="breadcrumb-item"><a href="../../resort/page-1.php?roomID=<?php echo $room['roomID']; ?>&businessInfoID=<?php echo $businessInfoID; ?>">(Resort Name)</a></li>
                                        <li class="breadcrumb-item active" aria-current="page"><?php echo htmlspecialchars($room['roomName']); ?></li>
                                    </ol>
                                </nav>
                            </div>

                            <div class="col-lg-9 col-12 mb-3">
                                <div class="card">
                                    <div class="card-body">

                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5 col-12">
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <div class="row d-flex justify-content-center">
                                            <div class="col-12 mb-3">
                                                <div class="row g-2 d-flex justify-content-start">
                                                    <div class="col-12"> <img src="<?php echo htmlspecialchars($room['image1']); ?>" class="img-fluid destinations-images" alt="" onclick="enlargeImage(this.src)"></div>
                                                    <div class="col-4"> <img src="<?php echo htmlspecialchars($room['image1']); ?>" class="img-fluid destinations-images" alt="" onclick="enlargeImage(this.src)"></div>
                                                    <div class="col-4"> <img src="<?php echo htmlspecialchars($room['image1']); ?>" class="img-fluid destinations-images" alt="" onclick="enlargeImage(this.src)"></div>
                                                    <div class="col-4"> <img src="<?php echo htmlspecialchars($room['image1']); ?>" class="img-fluid destinations-images" alt="" onclick="enlargeImage(this.src)"></div>
                                                    <div class="col-4"> <img src="<?php echo htmlspecialchars($room['image1']); ?>" class="img-fluid destinations-images" alt="" onclick="enlargeImage(this.src)"></div>
                                                    <div class="col-4"> <img src="<?php echo htmlspecialchars($room['image1']); ?>" class="img-fluid destinations-images" alt="" onclick="enlargeImage(this.src)"></div>
                                                    <div class="col-4"> <img src="<?php echo htmlspecialchars($room['image1']); ?>" class="img-fluid destinations-images" alt="" onclick="enlargeImage(this.src)"></div>
                                                </div>

                                                <!-- Overlay for Enlarged Image -->
                                                <div id="imageOverlay" class="image-overlay" style="display: none;">
                                                    <img id="overlayImage" src="" alt="Enlarged Image">
                                                </div>

                                                <script>
                                                    // Function to enlarge the image on click
                                                    function enlargeImage(imageSrc) {
                                                        document.getElementById('overlayImage').src = imageSrc;
                                                        document.getElementById('imageOverlay').style.display = 'flex'; // Use flex for centering
                                                    }

                                                    // Function to close the overlay when clicking outside the image
                                                    document.getElementById('imageOverlay').addEventListener('click', function(event) {
                                                        if (event.target === this) { // If the click is on the overlay itself (outside the image)
                                                            this.style.display = 'none'; // Close the overlay
                                                        }
                                                    });
                                                </script>
                                            </div>
                                            <h3 class="dm-sans-text fw-bold"><?php echo htmlspecialchars($room['roomName']); ?></h3>
                                            <h6 class="dm-sans-text fw-bold"><span>Price: </span> <span class="text-success"> &#8369 <?php echo number_format(htmlspecialchars($room['roomPrice']), 2, '.', ','); ?></span> /Night</h6>
                                            <p class="dm-sans-text"><span class="fw-bold">Max Adult: </span> </p>
                                            <p class="dm-sans-text"><span class="fw-bold">Max Children: </span> </p>
                                            <p class="dm-sans-text"><span class="fw-bold">Location:</span> <?php echo htmlspecialchars($businessInfo['BusinessAddress']); ?></p>
                                            <p class="dm-sans-text"><span class="fw-bold">Contact Number:</span> <?php echo htmlspecialchars($businessInfo['BusinessContactNumber']); ?></p>

                                            <hr>
                                            <div class="col-11 p-2 border rounded bg-secondary-subtle mb-2">
                                                <h6 class="dm-sans-text fw-bold">Highlights</h6>
                                                <div class="row g-2 d-flex justify-content-start">
                                                    <div class="col-lg-4 col-md-6">
                                                        <p class="dm-sans-text"><i class="bi bi-check-circle-fill  me-1 text-success"></i>Wi-fi</p>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6">
                                                        <p class="dm-sans-text"><i class="bi bi-check-circle-fill  me-1 text-success"></i>Television</p>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6">
                                                        <p class="dm-sans-text"><i class="bi bi-check-circle-fill  me-1 text-success"></i>King-sized Bed</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-11 p-2 border rounded bg-secondary-subtle mb-2">
                                                <h6 class="dm-sans-text fw-bold">Facilities</h6>
                                                <div class="row g-2 d-flex justify-content-start">
                                                    <div class="col-lg-4 col-md-6">
                                                        <p class="dm-sans-text"><i class="bi bi-check-circle-fill  me-1 text-success"></i>Wi-fi</p>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6">
                                                        <p class="dm-sans-text"><i class="bi bi-check-circle-fill  me-1 text-success"></i>Balcony</p>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6">
                                                        <p class="dm-sans-text"><i class="bi bi-check-circle-fill  me-1 text-success"></i>Kitchen</p>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6">
                                                        <p class="dm-sans-text"><i class="bi bi-check-circle-fill  me-1 text-success"></i>Pool</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-11 p-2 border rounded bg-secondary-subtle">
                                                <h6 class="dm-sans-text fw-bold">Policies</h6>
                                                <div class="row g-2 d-flex justify-content-start">
                                                    <div class="col-lg-4 col-md-6">
                                                        <p class="dm-sans-text"><i class="bi bi-x-circle-fill me-1 text-danger"></i>No Pets Allowed</p>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6">
                                                        <p class="dm-sans-text"><i class="bi bi-x-circle-fill me-1 text-danger"></i>No jumping in balcony</p>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6">
                                                        <p class="dm-sans-text"><i class="bi bi-x-circle-fill me-1 text-danger"></i>No Smoking</p>
                                                    </div>
                                                    <div class="col-lg-4 col-md-6">
                                                        <p class="dm-sans-text"><i class="bi bi-x-circle-fill me-1 text-danger"></i>No Swimming</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-7 mb-3">
                                <div class="row d-flex justify-content-center">
                                    <div class="col-11">

                                        <div class="row">
                                            <div class="col-12">
                                                <!-- Calendar -->
                                                <div class="card mb-3">
                                                    <div class="card-body">
                                                        <div class="text-center">
                                                            <h5 class="text-dark dm-sans-text fw-bold">Available Schedules</h5>
                                                            <p class="text-dark dm-sans-text">12:00 PM to 6:00 AM</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card mb-3">
                                                    <div class="card-body">
                                                        <div class="">
                                                            <h5 class="card-title dm-sans-text ">Check Available Dates</h5>
                                                            <div id="calendar"></div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <script>
                                                    document.addEventListener('DOMContentLoaded', function() {
                                                        var roomID = <?php echo $roomID; ?>;

                                                        fetch('../../backends/subadmin/fetch_booked_dates.php', {
                                                                method: 'POST',
                                                                headers: {
                                                                    'Content-Type': 'application/x-www-form-urlencoded'
                                                                },
                                                                body: new URLSearchParams({
                                                                    roomID: roomID
                                                                })
                                                            })
                                                            .then(response => response.json())
                                                            .then(data => {
                                                                var bookedDates = data.bookedDates;

                                                                var calendarEl = document.getElementById('calendar');
                                                                var calendar = new FullCalendar.Calendar(calendarEl, {
                                                                    initialView: 'dayGridMonth',
                                                                    datesSet: function(info) {
                                                                        var events = [];
                                                                        var today = new Date();
                                                                        var currentMonth = today.getMonth();
                                                                        var currentYear = today.getFullYear();

                                                                        function isInCurrentMonth(date) {
                                                                            var dateObj = new Date(date);
                                                                            return dateObj.getMonth() === currentMonth && dateObj.getFullYear() === currentYear;
                                                                        }

                                                                        for (var d = new Date(info.start); d <= new Date(info.end); d.setDate(d.getDate() + 1)) {
                                                                            var dateStr = d.toISOString().split('T')[0];
                                                                            var dateObj = new Date(dateStr);

                                                                            if (dateObj < today) {
                                                                                events.push({
                                                                                    start: dateStr,
                                                                                    end: dateStr,
                                                                                    display: 'background',
                                                                                    backgroundColor: '#d3d3d3' // Past dates
                                                                                });
                                                                            } else {
                                                                                var isBooked = bookedDates.some(bookedDate => bookedDate.date === dateStr && bookedDate.status === 'Accepted');
                                                                                if (isBooked) {
                                                                                    events.push({
                                                                                        start: dateStr,
                                                                                        end: dateStr,
                                                                                        display: 'background',
                                                                                        backgroundColor: '#ff9f89' // Booked dates
                                                                                    });
                                                                                } else {
                                                                                    events.push({
                                                                                        start: dateStr,
                                                                                        end: dateStr,
                                                                                        display: 'background',
                                                                                        backgroundColor: '#28a745' // Available dates
                                                                                    });
                                                                                }
                                                                            }
                                                                        }
                                                                        calendar.removeAllEvents();
                                                                        calendar.addEventSource(events);
                                                                    }
                                                                });

                                                                calendar.render();
                                                            });
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-success text-danger text-center fw-bold p-0 m-0 mb-2" role="alert">
                                    **Requires Downpayment**
                                </div>

                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <h4 class="dm-sans-text text-center fw-bold">Booking Information</h4>
                                        </div>
                                        <!-- Progress Bar -->
                                        <div class="progress my-3">
                                            <div
                                                id="progressBar"
                                                class="progress-bar"
                                                role="progressbar"
                                                style="width: 50%;"
                                                aria-valuenow="50"
                                                aria-valuemin="0"
                                                aria-valuemax="100">
                                                <span>Step 1 of 2</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="container">
                                            <form id="multiStepForm">
                                                <!-- Step 1 -->
                                                <div id="step1" class="step">
                                                    <h5 class=" fw-bold">Customer Information</h5>
                                                    <div class="row g-3">
                                                        <div class="col-lg-6 col-12">
                                                            <label for="fullname" class="dm-sans-text">Full Name</label>
                                                            <input type="text" class="form-control shadow" name="fullname_display" placeholder=" " value="<?php echo htmlspecialchars($userInfo['full_name']); ?>" disabled>
                                                            <input type="hidden" name="fullname" value="<?php echo htmlspecialchars($userInfo['full_name']); ?>">
                                                        </div>
                                                        <div class="col-lg-6 col-12">
                                                            <label for="sex" class="dm-sans-text">Sex</label>
                                                            <input type="text" name="sex_display" class="form-control shadow" value="<?php echo htmlspecialchars($userInfo['sex']); ?>" disabled>
                                                            <input type="hidden" name="sex" value="<?php echo htmlspecialchars($userInfo['sex']); ?>">
                                                        </div>
                                                        <div class="col-lg-6 col-12">
                                                            <label for="u_email" class="dm-sans-text">Email Address</label>
                                                            <input type="email" name="u_email_display" class="form-control shadow" value="<?php echo htmlspecialchars($userInfo['u_email']); ?>" disabled>
                                                            <input type="hidden" name="u_email" value="<?php echo htmlspecialchars($userInfo['u_email']); ?>">
                                                        </div>
                                                        <div class=" col-lg-6 col-12">
                                                            <label for="u_contact" class="dm-sans-text">Contact Number</label>
                                                            <input type="text" name="u_contact_display" class="form-control shadow" value="<?php echo htmlspecialchars($userInfo['u_contact']); ?>" disabled>
                                                            <input type="hidden" name="u_contact" value="<?php echo htmlspecialchars($userInfo['u_contact']); ?>">
                                                        </div>
                                                        <div class="col-lg-6 col-12">
                                                            <label for="regadd" class="dm-sans-text">Address</label>
                                                            <input type="text" class="form-control shadow" name="regadd_display" placeholder=" " value="<?php echo htmlspecialchars($userInfo['u_address']); ?>" disabled>
                                                            <input type="hidden" name="regadd" value="<?php echo htmlspecialchars($userInfo['u_address']); ?>">
                                                        </div>
                                                        <div class=" col-lg-6 col-12">
                                                            <label for="locationType" class="dm-sans-text">Type of Location </label>
                                                            <input type="text" name="locationType_display" class="form-control shadow" value="<?php echo htmlspecialchars($userInfo['locationType']); ?>" disabled>
                                                            <input type="hidden" name="locationType" value="<?php echo htmlspecialchars($userInfo['locationType']); ?>">
                                                        </div>
                                                        <hr class="mt-5">
                                                        <h5 class="fw-bold">Companions' Information</h5>
                                                        <div class="col-12">
                                                            <label for="daterange" class="dm-sans-text">Select Checkin and Checkout Date</label>
                                                            <input type="date" class="form-control shadow" name="daterange" id="daterange" placeholder="" required>
                                                            <script>
                                                                $(document).ready(function() {
                                                                    $('#daterange').daterangepicker({
                                                                        locale: {
                                                                            format: 'YYYY-MM-DD'
                                                                        },
                                                                        minDate: moment().startOf('day'), // Disable past dates
                                                                        isInvalidDate: function(date) {
                                                                            return date.isBefore(moment(), 'day'); // Disable past dates
                                                                        }
                                                                    });
                                                                });
                                                            </script>
                                                        </div>

                                                        <div class="col-12">
                                                            <div class="row d-flex justify-content-evenly">
                                                                <div class="col-lg-6 col-6 mb-3">
                                                                    <label class="dm-sans-text">Total Adults</label>
                                                                    <input type="number" name="total_adults" class="form-control shadow" placeholder="">
                                                                </div>
                                                                <div class="col-lg-6 col-6 mb-3">
                                                                    <label class="dm-sans-text">Total Children</label>
                                                                    <input type="number" name="total_children" class="form-control shadow" placeholder="">

                                                                </div>
                                                                <div class="col-12 text-center">
                                                                    <button type="button" class="btn btn-primary dm-sans-text" id="generateFormButton" onclick="generateForm()" disabled>Generate Form</button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-12 mb-3" id="attendeesContainer" style="max-height: 400px; overflow-x:hidden; overflow-y: auto;">
                                                            <!-- Attendees will be dynamically added here -->
                                                            <div class="col-lg-12 mb-3">
                                                                <div class="row mb-3">
                                                                    <p class="mb-0 dm-sans-text">Name of Attendee ${i}</p>
                                                                    <div class="col-xl-6 col-12">
                                                                        <input type="text" class="form-control shadow mb-2" name="name[]" placeholder="ex. Juan Dela Cruz" required>
                                                                    </div>
                                                                    <div class="col-xl-6 col-12">
                                                                        <div class="row g-2">
                                                                            <div class=" col-xl-12 col-6">
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
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-12 mb-3">
                                                                <div class="row mb-3">
                                                                    <p class="mb-0 dm-sans-text">Name of Attendee ${i}</p>
                                                                    <div class="col-xl-6 col-12">
                                                                        <input type="text" class="form-control shadow mb-2" name="name[]" placeholder="ex. Juan Dela Cruz" required>
                                                                    </div>
                                                                    <div class="col-xl-6 col-12">
                                                                        <div class="row g-2">
                                                                            <div class=" col-xl-12 col-6">
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
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-12 d-grid">
                                                            <button type="button" id="nextStep" class="btn btn-success dm-sans-text mb-2">Proceed to Payment</button>
                                                            <button type="button" class="btn btn-success dm-sans-text" id="registerButton" data-bs-toggle="modal" data-bs-target="#confirmationModal" disabled>Confirm Booking</button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Step 2 -->
                                                <div id="step2" class="step d-none">
                                                    <div class="row g-2">
                                                        <div class="col-lg-12">
                                                            <h5 class="fw-bold">Payment Information</h5>
                                                        </div>

                                                        <!-- Payment Information -->
                                                        <div class="col-lg-12 text-center mb-3">
                                                            <div>
                                                                <p class="dm-sans-text">Please scan the GCash QR Code of the Resort and send a total amount of <?php echo htmlspecialchars($price); ?> for the down payment.</p>
                                                            </div>
                                                            <div>
                                                                <img src="<?php echo htmlspecialchars($gcashInfo['bgcashQrImage']); ?>" class="img-fluid" alt="GCash QR Code" height="30">
                                                            </div>
                                                        </div>

                                                        <!-- Proof of Payment Upload -->
                                                        <div class="col-lg-12 mb-3">
                                                            <p class="text-center dm-sans-text">Name: <?php echo htmlspecialchars($gcashInfo['bgcashname']); ?></p>
                                                            <p class="text-center dm-sans-text">Number: <?php echo htmlspecialchars($gcashInfo['bgcashnum']); ?></p>
                                                        </div>
                                                        <div class="col-lg-12 mb-3">
                                                            <label for="proofofpayment" class="mb-1 d-block dm-sans-text text-start">Proof of Payment</label>
                                                            <input type="file" name="proofofpayment" id="proofofpayment" class="form-control shadow" accept="image/*" required>
                                                        </div>
                                                        <div class="col-lg-12 mb-3">
                                                            <label>G-Cash Reference Number</label>
                                                            <input type="text" name="gcash_reference" class="form-control shadow" placeholder="Enter the reference number of your transaction" required>
                                                        </div>
                                                        <div class="col-12 bg-success-subtle text-center rounded border-0">
                                                            <i class="bi bi-info-circle me-1"></i><span class="fw-bold ">Business owner will review your transaction before accepting your reservation.</span>
                                                        </div>

                                                        <div class="col-lg-12 my-3">
                                                            <div class="d-grid col-12 mx-auto">
                                                                <button type="button" class="btn btn-secondary mb-2" id="previousStep">Back</button>
                                                            </div>
                                                            <div class="d-grid col-12 mx-auto">
                                                                <button type="button" class="btn btn-success" id="registerButton" data-bs-toggle="modal" data-bs-target="#confirmationModal" disabled>Confirm Booking</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <script>
                                            const progressBar = document.getElementById('progressBar');
                                            const step1 = document.getElementById('step1');
                                            const step2 = document.getElementById('step2');

                                            document.getElementById('nextStep').addEventListener('click', function() {
                                                step1.classList.add('d-none');
                                                step2.classList.remove('d-none');
                                                progressBar.style.width = '100%';
                                                progressBar.setAttribute('aria-valuenow', '100');
                                                progressBar.textContent = 'Step 2 of 2';
                                            });

                                            document.getElementById('previousStep').addEventListener('click', function() {
                                                step2.classList.add('d-none');
                                                step1.classList.remove('d-none');
                                                progressBar.style.width = '50%';
                                                progressBar.setAttribute('aria-valuenow', '50');
                                                progressBar.textContent = 'Step 1 of 2';
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>

                    <div id="rooms" class="col-xl-8 col-lg-10 col-md-11 col-12 py-5">
                        <h5 class="text-dark dm-sans-text fw-bold mb-3">Related rooms from the same destination:</h5>
                        <div class="row g-3">
                            <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb">
                                <div class="card card-shadow">
                                    <div class="img-container">
                                        <img src="../img/businessowner-img/dalitiwan resort.jpg" class="card-img-top" alt="Room Image">
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title m-0 p-0 fw-bold cormorant-text">Villa Gregoria de pasta</h3>
                                        <p class="card-text  m-0 p-0 dm-sans-text text-secondary">Time Schedule: </p>
                                        <p class="card-text  m-0 p-0 dm-sans-text text-secondary">Max Adult: </p>
                                        <p class="card-text  m-0 p-0 dm-sans-text text-secondary">Max Children </p>
                                        <h6 class="mt-3 dm-sans-text fw-bold text-secondary text-end">Price: <span class="text-danger">&#8369 12121</span>/Night</h6>
                                        <a href="../../resort/booking.php" class="btn btn-book d-grid dm-sans-text rounded p-2">Book Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                <div class="card card-shadow">
                                    <div class="img-container">
                                        <img src="../img/general-img/majayjay-church.jpg" class="card-img-top" alt="Room Image">
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title m-0 p-0 fw-bold cormorant-text">Room Name</h3>
                                        <p class="card-text  m-0 p-0 dm-sans-text text-secondary">Time Schedule: </p>
                                        <p class="card-text  m-0 p-0 dm-sans-text text-secondary">Max Adult: </p>
                                        <p class="card-text  m-0 p-0 dm-sans-text text-secondary">Max Children </p>
                                        <h6 class="mt-3 dm-sans-text fw-bold text-secondary text-end">Price: <span class="text-danger">&#8369 12121</span>/Night</h6>
                                        <a href="../../resort/booking.php?roomID=<?php echo $room['roomID']; ?>&businessInfoID=<?php echo $businessInfoID; ?>" class="btn btn-book d-grid dm-sans-text rounded p-2">Book Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                <div class="card card-shadow">
                                    <div class="img-container">
                                        <img src="../img/general-img/majayjay-church.jpg" class="card-img-top" alt="Room Image">
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title m-0 p-0 fw-bold cormorant-text">Room Name</h3>
                                        <p class="card-text  m-0 p-0 dm-sans-text text-secondary">Time Schedule: </p>
                                        <p class="card-text  m-0 p-0 dm-sans-text text-secondary">Max Adult: </p>
                                        <p class="card-text  m-0 p-0 dm-sans-text text-secondary">Max Children </p>
                                        <h6 class="mt-3 dm-sans-text fw-bold text-secondary text-end">Price: <span class="text-danger">&#8369 12121</span>/Night</h6>
                                        <a href="../../resort/booking.php?roomID=<?php echo $room['roomID']; ?>&businessInfoID=<?php echo $businessInfoID; ?>" class="btn btn-book d-grid dm-sans-text rounded p-2">Book Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                <div class="card card-shadow">
                                    <div class="img-container">
                                        <img src="../img/general-img/majayjay-church.jpg" class="card-img-top" alt="Room Image">
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title m-0 p-0 fw-bold cormorant-text">Room Name</h3>
                                        <p class="card-text  m-0 p-0 dm-sans-text text-secondary">Time Schedule: </p>
                                        <p class="card-text  m-0 p-0 dm-sans-text text-secondary">Max Adult: </p>
                                        <p class="card-text  m-0 p-0 dm-sans-text text-secondary">Max Children </p>
                                        <h6 class="mt-3 dm-sans-text fw-bold text-secondary text-end">Price: <span class="text-danger">&#8369 12121</span>/Night</h6>
                                        <a href="../../resort/page-3.php?roomID=<?php echo $room['roomID']; ?>&businessInfoID=<?php echo $businessInfoID; ?>" class="btn btn-book d-grid dm-sans-text rounded p-2">Book Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                <div class="card card-shadow">
                                    <div class="img-container">
                                        <img src="../img/general-img/majayjay-church.jpg" class="card-img-top" alt="Room Image">
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title m-0 p-0 fw-bold cormorant-text">Room Name</h3>
                                        <p class="card-text  m-0 p-0 dm-sans-text text-secondary">Time Schedule: </p>
                                        <p class="card-text  m-0 p-0 dm-sans-text text-secondary">Max Adult: </p>
                                        <p class="card-text  m-0 p-0 dm-sans-text text-secondary">Max Children </p>
                                        <h6 class="mt-3 dm-sans-text fw-bold text-secondary text-end">Price: <span class="text-danger">&#8369 12121</span>/Night</h6>
                                        <a href="../../resort/page-3.php?roomID=<?php echo $room['roomID']; ?>&businessInfoID=<?php echo $businessInfoID; ?>" class="btn btn-book d-grid dm-sans-text rounded p-2">Book Now</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                                <div class="card card-shadow">
                                    <div class="img-container">
                                        <img src="../img/general-img/majayjay-church.jpg" class="card-img-top" alt="Room Image">
                                    </div>
                                    <div class="card-body">
                                        <h3 class="card-title m-0 p-0 fw-bold cormorant-text">Room Name</h3>
                                        <p class="card-text  m-0 p-0 dm-sans-text text-secondary">Time Schedule: </p>
                                        <p class="card-text  m-0 p-0 dm-sans-text text-secondary">Max Adult: </p>
                                        <p class="card-text  m-0 p-0 dm-sans-text text-secondary">Max Children </p>
                                        <h6 class="mt-3 dm-sans-text fw-bold text-secondary text-end">Price: <span class="text-danger">&#8369 12121</span>/Night</h6>
                                        <a href="../../resort/page-3.php?roomID=<?php echo $room['roomID']; ?>&businessInfoID=<?php echo $businessInfoID; ?>" class="btn btn-book d-grid dm-sans-text rounded p-2">Book Now</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>



        <section id="contact" class="contact-container">
            <div class="container-fluid p-5 bg-success-subtle">
                <div class="row justify-content-evenly">
                    <div class="col-lg-4 col-sm-5 gx-5 mb-4">
                        <div class="col-12">
                            <h5 class="text-start text-success fw-bold">CONTACT US</h5>
                        </div>
                        <div class="col-12">
                            <h3 class="text-start text-dark">Get in touch with us</h3>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="text" class="form-label text-start text-dark ms-2">Name</label>
                            <input type="text" class="form-control shadow" name="" placeholder="Juan Dela Cruz">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="email" class="form-label text-start text-dark ms-2">Email address</label>
                            <input type="email" class="form-control shadow" name="" placeholder="name@example.com">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="contact" class="form-label text-start text-dark ms-2">Phone number</label>
                            <input type="number" class="form-control shadow" name="" placeholder="09123456789">
                        </div>
                        <div class="col-12 mb-5">
                            <label for="message" class="form-label text-start text-dark ms-2">Message</label>
                            <textarea class="form-control shadow" name="" rows="3"></textarea>
                        </div>
                        <div class="col-12 mb-1 d-grid">
                            <button class="btn btn-success shadow">Submit</button>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-5 gx-5 bg-light">
                        <div id="googleMap" style="width:100%;height:400px;"></div>
                        <script>
                            function myMap() {
                                var mapProp = {
                                    center: new google.maps.LatLng(14.1591, 121.4709), // Majayjay, Laguna coordinates
                                    zoom: 12, // Adjust zoom level as needed
                                };
                                var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
                            }
                        </script>

                        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAOVYRIgupAurZup5y1PRh8Ismb1A3lLao&callback=myMap"></script>
                        <!-- <img src="../homepage/majayjaymap.PNG" class="mt-4 w-100 h-50 shadow" alt="" style="object-fit: cover;"> -->
                        <div class="row">
                            <div class="col-12">
                                <p class="text-start text-dark fw-bold mt-3">Contact us</p>
                                <p><i class="bi bi-envelope-at text-dark me-2"></i><a href="" class="text-dark">majayjaylaguna@gmail.com</a></p>
                            </div>
                            <div class="col-12 ">
                                <p class="text-start text-dark fw-bold mt-2">Location</p>
                                <p><i class="bi bi-geo-alt text-dark me-2"></i><a href="" class="text-dark">Majayjay, Laguna, Philippines</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section class="footer-container bg-success">
            <div class="container-fluid ">
                <div class="row ">
                    <div class="col-6 text-start">
                        <p class="mb-0">
                            <a href="#" class="text-muted">
                                <strong>HaKingz</strong>
                            </a>
                        </p>
                    </div>
                    <div class="col-6 text-end mt-2">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="#" class="text-muted">Contact</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="text-muted">About Us</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="text-muted">Terms</a>
                            </li>
                            <li class="list-inline-item">
                                <a href="#" class="text-muted">Booking</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

    </main>
</body>
<!-- Reservation Confirmation Modal -->
<div class="modal fade" id="reservationConfirmationModal" tabindex="-1" aria-labelledby="reservationConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reservationConfirmationModalLabel">Confirm Reservation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to book this room?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmReservationButton">Confirm</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', () => {
        const notyf = new Notyf({
            duration: 30000,
            position: {
                x: 'right',
                y: 'top'
            }
        });

        const form = document.getElementById('reservationForm');
        const confirmButton = document.getElementById('confirmReservationButton');

        confirmButton.addEventListener('click', async () => {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.status === 'success') {
                notyf.success(`Reservation successful! Your reference number is: ${result.referenceNum}`);
                setTimeout(() => {
                    location.reload();
                }, 3000); // Reload the page after 3 seconds
            } else if (result.status === 'error') {
                notyf.error(result.message);
            }

            // Close the modal
            const reservationConfirmationModal = bootstrap.Modal.getInstance(document.getElementById('reservationConfirmationModal'));
            reservationConfirmationModal.hide();
        });
    });
</script>

<script>
    $(document).ready(function() {
        const roomID = <?php echo $roomID; ?>;
        const notyf = new Notyf({
            duration: 3000,
            position: {
                x: 'right',
                y: 'top'
            }
        });

        function fetchBookedDates(roomID) {
            return $.ajax({
                url: '../../backends/subadmin/fetch_booked_dates.php',
                method: 'POST',
                data: {
                    roomID: roomID
                },
                dataType: 'json'
            });
        }

        function disableBookedDates(bookedDates) {
            $("#checkin, #departure").datepicker({
                dateFormat: 'yy-mm-dd',
                beforeShowDay: function(date) {
                    const dateString = $.datepicker.formatDate('yy-mm-dd', date);
                    const today = new Date();
                    today.setHours(0, 0, 0, 0); // Set to the beginning of today

                    const isBooked = bookedDates.some(bookedDate => bookedDate.date === dateString && bookedDate.status === 'Accepted');

                    if (date < today || isBooked) {
                        return [false, 'booked', 'Unavailable'];
                    }
                    return [true, ''];
                },
                onSelect: function(selectedDate) {
                    const option = this.id === "checkin" ? "minDate" : "maxDate";
                    const instance = $(this).data("datepicker");
                    const date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
                    $("#checkin, #departure").not(this).datepicker("option", option, date);
                }
            });
        }

        fetchBookedDates(roomID).done(function(response) {
            if (response.bookedDates) {
                disableBookedDates(response.bookedDates);
            }
        });

        $("#reservationForm").on('submit', function(event) {
            event.preventDefault();
            const formData = $(this).serialize();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        notyf.success(`Reservation successful! Your reference number is: ${response.referenceNum}`);
                        setTimeout(() => {
                            location.reload();
                        }, 3000); // Reload the page after 3 seconds
                    } else {
                        notyf.error(response.message);
                    }
                },
                error: function() {
                    notyf.error('An error occurred. Please try again later.');
                }
            });
        });
    });

    // Progressbar
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
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
<script src="../homepage/homepage.js"></script>

</html>