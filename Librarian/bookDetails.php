<?php
    include "../database.php";
    include "../functions.php";

    $book_id = mysqli_real_escape_string($conn, $_GET['book_id']);
    $query = "SELECT * FROM books WHERE book_id = '$book_id'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
        exit;
    }
    $book = mysqli_fetch_assoc($result);

    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $book['title'] ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="Assets/Style/bookDetails.css" class="css">
    <link rel="stylesheet" href="Assets/Style/sidebar.css" class="css">
    <link rel="stylesheet" href="Assets/Style/modal.css" class="css">
</head>
<body>
<div class="container">
    <?php include 'sidebar.php'; ?>

    <div class="main-content">
        <div class="details">
            <div class="details-header">
                <button class="backBtn">
                    <a href="http://localhost/Projects/BigBooks_BigBoyz_FinalProject/Librarian/index.php?page=viewBooks&subPage=allBooks">
                        <span class="material-symbols-outlined">
                            arrow_back
                        </span>
                        <p>Back</p>
                    </a>
                </button>
                <h1>Book Details</h1>
            </div>
            <div class="details-body">
                <div class="left">
                    <div class="imgBx">
                        <img src="<?php echo $book['image']; ?>" alt="Book Image">
                    </div>
                </div>

                <div class="right">
                    <div class="textBx">
                        <?php
                            echo "<h1>" . $book['title'] . "</h1>";
                            echo "<p>by " . $book['author'] . "</p>";
                        ?>
                        <div class="synopsis-container">
                            <?php echo $book['synopsis']; ?> 
                        </div>

                        <div class="bottom">
                            <div class="textGroup">
                                <label>Publish Date:</label> 
                                <p><?php echo $book['publish_date']; ?></p>
                            </div>
                            <div class="textGroup">    
                                <label>Category:</label> 
                                <p><?php echo $book['category']; ?></p>
                            </div>
                            <div class="textGroup">
                                <label>Status:</label> 
                                <p><?php echo $book['status']; ?></p>
                            </div>
                            <div class="textGroup">
                                <label>Stock:</label> 
                                <p><?php echo $book['stock']; ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="btnGrp">
                        <form method="post" action="BookActions/archiveBook.php" style="display: inline;">
                            <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                            <button type="submit" id="_archiveBtn">Archive</button>
                        </form>

                        <button id="_editBtn">Edit</button>

                        <form method="post" action="BookActions/deleteBook.php" style="display: inline;">
                            <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                            <button type="submit" id="_delBtn">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="edit-modal-bg">
    <div class="edit-modal">
        <div class="modal-header">
            <h1>Edit Book</h1>
            <button class="close-modal">
                <span class="material-symbols-outlined">
                    close
                </span>
            </button>
        </div>

        <form id="_editBook-form" action="BookActions/editBook.php" method="POST">
            <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
            <div class="input-group">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input 
                        type="text" 
                        name="title" 
                        id="_title" 
                        class="form-control" 
                        placeholder="eg. Goosebumps: The Haunted Mask" 
                        value="<?php echo $book['title']; ?>"
                        required>
                </div>
                <div class="form-group">
                    <label for="author">Author</label>
                    <input 
                        type="text" 
                        name="author" 
                        id="_author" 
                        class="form-control" 
                        placeholder="eg. R. L. Stine"
                        value="<?php echo $book['author']; ?>"
                        required>
                </div>
            </div>
            <div class="input-group">
                <div class="form-group">
                    <label for="category">Publish Date</label>
                    <input 
                        type="date" 
                        name="publish_date" 
                        id="_publish_date" 
                        class="form-control"
                        value="<?php echo $book['publish_date']; ?>"
                        required>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="_category">
                        <option value="Fiction" <?php if ($book['category'] == 'Fiction') echo 'selected'; ?>>Fiction</option>
                        <option value="Non-Fiction" <?php if ($book['category'] == 'Non-Fiction') echo 'selected'; ?>>Non-Fiction</option>
                        <option value="Reference" <?php if ($book['category'] == 'Reference') echo 'selected'; ?>>Reference</option>
                        <option value="Educational" <?php if ($book['category'] == 'Educational') echo 'selected'; ?>>Educational</option>
                        <option value="Children" <?php if ($book['category'] == 'Children') echo 'selected'; ?>>Children</option>
                        <option value="Graphic Novel" <?php if ($book['category'] == 'Graphic Novel') echo 'selected'; ?>>Graphic Novel</option>
                        <option value="Drama" <?php if ($book['category'] == 'Drama') echo 'selected'; ?>>Drama</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="synopsis">Synopsis</label>
                <textarea 
                    name="synopsis" 
                    id="_synopsis" 
                    class="form-control" 
                    placeholder="eg. A story about a haunted mask that turns the wearer into a monster."
                    required><?php echo $book['synopsis']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" id="_status">
                    <option value="Available" <?php if ($book['status'] == 'Available') echo 'selected'; ?>>Available</option>
                    <option value="Archived" <?php if ($book['status'] == 'Archived') echo 'selected'; ?>>Archived</option>
                </select>
            </div>
            <div class="input-group">
                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input 
                        type="number" 
                        name="stock" 
                        id="_stock" 
                        class="form-control" 
                        value="<?php echo $book['stock']; ?>"
                        required>
                </div>
                <div class="form-group">
                    <label for="image">Upload Image</label>
                    <input type="file" name="image" id="_image">
                </div>
            </div>
            <button type="submit" id="_editBookBtn">Save Changes</button>
        </form>
    </div>
</div>

<script>
document.getElementById('_editBtn').addEventListener('click', function() {
    document.querySelector('.edit-modal-bg').style.display = 'flex';
});

document.querySelector('.close-modal').addEventListener('click', function() {
    document.querySelector('.edit-modal-bg').style.display = 'none';
});
</script>
</body>
</html>