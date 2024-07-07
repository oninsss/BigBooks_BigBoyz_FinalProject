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
    }


    # File Upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $target = "../BookCovers/" . basename($image);
    
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
            echo "File uploaded successfully.";
        } else {
            $image = "../BookCovers/default.jpg";
            echo "Failed to move uploaded file.";
        }
    } else {
        $image = "../BookCovers/default.jpg";
    
        if (isset($_FILES['image']['error'])) {
            switch ($_FILES['image']['error']) {
                case UPLOAD_ERR_INI_SIZE:
                case UPLOAD_ERR_FORM_SIZE:
                    echo "File is too large.";
                    break;
                case UPLOAD_ERR_PARTIAL:
                    echo "File was only partially uploaded.";
                    break;
                case UPLOAD_ERR_NO_FILE:
                    echo "No file was uploaded.";
                    break;
                case UPLOAD_ERR_NO_TMP_DIR:
                    echo "Missing a temporary folder.";
                    break;
                case UPLOAD_ERR_CANT_WRITE:
                    echo "Failed to write file to disk.";
                    break;
                case UPLOAD_ERR_EXTENSION:
                    echo "File upload stopped by extension.";
                    break;
                default:
                    echo "Unknown upload error.";
                    break;
            }
        }
    }
    

    addBook($title, $author, $publishDate, $category, $synopsis, $status, $stock, $image, $added_date);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AddBook</title>
</head>
<body>

<form action="addBook.php" method="POST">
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="_title" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="author">Author</label>
        <input type="text" name="author" id="_author" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="category">Publish Date</label>
        <input type="date" name="publishDate" id="_publishDate" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="category">Category</label>
        <select name="category" id="_category">
            <option value="Fiction">Fiction</option>
            <option value="Non-Fiction">Non-Fiction</option>
            <option value="Reference">Reference</option>
            <option value="Educational">Educational</option>
            <option value="Children">Children</option>
            <option value="Graphic Novel">Graphic Novel</option>
            <option value="Drama">Drama</option>
        </select>
    </div>
    <div class="form-group">
        <label for="synopsis">Synopsis</label>
        <input type="textarea" name="synopsis" id="_synopsis" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="stock">Stock</label>
        <input type="number" name="stock" id="_stock" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="image">Upload Image</label>
        <input type="file" name="image" id="_image">
    </div>
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Add Book</button>
    </div>
</form>

</body>
</html>
