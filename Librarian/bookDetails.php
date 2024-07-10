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
                                <p><?php echo $book['book_status']; ?></p>
                            </div>
                            <div class="textGroup">
                                <label>Stock:</label> 
                                <p><?php echo $book['stock']; ?></p>
                            </div>
                        </div>
                    </div>

                    <?php
                    $book_status = $book['book_status'];

                    $archiveBtnText = $book_status === 'archive' ? 'Archived' : 'Archive';
                    $archiveBtnClass = $book_status === 'archive' ? 'archived' : '';
                    ?>

                    <div class="btnGrp">
                        <button id="_archiveBtn">
                            <span class="material-symbols-outlined">
                                archive
                            </span>
                            <?php echo $archiveBtnText; ?>
                        </button>

                        <button id="_editBtn">
                            <span class="material-symbols-outlined">
                                edit
                            </span>
                            Edit
                        </button>

                        <button id="_delBtn">
                            <span class="material-symbols-outlined">
                                delete
                            </span>
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="archive-modal-bg">
    <div class="archive-modal">
        <div class="modal-header">
            <h1>Confirm Archive</h1>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to archive this book?</p>
        </div>
        <div class="modal-footer">
            <form method="post" action="BookActions/archiveBook.php">
                <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                <button type="submit" id="_confirm-archive">Archive</button>
            </form>
            <button class="close-modal">Cancel</button>
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
                    <option value="Available" <?php if ($book['book_status'] == 'Available') echo 'selected'; ?>>Available</option>
                    <option value="Archived" <?php if ($book['book_status'] == 'Archived') echo 'selected'; ?>>Archived</option>
                    <option value="Unavailable" <?php if($book['book_status'] == 'Unavailable') echo 'selected'; ?>>Unavailable</option>
                </select>
            </div>
            <div class="input-group">
                <div class="form-group">
                    <label>Stock:</label>
                    <input 
                        type="number" 
                        min="0"
                        name="stock" 
                        id="stock" 
                        value="<?php echo $book['stock']; ?>" 
                        required>
                </div>
                <div class="form-group">
                    <label for="image">Upload Image</label>
                    <input type="file" name="image" id="_image">
                </div>
            </div>
            <button type="submit" id="_editBookBtn"  class="btn-primary">Save Changes</button>
        </form>
    </div>
</div>

<div class="success-modal-bg">
    <div class="success-modal">
        <div class="success-modal-content">
            <div class="modal-body">
                <p>Book Details edited successfully.</p>
            </div>
            <div class="modal-footer">
                <button class="close-modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="delete-modal-bg" style="display: none;">
    <div class="delete-modal">
        <div class="modal-header">
            <h1>Confirm Deletion</h1>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to delete this book?</p>
        </div>
        <div class="modal-footer">
            <form method="post" action="BookActions/deleteBook.php">
                <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
                <button type="submit" id="_confirm-delete">Delete</button>
            </form>
            <button class="close-modal">Cancel</button>
        </div>
    </div>
</div>

<script>
document.getElementById('_archiveBtn').addEventListener('click', function() {
    document.querySelector('.archive-modal-bg').style.display = 'flex';
});

document.getElementById('_editBtn').addEventListener('click', function() {
    document.querySelector('.edit-modal-bg').style.display = 'flex';
});

document.getElementById('_delBtn').addEventListener('click', function() {
    document.querySelector('.delete-modal-bg').style.display = 'block';
});

document.querySelectorAll('.close-modal').forEach(function(element) {
    element.addEventListener('click', function() {
        document.querySelector('.archive-modal-bg').style.display = 'none';
        document.querySelector('.edit-modal-bg').style.display = 'none';
        document.querySelector('.delete-modal-bg').style.display = 'none';
        document.querySelector('.success-modal-bg').style.display = 'none';
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var today = new Date().toISOString().split('T')[0];
    document.getElementById('_publish_date').setAttribute('max', today);
});

function showSuccessModal() {
    var modal = document.querySelector(".success-modal-bg");
    modal.style.display = "block";
}

document.getElementById('stock').addEventListener('input', function() {
    var stock = document.getElementById('stock').value;
    var status = document.getElementById('status');
    if (stock == 0) {
        status.value = 'Unavailable';
        status.setAttribute('readonly', 'true');
    } else {
        status.removeAttribute('readonly');
    }
});
</script>
</body>
</html>