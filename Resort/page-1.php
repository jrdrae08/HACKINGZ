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

try {
    // Query to fetch business media and related business information based on businessInfoID
    $stmt = $pdo->prepare("
        SELECT bm.Thumbnail, bm.Quotation, bif.BusinessName
        FROM business_media bm
        JOIN businessinformationform bif ON bm.BusinessInfoID = bif.BusinessInfoID
        WHERE bif.BusinessInfoID = :businessInfoID
    ");
    $stmt->execute(['businessInfoID' => $businessInfoID]);
    $business = $stmt->fetch(PDO::FETCH_ASSOC);
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
    </style>
</head>

<body>
    <main class="content">
        <!-- <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
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

                <div class="first-page-title">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <h1 class="title-text-1 text-light cormorant-text fw-bold text-shadow-light text-center"><?php echo htmlspecialchars($business['BusinessName']); ?></h1>
                        </div>
                        <div class="col-lg-12 d-flex justify-content-center align-items-center">
                            <h3 class="title-text-2 dm-sans-text text-shadow-light text-center"><?php echo htmlspecialchars($business['Quotation']); ?></h3>
                        </div>
                        <div class="col-lg-12 mt-3 d-flex justify-content-center align-items-center">
                            <a href="page-2.php?businessInfoID=<?php echo urlencode($businessInfoID); ?><?php echo isset($_SESSION['user_id']) ? '&userID=' . urlencode($_SESSION['user_id']) : ''; ?>" class="btn btn-success mx-2 rounded dm-sans-text text-center">View More</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <!-- <section class="footer-container bg-success">
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
        </section> -->
    </main>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/typed.js@2.1.0/dist/typed.umd.js"></script>
<script src="../homepage/homepage.js"></script>


<script>

</script>

</html>