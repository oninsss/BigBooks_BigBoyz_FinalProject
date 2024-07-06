<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="Assets/Style/login-signup.css">
    <script src="./Assets/Script/validations.js"></script>
    <script>
        var check = function() {
            var passwordValue = document.getElementById('password').value;
            var confirmPasswordValue = document.getElementById('confirm_password').value;

            // Check if both password fields have more than one character entered
            if (passwordValue.length > 1) {
                if (passwordValue == confirmPasswordValue) {
                    document.getElementById('message').style.color = 'green';
                    document.getElementById('message').innerHTML = 'Matching';
                } else {
                    document.getElementById('message').style.color = 'red';
                    document.getElementById('message').innerHTML = 'Not Matching';
                }
            } else {
                // Handle case where password field doesn't have enough characters entered
                document.getElementById('message').style.color = 'gray';
                document.getElementById('message').innerHTML = 'Enter more characters';
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <form name="studentSignUp"   action="signup.php" method="post">
            <h1>Create Student Account</h1>
            
            <div class="input-group">
                <input type="text" name="firstName" placeholder="First Name" required>
                <input type="text" name="lastName" placeholder="Last Name" required>
            </div>
            <input type="number" name="contactNum" placeholder="Contact Number" required>

            <input type="text" name="address" placeholder="Address">

            <input type="email" name="email" placeholder="Email" required>
            <span id='message'></span>
            <input type="password" id="password" name="password" placeholder="Password" onkeyup='check();' required>
            <input type="password" id="confirm_password" name="confirm_pass" placeholder="Confirm Password" onkeyup='check();' required>
            
            <input type="submit" value="Signup">
        </form>
    </div>
</body>
</html>

<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        require '../database.php';

        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $contactNum = $_POST['contactNum'];
        $address = $_POST['address'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_pass = $_POST['confirm_pass'];

        $checkEmailQuery = "SELECT * FROM user_account WHERE email = '$email'";

        $checkResult = mysqli_query($conn, $checkEmailQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            echo "Email already exists. Please choose a different email.";
        } else {
            if ($password == $confirm_pass) {

                $userCountSQL = "SELECT COUNT(*) FROM user WHERE user_id LIKE 'STUD%'";
                $userCountQuery = mysqli_query($conn, $userCountSQL);
                $userCountResult = mysqli_fetch_array($userCountQuery)[0];
                $formattedUserCount = sprintf("%04d", $userCountResult + 1);
                
                $tempUserId = "STUD".$formattedUserCount;
                

                $userInfo = "INSERT INTO user (user_id, firstname, lastname, contact_num, user_address, email) 
                            VALUES ('$tempUserId', '$firstName', '$lastName', '$contactNum', '$address', '$email')";
                $result = mysqli_query($conn, $userInfo);
                
                if ($result) {
                    echo "Account created successfully!";
                } else {
                    echo "Error creating account!";
                }

                // Hash password
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);

                $userAcc = "INSERT INTO user_account (email, hashed_password) 
                            VALUES ('$email', '$hashed_password')";
                $result = mysqli_query($conn, $userAcc);

            } else {
                echo "Passwords do not match!";
            }
        }

        $conn->close();
    }
?>