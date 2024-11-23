<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
?>
<!-- Admin dashboard content goes here -->

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/admin.css">

    <style>

    </style>
</head>

<body>
    <div class="wrapper">

        <!-- aside nav -->
        <?php include '../admin/includes/aside.php'; ?>

        <div class="main">

            <!-- navbar -->
            <?php include '../admin/includes/navbar.php'; ?>

            <main class="content px-3 py-2">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h3>Dashboard</h3>
                    </div>
                    <div class="row">
                        <h5>Tourist Reservation</h5>
                        <div class="col-12 col-md-4 d-flex">
                            <div class="card flex-fill border-0 new shadow">
                                <div class="card-body text-center">
                                    <h5>New</h5>
                                    <h4> 2</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 d-flex">
                            <div class="card flex-fill border-0 ongoing shadow">
                                <div class="card-body text-center">
                                    <h5>Ongoing</h5>
                                    <h4> 6</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4 d-flex s">
                            <div class="card flex-fill border-0 available shadow">
                                <div class="card-body text-center">
                                    <h5> Available Rooms</h5>
                                    <h4>5</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <!-- Table Element -->
                    <div class="card border-0 shadow">
                        <div class="card-header">
                            <h5 class="card-title">
                                Tourism Visitor Record
                            </h5>
                            <h6 class="card-subtitle text-muted">
                                Current month: October
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="3" class=" border-2 border-dark">Day</th>
                                            <th rowspan="3" class=" border-2 border-dark">Week Day <br>(Mon-Sun) </th>
                                            <th colspan="9" class="bg-success border-2 border-dark" style="text-align: center;">Philippines</th>
                                            <th colspan="3" class="bg-info  border-2 border-dark" style="text-align: center;">Foreign Country Residence</th>
                                            <th rowspan="3" class="bg-warning-subtle border-2 border-dark" style="text-align: center;">Grand Total<br>Number of Visitors</th>
                                        </tr>
                                        <tr>
                                            <th colspan="3" class="bg-success-subtle border border-bottom border-dark border-1" style="text-align: center;">This City/Municipality</th>
                                            <th colspan="3" class="bg-success-subtle  border-2 border-dark" style="text-align: center;">Other City/Municipality</th>
                                            <th colspan="3" class="bg-success-subtle  border-2 border-dark" style="text-align: center;">Other Province</th>
                                            <th colspan="3" class="bg-info-subtle  border-2 border-dark" style="text-align: center;">Foreign Country</th>
                                        </tr>
                                        <tr>
                                            <th class="bg-primary-subtle  border-2 border-dark">Male</th>
                                            <th class="bg-danger-subtle  border-2 border-dark">Female</th>
                                            <th class="bg-warning-subtle border-2 border-dark">Total</th>
                                            <th class="bg-primary-subtle border-2 border-dark">Male</th>
                                            <th class="bg-danger-subtle  border-2 border-dark">Female</th>
                                            <th class="bg-warning-subtle border-2 border-dark">Total</th>
                                            <th class="bg-primary-subtle border-2 border-dark">Male</th>
                                            <th class="bg-danger-subtle  border-2 border-dark">Female</th>
                                            <th class="bg-warning-subtle border-2 border-dark">Total</th>
                                            <th class="bg-primary-subtle border-2 border-dark">Male</th>
                                            <th class="bg-danger-subtle  border-2 border-dark">Female</th>
                                            <th class="bg-warning-subtle border-2 border-dark">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border-2 border-dark">1</td>
                                            <td class="border-2 border-dark">Mon</td>
                                            <td class="border-2 border-dark"></td>
                                            <td class="border-2 border-dark"></td>
                                            <td class="border-2 border-dark"></td>
                                            <td class="border-2 border-dark"></td>
                                            <td class="border-2 border-dark"></td>
                                            <td class="border-2 border-dark"></td>
                                            <td class="border-2 border-dark"></td>
                                            <td class="border-2 border-dark"></td>
                                            <td class="border-2 border-dark"></td>
                                            <td class="border-2 border-dark"></td>
                                            <td class="border-2 border-dark"></td>
                                            <td class="border-2 border-dark"></td>
                                            <td class="border-2 border-dark"></td>
                                        </tr>
                                    </tbody>
                                </table>
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
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0">
                                <a href="#" class="text-muted">
                                    <strong>HaKingz</strong>
                                </a>
                            </p>
                        </div>
                        <div class="col-6 text-end">
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
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/admin.js"></script>
</body>

</html>