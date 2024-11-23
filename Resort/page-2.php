<?php
// Include the database connection
include '../includes/db.php';

// Get the businessInfoID from the URL, defaulting to 1 if not set
$businessInfoID = isset($_GET['businessInfoID']) ? (int) $_GET['businessInfoID'] : 1;

try {
    // Query to fetch room information based on businessInfoID
    $stmt = $pdo->prepare("
        SELECT roomID, roomName, roomPrice, RoomDescriptions, image1, timeStart, timeEnd, adultMax, ChildrenMax
        FROM roominfotable
        WHERE BusinessInfoID = :businessInfoID
    ");
    $stmt->execute(['businessInfoID' => $businessInfoID]);
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Query to fetch business name and thumbnail
    $stmt = $pdo->prepare("
        SELECT bif.BusinessName, bm.Thumbnail
        FROM businessinformationform bif
        JOIN business_media bm ON bif.BusinessInfoID = bm.BusinessInfoID
        WHERE bif.BusinessInfoID = :businessInfoID
    ");
    $stmt->execute(['businessInfoID' => $businessInfoID]);
    $businessInfo = $stmt->fetch(PDO::FETCH_ASSOC);
    $businessName = $businessInfo['BusinessName'] ?? 'Unknown Business';
    $thumbnail = $businessInfo['Thumbnail'] ?? 'default-thumbnail.jpg'; // Provide a default thumbnail if not available
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
    <link rel="stylesheet" href="../css/businessowner.css">
    <style>
        .custom-img img {
            height: 400px;
            object-fit: cover;
        }

        body {
            overflow-x: hidden;
            position: relative;
            /* width: 100%;
            height: 100vh; */
            background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.5)), url('../../businessowner/businessmediacategory/<?php echo htmlspecialchars($thumbnail); ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        .text-truncate-8 {
            display: -webkit-box;
            -webkit-line-clamp: 6;
            /* Number of lines to show */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .btn-book {
            background-color: #ffffff;
        }

        .btn-book:hover {
            background-color: #198754;
            color: #ffffff;
        }
    </style>
</head>

<body>
    <main class="content">
        <!-- <nav class="navbar navbar-expand-lg">
            <div class="container-fluid my-1">
                <a class="navbar-brand ms-5 text-light" href="#">
                    <img src="../majayjay-logo.webp" alt="Majayjay Logo" height="50">
                    <span>Majayjay,Laguna</span>
                </a>
                <button class="navbar-toggler shadow" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link text-light btn btn-nav btn-success shadow" href="#">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light btn btn-nav btn-success shadow" href="#service">SERVICES</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light btn btn-nav btn-success shadow" href="#about">ABOUT</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-light btn btn-nav btn-success shadow" href="#contact">CONTACT</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav> -->

        <section class="first-page" id="first-page">
            <div class="container-fluid">
                <div class="row d-flex justify-content-between align-items-center">
                    <div class="col-2 py-3 d-flex justify-content-center align-items-center">
                        <a href="../../resort/page-1.php?businessInfoID=<?php echo $businessInfoID; ?>">
                            <i class="bi bi-arrow-left-circle fw-bold text-light fs-1 text-shadow-light"></i>
                        </a>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-10 py-3 align-items-center">
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-4 col-md-6 col-5 d-flex justify-content-center mb-3">
                                <a href="../../resort/page-2.php" class="page-nav active  text-light rounded-0 cormorant-text fw-bold text-shadow-light">Accommodations</a>
                            </div>
                            <div class="col-lg-2 col-md-6 col-5 d-flex justify-content-center mb-3">
                                <a href="" class="page-nav text-light rounded-0 cormorant-text fw-bold text-shadow-light">Events</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-title-container">
                    <h1 class="page-title text-light text-center cormorant-text fw-bold ">Available Rooms</h1>
                </div>
            </div>
        </section>

        <section class="accommodation-page-title shadow">
            <div class="accommodation-nav bg-success m-0 py-3">
                <div class="d-flex justify-content-center">
                    <a href="../../resort/page-1.php?businessInfoID=<?php echo $businessInfoID; ?>" class="text-decoration-none">
                        <h3 class="nav text-light text-nav mx-3 dm-sans-text">Home ></h3>
                    </a>
                    <a href="../../resort/page-3.php?roomID=<?php echo $room['roomID']; ?>&businessInfoID=<?php echo $businessInfoID; ?>" class="text-decoration-none">
                        <h3 class="nav text-nav text-light dm-sans-text">Accommodations</h3>
                    </a>
                </div>
            </div>
            <div class="container-fluid">
                <div class="row room-lists d-flex justify-content-center bg-secondary-subtle align-items-center">
                    <div class="col-xxl-8 col-xl-10 col-lg-10 col-md-11 col-md-12">
                        <div class="row">
                            <h1 class="text-color-1 cormorant-text fw-bold">Rooms:</h1>
                            <?php foreach ($rooms as $room): ?>
                                <div class="col-xl-4 col-lg-6 col-md-6 col-sm-10 my-4 d-flex justify-content-center">
                                    <div class="card card-trans shadow custom-card-height rounded-0 overflow-hidden">
                                        <div class="img-container">
                                            <img src="<?php echo htmlspecialchars($room['image1']); ?>" class="card-img-top rounded-0" alt="Room Image">
                                        </div>
                                        <div class="card-body">
                                            <div class="price-overlay shadow bg-light rounded-5">
                                                <h5 class="p-2 text-center dm-sans-text fw-bold text-secondary">Price: <span class="text-danger">&#8369 <?php echo number_format(htmlspecialchars($room['roomPrice']), 2, '.', ','); ?></span>/Night</h5>
                                            </div>
                                            <h3 class="card-title text-color-1 fw-bold cormorant-text"><?php echo htmlspecialchars($room['roomName']); ?></h3>
                                            <p class="card-text dm-sans-text text-secondary">Time Schedule: <span class="fw-bold"><?php echo date("g:i A", strtotime($room['timeStart'])) . " to " . date("g:i A", strtotime($room['timeEnd'])); ?></span></p>
                                            <p class="card-text dm-sans-text text-secondary">Max Adult: <span class="fw-bold"><?php echo htmlspecialchars($room['adultMax']); ?></span></p>
                                            <p class="card-text dm-sans-text text-secondary">Max Children: <span class="fw-bold"><?php echo htmlspecialchars($room['ChildrenMax']); ?></span></p>
                                            <a href="../../resort/page-3.php?roomID=<?php echo $room['roomID']; ?>&businessInfoID=<?php echo $businessInfoID; ?>" class="btn btn-book fw-bold dm-sans-text rounded-0 py-3 px-4">BOOK NOW</a>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="contact-container shadow">
            <div class="container-fluid p-5 bg-success-subtle">
                <div class="row justify-content-evenly">
                    <div class="col-lg-4 col-sm-5 gx-5 mb-4">
                        <div class="col-12">
                            <h5 class="text-start text-success fw-bold dm-sans-text">CONTACT US</h5>
                        </div>
                        <div class="col-12">
                            <h3 class="text-start text-dark cormorant-text">Get in touch with us</h3>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="text" class="form-label text-start text-dark dm-sans-text ms-2">Name</label>
                            <input type="text" class="form-control shadow" name="" placeholder="Juan Dela Cruz">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="email" class="form-label text-start text-dark dm-sans-text ms-2">Email address</label>
                            <input type="email" class="form-control shadow" name="" placeholder="name@example.com">
                        </div>
                        <div class="col-12 mb-3">
                            <label for="contact" class="form-label text-start text-dark dm-sans-text ms-2">Phone number</label>
                            <input type="number" class="form-control shadow" name="" placeholder="09123456789">
                        </div>
                        <div class="col-12 mb-5">
                            <label for="message" class="form-label text-start text-dark dm-sans-text ms-2">Message</label>
                            <textarea class="form-control shadow" name="" rows="3"></textarea>
                        </div>
                        <div class="col-12 mb-1 d-grid">
                            <button class="btn btn-success shadow dm-sans-text">Submit</button>
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
                                <p class="text-start text-dark fw-bold mt-3 dm-sans-text">Contact us</p>
                                <p><i class="bi bi-envelope-at text-dark me-2"></i><a href="" class="text-dark dm-sans-text">majayjaylaguna@gmail.com</a></p>
                            </div>
                            <div class="col-12 ">
                                <p class="text-start text-dark fw-bold mt-2 dm-sans-text">Location</p>
                                <p><i class="bi bi-geo-alt text-dark me-2"></i><a href="" class="text-dark dm-sans-text">Majayjay, Laguna, Philippines</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="footer-container bg-success">
            <div class="container-fluid ">
                <div class="row ">
                    <div class="col-6 text-start mt-2">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
<script src="../homepage/homepage.js"></script>

</html>