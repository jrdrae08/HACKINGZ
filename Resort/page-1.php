<?php
// Include the database connection
include '../includes/db.php';
session_start();

// Check if userID is set in the URL and store it in the session
if (isset($_GET['userID'])) {
    $_SESSION['user_id'] = $_GET['userID'];
}
// Get the businessInfoID from the URL, defaulting to 1 if not set
$businessInfoID = isset($_GET['businessInfoID']) ? (int) $_GET['businessInfoID'] : 1;

// Initialize facilities, features, and rooms as empty arrays
$facilities = [];
$features = [];
$rooms = [];

try {
    // Query to fetch business media and related business information based on businessInfoID
    $stmt = $pdo->prepare("
        SELECT bm.Thumbnail, bm.Quotation, bm.Image1, bm.Image2, bm.Image3, bm.Image4, bm.Image5, bm.Image6, 
               bif.BusinessName, bif.BusinessAddress, bif.BusinessContactNumber, bif.BusinessEmail
        FROM business_media bm
        JOIN businessinformationform bif ON bm.BusinessInfoID = bif.BusinessInfoID
        WHERE bif.BusinessInfoID = :businessInfoID
    ");
    $stmt->execute(['businessInfoID' => $businessInfoID]);
    $business = $stmt->fetch(PDO::FETCH_ASSOC);

    // Query to fetch facilities based on businessInfoID
    $stmtFacilities = $pdo->prepare("
        SELECT FacilityName
        FROM room_facilities
        WHERE BusinessInfoID = :businessInfoID
    ");
    $stmtFacilities->execute(['businessInfoID' => $businessInfoID]);
    $facilities = $stmtFacilities->fetchAll(PDO::FETCH_ASSOC);

    // Query to fetch features based on businessInfoID
    $stmtFeatures = $pdo->prepare("
        SELECT FeatureName
        FROM room_features
        WHERE BusinessInfoID = :businessInfoID
    ");
    $stmtFeatures->execute(['businessInfoID' => $businessInfoID]);
    $features = $stmtFeatures->fetchAll(PDO::FETCH_ASSOC);

    // Query to fetch rooms based on businessInfoID
    $stmtRooms = $pdo->prepare("
        SELECT roomID, roomName, roomPrice, adultMax, ChildrenMax, RoomDescriptions, image1, image2, image3, image4, image5, image6, timeStart, timeEnd
        FROM roominfotable
        WHERE BusinessInfoID = :businessInfoID
    ");
    $stmtRooms->execute(['businessInfoID' => $businessInfoID]);
    $rooms = $stmtRooms->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0.27/dist/fancybox.css" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0.27/dist/fancybox.umd.js"></script>
    <link rel="stylesheet" href="../../resort/new-resort-ui.css">

    <style>
        body {
            overflow-x: hidden;
            position: relative;
            /* width: 100%;
            height: 100vh; */
            background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.5)), url('../../businessowner/businessmediacategory/<?php echo htmlspecialchars($business['Thumbnail']); ?>');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            background-repeat: no-repeat;
        }

        #imageOverlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
            z-index: 1050;
            /* Ensure it's above the navbar */
        }

        /* css for image slider */
    </style>
</head>

<body>
    <main class="content">
        <?php include '../homepage/includes/main-nav.php'; ?>

        <section class="first-page mt-5" id="first-page">
            <div class="container-fluid">
                <div class="row page-nav-select d-flex justify-content-between align-items-center">
                    <div class="col-2 py-3 d-flex justify-content-center align-items-center">
                        <a href="../../resort/page-0.php?businessInfoID=<?php echo urlencode($businessInfoID); ?><?php echo isset($_SESSION['user_id']) ? '&userID=' . urlencode($_SESSION['user_id']) : ''; ?>">
                            <i class="bi bi-arrow-left-circle fw-bold text-light fs-1 text-shadow-light"></i>
                        </a>
                    </div>

                    <div class="col-xl-6 col-lg-6 col-10 py-3 align-items-center">
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-4 col-md-6 col-5 d-flex justify-content-center mb-3">
                                <a href="../../resort/page-2.php?businessInfoID=<?php echo urlencode($businessInfoID); ?><?php echo isset($_SESSION['user_id']) ? '&userID=' . urlencode($_SESSION['user_id']) : ''; ?>" class="page-nav text-light rounded-0 cormorant-text fw-bold text-shadow-light">Accommodations</a>
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
                            <h1 class="page-title  text-light cormorant-text fw-bold text-shadow-light text-center"><?php echo htmlspecialchars($business['BusinessName']); ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-light rounded-top rounded-top-3" id="destination-information">
            <div class="container-fluid">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8 col-md-10 col-11 py-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item dm-sans-text"><a href="../../resort/page-0.php">Destinations</a></li>
                                <li class="breadcrumb-item dm-sans-text active" aria-current="page"><?php echo htmlspecialchars($business['BusinessName']); ?></li>
                            </ol>
                        </nav>
                    </div>

                    <div class="col-lg-8 col-md-10 col-11 pb-3">
                        <div class="row g-2 d-flex justify-content-start">
                            <?php
                            $images = [
                                $business['Image1'],
                                $business['Image2'],
                                $business['Image3'],
                                $business['Image4'],
                                $business['Image5'],
                                $business['Image6']
                            ];
                            foreach ($images as $image) {
                                if ($image) {
                                    echo '<div class="col-lg-2 col-md-4 col-6">';
                                    echo '<a href="../../businessowner/businessmediacategory/' . htmlspecialchars($image) . '" data-fancybox="gallery">';
                                    echo '<img src="../../businessowner/businessmediacategory/' . htmlspecialchars($image) . '" class="img-fluid rounded object-fit-cover destinations-images" alt="Large Image">';
                                    echo '</a>';
                                    echo '</div>';
                                }
                            }
                            ?>
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

                    <!-- <div class="col-lg-8 col-md-10 col-11 mb-3">
                        <div class="card border border-secondary rounded ">
                            <div class="card-body">
                                <div class="flex-row">
                                    <a href="" class="text-dark mx-2 text-decoration-none dm-sans-text">Overview</a>
                                    <a href="#rooms" class="text-dark mx-2 text-decoration-none dm-sans-text">Rooms</a>
                                    <a href="" class="text-dark mx-2 text-decoration-none dm-sans-text">Posts</a>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="col-lg-8 col-md-10 col-11">
                        <div class="row d-flex justify-content-between">
                            <div class="col-lg-8 col-12 mb-3">
                                <div class="card border border-secondary rounded mb-3">
                                    <div class="card-body">
                                        <h3 class="text-dark dm-sans-text fw-bold"><?php echo htmlspecialchars($business['BusinessName']); ?></h3>
                                        <p class="text-dark dm-sans-text"><?php echo htmlspecialchars($business['BusinessAddress']); ?></p>
                                        <hr class="text-dark">
                                        <h6 class="text-dark dm-sans-text"><?php echo htmlspecialchars($business['Quotation']); ?></h6>
                                    </div>
                                </div>

                                <div class="card border border-secondary rounded mb-3">
                                    <div class="card-body">
                                        <h5 class="text-dark dm-sans-text fw-bold mb-4">Facilities</h5>
                                        <div class="row g-2 text-start">
                                            <?php if (!empty($facilities)): ?>
                                                <?php foreach ($facilities as $facility): ?>
                                                    <div class="col-lg-4 col-6">
                                                        <p><i class="bi bi-check-circle"></i> <?php echo htmlspecialchars($facility['FacilityName']); ?></p>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <p>No available facilities.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="card border border-secondary rounded">
                                    <div class="card-body">
                                        <h5 class="text-dark dm-sans-text fw-bold mb-4">Features</h5>
                                        <div class="row g-2 text-start">
                                            <?php if (!empty($features)): ?>
                                                <?php foreach ($features as $feature): ?>
                                                    <div class="col-lg-4 col-6">
                                                        <p><i class="bi bi-check-circle"></i> <?php echo htmlspecialchars($feature['FeatureName']); ?></p>
                                                    </div>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <p>No available features.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-lg-4 col-12 mb-3">
                                <div class="card border border-secondary rounded">
                                    <div class="card-body">
                                        <h5 class="text-dark text-center fw-bold dm-sans-text mb-3 bg-success-subtle rounded py-1">Business Information</h5>
                                        <h6 class="text-dark fw-bold dm-sans-text mb-3">Contact #:</h6>
                                        <h6 class="text-dark text-center dm-sans-text mb-3"><?php echo htmlspecialchars($business['BusinessContactNumber']); ?></h6>
                                        <?php if (!empty($business['BusinessEmail'])): ?>
                                            <h6 class="text-dark fw-bold dm-sans-text mb-3">Email Address:</h6>
                                            <h6 class="text-dark text-center dm-sans-text mb-3"><?php echo htmlspecialchars($business['BusinessEmail']); ?></h6>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="rooms" class="col-lg-8 col-md-10 col-11 mb-3">
                        <h5 class="text-dark dm-sans-text fw-bold ms-3 mb-3">Available Rooms</h5>
                        <div class="row g-3">
                            <?php if (!empty($rooms)): ?>
                                <?php foreach ($rooms as $room): ?>
                                    <div class="col-xl-3 col-lg-4 col-md-6 col-12 mb">
                                        <div class="card card-shadow">
                                            <div class="img-container">
                                                <img src="../../businessowner/businessmediacategory/<?php echo htmlspecialchars($room['image1']); ?>" class="card-img-top" alt="Room Image">
                                            </div>
                                            <div class="card-body">
                                                <h3 class="card-title m-0 p-0 fw-bold cormorant-text"><?php echo htmlspecialchars($room['roomName']); ?></h3>
                                                <p class="card-text m-0 p-0 dm-sans-text text-secondary">Time Schedule: <?php echo date("g:i A", strtotime($room['timeStart'])) . ' - ' . date("g:i A", strtotime($room['timeEnd'])); ?></p>
                                                <p class="card-text m-0 p-0 dm-sans-text text-secondary">Max Adult: <?php echo htmlspecialchars($room['adultMax']); ?></p>
                                                <p class="card-text m-0 p-0 dm-sans-text text-secondary">Max Children: <?php echo htmlspecialchars($room['ChildrenMax']); ?></p>
                                                <h6 class="mt-3 dm-sans-text fw-bold text-secondary text-end">Price: <span class="text-danger">&#8369 <?php echo htmlspecialchars($room['roomPrice']); ?></span>/Night</h6>
                                                <a href="../../resort/page-3.php?roomID=<?php echo $room['roomID']; ?>&businessInfoID=<?php echo $businessInfoID; ?><?php echo isset($_SESSION['user_id']) ? '&userID=' . urlencode($_SESSION['user_id']) : ''; ?>" class="btn btn-book d-grid dm-sans-text rounded p-2">Book Now</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No available rooms.</p>
                            <?php endif; ?>
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


<script>

</script>

</html>