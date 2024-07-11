<?php
include "../../database.php";
include "../../functions.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = mysqli_real_escape_string($conn, $_POST['book_id']);
    if (deleteBook($book_id)) {
        header("Location: http://localhost/Projects/BigBooks_BigBoyz_FinalProject/Librarian/index.php?page=viewBooks&subPage=allBooks&message=Book deleted successfully.");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
