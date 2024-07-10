<?php
    include "../database.php";
    include "../functions.php";

    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
    $query = "SELECT * FROM users WHERE user_id = '$user_id'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }
    $user = mysqli_fetch_assoc($result);

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="Assets/Style/bookDetails.css" class="css">
    <link rel="stylesheet" href="Assets/Style/sidebar.css" class="css">
    <link rel="stylesheet" href="Assets/Style/modal.css" class="css">
</head>
<body>
<div class="container">
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <h1><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></h1>
        <div class="book-details">
            <div class="book-info">
                <h2>User Information</h2>
                <p><strong>User ID:</strong> <?php echo $user['user_id']; ?></p>
                <p><strong>First Name:</strong> <?php echo $user['first_name']; ?></p>
                <p><strong>Last Name:</strong> <?php echo $user['last_name']; ?></p>
                <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
                <p><strong>Role:</strong> <?php echo $user['role']; ?></p>
                <p><strong>Address:</strong> <?php echo $user['address']; ?></p>
                <p><strong>Contact Number:</strong> <?php echo $user['contact_number']; ?></p>
            </div>
        </div>
    </div>
</div>
    
</body>
</html>