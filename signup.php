<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="Assets/Style/login-signup.css">
    
</head>
<body>
    <div class="container">
        <form action="signup.php" method="post">
            <h1>Create Student Account</h1>
            
            <div class="input-group">
                <input type="text" name="firstName" placeholder="First Name" required>
                <input type="text" name="lastName" placeholder="Last Name" required>
            </div>
            <input type="number" name="contactNum" placeholder="Contact Number" required>

            <input type="text" name="address" placeholder="Address">

            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_pass" placeholder="Confirm Password" required>
            
            <input type="submit" value="Signup">
        </form>
    </div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require 'database.php';

    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $contactNum = $_POST['contactNum'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_pass = $_POST['confirm_pass'];

    $checkEmailQuery = "SELECT * FROM user_accounts WHERE email = '$email'";
    $checkResult = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "Email already exists. Please choose a different email.";
    } else {
        if ($password == $confirm_pass) {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);

            $userAcc = "INSERT INTO user_accounts (email, password) 
                        VALUES ('$email', '$hashed_password')";
            $result = mysqli_query($conn, $userAcc);
            
            if ($result) {
                $userInfo = "INSERT INTO users (first_name, last_name, contact_number, address, email) 
                            VALUES ('$firstName', '$lastName', '$contactNum', '$address', '$email')";
                $result = mysqli_query($conn, $userInfo);

                if ($result) {
                    echo "Signup Successful";
                    header('Location: login.php');
                    exit();
                } else {
                    echo "Signup Failed to create user info";
                }
            } else {
                echo "Signup Failed to create user account";
            }
        } else {
            echo "Password does not match";
        }
    }
}
?>
