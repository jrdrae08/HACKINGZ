<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/login.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap');

        .fade-out {
            opacity: 0;
            transition: opacity 1s ease-out;
        }

        .dm-sans-text {
            font-family: "DM Sans", sans-serif;
            font-optical-sizing: auto;
            font-weight: 250;
            font-style: normal;
        }
    </style>
</head>

<body>
    <main>
        <div class="background"></div>
        <form method="POST" action="backends/loginfunction.php">
            <div class="container d-flex justify-content-lg-center align-items-center" style="height: 100vh;">
                <div class="card text-center shadow" style="width: 700px;">
                    <div class="card-body">
                        <div class="row d-flex justify-content-evenly align-items-center">
                            <div class="col-lg-5 col-md-5">
                                <img src="img/general-img/majayjay-logo.webp" class="" alt="" height="175" width="175">
                                <h5 class="dm-sans-text">Majayjay, Laguna</h5>
                            </div>
                            <div class="col-lg-5 col-md-5">
                                <h4 class="my-3">Login into your account</h4>
                                <?php if (isset($_SESSION['message'])) : ?>
                                    <div class="alert alert-<?php echo htmlspecialchars($_SESSION['message_type']); ?> alert-dismissible fade show" role="alert">
                                        <?php echo htmlspecialchars($_SESSION['message']); ?>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    <?php unset($_SESSION['message']);
                                    unset($_SESSION['message_type']); ?>
                                <?php endif; ?>
                                <div class="form-floating mt-4">
                                    <input type="text" class="form-control shadow" name="username" id="floatingEmail" placeholder="name@example.com" autocomplete="off" value="<?php echo isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : ''; ?>" required>
                                    <label for="floatingEmail">Username/Email Address</label>
                                </div>
                                <div class="form-floating my-3">
                                    <input type="password" class="form-control shadow" name="password" id="floatingPassword" placeholder="Password" autocomplete="off" required>
                                    <label for="floatingPassword">Password</label>
                                </div>
                                <div class="d-grid gap-2 my-2">
                                    <button type="submit" class="btn btn-success">Log in</button>
                                    <a href="" class="text-decoration-none text-secondary">forgot password?</a>
                                    <hr>
                                    <a href="../user/user_registration.php" class="btn btn-primary">SIGN UP</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alertBox = document.querySelector('.alert');
            if (alertBox) {
                setTimeout(() => {
                    alertBox.classList.add('fade-out');
                    setTimeout(() => {
                        alertBox.style.display = 'none';
                    }, 1000); // Match the CSS transition duration
                }, 10000); // Wait 10 seconds before starting the fade out
            }
        });
    </script>
</body>

</html>