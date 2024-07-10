<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body, html {
            background-color: #F3F2ED;
            font-family: 'Poppins', sans-serif;
            width: 100%;
            height: 100%;
        }
        .container {
            display: flex;
            padding-left: 0;
            max-width: 2560px;
            justify-content: start;
            width: 100%;
            min-height: 100vh;
        }
        .main-content {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            flex-grow: 1;
            padding: 20px;
            overflow: auto;
            z-index: 1;
        }
    </style>
    <link rel="stylesheet" href="Assets/Style/sidebar.css" class="css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/5.3/js/bootstrap.min.js"></script>
</head>
<body>
    <?php
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (!isset($_SESSION['student_id'])) {
        header('Location: login.php');
    }
    

    ?>

    <div class="container">  
        <?php include 'sidebar.php'; ?>
        <div class="main-content">
            <!-- this is where things will show up when buttons on the sidebar are clicked -->
            <?php
            $page = $_GET['page']??'home';
            if ($page == 'home') {
                include 'home.php';
            } else if ($page == 'viewBooks') {
                include 'viewBooks.php';
            } else if ($page == 'borrowedBooks') {
                include 'borrowedBooks.php';
            } else if ($page == 'profile') {
                include 'profile.php';
            } else if ($page == 'viewPayments') {
                include 'viewPayments.php';
            } else if ($page == 'viewHistory') {
                include 'viewHistory.php';
            } else if ($page == 'viewBooksDetails') {
                include 'viewBooksDetails.php';
            } else if ($page == 'payBalance') {
                include 'payBalance.php';
            } else if ($page == 'borrowTransaction') {
                include 'borrowTransaction.php';
            }
            ?>
        </div>
    </div>
</body>
</html>
