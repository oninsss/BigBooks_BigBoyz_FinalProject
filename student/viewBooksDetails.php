<?php
include '../database.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve and sanitize the book ID
$book_id = isset($_GET['book_id']) ? mysqli_real_escape_string($conn, $_GET['book_id']) : '';

if (empty($book_id)) {
    die('ERROR: Book ID not found.');
}

function hasPendingRequest($bookId, $conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM borrow_books_transactions WHERE book_id = ? AND b_status = 'Pending' AND borrowed_by = ?");
    if ($stmt) {
        $stmt->bind_param("ss", $bookId, $_SESSION['student_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return ($row['count'] > 0);
    }
    return false;
}

function bookApproved($bookId, $conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM borrow_books_transactions WHERE book_id = ? AND b_status = 'Approved' AND borrowed_by = ?");
    if ($stmt) {
        $stmt->bind_param("ss", $bookId, $_SESSION['student_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return ($row['count'] > 0);
    }
    return false;
}

function canBorrowBook($bookId, $studentId, $conn) {
    // Count approved transactions for this book and user
    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM borrow_books_transactions WHERE b_status = 'Approved' AND borrowed_by = ?");
    if ($stmt) {
        $stmt->bind_param("s", $studentId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result) {
            $row = $result->fetch_assoc();
            // Allow borrowing if there are less than 2 approved transactions
            return ($row['count'] < 2);
        }
    }
    return false;
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
$db_category = $row['category'];
$db_status = $row['book_status'];
$db_stock = $row['stock'];
$db_synopsis = $row['synopsis'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($db_book_title); ?></title>
    <link rel="stylesheet" href="./Assets/Style/viewBooksDetails.css" />
    <link rel="stylesheet" href="./Assets/Style/modal.css" />
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
                    <div class="buttons">
                        <?php
                            if (hasPendingRequest($db_book_id, $conn)) {
                                echo '<button class="btn btn-secondary" disabled>Pending Request</button>';
                            } else if (bookApproved($db_book_id, $conn)) {
                                echo '<button class="btn btn-secondary" disabled>Book Borrowed</button>';
                            } else if (!canBorrowBook($db_book_id, $_SESSION['student_id'], $conn)) {
                                echo '<button class="btn btn-secondary" disabled>Maximum Borrowed Books Reached</button>';
                            } else {
                                echo '<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#' . 'modal' . $db_book_id . '">Borrow</button>';
                            }
                        ?>
                        <div class="modal fade" id="<?php echo 'modal' . $db_book_id;?>" tabindex="-1" aria-labelledby="<?php echo 'modal' . $db_book_id;?>Label" aria-hidden="true" data-backdrop="false">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="<?php echo 'modal' . $db_book_id;?>Label">Book Borrowing Confirmation</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="bookImage">
                                            <img src="<?php echo $db_book_img;?>" alt="<?php echo $db_book_title;?>">
                                            <h2><?php echo $db_book_title;?></h2>
                                        </div>
                                        <hr>
                                        <p><strong>Author:</strong> <?php echo $db_book_author;?></p>
                                        <p><strong>Published:</strong> <?php echo $db_publish_date;?></p>
                                        <p><strong>Category:</strong> <?php echo $db_category;?></p>
                                        <form method="post" action="borrowTransaction.php">
                                            <input type="hidden" name="book_id" value="<?php echo $db_book_id;?>">
                                            <div class="form-group">
                                                <label for="start_date">Start Date:</label>
                                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="end_date">End Date:</label>
                                                <input type="date" class="form-control" id="end_date" name="end_date" required>
                                            </div>
                                    </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary" id="confirmButton">Confirm</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <script>document.body.appendChild(document.getElementById("<?php echo 'modal' . $db_book_id;?>"));</script>
                    </div>
                    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Your book borrowing request has been successfully submitted. Please proceed to the librarian and present your ID. Thank you!
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>document.body.appendChild(document.getElementById("successModal"))</script>
                </div>
                
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://getbootstrap.com/docs/5.3/assets/js/docs.min.js"></script>
    <script src="./Assets/Script/validation.js"></script>
</body>
</html>

<?php

$stmt->close();
$conn->close();

?>