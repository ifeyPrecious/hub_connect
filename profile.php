<?php
session_start();

$conn = mysqli_connect('localhost','root', '', 'hub_connect')
        or die('cant connect to database');
 
?>

<?php   
$username = $_SESSION['user_name'];
$email = $_SESSION['user_email'];

if (!isset($_SESSION['logged_in'])) {
    header('location: login.php');
    exit;
}

// Logout
if (isset($_GET['logout'])) {
    if (isset($_SESSION['logged_in'])) {
        unset($_SESSION['logged_in']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        header('location: login.php');
        exit;
    }  

}

// CHANGE PASSWORD============================
if (isset($_POST['change_password'])) {
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];
    $email = $_SESSION['user_email'];

    if ($password !== $confirmPassword) {
        header('location: profile.php?error=Passwords do not match');
        exit;
    } elseif (strlen($password) < 6) {
        header('location: profile.php?error=Password must be at least 6 characters');
        exit;
    } else {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param('ss', $hashedPassword, $email);

        if ($stmt->execute()) {
            header('location: profile.php?message=Password has been updated successfully');
            exit;
        } else {
            header('location: profile.php?error=Could not update the password');
            exit;
        }
    }
}
    

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

</head>

<body>

    <div class="container">
        <h2 class="text-center">MY PROFILE</h2>
        <div class="row my-5 mt-5">
            <div class="col">
            <div class="account-info">
                <h4>Username:<?php echo $username ?></h4>
                <h4>Email:<?php echo $email ?></h4>
                <p><a href="profile.php?logout=1" id="logout-btn" class="btn btn-danger mt-4">Logout</a></p>
            </div>
            </div>
            <div class="col">
            <div class="password w-50">
                <form id="change-profile" method="POST" action="">
                <p class="text-center" style="color: green;"><?php if (isset($_GET['message'])) {
                                                                        echo $_GET['message'];
                                                                    }  ?></p>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="text" name="password" class="form-control" id="exampleInputPassword1" placeholder="change password">
                        <span class="text-center text-danger"><?php if (isset($_GET['error'])) {
                                                            echo $_GET['error'];
                                                        }   ?></span>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Confirm password</label>
                        <input type="text" name="confirmPassword" class="form-control" id="exampleInputPassword1" placeholder="confirm changed-password">
                    </div>
                    <button type="submit" class="btn btn-primary" name="change_password">change password</button>
                </form>
            </div>
            </div>
           
        
        </div>
    </div>
</body>

</html>