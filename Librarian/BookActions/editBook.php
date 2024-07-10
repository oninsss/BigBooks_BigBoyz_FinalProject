<?php
include "../../database.php";
include "../../functions.php";

$editSuccess = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = mysqli_real_escape_string($conn, $_POST['book_id']);
    $name = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $publish_date = mysqli_real_escape_string($conn, $_POST['publish_date']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);  
    $added_date = mysqli_real_escape_string($conn, $_POST['date_added']);

    if ($stock == 0) {
        $status = 'Unavailable';
    }

    if (editBook($book_id, $name, $author, $category, $status, $stock, $publish_date, $added_date)) {
        $editSuccess = true;
        header("Location: http://localhost/Projects/BigBooks_BigBoyz_FinalProject/Librarian/index.php?page=viewBooks&subPage=allBooks&message=Book updated successfully.");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
