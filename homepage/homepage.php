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
                <div class="row d-flex justify-content-center align-items-center" style="margin-top: 75px;">
                    <div class="col-lg-5">
                        <div class="home-header text-center mx-4">
                            <h1 class="display-1 jaro-font">WELCOME TO <br><span class="element poetsen-one-regular"></span></h1>
                            <p class="main-text dm-sans-text text-light" style=" text-align: center;"><?= htmlspecialchars($content['description']) ?></p>
                        </div>
                    </div>
                    <div class="col-lg-6 collection m-0 p-0">
                        <div class="swiper mySwiper">
                            <div class="swiper-wrapper">
                                <div class="content swiper-slide">
                                    <img class="slider-img" src="../../admin/uploadannounce/<?= htmlspecialchars($content['slider_image_1']) ?>" alt="Slider Image 1">
                                    <div class="text-content">
                                        <h3 class="poetsen-one-regular text-success"><?= htmlspecialchars($content['slider_title_1']) ?></h3>
                                        <p class="mx-2"><?= htmlspecialchars($content['slider_content_1']) ?></p>
                                        <button class="btn btn-visit px-4 text-light shadow">VISIT</button>
                                    </div>
                                </div>
                                <div class="content swiper-slide">
                                    <img class="slider-img" src="../../admin/uploadannounce/<?= htmlspecialchars($content['slider_image_2']) ?>" alt="Slider Image 2">
                                    <div class="text-content">
                                        <h3 class="poetsen-one-regular text-success"><?= htmlspecialchars($content['slider_title_2']) ?></h3>
                                        <p class="mx-2"><?= htmlspecialchars($content['slider_content_2']) ?></p>
                                        <button class="btn btn-visit px-4 text-light shadow">VISIT</button>
                                    </div>
                                </div>
                                <div class="content swiper-slide">
                                    <img class="slider-img border" src="../../admin/uploadannounce/<?= htmlspecialchars($content['slider_image_3']) ?>" alt="Slider Image 3">
                                    <div class="text-content">
                                        <h3 class="poetsen-one-regular text-success"><?= htmlspecialchars($content['slider_title_3']) ?></h3>
                                        <p class="mx-2"><?= htmlspecialchars($content['slider_content_3']) ?></p>
                                        <button class="btn btn-visit px-4 text-light shadow">VISIT</button>
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
                            <h2 class="text-success fw-bold">DISCOVER</h2>
                            <h4 class="text-dark">Our Tourist Destinations</h4>
                            <p class="text-secondary">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nulla accusantium error voluptas recusandae assumenda sit, modi est amet unde fugiat?</p>
                            <a href="../Resort/page-0.php" class="btn text-light btn-success shadow text-center">View More</a>
                        </div>
                    </div>
                    <div class="col-lg-9 col-11 discover-content py-5 d-flex justify-content-center align-items-center" height="500px">
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-5 col-md-6 col-12">
                                <img src="../img/general-img/majayjay-church.jpg" class="img-fluid object-fit-cover rounded shadow" alt="">
                            </div>
                            <div class="col-md-6 col-12 my-3 text-dark text-center d-flex flex-column justify-content-center align-items-center">
                                <h1 class="fw-bold">Delux Resorts</h1>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus error autem laboriosam? Nesciunt rem veniam, maxime amet, repellat incidunt libero nobis exercitationem neque dolores alias itaque laboriosam accusamus est fuga praesentium quisquam totam repellendus! Distinctio modi architecto temporibus! Officia facere repudiandae atque repellat ut quidem numquam doloribus consectetur qui voluptates.</p>
                                <a href="../Resort/page-0.php?tab=resort" class="btn text-light btn-success shadow">View More</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9 col-11 discover-content py-5 d-flex justify-content-center align-items-center">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-6 col-12 my-3 text-dark text-center d-flex flex-column justify-content-center align-items-center">
                                <h1 class="fw-bold">Beautiful Farms</h1>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus error autem laboriosam? Nesciunt rem veniam, maxime amet, repellat incidunt libero nobis exercitationem neque dolores alias itaque laboriosam accusamus est fuga praesentium quisquam totam repellendus! Distinctio modi architecto temporibus! Officia facere repudiandae atque repellat ut quidem numquam doloribus consectetur qui voluptates.</p>
                                <a href="../Resort/page-0.php?tab=farms" class="btn text-light btn-success shadow">View More</a>
                            </div>

                            <div class="col-lg-5 col-md-6 col-12 pb-5">
                                <img src="../img/general-img/bg.png" class="img-fluid object-fit-cover rounded shadow" alt="">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-9 col-11 discover-content py-5 d-flex justify-content-center align-items-center" height="500px">
                        <div class="row d-flex justify-content-center">
                            <div class="col-lg-5 col-md-6 col-12">
                                <img src="../img/general-img/majayjay-church.jpg" class="img-fluid object-fit-cover rounded shadow" alt="">
                            </div>
                            <div class="col-md-6 col-12  my-3 text-dark text-center py-3 d-flex flex-column justify-content-center align-items-center">
                                <h1 class="fw-bold">Majayjay Waterfalls</h1>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Doloribus error autem laboriosam? Nesciunt rem veniam, maxime amet, repellat incidunt libero nobis exercitationem neque dolores alias itaque laboriosam accusamus est fuga praesentium quisquam totam repellendus! Distinctio modi architecto temporibus! Officia facere repudiandae atque repellat ut quidem numquam doloribus consectetur qui voluptates.</p>
                                <a href="../Resort/page-0.php" class="btn text-light btn-success shadow">View More</a>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

        <section id="about" class="about-container">
            <div class="container-fluid py-5 bg-secondary-subtle">
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-4 col-md-5 col-12 mb-5 mb-lg-0" style="min-height: 500px;">
                        <div class=" h-100 text-center">
                            <img class="w-100 h-100 shadow" src="../img/general-img/majayjay-church.jpg" style="object-fit: cover;">
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-6 col-11 d-flex align-items-center">
                        <div class="row">
                            <div class="col-12">
                                <h5 class="text-success fw-bold text-start">ABOUT US</h5>
                            </div>
                            <div class="col-12">
                                <p class="about-content text-dark">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente,
                                    aperiam sed sint quisquam culpa ut nostrum rem iusto doloribus fuga voluptate, debitis quod placeat earum neque officia
                                    eaque rerum eos iure? Reiciendis suscipit harum voluptas vel totam aperiam illo deleniti ipsa nihil unde sequi, illum velit
                                    voluptatem quod est incidunt? Dolores neque facere odit deleniti veniam error esse, porro at ea minima, minus aliquam expedita
                                    dicta veritatis maxime quasi nihil sed tempora ipsum harum incidunt optio, quos sapiente. Maiores itaque, est tenetur praesentium
                                    nisi sequi tempore quisquam earum architecto nobis modi officiis provident ipsam mollitia blanditiis laboriosam consectetur similique accusantium!</p>
                            </div>
                            <div class="col-12 text-center ">
                                <a href="#contact" class="btn btn-success text-light shadow">Get in Touch</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="service" class="service-container py-4">
            <div class="container-fluid">
                <h5 class="text-center text-success fw-bold">OUR SERVICES</h5>
                <div class="service-cards">
                    <div class="row d-flex justify-content-center">
                        <div class="col-lg-3 d-flex justify-content-center">
                            <a href="../businessowner/business-registration.php" class="text-decoration-none">
                                <div class="card mb-3 rounded-0 shadow" style="width: 18rem;">
                                    <img src="../img/general-img/majayjay-church.jpg" class="card-img-top rounded-0 " alt="...">
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
                                    <img src="../img/general-img/majayjay-church.jpg" class="card-img-top rounded-0 " alt="...">
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
        </section>

        <section id="contact" class="contact-container">
            <div class="container-fluid p-5 bg-success-subtle">
                <div class="row justify-content-evenly">
                    <div class="col-lg-4 col-sm-12 gx-5 mb-4">
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
                            <button class="btn btn-success text-light shadow">Submit</button>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-12 bg-light">
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