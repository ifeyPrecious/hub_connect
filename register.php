<?php include('header.php'); ?>
<?php

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    if ($password !== $confirmPassword) {
        header('location: register.php?error=passwords do not match');
        exit;
    } elseif (strlen($password) < 6) {
        header('location: register.php?error=passwords must be at least 6 characters');
        exit;
    }

    // Check if email already exists
    $stmt1 = $conn->prepare("SELECT count(*) FROM users WHERE email = ?");
    $stmt1->bind_param('s', $email);
    $stmt1->execute();
    $stmt1->bind_result($num_rows);
    $stmt1->store_result();
    $stmt1->fetch();

    // Check if a user already registered with this email
    if ($num_rows != 0) {
        header('location:register.php?error=user with this email already exists');
        exit;
    }

    // Insert a new user
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $username, $email, $hashedPassword);

    // If the account was created successfully
    if ($stmt->execute()) {
        $user_id = $stmt->insert_id;
        session_start();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['email'] = $email;
        $_SESSION['username'] = $username;
        $_SESSION['logged_in'] = true;

        // Redirect to the desired page after successful registration
        header('Location: index.php?register_success=Registration Successful');
        exit;
    } else {
        header('location: register.php?error=could not create account at the moment');
        exit;
    }
}
?>

 

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">HubConnect</p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <section id="wrapper" class="login-register login-sidebar" style="background-image:url(assets/images/background/login-register.jpg);">
    <h1 class="text-center">WELCOME TO OUR SOCIAL NETWORK</h1>
        <div class="login-box card">
            <div class="card-body">
                <form class="form-horizontal form-material" id="loginform" action="" method="POST"> <p class="text-danger"><?php if (isset($_GET['error'])) {
                                            echo $_GET['error'];
                                        } ?></p>
                </p>
                    <div class="text-center">
                        <a href="javascript:void(0)" class="db"><img src="assets/images/logo-icon.png" alt="Home" /><br/><img src="assets/images/logo-text.png" alt="Home" /></a>
                    </div>
                    <h3 class="box-title m-t-40 m-b-0">Register Now</h3><small>Create your account and connect</small>
                    <div class="form-group m-t-20">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Name" name="username">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="Email" name="email">
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" placeholder="Password" name="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" placeholder="Confirm Password" name="confirm_password">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">I agree to all <a href="javascript:void(0)">Terms</a></label> 
                            </div> 
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit" name="register">Sign Up</button>
                        </div>
                    </div>
                    <div class="form-group m-b-0">
                        <div class="col-sm-12 text-center">
                            <p>Already have an account? <a href="login.php" class="text-info m-l-5"><b>Sign In</b></a></p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="assets/node_modules/popper/popper.min.js"></script>
    <script src="assets/node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
        // ============================================================== 
        // Login and Recover Password 
        // ============================================================== 
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
    </script>
</body>
</html>