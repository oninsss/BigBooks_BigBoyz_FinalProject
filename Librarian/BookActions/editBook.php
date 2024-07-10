<?php
include "../../database.php";
include "../../functions.php";

$editSuccess = false;
$errorMsg = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = mysqli_real_escape_string($conn, $_POST['book_id']);
    $name = mysqli_real_escape_string($conn, $_POST['title']);
    $author = mysqli_real_escape_string($conn, $_POST['author']);
    $publish_date = mysqli_real_escape_string($conn, $_POST['publish_date']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $added_date = mysqli_real_escape_string($conn, $_POST['date_added']);
    $existing_image = mysqli_real_escape_string($conn, $_POST['existing_image']);
    
    $image = $existing_image;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $target = __DIR__ . "/../../BookCovers/";

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target . $image)) {
            $errorMsg = "Failed to upload image!";
            echo "Error moving uploaded file. Check directory permissions.<br>";
        } 
    } else {
        if (isset($_FILES['image']['error']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $errorMsg = "Image upload error: " . $_FILES['image']['error'];
            echo $errorMsg . "<br>";
        }
    }

    if (empty($errorMsg) && editBook($book_id, $name, $author, $category, $status, $stock, $publish_date, $image)) {
        $editSuccess = true;
        header("Location: http://localhost/Projects/BigBooks_BigBoyz_FinalProject/Librarian/index.php?page=viewBooks&subPage=allBooks&message=Book updated successfully.");
        exit;
    } else {
        if (empty($errorMsg)) {
            $errorMsg = "Failed to update book in the database!";
        }
        echo $errorMsg;
    }
} else {
    echo "Invalid request.";
}
?>
