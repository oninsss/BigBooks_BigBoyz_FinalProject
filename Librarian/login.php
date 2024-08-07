<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="../Assets/Style/login-signup.css">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <form action="login.php" method="post">
            <h1>Login to Account</h1>

            <!-- Display error message -->
            <?php if (!empty($message)) { ?>
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <div>
                <p><?php echo $message; ?></p>
                </div>
                
            </div>
            <?php } ?>

            <div class="popup">
                <p>
                    <?php 
                        if (!empty($message)) {
                            echo $message;
                        }
                    ?>
                </p>
            </div>

            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <input type="submit" value="Login">
        </form>
        <br>
        <hr>
        <br>
        <p>Don't have an account? <a href="signup.php">Sign up</a></p>
    </div>

</body>
</html>

<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require '../database.php';
    $message = "";

    # Get email and password from form
    $email = $_POST['email'];
    $password = $_POST['password'];

    # Check if user exists
    $userAcc = "SELECT * FROM user_account WHERE email = '$email'";
    $result = mysqli_query($conn, $userAcc);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['hashed_password'];
        $checkUserAcc = "SELECT user_id FROM user WHERE email = '$email' AND user_id LIKE 'LIB%'";
        
        $result = mysqli_query($conn, $checkUserAcc);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $user_id = $row['user_id'];
            # Verify password
            if (password_verify($password, $hashed_password)) {
                $_SESSION['email'] = $email;
                $_SESSION['loggedin'] = true;

                # Retrieve user_id
                $getUserId = "SELECT user_id FROM user WHERE email = '$email'";
                $result = mysqli_query($conn, $getUserId);
                $row = mysqli_fetch_assoc($result);

                $_SESSION['student_id'] = $row['user_id']; // Use 'user_id' consistently
                header('Location: index.php?page=viewBooks');
                exit();
        } else {
            $message = "User not found";
        }

        $hashed_password = $row['hashed_password'];

        
        } else {
            $message = "Incorrect password";
        }
    } else {
        $message = "User not found";
    }
}
?>