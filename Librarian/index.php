<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librarian Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        body, html {
            background-color: #E7E5D9;
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: start;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        .container {
            display: flex;
            width: 100%;
            overflow: hidden;
        }

        .main-content {
            flex-grow: 1;
            overflow-y: auto; 
            height: 100vh;
        }

    </style>

</head>
<body>
    <div class="container">  
        <?php include 'sidebar.php'; ?>
        <div class="main-content">
            <?php include 'header.php'; ?>
            <?php
            // Set $page based on the URL parameter or default to 'home'
            $page = $_GET['page'] ?? 'home';

            // Include different views based on $page
            switch ($page) {
                case 'viewBooks':
                    // Check for subPage parameter
                    $subPage = $_GET['subPage'] ?? 'allBooks'; // Default to allBooks if not specified
                    include "viewBooks.php"; // Include the viewBooks.php file
                    break;
                case 'viewUsers':
                    include 'viewUsers.php'; // You can include other views similarly
                    break;
                default:
                    echo '<div class="alert alert-info">Select a page to view.</div>';
                    break;
            }
            ?>
        </div>
    </div>
</body>
</html>
