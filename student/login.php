<?php
session_start();

$message = ""; // Initialize $message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require '../database.php'; // Adjust this path based on your file structure

    # Get email and password from form
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    # Validate email and password
    if (empty($email) || empty($password)) {
        $message = "Please enter both email and password.";
    } else {
        # Check if user exists
        $userAcc = "SELECT * FROM user_account WHERE email = '$email'";
        $result = mysqli_query($conn, $userAcc);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $hashed_password = $row['hashed_password'];

            # Verify password
            if (password_verify($password, $hashed_password)) {
                $_SESSION['email'] = $email;
                $_SESSION['loggedin'] = true;

                # Retrieve user_id
                $getUserId = "SELECT user_id FROM user WHERE email = '$email'";
                $result = mysqli_query($conn, $getUserId);
                $row = mysqli_fetch_assoc($result);

                $_SESSION['user_id'] = $row['user_id']; // Use 'user_id' consistently
                header('Location: index.php?page=welcomePage');
                exit();
            } else {
                $message = "Incorrect password";
            }
        } else {
            $message = "User not found";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Login</title>
    <link rel="stylesheet" href="../Assets/Style/login-signup.css">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <form action="login.php" method="post">
            <h1>Login to Account</h1>

            <!-- Display error message -->
            <div class="alert alert-danger d-flex align-items-center" role="alert">
                <div>
                <p><?php echo $message; ?></p>
                </div>
                
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
