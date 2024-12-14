<?php
// page-3.php
session_start();
include '../includes/db.php';

// Get the roomID and businessInfoID from the URL, defaulting to 1 if not set
$businessInfoID = isset($_GET['businessInfoID']) ? (int) $_GET['businessInfoID'] : 1;
$roomID = isset($_GET['roomID']) ? (int) $_GET['roomID'] : 1;
$userID = isset($_GET['userID']) ? (int) $_GET['userID'] : 1;

try {
    // Query to fetch room information based on roomID
    $stmt = $pdo->prepare("
        SELECT roomID, roomName, roomPrice, adultMax, ChildrenMax, RoomDescriptions, image1, image2, image3, image4, image5, image6, BusinessInfoID, timeStart, timeEnd
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

    // Query to fetch active features based on roomID and BusinessInfoID
    $stmtFeatures = $pdo->prepare("
        SELECT rf.FeatureName
        FROM room_features rf
        JOIN room_features_mapping rfm ON rf.FeatureID = rfm.FeatureID
        WHERE rfm.roomID = :roomID AND rfm.BusinessInfoID = :businessInfoID AND rfm.IsActive = 1
    ");
    $stmtFeatures->execute(['roomID' => $roomID, 'businessInfoID' => $businessInfoID]);
    $features = $stmtFeatures->fetchAll(PDO::FETCH_ASSOC);

    // Query to fetch active facilities based on roomID and BusinessInfoID
    $stmtFacilities = $pdo->prepare("
        SELECT rf.FacilityName
        FROM room_facilities rf
        JOIN room_facilities_mapping rfm ON rf.FacilityID = rfm.FacilityID
        WHERE rfm.roomID = :roomID AND rfm.BusinessInfoID = :businessInfoID AND rfm.IsActive = 1
    ");
    $stmtFacilities->execute(['roomID' => $roomID, 'businessInfoID' => $businessInfoID]);
    $facilities = $stmtFacilities->fetchAll(PDO::FETCH_ASSOC);

    // Query to fetch related rooms based on businessInfoID, excluding the current roomID (related rooms are rooms from the same business)
    $stmtRelatedRooms = $pdo->prepare("
        SELECT roomID, roomName, roomPrice, adultMax, ChildrenMax, image1, timeStart, timeEnd
        FROM roominfotable
        WHERE BusinessInfoID = :businessInfoID AND roomID != :roomID
    ");
    $stmtRelatedRooms->execute(['businessInfoID' => $businessInfoID, 'roomID' => $roomID]);
    $relatedRooms = $stmtRelatedRooms->fetchAll(PDO::FETCH_ASSOC);

    // Fetch user information
    $query = "SELECT full_name, u_address, u_email, u_contact, sex, locationType FROM users WHERE userID = :userID";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['userID' => $userID]);
    $userInfo = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch payment method for the room
    $query = "SELECT * FROM payment_methods WHERE roomID = :roomID";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['roomID' => $roomID]);
    $paymentMethod = $stmt->fetch(PDO::FETCH_ASSOC);
    $hasPaymentMethod = $stmt->rowCount() > 0;
    $price = $paymentMethod ? $paymentMethod['amount'] : 0;

    // Fetch GCash information for the business
    $query = "SELECT bgcashnum, bgcashname, bgcashQrImage FROM qcashPayment WHERE BusinessInfoID = :businessInfoID";
    $stmt = $pdo->prepare($query);
    $stmt->execute(['businessInfoID' => $businessInfoID]);
    $gcashInfo = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <!-- scrpt to enlarge image -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0.27/dist/fancybox.css" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0.27/dist/fancybox.umd.js"></script>
    <!-- script for daterange picker -->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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

        .hidden-field {
            display: none;
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
                <div class="row page-nav-select d-flex justify-content-between align-items-center mt-5">
                    <div class="col-2 py-3 d-flex justify-content-center align-items-center">
                        <a href="../../resort/page-1.php?businessInfoID=<?php echo urlencode($businessInfoID); ?><?php echo isset($_SESSION['user_id']) ? '&userID=' . urlencode($_SESSION['user_id']) : ''; ?>">
                            <i class="bi bi-arrow-left-circle fw-bold text-light fs-1 text-shadow-light"></i>
                        </a>
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
                                                    <?php for ($i = 1; $i <= 6; $i++): ?>
                                                        <?php if (!empty($room["image$i"])): ?>
                                                            <div class="col-4">
                                                                <a href="<?php echo htmlspecialchars($room["image$i"]); ?>" data-fancybox="gallery">
                                                                    <img src="<?php echo htmlspecialchars($room["image$i"]); ?>" class="img-fluid destinations-images" alt="Room Image">
                                                                </a>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endfor; ?>
                                                </div>

                                                <script>
                                                    Fancybox.bind("[data-fancybox='gallery']", {
                                                        transitionEffect: "fade",
                                                        thumbs: {
                                                            autoStart: true
                                                        }
                                                    });
                                                </script>
                                            </div>
                                            <h3 class="dm-sans-text fw-bold"><?php echo htmlspecialchars($room['roomName']); ?></h3>
                                            <h6 class="dm-sans-text fw-bold"><span>Price: </span> <span class="text-success"> &#8369 <?php echo number_format(htmlspecialchars($room['roomPrice']), 2, '.', ','); ?></span> /Night</h6>
                                            <p class="dm-sans-text"><span class="fw-bold">Max Adult: </span> <?php echo htmlspecialchars($room['adultMax']); ?></p>
                                            <p class="dm-sans-text"><span class="fw-bold">Max Children: </span> <?php echo htmlspecialchars($room['ChildrenMax']); ?></p>
                                            <p class="dm-sans-text"><span class="fw-bold">Location:</span> <?php echo htmlspecialchars($businessInfo['BusinessAddress']); ?></p>
                                            <p class="dm-sans-text"><span class="fw-bold">Contact Number:</span> <?php echo htmlspecialchars($businessInfo['BusinessContactNumber']); ?></p>

                                            <hr>
                                            <div class="col-11 p-2 border rounded bg-secondary-subtle mb-2">
                                                <h6 class="dm-sans-text fw-bold">Highlights</h6>
                                                <div class="row g-2 d-flex justify-content-start">
                                                    <?php foreach ($features as $feature): ?>
                                                        <div class="col-lg-4 col-md-6">
                                                            <p class="dm-sans-text"><i class="bi bi-check-circle-fill me-1 text-success"></i><?php echo htmlspecialchars($feature['FeatureName']); ?></p>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>

                                            <div class="col-11 p-2 border rounded bg-secondary-subtle mb-2">
                                                <h6 class="dm-sans-text fw-bold">Facilities</h6>
                                                <div class="row g-2 d-flex justify-content-start">
                                                    <?php foreach ($facilities as $facility): ?>
                                                        <div class="col-lg-4 col-md-6">
                                                            <p class="dm-sans-text"><i class="bi bi-check-circle-fill me-1 text-success"></i><?php echo htmlspecialchars($facility['FacilityName']); ?></p>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                            </div>

                                            <div class="col-11 p-2 border rounded bg-secondary-subtle">
                                                <h6 class="dm-sans-text fw-bold">Policies</h6>
                                                <div class="row g-2 d-flex justify-content-start">
                                                    <?php
                                                    $descriptions = explode("\n", $room['RoomDescriptions']);
                                                    foreach ($descriptions as $description):
                                                        $description = trim($description);
                                                        if (!empty($description)):
                                                            // Remove the leading * character
                                                            $description = ltrim($description, '* ');
                                                    ?>
                                                            <div class="col-lg-4 col-md-6">
                                                                <p class="dm-sans-text"><i class="bi bi-x-circle-fill me-1 text-danger"></i><?php echo htmlspecialchars($description); ?></p>
                                                            </div>
                                                    <?php
                                                        endif;
                                                    endforeach;
                                                    ?>
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
                                                            <p class="text-dark dm-sans-text"><?php echo date("g:i A", strtotime($room['timeStart'])) . ' to ' . date("g:i A", strtotime($room['timeEnd'])); ?></p>
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
                                                <?php if (!$userID): ?>
                                                    <p class="text-dark">Do you want to reserve this room? <a href="../login.php?redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>">Click here to login</a></p>
                                                <?php endif; ?>

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

                                <?php if ($hasPaymentMethod): ?>
                                    <div class="alert alert-success text-danger text-center fw-bold p-0 m-0 mb-2" role="alert">
                                        **Requires Downpayment**
                                    </div>
                                <?php endif; ?>


                                <?php if ($userID): ?>
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-title">
                                                <h4 class="dm-sans-text text-center fw-bold">Booking Information</h4>
                                            </div>
                                            <!-- Progress Bar -->
                                            <?php if ($hasPaymentMethod): ?>
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
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-body">
                                            <div class="container">
                                                <form id="multiStepForm" method="POST" enctype="multipart/form-data" action="../../backends/subadmin/bookingreg.php?roomID=<?php echo $roomID; ?>&businessInfoID=<?php echo $businessInfoID; ?>&userID=<?php echo $userID; ?>">
                                                    <!-- Step 1 -->
                                                    <div id="step1" class="step">
                                                        <h5 class="fw-bold">Customer Information</h5>
                                                        <div class="row g-3">
                                                            <div class="col-lg-6 col-12">
                                                                <label for="fullname" class="dm-sans-text">Full Name</label>
                                                                <input type="text" class="form-control shadow" name="fullname_display" placeholder=" " value="<?php echo htmlspecialchars($userInfo['full_name']); ?>" disabled>
                                                                <input type="hidden" name="fullname" value="<?php echo htmlspecialchars($userInfo['full_name']); ?>">
                                                            </div>
                                                            <div class="col-lg-6 col-12">
                                                                <label for="u_contact" class="dm-sans-text">Contact Number</label>
                                                                <input type="text" name="u_contact_display" class="form-control shadow" value="<?php echo htmlspecialchars($userInfo['u_contact']); ?>" disabled>
                                                                <input type="hidden" name="u_contact" value="<?php echo htmlspecialchars($userInfo['u_contact']); ?>">
                                                            </div>
                                                            <div class="col-lg-6 col-12">
                                                                <label for="u_email" class="dm-sans-text">Email Address</label>
                                                                <input type="email" name="u_email_display" class="form-control shadow" value="<?php echo htmlspecialchars($userInfo['u_email']); ?>" disabled>
                                                                <input type="hidden" name="u_email" value="<?php echo htmlspecialchars($userInfo['u_email']); ?>">
                                                            </div>
                                                            <div class="col-lg-6 col-12">
                                                                <label for="regadd" class="dm-sans-text">Address</label>
                                                                <input type="text" class="form-control shadow" name="regadd_display" placeholder=" " value="<?php echo htmlspecialchars($userInfo['u_address']); ?>" disabled>
                                                                <input type="hidden" name="regadd" value="<?php echo htmlspecialchars($userInfo['u_address']); ?>">
                                                            </div>
                                                            <div class="col-lg-6 col-12 hidden-field">
                                                                <label for="sex" class="dm-sans-text">Sex</label>
                                                                <input type="text" name="sex_display" class="form-control shadow" value="<?php echo htmlspecialchars($userInfo['sex']); ?>" disabled>
                                                                <input type="hidden" name="sex" value="<?php echo htmlspecialchars($userInfo['sex']); ?>">
                                                            </div>
                                                            <div class="col-lg-6 col-12 hidden-field">
                                                                <label for="locationType" class="dm-sans-text">Type of Location </label>
                                                                <input type="text" name="locationType_display" class="form-control shadow" value="<?php echo htmlspecialchars($userInfo['locationType']); ?>" disabled>
                                                                <input type="hidden" name="locationType" value="<?php echo htmlspecialchars($userInfo['locationType']); ?>">
                                                            </div>
                                                            <hr class="mt-5">
                                                            <h5 class="fw-bold">Companions' Information</h5>
                                                            <div class="col-12">
                                                                <input type="text" class="form-control shadow" name="daterange" id="daterange" placeholder="Select Checkin and Checkout Date" required>
                                                                <label for="daterange" class="fw-bold dm-sans-text">Select Checkin and Checkout Date</label>
                                                                <script>
                                                                    $(document).ready(function() {
                                                                        $('#daterange').daterangepicker({
                                                                            locale: {
                                                                                format: 'YYYY-MM-DD'
                                                                            },
                                                                            autoUpdateInput: false, // Prevents the input from being updated automatically
                                                                            minDate: moment().startOf('day'), // Disable past dates
                                                                            isInvalidDate: function(date) {
                                                                                return date.isBefore(moment(), 'day'); // Disable past dates
                                                                            }
                                                                        });

                                                                        $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                                                                            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
                                                                            checkInputs(); // Check inputs after selecting date range
                                                                        });

                                                                        $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
                                                                            $(this).val('');
                                                                            checkInputs(); // Check inputs after canceling date range
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
                                                                <script>
                                                                    // Initialize Notyf
                                                                    const notyf = new Notyf({
                                                                        duration: 5000,
                                                                        position: {
                                                                            x: 'right',
                                                                            y: 'top'
                                                                        }
                                                                    });

                                                                    function generateForm() {
                                                                        const totalAdults = parseInt(document.querySelector('input[name="total_adults"]').value) || 0;
                                                                        const totalChildren = parseInt(document.querySelector('input[name="total_children"]').value) || 0;
                                                                        const totalAttendees = totalAdults + totalChildren;

                                                                        if (totalAttendees === 0) {
                                                                            notyf.error('Please enter the number of adults or children.');
                                                                            return;
                                                                        }

                                                                        const attendeesContainer = document.getElementById('attendeesContainer');
                                                                        attendeesContainer.innerHTML = ''; // Clear previous entries

                                                                        // Add the user's information as the first attendee
                                                                        const userInfo = {
                                                                            name: document.querySelector('input[name="fullname"]').value,
                                                                            sex: document.querySelector('input[name="sex"]').value,
                                                                            location: document.querySelector('input[name="locationType"]').value
                                                                        };

                                                                        const userAttendeeDiv = document.createElement('div');
                                                                        userAttendeeDiv.classList.add('col-lg-12', 'mb-3');
                                                                        userAttendeeDiv.innerHTML = `
        <div class="row mb-3">
            <p class="mb-0 dm-sans-text">Name of Attendee 1</p>
            <div class="col-xl-6 col-12">
                <input type="text" class="form-control shadow mb-2" name="name[]" value="${userInfo.name}" disabled>
                <input type="hidden" name="name[]" value="${userInfo.name}">
            </div>
            <div class="col-xl-6 col-12">
                <div class="row g-2">
                    <div class="col-xl-12 col-6">
                        <select name="sex[]" class="form-select shadow" disabled>
                            <option value="Male" ${userInfo.sex === 'Male' ? 'selected' : ''}>Male</option>
                            <option value="Female" ${userInfo.sex === 'Female' ? 'selected' : ''}>Female</option>
                        </select>
                        <input type="hidden" name="sex[]" value="${userInfo.sex}">
                    </div>
                    <div class="col-xl-12 col-6">
                        <select name="location[]" class="form-select shadow" disabled>
                            <option value="This City/Municipality" ${userInfo.location === 'This City/Municipality' ? 'selected' : ''}>This City/Municipality</option>
                            <option value="Other City/Municipality" ${userInfo.location === 'Other City/Municipality' ? 'selected' : ''}>Other City/Municipality</option>
                            <option value="Other Province" ${userInfo.location === 'Other Province' ? 'selected' : ''}>Other Province</option>
                            <option value="Foreign Country" ${userInfo.location === 'Foreign Country' ? 'selected' : ''}>Foreign Country</option>
                        </select>
                        <input type="hidden" name="location[]" value="${userInfo.location}">
                    </div>
                </div>
            </div>
        </div>
    `;
                                                                        attendeesContainer.appendChild(userAttendeeDiv);

                                                                        // Add the remaining attendees
                                                                        for (let i = 2; i <= totalAttendees + 1; i++) {
                                                                            const attendeeDiv = document.createElement('div');
                                                                            attendeeDiv.classList.add('col-lg-12', 'mb-3');
                                                                            attendeeDiv.innerHTML = `
            <div class="row mb-3">
                <p class="mb-0 dm-sans-text">Name of Attendee ${i}</p>
                <div class="col-xl-6 col-12">
                    <input type="text" class="form-control shadow mb-2" name="name[]" placeholder="ex. Juan Dela Cruz" required>
                </div>
                <div class="col-xl-6 col-12">
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
            </div>
        `;
                                                                            attendeesContainer.appendChild(attendeeDiv);
                                                                        }

                                                                        checkInputs(); // Check inputs after generating the form
                                                                    }

                                                                    function checkInputs() {
                                                                        const totalAdults = parseInt(document.querySelector('input[name="total_adults"]').value) || 0;
                                                                        const totalChildren = parseInt(document.querySelector('input[name="total_children"]').value) || 0;
                                                                        const daterange = document.querySelector('input[name="daterange"]').value;
                                                                        const attendeesContainer = document.getElementById('attendeesContainer');
                                                                        const generateFormButton = document.getElementById('generateFormButton');
                                                                        const nextStepButton = document.getElementById('nextStep');
                                                                        const registerButton = document.getElementById('registerButton');

                                                                        if ((totalAdults > 0 || totalChildren > 0) && daterange) {
                                                                            generateFormButton.disabled = false;
                                                                        } else {
                                                                            generateFormButton.disabled = true;
                                                                        }

                                                                        let allAttendeesValid = true;
                                                                        const attendees = attendeesContainer.querySelectorAll('.row.mb-3');
                                                                        attendees.forEach(attendee => {
                                                                            const name = attendee.querySelector('input[name="name[]"]').value.trim();
                                                                            const sex = attendee.querySelector('select[name="sex[]"]').value;
                                                                            const location = attendee.querySelector('select[name="location[]"]').value;
                                                                            if (!name || !sex || !location) {
                                                                                allAttendeesValid = false;
                                                                            }
                                                                        });

                                                                        if (attendees.length > 0 && daterange && (totalAdults > 0 || totalChildren > 0) && allAttendeesValid) {
                                                                            if (nextStepButton) {
                                                                                nextStepButton.disabled = false;
                                                                            }
                                                                            if (!nextStepButton) {
                                                                                registerButton.disabled = false;
                                                                            }
                                                                        } else {
                                                                            if (nextStepButton) {
                                                                                nextStepButton.disabled = true;
                                                                            }
                                                                            if (!nextStepButton) {
                                                                                registerButton.disabled = true;
                                                                            }
                                                                        }
                                                                    }
                                                                    document.querySelector('input[name="total_adults"]').addEventListener('input', function() {
                                                                        const daterange = document.querySelector('input[name="daterange"]').value;
                                                                        if (!daterange && this.value > 0) {
                                                                            notyf.error('Please select a check-in and check-out date.');
                                                                        }
                                                                        checkInputs();
                                                                    });

                                                                    document.querySelector('input[name="total_children"]').addEventListener('input', function() {
                                                                        const daterange = document.querySelector('input[name="daterange"]').value;
                                                                        if (!daterange && this.value > 0) {
                                                                            notyf.error('Please select a check-in and check-out date before adding a adult and chidren.');
                                                                        }
                                                                        checkInputs();
                                                                    });

                                                                    document.querySelector('input[name="total_adults"]').addEventListener('input', checkInputs);
                                                                    document.querySelector('input[name="total_children"]').addEventListener('input', checkInputs);
                                                                    document.querySelector('input[name="daterange"]').addEventListener('input', checkInputs);
                                                                    document.getElementById('attendeesContainer').addEventListener('input', checkInputs);
                                                                </script>
                                                            </div>
                                                            <div class="col-lg-12 d-grid">
                                                                <?php if ($hasPaymentMethod): ?>
                                                                    <button type="button" id="nextStep" class="btn btn-success dm-sans-text mb-2" disabled>Proceed to Payment</button>
                                                                <?php else: ?>
                                                                    <button type="button" class="btn btn-success dm-sans-text" id="registerButton" data-bs-toggle="modal" data-bs-target="#reservationConfirmationModal" disabled>Confirm Booking</button>
                                                                <?php endif; ?>
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
                                                                <input type="file" name="proofofpayment" id="proofofpayment" class="form-control shadow" accept="image/*" <?php echo $hasPaymentMethod ? 'required' : ''; ?>>
                                                            </div>
                                                            <div class="col-lg-12 mb-3">
                                                                <label>G-Cash Reference Number</label>
                                                                <input type="text" name="gcash_reference" id="gcash_reference" class="form-control shadow" placeholder="Enter the reference number of your transaction" <?php echo $hasPaymentMethod ? 'required' : ''; ?>>
                                                            </div>
                                                            <div class="col-12 bg-success-subtle text-center rounded border-0">
                                                                <i class="bi bi-info-circle me-1"></i><span class="fw-bold ">Business owner will review your transaction before accepting your reservation.</span>
                                                            </div>

                                                            <div class="col-lg-12 my-3">
                                                                <div class="d-grid col-12 mx-auto">
                                                                    <button type="button" class="btn btn-secondary mb-2" id="previousStep">Back</button>
                                                                </div>
                                                                <div class="d-grid col-12 mx-auto">
                                                                    <button type="button" class="btn btn-success" id="registerButton" data-bs-toggle="modal" data-bs-target="#reservationConfirmationModal" disabled>Confirm Booking</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', () => {
                                                            const notyf = new Notyf({
                                                                duration: 3000,
                                                                position: {
                                                                    x: 'right',
                                                                    y: 'top'
                                                                }
                                                            });

                                                            const form = document.getElementById('multiStepForm');
                                                            const confirmButton = document.getElementById('confirmReservationButton');

                                                            confirmButton.addEventListener('click', async () => {
                                                                const formData = new FormData(form);
                                                                const response = await fetch(form.action, {
                                                                    method: 'POST',
                                                                    body: formData
                                                                });

                                                                const result = await response.json();

                                                                if (result.type === 'success') {
                                                                    notyf.success(result.message);
                                                                    setTimeout(() => {
                                                                        window.location.href = '../../resort/page-3.php?roomID=<?php echo $roomID; ?>&businessInfoID=<?php echo $businessInfoID; ?>&userID=<?php echo $userID; ?>';
                                                                    }, 3000);
                                                                } else {
                                                                    notyf.error(result.message);
                                                                }

                                                                // Close the modal
                                                                const reservationConfirmationModal = bootstrap.Modal.getInstance(document.getElementById('reservationConfirmationModal'));
                                                                reservationConfirmationModal.hide();
                                                            });
                                                        });

                                                        const progressBar = document.getElementById('progressBar');
                                                        const step1 = document.getElementById('step1');
                                                        const step2 = document.getElementById('step2');
                                                        const registerButton = document.getElementById('registerButton');
                                                        const proofOfPayment = document.getElementById('proofofpayment');
                                                        const gcashReference = document.getElementById('gcash_reference');

                                                        document.getElementById('nextStep').addEventListener('click', function() {
                                                            step1.classList.add('d-none');
                                                            step2.classList.remove('d-none');
                                                            progressBar.style.width = '100%';
                                                            progressBar.setAttribute('aria-valuenow', '100');
                                                            progressBar.textContent = 'Step 2 of 2';
                                                            checkStep2Inputs(); // Check inputs when proceeding to step 2
                                                        });

                                                        document.getElementById('previousStep').addEventListener('click', function() {
                                                            step2.classList.add('d-none');
                                                            step1.classList.remove('d-none');
                                                            progressBar.style.width = '50%';
                                                            progressBar.setAttribute('aria-valuenow', '50');
                                                            progressBar.textContent = 'Step 1 of 2';
                                                            registerButton.disabled = true; // Disable the confirm button when going back to step 1
                                                        });

                                                        function checkStep2Inputs() {
                                                            if (proofOfPayment.files.length > 0 && gcashReference.value.trim() !== '') {
                                                                registerButton.disabled = false;
                                                            } else {
                                                                registerButton.disabled = true;
                                                            }
                                                        }

                                                        proofOfPayment.addEventListener('change', checkStep2Inputs);
                                                        gcashReference.addEventListener('input', checkStep2Inputs);

                                                        // Enable the confirm button if there is no payment method
                                                        <?php if (!$hasPaymentMethod): ?>
                                                            registerButton.disabled = false;
                                                        <?php endif; ?>

                                                        // Format GCash reference number as xxxx xxx xxxxxx and limit to 13 digits
                                                        gcashReference.addEventListener('input', function() {
                                                            let value = gcashReference.value.replace(/\D/g, ''); // Remove non-digit characters
                                                            if (value.length > 13) {
                                                                value = value.slice(0, 13); // Limit to 13 digits
                                                            }
                                                            if (value.length > 4) {
                                                                value = value.slice(0, 4) + ' ' + value.slice(4);
                                                            }
                                                            if (value.length > 8) {
                                                                value = value.slice(0, 8) + ' ' + value.slice(8);
                                                            }
                                                            gcashReference.value = value;
                                                        });

                                                        // Remove spaces before submitting the form
                                                        document.getElementById('multiStepForm').addEventListener('submit', function() {
                                                            gcashReference.value = gcashReference.value.replace(/\s/g, ''); // Remove spaces
                                                        });
                                                    </script>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>


                            </div>
                        </div>

                        <div id="rooms" class="col-xl-8 col-lg-10 col-md-11 col-12 py-5">
                            <h5 class="text-dark dm-sans-text fw-bold mb-3">Related rooms from the same destination:</h5>
                            <div class="row g-3">
                                <?php foreach ($relatedRooms as $relatedRoom): ?>
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb">
                                        <div class="card card-shadow">
                                            <div class="img-container">
                                                <img src="../../businessowner/businessmediacategory/<?php echo htmlspecialchars($relatedRoom['image1']); ?>" class="card-img-top" alt="Room Image">
                                            </div>
                                            <div class="card-body">
                                                <h3 class="card-title m-0 p-0 fw-bold cormorant-text"><?php echo htmlspecialchars($relatedRoom['roomName']); ?></h3>
                                                <p class="card-text m-0 p-0 dm-sans-text text-secondary">Time Schedule: <?php echo date("g:i A", strtotime($relatedRoom['timeStart'])) . ' - ' . date("g:i A", strtotime($relatedRoom['timeEnd'])); ?></p>
                                                <p class="card-text m-0 p-0 dm-sans-text text-secondary">Max Adult: <?php echo htmlspecialchars($relatedRoom['adultMax']); ?></p>
                                                <p class="card-text m-0 p-0 dm-sans-text text-secondary">Max Children: <?php echo htmlspecialchars($relatedRoom['ChildrenMax']); ?></p>
                                                <h6 class="mt-3 dm-sans-text fw-bold text-secondary text-end">Price: <span class="text-danger">&#8369 <?php echo htmlspecialchars($relatedRoom['roomPrice']); ?></span>/Night</h6>
                                                <a href="../../resort/page-3.php?roomID=<?php echo $relatedRoom['roomID']; ?>&businessInfoID=<?php echo $businessInfoID; ?><?php echo isset($_SESSION['user_id']) ? '&userID=' . urlencode($_SESSION['user_id']) : ''; ?>" class="btn btn-book d-grid dm-sans-text rounded p-2">Book Now</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
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

        function fetchReservedDates(roomID) {
            return $.ajax({
                url: '../../backends/subadmin/fetch_reserved_dates.php',
                method: 'GET',
                data: {
                    roomID: roomID
                },
                dataType: 'json'
            });
        }

        function disableReservedDates(reservedDates) {
            $('#daterange').daterangepicker({
                locale: {
                    format: 'YYYY-MM-DD'
                },
                autoUpdateInput: false, // Prevents the input from being updated automatically
                minDate: moment().startOf('day'), // Disable past dates
                isInvalidDate: function(date) {
                    const dateString = date.format('YYYY-MM-DD');
                    return reservedDates.includes(dateString) || date.isBefore(moment(), 'day'); // Disable past dates and reserved dates
                },
                isCustomDate: function(date) {
                    const dateString = date.format('YYYY-MM-DD');
                    if (reservedDates.includes(dateString)) {
                        return 'booked-date'; // Apply custom class to reserved dates
                    }
                    return '';
                }
            });

            $('#daterange').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
                checkInputs(); // Check inputs after selecting date range
            });

            $('#daterange').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                checkInputs(); // Check inputs after canceling date range
            });
        }

        fetchBookedDates(roomID).done(function(response) {
            if (response.bookedDates) {
                disableBookedDates(response.bookedDates);
            }
        });

        fetchReservedDates(roomID).done(function(response) {
            if (response.status === 'success' && response.reservedDates) {
                disableReservedDates(response.reservedDates);
            } else {
                notyf.error('Failed to fetch reserved dates.');
            }
        }).fail(function() {
            notyf.error('An error occurred while fetching reserved dates.');
        });
    });
</script>
<style>
    .booked-date {
        background-color: red !important;
        color: white !important;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
<script src="../homepage/homepage.js"></script>

</html>