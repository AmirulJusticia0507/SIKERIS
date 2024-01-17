
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">

    <link rel="icon" href="img/logo_white.png" type="image/png">
    <title>Login SIKERIS (Sistem Kerjasama BPRS dengan Notaris)</title>

</head>
<body>
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6 contents">
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <?php if (!empty($loginError)): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= $loginError; ?>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <?php endif; ?>
                                <div class="col-md-6 text-center">
                                    <img src="img/logo_MCI-removebg-preview.png" alt="Image" class="img-fluid mx-auto">
                                </div>
                                <center><h3>Sign In</h3></center>
                                <center><strong><h1>SIKERIS</h1></strong></center>
                            </div>
                            <!-- Formulir login dengan username, password, dan tombol fingerprint -->
                            <form id="loginForm" method="post" action="login_process.php">
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="username" placeholder="Username" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-3">
                                        <button type="submit" class="btn btn-primary btn-block custom-login-button">Login</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- Tambahkan di bagian head HTML -->
    <script>
        const passwordInput = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');

        togglePasswordButton.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            // Toggle ikon mata terbuka/tertutup
            togglePasswordButton.innerHTML = type === 'password' ? '<i class="fa fa-eye" aria-hidden="true"></i>' : '<i class="fa fa-eye-slash" aria-hidden="true"></i>';
        });
    </script>

</body>
</html>
