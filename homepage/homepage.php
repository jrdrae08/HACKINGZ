<?php
include __DIR__ . '/../includes/db.php';

// Retrieve the userID from the URL or session
$userID = isset($_GET['userID']) ? intval($_GET['userID']) : (isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : null);

$sql = "SELECT * FROM frontpagecontent ORDER BY frontpageid DESC LIMIT 1";
$stmt = $pdo->query($sql);
$content = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <link rel="stylesheet" href="../homepage/homepage.css">
    <style>
        .no-caret::after {
            display: none !important;
        }
    </style>
</head>

<body>
    <main class="content">
        <!-- aside nav -->
        <?php include '../homepage/includes/main-nav.php'; ?>

        <section id="home" class="homepage-container">
            <div class="container-fluid">
                <div class="row d-flex justify-content-evenly align-items-center" style="margin-top: 75px;">
                    <div class="col-xl-5 col-lg-6 col-md-12 ">
                        <div class="home-header text-center mx-4">
                            <h1 class="display-5 noto-serif-hentaigana">Visit the Beautiful Place of<br><span class="element poetsen-one-regular"></span></h1>
                            <p class="main-text dm-sans-text text-light" style=" text-align: center; font-size: 20px;"><?= htmlspecialchars($content['description']) ?></p>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6 col-md-12 collection m-0 p-0">
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                <div class="content swiper-slide">
                                    <img class="slider-img" src="../../admin/uploadannounce/<?= htmlspecialchars($content['slider_image_1']) ?>" alt="Slider Image 1">
                                    <div class="text-content">
                                        <h3 class="poetsen-one-regular text-success"><?= htmlspecialchars($content['slider_title_1']) ?></h3>
                                        <p class="mx-2"><?= htmlspecialchars($content['slider_content_1']) ?></p>
                                        <a href="../Resort/page-0.php<?= $isLoggedIn ? '?userID=' . htmlspecialchars($userID) : '' ?>" class="text-decoration-none text-success">Discover more ></a>

                                    </div>
                                </div>
                                <div class="content swiper-slide">
                                    <img class="slider-img" src="../../admin/uploadannounce/<?= htmlspecialchars($content['slider_image_2']) ?>" alt="Slider Image 2">
                                    <div class="text-content">
                                        <h3 class="poetsen-one-regular text-success"><?= htmlspecialchars($content['slider_title_2']) ?></h3>
                                        <p class="mx-2"><?= htmlspecialchars($content['slider_content_2']) ?></p>
                                        <a href="../Resort/page-0.php<?= $isLoggedIn ? '?userID=' . htmlspecialchars($userID) : '' ?>" class="text-decoration-none text-success">Discover more ></a>

                                    </div>
                                </div>
                                <div class="content swiper-slide">
                                    <img class="slider-img border" src="../../admin/uploadannounce/<?= htmlspecialchars($content['slider_image_3']) ?>" alt="Slider Image 3">
                                    <div class="text-content">
                                        <h3 class="poetsen-one-regular text-success"><?= htmlspecialchars($content['slider_title_3']) ?></h3>
                                        <p class="mx-2"><?= htmlspecialchars($content['slider_content_3']) ?></p>
                                        <a href="../Resort/page-0.php<?= $isLoggedIn ? '?userID=' . htmlspecialchars($userID) : '' ?>" class="text-decoration-none text-success">Discover more ></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="discover" class="discover-container rounded-top rounded-top-5">
            <div class="container-fluid">
                <div class="row d-flex d-flex justify-content-center py-4 g-3">
                    <div class="col-12">
                        <div class="text-center">
                            <h4 class="text-success fw-bold">DISCOVER</h4>
                            <h4 class="text-dark">Our Tourist Destinations</h4>
                            <p class="text-secondary">Explore Majayjay&apos;s rich history, scenic beauty, and cultural attractions, offering a perfect mix of adventure and relaxation for every traveler.</p>

                        </div>
                    </div>
                    <div class="col-lg-9 col-11 discover-content py-3 d-flex justify-content-center align-items-center">
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-5 col-md-6 col-12">
                                <img src="../img/homepage/resort.jpg" class="img-fluid object-fit-cover rounded shadow" alt="" style="max-height: 400px; width: auto;">
                            </div>
                            <div class="col-md-6 col-12 my-3 text-dark text-center d-flex flex-column justify-content-center align-items-center">
                                <h1 class="fw-bold">Relaxing Resorts</h1>
                                <p>A luxurious and relaxing vacation experience awaits those seeking the perfect blend of comfort, elegance, and adventure. This destination offers premium accommodations designed to provide the utmost relaxation, featuring spacious suites, private villas, and beautifully appointed rooms with breathtaking views of the surrounding landscape. Whether overlooking pristine beaches, lush gardens, or majestic mountains, every guest is treated to a serene atmosphere that enhances their stay.

                                    The resort boasts world-class amenities, including infinity pools, rejuvenating spas, and private cabanas where guests can unwind while enjoying personalized service. Fine dining is an essential part of the experience, with a variety of gourmet restaurants offering exquisite cuisine prepared by top chefs. From lavish breakfast buffets to candlelit dinners by the sea, every meal is a culinary delight, featuring fresh, locally sourced ingredients and flavors from around the world.</p>
                                <a href="../Resort/page-0.php?tab=resort" class="text-decoration-none text-success fw-bold">Discover more ></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9 col-11 discover-content py-3 d-flex justify-content-center align-items-center">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-6 col-12 my-3 text-dark text-center d-flex flex-column justify-content-center align-items-center">
                                <h1 class="fw-bold">Beautiful Farms</h1>
                                <p>A peaceful rural escape, this destination offers a perfect retreat for those looking to reconnect with nature and experience the simple joys of countryside living. Surrounded by breathtaking scenic landscapes, rolling hills, and lush greenery, visitors can immerse themselves in a tranquil environment far from the noise and stress of urban life. The area is well-known for its immersive farm tours, where guests can explore working farms, learn about sustainable agriculture, and engage in hands-on experiences such as planting crops, feeding animals, and harvesting fresh produce.</p>
                                <a href="../Resort/page-0.php?tab=farms" class="text-decoration-none text-success fw-bold">Discover more ></a>
                            </div>

                            <div class="col-lg-5 col-md-6 col-12 pb-3">
                                <img src="../img/homepage/farm.jpg" class="img-fluid object-fit-cover rounded shadow" alt="" style="max-height: 400px; width: auto;">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9 col-11 discover-content py-3 d-flex justify-content-center align-items-center">
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-5 col-md-6 col-12">
                                <img src="../img/homepage/waterfall.webp" class="img-fluid object-fit-cover rounded shadow" alt="" style="max-height: 400px; width: auto;">
                            </div>
                            <div class="col-md-6 col-12  my-3 text-dark text-center py-3 d-flex flex-column justify-content-center align-items-center">
                                <h1 class="fw-bold">Amazing Waterfalls</h1>
                                <p>Majayjay is a picturesque town known for its breathtaking natural beauty, lush greenery, and crystal-clear, cool waters that provide a refreshing escape from the hustle and bustle of city life. Nestled at the foot of Mount Banahaw, this charming destination is a favorite among nature lovers, adventure seekers, and those looking for a serene retreat. The area boasts scenic hiking trails that lead through dense forests, offering stunning views of cascading waterfalls and vibrant flora. Visitors can take a dip in the invigoratingly cold waters of its famous streams and falls, perfect for relaxation and rejuvenation. Whether exploring its hidden trails, enjoying a peaceful picnic by the riverside, or simply breathing in the fresh mountain air, Majayjay offers an unforgettable experience for those seeking both adventure and tranquility in the heart of nature.</p>
                                <a href="../Resort/page-0.php?tab=falls" class="text-decoration-none text-success fw-bold">Discover more ></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-center">
                        <a href="../Resort/page-0.php" class="btn text-light btn-success shadow text-center mb-3">See More</a>
                    </div>
                </div>
        </section>

        <section id="about" class="about-container">
            <div class="container-fluid py-5 bg-success-subtle">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-4 col-md-5 col-12 mb-5 mb-lg-0" style="min-height: 500px;">
                        <div class=" h-100 text-center">
                            <img class="w-100 h-100" src="../img/general-img/majayjay-church.jpg" style="object-fit: cover;">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6 col-11 d-flex align-items-center">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="text-success fw-bold text-start">ABOUT US</h4>
                            </div>
                            <div class="col-12">
                                <p class="about-content text-dark">Ayon sa matandang kasaysayan ang pangalang Majayjay Barangay ay napalitan ng pangalang Mahayhay o Majayjay nang dumating ang mga Kastila sa ating bansa. Ang mga nagtutungo sa Majayjay ay inilululan sa duyan o hamaka dahol sa lubhang mataas ang inaahong mga bundok na kinalalagyan ng lugar na iyon. Dahil nga sa mahabang pag-ahon at mabigat ang kanilang dala ang mga naglalakbay ay nagpatuloy sa pagtaghoy ng hay , hay, hay, na nagpapakilalang sila ay hirap na hirap sa kanilang pag lalakad
                                    Nang ang mga kastila ay kasalukuyang nagpapalaganap ng pananakop sa bayan ng Majayjay, sila ay hindi lamang sa inaahong mga bundok nahihirapan kundi gayon din sa madawas at maliliit na daan, gayon din sa mga baku-bakong sapa at ilog at maliit na tinatawid. Dahil nga sa hirap na kanilang dinaranas ay napilitan silang magpahinga at inaalis ang pagod sa paghinga ng malalim at pagtaghoy ng hay, hay. hay.
                                    Kapag tinatanong noon ang isang tagapag-buhat kung anong masasabi tungkol sa pook ng iyon, nga ang isinasagot ay maraming hay, hay muna bago dumating doon. At dito nagsimula ang pangalan ng bayan ng Majayjay. </p>
                            </div>
                            <div class="col-12 text-center ">
                                <a href="#contact" class="btn btn-success text-light shadow">Get in Touch</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="carousel-container bg-light py-2">
            <style>
                .carousel-item img {
                    height: 900px;
                    /* Set a fixed height */
                    object-fit: cover;
                    /* Ensures the image covers the area */
                    width: 100%;
                    /* Ensures full width */
                }

                @media screen and (max-width: 768px) {
                    .carousel-item img {
                        height: 300px;
                    }

                }
            </style>

            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../img/general-img/image-1.jpg" class="d-block w-100" alt="Image 1">
                    </div>
                    <div class="carousel-item">
                        <img src="../img/general-img/image-5.jpg" class="d-block w-100" alt="Image 2">
                    </div>
                    <div class="carousel-item">
                        <img src="../img/general-img/image-3.jpg" class="d-block w-100" alt="Image 3">
                    </div>
                    <div class="carousel-item">
                        <img src="../img/general-img/image-6.jpg" class="d-block w-100" alt="Image 4">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </section>

        <!-- <section id="service" class="service-container py-4">
            <div class="container-fluid">
                <h4 class="text-center text-success fw-bold">OUR SERVICES</h4>
                <div class="service-cards">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-3 d-flex justify-content-center">
                            <a href="../businessowner/business-registration.php" class="text-decoration-none">
                                <div class="card mb-3 rounded-0 shadow" style="width: 18rem;">
                                    <img src="../img/homepage/business-registration.jpg" class="card-img-top rounded-0 " alt="...">
                                    <div class="card-body">
                                        <p class="text-success text-start fw-bold">Business Registration</p>
                                        <p class="card-text text-dark text-start">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <div class="col-lg-3 d-flex justify-content-center mb-sm-3">
                            <a href="../Resort/page-0.php" class="text-decoration-none">
                                <div class="card rounded-0 shadow" style="width: 18rem;">
                                    <img src="../img/homepage/online-reservation.jpg" class="card-img-top rounded-0 " alt="...">
                                    <div class="card-body">
                                        <p class="text-success text-start fw-bold">Online Reservation</p>
                                        <p class="card-text text-dark text-start">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section> -->

        <section id="contact" class="contact-container">
            <div class="container-fluid p-5 bg-success-subtle">
                <div class="row justify-content-evenly">


                    <div class="col-lg-3 col-sm-12 mb-4">
                        <h5 class="text-start text-success fw-bold">NAVIGATIONS</h5>

                        <ul class="text-decoration-none" style="list-style: none; padding: 0; margin: 0;">
                            <li>
                                <a href="../homepage/homepage.php<?= $isLoggedIn ? '?userID=' . htmlspecialchars($userID) : '' ?>" class="text-decoration-none text-dark me-2 d-flex align-items-center">
                                    <i class="bi bi-house-fill fs-3 me-3"></i>
                                    <p class="text-dark m-0">Home</p>
                                </a>
                            </li>

                            <li>
                                <a href="../Resort/page-0.php<?= $isLoggedIn ? '?userID=' . htmlspecialchars($userID) : '' ?>" class="text-decoration-none text-dark me-2 d-flex align-items-center">
                                    <i class="bi bi-signpost-2-fill fs-3 me-3"></i>
                                    <p class="text-dark m-0">View Destinations</p>
                                </a>
                            </li>
                            <li>
                                <a href="../businessowner/business-registration.php" class="text-decoration-none text-dark me-2 d-flex align-items-center">
                                    <i class="bi bi-briefcase-fill fs-3 me-3"></i>
                                    <p class="text-dark m-0">Register your Business</p>
                                </a>
                            </li>
                            <li>
                                <a href="" class="text-decoration-none text-dark me-2 d-flex align-items-center">
                                    <i class="bi bi-person-circle fs-3 me-3"></i>
                                    <p class="text-dark m-0">Sign In</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-lg-3 col-sm-12 mb-4">
                        <h5 class="text-start text-success fw-bold">KEEP CONNECTED</h5>

                        <ul class="text-decoration-none" style="list-style: none; padding: 0; margin: 0;">
                            <li>
                                <a href="" class="text-decoration-none text-dark me-2 d-flex align-items-center">
                                    <i class="bi bi-facebook fs-3 me-3"></i>
                                    <p class="text-dark m-0">Like us on Facebook</p>
                                </a>
                            </li>

                            <li>
                                <a href="" class="text-decoration-none text-dark me-2 d-flex align-items-center">
                                    <i class="bi bi-twitter fs-3 me-3"></i>
                                    <p class="text-dark m-0">Follow us on Twitter</p>
                                </a>
                            </li>
                            <li>
                                <a href="" class="text-decoration-none text-dark me-2 d-flex align-items-center">
                                    <i class="bi bi-instagram fs-3 me-3"></i>
                                    <p class="text-dark m-0">Follow us on Instagram</p>
                                </a>
                            </li>
                            <li>
                                <a href="" class="text-decoration-none text-dark me-2 d-flex align-items-center">
                                    <i class="bi bi-youtube fs-3 me-3"></i>
                                    <p class="text-dark m-0">Subscribe us on Youtube</p>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-sm-12 mb-4">
                        <h5 class="text-start text-success fw-bold">CONTACT INFORMATION</h5>
                        <ul class="text-decoration-none" style="list-style: none; padding: 0; margin: 0;">
                            <li>
                                <a href="" class="text-decoration-none text-dark me-2 d-flex align-items-center">
                                    <i class="bi bi-geo-alt-fill fs-3 me-3"></i>
                                    <p class="text-dark m-0">Plaza Rizal Street, Majayjay, Philippines</p>
                                </a>
                            </li>
                            <li>
                                <a href="" class="text-decoration-none text-dark me-2 d-flex align-items-center">
                                    <i class="bi bi-telephone-fill fs-3 me-3"></i>
                                    <p class="text-dark m-0">0917 548 0086</p>
                                </a>
                            </li>
                            <li>
                                <a href="" class="text-decoration-none text-dark me-2 d-flex align-items-center">
                                    <i class="bi bi-envelope-at-fill fs-3 me-3"></i>
                                    <p class="text-dark m-0">majayjaytourism1571@gmail.com</p>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-sm-12 bg-light">
                        <div class="row p-2">
                            <div class="col-12" id="googleMap" style="width:100%;height:300px;"></div>
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
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section class="footer-container bg-success">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 d-flex justify-content-center mt-2">
                        <p>Copyright &copy; Tourism Office of Majayjay, Laguna. 2025 All Rights Reserved.</p>
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
    // Function to toggle the 'scrolled' class on the navbar when scrolling
    window.addEventListener('scroll', function() {
        const navbar = document.querySelector('.custom-navbar');

        // Check if the page is scrolled down
        if (window.scrollY > 50) { // Adjust the value as needed
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });
</script>

</html>