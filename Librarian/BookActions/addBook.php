<?php 
include "../database.php";
include "../functions.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publishDate = $_POST['publishDate'];
    $category = $_POST['category'];
    $synopsis = $_POST['synopsis'];
    $stock = $_POST['stock'];
    $added_date = date('Y-m-d');

    if ($stock >= 0) {
        if ($stock == 0) {
            $status = "Unavailable";
        } else {
            $status = "Available";
        }
    } else {
        echo "<script>alert('Stock cannot be negative!')</script>";
        exit;
    }

    # File Upload
    if (isset($image)) {
        $image = $_FILES['image']['name'];
        $target = "../BookCovers/".basename($image);
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
    } else {
        $image = "default.jpg";
    }
    
    addBook($title, $author, $publishDate, $category, $synopsis, $status, $stock, $image, $added_date);
}
?>