<?php
include '../database.php';

// Retrieve and sanitize the book ID
$book_id = isset($_GET['book_id']) ? mysqli_real_escape_string($conn, $_GET['book_id']) : '';

if (empty($book_id)) {
    die('ERROR: Book ID not found.');
}

// Prepare the statement
$query = "SELECT * FROM bigbooks.books WHERE book_id = ?";
$stmt = $conn->prepare($query);

// Bind the parameter
$stmt->bind_param("s", $book_id);

// Execute the statement
$stmt->execute();

// Get the result
$results = $stmt->get_result();

if ($results->num_rows == 0) {
    die('ERROR: Book not found.');
}

$row = $results->fetch_assoc();

$db_book_id = $row['book_id'];
$db_book_img = $row['image'];
$db_book_title = $row['title'];
$db_book_author = $row['author'];
$db_publish_date = $row['publish_date'];
$db_status = $row['book_status'];
$db_stock = $row['stock'];
$db_synopsis = $row['synopsis'];

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($db_book_title); ?></title>
    <link rel="stylesheet" href="./Assets/Style/viewBooksDetails.css" />
</head>
<body>
    <div class="bookDetailsCont">
        <div class="contTopPart">

        </div>
        <div class="contBottomPart">
            <div class="bookDetails">
                <div class="left">
                    <img src="<?php echo htmlspecialchars($db_book_img); ?>" alt="Book Image">
                </div>
                <div class="right">
                    <h1><?php echo htmlspecialchars($db_book_title); ?></h1>
                    <p><strong>Author:</strong> <?php echo htmlspecialchars($db_book_author); ?></p>
                    <p><strong>Publish Date:</strong> <?php echo htmlspecialchars($db_publish_date); ?></p>
                    <p><strong>Status:</strong> <?php echo htmlspecialchars($db_status); ?></p>
                    <p><strong>Stock:</strong> <?php echo htmlspecialchars($db_stock); ?></p>
                    <strong><p>Synopsis:</p></strong>
                    <p><?php echo $db_synopsis; ?></p>
                </div>
                
            </div>
        </div>
    </div>
</body>
</html>
