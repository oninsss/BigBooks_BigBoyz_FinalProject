<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Librarian Dashboard</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="Assets/Style/sidebar.css" class="css">
    <link rel="stylesheet" href="Assets/Style/view.css" class="css">
    <link rel="stylesheet" href="Assets/Style/modal.css" class="css">
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
            overflow-x: hidden;
        }

        .main-content {
            flex-grow: 1;
            overflow-y: auto; 
            height: 100vh;
        }
    </style>
</head>
<body>
    <?php include 'sidebar.php'; ?>
    <div class="main-content">
        <?php
            $page = $_GET['page'] ?? 'viewBooks';

            switch ($page) {
                case 'viewBooks':
                    include 'viewBooks.php'; 
                    break;
                case 'viewUsers':
                    include 'viewUsers.php';
                    break;
                case 'viewRequests':
                    include 'viewRequests.php';
                    break;
                case 'viewTransactions':
                    include 'viewTransactions.php';
                    break;
                default:
                    echo '<div class="alert alert-info">Select a page to view.</div>';
                    break;
            }
        ?>
    </div>

    <script src="Assets/Script/sidebar.js"></script>
</body>
</html>
