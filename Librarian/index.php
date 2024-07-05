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
            $page = $_GET['page'] ?? 'home';

            switch ($page) {
                case 'viewBooks':
                    $subPage = $_GET['subPage'] ?? 'allBooks'; 
                    include "viewBooks.php"; 
                    break;
                case 'viewUsers':
                    $subPage = $_GET['subPage'] ?? 'allUsers'; 
                    include 'viewUsers.php';
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
