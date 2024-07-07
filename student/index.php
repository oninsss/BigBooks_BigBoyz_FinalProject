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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
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
            }
            ?>
        </div>
    </div>
</body>
</html>
