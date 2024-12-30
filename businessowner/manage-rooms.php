<?php
session_start();
include '../backends/subadmin/fetch_manage_rooms.php';

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
    <title>Sub-admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../css/businessowner.css">
</head>

<body>
    <div class="wrapper">

        <?php include '../businessowner/includes/aside.php'; ?>

        <div class="main">

            <?php include '../businessowner/includes/navbar.php'; ?>

            <main class="content py-2">
                <div class="container-fluid">
                    <div class="mb-3">
                        <h3>Manage Accommodation</h3>
                    </div>
                    <div class="row justify-content-center align-items-center g-2">

                        <div class="col-xl-9 col-12 mb-4 d-flex justify-content-between">
                            <a href="../businessowner/add-rooms.php" class="btn btn-success"><i class="bi bi-plus-circle pe-2"></i>Add Room</a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#archiveroom"><i class="bi bi-archive pe-2"></i></i>Archives</button>
                        </div>

                        <div class="col-xl-9 col-12">
                            <?php if (!empty($rooms)): ?>
                                <?php foreach ($rooms as $room): ?>
                                    <div class="card shadow-lg rounded">
                                        <div class="card-body">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col-xl-7 col-lg-7 col-sm-12">
                                                    <img src="<?php echo htmlspecialchars($room['image1']); ?>" class="img-fluid rounded" alt="room first image" style="object-fit: cover; min-height: 100%; width: 100%;">
                                                </div>
                                                <div class="col-xl-5 col-lg-5 col-sm-12">

                                                    <div class="col-md-12 d-flex justify-content-center">
                                                        <h2 class="text-success cormorant-text"><?php echo htmlspecialchars($room['roomName']); ?></h2>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <p><strong>Price</strong></p>
                                                        <h6 class="">₱ <?php echo htmlspecialchars(number_format($room['roomPrice'], 2)); ?></h6>
                                                    </div>
                                                    <?php foreach ($rooms as $room): ?>
                                                        <div class="col-md-12">
                                                            <p><strong>Time Schedule</strong></p>
                                                            <h6 class=""><?php echo date("g:i A", strtotime($room['timeStart'])); ?> - <?php echo date("g:i A", strtotime($room['timeEnd'])); ?></h6>
                                                        </div>
                                                    <?php endforeach; ?>
                                                    <div class="col-md-12">
                                                        <p><strong>Features</strong></p>
                                                        <div class="row g-2">
                                                            <?php foreach ($room['features'] as $feature): ?>
                                                                <div class="col-4">
                                                                    <p><?php echo htmlspecialchars($feature['FeatureName']); ?></p>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <p><strong>Facilities</strong></p>
                                                        <div class="row g-2">
                                                            <?php foreach ($room['facilities'] as $facility): ?>
                                                                <div class="col-4">
                                                                    <p><?php echo htmlspecialchars($facility['FacilityName']); ?></p>
                                                                </div>
                                                            <?php endforeach; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <p><strong>Guests</strong></p>
                                                        <div class="d-flex justify-content-evenly">
                                                            <p>Max Adult: <?php echo htmlspecialchars($room['adultMax']); ?></p>
                                                            <p>Max Children: <?php echo htmlspecialchars($room['ChildrenMax']); ?></p>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 d-flex justify-content-center">
                                                        <a href="../businessowner/update-rooms.php?roomID=<?php echo htmlspecialchars($room['roomID']); ?>" class="btn btn-warning shadow"><i class="bi bi-pencil-square"></i>Update</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No rooms available.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </main>

            <!-- MODAL -->
            <!-- Archive rooms -->
            <div class="modal fade" id="archiveroom" tabindex="-1" aria-labelledby="archiveroom" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered ">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Room Archives</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Time Archived</th>
                                        <th scope="col">Room name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>11:20PM 01/05/24</td>
                                        <td>Room 7</td>
                                        <td>2,300</td>
                                        <td>
                                            <button class="btn btn-primary me-2"><i class="bi bi-eye"></i></i></button>
                                            <button class="btn btn-success me-2"><i class="bi bi-arrow-counterclockwise"></i></button>
                                            <button class="btn btn-danger me-2"><i class="bi bi-trash3"></i></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>


            <a href="#" class="theme-toggle">
                <i class="fa-regular fa-sun"></i>
                <i class="fa-regular fa-moon"></i>
            </a>
            <footer class="footer">
                <?php include '../businessowner/includes/footer.php'; ?>
            </footer>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
        <script src="../js/businessowner.js"></script>
</body>

<script>
    function uploadImage(inputId, imageId) {
        const input = document.getElementById(inputId);
        const image = document.getElementById(imageId);

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                image.src = e.target.result;
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

</html>