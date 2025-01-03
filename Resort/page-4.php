<?php

include '../includes/db.php';
session_start();

// Get the barangayID from the URL, defaulting to 1 if not set
$barangayID = isset($_GET['barangayID']) ? (int) $_GET['barangayID'] : 1;

// Fetch establishment name, address, contact, quotation, and images from the database
$business = [];
if ($barangayID) {
    // Query to fetch establishment name, address, contact, quotation, and images based on barangayID
    $stmt = $pdo->prepare("
        SELECT ba.establishment, ba.address, ba.contact, bm.Quotation, bm.Thumbnail, bm.Image1, bm.Image2, bm.Image3, bm.Image4, bm.Image5, bm.Image6
        FROM barangay_accounts ba
        JOIN business_media bm ON ba.barangayId = bm.barangayId
        WHERE ba.barangayId = :barangayID
    ");
    $stmt->execute(['barangayID' => $barangayID]);
    $business = $stmt->fetch(PDO::FETCH_ASSOC);
}

$establishment = $business['establishment'] ?? '';
$address = $business['address'] ?? '';
$contact = $business['contact'] ?? '';
$quotation = $business['Quotation'] ?? '';
$thumbnail = $business['Thumbnail'] ?? '';
$images = [
    $business['Image1'] ?? '',
    $business['Image2'] ?? '',
    $business['Image3'] ?? '',
    $business['Image4'] ?? '',
    $business['Image5'] ?? '',
    $business['Image6'] ?? ''
];

// Fetch highlights based on barangayID and IsActive = 1
$highlights = [];
if ($barangayID) {
    $stmtHighlights = $pdo->prepare("
        SELECT HighlightName
        FROM highlights
        WHERE BarangayID = :barangayID AND IsActive = 1
    ");
    $stmtHighlights->execute(['barangayID' => $barangayID]);
    $highlights = $stmtHighlights->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch other tourist spots (falls) except the current barangayID
$otherFalls = [];
$stmtOtherFalls = $pdo->prepare("
    SELECT ba.barangayId, ba.establishment, bm.Thumbnail, bm.Quotation
    FROM barangay_accounts ba
    JOIN business_media bm ON ba.barangayId = bm.barangayId
    WHERE ba.barangayId != :barangayID
");
$stmtOtherFalls->execute(['barangayID' => $barangayID]);
$otherFalls = $stmtOtherFalls->fetchAll(PDO::FETCH_ASSOC);
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
            background: linear-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.5)), url('../../barangay/fallsCategory/<?php echo htmlspecialchars($thumbnail); ?>');
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
    </style>
</head>

<body>
    <main class="content">
        <?php include '../homepage/includes/main-nav.php'; ?>

        <section class="first-page mt-5" id="first-page">
            <div class="container-fluid">
                <div class="row page-nav-select d-flex justify-content-between align-items-center">
                    <div class="col-2 py-3 d-flex justify-content-center align-items-center">
                        <a href="../../resort/page-0.php<?php echo isset($_SESSION['user_id']) ? '?userID=' . urlencode($_SESSION['user_id']) : ''; ?>">
                            <i class="bi bi-arrow-left-circle fw-bold text-light fs-1 text-shadow-light"></i>
                        </a>
                    </div>
                </div>

                <div class="first-page-title pb-5">
                    <div class="row  d-flex justify-content-center">
                        <div class="col-lg-12 d-flex justify-content-center">
                            <h1 class="page-title  text-light cormorant-text fw-bold text-shadow-light text-center"><?php echo htmlspecialchars($establishment); ?></h1>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-light rounded-top rounded-top-3" id="destination-information">
            <div class="container-fluid">
                <div class="row d-flex justify-content-center">
                    <div class="col-xl-8 col-lg-9 col-md-10 col-11 py-3">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item dm-sans-text"><a href="../../resort/page-0.php">Destinations</a></li>
                                <li class="breadcrumb-item dm-sans-text active" aria-current="page-4.php"><?php echo htmlspecialchars($establishment); ?></li>
                            </ol>
                        </nav>
                    </div>

                    <div class="col-xl-8 col-lg-10 col-md-11 col-12 mb-3">
                        <div class="card">
                            <div class="card-body">

                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8 col-lg-10 col-md-11 col-12 pb-3">
                        <div class="row d-flex justify-content-center">
                            <div class="col-xl-5 col-lg-6 col-12 pb-3">
                                <a href="../../barangay/fallsCategory/<?php echo htmlspecialchars($thumbnail); ?>" data-fancybox="gallery">
                                    <img src="../../barangay/fallsCategory/<?php echo htmlspecialchars($thumbnail); ?>" class="img-fluid rounded object-fit-cover h-100" alt="Thumbnail Image">
                                </a>
                            </div>
                            <div class="col-xl-7 col-lg-6 col-12 mb-3">
                                <div class="card border border-secondary rounded mb-3">
                                    <div class="card-body">
                                        <h3 class="text-dark dm-sans-text fw-bold"> <?php echo htmlspecialchars($establishment); ?></h3>
                                        <p class="text-dark dm-sans-text pb-0 mb-0">Location: <?php echo htmlspecialchars($address); ?></p>
                                        <p class="text-dark dm-sans-text pb-0 mb-0">Contact Number: <?php echo htmlspecialchars($contact); ?></p>
                                        <hr class="text-dark">
                                        <h6 class="text-dark dm-sans-text">Descriptions:</h6>
                                        <p class="text-dark dm-sans-text"> <?php echo htmlspecialchars($quotation); ?></p>
                                        <h6 class="text-dark dm-sans-text fw-bold">Highlights</h6>
                                        <ul class="text-dark dm-sans-text list-unstyled">
                                            <?php foreach ($highlights as $highlight): ?>
                                                <li class="text-dark dm-sans-text"><i class="bi bi-check"></i> <?php echo htmlspecialchars($highlight['HighlightName']); ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 mb-3">
                                <h5 class="text-dark fw-bold dm-sans-text">More Images:</h5>
                                <div class="row g-3">
                                    <?php foreach ($images as $image): ?>
                                        <?php if (!empty($image)): ?>
                                            <div class="col-xl-3 col-lg-4 col-md-6 col-12 justify-content-start">
                                                <a href="../../barangay/fallsCategory/<?php echo htmlspecialchars($image); ?>" data-fancybox="gallery">
                                                    <img src="../../barangay/fallsCategory/<?php echo htmlspecialchars($image); ?>" class="img-fluid object-fit-cover h-100 rounded shadow" alt="Business Image">
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
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

                            <div id="" class="col-xl-12 mb-3">
                                <h5 class="text-dark dm-sans-text fw-bold mb-3 mt-5">Other Tourist Spots:</h5>
                                <div class="row g-3">
                                    <?php foreach ($otherFalls as $fall): ?>
                                        <div class="col-xl-3 col-lg-4 col-md-4 col-12 mb-2 d-flex justify-content-center">
                                            <div class="card card-shadow">
                                                <div class="img-container">
                                                    <a href="../../resort/page-4.php?barangayID=<?php echo $fall['barangayId']; ?><?php echo isset($_SESSION['user_id']) ? '&userID=' . urlencode($_SESSION['user_id']) : ''; ?>">
                                                        <img src="../../barangay/fallsCategory/<?php echo htmlspecialchars($fall['Thumbnail']); ?>" class="card-img-top" alt="Room Image">
                                                    </a>
                                                </div>
                                                <div class="card-body">
                                                    <h3 class="card-title m-0 p-0 fw-bold cormorant-text mb-3"><?php echo htmlspecialchars($fall['establishment']); ?></h3>
                                                    <p class="text-dark dm-sans-text pb-0 mb-0"><?php echo htmlspecialchars($fall['Quotation']); ?></p>
                                                    <a href="../../resort/page-4.php?barangayID=<?php echo $fall['barangayId']; ?><?php echo isset($_SESSION['user_id']) ? '&userID=' . urlencode($_SESSION['user_id']) : ''; ?>" class="btn btn-book d-grid dm-sans-text rounded p-2">Visit</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
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