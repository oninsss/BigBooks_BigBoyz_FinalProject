<?php 
include "../database.php";
include "../functions.php";

$addSuccess = false;
$errorMsg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publishDate = $_POST['publishDate'];
    $category = $_POST['category'];
    $synopsis = $_POST['synopsis'];
    $stock = $_POST['stock'];
    $added_date = date('Y-m-d');

    if ($stock >= 0) {
        $status = ($stock == 0) ? "Unavailable" : "Available";
    } else {
        echo "<script>alert('Stock cannot be negative!')</script>";
        exit;
    }

    # File Upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $target = "../BookCovers/" . basename($image);

        # Debugging statement
        echo "Trying to upload image to: $target<br>";

        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            $errorMsg = "Failed to upload image!";
            # Debugging statement
            echo "Error moving uploaded file. Check directory permissions.<br>";
        } else {
            echo "Image uploaded successfully to $target<br>";
        }
    } else {
        $image = "default.jpg";
        if (isset($_FILES['image']['error']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $errorMsg = "Image upload error: " . $_FILES['image']['error'];
            echo $errorMsg . "<br>";
        }
    }

    if (empty($errorMsg) && addBook($title, $author, $publishDate, $category, $synopsis, $status, $stock, $image, $added_date)) {
        $addSuccess = true;
    } else {
        if (empty($errorMsg)) {
            $errorMsg = "Failed to add book to the database!";
        }
    }
}
?>