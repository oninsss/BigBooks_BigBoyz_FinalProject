<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../Assets/Style/login-signup.css">
</head>
<body>
    <div class="container">
        <form action="login.php" method="post">
            <h1>Login to Account</h1>

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

    # If user exists, check if password is correct
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['hashed_password'];

        if (password_verify($password, $hashed_password)) {
            $_SESSION['email'] = $email;
            session_start();
            $_SESSION['loggedin'] = true;

            $getUserId = "SELECT user_id FROM user WHERE email = '$email'";
            $result = mysqli_query($conn, $getUserId);
            $row = mysqli_fetch_assoc($result);
            

            $_SESSION['student_id'] = $row['user_id'];
            header('Location: index.php');
            exit();
        } else {
            $message = "Incorrect password";
        }
    } else {
        $message = "User not found";
    }
}
?>